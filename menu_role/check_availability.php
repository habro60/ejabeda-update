<?php
//Code check user name
if(!empty($_POST["userid"])) {
	$result1 = mysqli_query($conn,"SELECT count(user_name) FROM sm_hr_emp WHERE user_name='" . $_POST["userid"] . "'");
	$row1 = mysqli_fetch_row($result1);
	$user_count = $row1[0];
	if($user_count>0) echo "<span style='color:red'> User name already exit .</span>";
	else echo "<span style='color:green'> User name Available.</span>";
}
