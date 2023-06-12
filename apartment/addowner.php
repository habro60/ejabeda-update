<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
//die;
//echo 'OUT';
if (isset($_POST['owner_name'])) {
    // echo 'in';
    // die;
    $flatid=$_GET['flat_no'];

    // echo $flatid;
    // die;

  $sql="SELECT max(owner_id) as last_owner_id FROM `apart_owner_info`";
  $sqlResult = $conn->query($sql);
  $rows = $sqlResult->fetch_assoc();
  $last_owner_id = ($rows['last_owner_id'] + '1');
  
  $office_code = $_SESSION['office_code'];
  $owner_name = $conn->escape_string($_POST['owner_name']);
  // $flat_no = $conn->escape_string($_POST['flat_no']);
  $father_hus_name = $conn->escape_string($_POST['father_hus_name']);
  $mother_name = $conn->escape_string($_POST['mother_name']);
  $nid = $conn->escape_string($_POST['nid']);
  $passport_no = $conn->escape_string($_POST['passport_no']);
  $date_of_birth = $conn->escape_string($_POST['date_of_birth']);
  $mobile_no = $conn->escape_string($_POST['mobile_no']);
  $intercom_number = $conn->escape_string($_POST['intercom_number']);
  $permanent_add = $conn->escape_string($_POST['permanent_add']);
  $profession = $conn->escape_string($_POST['profession']);
  $upload_dir = '../upload/';
  $imgName = $_FILES['image']['name'];
  $imgTmp = $_FILES['image']['tmp_name'];
  $imgSize = $_FILES['image']['size'];
  $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
  $date = date("d-m-Y");
  $ownerPic = $imgName . '_' . $date . '_' . rand(1000, 9999) . '.' . $imgExt;
  move_uploaded_file($imgTmp, $upload_dir . $ownerPic);

  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertownerQuery = "INSERT INTO `apart_owner_info`(`id`,`office_code`,`owner_id`,`owner_name`, `father_hus_name`,`mother_name`,`nid`, `passport_no`,`date_of_birth`, mobile_no, intercom_number, permanent_add,profession, gl_acc_code, owner_image, ss_creator,ss_created_on,ss_org_no) values  (NULL,'$office_code','$last_owner_id','$owner_name','$father_hus_name','$mother_name','$nid','$passport_no','$date_of_birth','$mobile_no','$intercom_number','$permanent_add','$profession','0','$ownerPic','$ss_creator','$ss_created_on','$ss_org_no')";

  $conn->query($insertownerQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save owner Successfully!";
  } else {
    $mess = "Failled!";
  }
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=apartment_setup.php?id=$flatid\">";
}