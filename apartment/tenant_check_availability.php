<?php 
require_once("../database.php");
//code check Tenant Name
if(!empty($_POST["tenant_name"])) {
$result = mysqli_query($conn,"SELECT count(tenant_name) FROM apart_tenant_info WHERE tenant_name='" . $_POST["tenant_name"] . "'");
$row = mysqli_fetch_row($result);
$owner_name = $row[0];
if($owner_name>0) echo "<h5 style='color:red'> Tenant  Name Already Exit .</h5>";
else echo "<h5 style='color:green'> Tenant Name Available.</h5>";
}
