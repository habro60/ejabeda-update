<?php
require "../auth/auth.php";
if (isset($_GET["account"]) && isset($_GET["from"]) && isset($_GET["to"])) {
    $account = $_GET["account"];
    $startdate = $_GET["from"];
    $enddate = $_GET["to"];
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];
    $q = $_SESSION['org_rep_footer1'];
    $b = $_SESSION['org_rep_footer2'];
    $org = "<div><h2 style='text-align:center'><img src='../upload/$org_logo' style='width:35px;height:25px;'>$org_name</h2></div>";
    $a = "<h4 style='text-align:center'> from $startdate to $enddate </h4>";
    require_once 'pdf.php';
    include('../database.php');
    $output = '';
    $output .= $org;
    $open_bal = date('Y-m-d', strtotime($startdate . ' - 1 day'));
    if (isset($account)) {
        $selectAcc = "SELECT acc_code,acc_head FROM gl_acc_code WHERE acc_code= $account";
        $result = mysqli_query($conn, $selectAcc);
        $data = mysqli_fetch_assoc($result);
    }
    $aco = $data['acc_head'];
    $aco1 = "<h4 style='text-align:center'> $aco </h4>";
    $output .= '<h3 style="text-align:center">General Ledger </h3>';
    $output .=  $aco1;
    $output .= $a;
    $output .= '<table width="100%" border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr style="text-align:center">
                    <th>Date</th>
                    <th>Trx. Mode</th>
                    <th>Particular</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Balance</th>
                </tr>
            </thead>';
    $org_fin_year_st =  $_SESSION["org_fin_year_st"];
    $open_bal = date('Y-m-d', strtotime($startdate . ' - 1 day'));
    $sql_opbal = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE gl_acc_code='$account' AND (`tran_date` BETWEEN '$org_fin_year_st' AND '$open_bal') ORDER BY `tran_date`";
    $return_opbal = mysqli_query($conn, $sql_opbal);
    $result_opbal = mysqli_fetch_assoc($return_opbal);
    $open_bal_debit = $result_opbal['debit'];
    $open_bal_credit = $result_opbal['credit'];
    $open_bal_total = $open_bal_debit - $open_bal_credit;
    $output .= '<tr style="font-weight:bold;color: red;text-align: right">
                    <td colspan="3">Opening Balance </td>
                    <td>' . $open_bal_debit . '</td>
                    <td>' . $open_bal_debit . '</td>
                    <td>' . $open_bal_total . '</td>
                </tr>';
    $sql = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code,tran_details.cr_amt_loc-tran_details.dr_amt_loc as balance, @RunningBalance:= @RunningBalance + (tran_details.cr_amt_loc-tran_details.dr_amt_loc) as RunningBalance  FROM tran_details JOIN gl_acc_code JOIN (SELECT @RunningBalance:= 0) r WHERE tran_details.gl_acc_code='$account' AND tran_details.gl_acc_code=gl_acc_code.acc_code AND (tran_details.tran_date BETWEEN '$org_fin_year_st' AND '$enddate') order by tran_details.batch_no";
    $query = $conn->query($sql);
    while ($rows = $query->fetch_assoc()) {
        if ($rows['tran_date'] >= $startdate) {
            $output .=
                '<tr style="text-align:right">
                                <td>' . $rows['tran_date'] . '</td>
                                <td>' . $rows['tran_mode'] . '</td>
                                <td>' . $rows['description'] . '</td>
                                <td>' . $rows['dr_amt_loc'] . '</td>
                                <td>' . $rows['cr_amt_loc'] . '</td>
                           <td><strong>' . $rows['RunningBalance'] . '</strong></td>
                            </tr>';
        }
    }
    $output .= '<tfoot>';
    $sql2 = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE gl_acc_code='$account' AND (`tran_date` BETWEEN '$org_fin_year_st' AND '$enddate') ORDER BY `tran_date`";
    $returnD = mysqli_query($conn, $sql2);
    $result = mysqli_fetch_assoc($returnD);
    $result_debit = $result['debit'];
    $result_credit = $result['credit'];
    $result_total = $result_debit - $result_credit;
    $output .= '<tr style="text-align:right">
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong> TK.' . $result_debit . '</strong></td>
                    <td><strong> TK.' . $result_credit . '</strong></td>
                    <td><strong> TK.' . $result_total . '</strong></td>
                </tr>';
    $output .= '</tfoot></table>';
    $output .= "<div style='padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><strong>$q</strong></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><strong>$b</strong></div></div>";
    $timestamp = time();
    $file_name = "gl_ledger_print-$timestamp";
    $pdf = new Pdf();
    $pdf->set_paper("A4", "portrait");
    // $pdf->set_paper("Letter", "landscape");
    $pdf->loadHtml(utf8_decode($output));
    $pdf->render();
    $font = $pdf->getFontMetrics()->get_font("helvetica", "bold");
    $font_com = $pdf->getFontMetrics()->get_font("helvetica");
    date_default_timezone_set('Asia/Dhaka');
    $date = date("Y-m-d h:i:sa");
    $canvas = $pdf->get_canvas();
    $footer = $canvas->open_object();
    $w = $canvas->get_width();
    $h = $canvas->get_height();
    $canvas->page_text($w - 60, $h - 28, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10);
    $canvas->page_text($w - 750, $h - 28, "Printed as on $date", $font, 10);
    $canvas->page_text($w - 400, $h - 18, "Habro System Limited Tel. +880 2 48810576", $font_com, 6);
    $canvas->close_object();
    $canvas->add_object($footer, "all");
    //   $pdf->stream($file_name);
    $pdf->stream($file_name, array("Attachment" => false));
    unset($pdf);
}
