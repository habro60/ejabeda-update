<?php 
require "../auth/auth.php";
require "../database.php";
if(!empty($_POST["owner_name"])) {
$result = mysqli_query($conn,"SELECT count(owner_name) FROM apart_owner_info WHERE owner_name='" . $_POST["owner_name"] . "'");
$row = mysqli_fetch_row($result);
$owner_name = $row[0];
if($owner_name>0) echo "<h5 style='color:red'> Owner  Name Already Exit .</h5>";
else echo "<h5 style='color:green'> Owner Name OK.</h5>";
}
