<?php 
require "../auth/auth.php";
require "../database.php";
$tenant_id = $_POST['tenant_id'];

$selectQuery = "SELECT  tenant_id, tenant_name, flat_no FROM apart_tenant_info Where `tenant_id`='$tenant_id'";
$Result = $conn->query($selectQuery);
$row = $Result->fetch_assoc();
echo $row['flat_no'];