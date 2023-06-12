<?php
require "../auth/auth.php";
require "../database.php";
$owner_id = $_POST['owner_id'];

$selectQuery = "SELECT  owner_id, owner_name, flat_no FROM apart_owner_info Where `owner_id`='$owner_id'";
$Result = $conn->query($selectQuery);
$row = $Result->fetch_assoc();
echo $row['flat_no'];