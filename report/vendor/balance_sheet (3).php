<?php
require "../auth/auth.php";
require '../database.php';
require '../source/top.php';
// $pid= 706000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require '../source/header.php';
require '../source/sidebar.php';

// session //
$office_code = $_SESSION['office_code'];
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_no      = $_SESSION['org_no'];
?>

<!-- total income  -->
<?php
$query2 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.cr_amt_loc- tran_details.dr_amt_loc) as balance FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< now() AND gl_acc_code.category_code = '3' group by gl_acc_code.category_code";
$returnIncome = mysqli_query($conn, $query2);
$income = mysqli_fetch_assoc($returnIncome);
?>
<!-- totoal Expense  -->
<?php
$query1 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as balance FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< now() AND gl_acc_code.category_code = '4' group by gl_acc_code.category_code";
$returnD = mysqli_query($conn, $query1);
$expense = mysqli_fetch_assoc($returnD);
?>

<main class="app-content">
    <div class="app-title">
        <div style="width: 100%;">
            <h1><i class="fa fa-dashboard"></i> Balance Sheet </h1>
        </div>
    </div>
    <form method="POST">
        <table class="table-responsive table-striped">
            <thead>
                <th>Office</th>
                <th> As on Date </th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <?php
                    // if () {   
                    // }
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
        <?php
        if (isset($_POST['submit'])) {
            $enddate = $conn->escape_string($_POST['enddate']);
            $org_fin_month =  $_SESSION["org_fin_month"];
            $total_libility = $total_asset = 0;

        ?>
            <div id="organizationName">
                <h2 style="text-align:center; padding-top:40px"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
            </div>
            <h3 style="text-align:center" id="reportTitle">Balance Sheet</h3>
            <h5 style="text-align:center" id="dateToDate">
                <?php if (isset($enddate)) {
                    echo "As on Date :- " . $enddate;
                }
                ?>
            </h5>
            <div class="row" style="margin-bottom: 5px">
                <div class="col-12">
                    <div class="pull-right">
                        <a id="Print" class="btn btn-danger print"></i>Print</a>
                        <a id='print' title="Print" class="btn btn-danger" href="balance_sheet_pdf.php?date=<?php echo $enddate; ?>"></i>PDF</a>
                        <a id='print' title="Print" class="btn btn-danger" href="balance_sheet_word.php?date=<?php echo $enddate; ?>"></i>docx</a>
                        <a id='print' title="Print" class="btn btn-danger" href="#"></i>Excel</a>
                        <a id='print' title="Print" class="btn btn-danger" href="#"></i>csv</a>
                    </div>
                </div>
            </div>
            <div id="mySelector">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-hover table-striped">
                            <thead class="reportHead" style="background-color: #138496;">
                                <tr style="text-align:center">
                                    <th colspan="4">Liabilities</th>
                                </tr>
                            </thead>
                            <tr>
                                <th>A/C HEAD</th>
                                <th>BALANCE</th>
                            </tr>
                            <tbody>
                                <?php
                                $sql1 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as Cr_amt, sum(tran_details.dr_amt_loc) as dr_amt, tran_details.tran_date, SUM(tran_details.cr_amt_loc - tran_details.dr_amt_loc) as balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date<= '$enddate'  group by gl_acc_code.parent_acc_code order by gl_acc_code.acc_code";
                                $query = $conn->query($sql1);
                                while ($rows = $query->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <?php
                                        if (($rows['category_code'] == 2) or ($rows['category_code'] == 5)) {
                                            $total_libility = ($total_libility + $rows['balance']);
                                            if ($rows['acc_level'] == 1) {
                                        ?>
                                                <td style="color:gray; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $rows['balance']; ?></td>
                                            <?php
                                            } elseif ($rows['acc_level'] == 2) {
                                            ?>
                                                <td style="text-indent: 20px;color:blue; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $rows['balance']; ?></td>
                                            <?php
                                            } elseif ($rows['acc_level'] == 3) {
                                            ?>
                                                <td style="text-indent: 30px;color:red;   font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right"> <?php echo $rows['balance']; ?></td>
                                            <?php
                                            } elseif ($rows['acc_level'] == 4) {
                                            ?>
                                                <td style="text-indent:  40px;color:green; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $rows['balance']; ?></td>
                                            <?php
                                            } else {
                                            ?>
                                                <td style="text-indent:  right 20px"><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $rows['balance']; ?></td>
                                            <?php
                                            }
                                            ?>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total Income</th>
                                    <th style="text-align: right"><strong><?php echo $income['balance']; ?></strong></th>
                                </tr>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total</th>
                                    <th style="text-align: right"><strong><?php echo ($total_libility + $income['balance']); ?></strong></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table table-hover table-striped">
                            <thead class="reportHead" style="background-color: #138496;">
                                <tr style="text-align:center">
                                    <th colspan="4">Assets</th>
                                </tr>
                            </thead>
                            <tr>
                                <th>A/C HEAD</th>
                                <th>BALANCE</th>
                            </tr>
                            <tbody>
                                <?php
                                $sql1 = "select gl_acc_code.acc_code, gl_acc_code.acc_head,tran_details.tran_date,gl_acc_code.category_code, gl_acc_code.parent_acc_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as Cr_amt, sum(tran_details.dr_amt_loc) as dr_amt, tran_details.tran_date, SUM(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date<= '$enddate' AND gl_acc_code.category_code = '1' group by gl_acc_code.parent_acc_code order by gl_acc_code.acc_code";
                                $query1 = $conn->query($sql1);
                                while ($row = $query1->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <?php
                                        if ($row['category_code'] == 1) {
                                            $total_asset = ($total_asset + $row['balance']);

                                            if ($row['acc_level'] == 1) {
                                        ?>
                                                <td style="color:gray; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $row['balance']; ?></td>
                                            <?php
                                            } elseif ($row['acc_level'] == 2) {
                                            ?>
                                                <td style="text-indent:20px;color:blue; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $row['balance']; ?></td>
                                            <?php
                                            } elseif ($row['acc_level'] == 3) {
                                            ?>
                                                <td style="text-indent:30px;color:red; right font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $row['balance']; ?></td>
                                            <?php
                                            } elseif ($row['acc_level'] == 4) {
                                            ?>
                                                <td style="text-indent:40px;color:green; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $row['balance']; ?></td>
                                            <?php
                                            } else {
                                            ?>
                                                <td style="text-indent:20px"><?php echo $row['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $row['balance']; ?></td>
                                            <?php
                                            }
                                            ?>
                                    <?php
                                        }
                                    }

                                    ?>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total Expances</th>
                                    <th style="text-align: right"><strong><?php echo $expense['balance']; ?></strong></th>
                                </tr>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total</th>
                                    <th style="text-align: right"><strong><?php echo ($total_asset + $expense['balance']); ?></strong></th>
                                </tr>
                            </tfoot>
                        <?php
                    } else {
                        echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select Date</h1>";
                    }
                        ?>
                        </table>
                    </div>
                </div>
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
<script>
    //===== seach box in select option start ========
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })

    //===== seach box in select option end ========
    $(document).ready(function() {
        $("#706000").addClass('active');
        $("#700000").addClass('active');
        $("#700000").addClass('is-expanded');
    });
</script>
</body>

</html>