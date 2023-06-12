<?php
require "../auth/auth.php";
if (isset($_GET['from']) && isset($_GET['to'])) {
    $startdate = $_GET['from'];
    $enddate = $_GET['to'];
    $officeId = $_GET['office'];
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];
    $q = $_SESSION['org_rep_footer1'];
    $b = $_SESSION['org_rep_footer2'];
    $org = "<div><h2 style='text-align:center'><img src='../upload/$org_logo' style='width:35px;height:25px;'>$org_name</h2></div>";
    $a = "<h4 style='text-align:center'>$startdate To $enddate</h4>";
    require_once 'pdf.php';
    include('../database.php');
    $output = '';
    $output .= $org;
    $output .= '<h3 style="text-align:center">Trial Balance</h3>';
    $output .= $a;
    $output .= '
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
    <tr class="active">
        <th>A/C Number </th>
        <th>A/C Head </th>
        <th>Debit Transction </th>
        <th>Credit Transction</th>
    </tr>
    <tbody>';
    if (!empty($officeId)) {
      $sql = "SELECT tran_details.batch_no,tran_details.gl_acc_code,SUM(tran_details.dr_amt_loc) as dr_amt_loc ,tran_details.tran_date,tran_details.tran_mode,tran_details.description,SUM(tran_details.cr_amt_loc) as cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.office_code='$officeId' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') GROUP BY tran_details.gl_acc_code ORDER BY tran_details.gl_acc_code";
  } else {
      $sql = "SELECT tran_details.batch_no,tran_details.gl_acc_code,SUM(tran_details.dr_amt_loc) as dr_amt_loc ,tran_details.tran_date,tran_details.tran_mode,tran_details.description,SUM(tran_details.cr_amt_loc) as cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code  AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') GROUP BY tran_details.gl_acc_code ORDER BY tran_details.gl_acc_code";
  }
    $query = $conn->query($sql);
    while ($rows = $query->fetch_assoc()) {
        $output .= '<tr>   
                        <td>' . $rows['gl_acc_code'] . '</td>
                        <td>' . $rows['acc_head'] . '</td>
                        <td style="text-align:right">' . $rows['dr_amt_loc'] . '</td>
                        <td style="text-align:right">' . $rows['cr_amt_loc'] . '</td>
                    </tr>';
    }
    $output .= '</tbody>
    <tfoot>';
    $sql2 = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE (`tran_date` BETWEEN '$startdate' AND '$enddate') ORDER BY `tran_date`";
    $returnD = mysqli_query($conn, $sql2);
    $result = mysqli_fetch_assoc($returnD);
    $output .= '<tr style="text-align:right">
        <td colspan="1"></td>
        <td colspan="1">Grand Total</td>
        <td><strong> TK. ' . $result['debit'] . '</strong></td>
        <td><strong> TK. ' . $result['credit'] . '</strong></td>
    </tr>
</tfoot>
</table>';
    $output .= "<div style=
  'padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><strong>$q</strong></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><strong>$b</strong></div></div>";
    // echo $output;
      $timestamp = time();
      $file_name = "trail_balance_pdf-$timestamp";
      $pdf = new Pdf();
      $pdf->set_paper("Letter", "landscape");
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
      $pdf->stream($file_name);
      // $pdf->stream($file_name, array("Attachment" => false));
      unset($pdf);
}
