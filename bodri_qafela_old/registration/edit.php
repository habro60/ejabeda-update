<?php
	require "../auth/auth.php";
	include_once('../database.php');

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$hardcode = $_POST['hardcode'];
		$softcode = $_POST['softcode'];
		$description = $_POST['description'];
		$sort_des = $_POST['sort_des'];
		$sql = "UPDATE code_master SET hardcode = '$hardcode', softcode = '$softcode', description = '$description', sort_des = '$sort_des' WHERE id = '$id'";

		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Member updated successfully';
		}
		///////////////

		//use for MySQLi Procedural
		// if(mysqli_query($conn, $sql)){
		// 	$_SESSION['success'] = 'Member updated successfully';
		// }
		///////////////
		
		else{
			$_SESSION['error'] = 'Something went wrong in updating member';
		}
	}
	else{
		$_SESSION['error'] = 'Select member to edit first';
	}

	header('location: ../code_master.php');

?>