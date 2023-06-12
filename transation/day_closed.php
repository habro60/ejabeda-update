<?php
require "../auth/auth.php";
require '../database.php';
?>
<?php
//insrt query
if (isset($_POST['subBtn'])) {
    $emp_n = $_SESSION['emp_no'];
    $office_code = $_SESSION['office_code'];
    $org_no = $_SESSION['org_no'];
    $updateQuery = "update `org_info` set org_eod_bod_flag='0' where org_no='$org_no'";
    // echo $updateQuery;
    // exit;
    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {

        echo "<script>alert('Day Close Successfully')</script>";
    } else {
        echo "<script>alert('Day Close failed')</script>";
    }
}
?>
<?php
$sql2 = "SELECT tran_details.gl_acc_code,tran_details.tran_date, sum(tran_details.dr_amt_loc) as dr_amt_loc,sum(tran_details.cr_amt_loc) as cr_amt_loc, gl_acc_code.acc_head,gl_acc_code.acc_code,sum(tran_details.cr_amt_loc-tran_details.dr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code='206010100000' AND tran_details.gl_acc_code=gl_acc_code.acc_code AND (tran_details.tran_date BETWEEN '2019-11-01' AND '2019-11-25')";
$returnD = mysqli_query($conn, $sql2);
$result = mysqli_fetch_assoc($returnD);
?>
<?php
require '../source/top.php';
?>
<?php
require '../source/header.php';
?>
<?php
require '../source/sidebar.php';
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Day Closed </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4>Opening Balance</h4>
                        <p><b><?php echo $result['balance']; ?></b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small info coloured-icon"><i class="icon fa fa-child fa-3x"></i>
                    <div class="info">
                        <h4>Total Received</h4>
                        <p><b><?php echo $result['dr_amt_loc']; ?></b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-child fa-3x"></i>
                    <div class="info">
                        <h4>Total Payment</h4>
                        <p><b><?php echo $result['cr_amt_loc']; ?></b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-small warning coloured-icon"><i class="icon fa fa-money fa-3x"></i>
                    <div class="info">
                        <h4>Closing Balance</h4>
                        <p><b>500</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Daily Received Statement</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Daily Payment Statement</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <form method="post">
            <!-- action="../index/index.php" -->
            <div class="form-group">
                <div>
                    <input type="submit" class="form-control btn btn-danger" name="subBtn" value="Closed Day">
                </div>
            </div>
        </form>
    </div>
    </div>
    </div>
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
<script src="../js/bootstrap.min"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#accinfo").addClass('active');
        $("#gl_acc").addClass('active');
        $("#accinfo").addClass('is-expanded');
    });
</script>

</body>

</html>