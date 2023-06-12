<?php

require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
require '../source/sidebar.php';
require '../source/header.php';

if (isset($_POST['addParkSetupInfo'])) {

    $vehicle_type = $_POST['vehicle_type'];
    $first_hr_rate = $_POST['first_hr_rate'];
    $next_hr_rate = $_POST['next_hr_rate'];
    $day_rate = $_POST['day_rate'];
    $monthly_rate = $_POST['monthly_rate'];
    $ss_creator = $_SESSION['username'];
    $ss_modifier = $_SESSION['username'];

    $query2 = "INSERT INTO `parking_rate_setup`(`vehicle_type`,`first_hr_rate`, `next_hr_rate`, `day_rate`,`monthly_rate`,`ss_creator`, `ss_modifier`) VALUES ('$vehicle_type','$first_hr_rate','$next_hr_rate','$day_rate','$monthly_rate','$ss_creator','$ss_modifier')";
    
    $result2 = mysqli_query($conn, $query2) or die( mysqli_error($conn));

    //header('location:/carparking/index.php');
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
    
}