<?php
require "../database.php";
?>
<?php
	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$hardcode = $_POST['hardcode'];
		$softcode = $_POST['softcode'];
		$description = $_POST['description'];
		$sort_des = $_POST['sort_des'];
		$modify_date = date("Y-m-d H:i:s");		
		$sql = "UPDATE code_master SET hardcode = '$hardcode', softcode = '$softcode', description = '$description', sort_des = '$sort_des',modify_date='$modify_date' WHERE id = '$id'";

		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Member updated successfully';
		}
		else{
			$_SESSION['error'] = 'Something went wrong in updating member';
		}
	}
	else{
		$_SESSION['error'] = 'Select member to edit first';
	}

	header('location:code_master.php');

?>
<?php
	if(isset($_POST['edithardcode'])){
		$id = $_POST['id'];
		$hardcode = $_POST['hardcode'];
		$softcode = $_POST['softcode'];
		$description = $_POST['description'];
		$sort_des = $_POST['sort_des'];
		$modify_date = date("Y-m-d H:i:s");		

		$sql = "UPDATE code_master SET hardcode = '$hardcode', softcode = '$softcode', description = '$description', sort_des = '$sort_des',modify_date='$modify_date' WHERE id = '$id'";
		//use for MySQLi OOP
		if($conn->query($sql)){
			$_SESSION['success'] = 'Member updated successfully';
		}		
		else{
			$_SESSION['error'] = 'Something went wrong in updating member';
		}
	}
	else{
		$_SESSION['error'] = 'Select member to edit first';
	}

	header('location:code_master.php');

?>