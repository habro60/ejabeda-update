<?php
require "../auth/auth.php";
require "../database.php";
?>
<?php

if (isset($_POST['subBtn'])) {
    // $trn_no = $_POST['trn_no'];
    $office_code = $_SESSION['office_code'];
    $ss_org_no = $_SESSION['org_no'];
    // $year_code = $_POST['year_code'];
    $batch_no = $_POST['batch_no'];
    $tran_date = $_POST['tran_date'];
    // $by_account = $_POST['by_account'];
    $to_account = $_POST['to_account'];
    $tran_mode = $_POST['tran_mode'];
    // $vaucher_type = $_POST['vaucher_type'];
    $particular = $_POST['particular'];

    $category_code = $_POST['category_code'];
    if ($category_code == '1') {
        $draccount = $_POST['draccount'];
    } elseif ($category_code == '2') {
        $craccount = $_POST['draccount'];
    }elseif ($category_code == '3') {
        $craccount = $_POST['draccount'];
    }elseif ($category_code == '4') {
        $draccount = $_POST['draccount'];
    }



    
    
    $ss_creator = $_POST['ss_creator'];


    $insertQuery = "INSERT INTO `tran_details` (`office_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`description`, `dr_amt_loc`,`cr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES ('$office_code','$batch_no','$tran_date','$to_account','$tran_mode','$particular','$draccount','$craccount','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuery);
    // echo $insertQuery;exit;
    if ($conn->affected_rows == 1) {
        $messages = "Updated successfully";
    }

    // header("refresh:1;../transation/opening_balance.php");
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=opening_balance.php\">";
}
?>

<?php
require "../source/top.php";
$pid = 102000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Opening Balance</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <?php
    $querys = "insert into bach_no (username) values ('$_SESSION[username]')";
    $returns = mysqli_query($conn, $querys);
    $lastRows = $conn->insert_id;
    ?>
    <!-- form start  -->
    <form method="post">
        <table class="table bg-light table-bordered table-sm">
            <thead>
                <tr>
                    <th>Voucher No</th>
                    <th style="text-align: center"> Date</th>
                    <th style="text-align: center">Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> <input type="text" name="batch_no" readonly class="org_form org_12" autofocus value="<?php echo $lastRows; ?>"></td>
                    <td>   <input type="date" id="date" class="org_form" name="tran_date" value="<?php echo date('Y-m-d'); ?>"></td>
                    <td> <input type="text" id="date" class="org_form" id="clock" value="<?php date_default_timezone_set('Asia/Dhaka');
                                                                                            echo date("h:i:sa"); ?>" readonly></td>
                </tr>
            </tbody>
        </table>
        <table class="table bg-light table-bordered table-sm">
            <thead>
                <th>Account</th>
                <th>Particular</th>
                <th>Opening Balance</th>
            </thead>
            <tbody>
            <td><select class="form-control grand" name="to_account" onchange="toAccount()" id="to_account" required>
                            <option value="">---Select To Account ---</option>
                            <?php
                             $selectQuery = "SELECT * FROM `gl_acc_code` where  postable_acc= 'Y'";
                             $selectQueryResult =  $conn->query($selectQuery);
                             if ($selectQueryResult->num_rows) {
                                 while ($drrow = $selectQueryResult->fetch_assoc()) {
                                     echo '<option value="' . $drrow['acc_code'] . '">'  . $drrow['acc_head'] . '</option>';
                                 }
                             }
                             ?>
                        </select></td>
                <td><input type="text" class="form-control" name="particular"></td>
                <td> <input type="text" class="form-control" id="draccount" name="draccount"></td>
                <!-- <td><input type="text" class="form-control" id="craccount" name="craccount"></td> -->
            </tbody>
        </table>
        <!-- hidden  -->
        <input type="hidden" class="form-control" name="tran_mode" value="OB">
        <input type="hidden" name="category_code" id="category_code" value="">
        <div class="text-right" style="margin-right:20px">
            <input type="submit" value="Submit" name="subBtn" class="btn btn-success">
            <input type="reset" value="Cancel" name="cacel" class="btn btn-danger">
        </div>
    </form>
    <!-- form end  -->
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java script plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- serch option js -->
<script src="../js/select2.full.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#102000").addClass('active');
        $("#100000").addClass('active');
        $("#100000").addClass('is-expanded');
    });

    function toAccount() {
            var account_no = $('#to_account').val();
            $.ajax({
                type: "POST",
                url: "getAccountAddress.php",
                data: {
                    to_account: account_no
                },
                dataType: "text",
                success: function(response) {

                    $('#category_code').val(response);
                    
                    }

            });
    }
        
</script>
<?php
$conn->close();
?>
</body>

</html>