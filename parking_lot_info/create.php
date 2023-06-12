<?php

require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
require '../source/sidebar.php';
require '../source/header.php';

if (isset($_POST['addParkingLots'])) {

    $park_lot_no = $_POST['park_lot_no'];
    $lot_type = $_POST['lot_type'];
    $flat_no = $_POST['flat_no'];
    $car_reg_no = $_POST['car_reg_no'];
    $ss_creator = $_SESSION['username'];
    $ss_modifier = $_SESSION['username'];
   //$ss_org_no = $_POST['ss_org_no'];
    $ss_org_no = $_SESSION['org_no'];

    $query2 = "INSERT INTO `parking_lots_info`(`park_lot_no`, `lot_type`, `flat_no`, `car_reg_no`, `ss_creator`, `ss_modifier`, `ss_org_no`) VALUES ('$park_lot_no','$lot_type','$flat_no','$car_reg_no','$ss_creator','$ss_modifier','$ss_org_no')";
    
    $result2 = mysqli_query($conn, $query2) or die( mysqli_error($conn));

    //header('location:/carparking/index.php');
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
    
}