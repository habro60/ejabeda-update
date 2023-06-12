<?php
require "../auth/auth.php";
require '../database.php';
if (isset($_GET['date'])) {
    $enddate = $_GET['date'];
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];
    $timestamp = time();
    $filename = 'balance_sheet_word-' . $timestamp . '.doc';
    header("Content-type: application/vnd.ms-word");
    // header("Content-Disposition: attachment;Filename=" . rand() . ".doc");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
    <div>
        <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
    </div>
    <h3 style="text-align:center">Balance Sheet</h3>
    <h5 style="text-align:center">As On Date <?php if (isset($enddate)) {
                                                    echo $enddate;
                                                } ?>
    </h5>
    <div style="width: 100%;height: 100%;">
        <div style="float: left;width: 50%;height: auto;">
            <table border="1" width="100%" cellpadding="5" cellspacing="0">
                <thead>
                    <tr style="text-align:center">
                        <th colspan="4">Liabilities</th>
                    </tr>
                    <tr>
                        <th>A/C HEAD</th>
                        <th>BALANCE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql1 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as Cr_amt, sum(tran_details.dr_amt_loc) as dr_amt, tran_details.tran_date, SUM(tran_details.cr_amt_loc - tran_details.dr_amt_loc) as balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddate'  AND gl_acc_code.category_code = '2' group by gl_acc_code.parent_acc_code order by gl_acc_code.acc_code";
                    $query = $conn->query($sql1);
                    while ($rows = $query->fetch_assoc()) {
                    ?>
                        <tr>
                            <?php
                            if ($rows['category_code'] == 2) {
                                if ($rows['acc_level'] == 1) {
                            ?>
                                    <td style="color:gray; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                    <td><?php echo $rows['balance']; ?></td>
                                <?php
                                } elseif ($rows['acc_level'] == 2) {
                                ?>
                                    <td style="text-indent:20px;color:blue; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                    <td><?php echo $rows['balance']; ?></td>
                                <?php
                                } elseif ($rows['acc_level'] == 3) {
                                ?>
                                    <td style="text-indent:30px;color:red; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                    <td><?php echo $rows['balance']; ?></td>
                                <?php
                                } elseif ($rows['acc_level'] == 4) {
                                ?>
                                    <td style="text-indent:40px;color:green; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                    <td><?php echo $rows['balance']; ?></td>
                                <?php
                                } else {
                                ?>
                                    <td style="text-indent:20px"><?php echo $rows['acc_head']; ?></td>
                                    <td><?php echo $rows['balance']; ?></td>
                                <?php
                                }
                                ?>
                        <?php
                            }
                        }
                        ?>
                        </tr>
                        <?php
                        $sql_total_libility = "select gl_acc_code.acc_code, gl_acc_code.acc_head,tran_details.tran_date,gl_acc_code.category_code, gl_acc_code.parent_acc_code,tran_details.gl_acc_code,tran_details.tran_date, SUM(tran_details.cr_amt_loc- tran_details.dr_amt_loc) as total_balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddate' AND gl_acc_code.category_code = '2' order by gl_acc_code.acc_code";
                        $query_total_libility = mysqli_query($conn, $sql_total_libility);
                        $total_libility = mysqli_fetch_assoc($query_total_libility);
                        ?>
                        <tr>
                            <td colspan="1" style="text-align: right"> Total</td>
                            <td style="text-align: right"><strong><?php echo $total_libility['total_balance']; ?></strong></td>
                        </tr>

            </table>
        </div>
        <div style="float: right;width: 50%;height: auto;">
            <table border="1" width="100%" cellpadding="5" cellspacing="0">
                <thead>
                    <tr style="text-align:center">
                        <th colspan="4">Asset</th>
                    </tr>
                    <tr>
                    <th>A/C HEAD</th>
                        <th>BALANCE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql1 = "select gl_acc_code.acc_code, gl_acc_code.acc_head,tran_details.tran_date,gl_acc_code.category_code, gl_acc_code.parent_acc_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as Cr_amt, sum(tran_details.dr_amt_loc) as dr_amt, tran_details.tran_date, SUM(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddate' AND gl_acc_code.category_code = '1' group by gl_acc_code.parent_acc_code order by gl_acc_code.acc_code";
                    $query1 = $conn->query($sql1);
                    while ($row = $query1->fetch_assoc()) {
                    ?>
                        <tr>
                            <?php
                            if ($row['category_code'] == 1) {
                                if ($row['acc_level'] == 1) {
                            ?>
                                    <td style="color:gray; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                    <td><?php echo $row['balance']; ?></td>
                                <?php
                                } elseif ($rows['acc_level'] == 2) {
                                ?>
                                    <td style="text-indent:20px;color:blue; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                    <td><?php echo $row['balance']; ?></td>
                                <?php
                                } elseif ($row['acc_level'] == 3) {
                                ?>
                                    <td style="text-indent:30px;color:red; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                    <td><?php echo $row['balance']; ?></td>
                                <?php
                                } elseif ($row['acc_level'] == 4) {
                                ?>
                                    <td style="text-indent:40px;color:green; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                    <td><?php echo $row['balance']; ?></td>
                                <?php
                                } else {
                                ?>
                                    <td style="text-indent:20px"><?php echo $row['acc_head']; ?></td>
                                    <td><?php echo $row['balance']; ?></td>
                                <?php
                                }
                                ?>
                        <?php
                            }
                        }

                        ?>
                        </tr>

                        <?php
                        $sql_total_asset = "select gl_acc_code.acc_code, gl_acc_code.acc_head,tran_details.tran_date,gl_acc_code.category_code, gl_acc_code.parent_acc_code,tran_details.gl_acc_code,tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as total_balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddate' AND gl_acc_code.category_code = '1' order by gl_acc_code.acc_code";
                        $query_total_asset = $conn->query($sql_total_asset);
                        $total_asset = $query_total_asset->fetch_assoc();
                        ?>

                        <tr>
                            <td colspan="1" style="text-align: right"> Total</td>
                            <td style="text-align: right"><strong><?php echo $total_asset['total_balance']; ?></strong></td>
                        </tr>
                    <?php
                }
                    ?>
            </table>
        </div>
    </div>