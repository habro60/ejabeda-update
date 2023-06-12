<?php 
require "../auth/auth.php";
require "../database.php";
extract($_POST);
$id=$conn->real_escape_string($id);
$status=$conn->real_escape_string($status);
$sql=$conn->query("UPDATE `user_info` SET user_status='$status', status_date=now() WHERE id='$id'");
echo 1;
?>