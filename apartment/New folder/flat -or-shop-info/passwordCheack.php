<?php
require "../auth/auth.php";
require "../database.php";
//session_start();



$password = $_GET['password'];
$password = strip_tags(mysqli_real_escape_string($conn, trim($password)));

$sql="SELECT password FROM `user_info` WHERE sa_role_no=99";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);


if (password_verify($password, $data["password"])) {
    echo "1";
}else{
    echo"0";
}




