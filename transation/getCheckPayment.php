<?php
    require "../auth/auth.php";
    require "../database.php";
/*
** Calculate To Account start 
*/
if (!empty($_POST['gl_acc'])) {
    $gl_acc = $_POST['gl_acc'];
    $sql = "SELECT `gl_acc_code`, SUM(dr_amt_loc - cr_amt_loc) as balance FROM `tran_details` WHERE `gl_acc_code`=$gl_acc";
    $payAmount = mysqli_query($conn, $sql);
    $amount = mysqli_fetch_assoc($payAmount);
    if (!empty($amount['balance']))
        echo $amount['balance'];
    else echo 0;
}
/*
** get voucher no 
*/
if (!empty($_POST['acc_code'])) {
    $gl_acc_code = $_POST['acc_code'];
    $sql = "SELECT tran_details.gl_acc_code,gl_acc_code.acc_type, SUM(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as balance FROM `tran_details` JOIN `gl_acc_code` where tran_details.gl_acc_code=`gl_acc_code`.`acc_code` AND tran_details.gl_acc_code =$gl_acc_code AND tran_details.tran_mode='PV'";
    $payAmount = mysqli_query($conn, $sql);
    $amount = mysqli_fetch_assoc($payAmount);
    if (!empty($amount['acc_type']) && !empty($amount['gl_acc_code'])) {
        $gl_code = $amount['gl_acc_code'];
        $sql1 = "SELECT invoice_detail.order_no FROM `invoice_detail` WHERE invoice_detail.gl_acc_code ='$gl_code' AND `bill_status`='PV' AND `item_status`='1' GROUP BY invoice_detail.order_no";
        $result = $conn->query($sql1);
        echo '<option>Select Voucher</optio>';
        while ($data = $result->fetch_assoc()) {
            echo '<option value="' . $data['order_no'] . '">' . $data['order_no'] . '</option>';
        }
    } else {
        echo 0;
    }
}
/*
** get purchase date 
*/
if (!empty($_POST['order_no'])) {
    $order_no = $_POST['order_no'];
    $sql1 = "SELECT invoice_detail.order_no, invoice_detail.order_date FROM `invoice_detail` WHERE invoice_detail.order_no ='$order_no' GROUP BY invoice_detail.order_no";
    $result = $conn->query($sql1);
    echo '<option> Select Date </optio>';
    while ($data = $result->fetch_assoc()) {
        echo '<option value="' . $data['order_date'] . '">' . $data['order_date'] . '</option>';
    }
} else {
    echo 0;
}
/*
** Calculate By Account balance 
*/
if (!empty($_POST['order_no_cal'])) {
    $order_no_cal = $_POST['order_no_cal'];
    // tax vat discunt
    $sql = "SELECT SUM(include_tax_amt) + SUM(include_vat_amt) - SUM(include_discount_amt) as balance FROM `invoice_detail` WHERE order_no='$order_no_cal'";
    $payAmount = mysqli_query($conn, $sql);
    $amount = mysqli_fetch_assoc($payAmount);
    $balance = $amount['balance'];
    // total amount
    $sql2 = "SELECT SUM(total_price_loc) as balance2 FROM `invoice_detail` WHERE order_no='$order_no_cal' AND bill_status='PV'";
    $payAmount2 = mysqli_query($conn, $sql2);
    $amount2 = mysqli_fetch_assoc($payAmount2);
    if (!empty($amount2['balance2'])) {
        $balance2 = $amount2['balance2'];
        echo $balance2 + $balance;
    } else {
        echo 0;
    }
}
