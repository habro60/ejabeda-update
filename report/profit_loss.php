<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
// $pid = 705000;
// $role_no = $_SESSION['sa_role_no'];
// auth_page($conn, $pid, $role_no);
require '../source/header.php';
require '../source/sidebar.php';

// session //
// $role_no     = 99; // admin 99 superadmin 100
$role_no  = $_SESSION['sa_role_no']; // admin 99 superadmin 100
$office_code = $_SESSION['office_code'];
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_no      = $_SESSION['org_no'];
?>
<main class="app-content">
    <div class="app-title">
        <div style="width: 100%;">
            <h1><i class="fa fa-dashboard"></i> Profit And Loss Statement </h1>
        </div>
    </div>
    <!--  -->
    <form method="POST">
        <table class="table-responsive table-striped">
            <thead>
                <?php
                if ($role_no== '99') {
                ?>
                <th>Office</th>
                <?php 
                }
                ?>
                <th> As on Date </th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if ($role_no== '99') {
                    $option = "SELECT office_code,office_name from office_info";
                    $query = $conn->query($option);
                    ?>
                    <td>
                    <select name="officeId" class="form-control select2" id="" style="width: 180px;">
                        <option value="">- Select -</option>
                            <?php
                            while ($rows = $query->fetch_assoc()) {
                                echo '<option value=' . $rows['office_code'] . '>' . $rows['office_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <?php
                    }
                    ?>
                    <td>
                        <input type="date" name="enddate" value="<?php echo $enddate; ?>" class="form-control" required>
                    </td>
                    <td>
                        <input type="submit" name="submit" id="submitBtn" class="btn btn-info" value="Report View">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <div>
        <!--  -->
        <?php
        if (isset($_POST['submit'])) {
            $officeId = $_POST['officeId'];
            $enddate = $conn->escape_string($_POST['enddate']);
        ?>
            <div id="organizationName">
                <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
            </div>
            <h4 style="text-align:center" id="reportTitle">Profit And Loss Statement</h4>
            <h5 style="text-align:center" id="dateToDate">
                <?php if (isset($enddate)) {
                    echo "As on Date :- " . $enddate;
                }
                ?>
            </h5>
            <div class="pull-right">
                <a id="Print" class="btn btn-danger print"></i>Print</a>
                
            </div>
            <br><br>
            <div id="mySelector">
                <div id="mySelector">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">
                            <th>Total Income</th>
                            <th>Total Expense</th>
                            <th>Total Profit</th>
                            <th>Total loss</th>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($officeId)) {
                                 $sql_inc = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.cr_amt_loc- tran_details.dr_amt_loc) as total_income  FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.office_code='$officeId' AND tran_details.tran_date<= '$enddate' AND gl_acc_code.category_code = '3' group by gl_acc_code.category_code";
                            } else {
                                 $sql_inc = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.cr_amt_loc- tran_details.dr_amt_loc) as total_income  FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date<= '$enddate' AND gl_acc_code.category_code = '3' group by gl_acc_code.category_code";
                            }
                            if (!empty($officeId)) {
                                $sql_exp = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as total_expanse FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.office_code='$officeId' AND tran_details.tran_date<= '$enddate' AND gl_acc_code.category_code = '4' group by gl_acc_code.category_code";
                            } else {
                                $sql_exp = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as total_expanse FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date<= '$enddate' AND gl_acc_code.category_code = '4' group by gl_acc_code.category_code";
                            }
                            $query_inc = mysqli_query($conn, $sql_inc);
                            $rows_inc =  mysqli_fetch_assoc($query_inc);
                            $query_exp = mysqli_query($conn, $sql_exp);
                            $rows_exp = mysqli_fetch_assoc($query_exp);
                            ?>
                            <tr style="text-align:center">
                                <td style="width:25%;height: 100px;background-color: white">
                                    <strong> <?php echo  $rows_inc['total_income']; ?></strong>
                                </td>
                                <td style="width:25%;height: 50px;background-color: red">
                                    <strong><?php echo  $rows_exp['total_expanse']; ?></strong>
                                </td>
                                <td style="width:25%;height: 50px;background-color: white">
                                    <strong><?php echo ($rows_inc['total_income'] - $rows_exp['total_expanse']); ?></strong>
                                </td>
                                <td style="width:25%;height: 50px;background-color: red">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
        } else {
            echo "<h3 style='color:red;text-align:center;margin-top:150px'>Please Select Date </h3>";
        }
            ?>
            </div>
</main>
<?php
require "report_footer.php";
?>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>

<script src="../js/custom.js"></script>
<!-- data table -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<!-- print this js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>
<!--  -->
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
    $(document).ready(function() {
        $("#705000").addClass('active');
        $("#700000").addClass('active');
        $("#700000").addClass('is-expanded');
    });
</script>
</body>

</html>