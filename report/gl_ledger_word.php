<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_GET["account"]) && isset($_GET["from"]) && isset($_GET["to"])) {
    $account = $_GET["account"];
    $startdate = $_GET["from"];
    $enddate = $_GET["to"];
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];
    $timestamp = time();
    $filename = 'gl_ledger_word-' . $timestamp . '.doc';
    header("Content-type: application/vnd.ms-word");
    // header("Content-Disposition: attachment;Filename=" . rand() . ".doc");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
    <div>
        <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
    </div>
    <h4 style="text-align:center">General Ledger Statement </h4>
    <h5 style="text-align:center"> Account :
        <?php
        if (isset($account)) {
            $selectAcc = "SELECT acc_code,acc_head FROM gl_acc_code WHERE acc_code= $account";
            $result = mysqli_query($conn, $selectAcc);
            $data = mysqli_fetch_assoc($result);
        }
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
    </div>
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
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
            $org_fin_year_st =  $_SESSION["org_fin_year_st"];
            $open_bal = date('Y-m-d', strtotime($startdate . ' - 1 day'));
            $sql_opbal = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE gl_acc_code='$account' AND (`tran_date` BETWEEN '$org_fin_year_st' AND '$open_bal') ORDER BY `tran_date`";
            $return_opbal = mysqli_query($conn, $sql_opbal);
            $result_opbal = mysqli_fetch_assoc($return_opbal);
            ?>
            <tr style="font-weight:bold;color: red;text-align: right">
                <td colspan="3">Opening Balance </td>
                <td><?php echo $result_opbal['debit']; ?></td>
                <td><?php echo $result_opbal['credit']; ?></td>
                <td>
                    <?php echo $result_opbal['credit'] - $result_opbal['debit']; ?>
                </td>
            </tr>
            <?php
            $sql = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code,tran_details.cr_amt_loc-tran_details.dr_amt_loc as balance, @RunningBalance:= @RunningBalance + (tran_details.cr_amt_loc-tran_details.dr_amt_loc) as RunningBalance  FROM tran_details JOIN gl_acc_code JOIN (SELECT @RunningBalance:= 0) r WHERE tran_details.gl_acc_code='$account' AND tran_details.gl_acc_code=gl_acc_code.acc_code AND (tran_details.tran_date BETWEEN '$org_fin_year_st' AND '$enddate') order by tran_details.batch_no";
            $query = $conn->query($sql);
            while ($rows = $query->fetch_assoc()) {
                // $a = $rows['tran_date'];
                if ($rows['tran_date'] >= $startdate) {
                    echo
                        '<tr style="text-align:right">
                                <td>' . $rows['tran_date'] . '</td>
                                <td>' . $rows['tran_mode'] . '</td>
                                <td>' . $rows['description'] . '</td>
                                <td>' . $rows['dr_amt_loc'] . '</td>
                                <td>' . $rows['cr_amt_loc'] . '</td>
                           <td><strong>' . $rows['RunningBalance'] . '</strong></td>
                            </tr>';
                }
            } ?>
        </tbody>
        <tfoot>
            <?php
            $sql2 = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE gl_acc_code='$account' AND (`tran_date` BETWEEN '$org_fin_year_st' AND '$enddate') ORDER BY `tran_date`";
            $returnD = mysqli_query($conn, $sql2);
            $result = mysqli_fetch_assoc($returnD); ?>
            <tr class="text-right">
                <td colspan="3"><strong>Total</strong></td>
                <td><strong> TK. <?php echo $result['debit']; ?></strong>
                </td>
                <td><strong> TK. <?php echo $result['credit']; ?></strong>
                </td>
                <td><strong> TK. <?php echo $result['credit'] - $result['debit']; ?></strong>
                </td>
            </tr>
        </tfoot>
    </table>
    <br>
    <br>
    <br>
    <br>
    <div style="text-align: right; margin-right:50px; margin-top:0px">
        <label>--------------------------------</label><br>
        <label for="">Sign by Authorized officer</label>
    </div>
<?php } ?>
</body>

</html>