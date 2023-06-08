<?php
require "../auth/auth.php";
require "../database.php";
if (!empty($_POST['by_account'])) {
    $by_account = $_POST['by_account'];
    $selectQuery = "SELECT acc_code, acc_head, acc_type  FROM `gl_acc_code` WHERE acc_code='$by_account'";
    $result =  $conn->query($selectQuery);
    if ($result->num_rows) {
        while ($data = $result->fetch_assoc()) {
            echo $data['acc_type'];
        }
    }
}


if (!empty($_POST['by_account_chq'])) {
    $by_account_chq = $_POST['by_account_chq'];
    $selectQuery = "SELECT acc_code, acc_head, acc_type  FROM `gl_acc_code` WHERE acc_code='$by_account_chq'";
    $result =  $conn->query($selectQuery);
    $data = $result->fetch_assoc();
    if ($result->num_rows) {
        if ($data['acc_type'] == '2') {
            $selectChque = "SELECT bank_acc_info.gl_acc_code, bank_acc_info.bank_acc_no,bank_chq_leaf_info.account_no, bank_chq_leaf_info.chq_leaf_no, bank_chq_leaf_info.leaf_status FROM `bank_acc_info`,bank_chq_leaf_info WHERE `gl_acc_code`='$by_account_chq' AND bank_chq_leaf_info.leaf_status='0' AND bank_acc_info.bank_acc_no=bank_chq_leaf_info.account_no;";
            $resultChque =  $conn->query($selectChque);
            $num =  $resultChque->num_rows;
            if ($num > 0) {
                while ($rows = $resultChque->fetch_assoc()) {
?>
                    <option value="<?php echo $rows["chq_leaf_no"]; ?>"><?php echo $rows["chq_leaf_no"]; ?></option>
    <?php
                }
            }
        }
    }
}
?>