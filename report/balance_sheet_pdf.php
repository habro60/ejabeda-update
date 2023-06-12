<?php
require "../auth/auth.php";
if (isset($_GET['date'])) {
    $enddate = $_GET['date'];
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];
    $q = $_SESSION['org_rep_footer1'];
    $b = $_SESSION['org_rep_footer2'];
    $org = "<div><h2 style='text-align:center'><img src='../upload/$org_logo' style='width:35px;height:25px;'>$org_name</h2></div>";
    require_once 'pdf.php';
    include('../database.php');
    $output = '';
    $output .= $org;
    $output .= '<h3 style="text-align:center">Balance Sheet</h3>';
    $output .= "<center><strong>As On Date:$enddate</strong></center>";
    $output .= '<div><div style="float: left;width: 49.2%;height: auto;border-style: solid">
    <table style="width: 100%">
        <thead>
            <tr style="text-align:center;background-color:red">
                <th colspan="4">Libilities</th>
            </tr>
            <tr>
                <th>A/HEAD</th>
                <th style="text-align:right">BALANCE</th>
            </tr>
        </thead>
        <tbody>';
    $sql1 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as Cr_amt, sum(tran_details.dr_amt_loc) as dr_amt, tran_details.tran_date, SUM(tran_details.cr_amt_loc - tran_details.dr_amt_loc) as balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddate'  AND gl_acc_code.category_code = '2' group by gl_acc_code.parent_acc_code order by gl_acc_code.acc_code";
    $query = $conn->query($sql1);
    while ($rows = $query->fetch_assoc()) {
        if ($rows['category_code'] == 2) {
            if ($rows['acc_level'] == 1) {
                $output .=  "<tr><td style='color:gray; font-weight:bold'>" . $rows['acc_head'] . "</td>
            <td style='text-align:right'>" . $rows['balance'] . "</td>
            </tr>";
            } elseif ($rows['acc_level'] == 2) {
                $output .=  "<tr><td style='text-indent:20px;color:blue; font-weight:bold'>" . $rows['acc_head'] . "</td>
            <td style='text-align:right'>" . $rows['balance'] . "</td></tr>";
            } elseif ($rows['acc_level'] == 3) {
                $output .=  "<tr><td style='text-indent:30px;color:red; font-weight:bold'>" . $rows['acc_head'] . "</td>
            <td style='text-align:right'>" . $rows['balance'] . "</td></tr>";
            } elseif ($rows['acc_level'] == 4) {
                $output .=  "<tr><td style='text-indent:40px;color:green; font-weight:bold'>" . $rows['acc_head'] . "</td>
            <td style='text-align:right'>" . $rows['balance'] . "</td></tr>";
            } else {
                $output .=  "<tr><td style='text-indent:20px'>" . $rows['acc_head'] . "</td>
            <td style='text-align:right'>" . $rows['balance'] . "</td></tr>";
            }
        }
    }
    $sql_total_libility = "select gl_acc_code.acc_code, gl_acc_code.acc_head,tran_details.tran_date,gl_acc_code.category_code, gl_acc_code.parent_acc_code,tran_details.gl_acc_code,tran_details.tran_date, SUM(tran_details.cr_amt_loc- tran_details.dr_amt_loc) as total_balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddate' AND gl_acc_code.category_code = '2' order by gl_acc_code.acc_code";
    $query_total_libility = mysqli_query($conn, $sql_total_libility);
    $total_libility = mysqli_fetch_assoc($query_total_libility);
    $output .= '<tr>
    <th colspan="1" style="text-align: right"> Total</th>
    <th style="text-align: right"><strong>' . $total_libility['total_balance'] . '</strong></th>
    </tr>';
    $output .= '</tobody></table></div>';
    $output .= '<div style="float: right;width: 50%;height: auto;border-style: solid">
    <table>
        <thead>
            <tr style="text-align:center;background-color:green">
                <th colspan="4">Asset</th>
            </tr>
            <tr>
                <th>A/HEAD</th>
                <th style="text-align:right">BALANCE</th>
            </tr>
        </thead>
        <tbody>';
    $sql1 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as Cr_amt, sum(tran_details.dr_amt_loc) as dr_amt, tran_details.tran_date, SUM(tran_details.cr_amt_loc - tran_details.dr_amt_loc) as balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddate'  AND gl_acc_code.category_code = '1' group by gl_acc_code.parent_acc_code order by gl_acc_code.acc_code";
    $query1 = $conn->query($sql1);
    while ($row = $query1->fetch_assoc()) {
        if ($row['category_code'] == 1) {
            if ($row['acc_level'] == 1) {
                $output .=  "<tr><td style='color:gray; font-weight:bold'>" . $row['acc_head'] . "</td>
            <td style='text-align:right'>" . $row['balance'] . "</td>
            </tr>";
            } elseif ($row['acc_level'] == 2) {
                $output .=  "<tr><td style='text-indent:20px;color:blue; font-weight:bold'>" . $row['acc_head'] . "</td>
            <td style='text-align:right'>" . $row['balance'] . "</td></tr>";
            } elseif ($row['acc_level'] == 3) {
                $output .=  "<tr><td style='text-indent:30px;color:red; font-weight:bold'>" . $row['acc_head'] . "</td>
            <td style='text-align:right'>" . $row['balance'] . "</td></tr>";
            } elseif ($row['acc_level'] == 4) {
                $output .=  "<tr><td style='text-indent:40px;color:green; font-weight:bold'>" . $row['acc_head'] . "</td>
            <td style='text-align:right'>" . $row['balance'] . "</td></tr>";
            } else {
                $output .=  "<tr><td style='text-indent:20px'>" . $row['acc_head'] . "</td>
            <td style='text-align:right'>" . $row['balance'] . "</td></tr>";
            }
        }
    }
    $sql_total_asset = "select gl_acc_code.acc_code, gl_acc_code.acc_head,tran_details.tran_date,gl_acc_code.category_code, gl_acc_code.parent_acc_code,tran_details.gl_acc_code,tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as total_balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddate' AND gl_acc_code.category_code = '1' order by gl_acc_code.acc_code";
    $query_total_asset = $conn->query($sql_total_asset);
    $total_asset = $query_total_asset->fetch_assoc();
    $output .= '<tr>
    <th colspan="1" style="text-align: right"> Total</th>
    <th style="text-align: right"><strong>' . $total_asset['total_balance'] . '</strong></th>
</tr>';
    $output .= '</tbody></table></div></div>';
    $output .= '<br>';
    $output .= '<br>';
    $output .= '<br>';
    $output .= '<br>';
    $output .= '<br>';
    $output .= '<br>';
    $output .= '<br>';
    $output .= '<br>';
    $output .= '<br>';
    $output .= '<br>';
    $output .= "<div style=
'padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><strong>$q</strong></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><strong>$b</strong></div></div>";
    // echo $output;
    $timestamp = time();
    $file_name = "gl_ledger_pdf-$timestamp";
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
