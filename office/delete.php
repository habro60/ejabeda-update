<?php
	// require "../auth/auth.php";
	include_once('../database.php');

	if(isset($_GET['id'])){
		$sql = "DELETE FROM office_info WHERE id = '".$_GET['id']."'";

		if($conn->query($sql)){
			$_SESSION['success'] = 'Office deleted successfully';
		}
		
		else{
			$_SESSION['error'] = 'Something went wrong in deleting Office';
		}
	}
	else{
		$_SESSION['error'] = 'Select Office to delete first';
	}

	// header('location: office_info.php');
?>