<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
$pid = 702000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require '../source/header.php';
require '../source/sidebar.php';
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Transaction</h1>
        </div>
    </div>
    <table>
        <form method="POST">
            <tr>
                <td> As on date: <input type="date" name="startdate" id="" required></td>
                <td> From: <input type="date" name="enddate" id="" required></td>
                <td> <input type="submit" name="submit" value="Submit" id="dateSubmit"></td>
        </form>
    </table>
    <?php
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];
    ?>
    <div>
        <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
    </div>
    <div>
        <h4 style="text-align:center">Transaction Statement </h4>
        <?php
        if (isset($_POST['submit'])) {
            $startdate = $_POST['startdate'];
            $enddate = $conn->escape_string($_POST['enddate']);
        ?>
            <h5 style="text-align:center">
                <?php
                if (empty($startdate)) {
                    echo $_SESSION["org_fin_month"];
                } else {
                    echo $startdate;
                }
                ?>
                To <?php if (isset($enddate)) {
                        echo $enddate;
                    }
                    ?>
            </h5>
            <div class="pull-right">
                <a id='print' title="Print" class="btn btn-danger" target="_blank" href="trial_balance_print.php?from=<?php echo $startdate; ?>&to=<?php echo $enddate; ?>"></i>Print</a>
                <a id='print' title="Print" class="btn btn-danger" href="trial_balance_pdf.php?from=<?php echo $startdate; ?>&to=<?php echo $enddate; ?>"></i>PDF</a>
                <a id='print' title="Print" class="btn btn-danger" href="trial_balance_word.php?from=<?php echo $startdate; ?>&to=<?php echo $enddate; ?>"></i>docx</a>
                <a id='print' title="Print" class="btn btn-danger" href="#"></i>Excel</a>
                <a id='print' title="Print" class="btn btn-danger" href="#"></i>csv</a>
            </div>
            <table class="table table-hover">
                <tr class="active" align="right">
                    <th>A/C Number </th>
                    <th>A/C Head </th>
                    <th>Debit </th>
                    <th>Credit</th>
                    <th>Balance</th>
                </tr>
                <tbody>
                    <?php
                    $op_bal = 0;
                    $sql_opbal = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE (`tran_date` BETWEEN '$startdate' AND '$enddate') ORDER BY `tran_date`";
                    $return_opbal = mysqli_query($conn, $sql_opbal);
                    $result_opbal = mysqli_fetch_assoc($return_opbal);
                    ?>
                    <tr style="font-weight:bold;color: red;text-align: right">
                        <td colspan="2">Opening Balance </td>
                        <td></td>
                        <td></td>
                        <td>
                            <?php echo $op_bal = ($result_opbal['credit'] - $result_opbal['debit']); ?>
                        </td>
                    </tr>
                    <?php
                    $balance_dr = 0;
                    $balance_cr = 0;
                    $run_bal=($result_opbal['credit'] - $result_opbal['debit']);
                    $sql = "SELECT tran_details.batch_no,tran_details.gl_acc_code,SUM(tran_details.dr_amt_loc) as dr_amt_loc ,tran_details.tran_date,tran_details.tran_mode,tran_details.description,SUM(tran_details.cr_amt_loc) as cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code  AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') GROUP BY tran_details.gl_acc_code ORDER BY tran_details.gl_acc_code";

                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                        $balance_dr = $balance_dr + $rows['dr_amt_loc'];
                        $balance_cr = $balance_cr + $rows['cr_amt_loc'];
                        $run_bal = ($run_bal + $rows['cr_amt_loc'] - $rows['dr_amt_loc']);
                        echo
                            '<tr>
									<td>' . $rows['gl_acc_code'] . '</td>
                                    <td>' . $rows['acc_head'] . '</td>
									<td style="text-align:right">' . $rows['dr_amt_loc'] . '</td>
									<td style="text-align:right">' . $rows['cr_amt_loc'] . '</td>
                                    <td style="text-align:right"><strong>' . $run_bal . '</strong></td>
							</tr>';
                    }
                    echo '<tr style="text-align:right; color:green; font-weight: bold; font-size: 16px">
                                	<td></td>
                                    <td>Total</td>
									<td>TK ' . $balance_dr . '</td>
                                    <td>TK ' . $balance_cr . '</td>
									
							</tr>';
                    ?>

                </tbody>
            <?php
        } else {
            echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select From Date and To Date</h1>";
        }
            ?>
            </table>
            <?php
            $conn->close();
            ?>
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

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#702000").addClass('active');
        $("#700000").addClass('active');
        $("#700000").addClass('is-expanded');

        $("#showDate").hide();
        $("#dateSubmit").click(function() {
            $("#showDate").show(1000);
        });
    });
</script>
</body>

</html>