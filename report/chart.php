<?php
require "../auth/auth.php";
$output = '';
$org_name = $_SESSION['org_name'];
$org_logo = $_SESSION['org_logo'];
$q = $_SESSION['org_rep_footer1'];
$b = $_SESSION['org_rep_footer2'];
$org = "<div><h2 style='text-align:center'><img src='../upload/$org_logo' style='width:35px;height:25px;'>$org_name</h2></div>";
require_once 'pdf.php';
include('../database.php');
$output .= '<h3 style="text-align:center">Chart of Account</h3>';
$output .= '<table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr class="active">
  <th>মেহমানদারী</th>
  <th>যাতায়াত</th>
  <th>পুনঃ ভর্তি</th>
  <th>Category</th>
  <th>Postable Acc</th>
  </tr>
  <tbody>';
$output .= '<tbody></table>';
// echo $output;

$timestamp = time();
$file_name = "chart_of_account_print-$timestamp";
$pdf = new Pdf();
// $pdf->set_option('defaultFont', 'SolaimanLipi');
// $pdf->set('defaultFont', 'Courier');
// $pdf->set_paper("A4", "landscape");
$pdf->loadHtml(utf8_decode($output));
$pdf->render();
//
// $pdf = iconv('UTF-8', 'windows-1252', '??? ??? ????');
//
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
