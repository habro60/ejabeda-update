<?php
include('../database.php');
$timestamp = time();
$filename = 'chart_of_account_excel_' . $timestamp . '.csv';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
$isPrintHeader = false;
$sqlExcel = "SELECT `acc_code`,`acc_head`,`acc_level`,`category_code`,`postable_acc` from `gl_acc_code` ORDER BY `acc_code`";
$productResult = $conn->query($sqlExcel);
foreach ($productResult as $row) {
    if (!$isPrintHeader) {
        echo implode("\t", array_keys($row)) . "\n";
        $isPrintHeader = true;
    }
    echo implode("\t", array_values($row)) . "\n";
}
exit();
