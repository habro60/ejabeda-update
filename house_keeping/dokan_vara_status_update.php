<?php
require "../auth/auth.php";
require "../database.php";
$flate_no=$_POST['flate_no']??'';
$status=$_POST['status']??'';
$flate_no1=$_POST['flate_no1']??'';
$status1=$_POST['status1']??'';
$payamount=$_POST['payamount']??'';
$date=$_POST['date']??'';
$edate=$_POST['edate']??'';

if($status==0){
    $status=1;
    $sql="UPDATE `dokan_vara_detail` 
    SET `effect_date`='$edate',`last_paid_date`='$date',`pay_amt`='$payamount',`donner_pay_amt`='$payamount', `allow_flag`='$status' WHERE flat_no='$flate_no'";
    // echo  $sql;
    // exit;
    $status=$conn->query($sql);
    

    //$status=1;
    //$flate_no=$_POST['flate_no']??'';
    $sql_mthly="UPDATE `monthly_bill_entry` 
    SET  `allow_flag`='$status' WHERE flat_no='$flate_no'";
    $status=$conn->query($sql_mthly);
    

    //$status=1;
    //$flate_no=$_POST['flate_no']??'';
    $sql_services="UPDATE apart_owner_sevice_facility 
    SET  `allow_flag`='$status' WHERE flat_no='$flate_no'";
    $status=$conn->query($sql_services);

   
}
if($status1==1){
    $status1=0;
    $sql="UPDATE `dokan_vara_detail` 
    SET `effect_date`='$edate',`allow_flag`='$status1' WHERE flat_no='$flate_no1'";
    $update_dokan=$conn->query($sql);
   
    //$status1=0;
    $sql_mthly="UPDATE `monthly_bill_entry` 
    SET  `allow_flag`='$status1' WHERE flat_no='$flate_no1'";
    $status=$conn->query($sql_mthly);
  
   // $status1=0;
    $sql_services="UPDATE apart_owner_sevice_facility 
    SET  `allow_flag`='$status1' WHERE flat_no='$flate_no1'";
    $status=$conn->query($sql_services);

}
// $today=date('yy-m-d');
//echo $today;
header('refresh:0;dokan_vara_active_inactive.php');
?>
