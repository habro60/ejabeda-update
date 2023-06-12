<?php
require "../auth/auth.php";
require "../database.php";
$bill_code = $_POST['bill_codc'];
$selectQuery = "SELECT `description` FROM `code_master` WHERE `hardcode`= 'billt' AND `softcode`='$bill_code'";
$Result = $conn->query($selectQuery);
$row = $Result->fetch_assoc();
echo $row['description'];
?>