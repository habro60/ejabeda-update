<?php
    require "../auth/auth.php";
    if (isset($_GET['from']) && isset($_GET['to'])) {
    $timestamp = time();
    $filename = 'inc_exp_word-' . $timestamp . '.doc';
    header("Content-type: application/vnd.ms-word");
    // header("Content-Disposition: attachment;Filename=" . rand() . ".doc");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");
    $startdate = $_GET['from'];
    $enddate = $_GET['to'];
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];
    $q = $_SESSION['org_rep_footer1'];
    $b = $_SESSION['org_rep_footer2'];
    $org = "<div><h2 style='text-align:center'><img src='../upload/$org_logo' style='width:35px;height:25px;'>$org_name</h2></div>";
    $a = "<h4 style='text-align:center'> from $startdate to $enddate </h4>";
    include('../database.php');
    $output = '';
    $output .= $org;
    $output .= '<h3 style="text-align:center">Income and Expenditure Statement </h3>';
    $output .= $a;
    $output .= '<div style="width: 100%;height: 100%;">
    <div style="float: left;width: 49%;height: auto;border-style: solid"><table width="100%">
            <thead>
                <tr style="text-align:center">
                    <th colspan="4" style="background: green">Income </th>
                </tr>
                <tr>
                    <th>Date</th>
                    <th>A/C Code</th>
                    <th>A/C Head</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>';
    $sql = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.cr_amt_loc-tran_details.dr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND gl_acc_code.category_code='3' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
    $query = $conn->query($sql);
    while ($row = $query->fetch_assoc()) {
        $output .= "<tr>
 <td>" . $row['tran_date'] . "</td>
 <td>" . $row['acc_code'] . "</td>
 <td>" . $row['acc_head'] . "</td>
 <td style='text-align: right'>" . $row['balance'] . "</td>
</tr>";
    }
    $output .= '</tbody><tfoot>';
    $sqls_total_inc = "SELECT tran_details.gl_acc_code, SUM(tran_details.dr_amt_loc) as dr_amt_loc,tran_details.tran_date, SUM(tran_details.cr_amt_loc) as cr_amt_loc,  gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.dr_amt_loc-tran_details.cr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND gl_acc_code.category_code='3' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')";
    $return_inc = mysqli_query($conn, $sqls_total_inc);
    $result_inc = mysqli_fetch_assoc($return_inc);
    $dr_amt_loc_inc = $result_inc['dr_amt_loc'];
    $cr_amt_loc_inc = $result_inc['cr_amt_loc'];
    $total_inc = $dr_amt_loc_inc - $cr_amt_loc_inc;
    $output .= "<tr style='text-align: right; font-weight:bold'>
        <td colspan='3'>Total</td>
        <td>" . $total_inc . "</td>
        </tr>";
    $output .= '</tfoot></table></div>';
    $output .= '<div style="float: right;width: 50%;height: auto;border-style: solid"><table width="100%">
    <thead>
        <tr style="text-align:center">
            <th colspan="4" style="background: red">Expenditure </th>
        </tr>
        <tr>
            <th>Date</th>
            <th>A/C Code</th>
            <th>A/C Head</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>';
    $sqls = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.dr_amt_loc-tran_details.cr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND gl_acc_code.category_code='4' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
    $querys = $conn->query($sqls);
    while ($rows = $querys->fetch_assoc()) {
$output .= "<tr>
            <td>" . $rows['tran_date'] . "</td>
            <td>" . $rows['acc_code'] . "</td>
            <td>" . $rows['acc_head'] . "</td>
            <td style='text-align: right'>" . $rows['balance'] . "</td>
        </tr>";
    }
    $output .= '</tbody><tfoot>';
    $sqls_total_exp = "SELECT tran_details.gl_acc_code, SUM(tran_details.dr_amt_loc) as dr_amt_loc,tran_details.tran_date, SUM(tran_details.cr_amt_loc) as cr_amt_loc,  gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.dr_amt_loc-tran_details.cr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND gl_acc_code.category_code='4' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')";
    $return_exp = mysqli_query($conn, $sqls_total_exp);
    $result_exp = mysqli_fetch_assoc($return_exp);
    $dr_amt_loc_exp = $result_exp['dr_amt_loc'];
    $cr_amt_loc_exp = $result_exp['cr_amt_loc'];
    $total_exp = $dr_amt_loc_exp - $cr_amt_loc_exp;
    $output .= "<tr style='text-align: right; font-weight:bold'>
                    <td colspan='3'>Total</td>
                    <td>" . $total_exp . "</td>
                </tr>";
    $output .= '</tfoot></table></div>';
    $output .= '</div>';
    // ========================
    $output .= "<div style='padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><strong>$q</strong></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><strong>$b</strong></div></div>";

    echo $output;
    }
