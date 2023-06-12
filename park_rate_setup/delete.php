<?php

require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
require '../source/sidebar.php';
require '../source/header.php';

if (isset($_GET['carDriverInfoDelete'])) {
    $id = base64_decode($_GET['carDriverInfoDelete']);

   // echo $id;

    mysqli_query($conn, "DELETE FROM `driver_info` WHERE `id`='$id'") or die( mysqli_error($conn));

    //header("location:index.php");
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";

}