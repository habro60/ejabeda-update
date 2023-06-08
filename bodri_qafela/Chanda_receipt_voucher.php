<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['subBtn'])) {

    
     $craccount = $_POST['craccount'];
     if ($craccount >'0'){

    $office_code = $_POST['office_code'];
    $year_code = $_POST['year_code'];
    $batch_no = $_POST['batch_no'];
    $tran_date = $_POST['tran_date'];
    $by_account = $_POST['by_account'];
    $to_account = $_POST['to_account'];
    $tran_mode = $_POST['tran_mode'];
    $vaucher_typedr = $_POST['vtdr'];
    $vaucher_typecr = $_POST['vtcr'];
    $particular = $_POST['particular'];
    $craccount = $_POST['craccount'];
    $ss_creator = $_POST['ss_creator'];
    $ss_org_no = $_POST['ss_org_no'];

    $insertQuery="INSERT INTO `tran_details` (`tran_no`, `auto_tran_no`, `office_code`, `year_code`, `batch_no`, `tran_date`, `back_value_date`, `gl_acc_code`, `tran_mode`, `vaucher_type`, `dr_amt_loc`, `cr_amt_loc`, `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `pay_on_vouch_no`, `purchase_date`, `bill_paid_flag`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no`) values (NULL, '0', '2400000000', '2021', '$batch_no', '$tran_date', '9999-09-09', '$to_account', '$tran_mode', '$vaucher_typecr', '0.00', '$craccount', '0.00', '0.00', 'N/A', 'N/A', 'N/A', '9999-09-09', '01', '0.0', '$particular', '', '', '', '1', '', '9999-09-09', '', '9999-09-09', '', '$ss_creator', now(), '', '9999-09-09', '$ss_org_no')";


    // echo $insertQuery;
    // exit;

    $conn->query($insertQuery);
    if ($conn->affected_rows == 1) {
        $message = "Save Successfully";
        require "../bodri_qafela/SMS_chanda_receive.php";
    }

    $insertQuery="INSERT INTO `tran_details` (`tran_no`, `auto_tran_no`, `office_code`, `year_code`, `batch_no`, `tran_date`, `back_value_date`, `gl_acc_code`, `tran_mode`, `vaucher_type`, `dr_amt_loc`, `cr_amt_loc`, `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `pay_on_vouch_no`, `purchase_date`, `bill_paid_flag`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no`) values (NULL, '0', '2400000000', '2021', '$batch_no', '$tran_date', '9999-09-09', '$by_account', '$tran_mode', '$vaucher_typedr', '$craccount', '0.0', '0.00', '0.00', 'N/A', 'N/A', 'N/A', '9999-09-09', '01', '0.0', '$particular', '', '', '', '1', '', '9999-09-09', '', '9999-09-09', '', '$ss_creator', now(), '', '9999-09-09', '$ss_org_no')";
    
    $conn->query($insertQuery);
    if ($conn->affected_rows == 1) {
        $messagecr = "cr Save Successfully";
        // require "../bodri_qafela/SMS_fund_receive.php";
    }

    for ($i = 0; $i < count($_POST['flag']); $i++) {
        $flag = $_POST['flag'][$i];
        $donner_pay_amt = $_POST['donner_pay_amt'][$i];
        $member_id = $_POST['member_id'][$i];
        // $from_date = $_POST['from_date'][$i];
        $fund_type = $_POST['fund_type'][$i];
        $bill_date=$_POST['bill_date'];
        $tran_date=$_POST['tran_date'];
        $craccount = $_POST['craccount'];

        if ($flag == 1) {
            $updateQuery = "UPDATE donner_fund_detail SET `last_paid_date`='$bill_date', `num_of_paid`=(num_of_paid +1), donner_paid_amt=(donner_paid_amt+$donner_pay_amt) WHERE `member_id`='$member_id' AND fund_type='$fund_type'";
            // echo $updateQuery;
            // exit; 
            $conn->query($updateQuery);
            if ($conn->affected_rows == 1) {
                $messagescr = "Updated successfully";
            }
        }
    }
    for ($i = 0; $i < count($_POST['flag']); $i++) {
        $flag = $_POST['flag'][$i];
        $donner_pay_amt = $_POST['donner_pay_amt'][$i];
        $member_id = $_POST['member_id'][$i];
        $fund_type = $_POST['fund_type'][$i];
        $fund_type_desc = $_POST['fund_type_desc'][$i];
        $from_date = $_POST['from_date'][$i];
        $paid_upto = $_POST['bill_date'];
        $paid_date = $_POST['tran_date'];

        if ($flag == 1) {

            $insertFund = "INSERT INTO `fund_receive_detail`  (`tran_no`,batch_no,`office_code`,`member_id`, gl_acc_code,paid_mode, `paid_amount`, `paid_date`,from_date, paid_upto,`fund_type`,`fund_type_desc`, `ss_creator`,`ss_creator_on`,`ss_modified_on`,`ss_org_no`) VALUES (NULL,'$batch_no','$office_code','$member_id', '$to_account','CR','$donner_pay_amt', '$paid_date','$from_date','$paid_upto','$fund_type','$fund_type_desc','$ss_creator',now(),now(),'$ss_org_no')";

            // echo  $insertFund;
            // exit;

            $conn->query($insertFund);
            if ($conn->affected_rows == 1) {
                $messagescr = "insert successfully";
            }
        }
    }
    }
    header('refresh:1;../bodri_qafela/Chanda_receipt_voucher.php');
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
            <h1><i class="fa fa-dashboard"></i> Chanda Collection</h1>
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
                <th> <a href="../bodri_qafela/fund_receipt_voucher.php"><button type="button" class="btn btn-dark" disabled>Chanda Cash Received</button></a></th>
                <th> <a href="../bodri_qafela/fund_receipt_voucher_bank.php"><button type="button" class="btn btn-primary">Chanda Cheque Received</button></a></th>
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
                    <td><input type="date" name="tran_date" id="tran_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required></td>
                    <td> <?php if (isset($_SESSION['username'])) : ?>
                            <input type="text" name="ss_creator" id="" value="<?php echo $_SESSION['username']; ?>" class="form-control" readonly>
                        <?php endif; ?></td>
                </tr>
                </body>
        </table>
        <hr>
        <!-- 
            Add To Bill 
         -->
        <table class="table bg-light table-bordered table-sm">
            <h5 style="text-align: center">Fund Cash Received</h5>
            <thead>
                <tr>
                    <th>By Account</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 200px">
                        <select class="form-control select2" name="by_account" onchange="calculatebyAccount()" id="byAccount" required>
                            <option value="">---Select---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where category_code = 1 and postable_acc= 'Y' AND acc_type=1  or acc_type=2 ORDER by acc_code";
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
                    <td style="width: 200px"><input type="text" name="" id="acBalance" class="form-control" placeholder='balance' readonly></td>
                </tr>
                <thead>
                    <tr>
                        <th>Chanda upto Date</th>
                        <th>To Account</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
            <tbody>
                <tr>
                    <td style="width: 250px"> <input type="date" id="bill_date" class="form-control" name="bill_date" placeholder='Bill Upto date' required></td>
                    <td style="width: 200px">
                        <select class="form-control select2" name="to_account" onchange="MyfunctionToAcc()" id="ToAccount" required>
                            <option value="">---Select---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' AND subsidiary_group_code= '400' ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['acc_code'] . '">'  . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    
                    <td style="width: 250px"> <input type="text" class="form-control" name="particular" placeholder='Particulars'></td>
                    <td style="width: 250px"> <input type="text" class="form-control" name="draccount" placeholder='Dr. Amount' disabled></td>
                    <td style="width: 250px"> <input type="text" class="form-control" name="" placeholder='Cr. Amount'></td>
                </tr>
            </tbody>
        </table>
        <hr>
        
        <div id="result">

        </div>
        
        <input type="hidden" class="form-control" name="tran_mode" value="CASFR">
        <input type="hidden" class="form-control" name="office_code" value="<?php echo $_SESSION['office_code']; ?>">
        <input type="hidden" class="form-control" name="year_code" value="<?php echo $_SESSION['org_fin_year_st']; ?>">
        <input type="hidden" class="form-control" name="vtdr" value="DR">
        <input type="hidden" class="form-control" name="vtcr" value="CR">
        <input type="hidden" class="form-control" name="ss_org_no" value="<?php echo $_SESSION['org_no']; ?>">
        <!-- 
         submit btn
        -->
        
        <div class="text-right" style="margin-right:20px"> 
        
            <input type="submit" value="Submit" name="subBtn" class="btn btn-success">
        </div>
        </div>
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
        $("#908000").addClass('active');
        $("#900000").addClass('active');
        $("#900000").addClass('is-expanded');
    });

    function calculatebyAccount(byAcc) {
        var byAcc = $('#byAccount').val();
        $.ajax({
            url: 'getFundByAccount.php',
            method: 'POST',
            dataType: 'text',
            data: {
                gl_acc: byAcc
            },
            success: function(response) {
                $("#acBalance").val(response);
            }
        });
    }

    function MyfunctionToAcc(toAcc) {
        var toAcc = $('#ToAccount').val();
        var billdate = $('#bill_date').val();
        // alert(toAcc);
        $.ajax({
            url: 'getChandaReceiv.php',
            method: 'POST',
            dataType: 'text',
            data: {
                to_account: toAcc,
                bill_date: billdate
            },
            success: function(response) {
                $('#result').html(response);
            }
        });
    }

    function returnPost(name, amount) {
        // alert(name + '\n' + amount);
        var total_balance = $('#total_balance').val();
        var cr_balance = $('#crAccount').val();
        var num_of_pay = $('#num_of_pay').val();
        var num_of_paid = $('#num_of_paid').val();
        total_amount = parseInt(cr_balance) + parseInt(amount);
        $('.total').val(total_amount);
        $('#fund_paid_flag' + amount + '').attr("disabled", true);
        $('#fund_paid_flag_skip' + amount + '').attr("disabled", false);
        $('#donner_pay_amt' + amount + '').css({
            "color": "red",
            "border": "2px solid red"
        });
        $('#fund_type_desc' + amount + '').css({
            "color": "red",
            "border": "2px solid red"
        });
        $('#flag' + amount + '').val('1');

        return false;
    }

    function returnSkip(name, amount) {
        //    alert(name+'\n'+amount);
        var total_balance = $('#total_balance').val();
        var cr_balance = $('#crAccount').val();
        total_amount = parseInt(cr_balance) - parseInt(amount);
        $('.total').val(total_amount);
        $('#fund_paid_flag' + amount + '').attr("disabled", false);
        $('#fund_paid_flag_skip' + amount + '').attr("disabled", true);
        $('#donner_pay_amt' + amount + '').css({
            "color": "black",
            "border": "2px solid white"
        });
        $('#fund_type_desc' + amount + '').css({
            "color": "black",
            "border": "2px solid white"
        });
        $('#flag' + amount + '').val('0');
        return false;
    }
    /*
         jQuery(document).ready(function($){
            $(this).click(function(){

             var target=(event.target.id);// Get the id of the title on which we clicked. We will extract the number from this and use it to create a new id for the section we want to open.
             alert(target);// checking that we are getting the right value.
             var openaddress=target.replace(/click/gi, "section");//create the new id for the section we want to open.
             alert('"#'+openaddress+'"');//Confirm that the correct ID has been created
             $('"#'+openaddress+'"').css( "color", "green" );//get the id of the click element and set it as a variable.
             //$("#section1").css( "color", "green" );//Test to confirm that hard coded selector functions correctly.
                 return false;// Suppress the action on the anchor link.
                 });
         });
        */
</script>
<?php
$conn->close();
?>
</body>

</html>