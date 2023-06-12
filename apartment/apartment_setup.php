<?php
require "../auth/auth.php";
require "../database.php";


function billamount($bill_pay_method,$bill_fixed_amt,$flat_area){

  

  if($bill_pay_method=='SFT'){

  $floatfixdbill = floatval( $bill_fixed_amt );
  $floatflatarea = floatval( $flat_area );

  return $floatfixdbill*$floatflatarea;

  }else{
    return $bill_fixed_amt;
  }
 
}


if (isset($_POST['SubBtn'])) {

        $id = $_GET['id'];
        $owner_id = $_POST['owner_id']??'';
        $new_owner_id = $_POST['owner_id']??'';
        $flat_no = $_POST['flat_no'];

        $office_code = $_SESSION['office_code'];
        $acc_code1 = $_POST['acc_code'];
        //$acc_on = $_POST['acc_on'];
        $acc_head=$_POST['accountName'];

        $postable_acc = $_POST['postable_acc'];

        $rep_glcode = $_POST['rep_glcode'];
        $category_code = $_POST['category_code'];
        $acc_level = $_POST['acc_level'];
        $acc_type = $_POST['acc_type'];
        $parent_acc_code = $_POST['parent_acc_code'];
        $subsidiary_group_code=$_POST['subsidiary_group_code'];
        $ss_creator = $_SESSION['username'];
        $ss_org_no = $_SESSION['org_no'];
        
        $acc_code = intval($acc_code1);
       

        
  //update owner id and flat no
        $updateQuery = "UPDATE `flat_info` SET owner_id='$owner_id',billing_gl_code='$acc_code', flat_status='1', `status_date`=now(), `ss_modifier`='$ss_creator',`ss_modified_on`=now() WHERE id='$id'";
        if ($conn->query($updateQuery)) {
            echo 1;
        } else {
            echo 0;
        }

 
    //  echo $updateQuery;
    //     die;
// *****Update apart_owner_info****
        $updateOwner = "UPDATE `apart_owner_info` SET flat_no='$flat_no',gl_acc_code='$acc_code',`ss_modifier`='$ss_creator',`ss_modified_on`=now() WHERE owner_id='$owner_id'";
        if ($conn->query($updateOwner)) {
            echo 1;
        } else {
            echo 0;
        }
        
        // echo $updateOwner;
 
// *****Update monthly_bill_entry****
        $updateMonthly = "UPDATE `monthly_bill_entry` SET owner_gl_code='$acc_code',owner_id='$owner_id',`ss_modifier`='$ss_creator',`ss_modified_on`=now() WHERE flat_no='$flat_no'";
        if ($conn->query($updateMonthly)) {
            echo 1;
        } else {
            echo 0;
        }      
 
        //   echo $updateMonthly;
        //   die;


//insert gl code
          
$total_gl='0';   
$duplicate_count="SELECT COUNT(`id`) AS CC FROM `gl_acc_code` WHERE `acc_code`='$acc_code' GROUP BY `acc_code`";
$selectQueryResult2 = $conn->query($duplicate_count);
$row22 = $selectQueryResult2->fetch_assoc();

if(isset($row22['CC'])){
    $total_gl=intval($row22['CC']);
    
}





// echo $total_gl;
// echo $acc_code;

if($total_gl==0){
    
    //echo  $acc_code;
 $office_code = $_SESSION['office_code'];
 $insertQuery = "INSERT INTO `gl_acc_code` 
 (`office_code`, `acc_code`, `acc_head`, `postable_acc`,`rep_glcode`,`is_ho_acc`,
 `category_code`,`acc_level`,`acc_type`,`parent_acc_code`,`is_root`,`exch_rate`,
 `subsidiary_group_code`,`ss_creator`,`ss_creator_on`,`ss_modifier_on`,`ss_org_no`) 
 VALUES ('$office_code','$acc_code',concat('$flat_no',' ', '$acc_head'),'$postable_acc',
 '$rep_glcode','Y','$category_code','$acc_level','$acc_type','$parent_acc_code','1','0',
 '$subsidiary_group_code','$ss_creator',now(),now(),'$ss_org_no')";
 
 //echo $insertQuery;
  
  $conn->query($insertQuery);
     
}


  for ($count = 0; $count < count($_POST['id']); ++$count) {
    $id = $_POST['id'][$count];
    $allow_flag = $_POST['allow_flag'][$count];
    $effect_date = $_POST['effect_date'][$count];
    $bill_fixed_amt = $_POST['bill_fixed_amt'][$count];
    $terminate_date = $_POST['terminate_date'][$count];
    $ss_creator = $_SESSION['username'];
    $ss_creator_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    if ($owner_id > 0) {
      $query = "update `apart_owner_sevice_facility` set `owner_id`='$new_owner_id' , `allow_flag`='$allow_flag', `bill_fixed_amt`='$bill_fixed_amt',`effect_date`='$effect_date',`terminate_date`='$terminate_date', ss_creator='$ss_creator', ss_creator_on='$ss_creator_on', ss_org_no='$ss_org_no' where id='$id'";

      $conn->query($query);
    }
    if ($conn->affected_rows == TRUE) {
      $message = "Successfully";
    } else {
      $assign_menu_failled = "Failled";
    }
    
  }

$office_code = $_SESSION['office_code'];
$sql= "INSERT INTO `monthly_bill_entry`(office_code,`owner_id`,`flat_no`,`bill_for_month`,`bill_charge_code`, `bill_charge_name`,`bill_pay_method`) VALUES ('$office_code','$owner_id','$flat_no','0000-00-00','6','Electric Bill','variable')";  
 mysqli_query($conn, $sql) or die( mysqli_error($conn));
          
    //die;
    //header('refresh:1;flat_list_info.php');
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=flat_list_info.php\">";

      
}


require "../source/top.php";
// $pid= 1302000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Apartment Setup Information</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index/index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12 mx-auto">
      <!-- -------------------------------->
      <?php if (isset($message)) echo $message; ?>
      <form method="post"  enctype="multipart/form-data">
        <div  class="form-row form-group">
        <label class="col-2 col-form-label">Flat No </label>
        <label class="col-form-label">:</label>
        <div class="col-8 mb-3">
        <?php
          $flatid=$_GET['id'];
          $flat_information="SELECT flat_info.owner_id,flat_info.office_code,flat_info.flat_no,flat_info.flat_area,flat_info.side_of_flat,flat_info.building,flat_info.block_no,flat_info.flat_title,office_info.office_name 
          FROM flat_info,
           office_info WHERE flat_info.office_code=office_info.office_code AND flat_info.id='$flatid' ";
           $selectQueryResult = $conn->query($flat_information);
           $row = $selectQueryResult->fetch_assoc();
          
            
           $flat_area=$row['flat_area'];
           $flat_no=$row['flat_no'];



           $flat_information1="SELECT owner_id FROM `apart_owner_sevice_facility` WHERE flat_no='$flat_no' ";
           $selectQueryResult1 = $conn->query($flat_information1);
           $rowqq = $selectQueryResult1->fetch_assoc();

           $old_owner_id=$rowqq['owner_id']??'';
          ///////
           $tanent_info="SELECT * FROM `apart_tenant_info` WHERE flat_no='$flat_no' ";
            $tanent_infotQueryResult = $conn->query($tanent_info);
            $rowtanent = $tanent_infotQueryResult->fetch_assoc();
            $tanent_name=$rowtanent['tenant_name']??'';


           ?>

          <input  type="hidden" name="tanent_name" id="tanent_name" value="<?php echo $tanent_name; ?> ">
         <input type="hidden" name="flat_name" id="flat_name" value="<?php echo $row['flat_title'] ?>">
          <select readonly style="text-align:left;" name="flat_no" class="form-control">
             
                            <?php
                            echo '<option disabled value="' . $row['flat_no'] . '" selected="selected">' . $row['flat_no'] . '</option>';
                               
                            ?>
              </select>

             
          </div>

         
              <label class="col-form-label checkle" style="font-size: 15px;">Owner Transfer </label>
              <input name="owner_trans" id="owner_trans" class="check2" type="checkbox" style="zoom: 3;">
              
              
          <!-- <button type="button"  id="updatewflat" name="updatewflat" class="btn btn-danger mb-3" style="text-align:right;"><span class=" fa fa-plus"></span></button> -->

         
          
          <label class="col-sm-2 col-form-label">Owner </label>
          <label class="col-form-label">:</label>
          <div class="col-8 mb-3">
              
              <select  style="text-align:left;" id="owner_id" name="owner_id" class="form-control select2" readonly>
                                <option value="">Select Owner</option>
                                <?php
                                $selectQuery = 'SELECT owner_id, owner_name, flat_no 
                                FROM `apart_owner_info` order by id desc';
                                $owner_id=0;
                                $selectQueryResult = $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                    while ($rowowner = $selectQueryResult->fetch_assoc()) {
                                ?>
                                <option value="<?= $rowowner['owner_id']; ?>" <?php echo $rowowner['owner_id'] == $row['owner_id'] ? 'selected' : ''?>><?php echo $rowowner['owner_name'] ?></option>

                                <?php
                                $owner_id_ini=$rowowner['owner_id'];
                                //echo '<option value="' . $rowowner['owner_id'] . '"=="' . $row['owner_id'] . '" selected="selected">' . $rowowner['owner_name'] . '</option>';
                                    }
                                }
                                ?>

                  </select>
    
                
              </div>
              

              <button type="button" id="addowner" name="addowner" class="btn btn-danger"style="text-align:right;"><span class=" fa fa-plus"></span></button>


              
    <?php

$flat_no = $row['flat_no'];
$owner_id =$owner_id_ini;
$sql= "SELECT `id`, `flat_no`,`owner_id`, flat_title,billing_gl_code FROM `flat_info` WHERE `flat_no`='$flat_no'";
$sqlResult = $conn->query($sql);
$rows = $sqlResult->fetch_assoc();
$flat_title=$rows['flat_title'];
$old_gl_code=$rows['billing_gl_code'];
$sql_owner= "SELECT id, owner_id, owner_name FROM apart_owner_info WHERE `owner_id`='$owner_id'";
$sqlResult_owner = $conn->query($sql_owner);
$rows_owner = $sqlResult_owner->fetch_assoc();
$owner_name=$rows_owner['owner_name'];
 
$sql_tenant= "SELECT `id`, `tenant_under_owner_id`, tenant_name FROM `apart_tenant_info` WHERE `flat_no`='$flat_no'";
$sqlResult_tenant = $conn->query($sql_tenant);
$rowcount = mysqli_num_rows($sqlResult_tenant);
if ($rowcount == '0') {
      $tenant_name= "Not Avaiable";
}else{

     $sql= "SELECT `id`, `tenant_under_owner_id`, tenant_name FROM `apart_tenant_info` WHERE `flat_no`='$flat_no'";
      $sql_tenant = $conn->query($sql);
     $rows_tenant = $sql_tenant->fetch_assoc();
     $tenant_name= $rows_tenant['tenant_name'];  
}


$selectQuery = "select * from gl_acc_code where subsidiary_group_code='800' and `postable_acc`='N'";
$selectQueryReuslt = $conn->query($selectQuery);
$row = $selectQueryReuslt->fetch_assoc();

?>

<?php
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

?>

<?php

$maxRows1 = $row['acc_level'];
if (empty($maxRows1)) {
$lastRows = $maxRows1 = 1;
} else {
$lastRows = $maxRows1 + 1;
}

$query2 = "SELECT gl_acc_code.acc_head,gl_acc_code.acc_code
FROM gl_acc_code JOIN apart_owner_info 
  ON gl_acc_code.acc_code = apart_owner_info.gl_acc_code
WHERE apart_owner_info.flat_no='$flat_no' AND apart_owner_info.owner_id='$old_owner_id' ";




// $query2 = "SELECT gl_acc_code.acc_head,gl_acc_code.acc_head FROM `gl_acc_code` JOIN flat_info ON gl_acc_code.acc_code=flat_info.billing_gl_code WHERE flat_info.flat_no='$flat_no'";


$returnD2 = mysqli_query($conn, $query2); 
$result2 = mysqli_fetch_assoc($returnD2);

$acc_head=$result2['acc_head']??'';



?>   

    
      <label class="col-2 col-form-label" id="acc_select_status">Billing GL ON</label>
    
      <label class="col-form-label">:</label>
      <div class="col-8 mb-3">

      <!-- <select name="acc_on" id="acc_on" class="form-control" onchange="select_acc_name()" required> -->
      <select <?php if($acc_head){ echo "disabled";} ?>  name="acc_on" id="acc_on" class="form-control select2"        
                <option value="">Select Billing GL  </option>


           

                <option value="1">Shop/Flat Name</option>
                <option value="2">Owner Name</option>
                <option value="3">Tenant Name</option>
               
              </select>
              <tr>
          <th width="24%" scope="row"></th>
          <td><span id="name_availability_status"></span></td>
        </tr>
      </div>
   
    

   
      <label class="col-2 col-form-label " id="acc_select_status">Billing Account Name</label>
      <label class="col-form-label">:</label>
      <div class="col-8">
      <!-- <select name="acc_on" id="acc_on" class="form-control" onchange="select_acc_name()" required> -->
        
     <input readonly required class="form-control" type="text" name="accountName" id="accountName" value="<?php echo $acc_head  ?>">
              <tr>
          <th width="24%" scope="row"></th>
          <td><span id="name_availability_status"></span></td>
        </tr>
      </div>
      <div class="col-2"></div>
    
   

    
    
    <input type="text" name="postable_acc" value="Y" onclick="Fun()" id="more" hidden>
      
   
    <!-- reporting  -->
    <div class="form-group row">
      <!-- <label class="col-2 col-form-label">BIlling GL Code</label>
      <label class="col-form-label">:</label> -->
      <div class="col-8">
    
      <input type="hidden" class="form-control" value="<?php echo $row['acc_head'] ?>" readonly>
      <input type="hidden" name="flat_no" class="form-control"id="flat_no" autofocus value="<?php echo $flat_no; ?>"readonly>

      <?php
      if($old_gl_code){
      ?>
     
     <input type="hidden" name="acc_code" id="acc_code"  class="form-control" autofocus value="<?php echo $old_gl_code; ?>" readonly>
     <input type="hidden" class="form-control" id="acc_code2"  name="rep_glcode" value=<?php echo $old_gl_code; ?>>
      <?php
      }else{
        ?>

      <input type="hidden" name="acc_code" id="acc_code" class="form-control" autofocus value="<?php echo $lastRow; ?>" readonly>
      <input type="hidden" class="form-control" id="acc_code2"  name="rep_glcode" value=<?php echo $lastRow; ?>>

        <?php
      }


      ?>
    </div>
      <div class="col-2"></div>
    </div>
    <!-- category  hidden but input value by catagory-->
    
    <input type="text" class="form-control" id="" value="<?php echo $rows['flat_title']; ?>" name="acc_head1" hidden>
    <input type="text" class="form-control" id="" value="<?php echo $rows_owner['owner_name']; echo $flat_no;?>" name="acc_head2" hidden>
    <input type="text" class="form-control" id="" value="<?php echo $tenant_name; ?>" name="acc_head3" hidden>
    <input type="text" class="form-control" id="" value="<?php echo $row['subsidiary_group_code']; ?>" name="subsidiary_group_code" hidden>
    <input type="text" class="form-control" id="" value="<?php echo $row['category_code']; ?>" name="category_code" hidden>
    <!-- Account Type  -->
    <input type="text" class="form-control" id="" value="7" name="acc_type" hidden>
    <!-- hidden parant account code and account level set up-->
    <input type="number" class="form-control" name="parent_acc_code" value="<?php echo $row['id']; ?>" hidden>
    <input type="text" name="acc_level" class="form-control" required autofocus placeholder="ID" value=<?php if (!empty($lastRows)) {
                                                                                                          echo $lastRows;
                                                                                                        } ?> hidden>
<!-- submit  -->
   
 

<!-- form close  -->



    
    </div>
    
  <!-- -------------------------------->
  <?php
  if (!empty($message)) {
    echo '<script type="text/javascript">
        Swal.fire(
            "Save Successfully!!",
            "Welcome ' . $_SESSION['username'] . '",
            "success"
          )
        </script>';
  } else {
  }
  if (!empty($mess)) {
    echo '<script type="text/javascript">
      Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Sorry ' . $_SESSION['username'] . '",
        });
      </script>';
  } else {
  }
  ?>

</div>


        </div>

        

           <!-- NID and Passport No. -->








<?php
  $owner_id =$old_owner_id;

  if($owner_id){
?>

<div class="row">
      <div class="col-md-12">
          <div class="card" id="servicesListForm">
            <div class="card-header" style="background-color:#FFBF00 ">
              <h4 style="text-align:center; ">Assign Services to Owner</h4>
            </div>
            <div class="card-body">
              <table style="width: 100%">
                <tbody>
                  <tr>
                  
                          <table class="table bg-light table-bordered table-sm">
                   <thead>
                         <tr>
                            <th>Owner Name</th>
                            <th>Flat Number</th>
                            <th>Services Name</th>
                            <th>Pay Method</th>
                            <th>Bill Amount</th>
                            <th>Effect Date</th>
                            <th>Terminat Name</th>
                            <th>Active Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $disflag = '0';
                        $sqlowner ="SELECT owner_id, Flat_no FROM apart_owner_sevice_facility where owner_id='$owner_id' 
                        AND flat_no='$flat_no'";
                        $queryowner = mysqli_query($conn, $sqlowner);
                        $rowcount = mysqli_num_rows($queryowner);
                        if ($rowcount == '0') {
                            $Sqlinsert = "INSERT INTO `apart_owner_sevice_facility`
                             (`office_code`,`owner_id`,`flat_no`,`bill_charge_code`,`bill_charge_name`, `bill_pay_frequency`, 
                             bill_pay_method,pay_curr,bill_fixed_amt, ss_creator, ss_creator_on, ss_org_no) 
                             SELECT flat_info.office_code,flat_info.owner_id, 
                             flat_info.flat_no, apart_bill_charge_setup.bill_charge_code,
                             apart_bill_charge_setup.bill_charge_name, apart_bill_charge_setup.bill_pay_frequency,
                             apart_bill_charge_setup.bill_pay_method,
                             apart_bill_charge_setup.pay_curr,apart_bill_charge_setup.bill_fixed_amt,
                              apart_bill_charge_setup.ss_creator, apart_bill_charge_setup.ss_created_on, 
                              apart_bill_charge_setup.ss_org_no FROM flat_info, apart_bill_charge_setup
                                WHERE flat_info.owner_id ='$owner_id' AND flat_info.flat_no='$flat_no'";
                            $query = mysqli_query($conn, $Sqlinsert);
                        }
                        $sql = "SELECT apart_owner_sevice_facility.id,apart_owner_sevice_facility.office_code,
                        apart_owner_sevice_facility.owner_id,apart_owner_sevice_facility.flat_no, 
                        apart_owner_sevice_facility.bill_charge_code, apart_owner_sevice_facility.bill_charge_name,
                        apart_owner_sevice_facility.bill_pay_frequency,apart_owner_sevice_facility.bill_pay_method,
                        apart_owner_sevice_facility.pay_curr,apart_owner_sevice_facility.bill_fixed_amt, 
                        apart_owner_sevice_facility.effect_date,apart_owner_sevice_facility.terminate_date, 
                        apart_owner_sevice_facility.allow_flag,apart_owner_info.owner_name
                         FROM apart_owner_sevice_facility, apart_owner_info
                          WHERE apart_owner_sevice_facility.owner_id=apart_owner_info.owner_id 
                          AND apart_owner_sevice_facility.owner_id='$owner_id' AND 
                          apart_owner_sevice_facility.flat_no='$flat_no' 
                          order by apart_owner_sevice_facility.id ,apart_owner_sevice_facility.bill_charge_code";
                        $query = mysqli_query($conn, $sql);
                        if (!empty($query)) {
                            if (is_array($query) || is_object($query)) {
                                while ($rows = $query->fetch_assoc()) {
                        ?>
                                    <tr>
                                        <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>
                                        <input type="hidden" name="bill_charge_code[]" class="form-control" value="<?php echo $rows['bill_charge_code']; ?>" style="width: 100%" readonly>
                                        <td style="background-color:powderblue; text-align: left; width:220px; font-weight:bold"><?php if ($rows['flat_no'] > $disflag) {
                                                                                                        echo $rows['owner_name'];
                                                                                                        $disflag = $rows['flat_no'];
                                                                                                    } else {
                                                                                                        echo "";
                                                                                                    } ?></td>
                                        <td>
                                            <input type="text" name="flat_no" class="form-control" value="<?php echo $rows['flat_no']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td hidden>
                                            <input type="text" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="bill_charge_name[]" class="form-control" value="<?php echo $rows['bill_charge_name']; ?>" style="width: 180px" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="bill_pay_method[]" class="form-control" value="<?php echo $rows['bill_pay_method']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td hidden>
                                            <input type="text" name="pay_curr[]" class="form-control" value="<?php echo $rows['pay_curr']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td >
                                            <input type="text" name="bill_fixed_amt[]" class="form-control" value="<?php echo $rows['bill_fixed_amt']; ?>" style="width: 100px" required>
                                        </td>
                                        <td>
                                            <input type="date" name="effect_date[]" class="form-control" value="<?php echo $rows['effect_date']; ?>" style="width: 170px">
                                        </td>
                                        <td>
                                            <input type="date" name="terminate_date[]" class="form-control" value="<?php echo $rows['terminate_date']; ?>" style="width: 170px">
                                        </td>
                                        <td>
                                            <select name="allow_flag[]" class="form-control" style="width: 100px">
                                                <option value="1" <?php if ($rows['allow_flag'] == 1) { ?> selected="selected" <?php } ?>>Active</option>
                                                <option value="0" <?php if ($rows['allow_flag'] == 0) { ?> selected="selected" <?php } ?>>Inactive</option>
                                            </select>
                                        </td>
                                    </tr>
                                    
                            <?php
                                }
                            }
                            ?>
                    </tbody>
                </table>
<?php
                        
            }
          }else{
            ?>

            

    <div class="row">
      <div class="col-md-12">
          <div class="card" id="servicesListForm">
            <div class="card-header" style="background-color:#FFBF00 ">
              <h4 style="text-align:center; ">Assign Services to Owner</h4>
            </div>
            <div class="card-body">
              <table style="width: 100%">
                <tbody>
                  <tr>
                  
                          <table class="table bg-light table-bordered table-sm">
                   <thead>
                         <tr>
                            <th>Owner Name</th>
                            <th>Flat Number</th>
                            <th>Services Name</th>
                            <th>Pay Method</th>
                            <th>Bill Amount</th>
                            <th>Effect Date</th>
                            <th>Terminat Name</th>
                            <th>Active Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $disflag = '0';
                       $sqlowner ="SELECT  Flat_no FROM apart_owner_sevice_facility where flat_no='$flat_no'";
                       $queryowner = mysqli_query($conn, $sqlowner);
                        $rowcount = mysqli_num_rows($queryowner);
                        if ($rowcount == '0') {
                            $Sqlinsert = "INSERT INTO `apart_owner_sevice_facility`
                             (`office_code`,`flat_no`,`bill_charge_code`,`bill_charge_name`, 
                             `bill_pay_frequency`, bill_pay_method,pay_curr,bill_fixed_amt, ss_creator, ss_creator_on, ss_org_no) 
                             SELECT flat_info.office_code,flat_info.flat_no, 
                             apart_bill_charge_setup.bill_charge_code,apart_bill_charge_setup.bill_charge_name, 
                             apart_bill_charge_setup.bill_pay_frequency,apart_bill_charge_setup.bill_pay_method,
                             apart_bill_charge_setup.pay_curr,apart_bill_charge_setup.bill_fixed_amt, 
                             apart_bill_charge_setup.ss_creator, apart_bill_charge_setup.ss_created_on, 
                             apart_bill_charge_setup.ss_org_no FROM flat_info, apart_bill_charge_setup  
                            WHERE  flat_info.flat_no='$flat_no'";
                            $query = mysqli_query($conn, $Sqlinsert);
                        }
                      
                        $sql = "SELECT apart_owner_sevice_facility.id,apart_owner_sevice_facility.office_code,
                        apart_owner_sevice_facility.owner_id,apart_owner_sevice_facility.flat_no,
                         apart_owner_sevice_facility.bill_charge_code,
                          apart_owner_sevice_facility.bill_charge_name,apart_owner_sevice_facility.bill_pay_frequency,
                          apart_owner_sevice_facility.bill_pay_method,apart_owner_sevice_facility.pay_curr,
                          apart_owner_sevice_facility.bill_fixed_amt, apart_owner_sevice_facility.effect_date,
                          apart_owner_sevice_facility.terminate_date, apart_owner_sevice_facility.allow_flag
                    
                          FROM apart_owner_sevice_facility 
                          WHERE 
                      
                 apart_owner_sevice_facility.flat_no='$flat_no'
                           order by apart_owner_sevice_facility.id ,apart_owner_sevice_facility.bill_charge_code";
                        $query = mysqli_query($conn, $sql);
                        if (!empty($query)) {
                            if (is_array($query) || is_object($query)) {
                                while ($rows = $query->fetch_assoc()) {
                        ?>
                                    <tr>
                                        <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>
                                        <input type="hidden" name="bill_charge_code[]" class="form-control" value="<?php echo $rows['bill_charge_code']; ?>" style="width: 100%" readonly>
                                        <td style="background-color:powderblue; text-align: left; width:220px; font-weight:bold"><?php if ($rows['flat_no'] > $disflag) {
                                                                                                        echo "<input type='text' readonly id='woner' class='woner' style='background-color:powderblue; text-align: left; width:120px; font-weight:bold;border:none;'>";
                                                                                                        $disflag = $rows['flat_no'];
                                                                                                    } else {
                                                                                                        echo "";
                                                                                                    } ?></td>
                                        <td>
                                            <input type="text" name="flat_no" class="form-control" value="<?php echo $rows['flat_no']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td hidden>
                                            <input type="text" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="bill_charge_name[]" class="form-control" value="<?php echo $rows['bill_charge_name']; ?>" style="width: 180px" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="bill_pay_method[]" class="form-control" value="<?php echo $rows['bill_pay_method']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td hidden>
                                            <input type="text" name="pay_curr[]" class="form-control" value="<?php echo $rows['pay_curr']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td >
                                            <input type="text" name="bill_fixed_amt[]" class="form-control" value="<?php echo $rows['bill_fixed_amt']; ?>" style="width: 100px" required>
                                        </td>
                                        <td>
                                            <input type="date" name="effect_date[]" class="form-control" value="<?php echo $rows['effect_date']; ?>" style="width: 170px">
                                        </td>
                                        <td>
                                            <input type="date" name="terminate_date[]" class="form-control" value="<?php echo $rows['terminate_date']; ?>" style="width: 170px">
                                        </td>
                                        <td>
                                            <select name="allow_flag[]" class="form-control" style="width: 100px">
                                                <option value="1" <?php if ($rows['allow_flag'] == 1) { ?> selected="selected" <?php } ?>>Active</option>
                                                <option value="0" <?php if ($rows['allow_flag'] == 0) { ?> selected="selected" <?php } ?>>Inactive</option>
                                            </select>
                                        </td>
                                        
                                    </tr>
                                   
                            <?php
                                }
                            }
                            ?>
                    </tbody>
                </table>
            <?php

                          }
          }
?>


<input type="submit" style="background-color:#FFBF00" value="Submit" id="register" class=" btn btn-primary form-control text-center" name="SubBtn">
      </form>
          </div>
      
        <!-- end of service facility -->
        </div>
         <!-- form close  -->
         <?php
          if (!empty($message)) {
            echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
          } else {
          }
          if (!empty($mess)) {
            echo '<script type="text/javascript">
          Swal.fire({
              icon: "error",
              title: "oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
          } else {
          }
          ?>

      </div>
    </div>
    </main>


<!-- // owner add modal -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Add Owner </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

               

                    <div class="modal-body">

                    <form action="addowner.php?flat_no=<?php echo $flatid?>" method="post" enctype="multipart/form-data">
                <!--Owner under Office -->
          
                
                <!-- owner_name  -->
                <script>
                  function owner_check_availability() {
                    var name = $("#owner_name").val();
                    $("#loaderIcon").show();
                    jQuery.ajax({
                      url: "owner_check_availability.php",
                      data: 'owner_name=' + name,
                      type: "POST",
                      success: function(data) {
                        $("#name_availability_status").html(data);
                        $("#loaderIcon").hide();
                      },
                      error: function() {}
                    });
                  }
                </script>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Name</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="owner_name" onkeyup="owner_check_availability()" name="owner_name" required>
                    <tr>
                      <th width="24%" scope="row"></th>
                      <td><span id="name_availability_status"></span></td>
                    </tr>
                  </div>
                </div>

                <!-- Flat No.
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Residential No.</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="flat_no">
                  </div>
                </div> -->
                <!-- father_hus_name -->
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Father Name</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="" name="father_hus_name">
                  </div>
                </div>
                <!-- mother_name -->
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Mother Name</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="" name="mother_name">
                  </div>
                </div>
                <!-- NID -->
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">NID</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="" name="nid">
                  </div>
                </div>
                <!-- passport_no  -->
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Passport No.</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="" name="passport_no">
                  </div>
                </div>
                <!-- date_of_birth  -->
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Date of Birth.</label>
                  <div class="col-sm-8">
                    <input type="date" class="form-control" id="" name="date_of_birth">
                  </div>
                </div>
                <!-- Mobile No.  -->
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Mobile Number</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="" name="mobile_no" required>
                  </div>
                </div>
                <!-- intercom_number  -->
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Intercome Number</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="" name="intercom_number">
                  </div>
                </div>
                <!-- permanent_add  -->
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Parmenant Address</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="" name="permanent_add">
                  </div>
                </div>
                <!-- profession  -->
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Profession</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="" name="profession">
                  </div>
                </div>
                <!-- owner_image  -->
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Owner Photograph</label>
                  <div class="col-sm-8">
                    <input type="file" name="image" class="form-control">
                  </div>
                </div>
                <!-- submit  -->
              
          
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="ownerSubmit" class="btn btn-primary">Add Owner</button>
                    </div>
                </form>

            </div>
        </div>
    </div>



<!-- // Edit Flat  modal -->
    <div class="modal fade" id="editmodal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Password Conformation </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

               

                    <div class="modal-body">

                  
                <!-- ======= Password======-->
                <div class="form-row form-group">
                  <div class="col-sm-12">
                    <div class="card">
                      <div class="card-header">
                      Super Admin Password
                      </div>
                      <div class="card-body">
                        <!---=====Flat No.======-->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">PASSWORD</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="password" class="form-control" id="password" name="password">
                          </div>
                        </div>
                    
                      
                      </div>
                    </div>
                  </div>
                </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="passwordSubmit" name="passwordSubmit" class="btn btn-primary">SUBMIT</button>
                    </div>
               

            </div>
        </div>
    </div>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#1302000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded');
  });
</script>

<script>
        $(document).ready(function () {

            $('#addowner').on('click', function () {

              
              $('#editmodal').modal('show');
                // $tr = $(this).closest('tr');

                // var data = $tr.children("td").map(function () {
                //     return $(this).text();
                // }).get();

              
            });

           

            
        });
    </script>





<script>

$('#owner_id').on('change', function() {

 var a=$("#owner_id :selected").text();
 var b= $('#woner').val(a);

 var owner_id=$("#owner_id :selected").val();
 var flat_no= $('#flat_no').val();


  $.ajax({      
                url: "getAccountInfoAjax.php",
                method: "get",
                data: {
                    owner_id: owner_id,
                    flat_no :flat_no
                },
                success: function(data) {
                    console.log(data);
                    //$('#accountName').data(data);
                    //$('#city').data('<option value="">Select accountName first</option>'); 
                   // $("#accountName").val(tanent_name);
                    $("#acc_code").val(data);
                    $("#acc_code2").val(data);
                }
            });
 
  //console.log(b);
  //alert( b );
});
</script>

<script>

$('#acc_on').on('change', function(e) {

     
            e.preventDefault;
            var item_no = this.value;

 
            if(item_no==1){

            var flat_name=$('#flat_name').val();

             //alert(a);


            $("#accountName").val(flat_name);
            
            }


            if(item_no==2){

              var a=$("#owner_id :selected").text();

             // alert(a);


              $("#accountName").val(a);
               
            }
            if(item_no==3){

              var tanent_name=$('#tanent_name').val();

              //alert(tanent_name);


              $("#accountName").val(tanent_name);
               
            }

        })


</script>

<script>


$( "#owner_trans" ).click(function() {


  if ($("#owner_trans").is(":checked")) {


 
              $('#editmodal1').modal('show');
              
              $( "#passwordSubmit" ).click(function() {


                var password= $('#password').val();
                 

                $.ajax({      
                url: "passwordCheack.php",
                dataType:"json",
                method: "get",
                data: {
                  password: password
                   
                },
                success: function(data) {

               
if(data==1){
        $('#editmodal1').modal('hide');
        $('#owner_id').prop('disabled', false);
        $('#acc_on').prop('disabled', false);
}else{
  alert("Worng Password");
}
                   // console.log(data);
                   
                
                }
            });

              });
             

              
        

       
        

    }
    else {
        $('#owner_id').prop('disabled', 'disabled');
        $('#acc_on').prop('disabled', 'disabled');
       
    }
  
  // $('#owner_id').prop('disabled', false);
});

</script>

</body>

</html>