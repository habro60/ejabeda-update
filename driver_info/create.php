<?php

require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
require '../source/sidebar.php';
require '../source/header.php';

if (isset($_POST['addDriverInfo'])) {

    $driver_name = $_POST['driver_name'];
    $driver_add = $_POST['driver_add'];
    $driver_license_no = $_POST['driver_license_no'];
    $license_issue_place = $_POST['license_issue_place'];
    $license_issue_date = $_POST['license_issue_date'];
    $license_exp_date = $_POST['license_exp_date'];
    $car_reg_no = $_POST['car_reg_no'];
    $ss_creator = $_SESSION['username'];
    $ss_modifier = $_SESSION['username'];

    $query2 = "INSERT INTO `driver_info`(`driver_name`,`driver_add`, `driver_license_no`, `license_issue_place`,`license_issue_date`,`license_exp_date`, `car_reg_no`, `ss_creator`, `ss_modifier`) VALUES ('$driver_name','$driver_add','$driver_license_no','$license_issue_place','$license_issue_date','$license_exp_date','$car_reg_no','$ss_creator','$ss_modifier')";
    
    $result2 = mysqli_query($conn, $query2) or die( mysqli_error($conn));

    //header('location:/carparking/index.php');
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
    
}