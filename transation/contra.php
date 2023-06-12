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
    if (empty($_POST['craccount'])) {
        $vaucher_type = $_POST['vtcr'];
    } else {
        $vaucher_type = $_POST['vtdr'];
    }
    $draccount = $_POST['draccount'];
    $craccount = $_POST['craccount'];
    $particular = $_POST['particular'];
    $draccount1 = $_POST['draccount1'];
    $craccount1 = $_POST['craccount1'];
    $particular1 = $_POST['particular1'];
    if (empty($_POST['draccount1'])) {
        $vaucher_type1 = $_POST['vtdr'];
    } else {
        $vaucher_type1 = $_POST['vtcr'];
    }
    $ss_creator = $_POST['ss_creator'];
    $ss_org_no = $_POST['ss_org_no'];

    $insertQuery = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `dr_amt_loc`,`cr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$by_account','$tran_mode','$vaucher_type1','$particular','$draccount','$craccount','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuery);
    // echo $insertQuery;
    if ($conn->affected_rows == 1) {
        $message = "Save Successfully";
    }
    // insert cr 
    $insertQuery = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`,`dr_amt_loc`, `cr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$toaccount','$tran_mode','$vaucher_type','$particular1','$draccount1','$craccount1','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuery);
    // echo $insertQuery;
    if ($conn->affected_rows == 1) {
        $messagecr = "cr Save Successfully";
    }
    header('refresh:1;../transation/contra.php');
}
require "../source/top.php";
$pid= 405000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Cash Receipt</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <!-- ----------------code here---------------->
        <div class="c_main">
            <!-- head -->
            <div class="c_head">
                <!-- form start  -->
                <form method="post">
                    <div class="c_main_left"><br>
                        <!-- batch_no -->
                        <?php
                        $querys = "insert into bach_no (username) values ('$_SESSION[username]')";
                        $returns = mysqli_query($conn, $querys);
                        $lastRows = $conn->insert_id;
                        ?>
                        <div class="org_row org_group">
                            <label class="org_2 org_label"> Contra Voucher No</label>
                            <div class="org_10">
                                <input type="text" name="batch_no" readonly class="org_5 org_label" required autofocus placeholder="ID" value="<?php echo $lastRows; ?>">
                            </div>
                            <label class="org_2 org_label">Received Type</label>
                        </div>
                    </div>
                    <div class="c_main_right">
                        <div class="org_row org_group">
                            <label class="org_4 org_label">Transaction Date</label>
                            <div class="org_6">
                                <!-- <input type="date" name="tran_date" id="date" class="org_form" value="<?php echo $_SESSION['org_eod_bod_proceorg_date']; ?>" required> -->
                                <input type="date" name="tran_date" id="date" class="org_form" value="<?php echo date('Y-m-d'); ?>" required>

                            </div>
                        </div>
                        <div class="org_row org_group">
                            <label class="org_4 org_label">User ID</label>
                            <div class="org_6">
                                <?php if (isset($_SESSION['username'])) : ?>
                                    <input type="text" name="ss_creator" id="" value="<?php echo $_SESSION['username']; ?>" class="org_form" readonly>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- head close  -->
            <!-- maid body start  -->
            <!-- 2nd section  -->
            <div class="c_form_div">
                <div class="form-row" style="width:98%">
                    <div class="form-group col-md-3">
                        <label>Transfer To Account</label>
                        <select class="form-control select2" name="by_account" required>
                            <option value="">---Select---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' AND (acc_type = 1 OR acc_type = 2 ) ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['acc_code'] . '">'  . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Particular</label>
                        <input type="text" class="form-control" name="particular">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Dr. Amount</label>
                        <input type="text" class="form-control" name="draccount">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Cr. Amount</label>
                        <input readonly type="text" class="form-control" name="craccount">
                    </div>
                </div>
            </div>
            <hr>
            <!-- 2nd section  -->
            <div class="c_form_div">
                <div class="form-row" style="width:98%">
                    <div class="form-group col-md-3">
                        <label>Transfer From Account</label>
                        <select class="form-control select2" name="toaccount" required>
                            <option value="">---Select---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' AND (acc_type = 1 OR acc_type = 2 ) ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['acc_code'] . '">'  . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Particular</label>
                        <input type="text" class="form-control" name="particular1">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Dr. Amount</label>
                        <input readonly type="text" class="form-control" name="draccount1">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Cr. Amount</label>
                        <input readonly type="text" id="craccount1" class="form-control" name="craccount1">
                    </div>
                </div>
            </div>
            <!-- hidden  -->
            <input type="hidden" class="form-control" name="tran_mode" value="CONTR">
            <input type="hidden" class="form-control" name="office_code" value="<?php echo $_SESSION['office_code']; ?>">
            <input type="hidden" class="form-control" name="year_code" value="<?php echo $_SESSION['org_fin_year_st']; ?>">
            <input type="hidden" class="form-control" name="vtdr" value="DR">
            <input type="hidden" class="form-control" name="vtcr" value="CR">
            <input type="hidden" class="form-control" name="ss_org_no" value="<?php echo $_SESSION['org_no']; ?>">
            <!-- /////////////////////////////////////  -->
            <div class="text-right" style="margin-right:20px">
                <input type="submit" value="Submit" name="subBtn" class="btn btn-success">
                <!-- <input type="submit" value="Cancel" name="cacel" class="btn btn-danger"> -->
            </div>
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
                "Save CR Successfully!!",
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
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>


<script>

$(document).on('keyup', 'input[name^="draccount"]', function() {
    
     var drValue = $(this).val();
     
     
    $('#craccount1').val(drValue);



});

</script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>
<script>
    $(document).ready(function() {
        $("#405000").addClass('active');
        $("#400000").addClass('active');
        $("#400000").addClass('is-expanded');
    });
</script>
<?php
$conn->close();
?>
</body>

</html>