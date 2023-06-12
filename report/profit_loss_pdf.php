<?php
require "../auth/auth.php";
if (isset($_GET['office']) && isset($_GET['date'])) {
    $enddate = $_GET['date'];
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
    if (!empty($officeId)) {
        $sql_inc = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.cr_amt_loc- tran_details.dr_amt_loc) as total_income  FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.office_code='$officeId' AND tran_details.tran_date<= '$enddate' AND gl_acc_code.category_code = '3' group by gl_acc_code.category_code";
   } else {
        $sql_inc = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.cr_amt_loc- tran_details.dr_amt_loc) as total_income  FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date<= '$enddate' AND gl_acc_code.category_code = '3' group by gl_acc_code.category_code";
   }
   if (!empty($officeId)) {
       $sql_exp = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as total_expanse FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.office_code='$officeId' AND tran_details.tran_date<= '$enddate' AND gl_acc_code.category_code = '4' group by gl_acc_code.category_code";
   } else {
       $sql_exp = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as total_expanse FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date<= '$enddate' AND gl_acc_code.category_code = '4' group by gl_acc_code.category_code";
   }
    $query_inc = mysqli_query($conn, $sql_inc);
    $rows_inc =  mysqli_fetch_assoc($query_inc);
    $query_exp = mysqli_query($conn, $sql_exp);
    $rows_exp = mysqli_fetch_assoc($query_exp);
    $output .= '
        <table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr style="background-color: green;">
  <th>Total Income</th>
  <th>Total Expense</th>
  <th>Total Profit</th>
  <th>Total loss</th>
  </tr>
  <tr style="text-align:center">
  <td style="width:25%;height: 100px;background-color: white">
      <strong>'.$rows_inc['total_income'].'</strong>
 </td>
 <td style="width:25%;height: 50px;background-color: red">
     <strong>'.$rows_exp['total_expanse'].'</strong>
 </td>
 <td style="width:25%;height: 50px;background-color: white">
     <strong>'.($rows_inc['total_income'] - $rows_exp['total_expanse']).'</strong>
 </td>
 <td style="width:25%;height: 50px;background-color: red">
 </td>
</tr>
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
    //   $pdf->stream($file_name);
    $pdf->stream($file_name, array("Attachment" => false));
    unset($pdf);
}
