<?php 
require_once("../database.php");
//code check direomer Name
if(!empty($_POST["dire_name"])) {
$result = mysqli_query($conn,"SELECT count(dire_name) FROM dire_info WHERE dire_name='" . $_POST["dire_name"] . "'");
$row = mysqli_fetch_row($result);
$dire_name = $row[0];
if($dire_name>0) echo "<h5 style='color:red'> Director Name Already Exit .</h5>";
else echo "<h5 style='color:green'> Director Name Available.</h5>";
}
