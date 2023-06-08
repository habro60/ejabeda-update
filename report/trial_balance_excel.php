<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_GET['from']) && isset($_GET['to'])) {
    $startdate = $_GET['from'];
    $enddate = $_GET['to'];
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];
?>
    <div>
        <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
    </div>
    <div>
        <h4 style="text-align:center">Trial Balance Statement </h4>
        <h5 style="text-align:center">
            <?php
            if (!empty($startdate)) {
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
        <table width="100%" border="1" cellpadding="5" cellspacing="0">
            <tr class="active">
                <th>Account Number </th>
                <th>Account Head </th>
                <th>Debit Transction </th>
                <th>Crdit Transction</th>
            </tr>
            <tbody>
                <?php
                $sql = "SELECT tran_details.batch_no,tran_details.gl_acc_code,SUM(tran_details.dr_amt_loc) as dr_amt_loc ,tran_details.tran_date,tran_details.tran_mode,tran_details.description,SUM(tran_details.cr_amt_loc) as cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code  AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') GROUP BY tran_details.gl_acc_code ORDER BY tran_details.gl_acc_code";
                $query = $conn->query($sql);
                while ($rows = $query->fetch_assoc()) {
                    echo
                        '<tr>   
									<td>' . $rows['gl_acc_code'] . '</td>
                                    <td>' . $rows['acc_head'] . '</td>
									<td>' . $rows['dr_amt_loc'] . '</td>
									<td>' . $rows['cr_amt_loc'] . '</td>
								</tr>';
                }
                ?>
            </tbody>
            <tfoot>
                <?php
                $sql2 = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE (`tran_date` BETWEEN '$startdate' AND '$enddate') ORDER BY `tran_date`";
                $returnD = mysqli_query($conn, $sql2);
                $result = mysqli_fetch_assoc($returnD);
                ?>
                <tr class="text-right">
                    <td colspan="1"></td>
                    <td colspan="1">Grand Total</td>
                    <td style="text-align:left"><strong> TK. <?php echo $result['debit']; ?></strong>
                    </td>
                    <td style="text-align:left"><strong> TK. <?php echo $result['credit']; ?></strong>
                    </td>
                </tr>
            </tfoot>
        <?php
    }
        ?>
        </table>
        <?php
        $conn->close();
        ?>