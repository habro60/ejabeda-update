<?php



require "../auth/auth.php";
require "../database.php";

class BkashHelper
{

    // FOR SANDBOX (just uncomment the below sandbox credentials, and comment out the live credentials)
   // public $base_url = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/';
   // public $app_key = '4f6o0cjiki2rfm34kfdadl1eqq'; // bKash Merchant API APP KEY
   //public $app_secret = '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b'; // bKash Merchant API APP SECRET
   // public $username = 'sandboxTokenizedUser02'; // bKash Merchant API USERNAME
   // public $password = 'sandboxTokenizedUser02@12345'; // bKash Merchant API PASSWORD





    //  FOR LIVE PRODUCTION (just uncomment the below live credentials, and comment the sandbox credentials)

     public $base_url = 'https://tokenized.pay.bka.sh/v1.2.0-beta/';
     public $app_key = 'zVWJdh5COrgwoRD3mulkqRPBtc'; // bKash Merchant API APP KEY
     public $app_secret = 'Yw63pSpYHXGZz1nxAzy6mdO0DD9xcMulMSgN08RyCpQc8Ro9Waxd'; // bKash Merchant API APP SECRET
     public $username = '01953311713'; // bKash Merchant API USERNAME
     public $password = 'Ci+R.?W2Ik8'; // bKash Merchant API PASSWORD



    public function getToken()
    {
        $_SESSION['bkash_token'] = null;

        $post_token = array(
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret
        );

        $url = curl_init("$this->base_url/tokenized/checkout/token/grant");
        $post_token = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            "password:$this->password",
            "username:$this->username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $result_data = curl_exec($url);
        curl_close($url);

        $response = json_decode($result_data, true);



        $_SESSION['bkash_token'] = $response['id_token'];
        $_SESSION['bkash_refreshtoken'] = $response['refresh_token'];

        return json_encode($response);
    }



    public function createAgreement()
    {
        $token = $_SESSION['bkash_token'];


        $mode = '0000';
        $payerReference = ' ';
        $callbackURL = 'https://ejabeda.habrohosting.com/bkash/api-handle.php?action=agreementCallback';

        $createagreementbody = array(
            'payerReference' => $payerReference,
            'callbackURL' => $callbackURL,
            'mode' => $mode,

        );

        $url = curl_init("$this->base_url/tokenized/checkout/create");
        $createagreementbodyx = json_encode($createagreementbody);
        $header = array(
            'Content-Type:application/json',
            "authorization: $token",
            "x-app-key: $this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $createagreementbodyx);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        $resultdata = curl_exec($url);
        curl_close($url);

        // $response = json_decode($resultdata, true);
        // return json_decode($resultdata, true);
        // var_dump($resultdata);

        return $resultdata;
    }


    function agreementCallback()
    {
        echo 'agreementCallback';
        $status = $_GET['status'];
        $paymentId = $_GET['paymentID'];

        if ($status == 'success' && !empty($paymentId)) {

            return $this->executeAgreement($paymentId);
        } else if ($status == 'failure' && !empty($paymentId)) {
            $_SESSION['paymentStatus'] = 'Payment Failed';
            $_SESSION['paymentStatusMessage'] = " ";
            header("location: ../billPayment/onlinePayment.php");
        } else if ($status == 'cancel' && !empty($paymentId)) {
            $_SESSION['paymentStatus'] = 'Payment Failed';
            $_SESSION['paymentStatusMessage'] = "Cancelled";
            header("location: ../billPayment/onlinePayment.php");
        }
    }




    public function executeAgreement($paymentID)
    {
        $token = $_SESSION['bkash_token'];

        $requestbody = array(
            'paymentID' => $paymentID
        );

        $url = curl_init("$this->base_url/tokenized/checkout/execute");
        $requestbodyJson = json_encode($requestbody);
        $header = array(
            'Content-Type:application/json',
            "authorization: $token",
            "x-app-key: $this->app_key"
        );
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);

        $resultdata = json_decode($resultdata, true);

        if (isset($resultdata['statusCode'])) {
            if ($resultdata['statusCode'] == '0000' && $resultdata['agreementStatus'] == 'Completed') {
                $_SESSION['agreementID'] = $resultdata['agreementID'];
                $_SESSION['paymentID'] = $resultdata['paymentID'];
                $_SESSION['customerBkashAccount'] = $resultdata['customerMsisdn'];


                echo "agreement executedd";
                header("location: bkashCheckout.php");
            }
        } else {
            // return $resultdata;
            $_SESSION['paymentStatus'] = 'Payment Failed';
            header("location: ../billPayment/onlinePayment.php");
        }
    }


    public function refreshToken()
    {

        $_SESSION['bkash_token'] = null;

        $refreshToken = $_SESSION['bkash_refreshtoken'];

        $post_token = array(
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret,
            'refresh_token' => $refreshToken
        );

        $url = curl_init("$this->base_url/tokenized/checkout/token/grant");
        $post_token = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            'Accept:application/json',
            "password:$this->password",
            "username:$this->username"
        );

        curl_setopt(
            $url,
            CURLOPT_HTTPHEADER,
            $header
        );
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $url,
            CURLOPT_POSTFIELDS,
            $post_token
        );
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);

        $response = json_decode(
            $resultdata,
            true
        );


        if (array_key_exists('message', $response)) {
            return $response;
        }

        $_SESSION['bkash_token'] = $response['id_token'];
        $_SESSION['bkash_refreshtoken'] = $response['refresh_token'];
        return json_encode($response);
    }



    public function createPayment()
    {

        $token = $_SESSION['bkash_token'];

        $agreementID =
            $_SESSION['agreementID'];
        $amount =
            $_SESSION['craccount'];
        $invoiceno = rand();
        $callbackURL = 'https://ejabeda.habrohosting.com/bkash/api-handle.php?action=paymentCallback';

        $requestbody = array(
            'agreementID' => $agreementID,
            'mode' => '0001',
            // 'amount' => $amount,
            'amount' => '1',
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $invoiceno,
            'callbackURL' => $callbackURL
        );


        $url = curl_init("$this->base_url/tokenized/checkout/create");
        $request_data_json = json_encode($requestbody);

        // dd($request_data_json);
        $header = array(
            'Content-Type:application/json',
            "authorization: $token",
            "x-app-key: $this->app_key"
        );

        curl_setopt(
            $url,
            CURLOPT_HTTPHEADER,
            $header
        );
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $url,
            CURLOPT_POSTFIELDS,
            $request_data_json
        );
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);


        // var_dump(json_decode($resultdata, true));
        // sleep(10);


        return $resultdata;
    }

    public function paymentCallback()
    {
        echo 'paymentCallback';

        $status = $_GET['status'];
        $paymentId = $_GET['paymentID'];

        if ($status == 'success' && !empty($paymentId)) {

            return $this->executePayment($paymentId);
        } else if ($status == 'failure' && !empty($paymentId)) {

            $_SESSION['paymentStatus'] = 'Payment Failed';
            $_SESSION['paymentStatusMessage'] = " ";
            header("location: ../billPayment/onlinePayment.php");
        } else if ($status == 'cancel' && !empty($paymentId)) {
            $_SESSION['paymentStatus'] = 'Payment Failed';
            $_SESSION['paymentStatusMessage'] = "Cancelled";
            header("location: ../billPayment/onlinePayment.php");
        }
    }



    public function executePayment($paymentID)
    {

        // dd('execute payment');
        $token = $_SESSION['bkash_token'];

        // $paymentID = $request->paymentID;
        $requestbody = array(
            'paymentID' => $paymentID
        );
        $url = curl_init("$this->base_url/tokenized/checkout/execute");
        $requestbodyJson = json_encode($requestbody);
        $header = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);
        // dd($resultdata);

        $response = json_decode($resultdata, true);



        // var_dump($response);
        // sleep(5);


        return $this->paymentStatus($response);
    }



    public function paymentStatus($bkashresponse)
    {


        $bkashErrorCode = [
            2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014,
            2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030,
            2031, 2032, 2033, 2034, 2035, 2036, 2037, 2038, 2039, 2040, 2041, 2042, 2043, 2044, 2045, 2046,
            2047, 2048, 2049, 2050, 2051, 2052, 2053, 2054, 2055, 2056, 2057, 2058, 2059, 2060, 2061, 2062,
            2063, 2064, 2065, 2066, 2067, 2068, 2069, 503,
        ];

        if (in_array($bkashresponse['statusCode'], $bkashErrorCode)) {
            $_SESSION['paymentStatus'] = 'Payment Failed';
            $_SESSION['paymentStatusMessage'] = $bkashresponse['statusMessage'];
            header("location: ../billPayment/onlinePayment.php");
        }



        if (
            $bkashresponse['statusCode'] == '0000'
        ) {
            if (isset($bkashresponse['transactionStatus']) && $bkashresponse['transactionStatus'] == 'Completed') {


                $this->saveBkashPaymentInfo($bkashresponse);



                return $this->savePayment($bkashresponse);
            }
        }
    }

    public function saveBkashPaymentInfo($bkashresponse)
    {

        global $conn;

        $paymentID = $bkashresponse['paymentID'];
        $agreementID = $bkashresponse['agreementID'];
        $payerReference = $bkashresponse['payerReference'];
        $customerMsisdn = $bkashresponse['customerMsisdn'];
        $trxID = $bkashresponse['trxID'];
        $amount = $bkashresponse['amount'];
        $transactionStatus = $bkashresponse['transactionStatus'];
        $paymentExecuteTime = $bkashresponse['paymentExecuteTime'];
        $currency = $bkashresponse['currency'];
        $intent = $bkashresponse['intent'];
        $merchantInvoiceNumber = $bkashresponse['merchantInvoiceNumber'];


        $insertBkashPaymentInfo = "INSERT INTO `bkash_transinfo` (`id`, `paymentID`, `agreementID`, `payerReference`, `customerMsisdn`, `trxID`, `amount`, `transactionStatus`, `paymentExecuteTime`, `currency`, `intent`, `merchantInvoiceNumber`) VALUES (NULL, '$paymentID','$agreementID', '$payerReference','$customerMsisdn','$trxID', '$amount', '$transactionStatus', '$paymentExecuteTime', '$currency','$intent', '$merchantInvoiceNumber')";


        $conn->query($insertBkashPaymentInfo);
        if ($conn->affected_rows < 1) {
            $_SESSION['paymentStatus'] = 'Payment Failed';
            $_SESSION['paymentStatusMessage'] = 'Internal Database Error 5';
            header("location: ../billPayment/onlinePayment.php");
        }
    }



    public function savePayment($bkashresponse)
    {
        global $conn;

        $office_code = $_SESSION['office_code'];
        $year_code = $_SESSION['year_code'];
        $batch_no = $_SESSION['batch_no'];

        $tran_date = $_SESSION['tran_date'];
        $by_account = $_SESSION['by_account'];
        $to_account = $_SESSION['to_account'];
        $tran_mode = $_SESSION['tran_mode'];
        $vaucher_typedr = $_SESSION['vtdr'];
        $vaucher_typecr = $_SESSION['vtcr'];
        $particular = $_SESSION['particular'];
        $craccount = $_SESSION['craccount'];
        $ss_creator = $_SESSION['ss_creator'];
        $ss_org_no = $_SESSION['ss_org_no'];


        //send confirmation sms
        $ownerMobileSql = "SELECT mobile_no FROM apart_owner_info WHERE gl_acc_code = '$to_account'";
        $result = mysqli_query($conn, $ownerMobileSql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $owner_mobile = $row['mobile_no'];
        } else {
            $owner_mobile = '';
        }
        $this->sendPaymentConfirmationSMS($owner_mobile);






        $insertQuerycr = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `cr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$to_account','$tran_mode','$vaucher_typecr','$particular','$craccount','$ss_creator',now(),'$ss_org_no')";

        $conn->query($insertQuerycr);
        if ($conn->affected_rows < 1) {
            $_SESSION['paymentStatus'] = 'Payment Failed';
            $_SESSION['paymentStatusMessage'] = 'Internal Database Error 1';
            header("location: ../billPayment/onlinePayment.php");
        }

        $insertQuerydr = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `dr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$by_account','$tran_mode','$vaucher_typedr','$particular','$craccount','$ss_creator',now(),'$ss_org_no')";

        $conn->query($insertQuerydr);
        if ($conn->affected_rows < 1) {
            $_SESSION['paymentStatus'] = 'Payment Failed';
            $_SESSION['paymentStatusMessage'] = 'Internal Database Error 2';
            header("location: ../billPayment/onlinePayment.php");
        }


        for ($i = 0; $i < count($_SESSION['bill_paid_flag']); $i++) {



            $bill_paid_flag = $_SESSION['bill_paid_flag'][$i];
            $bill_for_month = $_SESSION['bill_for_month'][$i];
            $bill_charge_code = $_SESSION['bill_charge_code'][$i];
            $flat_no = $_SESSION['flat_no'][$i];


            if ($bill_paid_flag == 1) {
                $updateQuery = "UPDATE `apart_owner_bill_detail` set `bill_paid_date`='$tran_date', `bill_paid_flag`='1', `batch_no`='$batch_no' WHERE `owner_gl_code`='$to_account' AND bill_charge_code='$bill_charge_code' AND flat_no='$flat_no' AND bill_for_month='$bill_for_month'";
                $conn->query($updateQuery);
                if ($conn->affected_rows < 1) {
                    $_SESSION['paymentStatus'] = 'Payment Failed';
                    $_SESSION['paymentStatusMessage'] = 'Internal Database Error 3';
                    header("location: ../billPayment/onlinePayment.php");
                }
            }
        }



        $_SESSION['paymentStatus'] = 'Payment Successful';
        $_SESSION['paymentStatusMessage'] = $bkashresponse['statusMessage'];
        header("location: ../billPayment/onlinePayment.php");
    }


    public function sendPaymentConfirmationSMS($ownerMobile)
    {

        // Set the request URL
        $url = "https://bulk-sms-core.azurewebsites.net/SmsSender/SendMessage";


        $securityId = 'IUFpvjHNpgulCcb60PBXsNigSjMQj1ZkxPz';
        $securityValue = 'g{M2l4fFL9F)E@w-H8X_JgSOAV]z1p)}j_VX5u({K/h9[!WNx6lfV3fyFomkHX1-kC@Q[MfmtY7Q+mZM5]6R04W6$@_90xX_QN3}';

        $messageTo =  $ownerMobile;
        // $messageTo = '01779393932';


        $chargeType = 3;

        $message = "Payment of BDT " . $_SESSION['craccount'] . " successfully received from account " . $_SESSION['acc_head'] . " (" . $_SESSION['ss_creator'] . ") on " . $_SESSION['tran_date'] . "%0a";

        for ($i = 0; $i < count($_SESSION['bill_paid_flag']); $i++) {
            $message .= "For " . $_SESSION['bill_charge_name'][$i] . " of Flat No. " . $_SESSION['flat_no'][$i] . " for the month of " . $_SESSION['bill_for_month'][$i] . "%0a";
        }




        // Set the request body
        $data = array(
            "securityId" => $securityId,
            "securityValue" =>  $securityValue,
            "messageTo" => $messageTo,
            "message" => $message,
            "chargeType" => $chargeType
        );

        // Convert data to JSON format
        $jsonData = json_encode($data);

        // var_dump($jsonData);


        // Initialize curl
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the curl request
        $response = curl_exec($ch);

        // Close curl
        curl_close($ch);


        // var_dump($response);
        // if (curl_error($ch)) {
        //     echo 'Error: ' . curl_error($ch);
        // }
        // die;




        // Handle the response
        if ($response) {
        } else {
        }
    }




    public function savePaymentSession()
    {





        $_SESSION['office_code']  = $_POST['office_code'];
        $_SESSION['year_code']  = $_POST['year_code'];
        $_SESSION['batch_no'] = $_POST['batch_no'];

        $_SESSION['tran_date']  = $_POST['tran_date'];
        $_SESSION['by_account']  = $_POST['by_account'];
        $_SESSION['to_account']  = $_POST['to_account'];
        $_SESSION['tran_mode']  = $_POST['tran_mode'];
        $_SESSION['vtdr']   = $_POST['vtdr'];
        $_SESSION['vtcr']  = $_POST['vtcr'];
        $_SESSION['particular']  = $_POST['particular'];
        $_SESSION['craccount']  = $_POST['craccount'];
        $_SESSION['ss_creator']  = $_POST['ss_creator'];
        $_SESSION['ss_org_no']  = $_POST['ss_org_no'];


        for ($i = 0; $i < count($_POST['bill_paid_flag']); $i++) {

            $_SESSION['bill_paid_flag'][$i] =
                $_POST['bill_paid_flag'][$i];
            $_SESSION['bill_for_month'][$i] = $_POST['bill_for_month'][$i];
            $_SESSION['bill_charge_code'][$i] =
                $_POST['bill_charge_code'][$i];
            $_SESSION['flat_no'][$i] =
                $_POST['flat_no'][$i];
            $_SESSION['bill_charge_name'][$i] =
                $_POST['bill_charge_name'][$i];


            // $_SESSION['bill_fixed_amt'][$i] =
            //     $_POST['bill_fixed_amt'][$i];
            // $_SESSION['bill_amount'][$i] =
            //     $_POST['bill_amount'][$i];

            // $_SESSION['last_paid_date'][$i] =
            //     $_POST['last_paid_date'][$i];


        }


        $_SESSION['acc_head']  = $_POST['acc_head'];


        // $_SESSION['bill_date']  = $_POST['bill_date'];




        return 'Session variables saved';
    }
}
