<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['subBtn'])) {
    $office_code = $_POST['office_code'];
    $year_code = $_POST['year_code'];
    $batch_no = $_POST['batch_no'];
    $tran_date = $_POST['tran_date'];
    // to account -------
    $toaccount = $_POST['toaccount'];
    // by account 
    $byaccount = $_POST['byaccount'];
    //-------------------
    $tran_mode = $_POST['tran_mode'];
    $vaucher_typedr = $_POST['vtdr'];
    $vaucher_typecr = $_POST['vtcr'];
    //-------------------
    $pay_on_vouch_no = $_POST['pay_on_vouch_no'];
    $purchase_date = $_POST['purchase_date'];
    if (!empty($pay_on_vouch_no)) {
        $bill_paid_flag = '2';
    } else {
        $bill_paid_flag = '0';
    }
    //-------------------
    $particular = $_POST['particular'];
    $draccount = $_POST['draccount'];
    $ss_creator = $_POST['ss_creator'];
    $ss_org_no = $_POST['ss_org_no'];
    // cr
    $insertQuery1 = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `dr_amt_loc`,`pay_on_vouch_no`,`purchase_date`,`bill_paid_flag`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$byaccount','$tran_mode','$vaucher_typedr','$particular','$draccount','$pay_on_vouch_no','$purchase_date','$bill_paid_flag','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuery1);
    // echo $insertQuery; exit;
    if ($conn->affected_rows == 1) {
        $messagecr = "cr Save Successfully";
    }
    // dr
    $insertQuery = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `cr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$toaccount','$tran_mode','$vaucher_typecr','$particular','$draccount','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuery);
    // echo $insertQuery; exit;
    if ($conn->affected_rows == 1) {
        $message = "Save Successfully";

        //Update invoice table ;  
        // $insertInv = "INSERT INTO invoice_detail(id,`office_code`, `order_type`, `in_out_flag`, `order_no`,`gl_acc_code`, `order_date`, `item_no`, `item_qty`, `item_unit`, `unit_price_loc`, `unit_price_fc`, `curr_code`, `exch_rate`, `total_price_loc`, `total_price_fc`, `include`, `bar_code`, `item_origin`, `item_waranty`, `warranty_type`, `agaunest_indent_no`,`bill_status`, `item_status`, `status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no`) SELECT null, `office_code`,'CASP','1', '$batch_no', '$byaccount', '$tran_date', `item_no`, `item_qty`, `item_unit`, `unit_price_loc`, `unit_price_fc`, `curr_code`, `exch_rate`, `total_price_loc`, `total_price_fc`, `include`, `bar_code`, `item_origin`, `item_waranty`, `warranty_type`, `agaunest_indent_no`, 'CASP', '1',`status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no` FROM invoice_detail WHERE  gl_acc_code='$byaccount' and  order_no= '$pay_on_vouch_no' and bill_status='PV'";


        $insertInv = "INSERT INTO invoice_detail(id,`office_code`, `order_type`, `in_out_flag`, `order_no`,`gl_acc_code`, `order_date`,`item_no`,`item_qty`,`item_unit`,`unit_price_loc`,`curr_code`,`total_price_loc`,`include_vat_rate`,`include_vat_amt`,`include_tax_rate`,`include_tax_amt`,`include_sour_tax_rate`,`include_sour_tax_amt`,`include_discount_rate`,`include_discount_amt`, `bill_status`, `item_status`, `status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no`) 

        SELECT null, `office_code`,'CASP','1', '$batch_no', '$byaccount', '$tran_date', `item_no`, `item_qty`, `item_unit`,`unit_price_loc`,`curr_code`,`total_price_loc`,`include_vat_rate`,`include_vat_amt`,`include_tax_rate`,`include_tax_amt`,`include_sour_tax_rate`,`include_sour_tax_amt`,`include_discount_rate`,`include_discount_amt` , 'CASP', '1',`status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no` FROM invoice_detail WHERE  gl_acc_code='$byaccount' and  order_no= '$pay_on_vouch_no' and bill_status='PV'";



        // echo $insertInv;
        // exit;
        $conn->query($insertInv);
        if ($conn->affected_rows == 1) {
            $message = "Save Successfully";
        }
    }
    $updateInv = "UPDATE `invoice_detail` SET `bill_status`='CASP',`item_status`='3',`status_date`=now() WHERE order_no='$pay_on_vouch_no' AND order_type='PV' AND bill_status='PV'";
    $conn->query($updateInv);

    $updateTrans = "UPDATE `tran_details` SET pay_on_vouch_no='$pay_on_vouch_no', bill_paid_flag='$bill_paid_flag' WHERE gl_acc_code= '$byaccount'";
    $conn->query($updateTrans);

    // header('refresh:1;../transation/payment_voucher.php');
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=payment_voucher.php\">";
}
require "../source/top.php";
$pid = 402000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>

<style>

</style>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Cash Payment</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>

    <!-- ---------------- code here---------------->
    <form method="POST">
        <table>
            <thead>
                <th>Received Type : </th>
                <th> <a href="../transation/payment_voucher.php"><button type="button" class="btn btn-dark" disabled>Cash Payment</button></a></th>
                <th> <a href="../transation/payment_voucher_bank.php"><button type="button" class="btn btn-primary">Cheque Payment</button></a></th>
                <th> <a href="../transation/advice_issue.php"><button type="button" class="btn btn-primary">Advice Issue</button></a></th>
            </thead>
        </table>
        <hr>
        <table class="table bg-light table-bordered table-sm">
            <thead>
                <!-- <th>Office Name</th> -->
                <th>Voucher No</th>
                <th>Transaction Date</th>
                <th>User ID</th>
            </thead>
            <tbody>
                <?php
                $querys = "INSERT INTO bach_no (username) values ('$_SESSION[username]')";
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
        <table class="table bg-light table-bordered table-sm">
            <h5 style="text-align: center">Cash Payment</h5>
            <thead>
                <!-- <th>To Account</th> -->
                <th></th>
                <th class="byacc1" hidden></th>
                <th class="byacc2" hidden></th>
                <!-- <th>A/C Balance</th> -->
            </thead>
            <tbody>
                <tr>
                <?php
                        $selectQuery = "SELECT acc_code, acc_head FROM `gl_acc_code`where category_code = 1 and postable_acc= 'Y' AND acc_type=1";
                        $selectQueryReuslt = $conn->query($selectQuery);
                        $row = $selectQueryReuslt->fetch_assoc();
                        
                        ?>
                       <input type="hidden" name="by_account" id="by_account" class="form-control" onchange="calculateToAccount()" value="<?php echo $row['acc_code'] ?>" readonly>
                    </td>
                    <!-- <td style="width: 200px">
                        <select class="form-control select2" name="toaccount" onchange="calculateToAccount()" id="toAccount" required>
                            <option value="">---Select To Account---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' AND acc_type=1 ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['acc_code'] . '">' . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td> -->
                    <td></td>
                    <td class="byacc3" hidden></td>
                    <td class="byacc4" hidden></td>
                    <td style="width: 200px"><input type="text" name="" id="acBalance" class="form-control" required readonly></td>
                <tr id="loaderIcon">
                    <th width="24%" scope="row"></th>
                    <td><span id="name_availability_status"></span></td>
                </tr>

                <tr id="loaderIcon2">
                    <th width="24%" scope="row"></th>
                    <td><span id="minimum_balence"></span></td>
                </tr>
                </tr>
                <tr>
                    <th>Payment A/C</th>
                </tr>
            <tbody>
                <tr>
                    <td style="width: 200px">
                        <select class="form-control select2" name="byaccount" id="byAccount" onchange="calculateByAccount()" required>
                            <option value="">---Payment A/C---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' AND category_code !='3' and acc_type!=1 AND acc_type!=2 ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['acc_code'] . '">'  . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td class="particular"><input type="text" class="form-control" name="particular" id="particular" placeholder="Particular"></td>
                    <td class="pay_on_vouch_no" hidden><select name="pay_on_vouch_no" id="pay_on_vouch_no" class="form-control" onchange="calculateDate()">
                            <option value="0">Select voucher</option>
                        </select></td>
                    <td class="purchase_date" hidden><select name="purchase_date" id="purchase_date" class="form-control">
                            <option value="">Select Date</option>
                        </select></td>
                    <td style="width: 250px"> <input type="text" class="form-control" name="draccount" id="drAccount" placeholder="Dr. Amount"></td>
                </tr>
                <!-- hidden  -->
                <input type="hidden" class="form-control" name="office_code" value="<?php echo $_SESSION['office_code']; ?>">
                <input type="hidden" class="form-control" name="tran_mode" value="CASP">
                <input type="hidden" class="form-control" name="year_code" value="<?php echo $_SESSION['org_fin_year_st']; ?>">
                <input type="hidden" class="form-control" name="vtdr" value="DR">
                <input type="hidden" class="form-control" name="vtcr" value="CR">
                <input type="hidden" class="form-control" name="ss_org_no" value="<?php echo $_SESSION['org_no']; ?>">
            </tbody>
        </table>
        <div class="text-right" style="margin-right:20px">
            <input type="submit" id="submit" value="Submit" name="subBtn" class="btn btn-success">
        </div>
    </form>
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
                "Save CR Successfully!!",
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
<!-- serch option -->
<script src="../js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
    $(document).ready(function() {
        $("#402000").addClass('active');
        $("#400000").addClass('active');
        $("#400000").addClass('is-expanded');
    });
    //   $('#submit').attr('disabled', true);
    /*
     ** To Account function calculateToAccount()
     */
    function calculateToAccount(toAcc) {
        var toAcc = $('#toAccount').val();
        $.ajax({
            url: 'getCheckPayment.php',
            method: 'POST',
            dataType: 'text',
            data: {
                gl_acc: toAcc
            },
            success: function(response) {
                $("#acBalance").val(response);

            }
        });
    }
    /*
     ** calculate by account -- account type !1 and !2 
     ** get pay_on_vouch_no and purchase_date 
     */
    function calculateByAccount(x) {
        var x = $('#byAccount').val();
        $.ajax({
            url: 'getCheckPayment.php',
            method: 'POST',
            dataType: 'text',
            data: {
                acc_code: x
            },
            success: function(response) {
                $("#pay_on_vouch_no").html(response);

                if (response == 0) {
                    $(".pay_on_vouch_no").attr('hidden', true);
                    $(".purchase_date").attr("hidden", true);
                    $(".byacc1").attr('hidden', true);
                    $(".byacc2").attr('hidden', true);
                    $(".byacc3").attr('hidden', true);
                    $(".byacc4").attr('hidden', true);
                } else {

                    $(".pay_on_vouch_no").attr('hidden', false);
                    $(".purchase_date").attr("hidden", false);
                    $(".byacc1").attr('hidden', false);
                    $(".byacc2").attr('hidden', false);
                    $(".byacc3").attr('hidden', false);
                    $(".byacc4").attr('hidden', false);
                }
            }
        });
    }
    /*
     ** calculateDate() 
     */
    function calculateDate() {
        var order_no = $('#pay_on_vouch_no').val();
        $.ajax({
            url: 'getCheckPayment.php',
            method: 'POST',
            dataType: 'text',
            data: {
                order_no: order_no
            },
            success: function(response) {
                $("#purchase_date").html(response);
            }
        });
        // =========================================
        var x = $('#pay_on_vouch_no').val();
        $.ajax({
            url: 'getCheckPayment.php',
            method: 'POST',
            dataType: 'text',
            data: {
                order_no_cal: x
            },
            success: function(response) {
                $("#paid").html(response);
                $("#drAccount").val(response);
                $("#submit").attr("disabled", false);
                $("#drAccount").attr("disabled", false);
                if (response == 0) {
                    $("#submit").attr("disabled", true);
                    $("#drAccount").attr("disabled", true);
                    $("#paid").text('Not Transction');
                }
            }
        });
    }
    //     $("#drAccount").keyup(function() {
    //     var dr = -$("#acBalance").val();
    //     var cr = $(this).val();
    //     if (dr < cr) {
    //         $("#submit").attr("disabled", true);
    //     } else {
    //         $("#submit").attr("disabled", false);
    //     }
    // });
</script>

<script>
    // acBalance
    $("#drAccount").on("keyup change", function(e) {
        var cr = parseInt($("#acBalance").val());
        var dr = parseInt($("#drAccount").val());


        if (isNaN(cr)) {
            $("#loaderIcon").show();
            $("#name_availability_status").html("<b><h4 class='validation' style='color:red;margin-bottom: 20px;text-align:center;'>Please Select To Account</h4></b>");
            $("#submit").hide();
        } else {
            $("#loaderIcon").hide();
            if (cr <= dr) {

                $("#loaderIcon2").show();
                $("#minimum_balence").html("<b><h4 class='validation' style='color:red;margin-bottom: 20px;text-align:center;'>Insufficient Balance</h4></b>");
                $("#submit").hide();

            } else {

                $("#loaderIcon2").hide();
                $("#submit").show();

            }

        }
        
    })
   
</script>
<?php
$conn->close();
?>
</body>

</html>