<?php
require "../auth/auth.php";
// require "../database.php";
require_once ("../dbcontroller.php");
$db_handle = new DBController();
if (! empty($_POST["reffered_id"])) {
    $query = "SELECT * FROM fund_ref_info WHERE reffered_id = '" . $_POST["reffered_id"] . "'";
    $results = $db_handle->runQuery($query);
    ?>
<?php
    foreach ($results as $District) {
        ?>
<option value="<?php echo $District["full_name"]; ?>"><?php echo $District["full_name"]; ?></option>
<?php
    }
}
?>
