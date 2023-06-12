<?php
require "../auth/auth.php";
require "../database.php";


$owner_id = $_GET['owner_id'];
$flat_no = $_GET['flat_no'];



$sql="SELECT gl_acc_code FROM `apart_owner_info` WHERE owner_id='$owner_id'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
$gl_code=$data['gl_acc_code'];

if($gl_code==0){


    // echo "sjdfsfsd";

$sql= "SELECT `id`, `flat_no`,`owner_id`, flat_title,billing_gl_code FROM `flat_info` WHERE `flat_no`='$flat_no'";
$sqlResult = $conn->query($sql);
$rows = $sqlResult->fetch_assoc();
$flat_title=$rows['flat_title'];
$old_gl_code=$rows['billing_gl_code'];


$selectQuery = "select * from gl_acc_code where subsidiary_group_code='800' and `postable_acc`='N'";
$selectQueryReuslt = $conn->query($selectQuery);
$row = $selectQueryReuslt->fetch_assoc();


$id=$row['id'];


// $id=$row['parent_acc_code'];
$query = "Select Max(acc_code) FROM gl_acc_code where `parent_acc_code`='$id'";
$returnD = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($returnD);
$maxRows = $result['Max(acc_code)'];


  if ($row['acc_level'] == 1) {
    $lastRow = $maxRows + 1000000000;
  } elseif ($row['acc_level'] == 2) {
    $lastRow = $maxRows + 10000000;
  } elseif ($row['acc_level'] == 3) {
    $lastRow = $maxRows + 100000;
  } elseif ($row['acc_level'] == 4) {
    $lastRow = $maxRows + 1000;
  } elseif ($row['acc_level'] == 5) {
    $lastRow = $maxRows + 10;
  }

  $gl_code=$lastRow;
//   print_r($lastRow);
  
  
$maxRows1 = $row['acc_level'];
if (empty($maxRows1)) {
$lastRows = $maxRows1 = 1;
} else {
$lastRows = $maxRows1 + 1;
}



//$gl_code=$lastRows;



}
echo $gl_code;

// echo $fat_no;

// if (!empty($_GET['item_no_soft'])) {
   
//     if($id==1){
//     $selectQuery = "SELECT * FROM flat_info";
//     $result = mysqli_query($conn, $selectQuery);
//     //$data = mysqli_fetch_assoc($result);


//     if($result->num_rows > 0){ 
//         echo '<option value="">Select Flat Info</option>'; 
//         while($row = $result->fetch_assoc()){  

          
//         } 
//     }else{ 
//         echo '<option value="">Flat not available</option>'; 
//     }
// }
    
//  if($id==2){
//     $selectQuery = "SELECT * FROM apart_owner_info";
//     $result = mysqli_query($conn, $selectQuery);
//     //$data = mysqli_fetch_assoc($result);


//     if($result->num_rows > 0){ 
//         echo '<option value="">Select Owner Info</option>'; 
//         while($row = $result->fetch_assoc()){  
//             echo '<option value="'.$row['owner_name'].'">'.$row['owner_name'].'</option>'; 
//         } 
//     }else{ 
//         echo '<option value="">Owner not available</option>'; 
//     }
//     }
    
//  if($id==3){
//     $selectQuery = "SELECT * FROM apart_tenant_info";
//     $result = mysqli_query($conn, $selectQuery);
//     //$data = mysqli_fetch_assoc($result);


//     if($result->num_rows > 0){ 
//         echo '<option value="">Select Tenant Info</option>'; 
//         while($row = $result->fetch_assoc()){  
//             echo '<option value="'.$row['tenant_name'].'">'.$row['tenant_name'].'</option>'; 
//         } 
//     }else{ 
//         echo '<option value="">Tenant not available</option>'; 
//     }
//     }

    // $a = json_encode($data);

    // echo $a;
 

    // if ($data['flat_title']) {
    //     $softcode = $data['flat_title'];
    //     $sql = "SELECT * FROM code_master WHERE hardcode='UCODE' AND softcode='$softcode'";
    //     $query = $conn->query($sql);
    //     $row = $query->fetch_assoc();
        
       
    //     echo $row['softcode'];
    //     die;
    // }
//}
?>

