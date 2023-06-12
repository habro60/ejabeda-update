<?php
   require "../auth/auth.php";
require_once ("../dbcontroller.php");
$db_handle = new DBController();
if (! empty($_POST["acc_code"])) {
    $query = "SELECT * FROM bank_acc_info WHERE gl_acc_code = '" . $_POST["acc_code"] . "'";
    $results = $db_handle->runQuery($query);
    ?>
<option value disabled selected>Select Bank Account</option>
<?php
    foreach ($results as $District) {
        ?>
<option value="<?php echo $District["bank_acc_no"]; ?>"><?php echo $District["acc_name"]; ?></option>
<?php
    }
}
?>
