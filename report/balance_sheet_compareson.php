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
$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>


<main class="app-content">
    <div class="app-title">
        <div style="width: 100%;">
            <h1><i class="fa fa-dashboard"></i>Current And Previous Balance Sheet </h1>
        </div>

        <div class="pull-right">
            <!--<a id="Print" class="btn btn-danger print"></i>Print</a>-->
            <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
        </div>
    </div>
    <form method="POST">
        <table id="form_class_id" class="table-responsive table-striped">
            <thead>
                <th>Office</th>
                <th>Current Year Up to Month</th>
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
            // $pre_date = $conn->escape_string($_POST['pre_date']);
           $time = new DateTime($enddate);
           $pre_date = $time->modify('-1 year')->format('Y-m-d');
                        echo $enddate;

            // echo $newtime;
            // die;

            //    Income & expanse ====================

            $query1 = "SELECT tran_details.tran_date, tran_details.gl_acc_code, sum(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as dr_balance, gl_acc_code.category_code FROM `tran_details`,gl_acc_code  WHERE tran_details.tran_date <= '$enddate'and gl_acc_code.category_code='4' and gl_acc_code.acc_code=tran_details.gl_acc_code";
            $returnD = mysqli_query($conn, $query1);

            $curr_expense = mysqli_fetch_assoc($returnD);

            $query2 = "SELECT tran_details.tran_date, tran_details.gl_acc_code,sum(tran_details.cr_amt_loc - tran_details.dr_amt_loc) as cr_balance,  gl_acc_code.category_code FROM `tran_details`,gl_acc_code  WHERE tran_details.tran_date <= '$enddate'and gl_acc_code.category_code='3' and gl_acc_code.acc_code=tran_details.gl_acc_code";
            $returnIncome = mysqli_query($conn, $query2);
            $curr_income = mysqli_fetch_assoc($returnIncome);

            //    Income & expanse for Previous_date ====================

            $query_pre_date = "SELECT tran_details.tran_date, tran_details.gl_acc_code, sum(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as dr_balance, gl_acc_code.category_code FROM `tran_details`,gl_acc_code  WHERE tran_details.tran_date <= '$pre_date'and gl_acc_code.category_code='4' and gl_acc_code.acc_code=tran_details.gl_acc_code";
            $query_pre_date_returnD = mysqli_query($conn, $query_pre_date);

            $prev_expense = mysqli_fetch_assoc($query_pre_date_returnD);

            $query2_query_pre_date = "SELECT tran_details.tran_date, tran_details.gl_acc_code,sum(tran_details.cr_amt_loc - tran_details.dr_amt_loc) as cr_balance,  gl_acc_code.category_code FROM `tran_details`,gl_acc_code  WHERE tran_details.tran_date <= '$pre_date'and gl_acc_code.category_code='3' and gl_acc_code.acc_code=tran_details.gl_acc_code";
            $query_pre_date_returnIncome = mysqli_query($conn, $query2_query_pre_date);
            $prev_income = mysqli_fetch_assoc($query_pre_date_returnIncome);




            //   end income and expanse  ==============

            $org_name    = $_SESSION['org_name'];
            $org_addr1 = $_SESSION['org_addr1'];
            $org_email = $_SESSION['org_email'];
            $org_tel = $_SESSION['org_tel'];
            $org_logo    = $_SESSION['org_logo'];

            $org_fin_month =  $_SESSION["org_fin_month"];

            //total Liability for as on Date
            $total_libility = $total_asset = 0;
            $sql1 = "CREATE or REPLACE VIEW view_curr_balance_sheet AS SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, gl_acc_code.parent_acc_code, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as Cr_amt, sum(tran_details.dr_amt_loc) as dr_amt, tran_details.tran_date, SUM(tran_details.cr_amt_loc - tran_details.dr_amt_loc) as liab_balance, SUM(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as asst_balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date<= '$enddate'  group by gl_acc_code.parent_acc_code order by gl_acc_code.acc_code";
            $curr_query = $conn->query($sql1);



            $total_libility_pre_date = $total_libility_pre_date = 0;
            $sql2 = "CREATE or REPLACE VIEW view_prev_balance_sheet AS SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, gl_acc_code.parent_acc_code, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as Cr_amt, sum(tran_details.dr_amt_loc) as dr_amt, tran_details.tran_date, SUM(tran_details.cr_amt_loc - tran_details.dr_amt_loc) as liab_balance, SUM(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as asst_balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date<= '$pre_date'  group by gl_acc_code.parent_acc_code order by gl_acc_code.acc_code";

            $prev_query = $conn->query($sql2);

        ?>
            <div>

                <h4 style="text-align:center; margin-top:60px;"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;margin-right:10px;"><?php echo $org_name; ?></h4>
            </div>
            <div id="organizationAdd">
                <p style="text-align:center"> <?php echo $org_addr1;
                                                echo ",<br> ";
                                                echo  "E-Mail:";
                                                echo $org_email;
                                                echo ", ";
                                                echo "Tele:";
                                                echo $org_tel; ?></p>
            </div>



            <div>
                <div>
                    <div id="reporttitle">
                        <h6 style="text-align:center" id="reportTitle"> Current And Previous Balance Sheet</h6>
                    </div>




                    </p>
                </div>
            </div>

            <br><br>

            <div id="mySelector">
                <div class="row">

                <!-- first -->


                <div class="col-6">
                        <table id="sampleTable">
                            <thead class="reportHead" style="background-color: #138496;">
                                <tr style="text-align:center">
                                    <th colspan="4">
                                        <h3>Liabilities For Year <?php echo date('Y ', strtotime($enddate)); ?></h3>
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                                <th style="text-align:left;width:5%;">A/C HEAD</th>
                                <th style="text-align:right;width:5%;">BALANCE IN (TK)</th>
                            </tr>
                            <tr>
                                <th>
                                    <hr>
                                </th>
                                <th>
                                    <hr>
                                </th>
                            </tr>
                            <tbody>
                            <?php
                            
                            $set_query="SET SQL_BIG_SELECTS=1";
                             $query = $conn->query("SET SQL_BIG_SELECTS=1");

                                $as_on_date = "SELECT view_curr_balance_sheet.category_code,view_curr_balance_sheet.acc_level,view_curr_balance_sheet.parent_acc_code, view_curr_balance_sheet.Cr_amt,view_curr_balance_sheet.dr_amt,view_curr_balance_sheet.liab_balance, gl_acc_code.acc_head,view_prev_balance_sheet.liab_balance AS previous_liab_balance FROM `view_curr_balance_sheet`,view_prev_balance_sheet, gl_acc_code where view_curr_balance_sheet.parent_acc_code=gl_acc_code.id AND view_prev_balance_sheet.parent_acc_code=gl_acc_code.id  ORDER BY view_curr_balance_sheet.category_code,view_curr_balance_sheet.acc_level,view_curr_balance_sheet.parent_acc_code";


                                $query = $conn->query($as_on_date);
                                //    $as_on_date_query = $conn->query($as_on_date);
                                while ($curr_rows = $query->fetch_assoc()) {
                                ?>
                                    <tr>
                                    <?php
                                        if (($curr_rows['category_code'] == 2) or ($curr_rows['category_code'] == 5)) {
                                            $total_libility = ($total_libility + $curr_rows['liab_balance']);


                                            if ($curr_rows['acc_level'] == 1) {
                                        ?>
                                                <td style="text-align:right;">
                                                    <hr>
                                                </td>
                                                <td style="color:gray; font-weight:bold;"><?php echo $curr_rows['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right;"><?php echo $curr_rows['liab_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($curr_rows['acc_level'] == 2) {
                                            ?>
                                                <td style="text-indent:20px;color:blue; font-weight:bold;"><?php echo $curr_rows['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $curr_rows['liab_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($curr_rows['acc_level'] == 3) {
                                            ?>
                                                <td style="text-indent:40px;color:red; right font-weight:bold; "><?php echo $curr_rows['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $curr_rows['liab_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($curr_rows['acc_level'] == 4) {
                                            ?>
                                                <td style="text-indent:60px;color:green; font-weight:bold; "><?php echo $curr_rows['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $curr_rows['liab_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } else {
                                            ?>
                                                <td style="text-indent:20px; "><?php echo $curr_rows['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $curr_rows['liab_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
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
                                    <th colspan="1" style="text-align: right"> Total Liabilities</th>


                                    <th style="text-align: right"><strong><?php echo number_format($total_libility, 2, '.', ','); ?></strong></th>
                                </tr>

                                <tr>
                                    <th colspan="1" style="text-align: right"> Total Income</th>


                                    <th style="text-align: right"><strong><?php echo number_format($curr_income['cr_balance'], 2, '.', ','); ?></strong></th>
                                </tr>
                                <tr>
                                    <th colspan="1" style="text-align: right">Grand Total</th>

                                    <th style="text-align: right"><strong><?php echo number_format(($total_libility + $curr_income['cr_balance']), 2, '.', ',');  ?></strong></th>



                                </tr>


                            </tfoot>

                        </table>

                    </div>

                    <div class="col-6">
                        <table id="sampleTable">
                            <thead class="reportHead" style="background-color: #138496;">
                                <tr style="text-align:center">
                                    <th colspan="4">
                                        <h3>Liabilities For Year <?php echo date('Y ', strtotime($pre_date)); ?></h3>
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                                <th style="text-align:left;width:5%;">A/C HEAD</th>
                                <th style="text-align:right;width:5%;">BALANCE IN (TK)</th>
                            </tr>
                            <tr>
                                <th>
                                    <hr>
                                </th>
                                <th>
                                    <hr>
                                </th>
                            </tr>
                            <tbody>
                            <?php
                                    $as_on_date = "SELECT view_prev_balance_sheet.category_code,view_prev_balance_sheet.acc_level,view_prev_balance_sheet.parent_acc_code, view_prev_balance_sheet.Cr_amt,view_prev_balance_sheet.dr_amt,view_prev_balance_sheet.liab_balance, gl_acc_code.acc_head,view_prev_balance_sheet.liab_balance AS previous_liab_balance FROM `view_prev_balance_sheet`, gl_acc_code where view_prev_balance_sheet.parent_acc_code=gl_acc_code.id  ORDER BY view_prev_balance_sheet.category_code,view_prev_balance_sheet.acc_level,view_prev_balance_sheet.parent_acc_code";




                                    $query = $conn->query($as_on_date);
                                    //    $as_on_date_query = $conn->query($as_on_date);
                                    while ($prev_rows = $query->fetch_assoc()) {
                                    ?>
                                    <tr>
                                    <?php
                                            if (($prev_rows['category_code'] == 2) or ($prev_rows['category_code'] == 5)) {
                                                $total_libility = ($total_libility + $prev_rows['liab_balance']);


                                                if ($prev_rows['acc_level'] == 1) {
                                            ?>
                                                <td style="text-align:right;">
                                                    <hr>
                                                </td>
                                                <td style="color:gray; font-weight:bold;"><?php echo $prev_rows['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right;"><?php echo $prev_rows['liab_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($prev_rows['acc_level'] == 2) {
                                            ?>
                                                <td style="text-indent:20px;color:blue; font-weight:bold;"><?php echo $prev_rows['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $prev_rows['liab_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($prev_rows['acc_level'] == 3) {
                                            ?>
                                                <td style="text-indent:40px;color:red; right font-weight:bold; "><?php echo $prev_rows['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $prev_rows['liab_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($prev_rows['acc_level'] == 4) {
                                            ?>
                                                <td style="text-indent:60px;color:green; font-weight:bold; "><?php echo $prev_rows['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $prev_rows['liab_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } else {
                                            ?>
                                                <td style="text-indent:20px; "><?php echo $prev_rows['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $prev_rows['liab_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
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
                                        <th colspan="1" style="text-align: right"> Total Liabilities </th>


                                        <th style="text-align: right"><strong><?php echo number_format($total_libility, 2, '.', ','); ?></strong></th>
                                    </tr>
                                    <tr>
                                        <th colspan="1" style="text-align: right"> Total Income</th>


                                        <th style="text-align: right"><strong><?php echo number_format($prev_income['cr_balance'], 2, '.', ','); ?></strong></th>
                                    </tr>
                                    <tr>
                                        <th colspan="1" style="text-align: right">Grand Total</th>

                                        <th style="text-align: right"><strong><?php echo number_format(($total_libility + $prev_income['cr_balance']), 2, '.', ',');  ?></strong></th>



                                    </tr>


                                </tfoot>

                        </table>

                    </div>

                <!-- first -->

                    <!-- assect -->

                    <div style="margin-top: 70px;" class="col-6">
                        <table id="sampleTable">
                            <thead class="reportHead" style="background-color: #138496;">
                                <tr style="text-align:center">
                                    <th colspan="4">
                                        <h3>Assets For Year <?php echo date('Y ', strtotime($enddate)); ?></h3>
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                                <th style="text-align:left;width:5%;">A/C HEAD</th>
                                <th style="text-align:right;width:5%;">BALANCE IN (TK)</th>
                            </tr>
                            <tr>
                                <th>
                                    <hr>
                                </th>
                                <th>
                                    <hr>
                                </th>
                            </tr>
                            <tbody>
                                <?php
                                $sql1 = "SELECT view_curr_balance_sheet.category_code,view_curr_balance_sheet.acc_level,view_curr_balance_sheet.parent_acc_code, view_curr_balance_sheet.Cr_amt,view_curr_balance_sheet.dr_amt,view_curr_balance_sheet.asst_balance, gl_acc_code.acc_head FROM `view_curr_balance_sheet`, gl_acc_code where view_curr_balance_sheet.parent_acc_code=gl_acc_code.id order  by view_curr_balance_sheet.category_code,view_curr_balance_sheet.acc_level,view_curr_balance_sheet.parent_acc_code";
                                $query1 = $conn->query($sql1);
                                while ($row = $query1->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <?php
                                        if ($row['category_code'] == 1) {
                                            $total_asset = ($total_asset + $row['asst_balance']);

                                            if ($row['acc_level'] == 1) {
                                        ?>
                                                <td style="text-align:right;">
                                                    <hr>
                                                </td>
                                                <td style="color:gray; font-weight:bold;"><?php echo $row['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right;"><?php echo $row['asst_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($row['acc_level'] == 2) {
                                            ?>
                                                <td style="text-indent:20px;color:blue; font-weight:bold;"><?php echo $row['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $row['asst_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($row['acc_level'] == 3) {
                                            ?>
                                                <td style="text-indent:40px;color:red; right font-weight:bold; "><?php echo $row['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $row['asst_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($row['acc_level'] == 4) {
                                            ?>
                                                <td style="text-indent:60px;color:green; font-weight:bold; "><?php echo $row['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $row['asst_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } else {
                                            ?>
                                                <td style="text-indent:20px; "><?php echo $row['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $row['asst_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
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
                                    <th colspan="1" style="text-align: right"> Total Assect</th>
                                    <th style="text-align: right"><strong><?php echo number_format($total_asset, 2, '.', ','); ?></strong></th>
                                </tr>

                                <tr>
                                    <th colspan="1" style="text-align: right"> Total Expances</th>
                                    <th style="text-align: right"><strong><?php echo number_format($curr_expense['dr_balance'], 2, '.', ','); ?></strong></th>
                                </tr>
                                <tr>
                                    <th colspan="1" style="text-align: right">Grand Total</th>
                                    <th style="text-align: right"><strong><?php echo number_format(($total_asset + $curr_expense['dr_balance']), 2, '.', ','); ?></strong></th>
                                </tr>
                            </tfoot>

                        </table>

                    </div>

                    <div style="margin-top: 70px;" class="col-6">
                        <table id="sampleTable">
                            <thead class="reportHead" style="background-color: #138496;">
                                <tr style="text-align:center">
                                    <th colspan="4">
                                        <h3>Assets For Year <?php echo date('Y ', strtotime($pre_date)); ?></h3>
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                                <th style="text-align:left;width:5%;">A/C HEAD</th>
                                <th style="text-align:right;width:5%;">BALANCE IN (TK)</th>
                            </tr>
                            <tr>
                                <th>
                                    <hr>
                                </th>
                                <th>
                                    <hr>
                                </th>
                            </tr>
                            <tbody>
                                <?php
                                $sql1 = "SELECT view_prev_balance_sheet.category_code,view_prev_balance_sheet.acc_level,view_prev_balance_sheet.parent_acc_code, view_prev_balance_sheet.Cr_amt,view_prev_balance_sheet.dr_amt,view_prev_balance_sheet.asst_balance, gl_acc_code.acc_head FROM `view_prev_balance_sheet`, gl_acc_code where view_prev_balance_sheet.parent_acc_code=gl_acc_code.id order  by view_prev_balance_sheet.category_code,view_prev_balance_sheet.acc_level,view_prev_balance_sheet.parent_acc_code";
                                $query1 = $conn->query($sql1);
                                while ($row = $query1->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <?php
                                        if ($row['category_code'] == 1) {
                                            $total_asset = ($total_asset + $row['asst_balance']);

                                            if ($row['acc_level'] == 1) {
                                        ?>
                                                <td style="text-align:right;">
                                                    <hr>
                                                </td>
                                                <td style="color:gray; font-weight:bold;"><?php echo $row['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right;"><?php echo $row['asst_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($row['acc_level'] == 2) {
                                            ?>
                                                <td style="text-indent:20px;color:blue; font-weight:bold;"><?php echo $row['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $row['asst_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($row['acc_level'] == 3) {
                                            ?>
                                                <td style="text-indent:40px;color:red; right font-weight:bold; "><?php echo $row['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $row['asst_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } elseif ($row['acc_level'] == 4) {
                                            ?>
                                                <td style="text-indent:60px;color:green; font-weight:bold; "><?php echo $row['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $row['asst_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
                                            <?php
                                            } else {
                                            ?>
                                                <td style="text-indent:20px; "><?php echo $row['acc_head']; ?>
                                                    <hr>
                                                </td>
                                                <td style="text-align: right"><?php echo $row['asst_balance'] ?? 0.00; ?>
                                                    <hr>
                                                </td>
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
                                    <th colspan="1" style="text-align: right"> Total Assect</th>
                                    <th style="text-align: right"><strong><?php echo number_format($total_asset, 2, '.', ','); ?></strong></th>
                                </tr>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total Expances</th>
                                    <th style="text-align: right"><strong><?php echo number_format($prev_expense['dr_balance'], 2, '.', ','); ?></strong></th>
                                </tr>
                                <tr>
                                    <th colspan="1" style="text-align: right">Grand Total</th>
                                    <th style="text-align: right"><strong><?php echo number_format(($total_asset + $prev_expense['dr_balance']), 2, '.', ','); ?></strong></th>
                                </tr>
                            </tfoot>

                        </table>

                    </div>



                </div>







                <div style='padding:80px'>
                    <div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $q; ?></div>


                    <div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $b; ?></div>
                </div>
            </div>
    </div>

    <?php $today = date('d-m-Y'); ?>

    <div style='padding:40px;'>
        <span><b>Prepared By:</b> <?php echo $_SESSION['username']; ?> </span>
        <span><b>Date:</b> <?php echo $today; ?> </span>
    </div>

<?php
        } else {
            echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select Date</h1>";
        }
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
<script src="../js/custom.js"></script>
<!-- data table -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<!-- print this js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>
<!--  -->



<script>
    $(document).ready(function() {

        $("#print").click(function() {

            // alert('sdsd');
            $("#form_class_id").hide();
        });
    });
</script>


</body>

</html>