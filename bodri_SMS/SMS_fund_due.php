<?php 

//প্রথমে আপনার সুবিধে মত করে ডেটাবেজ হতে ডেটা নিন এখানে mysqli ব্যবহার করে mysql/mariadb ডেটাবেজ হতে ডেটা নিয়ে দেখানো হলো তবে চাইলে লুপের মধ্যে সেন্ড এর কোড দিয়ে একাধিক অথবা ডাইনামিক ভাবেও এসএমএস প্রেরন করা যাবে । তবে এভাবে ডাইনামিক প্রেরন না করে many to many পদ্ধতি ব্যবহার করুন যা এর পরবর্তি মেনুতে দেখানো হয়েছে । এটি স্ট্যাটিক এসএমএস এর জন্য বেস্ট যেমন আপনার ডেটাবেজে ১০০ নাম্বার আছে তাদের সবাইকে একটি সেম ম্যাসেজ (নোটিশ, মার্কেটিং ইত্যাদি) দিতে চান এক্ষেত্রে ডেটাবেজ থেকে আপনি সব নাম্বার একবারে নিয়ে কমা সেপারেট ফরম্যাটে সাজিয়ে একটি রিকোয়েস্টের মাধ্যমে সব এসএমএস প্রেরন করা যাবে ।

// $dblink = mysqli_connect("localhost", "dbusername", "dbpassword", "dbname");
require "../auth/auth.php";
require "../database.php";
//  If connection fails throw an error /

if (mysqli_connect_errno()) {
    echo "Could  not connect to database: Error: ".mysqli_connect_error();
    exit();
}
// if (isset($_GET['end_date'])) {
//     // $member_id = intval($_GET['member_id']);
//     $enddate = $_GET['end_date'];

$enddate=$_SESSION['smsDate'];  
 
$sql = "SELECT donner_fund_detail.member_id, donner_fund_detail.num_of_paid, fund_member.member_no, '$enddate',fund_member.mobile, donner_fund_detail.donner_paid_amt, (12 * (YEAR('$enddate') - YEAR(last_paid_date)) + (MONTH('$enddate') - MONTH(last_paid_date))) as due_month, sum(mthly_rate_setup.rate_amt) as pay_amt from donner_fund_detail,fund_member, mthly_rate_setup where (mthly_rate_setup.rate_date > donner_fund_detail.last_paid_date and mthly_rate_setup.rate_date <= '$enddate') and donner_fund_detail.member_id=fund_member.member_id and allow_flag >'0' and fund_member.mobile >'0' and donner_fund_detail.last_paid_date <= '$enddate' group by  fund_member.mobile order by fund_member.member_no";
// echo $sql;
// exit;

if ($result = mysqli_query($conn, $sql)) {
//    $counr=mysqli_num_rows($result);
// echo $counr;
// die;
    while ($row = mysqli_fetch_assoc($result)) {
    $text=   $row['pay_amt'];    
	$number = $row['mobile'];
	 $to = "$number";


// আমরা $to তে সব নাম্বার কমা সেপারেট করা অবস্থায় পেয়েছি এবার এসএমএস প্রেরন করুন
$token = "77b26b4844c6e4a25a3049822e9eeba8";
// $message = 'Test SMS From for receive fund' ;


$message="দাপুনিয়া বাজার সমিতিতে আপনার মোট বকেয়া (" . $text. ") টাকা। দ্রুত আপনার বকেয়া পরিশোধের জন্য অনুরোধ করা যাচ্ছে।";

$url = 'http://api.greenweb.com.bd/api2.php';
// token- 79393e61a113a34ef86eed5d2f52d51c


$data= array(
'to'=>"$to",
'message'=>"$message",
'token'=>"$token"
); // Add parameters in key value
$ch = curl_init(); // Initialize cURL
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$smsresult = curl_exec($ch);

//Result
echo $smsresult;

//Error Display
echo curl_error($ch);
}

}

?>
