<?php
require "../auth/auth.php";
require "../database.php";
if (!empty($_POST['con_gl_acc_code'])) {
    $con_gl_acc_code = $_POST['con_gl_acc_code'];

    $sql="SELECT SUM(personal_ledger.dr_amt_loc - personal_ledger.cr_amt_loc) as closecash,personal_account.category_code  FROM personal_ledger, personal_account where personal_account.id=personal_ledger.gl_acc_code and (personal_ledger.tran_date BETWEEN '$org_fin_year_st' AND '$enddate') and personal_account.id='$con_gl_acc_code'";
    $payAmount = mysqli_query($conn, $sql);
    $amount = mysqli_fetch_assoc($payAmount);
    if (!empty($amount['balance']))
        echo $amount['balance'];
    else echo 0;
}
?>
