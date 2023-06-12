<?php

require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
require '../source/sidebar.php';
require '../source/header.php';

if (isset($_GET['carParkingInfoDelete'])) {
    $id = base64_decode($_GET['carParkingInfoDelete']);

   // echo $id;

    mysqli_query($conn, "DELETE FROM `parking_lots_info` WHERE `id`='$id'") or die( mysqli_error($conn));

    //header("location:index.php");
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";

}