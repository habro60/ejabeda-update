<?php 
// require_once("../database.php");
require "../auth/auth.php";
require "../database.php";
//code check customer Name
if(!empty($_POST["cust_name"])) {
$result = mysqli_query($conn,"SELECT count(cust_name) FROM cust_info WHERE cust_name='" . $_POST["cust_name"] . "'");
$row = mysqli_fetch_row($result);
$cust_name = $row[0];
if($cust_name>0) echo "<h5 style='color:red'> Customer Name Already Exit .</h5>";
else echo "<h5 style='color:green'> Customer Name Available.</h5>";
}
