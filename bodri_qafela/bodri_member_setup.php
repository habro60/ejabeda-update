<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['SubBtn'])) {

        $id = $_GET['id'];
        $office_code = $_SESSION['office_code'];
        $acc_code = $_POST['acc_code'];
        $member_no = $_POST['member_no'];
        $acc_head = $_POST['full_name'];
        $postable_acc = 'Y';
        $rep_glcode = $_POST['rep_glcode'];
        $category_code = $_POST['category_code'];
        $acc_level = $_POST['acc_level'];
        $acc_type = $_POST['acc_type'];
        $parent_acc_code = $_POST['parent_acc_code'];
        $subsidiary_group_code=$_POST['subsidiary_group_code'];
      
        $ss_creator = $_SESSION['username'];
        $ss_org_no = $_SESSION['org_no'];
        
     $duplicate_count="SELECT COUNT(`id`) AS CC FROM `gl_acc_code` WHERE `acc_code`='$acc_code' GROUP BY `acc_code`";
           $selectQueryResult2 = $conn->query($duplicate_count);
           $row22 = $selectQueryResult2->fetch_assoc();
        
//         $duplicate_count="SELECT COUNT(`id`) FROM `gl_acc_code` WHERE `acc_code='$acc_code'";
//   $result=$conn->query($duplicate_count);
//   $final=$result->fetch_assoc();
  
  $total_gl=intval($row22['CC']);

// echo $total_gl;
// die;
      
        if($total_gl==0){
            
            $insertQuery = "INSERT INTO `gl_acc_code` (`id`,`office_code`, `acc_code`, `acc_head`, `postable_acc`,`rep_glcode`,`category_code`,`acc_level`,`acc_type`,`parent_acc_code`,subsidiary_group_code,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$acc_code',concat('$member_no','$acc_head'),'$postable_acc','$rep_glcode','$category_code','$acc_level','$acc_type','$parent_acc_code','$subsidiary_group_code','$ss_creator',now(),'$ss_org_no')";
        $conn->query($insertQuery);
            
        }
       
      
    
        // echo $insertQuery;
        // exit;
        if ($conn->affected_rows == 1) {
          $mess = "Save Successfully";
       
        } else {
          $mess = "Failled!";
          header("refresh:2;bodri_gl_account_add.php");
        }
        $conn->query("UPDATE `fund_member` SET `gl_acc_code`='$acc_code' WHERE full_name='$acc_head'");


  //update owner id and flat no
   
  for ($count = 0; $count < count($_POST['member_id']); ++$count) {
    $id = $_POST['id'][$count];
    $member_id = $_POST['member_id'][$count];
    $allow_flag = $_POST['allow_flag'][$count];
    $effect_date = $_POST['effect_date'][$count];
    $donner_pay_amt=$_POST['donner_pay_amt'][$count];
    $num_of_pay=$_POST['num_of_pay'][$count];
    $terminate_date = $_POST['terminate_date'][$count];
    $ss_creator = $_SESSION['username'];
    $ss_creator_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    if ($member_id > 0) {
      $query = "update donner_fund_detail set `allow_flag`='$allow_flag', `donner_pay_amt`='$donner_pay_amt',`num_of_pay`='$num_of_pay',`last_paid_date`='$effect_date',`effect_date`='$effect_date',`terminate_date`='$terminate_date', ss_creator='$ss_creator', ss_creator_on='$ss_creator_on', ss_org_no='$ss_org_no' where id='$id'";
   
     $cheack= $conn->query($query);
    }

    // echo  $cheack;
    // exit;
    if ($conn->affected_rows == TRUE) {
      $mess = "Successfully";
    } else {
      $assign_menu_failled = "Failled";
    }
  }
 
   

// die;

    //header('refresh:1;bodri_mem_reg.php');
    
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=bodri_mem_reg.php\">";

      
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
      <h1><i class="fa fa-dashboard"></i> Bodri Member Setup Information</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
    <a href="bodri_mem_reg.php" class="btn btn-outline-info btn-sm mt-1">
<i class="fa fa-arrow-left"></i><span> BACK</span></a>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-10 mx-auto">
      <!-- -------------------------------->
      <?php if (isset($message)) echo $message; ?>
      <form method="post"  enctype="multipart/form-data">

        <!-- Flat No, & taneant Under Flat -->
        <div  class="form-row form-group">
          <label class="col-sm-2 col-form-label">Member</label>
          
          <div class="col-sm-6  mb-3">
            
          <?php
          $memberId=$_GET['id'];

        
          $member_information="SELECT fund_member.member_id,fund_member.gl_acc_code,fund_member.office_code,fund_member.member_no,fund_member.full_name,fund_member.mobile,office_info.office_name 
          FROM fund_member,
           office_info WHERE fund_member.office_code=office_info.office_code AND fund_member.member_id='$memberId' ";
           $selectQueryResult = $conn->query($member_information);
           $row = $selectQueryResult->fetch_assoc();
           $old_member_id=$row['member_id'];
           $old_gl_code=$row['gl_acc_code'];

          
           ?>

           
         
          <select readonly style="text-align:left;" name="member_no" class="form-control">
             
                            <?php
                            echo '<option disabled value="' . $row['member_no'] . '" selected="selected">' . $row['full_name'] . '</option>';
                               
                            ?>
              </select>

            
          </div>
        
          <!-- <button type="button"  id="updatewflat" name="updatewflat" class="btn btn-danger mb-3" style="text-align:right;"><span class=" fa fa-plus"></span></button> -->




           <!-- NID and Passport No. -->


           <?php
$selectQuery = "select * from gl_acc_code where subsidiary_group_code='400' and `postable_acc`='N'";
$selectQueryReuslt = $conn->query($selectQuery);
$row = $selectQueryReuslt->fetch_assoc();

$id=$row['id'];
$query = "Select Max(acc_code) FROM gl_acc_code where `parent_acc_code`='$id'";
// $query = "Select Max(acc_code) FROM gl_acc_code where `id`='$id'";

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
?>
<?php
if (isset($_GET['id'])) {
  $idno = $_GET['id'];
  $selectQuery = "SELECT member_no,full_name FROM `fund_member` WHERE `member_id`='$idno'";
  $selectQueryReuslt = $conn->query($selectQuery);
  $row_member = $selectQueryReuslt->fetch_assoc();

}
?>
  
  <div class="col-md-12">
      <!-- form start  -->
  
        <!-- uner account -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Sub Account Under</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" value="<?php echo $row['acc_head'] ?>" readonly>
          </div>
        </div>
        <!-- acc conde  -->

        <?php
          if($old_gl_code){
          ?>

<div class="form-group row">
          <label class="col-sm-2 col-form-label">Account Code</label>
          <div class="col-sm-6">
          <input type="hidden" name="acc_code" class="form-control" autofocus value="<?php echo $old_gl_code; ?>" readonly>
         <input type="text" class="form-control" id="" name="rep_glcode" value=<?php echo $old_gl_code; ?> readonly>
          </div>
        </div>
         
         
          <?php
          }else{
            ?>

<div class="form-group row">
          <label class="col-sm-2 col-form-label">Account Code</label>
          <div class="col-sm-6">
          <input type="hidden" name="acc_code" class="form-control" autofocus value="<?php echo $lastRow; ?>" readonly>
          <input type="text" class="form-control" id="" name="rep_glcode" value=<?php echo $lastRow; ?> readonly>
          </div>
        </div>

          

            <?php
          }


          ?>

        <div class="form-group row">
          <!-- <label class="col-sm-2 col-form-label">Account Name</label> -->
          <div class="col-sm-6">
                <input type="hidden" name="full_name" class="form-control" value="<?php echo $row_member['full_name']; ?>" readonly>
          </div>
          <div class="col-sm-6">
                <input type="hidden" name="member_no" class="form-control" value="<?php echo $row_member['member_no']; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <!-- <label class="col-sm-2 col-form-label">Reporting GL Code</label> -->
          <div class="col-sm-6">
            <input type="hidden" class="form-control" id="" name="rep_glcode">
          </div>
        </div>
        
        <div>
        <!-- category  hidden but input value by catagory-->
        <input type="text" class="form-control" id="" value="<?php echo $row['subsidiary_group_code']; ?>" name="subsidiary_group_code" hidden>
        <input type="text" class="form-control" id="" value="<?php echo $row['category_code']; ?>" name="category_code" hidden>
        <input type="text" class="form-control" id="" value="<?php echo $row['acc_type']; ?>" name="acc_type" hidden>

        
        <!-- hidden parant account code and account level set up-->
        <input type="number" class="form-control" name="parent_acc_code" value="<?php echo $row['id']; ?>" hidden>
        <input type="text" name="acc_level" class="form-control"  value="<?php echo $lastRows; ?>" hidden>
                                                                                                         </div>
        
    
    </div>
      <!-- -------------------------------->
      <?php
      if (!empty($mess)) {
        // echo '<script type="text/javascript">
        //     Swal.fire(
        //         "Save Successfully!!",
        //         "Welcome ' . $_SESSION['username'] . '",
        //         "success"
        //       )
        //     </script>';
            
             echo '<script type="text/javascript">
          Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
          
      } else {
      }
      if (!empty($message)) {
        // echo '<script type="text/javascript">
        //   Swal.fire({
        //       icon: "error",
        //       title: "Oops...",
        //       text: "Sorry ' . $_SESSION['username'] . '",
        //     });
        //   </script>';
        
         echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
            
      } else {
      }
      ?>

  </div>





 

  <?php
//  echo $memberId;
//  die;

if ($memberId) {
 
?>

<div class="row">
      <div class="col-md-12">
          <div class="card" id="donorFundAssigned">
            <div class="card-header" style="background-color:#85C1E9">
              <h4 style="text-align:center">Assign Donor/Member Contribution</h4>
            </div>

  <div class="card-body">
              <table style="width: 100%">
                <tbody>
                  <tr>
                  
                          <table class="table bg-light table-bordered table-sm">
                   <thead>
                         <tr>
                          <th>Donner</th>
                          <th>fund Name</th>
                          <th>Pay Frequency</th>
                          <th>Pay Method</th>
                          <th>Pay Amount</th>
                          <th>Donner Pay Amount</th>
                          <th>Number of Pay</th>
                          <th>Effect Date</th>
                          <th>Terminated Date</th>
                          <th style="width: 100px;">Active Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $disflag = '1';
                        $sql ="SELECT member_id  FROM donner_fund_detail where member_id='$memberId'";
                        $query = mysqli_query($conn, $sql);
                        $rowcount = mysqli_num_rows($query);



                        if ($rowcount == '0') {
                            $Sqlinsert = "INSERT INTO  donner_fund_detail (office_code,member_id, gl_acc_code,fund_type, fund_type_desc, fund_pay_frequency, pay_method, pay_curr, pay_amt, num_of_pay, donner_pay_amt,num_of_paid,allow_flag, effect_date, terminate_date,`ss_creator`,`ss_creator_on`,`ss_org_no`)  select `office_code`,'$memberId','0',`fund_type`,`fund_type_desc`,`fund_pay_frequency`,`pay_method`,`pay_curr`,`pay_amt`,'0','0','0','0','9999-09-99','9999-99-99',`ss_creator`,`ss_created_on`,`ss_org_no` from fund_type_setup ";
                            $query = mysqli_query($conn, $Sqlinsert);
                        }
                        $sql = "select donner_fund_detail.id,donner_fund_detail.office_code,donner_fund_detail.member_id,donner_fund_detail.fund_type,donner_fund_detail.fund_type_desc,donner_fund_detail.fund_pay_frequency,donner_fund_detail.pay_method,donner_fund_detail.pay_curr,donner_fund_detail.pay_amt,donner_fund_detail.allow_flag,donner_fund_detail.num_of_pay,donner_fund_detail.donner_pay_amt,donner_fund_detail.num_of_paid,donner_fund_detail.donner_paid_amt,donner_fund_detail.fund_paid_flag,donner_fund_detail.last_paid_date,donner_fund_detail.effect_date,donner_fund_detail.terminate_date,fund_member.full_name from donner_fund_detail,fund_member where fund_member.member_id=donner_fund_detail.member_id and donner_fund_detail.member_id='$memberId'";
                        $query = mysqli_query($conn, $sql);
                        if (!empty($query)) {
                            if (is_array($query) || is_object($query)) {
                                while ($rows = $query->fetch_assoc()) {
                        ?>
                          <tr>
                              <input type="hidden" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                              <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>
                              <input type="hidden" name="fund_type[]" class="form-control" value="<?php echo $rows['fund_type']; ?>" style="width: 100%" readonly>
                              
                              <td style="background-color:powderblue; text-align: left"><strong><?php if ($disflag == 1) {
                                                                                                  echo $rows['full_name'];
                                                                                                  $disflag = 0;
                                                                                                } else {
                                                                                                  echo "";
                                                                                                } ?></strong>
                              </td>
                              <td>
                                <input type="text" name="fund_type_desc[]" class="form-control" value="<?php echo $rows['fund_type_desc']; ?>" style="width: 100%" readonly>
                              </td>
                              <td>
                                <input type="text" name="fund_pay_frequency[]" class="form-control" value="<?php echo $rows['fund_pay_frequency']; ?>" style="width: 100%" readonly>

                              </td>
                              <td>
                                <input type="text" name="pay_method[]" class="form-control" value="<?php echo $rows['pay_method']; ?>" style="width: 100%" readonly>

                              </td>
                             
                              <td>
                                <input type="text" name="pay_amt[]" class="form-control" value="<?php echo $rows['pay_amt']; ?>" style="width: 100%" readonly>
                              </td>
                              <td>
                                <input type="text" name="donner_pay_amt[]" class="form-control" value="<?php echo $rows['donner_pay_amt']; ?>" style="width: 100%">
                              </td>
                              <td>
                                <input type="text" name="num_of_pay[]" class="form-control" value="<?php echo $rows['num_of_pay']; ?>" style="width: 100%">
                              </td>
                              <td>
                                <input type="date" name="effect_date[]" class="form-control" value="<?php echo $rows['effect_date']; ?>" style="width: 100%">
                              </td>
                              <td>
                                <input type="date" name="terminate_date[]" class="form-control" value="<?php echo $rows['terminate_date']; ?>" style="width: 100%">
                              </td>
                              <td>
                                <select name="allow_flag[]" id="" class="form-control hh" style="width: 100%">
                                  <option value="1" <?php if ($rows['allow_flag'] == 1) { ?> selected="selected" <?php } ?>>Allow</option>
                                  <option value="0" <?php if ($rows['allow_flag'] == 0) { ?> selected="selected" <?php } ?>>Not Allow</option>
                                </select>
                              </td>
                              <input type="hidden" name="member_id[]" value="<?php echo $rows['member_id']; ?>" class="">
                            </tr>
                                <input type="hidden" name="member" value="<?php echo $rows['member_id']; ?>">
                            <?php
                                }
                            }
                            ?>
                    </tbody>
                </table>
    <input name="SubBtn" type="submit" id="submit" value="Submit" class="btn btn-info pull-right submit" />
<?php
            }
?>
          </div>
        <?php
      } else {





        echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
      } ?>
        <!-- end of service facility -->
        </div>
         <!-- form close  -->
         <?php
          if (!empty($mess)) {
            echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
          } else {
          }
          if (!empty($message)) {
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


        </form>
</div>
    </div>



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

            $('#updatewflat').on('click', function () {

              
              $('#editmodal1').modal('show');
                // $tr = $(this).closest('tr');

                // var data = $tr.children("td").map(function () {
                //     return $(this).text();
                // }).get();

              
            });

            
        });
    </script>





<script>
$('#ttt').on('change', function() {
  var a=$("#ttt :selected").text();
 var b= $('#woner').val(a);
  console.log(b);
  //alert( a );
});

$('#acc_on').on('change', function(e) {

     
            e.preventDefault;
            var item_no = this.value;
            $.ajax({
                url: "getAccountInfoAjax.php",
                method: "get",
                data: {
                    item_no_soft: item_no
                },
                success: function(html) {
                    console.log(html);
                    $('#accountName').html(html);
                    $('#city').html('<option value="">Select accountName first</option>'); 
                   // $('.item_unit').val(response);
                }
            });
            $.ajax({
                url: "getAccountInfoAjax.php",
                method: "get",
                data: {
                    item_no_des: item_no
                },
                success: function(response) {
                    console.log(response);

                    $('.item_unit_name').val(response);
                }
            });
        })



</script>


</body>

</html>