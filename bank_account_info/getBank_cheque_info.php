<?php
require "../auth/auth.php";
require_once ("../dbcontroller.php");
$db_handle = new DBController();
if (! empty($_POST["bank_acc_no"])) {
    $query = "SELECT * FROM bank_chq_leaf_info WHERE account_no = '" . $_POST["bank_acc_no"] . "' AND leaf_status=0";
    $results = $db_handle->runQuery($query);
    ?>
<option value disabled selected>Select Cheque No</option>
<?php
    foreach ($results as $chk) {
echo '<option value="'.$chk['chq_leaf_no'].'">'.$chk["chq_leaf_no"].'</option>';  

    }
}
?>