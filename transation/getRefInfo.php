<?php
require "../auth/auth.php";
require_once ("../dbcontroller.php");
$db_handle = new DBController();
if (! empty($_POST["id"])) {
    $query = "SELECT * FROM item WHERE id = '" . $_POST["id"] . "'";
    $results = $db_handle->runQuery($query);
    ?>
<?php
    foreach ($results as $District) {
        ?>
<option value="<?php echo $District["unit"]; ?>"><?php echo $District["unit"]; ?></option>
<?php
    }
}
?>
