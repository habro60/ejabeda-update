<?php 
require_once("../index.php");
require_once("../database.php");
//code check email perosonal
if(!empty($_POST["emailid"])) {
$result = mysqli_query($conn,"SELECT count(email_personal) FROM sm_hr_emp WHERE email_personal='" . $_POST["emailid"] . "'");
$row = mysqli_fetch_row($result);
$email_count = $row[0];
if($email_count>0) echo "<span style='color:red'> Email Already Exit .</span>";
else echo "<span style='color:green'> Email Available.</span>";
}
// email offical
if(!empty($_POST["pemailid"])) {
	$result = mysqli_query($conn,"SELECT count(email_official) FROM sm_hr_emp WHERE email_official='" . $_POST["pemailid"] . "'");
	$row = mysqli_fetch_row($result);
	$email_count = $row[0];
	if($email_count>0) echo "<span style='color:red'> Email Already Exit .</span>";
	else echo "<span style='color:green'> Email Available.</span>";
	}
//Code check user name
if(!empty($_POST["userid"])) {
	$result = mysqli_query($conn,"SELECT count(emp_id) FROM sm_hr_emp WHERE emp_id='" . $_POST["userid"] . "'");
	$row = mysqli_fetch_row($result);
	$user_count = $row[0];
	if($user_count>0) echo "<span style='color:red'> User name already exit .</span>";
	else echo "<span style='color:green'> User name Available.</span>";
}
// ref email check 
if(!empty($_POST["refemailid"])) {
	$result = mysqli_query($conn,"SELECT count(*) FROM fund_ref_info WHERE email='" . $_POST["refemailid"] . "'");
	$row = mysqli_fetch_row($result);
	$email_count = $row[0];
	if($email_count>0) echo "<span style='color:red'> Email Already Exit .</span>";
	else echo "<span style='color:green'> Email Available.</span>";
	}
// ref id check 
if(!empty($_POST["refid"])) {
	$result = mysqli_query($conn,"SELECT count(*) FROM fund_ref_info WHERE reffered_id='" . $_POST["refid"] . "'");
	$row = mysqli_fetch_row($result);
	$id_count = $row[0];
	if($id_count>0) echo "<span style='color:red'> Reffered ID Already Exit .</span>";
	else echo "<span style='color:green'> Reffered ID Available.</span>";
	}
//code check email
if(!empty($_POST["memberemailid"])) {
	$result = mysqli_query($conn,"SELECT count(*) FROM fund_member WHERE email='" . $_POST["memberemailid"] . "'");
	$row = mysqli_fetch_row($result);
	$email_count = $row[0];
	if($email_count>0) echo "<span style='color:red'> Email Already Exit .</span>";
	else echo "<span style='color:green'> Email Available.</span>";
	}

//code check Fixed bill  Month
if(!empty($_POST["Fmth"])) {
	$month=$_POST["Fmth"];
    $inputMth = $month.substr(0,7);
	$sql="SELECT max(bill_for_month) as pmonth FROM apart_owner_bill_detail where pay_method ='fixed' and regular_pay_flag='0'";
	$query = mysqli_query( $conn, $sql);
	$rows = $query->fetch_assoc();
	$datamth = $rows['pmonth'];
    $tableMth = $datamth.substr(0,7);
     if ($rows['tableMth'] >= $inputMth) echo 5; // "<span style='color:red'> This month bill  Already process .</span>"
	else echo "<span style='color:green'> (Month ok)</span>";

}
//code check Fixed Bill billdate
if(!empty($_POST["Fbilldate"])) {
	$result = mysqli_query($conn,"SELECT max(bill_date) as pdate FROM apart_owner_bill_detail where pay_method ='fixed' and regular_pay_flag='0' ");
	$resultdate = mysqli_fetch_assoc($result);
	if ($resultdate['pdate']> 0) echo "<span style='color:red'> This dated bill  Already process .</span>";
	else echo "<span style='color:green'> date ok.</span>";
}
// code check  Fixed Bill Paydate
if(!empty($_POST["Fpaydate"])) {
	$pay_date =	$_POST['Fpaydate'];
	$bill_date = isset($_POST['Fbilldate']);
	// $result = mysqli_query($conn,"SELECT max(bill_date) as pdate FROM apart_owner_bill_detail  where bill_date = '".$_POST["paydate"]."'");
    // $resultdate = mysqli_fetch_assoc($result);
	if ($pay_date  < $bill_date) echo "<span style='color:red'> The payment date should be equal or greater than bill date.</span>";
	else echo "<span style='color:green'> date ok.</span>";

}

//code check Varaiable Bill month 
if(!empty($_POST["Vmth"])) {
	$sql="SELECT max(bill_for_month) as pmonth FROM apart_owner_bill_detail where pay_method ='varia'";
	$query = mysqli_query( $conn, $sql);
	$rows = $query->fetch_assoc();
     if ($rows['pmonth'] >= $_POST['Vmth']) echo 5; // "<span style='color:red'> This month bill  Already process .</span>"
	else echo "<span style='color:green'> (Month ok)</span>";

}
//code check Variable bill billdate
if(!empty($_POST["Vbilldate"])) {
	$result = mysqli_query($conn,"SELECT max(bill_date) as pdate FROM apart_owner_bill_detail where pay_method ='varia' ");
	$resultdate = mysqli_fetch_assoc($result);
	if ($resultdate['pdate']> 0) echo "<span style='color:red'> This dated bill  Already process .</span>";
	else echo "<span style='color:green'> date ok.</span>";
}
// code check Variable Paydate
if(!empty($_POST["Vpaydate"])) {
	$pay_date =	$_POST['Vpaydate'];
	$bill_date = isset($_POST['Vbilldate']);
	// $result = mysqli_query($conn,"SELECT max(bill_date) as pdate FROM apart_owner_bill_detail  where bill_date = '".$_POST["paydate"]."'");
    // $resultdate = mysqli_fetch_assoc($result);
	if ($pay_date  < $bill_date) echo "<span style='color:red'> The payment date should be equal or greater than bill date.</span>";
	else echo "<span style='color:green'> date ok.</span>";
}