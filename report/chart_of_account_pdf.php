<?php
require "../auth/auth.php";
$org_name = $_SESSION['org_name'];
$org_logo = $_SESSION['org_logo'];
$q = $_SESSION['org_rep_footer1'];
$b = $_SESSION['org_rep_footer2'];
$org = "<div><h2 style='text-align:center'><img src='../upload/$org_logo' style='width:35px;height:25px;'>$org_name</h2></div>";
require_once 'pdf.php';
include('../database.php');
$output = '';
$output .= $org;
$output .= '<h3 style="text-align:center">Chart of Account</h3>';
$output .= '
  <table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr class="active">
  <th>A/C Head</th>
  <th>Account No</th>
  <th>Level</th>
  <th>Category</th>
  <th>Postable Acc</th>
  </tr>
  <tbody>';
$sql = "SELECT * from `gl_acc_code` ORDER BY `acc_code`";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
        if ($row['acc_level'] == 1) {
          $output .=  "<tr>
            <td>". $row['acc_code']."</td>
            <td style='color:red; font-weight:bold'>". $row['acc_head']."</td>
            <td>". $row['acc_level']."</td>
            <td>". $row['category_code']."</td>
            <td>". $row['postable_acc']."</td>
            </tr>";
        } elseif ($row['acc_level'] == 2) {
          $output .=  "<tr><td>". $row['acc_code']."</td>
            <td style='text-indent:20px;color:gray; font-weight:bold'>". $row['acc_head']."</td>
            <td>". $row['acc_level']."</td>
            <td>". $row['category_code']."</td>
            <td>". $row['postable_acc']."</td>
            </tr>";
        } elseif ($row['acc_level'] == 3) {
          $output .=  "<tr><td>". $row['acc_code']."</td>
            <td style='text-indent:30px;color:blue; font-weight:bold'>". $row['acc_head']."</td>
            <td>". $row['acc_level']."</td>
            <td>". $row['category_code']."</td>
            <td>". $row['postable_acc']."</td>
            </tr>";
        } elseif ($row['acc_level'] == 4) {
          $output .=  "<tr><td>". $row['acc_code']."</td>
            <td style='text-indent:40px;color:green; font-weight:bold'>". $row['acc_head']."</td>
            <td>". $row['acc_level']."</td>
            <td>". $row['category_code']."</td>
            <td>". $row['postable_acc']."</td>
            </tr>";
        } else {
          $output .=  "<tr><td>". $row['acc_code']."</td>
            <td style='text-indent:20px'>". $row['acc_head']."</td>
            <td>". $row['acc_level']."</td>
            <td>". $row['category_code']."</td>
            <td>". $row['postable_acc']."</td>
            </tr>";
        }
}
// echo $output;
$output .= '<tbody></table>';
$output .= "<div style=
  'padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><strong>$q</strong></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><strong>$b</strong></div></div>";
// echo $output;
      $timestamp = time();
      $file_name = "chart_of_account_pdf-$timestamp";
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
