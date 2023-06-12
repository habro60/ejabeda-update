<?php
require "../auth/auth.php";
require "../database.php";
/*
** Calculate To Account start 
*/
if (!empty($_POST['gl_acc'])) {
    $gl_acc = $_POST['gl_acc'];
    $sql = "SELECT `gl_acc_code`, SUM(dr_amt_loc - cr_amt_loc) as balance FROM `tran_details` WHERE `gl_acc_code`='$gl_acc'";
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
        $sql1 = "SELECT invoice_detail.order_no FROM `invoice_detail` WHERE invoice_detail.gl_acc_code ='$gl_code' GROUP BY invoice_detail.order_no";  // GROUP BY invoice_detail.order_no
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
    //  GROUP BY invoice_detail.order_no
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
if (!empty($_POST['gl_acc_code'])) {
    $gl_acc_code = $_POST['gl_acc_code'];
    $sql = "SELECT tran_details.gl_acc_code, gl_acc_code.acc_type,tran_details.tran_mode
    ,tran_details.batch_no, SUM(tran_details.cr_amt_loc) as balance FROM `tran_details` JOIN `gl_acc_code` where tran_details.gl_acc_code=`gl_acc_code`.`acc_code` AND tran_details.tran_mode='PV' AND tran_details.batch_no =$gl_acc_code";
    $payAmount = mysqli_query($conn, $sql);
    $amount = mysqli_fetch_assoc($payAmount);
    if (!empty($amount['balance'])) {
        echo $amount['balance'];
    } else {
        echo 0;
    }
}
if (!empty($_POST['bill_charge_code'])) {
    $bill_charge_code = $_POST['bill_charge_code'];
    $sql = "SELECT * FROM apart_owner_sevice_facility WHERE bill_charge_code='$bill_charge_code'";
    $result = $conn->query($sql);
    $row=mysqli_fetch_assoc($result);
    echo $row['bill_fixed_amt'];
    
}
if (!empty($_POST['flat_no'])) {
    $flat_no = $_POST['flat_no'];
    $sql = "SELECT `flat_info`.`flat_no`, `apart_owner_info`.`owner_name` FROM `flat_info`, apart_owner_info WHERE `flat_info`.`owner_id`=`apart_owner_info`.`owner_id` AND `flat_info`.`flat_no`='$flat_no'";
    $result1 = $conn->query($sql);
    $row=$result1->fetch_assoc();
    echo $row['owner_name'];
}
