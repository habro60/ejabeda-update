<?php
require "../auth/auth.php";
require "../database.php";
if (! empty($_POST['division_id'])) {
    $id=$_POST['division_id'];

    $query = "SELECT * FROM districts WHERE division_id = '$id'";
    $result = mysqli_query($conn, $query);
    ?>
<option value="">-Select District-</option>
<?php
    while ($data = mysqli_fetch_assoc($result)) {
        ?>
<option value="<?php echo $data["id"]; ?>"><?php echo $data["name"]; ?></option>
<?php
    };
}

if (!empty($_POST["district_id"])) {
    $id=$_POST["district_id"];
    $query = "SELECT * FROM upazilas WHERE district_id = '$id'";
    $result = mysqli_query($conn, $query);
    ?>
<option value="">-Select upazilas-</option>
<?php
    while ($data = mysqli_fetch_assoc($result)) {
        ?>
<option value="<?php echo $data["id"]; ?>"><?php echo $data["name"]; ?></option>
<?php
    }
}

?>
