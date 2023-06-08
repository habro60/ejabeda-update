<?php 

//প্রথমে আপনার সুবিধে মত করে ডেটাবেজ হতে ডেটা নিন এখানে mysqli ব্যবহার করে mysql/mariadb ডেটাবেজ হতে ডেটা নিয়ে দেখানো হলো তবে চাইলে লুপের মধ্যে সেন্ড এর কোড দিয়ে একাধিক অথবা ডাইনামিক ভাবেও এসএমএস প্রেরন করা যাবে । তবে এভাবে ডাইনামিক প্রেরন না করে many to many পদ্ধতি ব্যবহার করুন যা এর পরবর্তি মেনুতে দেখানো হয়েছে । এটি স্ট্যাটিক এসএমএস এর জন্য বেস্ট যেমন আপনার ডেটাবেজে ১০০ নাম্বার আছে তাদের সবাইকে একটি সেম ম্যাসেজ (নোটিশ, মার্কেটিং ইত্যাদি) দিতে চান এক্ষেত্রে ডেটাবেজ থেকে আপনি সব নাম্বার একবারে নিয়ে কমা সেপারেট ফরম্যাটে সাজিয়ে একটি রিকোয়েস্টের মাধ্যমে সব এসএমএস প্রেরন করা যাবে ।

// $dblink = mysqli_connect("localhost", "dbusername", "dbpassword", "dbname");
// require "../auth/auth.php";
// require "../database.php";
//  If connection fails throw an error /
if (mysqli_connect_errno()) {
    echo "Could  not connect to database: Error: ".mysqli_connect_error();
    exit();
}

$today = date("Y-m-d");                     // 2001-03-10 1


$to_account = $_POST['to_account'];
$querys = "select sum(cr_amt_loc - dr_amt_loc) as balance from tran_details where gl_acc_code ='$to_account'";
$return = mysqli_query($conn, $querys);
$rows = mysqli_fetch_assoc($return);
$balance = $rows['balance'];
$to_account = $_POST['to_account'];
$querys = "SELECT fund_member.member_id, fund_member.gl_acc_code, fund_member.mobile,tran_details.tran_date, CURRENT_DATE(),tran_details.gl_acc_code,tran_details.cr_amt_loc from fund_member, tran_details where fund_member.gl_acc_code=tran_details.gl_acc_code and fund_member.gl_acc_code =$to_account and tran_details.batch_no='$batch_no'  and tran_details.tran_date='$today'";


$return = mysqli_query($conn, $querys);
$result = mysqli_fetch_assoc($return);
$text=   $result['cr_amt_loc']; 
$number = $result['mobile'];
$balance = $rows['balance'];
$to = "$number, $to";

// $to='01932669314,01767213613';
// $to_account = $_POST['to_account'];
// $batch_no = $_POST['batch_no'];
// $sqlquery = "SELECT fund_member.member_id, fund_member.gl_acc_code, fund_member.mobile,tran_details.tran_date, CURRENT_DATE(),tran_details.gl_acc_code,tran_details.cr_amt_loc from fund_member, tran_details where fund_member.gl_acc_code=tran_details.gl_acc_code and fund_member.gl_acc_code =$to_account and tran_details.batch_no='$batch_no'  and tran_details.tran_date=CURRENT_DATE()";
// if ($result = mysqli_query($conn, $sqlquery)) {
//     //  fetch associative array /
//     while ($row = mysqli_fetch_assoc($result)) {
//     $text=   $row['cr_amt_loc'];    
// 	$number = $row['mobile'];
// 	 $to = "$number, $to";
//     }
// } 

// আমরা $to তে সব নাম্বার কমা সেপারেট করা অবস্থায় পেয়েছি এবার এসএমএস প্রেরন করুন
// $token = "77b26b4844c6e4a25a3049822e9eeba8";
// // $message = 'Test SMS From for receive fund' ;

// $message="দারুল উলূম ঢাকা  (" . $text. ") টাকা জমাদানের জন্য ধন্যবাদ। আপনার মোট স্থিতি টাকা (" .$balance. ")";

// $url = 'http://api.greenweb.com.bd/api2.php';
// // token- 79393e61a113a34ef86eed5d2f52d51c


// $data= array(
// 'to'=>"$to",
// 'message'=>"$message",
// 'token'=>"$token"

// ); // Add parameters in key value

// $ch = curl_init(); // Initialize cURL
// curl_setopt($ch, CURLOPT_URL,$url);
// curl_setopt($ch, CURLOPT_ENCODING, '');
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $smsresult = curl_exec($ch);

// //Result
// echo $smsresult;

// //Error Display
// echo curl_error($ch);

$message="দারুল উলূম ঢাকা  (" . $text. ") টাকা জমাদানের জন্য ধন্যবাদ। আপনার মোট স্থিতি টাকা (" .$balance. ")";



$url = 'https://www.24bulksmsbd.com/api/smsSendApi';
		$data = array(
			'customer_id' => 89,
			'api_key' => 175651299097062801707009710,
			'message' =>$message,	
			'mobile_no' => $to
		);

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
		$output = curl_exec($curl);
		curl_close($curl);




// $url = "http://joy.metrotel.com.bd/smspanel/smsapi";
// $data = [
//   "api_key" => "2y10iC4R9JFlfzQYJ7B2GYiCxOrOL3tMk1JNCoYNpytjuClszdKJaYN2878",
//   "type" => "{text/unicode}",
// //   "contacts" => "$to",
//   "contacts" => "$to",
//   "senderid" => "8809612443345",
//   "msg" => "$message",
// ];

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// $response = curl_exec($ch);
// curl_close($ch);
// echo $response;
// die;
//return  $response;


?>
