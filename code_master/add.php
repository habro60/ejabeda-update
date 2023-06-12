<?php
require "../auth/auth.php";
include_once('../database.php');
if (isset($_POST['add'])) {
    $office_code = $_SESSION['office_code'];
	$hardcode = $_POST['hardcode'];
	$softcode = $_POST['softcode'];
	$description = $_POST['description'];
	$sort_des = $_POST['sort_des'];
	$ss_creator = $_SESSION['username'];
	$ss_org_no = $_SESSION['org_no'];
	$sql = "INSERT INTO `code_master` (`id`,`office_code`,`hardcode`,`softcode`,`description`,`sort_des`,`created_by`,`created_date`,`ss_org_no`) VALUES(NULL,'$office_code','$hardcode','$softcode','$description','$sort_des','$ss_creator',now(),'$ss_org_no')";


	//use for MySQLi OOP
	if ($conn->query($sql)) {
		$_SESSION['success'] = 'Record added successfully';
	}
	///////////////

	//use for MySQLi Procedural
	// if(mysqli_query($conn, $sql)){
	// 	$_SESSION['success'] = 'Member added successfully';
	// }
	//////////////

	else {
		$_SESSION['error'] = 'Something went wrong while adding';
	}
} else {
	$_SESSION['error'] = 'Fill up add form first';
}

header('location: code_master.php');
