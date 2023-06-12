<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['subBtn'])) {
    $office_code = $_POST['office_code'];
    $year_code = $_POST['year_code'];
    $batch_no = $_POST['batch_no'];
    // date ..
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
    $insertQuerycr = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `cr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$to_account','$tran_mode','$vaucher_typecr','$particular','$craccount','$ss_creator',now(),'$ss_org_no')";
  
    $conn->query($insertQuerycr);
    if ($conn->affected_rows == 1) {
        $message = "Save Successfully";
    }

    $insertQuerydr = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `dr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$by_account','$tran_mode','$vaucher_typedr','$particular','$craccount','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuerydr);
    if ($conn->affected_rows == 1) {
        $messagecr = "cr Save Successfully";
    }
 
    for ($i = 0; $i < count($_POST['bill_paid_flag']); $i++) {
        $bill_paid_flag = $_POST['bill_paid_flag'][$i];
        $bill_for_month = $_POST['bill_for_month'][$i];
        $bill_charge_code = $_POST['bill_charge_code'][$i];
        $flat_no = $_POST['flat_no'][$i];
      
        if ($bill_paid_flag == 1) {
            $updateQuery = "UPDATE `apart_owner_bill_detail` set `bill_paid_date`='$tran_date', `bill_paid_flag`='1', `batch_no`='$batch_no' WHERE `owner_gl_code`='$to_account' AND bill_charge_code='$bill_charge_code' AND flat_no='$flat_no' AND bill_for_month='$bill_for_month'";
            $conn->query($updateQuery);
            if ($conn->affected_rows == 1) {
                $messagescr = "Updated successfully";
            }
        }
    }

    // header('refresh:1;../apartment/bill_receipt_voucher.php');
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=bill_receipt_voucher.php\">";
}
require "../source/top.php";
$pid = 1306000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
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
        <table>
            <thead>
                <th>Received Type : </th>
                <th> <a href="../apartment/bill_receipt_voucher.php"><button type="button" class="btn btn-dark" disabled>Bill Cash Received</button></a></th>
                <th> <a href="../apartment/bill_receipt_voucher_bank.php"><button type="button" class="btn btn-primary">Bill Cheque Received</button></a></th>
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
        <!-- 
            Add To Bill 
         -->
        <table class="table bg-light table-bordered table-sm">
            <h5 style="text-align: center">Bill Cash Received</h5>
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
                            $selectQuery = "SELECT * FROM `gl_acc_code` where category_code = 1 and postable_acc= 'Y' AND acc_type=1  ORDER by acc_code";
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
                        <th>To Account</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
            <tbody>
                <tr>
                    <td style="width: 200px">
                        <select class="form-control select2" name="to_account" onchange="MyfunctionToAcc()" id="ToAccount" required>
                            <option value="">---Select---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' AND subsidiary_group_code= '800' ORDER by acc_code";
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
                    <td style="width: 250px"> <input type="text" class="form-control" name="craccount" placeholder='Cr. Amount' disabled></td>
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
        $("#1306000").addClass('active');
        $("#1300000").addClass('active');
        $("#1300000").addClass('is-expanded');

    });

    function MyfunctionToAcc(toAcc) {
        var toAcc = $('#ToAccount').val();
        // alert(toAcc);
        $.ajax({
            url: 'getBillRecepit.php',
            method: 'POST',
            dataType: 'text',
            data: {
                to_account: toAcc
            },
            success: function(response) {
                $('#result').html(response);
            }
        });
    }

    function calculatebyAccount(byAcc) {
        var byAcc = $('#byAccount').val();
        $.ajax({
            url: 'getCheckPayment.php',
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

        return false;
    }

    function returnSkip(name, amount,no) {
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
        return false;
    }
    // $(this).click(function() {
    //     var target = (event.target.name); // Get the id of the title on which we clicked. We will extract the number from this and use it to create a new id for the section we want to open.
    //     alert(target); 
    // });
</script>
<?php
$conn->close();
?>
</body>

</html>