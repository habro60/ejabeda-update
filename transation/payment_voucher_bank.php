<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['subBtn'])) {
    // $trn_no = $_POST['trn_no'];
    $office_code = $_POST['office_code'];
    $year_code = $_POST['year_code'];
    $batch_no = $_POST['batch_no'];
    $tran_date = $_POST['tran_date'];

    // Account
    $by_account = $_POST['by_account'];
    $toaccount = $_POST['toaccount'];
    // Account

    $tran_mode = $_POST['tran_mode'];
    $vaucher_typedr = $_POST['vtdr'];
    $vaucher_typecr = $_POST['vtcr'];
    $particular = $_POST['particular'];
    $draccount = $_POST['draccount'];
    $bank_name = $_POST['bank_name'];
    $cheque_no = $_POST['cheque_no'];
    $cheque_date = $_POST['cheque_date'];
    $ss_creator = $_POST['ss_creator'];
    $ss_org_no = $_POST['ss_org_no'];
    //---------------------
    $pay_on_vouch_no = $_POST['pay_on_vouch_no'];
    $purchase_date = $_POST['purchase_date'];
    if (!empty($pay_on_vouch_no)) {
        $bill_paid_flag = '2';
    } else {
        $bill_paid_flag = '0';
    }

    //----------------------
    // insert dr 
    $insertQuery = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `dr_amt_loc`,`bank_name`,`cheque_no`,`cheque_date`,`pay_on_vouch_no`,`purchase_date`,`bill_paid_flag`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$by_account','$tran_mode','$vaucher_typedr','$particular','$draccount','$bank_name','$cheque_no','$cheque_date','$pay_on_vouch_no','$purchase_date','$bill_paid_flag','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuery);
    // echo $insertQuery; exit;
    if ($conn->affected_rows == 1) {
        $messagecr = "cr Save Successfully";
        if ($conn->affected_rows == 1) {
            $message = "Save Successfully";
        }
    }
    //Update invoice table ;  
    // $insertInv = "INSERT INTO invoice_detail(id,`office_code`, `order_type`, `in_out_flag`, `order_no`,`gl_acc_code`, `order_date`, `item_no`, `item_qty`, `item_unit`, `unit_price_loc`, `unit_price_fc`, `curr_code`, `exch_rate`, `total_price_loc`, `total_price_fc`, `include`, `bar_code`, `item_origin`, `item_waranty`, `warranty_type`, `agaunest_indent_no`,`bill_status`, `item_status`, `status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no`) SELECT null, `office_code`,'CHQP','1', '$batch_no', '$by_account', '$tran_date', `item_no`, `item_qty`, `item_unit`, `unit_price_loc`, `unit_price_fc`, `curr_code`, `exch_rate`, `total_price_loc`, `total_price_fc`, `include`, `bar_code`, `item_origin`, `item_waranty`, `warranty_type`, `agaunest_indent_no`, 'CHQP', '1',`status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no` FROM invoice_detail WHERE  gl_acc_code='$by_account' and  order_no= '$pay_on_vouch_no' and bill_status='PV'";


    $insertInv="INSERT INTO invoice_detail(id,`office_code`, `order_type`, `in_out_flag`, `order_no`,`gl_acc_code`, `order_date`,`item_no`,`item_qty`,`item_unit`,`unit_price_loc`,`curr_code`,`total_price_loc`,`include_vat_rate`,`include_vat_amt`,`include_tax_rate`,`include_tax_amt`,`include_sour_tax_rate`,`include_sour_tax_amt`,`include_discount_rate`,`include_discount_amt`, `bill_status`, `item_status`, `status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no`) 

    SELECT null, `office_code`,'CHQP','1', '$batch_no', '$by_account', '$tran_date', `item_no`, `item_qty`, `item_unit`,`unit_price_loc`,`curr_code`,`total_price_loc`,`include_vat_rate`,`include_vat_amt`,`include_tax_rate`,`include_tax_amt`,`include_sour_tax_rate`,`include_sour_tax_amt`,`include_discount_rate`,`include_discount_amt` , 'CHQP', '1',`status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no` FROM invoice_detail WHERE  gl_acc_code='$by_account' and  order_no= '$pay_on_vouch_no' and bill_status='PV'";
 
   


    $conn->query($insertInv);
    $updateInv = " UPDATE `invoice_detail` SET `bill_status`='CHQP',`item_status`='3',`status_date`=now() WHERE order_no='$pay_on_vouch_no' and order_type='PV' and bill_status='PV'";
    $conn->query($updateInv);

    // update cr 
    $updateQuery = "UPDATE `gl_acc_code` SET acc_bal_loc=acc_bal_loc-'$draccount' where acc_code='$toaccount'";
    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {
        $messagescr = "Updated successfully";
    }
    // update leaf no 
    $updateQuerys = "UPDATE `bank_chq_leaf_info` SET leaf_status=1, status_date=now() where chq_leaf_no='$cheque_no'";
    $conn->query($updateQuerys);
    $updateTrans = "UPDATE `tran_details` set pay_on_vouch_no='$pay_on_vouch_no', bill_paid_flag='$bill_paid_flag' where gl_acc_code= '$by_account'";
    $conn->query($updateTrans);
    if ($conn->affected_rows == 1) {
        $messagescrck = "Updated successfully";
    }
    // cr
    $insertQuery = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `cr_amt_loc`,`bank_name`,`cheque_no`,`cheque_date`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$toaccount','$tran_mode','$vaucher_typecr','$particular','$draccount','$bank_name','$cheque_no','$cheque_date','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuery);
    // echo $insertQuery; exit;
    if ($conn->affected_rows == 1) {
        $message = "Save Successfully";
    }
    // update dr 
    $updateQuery = "UPDATE `gl_acc_code` SET acc_bal_loc=acc_bal_loc+'$draccount' where acc_code='$by_account'";
    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {
        $messages = "Updated successfully";
    }
    // header("refresh:1;../transation/payment_voucher_bank.php");
     echo "<meta http-equiv=\"refresh\" content=\"0;URL=payment_voucher_bank.php\">";
}
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Cheque Payment</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>

    <form method="POST">
        <table>
            <thead>
                <th>Received Type : </th>
                <th> <a href="../transation/payment_voucher.php"><button type="button" class="btn btn-dark">Cash Payment</button></a></th>
                <th> <a href="../transation/payment_voucher_bank.php"><button type="button" class="btn btn-primary" disabled>Cheque Payment</button></a></th>
            </thead>
        </table>
        <hr>
        <table class="table bg-light table-bordered table-sm">
            <thead>
                <th>Voucher No</th>
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
                    <input type="hidden" class="form-control" name="office_code" value="<?php echo $_SESSION['office_code']; ?>">
                    <td><input type="text" name="batch_no" readonly class="form-control" autofocus placeholder="ID" value="<?php echo $lastRows; ?>"></td>
                    <td><input type="date" name="tran_date" id="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required></td>
                    <td> <?php if (isset($_SESSION['username'])) : ?>
                            <input type="text" name="ss_creator" id="" value="<?php echo $_SESSION['username']; ?>" class="form-control" readonly>
                        <?php endif; ?></td>
                </tr>
                </body>
        </table>
        <hr>
        <table class="table bg-light table-bordered table-sm">
            <h5 style="text-align: center">Cheque Payment</h5>
            <thead>
                <th> Bank A/C</th>
                <th></th>
                <th></th>
                <th>A/C Balance</th>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 200px">
                        <select name="toaccount" id="division-list" required class="org_form select2" style="width: 100%" onChange="getDistrict(this.value);">
                            <option value="">---Select Bank A/C---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' AND acc_type=2 ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['acc_code'] . '">' . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td></td>
                    <td></td>
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
                <th>Payment A/C</th>
                <tr>
                    <td style="width: 200px">
                        <select name="by_account" onchange="calculateByAccount()" id="byAccount" required class="form-control">
                            <option value="">---Select Payment A/C---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' AND category_code !='3' and acc_type!=1 AND acc_type!=2 ORDER by acc_code";
                            // $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' AND acc_type='6' ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['acc_code'] . '">'  . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td><select name="pay_on_vouch_no" id="pay_on_vouch_no" class="form-control" onchange="calculateDate()">
                            <option value="">Select voucher</option>
                        </select></td>
                    <td><select name="purchase_date" id="purchase_date" class="form-control">
                            <option value="">Select Date</option>
                        </select></td>

                    <td style="width: 200px"> <input type="text" class="form-control" name="particular" placeholder="Particular"></td>
                </tr>
            <tbody>
                <tr>
                    <td style="width: 200px"> <select name="bank_name" id="bank-list" required class="form-control" onChange="getUpazilas(this.value);">
                            <option value="">Select Bank Account</option>
                        </select></td>
                    <td style="width: 200px"> <select name="cheque_no" id="cheque-list" required class="form-control">
                            <option value="">Select Cheque No</option>
                        </select></td>
                    <td style="width: 200px"> <input type="date" class="form-control" name="cheque_date"></td>
                    <td style="width: 200px"> <input type="text" class="form-control" id="drAccount" name="draccount" placeholder="Dr. Amount"></td>
                </tr>
                <!-- hidden  -->
                <input type="hidden" class="form-control" name="tran_mode" id="tran_mode" value="CHQP">
                <input type="hidden" class="form-control" name="year_code" value="<?php echo $_SESSION['org_fin_year_st']; ?>">
                <input type="hidden" class="form-control" name="vtdr" value="DR">
                <input type="hidden" class="form-control" name="vtcr" value="CR">
                <input type="hidden" class="form-control" name="ss_org_no" value="<?php echo $_SESSION['org_no']; ?>">
                <!-- /////////////////////////////////////  -->
                <tr>
                    <!-- <td></td> -->
                    <!-- <td></td> -->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input type="submit" value="Submit" name="subBtn" id="submit" class="btn btn-success form-control"></td>
                </tr>
            </tbody>
        </table>
    </form>
    </table>
    </form>
    <!-- form end  -->
    </div>
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
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    } else if (!empty($messages)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Update Successfully!!",
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
    } else if (!empty($messagescrck)) {
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
    </div>
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
    function getDistrict(val) {
        // alert(val);
        $.ajax({
            type: "POST",
            url: "getBank_info.php",
            data: 'acc_code=' + val,
            success: function(data) {
                $("#bank-list").html(data);
                getUpazilas();
            }
        });
        var toAcc = $('#division-list').val();
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

    function getUpazilas(val) {
        $.ajax({
            type: "POST",
            url: "getBank_cheque_info.php",
            data: 'bank_acc_no=' + val,
            success: function(data) {
                $("#cheque-list").html(data);
            }
        });

    }
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })
</script>
<script>
    $(document).ready(function() {
        $("#402000").addClass('active');
        $("#400000").addClass('active');
        $("#400000").addClass('is-expanded');
    });

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
                    $("#pay_on_vouch_no").attr('readonly', true);
                    $("#purchase_date").attr("readonly", true);
                } else {
                    $("#pay_on_vouch_no").attr('readonly', false);
                    $("#purchase_date").attr("readonly", false);

                }
            }
        });
    }
    /*
     ** calculateDate() 
     */
    function calculateDate() {
        var order_no = $('#pay_on_vouch_no').val();
        // alert(order_no); 
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
                    $("#submit").attr("disabled", false);
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
    //     $("#drAccount").change(function(){
    //   alert("The text has been changed.");
    // });
</script>

<?php
$conn->close();
?>
</body>

</html>