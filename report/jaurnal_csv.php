<?php
include('../database.php');
if (isset($_GET["date"])) {
    $timestamp = time();
    $filename = 'jaurnal_csv-' . $timestamp . '.csv';
    $isPrintHeader = false;
    $sqlExcel = "SELECT tran_details.batch_no,tran_details.tran_no,tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code  AND (tran_details.tran_date BETWEEN '2017-07-01' AND '2017-08-01') ORDER BY tran_details.batch_no";
    $productResult = $conn->query($sqlExcel);
    foreach ($productResult as $row) {
        if (!$isPrintHeader) {
            echo implode("\t", array_keys($row)) . "\n";
            $isPrintHeader = true;
        }
        echo implode("\t", array_values($row)) . "\n";
    }
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    exit();
}
