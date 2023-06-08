<?php
require "../auth/auth.php";
if (isset($_GET["recortid"])) {
    $timestamp = time();
    $filename = 'voucher_view_word-' . $timestamp . '.doc';
    header("Content-type: application/vnd.ms-word");
    // header("Content-Disposition: attachment;Filename=" . rand() . ".doc");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];
    $org = "<div><h2 style='text-align:center'><img src='../upload/$org_logo' style='width:35px;height:25px;'>$org_name</h2></div>";
    // $org ='<div><h2 style="text-align:center"><img src="../upload/$org_logo" alt="logo" style="width:40px;height:40px;">$org_name</h2></div>';
    // $date = $_GET["recortid"];
    // $a = "<h4 style='text-align:center'>$date</h4>";
    require_once 'pdf.php';
    include('../database.php');
    $output = '';
    $output .= $org;
    $output .= '<h3 style="text-align:center"> Voucher </h3>';
    // $output .= $a;
    $sql = "SELECT tran_details.batch_no, tran_details.tran_no,tran_details.tran_mode, tran_details.tran_date,tran_details.gl_acc_code,gl_acc_code.acc_type,tran_details.dr_amt_loc,tran_details.cr_amt_loc,tran_details.description,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.batch_no='" . $_GET['recortid'] . "'";
    $query2 = $conn->query($sql);
    $row = $query2->fetch_assoc();
    $output .= '
    <div>
    <div style="float:right">
        <p>Voucher Number : ' . $row['batch_no'] . ' </p>
    </div>
    <div>
        <p>Voucher Date : ' . $row['tran_date'] . ' </p>
        <p>Voucher Type : ' . $row['tran_mode'] . ' </p>
        <p>Narration : ' . $row['description'] . ' </p>
    </div>
</div>';
    $output .= '
  <table width="100%" border="1" cellpadding="5" cellspacing="0">
    <tr class="active">
    <th>Trx. No </th>
    <th>GL A/C Code </th>
    <th>A/C Head </th>
    <th>Debit </th>
    <th>Credit</th>
    </tr>';
    $sql = "SELECT tran_details.batch_no, tran_details.tran_no, tran_details.tran_date,tran_details.gl_acc_code,gl_acc_code.acc_type,tran_details.dr_amt_loc,tran_details.cr_amt_loc,tran_details.description,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.batch_no='" . $_GET['recortid'] . "' ORDER BY tran_details.tran_no";
    $query = $conn->query($sql);
    while ($rows = $query->fetch_assoc()) {
        $output .= "<tr>
     <td>" . $rows['tran_no'] . "</td>
     <td>" . $rows['gl_acc_code'] . "</td>
     <td>" . $rows['acc_head'] . "</td>
     <td>" . $rows['dr_amt_loc'] . "</td>
     <td>" . $rows['cr_amt_loc'] . "</td>
  </tr>";
    }
    $sqls = "SELECT SUM(dr_amt_loc), SUM(cr_amt_loc) FROM tran_details WHERE batch_no='" . $_GET['recortid'] . "'";
    $returnD = mysqli_query($conn, $sqls);
    $result = mysqli_fetch_assoc($returnD);
    $dr = $result['SUM(dr_amt_loc)'];
    $cr = $result['SUM(cr_amt_loc)'];
    $output .= '
    <tr class="text-right">
            <th colspan="2"></th>
            <th colspan="1">Grand Total </th>
            <th style="text-align:left">' . $dr . '</th>
            <th style="text-align:left">' . $cr . '</th>
    </tr></table>';
    $output .= '<br><br><br><div style="padding:80px"><div style="float:left;text-align:left;line-height:100%"><label>--------------------</label><br><strong>Received by</strong></div><div style="text-align:right;"><label>---------------------------------</label><br><label>Sign by Authorized officer</label></div>';
    $output .= '<h5 style="text-align:center;color:red">Habro Systems Limited</h5>';
    echo $output;
    // $now = date('d:m:Y');
    // $timestamp = time();
    // $pdf = new Pdf();
    // $file_name = "voucher_view_pdf-$timestamp";
    // $pdf->loadHtml($output);
    // $pdf->setPaper('A4', 'ligal');
    // $pdf->render();
    // // $pdf->stream($file_name);
    // $pdf->stream($file_name, array("Attachment" => false));
}
