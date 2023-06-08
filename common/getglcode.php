<?php
require_once ("../dbcontroller.php");
$db_handle = new DBController();
if (! empty($_POST["getacccode"])) {
    $query = "SELECT * FROM fund_member WHERE member_id = '" . $_POST["getacccode"] . "'";
    $results = $db_handle->runQuery($query);
    ?>
<?php
    foreach ($results as $District) {
        ?>
<option value="<?php echo $District["gl_acc_code"]; ?>"><?php echo $District["paid_amount"]; ?></option>
<?php
    }
}
?>
