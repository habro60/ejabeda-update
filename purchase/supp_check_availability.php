<?php 
// require_once("../database.php");
require "../auth/auth.php";
require "../database.php";
//code check suppomer Name
if(!empty($_POST["supp_name"])) {
$result = mysqli_query($conn,"SELECT count(supp_name) FROM supp_info WHERE supp_name='" . $_POST["supp_name"] . "'");
$row = mysqli_fetch_row($result);
$supp_name = $row[0];
if($supp_name>0) echo "<h5 style='color:red'> Supplier Name Already Exit .</h5>";
else echo "<h5 style='color:green'> Supplier Name Available.</h5>";
}
