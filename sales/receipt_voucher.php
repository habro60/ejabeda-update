<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['subBtn'])) {
    // $trn_no = $_POST['trn_no'];
    $office_code = $_POST['office_code'];
    $year_code = $_POST['year_code'];
    $batch_no = $_POST['batch_no'];
    $tran_date = $_POST['tran_date'];
    $by_account = $_POST['by_account'];
    $toaccount = $_POST['toaccount'];
    $tran_mode = $_POST['tran_mode'];
    $vaucher_typedr = $_POST['vtdr'];
    $vaucher_typecr = $_POST['vtcr'];
    $particular = $_POST['particular'];
    $craccount = $_POST['craccount'];
    $ss_creator = $_POST['ss_creator'];
    $ss_org_no = $_POST['ss_org_no'];
    //-------------------
    $pay_on_vouch_no = $_POST['pay_on_vouch_no'];
    $purchase_date = $_POST['purchase_date'];
    $bill_paid_flag = '2';
    //-------------------
    // cr
    $insertQuery = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `dr_amt_loc`,`pay_on_vouch_no`,`purchase_date`,`bill_paid_flag`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$by_account','$tran_mode','$vaucher_typedr','$particular','$craccount','$pay_on_vouch_no','$purchase_date','$bill_paid_flag','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuery);
    if ($conn->affected_rows == 1) {
        $message = "Save Successfully";
    }
    $updateQuery = "UPDATE `gl_acc_code` SET acc_bal_loc=acc_bal_loc-'$craccount' where acc_code='$by_account'";
    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {
        $messages = "Updated successfully";
    }
    // dr
    $insertQuery = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `cr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$toaccount','$tran_mode','$vaucher_typecr','$particular','$craccount','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuery);
    if ($conn->affected_rows == 1) {
        $messagecr = "cr Save Successfully";
    }

    // Update invoice table ;  
    $insertInv = "INSERT INTO invoice_detail(id,`office_code`, `order_type`, `in_out_flag`, `order_no`,`gl_acc_code`, `order_date`, `item_no`, `item_qty`, `item_unit`, `unit_price_loc`, `unit_price_fc`, `curr_code`, `exch_rate`, `total_price_loc`, `total_price_fc`, `include`, `includ_vat_tax`, `bar_code`, `item_origin`, `item_waranty`, `warranty_type`, `agaunest_indent_no`,`bill_status`, `item_status`, `status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no`) SELECT null, `office_code`,'SVR','1', '$batch_no', '$toaccount', '$tran_date', `item_no`, `item_qty`, `item_unit`, `unit_price_loc`, `unit_price_fc`, `curr_code`, `exch_rate`, `total_price_loc`, `total_price_fc`, `include`, `includ_vat_tax`, `bar_code`, `item_origin`, `item_waranty`, `warranty_type`, `agaunest_indent_no`, 'SVR', '1',`status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no` FROM invoice_detail WHERE  gl_acc_code='$toaccount' and  order_no= '$pay_on_vouch_no' and bill_status='SV'";
    // echo $insertInv;
    // exit;
    $conn->query($insertInv);
    if ($conn->affected_rows == 1) {
        $message = "Save Successfully";
    }

    $updateQuery = "UPDATE `gl_acc_code` SET acc_bal_loc=acc_bal_loc+'$craccount' where acc_code='$toaccount'";
    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {
        $messagescr = "Updated successfully";
    }
    $updateInv = "update invoice_detail set `item_status`='SVR', `status_date`=now() where order_no= '$pay_on_vouch_no' and order_type='SV'";
    $conn->query($updateInv);
    header('refresh:1;../transation/receipt_voucher.php');
}
require "../source/top.php";
$pid = 401000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Cash Received</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <form method="post">
        <table>
            <thead>
                <th>Received Type : </th>
                <th> <a href="../transation/receipt_voucher.php"><button type="button" class="btn btn-dark" disabled>Cash Received</button></a></th>
                <th> <a href="../transation/receipt_voucher_Bank.php"><button type="button" class="btn btn-primary">Cheque Received</button></a></th>
            </thead>
        </table>
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
                        <?php endif; ?></td>
                </tr>
                </body>
        </table>
        <hr>
        <table class="table bg-light table-bordered table-sm">
            <h5 style="text-align: center">Cash Received</h5>
            <thead>
                <th>By Account</th>
                <th></th>
                <th></th>
                <th>A/C Balance</th>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 200px">
                        <select class="form-control select2" name="by_account" onchange="calculateToAccount()" id="toAccount" required>
                            <option value="">---Select---</option>
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
                    </td>
                    <td></td>
                    <td></td>
                    <td style="width: 200px"><input type="text" name="" id="acBalance" class="form-control" readonly></td>
                </tr>
                <thead>
                    <th>To Account</th>
                    <th>Particular</th>
                    <th>Dr. Amount</th>
                    <th>Cr. Amount</th>
                </thead>
            <tbody>
                <tr>
                    <td style="width: 200px">
                        <select class="form-control select2" name="toaccount" id="byAccount" onchange="calculateByAccount()" required>
                            <option value="">---Select---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' AND acc_type!=1 AND acc_type!=2 ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['acc_code'] . '">'  . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <input type="hidden" class="form-control" name="particular">
                    <td><select name="pay_on_vouch_no" id="pay_on_vouch_no" class="form-control" onchange="calculateDate()">
                            <option value="">Select voucher</option>
                        </select></td>
                    <td><select name="purchase_date" id="purchase_date" class="form-control">
                            <option value="">Select Date</option>
                        </select></td>
                    <!-- <td style="width: 250px"> <input type="text" class="form-control" name="draccount" disabled></td> -->
                    <td style="width: 250px"> <input type="text" class="form-control" name="craccount" id="drAccount"></td>
                </tr>
            </tbody>
        </table>
        <!-- hidden  -->
        <input type="hidden" class="form-control" name="tran_mode" value="SCR">
        <input type="hidden" class="form-control" name="office_code" value="<?php echo $_SESSION['office_code']; ?>">
        <input type="hidden" class="form-control" name="year_code" value="<?php echo $_SESSION['org_fin_year_st']; ?>">
        <input type="hidden" class="form-control" name="vtdr" value="DR">
        <input type="hidden" class="form-control" name="vtcr" value="CR">
        <input type="hidden" class="form-control" name="ss_org_no" value="<?php echo $_SESSION['org_no']; ?>">
        <div class="text-right" style="margin-right:20px">
            <input type="submit" value="Submit" name="subBtn" class="btn btn-success">
        </div>
    </form>
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
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
    $(document).ready(function() {
        $("#401000").addClass('active');
        $("#400000").addClass('active');
        $("#400000").addClass('is-expanded');
    });

    function calculateToAccount(toAcc) {
        var toAcc = $('#toAccount').val();
        $.ajax({
            url: 'getCheckReceive.php',
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
        alert(x);
        $.ajax({
            url: 'getCheckReceive.php',
            method: 'POST',
            dataType: 'text',
            data: {
                acc_code: x
            },
            success: function(response) {
                $("#pay_on_vouch_no").html(response);
                if (response == 0) {

                } else {

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
            url: 'getCheckReceive.php',
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
            url: 'getCheckReceive.php',
            method: 'POST',
            dataType: 'text',
            data: {
                gl_acc_code: x
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
</script>
<?php
$conn->close();
?>
</body>

</html>