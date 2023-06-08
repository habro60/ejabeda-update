<?php
require "../auth/auth.php";
require "../database.php";

include "../bkash/forgetPrevPaymentSessions.php";

require "../source/top.php";
$pid = 1306000;
$role_no = $_SESSION['sa_role_no'];
// auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">

    <?php
    if (isset($_SESSION['paymentStatus']) && $_SESSION['paymentStatus'] == 'Payment Failed') {
        include '../bkash/_paymentFailedModal.php';
    }

    if (isset($_SESSION['paymentStatus']) && $_SESSION['paymentStatus'] == 'Payment Successful') {
        include '../bkash/_paymentSucessModal.php';
    }
    ?>


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
            <h1><i class="fa fa-dashboard"></i> Bill Received</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <form method="post">
        <!-- <table>
            <thead>
                <th>Received Type : </th>
                <th> <a href="../apartment/bill_receipt_voucher.php"><button type="button" class="btn btn-dark" disabled>Bill Cash Received</button></a></th>
                <th> <a href="../apartment/bill_receipt_voucher_bank.php"><button type="button" class="btn btn-primary">Bill Cheque Received</button></a></th>
            </thead>
        </table> -->
        <hr>
        <table class="table bg-light table-bordered table-sm">
            <thead>
                <th>Receipt Voucher No</th>
                <th>Transaction Date</th>
                <th>User ID</th>
            </thead>
            <tbody>
                <?php
                $querys = "insert into bach_no (username) values ('$_SESSION[username]')";
                $returns = mysqli_query($conn, $querys);
                $lastRows = $conn->insert_id;
                ?>
                <tr>
                    <td><input type="text" name="batch_no" readonly class="form-control" autofocus placeholder="ID" value="<?php echo $lastRows; ?>"></td>
                    <td><input type="date" name="tran_date" id="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required></td>
                    <td> <?php if (isset($_SESSION['username'])) : ?>
                            <input type="text" name="ss_creator" id="" value="<?php echo $_SESSION['username']; ?>" class="form-control" readonly>
                        <?php endif; ?>
                    </td>
                </tr>
                </body>
        </table>
        <hr>
        <!-- 
            Add To Bill 
         -->
        <table class="table bg-light table-bordered table-sm">
            <h5 style="text-align: center">Bill </h5>
            <!-- <thead>
                <tr>
                    <th>By Account</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead> -->
            <tbody>

                <?php
                $selectQuery = "SELECT * FROM `gl_acc_code` where category_code = 1 and postable_acc= 'Y' AND acc_type=1  ORDER by acc_code";
                $selectQueryResult =  $conn->query($selectQuery);

                $row = $selectQueryResult->fetch_assoc();


                echo '<input type="hidden" name="by_account" id="by_account" class="form-control" value="' . $row['acc_code'] . '" readonly>';
                ?>




                <thead>
                    <tr>
                        <th>To Account</th>

                    </tr>
                </thead>

            <tbody>
                <tr>


                    <?php


                    // Print all the session variables
                    // foreach ($_SESSION as $key => $value) {
                    //     echo $key . ' => ' . $value . '<br>';
                    // }

                    ?>

                    <td style="width: 200px">
                        <?php
                        $link_id = $_SESSION["link_id"];
                        $selectQuery = "SELECT *
                                           FROM gl_acc_code
                                          WHERE acc_code IN (
                                               SELECT gl_acc_code
                                               FROM apart_owner_info
                                               WHERE owner_id = $link_id
                                           )";
                        $selectQueryResult =  $conn->query($selectQuery);
                        if ($selectQueryResult->num_rows) {
                            while ($row = $selectQueryResult->fetch_assoc()) {
                                echo '<input type="text" class="form-control" name="acc_head" value="' .  $row['acc_head'] . '" readonly >';
                                echo '<input type="hidden" name="to_account" id="ToAccount" class="form-control" value="' . $row['acc_code'] . '" readonly>';
                            }
                        }
                        ?>
                    </td>
                    <input type="hidden" class="form-control" name="particular" placeholder='Particulars'>
                    <input type="hidden" class="form-control" name="draccount" placeholder='Dr. Amount' disabled>
                    <input type="hidden" class="form-control" name="craccount" placeholder='Cr. Amount' disabled>
                </tr>
            </tbody>
        </table>
        <hr>
        <!-- =========================== -->
        <div id="result">

        </div>
        <input type="hidden" class="form-control" name="tran_mode" value="CASBR">
        <input type="hidden" class="form-control" name="office_code" value="<?php echo $_SESSION['office_code']; ?>">
        <input type="hidden" class="form-control" name="year_code" value="<?php echo $_SESSION['org_fin_year_st']; ?>">
        <input type="hidden" class="form-control" name="vtdr" value="DR">
        <input type="hidden" class="form-control" name="vtcr" value="CR">
        <input type="hidden" class="form-control" name="ss_org_no" value="<?php echo $_SESSION['org_no']; ?>">


        </div>
        </div>
    </form>

    <div class="text-right" style="margin-right:20px">

        <button id="subBtn" name="subBtn" onclick="getBkashToken(), savePaymentSession()" class="btn btn-success"> Submit </button>
    </div>
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
    // Get the submit button element
    var submitBtn = document.getElementById('subBtn');

    // Disable the submit button initially
    submitBtn.disabled = true;


    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
    $(document).ready(function() {
        $("#1306000").addClass('active');
        $("#1300000").addClass('active');
        $("#1300000").addClass('is-expanded');

    });


    window.addEventListener('load', function() {
        MyfunctionToAcc();
    });

    function MyfunctionToAcc() {
        var toAcc = $('#ToAccount').val();
        // alert(toAcc);
        $.ajax({
            url: 'getOnlinePaymentReceipt.php',
            method: 'POST',
            dataType: 'text',
            data: {
                to_account: toAcc
            },
            success: function(response) {
                $('#result').html(response);
                const postButtons = document.querySelectorAll('.returnPostBtn');
                postButtons.forEach(button => button.click());
            }
        });
    }




    function returnPost(name, amount, no) {
        // alert(name + '\n' + amount);
        var total_balance = $('#total_balance').val();
        var cr_balance = $('#crAccount').val();
        total_amount = parseInt(cr_balance) + parseInt(amount);
        $('.total').val(total_amount);
        $('#bill_paid_flag' + no + '').attr("disabled", true);
        $('#bill_paid_flag_skip' + no + '').attr("disabled", false);
        $('#bill_charge_name' + no + '').css({
            "color": "green",
            "border": "2px solid green"
        });
        $('#bill_amount' + no + '').css({
            "color": "green",
            "border": "2px solid green"
        });
        $('#flag' + no + '').val('1');

        // Enable/disable the submit button based on the value of the crAccount field
        const crAccountValue = parseFloat(document.getElementById('crAccount').value);

        const submitBtn = document.getElementById('subBtn');
        if (crAccountValue > 0) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }




        return false;
    }

    function returnSkip(name, amount, no) {
        //    alert(name+'\n'+amount);
        var total_balance = $('#total_balance').val();
        var cr_balance = $('#crAccount').val();
        total_amount = parseInt(cr_balance) - parseInt(amount);
        $('.total').val(total_amount);
        $('#bill_paid_flag' + no + '').attr("disabled", false);
        $('#bill_paid_flag_skip' + no + '').attr("disabled", true);
        $('#bill_charge_name' + no + '').css({
            "color": "black",
            "border": "2px solid white"
        });
        $('#bill_amount' + no + '').css({
            "color": "black",
            "border": "2px solid white"
        });
        $('#flag' + no + '').val('0');

        // Enable/disable the submit button based on the value of the crAccount field
        const crAccountValue = parseFloat(document.getElementById('crAccount').value);

        const submitBtn = document.getElementById('subBtn');
        if (crAccountValue > 0) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }





        return false;
    }
    // $(this).click(function() {
    //     var target = (event.target.name); // Get the id of the title on which we clicked. We will extract the number from this and use it to create a new id for the section we want to open.
    //     alert(target); 
    // });
</script>
<script>
    function savePaymentSession() {
        $.ajax({
            url: '../bkash/api-handle.php?action=savePaymentSession',
            type: 'post',
            data: $('form').serialize(),
            success: function(data) {
                console.log(data);
            }
        });
    }


    function getBkashToken() {

        $('#loading').show();
        // get token
        $.ajax({
            url: '../bkash/api-handle.php?action=getToken',
            type: 'POST',
            contentType: 'application/json',
            success: function(data) {
                $('#loading').hide();
                // alert('success');
                // alert(data);

                createAgreement();

                if (data.hasOwnProperty('statusMessage')) {


                    showErrorMessage(data)

                }
            },
            error: function(err) {
                $('#loading').hide();
                showErrorMessage(err);
            }
        });
    }


    function createAgreement() {

        console.log('createagreementstart');
        $('#loading').show();
        $.ajax({
            url: '../bkash/api-handle.php?action=createAgreement',
            type: 'POST',
            contentType: 'application/json',

            success: function(data) {
                $('#loading').hide();
                // hideLoading();
                console.log("aaa1");
                console.log(data);

                data = JSON.parse(data);
                if (data.statusMessage == 'Successful') {
                    console.log("aaa52");

                    window.location.replace(data.bkashURL);
                }
            },
            error: function(err) {
                $('#loading').hide();
                // hideLoading();
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
if (isset($_SESSION['paymentStatus']) && $_SESSION['paymentStatus'] == 'Payment Failed') {
    echo "<script>
            console.log('failed');
            $(document).ready(function() {
                $('#payment-failed-modal').modal('show');
            });
        </script>";
}

if (isset($_SESSION['paymentStatus']) && $_SESSION['paymentStatus'] == 'Payment Successful') {
    echo "<script>
            console.log('success');
            $(document).ready(function() {
                $('#payment-success-modal').modal('show');
            });
        </script>";
}

unset($_SESSION['paymentStatus']);
unset($_SESSION['paymentStatusMessage']);
?>


<?php
$conn->close();
?>
</body>

</html>