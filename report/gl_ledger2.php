<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
$pid= 703000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require '../source/header.php';
require '../source/sidebar.php';
?>
<main class="app-content">
    <div class="app-title">
        <div style="width: 100%;">
            <h1><i class="fa fa-dashboard"></i> General Account Ledger 2</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="POST">
                <div>
                    <label for="">Account</label>
                    <select class="select2" name="account" id="accou" required>
                        <option value="">---Select---</option>
                        <?php
                        $selectQuery = 'SELECT * FROM `gl_acc_code`';
                        $selectQueryResult = $conn->query($selectQuery);
                        if ($selectQueryResult->num_rows) {
                            while ($row = $selectQueryResult->fetch_assoc()) {
                                echo '<option value="' . $row['acc_code'] . '">' . $row['acc_head'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <label for="">As on from</label>
                    <input type="date" name="startdate" value="<?php echo $startdate; ?>" required>
                    <label for="">To</label>
                    <input type="date" name="enddate" value="<?php echo $enddate; ?>" required>
                    <input type="submit" name="submit" id="submitBtn" class="btn-info" value="Report View">
                </div>
            </form>
            <?php
            $org_name = $_SESSION['org_name'];
            $org_logo = $_SESSION['org_logo'];
            ?>
            <div>
                <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
            </div>
            <div>
                <h4 style="text-align:center">General Ledger 2 Statement </h4>
                <h5 style="text-align:center"> Account :
                    <?php
                    if (isset($_POST['submit'])) {
                        $org_fin_year_st =  $_SESSION["org_fin_year_st"];
                        $account = $_POST['account'];
                        $startdate = $_POST['startdate'];
                        $enddate = $conn->escape_string($_POST['enddate']);
                        $open_bal = date('Y-m-d', strtotime($startdate . ' - 1 day'));
                        if (isset($account)) {
                            $selectAcc = "SELECT acc_code,acc_head FROM gl_acc_code WHERE acc_code= $account";
                            $result = mysqli_query($conn, $selectAcc);
                            $data = mysqli_fetch_assoc($result);
                        }
                        echo $data['acc_head'];
                    ?>
                </h5>
                <h5 style="text-align:center">
                    Form <?php
                            if (empty($startdate)) {
                                echo $_SESSION["org_fin_year_st"];
                            } else {
                                echo $startdate;
                            }
                            ?>
                    To <?php if (isset($enddate)) {
                            echo $enddate;
                        }
                        ?>
                </h5>
            </div>
            <div class="pull-right">
                <a id='print' title="Print" class="btn btn-danger" target="_blank" href="gl_ledger_print.php?account=<?php echo $account; ?>&from=<?php echo $startdate; ?>&to=<?php echo $enddate; ?>"></i>Print</a>
                <a id='print' title="Print" class="btn btn-danger" href="gl_ledger_pdf.php?account=<?php echo $account; ?>&from=<?php echo $startdate; ?>&to=<?php echo $enddate; ?>"></i>PDF</a>
                <a id='print' title="Print" class="btn btn-danger" href="gl_ledger_word.php?account=<?php echo $account; ?>&from=<?php echo $startdate; ?>&to=<?php echo $enddate; ?>"></i>docx</a>
                <a id='print' title="Print" class="btn btn-danger" href="jaurnal_excel.php?date=BETWEEN '<?php echo $startdate; ?>' AND '<?php echo $enddate; ?>'"></i>Excel</a>
                <a id='print' title="Print" class="btn btn-danger" href="jaurnal_csv.php?date=BETWEEN '<?php echo $startdate; ?>' AND '<?php echo $enddate; ?>'"></i>csv</a>
            </div>
            <br>
            <br>
            <table style="width:100%" border="1" id="showBtn">
                <thead>
                    <tr style="text-align:center">
                        <th>Date</th>
                        <th>Trx. Mode</th>
                        <th>Particular</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $op_bal=0;
                        $sql_opbal = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE gl_acc_code='$account' AND (`tran_date` BETWEEN '$org_fin_year_st' AND '$open_bal') ORDER BY `tran_date`";
                        $return_opbal = mysqli_query($conn, $sql_opbal);
                        $result_opbal = mysqli_fetch_assoc($return_opbal);
                    ?>
                    <tr style="font-weight:bold;color: red;text-align: right">
                        <td colspan="3">Opening Balance </td>
                        <td></td>
                        <td></td>
                        <td>
                            <?php echo $op_bal= ($result_opbal['credit'] - $result_opbal['debit']); ?>
                        </td>
                    </tr>
                    <?php
                    $total_dr = 0;
                    $total_cr = 0;
                    $run_bal=($result_opbal['credit'] - $result_opbal['debit']);;
                  
                        $sql = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code,tran_details.cr_amt_loc-tran_details.dr_amt_loc as balance, @RunningBalance:= @RunningBalance + (tran_details.cr_amt_loc-tran_details.dr_amt_loc) as RunningBalance  FROM tran_details JOIN gl_acc_code JOIN (SELECT @RunningBalance:= 0) r WHERE tran_details.gl_acc_code='$account' AND tran_details.gl_acc_code=gl_acc_code.acc_code AND (tran_details.tran_date BETWEEN '$org_fin_year_st' AND '$enddate') order by tran_details.tran_date, tran_details.tran_no";
                        $query = $conn->query($sql);
                        while ($rows = $query->fetch_assoc()) {
                            
                            if ($rows['tran_date'] >= $startdate) {
                                $total_dr = $total_dr + $rows['dr_amt_loc'];
                                $total_cr = $total_cr + $rows['cr_amt_loc'];
                                $run_bal = ($run_bal + $rows['cr_amt_loc'] - $rows['dr_amt_loc']);

                                echo  '<tr style="text-align:right">
                                <td>' . $rows['tran_date'] . '</td>
                                <td>' . $rows['tran_mode'] . '</td>
                                <td>' . $rows['description'] . '</td>
                                <td>' . $rows['dr_amt_loc'] . '</td>
                                <td>' . $rows['cr_amt_loc'] . '</td>
                                
                               <td><strong>' . $run_bal . '</strong></td>
                               
                            </tr>';
                            }
                        } ?>
                        <tr style="font-weight:bold" class="text-right">
                            <td colspan="3">Sub Total</td>
                            <td>TK.<?php echo $total_dr; ?></td>
                            <td>TK.<?php echo $total_cr; ?></td>
                            <td></td>
                        </tr>
                </tbody>
                <tfoot>
                <?php
                    } else {
                        echo "<h3 style='color:red;text-align:center'>Please Select Account and Date</h3>";
                    }
                ?>
                </tfoot>
            </table>
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
        $("#703000").addClass('active');
        $("#700000").addClass('active');
        $("#700000").addClass('is-expanded');
    });
</script>
</body>

</html>