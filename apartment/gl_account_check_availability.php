<?php 
require "../auth/auth.php";
require "../database.php";
// require("../database.php");
//code check suppomer Name
if(!empty($_POST["acc_on"])) {

    $acc_on = $_POST["acc_on"];
    $flat_no =$_POST["flat_no"];
    if ($acc_on == '3'){
         $sql= "SELECT id, flat_no, tenant_name FROM `apart_tenant_info` WHERE `flat_no`='$flat_no' limit 1";

         $sqlViewReturn = mysqli_query($conn, $sql);
         $rowcount = mysqli_num_rows($sqlViewReturn);
         if ($rowcount !='0') {
             $sql= "SELECT id, flat_no, tenant_name FROM `apart_tenant_info` WHERE `flat_no`='$flat_no'";
             $result= $conn->query($sql);
             $row = $result->fetch_assoc();
             if ($row['tenant_name']) {
                 $tenant_name = $row['tenant_name'];
                 $result = mysqli_query($conn,"SELECT count(acc_head) FROM `gl_acc_code` WHERE acc_head='$tenant_name'");
                 $row = mysqli_fetch_row($result);
                   $acc_head = $row[0];
                    if($acc_head>0) echo 5; // "<h5 style='color:red'> Account Name Already Exit .</h5>";
                     else echo "<h5 style='color:green'> Account Name Available.</h5>";
             }
        
         }else{

         if($rowcount =='0') echo 5; //"<h5 style='color:red'> Flat has no Tenant</h5>";
         else echo "<h5 style='color:green'> Flat has Tenant </h5>";
         }
    } elseif ($acc_on == '2') {
        $sql= "SELECT apart_owner_info.id, apart_owner_info.owner_id, apart_owner_info.owner_name, flat_info.flat_no FROM apart_owner_info, flat_info WHERE apart_owner_info.owner_id=flat_info.owner_id and flat_info.flat_no='$flat_no'";
        $result= $conn->query($sql);
        $row = $result->fetch_assoc();

         if ($row['owner_name']) {
            $owner_name = $row['owner_name'];
            $result = mysqli_query($conn,"SELECT count(acc_head) FROM `gl_acc_code` WHERE acc_head='$owner_name'");
            $row = mysqli_fetch_row($result);
                $acc_head = $row[0];
                if($acc_head>0) echo 5; // "<h5 style='color:red'> Account Name Already Exit .</h5>";
                else echo "<h5 style='color:green'> Account Name Available.</h5>";
            
        }

    }elseif ($acc_on == '1') {
        $sql= "SELECT id, flat_no, flat_title FROM flat_info WHERE `flat_no`='$flat_no'";
        $result= $conn->query($sql);
        $row = $result->fetch_assoc();

         if ($row['flat_title']) {
            $flat_title = $row['flat_title'];
            $result = mysqli_query($conn,"SELECT count(acc_head) FROM `gl_acc_code` WHERE acc_head='$flat_title'");
            $row = mysqli_fetch_row($result);
                $acc_head = $row[0];
                if($acc_head>0) echo 5; //"<h5 style='color:red'> Account Name Already Exit .</h5>";
                else echo "<h5 style='color:green'> Account Name Available.</h5>";
            
        }
         
    }
}
// if(!empty($_POST["acc_head"])) {
//         $result = mysqli_query($conn,"SELECT count(acc_head) FROM `gl_acc_code` WHERE acc_head='" . $_POST["acc_head"] . "'");
//         $row = mysqli_fetch_row($result);
//         $acc_head = $row[0];
//         if($acc_head>0) echo "<h5 style='color:red'> Account Name Already Exit .</h5>";
//         else echo "<h5 style='color:green'> Account Name Available.</h5>";
// }
