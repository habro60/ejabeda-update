<?php
require "../auth/auth.php";
require '../database.php';
$output = '';
?>
   
   <?php


    $duebills = "SELECT apart_owner_bill_detail.owner_gl_code, apart_owner_info.mobile_no,apart_owner_info.owner_name, apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.flat_no,apart_owner_bill_detail.bill_for_month, apart_owner_bill_detail.bill_last_pay_date,apart_owner_bill_detail.bill_amount FROM flat_info, apart_owner_info, apart_owner_bill_detail where apart_owner_bill_detail.bill_paid_flag=0 and flat_info.flat_no=apart_owner_bill_detail.flat_no and flat_info.flat_no=apart_owner_info.flat_no";
    $query = mysqli_query($conn, $duebills);


    // Store dues for each flat owner
    $dues = array();

    while ($row = mysqli_fetch_assoc($query)) {
        $flatOwner = $row['owner_name'] . ' (' . $row['flat_no'] . ')';
        $billMonth = date('F Y', strtotime($row['bill_for_month']));
        $billAmount = $row['bill_amount'];
        $payDate = date('F j, Y', strtotime($row['bill_last_pay_date']));

        if (!isset($dues[$flatOwner])) {
            $dues[$flatOwner] = array();
        }


        $dues[$flatOwner][] = "Bill of amount $billAmount for $billMonth is due. Pay before $payDate.";
    }

    // Send reminders to flat owners
    foreach ($dues as $flatOwner => $dueMonths) {
        $message = "Dear $flatOwner,\n\n";
        $message .= implode("\n", $dueMonths);
        $phoneNo = getPhoneNumberForOwner($flatOwner); // Replace with your method to retrieve the phone number
        sendReminderSMS($message, $phoneNo);
    }


    function getPhoneNumberForOwner($flatOwner)
    {
        global $conn;

        // Split the flatOwner string into owner_name and flat_no

        $flatNo = substr($flatOwner, strrpos($flatOwner, '(') + 1, -1);

        // Perform a database query to retrieve the phone number for the given flat owner
        $query = "SELECT mobile_no FROM apart_owner_info WHERE  flat_no = '$flatNo'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['mobile_no'];
        }

        return null; // Return null if no phone number found for the flat owner
    }



    function sendReminderSMS($message, $phoneNo)
    {

        // Set the request URL
        $url = "https://bulk-sms-core.azurewebsites.net/SmsSender/SendMessage";


        $securityId = 'IUFpvjHNpgulCcb60PBXsNigSjMQj1ZkxPz';
        $securityValue = 'g{M2l4fFL9F)E@w-H8X_JgSOAV]z1p)}j_VX5u({K/h9[!WNx6lfV3fyFomkHX1-kC@Q[MfmtY7Q+mZM5]6R04W6$@_90xX_QN3}';

        $messageTo =  $phoneNo;
        // $messageTo = '01779393932';


        $chargeType = 3;


        // Set the request body
        $data = array(
            "securityId" => $securityId,
            "securityValue" =>  $securityValue,
            "messageTo" => $messageTo,
            "message" => $message,
            "chargeType" => $chargeType
        );


        echo var_dump($data);


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
    }

    ?>