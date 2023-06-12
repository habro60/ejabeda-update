<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['subBtn'])) {

    $id = intval($_GET['id']);
    $office_code = $_SESSION['office_code'];
    $bank_acc_no = $_POST['bank_acc_no'];
    $acc_name = $_POST['acc_name'];
    $bank_code = $_POST['bank_code'];
    $bank_name = $_POST['bank_name'];
    $branch_code = $_POST['branch_code'];
    $branch_name = $_POST['branch_name'];
    $bank_address = $_POST['bank_address'];
    $ss_creator = $_SESSION['username'];
    $ss_modifier_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    $insertQuery = "UPDATE `bank_acc_info` SET `office_code`='$office_code', `bank_acc_no`='$bank_acc_no',`acc_name`='$acc_name', `bank_code`='$bank_code',`bank_name`='$bank_name',`branch_code`='$branch_code',`branch_name`='$branch_name',`bank_address`='$bank_address',`ss_creator`='$ss_creator',`ss_modifier_on`='$ss_modifier_on',`ss_org_no`='$ss_org_no' WHERE id=$id";
    $conn->query($insertQuery);
    // echo $insertQuery; exit;
    if ($conn->affected_rows == 1) {
        $message = "Successfully";
    } else {
        $message_failled = "Save Invalid !!";
        header("refresh:1;bank_acc_info_edit.php?id=$id");
    }
    header('refresh:1;bank_acc_info.php');
}
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $selectQueryEdit = "SELECT * FROM `bank_acc_info` WHERE id='$id'";
    $selectQueryEditResult = $conn->query($selectQueryEdit);
    $rows = $selectQueryEditResult->fetch_assoc();
}
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Edit Bank Account Information <?php $rows['id']; ?> </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post">
                <!-- Bank Account No. -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bank Account No.</label>
                    <div class="col-sm-6">
                        <input type="text" name="bank_acc_no" class="form-control" id="" value="<?php echo $rows['bank_acc_no']; ?>" placeholder="Bank Account No" required>
                    </div>
                </div>
                <!-- Account Name -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Account Name</label>
                    <div class="col-sm-6">
                        <input type="text" name="acc_name" class="form-control" id="" value="<?php echo $rows['acc_name']; ?>" placeholder="Account Name" required>
                    </div>
                </div>
                <!-- Bank Code  -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bank</label>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="text" name="bank_code" class="form-control" id="" value="<?php echo $rows['bank_code']; ?>" placeholder="Bank Code" required>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="bank_name" class="form-control" id="" value="<?php echo $rows['bank_name']; ?>" placeholder="Bank Name" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Branch name  -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Branch</label>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="text" name="branch_code" class="form-control" id="" value="<?php echo $rows['branch_code']; ?>" placeholder="Branch Code" required>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="branch_name" class="form-control" id="" value="<?php echo $rows['branch_name']; ?>" placeholder="Branch Name" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bank Address  -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bank Address </label>
                    <div class="col-sm-6">
                        <input type="text" name="bank_address" class="form-control" id="" value="<?php echo $rows['bank_address']; ?>" placeholder="Bank Address" required>
                    </div>
                </div>

                <!-- submit  -->
                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-primary" name="subBtn" value="submit">
                        <input type="reset" class="btn btn-danger" name="subBtn" value="cancel">
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <?php
    if (!empty($message)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Update Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    } else {
    }
    if (!empty($message_failled)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Failled !!",
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
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#accinfo").addClass('active');
        $("#gl_acc").addClass('active');
        $("#accinfo").addClass('is-expanded');
    });
</script>
<?php
$conn->close();
?>
</body>

</html>