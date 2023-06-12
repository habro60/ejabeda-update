<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_GET['date'])) {
    $enddate = $_GET['date'];
    $enddateexp = $_GET['date'];
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];
    $q = $_SESSION['org_rep_footer1'];
    $b = $_SESSION['org_rep_footer2'];
    $timestamp = time();
    $filename = 'profit_loss_word-' . $timestamp . '.doc';
    header("Content-type: application/vnd.ms-word");
    // header("Content-Disposition: attachment;Filename=" . rand() . ".doc");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");
?>
    <div>
        <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
    </div>
    <div>
        <h4 style="text-align:center">Profit And Loss Statement</h4>
        <h5 style="text-align:center">
            <?php

            if (isset($enddate)) {
                echo $enddate;
            }
            ?>
        </h5>
    </div>
    <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr style="text-align:center;width:100%">
                <th>Total Income</th>
                <th>Total Expense</th>
                <th>Total Profit</th>
                <th>Total loss</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_inc = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as balance FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddate' AND gl_acc_code.category_code = '3' group by gl_acc_code.category_code
                        ";
            $query_inc = $conn->query($sql_inc);
            $rows_inc = $query_inc->fetch_assoc();
            ?>
            <tr style="text-align:center">
                <td style="width:25%;height: 100px;background-color: red"><strong> <?php echo  $rows_inc['cr_amt_loc']; ?></strong></td>
                <td style="width:25%;height: 100px;background-color: green"><strong><?php echo  $rows_inc['cr_amt_loc']; ?></strong></td>
                <td style="width:25%;height: 100px;background-color: gray"><strong><?php echo  $rows_inc['cr_amt_loc']; ?></strong></td>
                <?php
                $sql_exp = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as balance FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddateexp' AND gl_acc_code.category_code = '4' group by gl_acc_code.category_code
                        ";
                $query_exp = $conn->query($sql_exp);
                $rows_exp = $query_exp->fetch_assoc();
                ?>
                <td style="width:25%;height: 100px;background-color: yellow"><strong><?php echo  $rows_exp['dr_amt_loc']; ?></strong></td>
            </tr>

        </tbody>
    </table>
    <div style='padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><strong><?php echo $q;?></strong></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><strong><?php echo $b;?></strong></div></div>
<?php
} 
?>