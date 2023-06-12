<?php
require_once ("dbcontroller.php");
$db_handle = new DBController();
if (! empty($_POST["division_id"])) {
    $query = "SELECT * FROM districts WHERE division_ID = '" . $_POST["division_id"] . "'";
    $results = $db_handle->runQuery($query);
    ?>
<option value disabled selected>Select District</option>
<?php
    foreach ($results as $District) {
        ?>
<option value="<?php echo $District["id"]; ?>"><?php echo $District["name"]; ?></option>
<?php
    }
}
?>
