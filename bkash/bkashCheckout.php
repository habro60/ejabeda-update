<?php
require "../auth/auth.php";
require "../database.php";

if (!isset($_SESSION['agreementID']) || empty($_SESSION['agreementID'])) {
    header('Location: ../plot_owner_report/owner_billpayment.php');
}

require "../source/top.php";
$pid = 1306000;
$role_no = $_SESSION['sa_role_no'];
// auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">


   <div id="loading" style="display:none;  position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(0, 0, 0, 0.5);">
        <div id="" style="  position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 20px;
        color: white;
        text-align: center;">
            <i class="fa fa-spinner fa-spin" style="font-size: 40px;"></i> <br><strong style="font-size: 25px;">Processing. Please Wait...</strong>
        </div>
    </div>

    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Bill Payment</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <!-- <form method="post"> -->

    <?php

    // Print all the session variables
    // foreach ($_SESSION as $key => $value) {
    //     echo $key . ' => ' . $value . '<br>';
    // }
    // var_dump($_SESSION['flat_no']);
    // var_dump($_SESSION['bill_paid_flag']);
    // var_dump($_SESSION['bill_for_month']);
    // var_dump($_SESSION['bill_charge_code']);
    // ?>

   

    <div class="card">
        <div class="card-body d-flex justify-content-center">
            <div class="col-6">
                <table class="table bg-light table-bordered">
                    <tbody>
                        <tr>
                            <th>Voucher No</th>
                            <td><?php echo $_SESSION['batch_no']; ?></td>
                        </tr>
                        <tr>
                            <th>Plot Account</th>
                            <td><?php echo $_SESSION['to_account']; ?></td>
                        </tr>
                        <tr>
                            <th>Transaction Date</th>
                            <td><?php echo $_SESSION['tran_date']; ?></td>
                        </tr>
                        <tr>
                            <th>bKash Account Number:</th>
                            <td><?php echo $_SESSION['customerBkashAccount']; ?></td>
                        </tr>
                        <tr>
                            <th>Amount to pay:</th>
                            <td>৳ <?php echo $_SESSION['craccount']; ?></td>
                        </tr>


                    </tbody>
                </table>
                <div class="text-center" style="margin-right:20px">

                    <button onclick="BkashRefreshToken() " class="btn btn-success"> Proceed Payment </button>
                </div>
            </div>
        </div>



    </div>


    </div>
    </div>
    <!-- </form> -->
    <!-- form end  -->
    <?php
    if (!empty($message)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    } else if (!empty($messagecr)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Update Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    } else if (!empty($messages)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    } else if (!empty($messagescr)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Update Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    } else {
    }
    ?>
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java script plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>

<script>
    function BkashRefreshToken() {
        $('#loading').show();

        // get token
        $.ajax({
            url: '../bkash/api-handle.php?action=refreshToken',
            type: 'POST',
            contentType: 'application/json',
            success: function(data) {
                console.log(data);
                // alert('success');
                // alert(data);
                $('#loading').hide();
                createPayment();

                if (data.hasOwnProperty('statusMessage')) {

                    $('#loading').hide();
                    showErrorMessage(data)

                }
            },
            error: function(err) {
                showErrorMessage(err);
            }
        });
    }



    function createPayment() {
        $('#loading').show();
        console.log('createPaymentstart');
        $.ajax({

            url: '../bkash/api-handle.php?action=createPayment',
            type: 'POST',
            contentType: 'application/json',

            success: function(data) {
                $('#loading').hide();
                console.log("bbb1");
                console.log(data);

                data = JSON.parse(data);
                if (data.statusMessage == 'Successful') {
                    console.log("bbb52");

                    window.location.replace(data.bkashURL);
                }
            },
            error: function(err) {
                $('#loading').hide();
                showErrorMessage(err.responseJSON);
                // bKash.create().onError();
            }
        });
    }


    function showErrorMessage(response) {
        let message = 'Unknown Error';

        if (response.hasOwnProperty('errorMessage')) {
            let errorCode = parseInt(response.errorCode);
            let bkashErrorCode = [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014,
                2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030,
                2031, 2032, 2033, 2034, 2035, 2036, 2037, 2038, 2039, 2040, 2041, 2042, 2043, 2044, 2045, 2046,
                2047, 2048, 2049, 2050, 2051, 2052, 2053, 2054, 2055, 2056, 2057, 2058, 2059, 2060, 2061, 2062,
                2063, 2064, 2065, 2066, 2067, 2068, 2069, 503,
            ];
            if (bkashErrorCode.includes(errorCode)) {
                message = response.errorMessage
            }
        }
        Swal.fire("Payment Failed!", message, "error");
    }
</script>



<?php
$conn->close();
?>
</body>

</html>