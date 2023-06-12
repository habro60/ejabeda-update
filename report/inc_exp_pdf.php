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
        $a = "<h4 style='text-align:center'> from $startdate to $enddate </h4>";
        require_once 'pdf.php';
        include('../database.php');
        $output = '';
        $output .= $org;
        $output .= '<h3 style="text-align:center">Income and Expenditure Statement </h3>';
        $output .= $a;
        $output .= '<div style="width: 100%;height: 100%;">
        <div><table width="100%" border="1" cellpadding="0" cellspacing="0">
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
                if (!empty($officeId)) {
                    $sql = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.cr_amt_loc-tran_details.dr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.office_code='$officeId' AND gl_acc_code.category_code='3' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and (tran_details.dr_amt_loc is not NULL or tran_details.dr_amt_loc is NULL) and (tran_details.cr_amt_loc is not NULL or tran_details.cr_amt_loc is NULL) group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
                } else {
                    $sql = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.cr_amt_loc-tran_details.dr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND gl_acc_code.category_code='3' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and (tran_details.dr_amt_loc is not NULL or tran_details.dr_amt_loc is NULL) and (tran_details.cr_amt_loc is not NULL or tran_details.cr_amt_loc is NULL) group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
                }
        $query = $conn->query($sql);
        $tot = 0;
        while ($row = $query->fetch_assoc()) {
            $tot = $tot + $row['balance'];
            $output .= "<tr>
     <td>" . $row['tran_date'] . "</td>
     <td>" . $row['acc_code'] . "</td>
     <td>" . $row['acc_head'] . "</td>
     <td style='text-align: right'>" . $row['balance'] . "</td>
  </tr>";
        }
        $output .= '</tbody><tfoot>';
        $output .= "<tr style='text-align: right; font-weight:bold'>
            <td colspan='3'>Total</td>
            <td>" . $tot . "</td>
            </tr>";
        $output .= '</tfoot></table></div>';
        $output .= '<div><table width="100%" border="1" cellpadding="0" cellspacing="0">
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
        if (!empty($officeId)) {
            $sqls = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.dr_amt_loc-tran_details.cr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.office_code='$officeId' AND gl_acc_code.category_code='4' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
        } else {
            $sqls = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.dr_amt_loc-tran_details.cr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND gl_acc_code.category_code='4' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
        }
        $querys = $conn->query($sqls);
        $total_exp = 0;
        while ($rows = $querys->fetch_assoc()) {
            $total_exp = $total_exp + $rows['balance'];
            $output .= "<tr>
                            <td>" . $rows['tran_date'] . "</td>
                            <td>" . $rows['acc_code'] . "</td>
                            <td>" . $rows['acc_head'] . "</td>
                            <td style='text-align: right'>" . $rows['balance'] . "</td>
                        </tr>";
        }
        $output .= '</tbody><tfoot>';
        $output .= "<tr style='text-align: right; font-weight:bold'>
                        <td colspan='3'>Total</td>
                        <td>" . $total_exp . "</td>
                    </tr>";
        $output .= '</tfoot></table></div>';
        $output .= '</div>';
        $output .= "<div style='padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><strong>$q</strong></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><strong>$b</strong></div></div>";
          $timestamp = time();
          $file_name = "inc_exp_pdf-$timestamp";
          $pdf = new Pdf();
          $pdf->set_paper("Letter", "landscape");
          $pdf->loadHtml(utf8_decode($output));
          $pdf->render();
          $font = $pdf->getFontMetrics()->get_font("arial", "bold");
          $font_com = $pdf->getFontMetrics()->get_font("arial");
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
        //   $pdf->stream($file_name, array("Attachment" => false));
          unset($pdf);
    }
