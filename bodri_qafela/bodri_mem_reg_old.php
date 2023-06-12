<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['memberSubmit'])) {
  $error = false;
  // $gl_acc_code = $_POST['gl_acc_code'];
  $member_no = $_POST['member_no'];
  $office_code = $_SESSION['office_code'];
  $member_type = $_POST['member_type'];
  $full_name = $_POST['full_name'];
  $father_name = $_POST['f_name'];
  $mother_name = $_POST['m_name'];
  $husband_name = $_POST['h_name'];
  $email = $_POST['email'];
  $mobile = $_POST['mobile'];
  $nid_birth_no = $_POST['nid_birth_no'];
  $passport_no = $_POST['passport_no'];
  $blood_group = $_POST['blood_group'];
  $dob = $_POST['dob'];
  $village = $_POST['village'];
  $division = $_POST['division'];
  $district = $_POST['district'];
  $upazila = $_POST['upazila'];
  $p_office = $_POST['p_office'];

  $p_village = $_POST['p_village'];
  $p_division = $_POST['p_division'];
  $p_district = $_POST['p_district'];
  $p_upazila = $_POST['p_upazila'];
  $p_p_office = $_POST['p_p_office'];

  $referred_person_type = $_POST['referred_person_type'];
  $referred_person_id = $_POST['referred_person_id'];
  // $referred_person = $_POST['referred_person'];

  $activation_key = $_POST['activation_key'];
  $ss_creator = $_SESSION['username'];
  $ss_org_no = $_SESSION['org_no'];

  $insertQuery = "INSERT INTO `fund_member` (member_id,member_no,office_code,member_type,full_name,father_name,mother_name,husband_name,email,mobile,nid_birth_no,passport_no,blood_group,dob,village,division,district,upazila,p_office,p_village,p_division,p_district,p_upazila,p_p_office,referred_person_type,referred_person_id,activation_key,ss_creator,ss_creator_on,ss_org_no) VALUES (NULL,'$member_no','$office_code','$member_type','$full_name','$father_name','$mother_name','$husband_name','$email','$mobile','$nid_birth_no','$passport_no','$blood_group','$dob','$village','$division','$district','$upazila','$p_office','$p_village','$p_division','$p_district','$p_upazila','$p_p_office','$referred_person_type','$referred_person_id','$activation_key','$ss_creator',now(),'$ss_org_no')";

// echo $insertQuery;
// exit;

  $conn->query($insertQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully!";
    require "../bodri_qafela/SMS_memb_reg.php";

  } else {
    $mess = "Failled!";
  }
  header('refresh:2;../bodri_qafela/bodri_mem_reg.php');
} elseif (isset($_POST['submit'])) {
  $a = $_POST['member'];
  $deleteQuery = "DELETE FROM donner_fund_detail WHERE member_id ='$a'";

  $conn->query($deleteQuery);
  for ($count = 0; $count < count($_POST['member_id']); ++$count) {
    $member_no = $_POST['member_no'][$count];
    $office_code = $_POST['office_code'][$count];
    $member_id = $_POST['member_id'][$count];
    // $gl_acc_code = $_POST['gl_acc_code'][$count];
    $fund_type = $_POST['fund_type'][$count];
    $fund_type_desc = $_POST['fund_type_desc'][$count];
    $fund_pay_frequency = $_POST['fund_pay_frequency'][$count];
    $pay_method = $_POST['pay_method'][$count];
    $pay_curr = $_POST['pay_curr'][$count];
    $pay_amt = $_POST['pay_amt'][$count];
    $num_of_pay = $_POST['num_of_pay'][$count];
    $donner_pay_amt = $_POST['donner_pay_amt'][$count];
    $num_of_paid = '0';
    $allow_flag = $_POST['allow_flag'][$count];
    $effect_date = $_POST['effect_date'][$count];
    $terminate_date = $_POST['terminate_date'][$count];
    $ss_creator = $_SESSION['username'];
    $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    if ($member_id > 0) {
      $queryFund = "INSERT INTO  donner_fund_detail (id, office_code,member_id,member_no,gl_acc_code,fund_type, fund_type_desc, fund_pay_frequency, pay_method, pay_curr, pay_amt, num_of_pay, donner_pay_amt,num_of_paid,allow_flag, effect_date, terminate_date,`ss_creator`,`ss_creator_on`,`ss_org_no`) values (null,'$office_code','$member_id','0','$member_no','$fund_type','$fund_type_desc','$fund_pay_frequency','$pay_method','$pay_curr','$pay_amt', '$num_of_pay','$donner_pay_amt','$num_of_paid','$allow_flag','$effect_date','$terminate_date','$ss_creator','$ss_created_on','$ss_org_no')";
      echo $queryFund;
      exit;
      
      $conn->query($queryFund);
    }
    if ($conn->affected_rows == TRUE) {
      $assign_menu = "Successfully";
    } else {

      $assign_menu_failled = "Failled";
    }
  }

  header('refresh:2;bodri_mem_reg.php');
}



// $query = "Select Max(acc_code) From gl_acc_code where acc_level=1";
// $returnDrow = mysqli_query($conn, $query);
// $resultrow = mysqli_fetch_assoc($returnDrow);
// $maxRowsrow = $resultrow['Max(acc_code)'];
// if (empty($maxRowsrow)) {
//   $lastRowrow = $maxRowsrow = 100000000000;
// } else {
//   $lastRowrow = $maxRowsrow + 100000000000;
// }
require "../source/top.php";
$pid = 1005000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";

$querys = "select max(member_id) from fund_member";
$return = mysqli_query($conn, $querys);
$result = mysqli_fetch_assoc($return);
$maxMemID = $result['max(member_id)'];
$lastRow = $maxMemID + 1;

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Member Information</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>
    <!-- =================-- button define================= -->
    <div>
      <button id="memberAddBtn" class="btn btn-success"><i class="fa fa-plus"></i>Add member info. </button>
      <button id="memberListBtn" class="btn btn-primary"><i class="fa fa-eye"></i> Member List </button>
      <button id="memberGlListBtn" class="btn btn-info"><i class="fa fa-plus"></i>GL & Fund Assigned</button>
    </div>
    <!-- ====================button Define closed=============== -->
    <div class="row">
      <div class="col-md-12">
        <div>
          <br>
          <div id="memberForm" class="collapse">
            <div style="padding:5px">
              <!-- form start  -->
              <form action="" method="post">
                <!-- acc conde  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Member Number<span style="color:red;">* </span></label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="member_no" class="form-control" autofocus placeholder="member Number"  required>
                  </div>
                  <label class="col-sm-2 col-form-label">Member Type</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <select name="member_type" id="" class="form-control">
                      <!-- ----------------------------------->
                      <?php
                      $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "MTYPE" AND `softcode`>0';
                      $selectQueryResult =  $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                          echo '<option value="' . $row['softcode'] . '">' . $row['softcode'] . "." . $row['description'] . '</option>';
                        }
                      }
                      ?>
                    </select>
                    <!------------------------------------->
                  </div>
                </div>
                <!-- Name part -->
                <div class="form-row form-group">
                  <label class="col-sm-2 col-form-label">Full Name <span style="color:red">*</span></label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
                  </div>
                  <label class="col-sm-2 col-form-label">Father Name <span style="color:red">*</span></label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="f_name" class="form-control" placeholder="Father Name" required>
                  </div>
                </div>
                <div class="form-row form-group">
                  <label class="col-sm-2 col-form-label">Mother Name</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="m_name" class="form-control" placeholder="Mother Name">
                  </div>
                  <label class="col-sm-2 col-form-label">Spouse Name</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="h_name" class="form-control" placeholder="Spouse Name(if applicable)">
                  </div>
                </div>
                <!-- contract part -->
                <!-- script start  -->
                <script>
                  function checkemailAvailability() {
                    $("#loaderIcon").show();
                    jQuery.ajax({
                      url: "../common/check_availability.php",
                      data: 'memberemailid=' + $("#memberemailid").val(),
                      type: "POST",
                      success: function(data) {
                        $("#email-availability-status").html(data);
                        $("#loaderIcon").hide();
                      },
                      error: function() {}
                    });
                  }
                </script>
                <!-- script stop  -->
                <div class="form-row form-group">
                  <label class="col-sm-2 col-form-label">Email</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="email" name="email" class="form-control" id="memberemailid" onBlur="checkemailAvailability()" placeholder="admin@domain.com">
                    <tr>
                      <th width="24%" scope="row"></th>
                      <td><span id="email-availability-status"></span></td>
                    </tr>
                  </div>
                  <label class="col-sm-2 col-form-label">Mobile No <span style="color:red">*</span></label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="tel" id="phone" name="mobile" class="form-control" required>
                  </div>
                </div>
                <!-- nid/pasport part -->
                <div class="form-row form-group">
                  <label class="col-sm-2 col-form-label">NID/Birth Cer. No <span style="color:red">*</span></label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="nid_birth_no" class="form-control" id="validationServer01" placeholder="NID/Birth Cert. no" required>
                  </div>
                  <label class="col-sm-2 col-form-label">Passport</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="passport_no" class="form-control" placeholder="Passport No">
                  </div>
                </div>
                <!-- date of birth and blood group part -->
                <div class="form-row form-group">
                  <label class="col-sm-2 col-form-label">Blood Group</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <select name="blood_group" class="form-control">
                      <option value="NA">-Select Blood Group-</option>
                      <?php
                      $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "BGTYP" AND `softcode`>0';
                      $selectQueryResult =  $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                          echo '<option value="' . $row['softcode'] . '">' . $row['description'] . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                  <label class="col-sm-2 col-form-label">Date of Birth <span style="color:red">*</span></label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="date" name="dob" class="form-control" required>
                  </div>
                </div>


                <!-- address part -->
                <div class="form-row form-group">
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-header">
                        Present Address
                      </div>
                      <div class="card-body">
                        <!--------------------address script and php query---------------------------->
                        
                        <!------------------------------------------------>
                        <div class="form-row form-group">
                          <label for="inputPassword" class="col-sm-5 col-form-label">Village/Road/House/Flat</label>
                          <label for="" class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" name="village" id="village" placeholder="Village/Road#/House#/Flat#">
                          </div>
                        </div>
                        <!------------------------------------------->
                        <div class="form-row form-group">
                          <label for="inputPassword" class="col-sm-5 col-form-label">Division</label>
                          <label for="" class="col-form-label">:</label>
                          <div class="col">
                          <select name="division" id="division_id" class="form-control" onChange="getDistrict(this.value);">
                               <option value="">Select Division</option>
                              <?php
                              
                              $selectQuery = 'SELECT * FROM `divisions`';
                              $selectQueryResult = $conn->query($selectQuery);
                              if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                              ?>
                              <?php
                                  echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }
                              }
                              ?>
                           </select>
                          </div>
                        </div>
                       <!------------------------------------------->
                       <div class="form-row form-group">
                           <label class="col-sm-5 col-form-label">Dristrict</label>
                            <label class="col-form-label">:</label>
                            <div class="col">
                              <select name="district" id="district_id" class="form-control" onChange="getUpazilas(this.value);">
                              <option value="">Select Distict</option>
                           </select>
                         </div>
                        </div>
                 <!------------------------------------------->
                 <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">P.S./Upazila</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="upazila" id="upazilla_id" class="form-control">
                      <option value="">Select Upazila</option>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                        <div class="form-row form-group">
                          <label for="inputPassword" class="col-sm-5 col-form-label">Post Office</label>
                          <label for="" class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" name="p_office" id="p_office" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-header">
                        Permanent Address
                        <div class="pull-right both_same">
                          <input type="checkbox" name="both_same" id="both_same" onclick="return auto_fill_address();" /> <strong style="color:red"> Present address same as parmanent address.</strong><br />
                        </div>

                      </div>
                      <div class="card-body">
                        <div class="permanant_address">
                          <div class="form-row form-group">
                            <label for="inputPassword" class="col-sm-5 col-form-label">Village/Road/House/Flat</label>
                            <label for="" class="col-form-label">:</label>
                            <div class="col">
                              <input type="text" name="p_village" id="p_village" class="form-control" placeholder="Village/Road#/House#/Flat#">
                            </div>
                          </div>
                          <div class="form-row form-group">
                            <label for="inputPassword" class="col-sm-5 col-form-label">Division</label>
                            <label for="" class="col-form-label">:</label>
                            <div class="col">
                            <select name="p_division" id="p_division_id" class="form-control" onChange="p_getDistrict(this.value);">
                              <option value="">Select Division</option>
                              <?php
                              $selectQuery = 'SELECT * FROM `divisions`';
                              $selectQueryResult = $conn->query($selectQuery);
                              if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                              ?>
                              <?php
                                  echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }
                              }
                              ?>
                            </select>
                            </div>
                          </div>
                         <!------------------------------------------->
                          <div class="form-row form-group">
                            <label class="col-sm-5 col-form-label">Dristrict</label>
                            <label class="col-form-label">:</label>
                            <div class="col">
                              <select name="p_district" id="p_district_id" class="form-control" onChange="p_getUpazilas(this.value);">
                                <option value="">Select District</option>
                              </select>
                            </div>
                          </div>
                        
                          <!------------------------------------------->
                          <div class="form-row form-group">
                            <label class="col-sm-5 col-form-label">P.S./Upazila</label>
                            <label class="col-form-label">:</label>
                            <div class="col">
                              <select name="p_upazila" id="p_upazilla_id" class="form-control">
                                <option value="">Select Upazila</option>
                              </select>
                            </div>
                          </div>
                          <!------------------------------------------->
                          <div class="form-row form-group">
                            <label for="inputPassword" class="col-sm-5 col-form-label">Post Office</label>
                            <label for="" class="col-form-label">:</label>
                            <div class="col">
                              <input type="text" name="p_p_office" id="p_p_office" class="form-control">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row form-group">
                  <label class="col-sm-2 col-form-label">Refferred Person Type</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <select name="referred_person_type" class="form-control">
                      <?php
                      $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "RTYPE" AND `softcode`>0';
                      $selectQueryResult =  $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                          echo '<option value="' . $row['softcode'] . '">' . $row['softcode'] . '. ' . $row['description'] . '</option>';
                        }
                      }
                      ?>
                      
                    </select>
                  </div>
                
                  <label class="col-sm-2 col-form-label">Refferred Person</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <select name="referred_person_id" id="get_id" class="form-control" onChange="get_ref(this.value);">
                      <?php
                      $selectQuery = "SELECT * FROM `fund_ref_info` ";
                      $selectQueryResult =  $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                          echo '<option value="' . $row['reffered_id'] . '">' . $row['reffered_id'] . "." . $row['full_name'] . '</option>';
                        }
                      }
                      ?>
                    </select>

                  </div>
                  <label class="col-sm-3 col-form-label">Refferred Name</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <select name="referred_person" id="referred_person" class="form-control" type="text"></select>
                  </div>
                </div>
                <!-- Referred type End -->
                <input type="hidden" name="activation_key" value="0">
                
                <button type="submit" class="btn btn-primary" name="memberSubmit">Submit</button>
              </form>
            </div>
          </div>
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
          <!--== member View List ==-->
          <div id="table">
            <div class="tile" id="memberListForm">
              <div class="tile-body">
                <h5 style="text-align: center">Member List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="memberTable">
                  <thead>
                    <tr>
                      <th>Member Number</th>
                      <th>Name</th>
                      <th>Father/Husband Name</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Referrd Person</th>
                      <th>GL Account</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT member_id,member_no, full_name, father_name,email,mobile,referred_person, gl_acc_code FROM `fund_member` order by member_no";

                    //use for MySQLi-OOP
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                      echo
                        "<tr>
                           <td>" . $row['member_no'] . "</td>
                           <td>" . $row['full_name'] . "</td>
                           <td>" . $row['father_name'] . "</td>
                           <td>" . $row['email'] . "</td>
                           <td>" . $row['mobile'] . "</td>
                           <td>" . $row['referred_person'] . "</td>
                           <td>" . $row['gl_acc_code'] . "</td>
                           <td><a target='_blank' href='bodri_mem_reg_edit.php?id=" . $row['member_id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                           </td>
                         </tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- == General Ledger == -->
            <div class="tile" id="memberGLAddForm">
              <div class="tile-body">
                <h5 style="text-align: center">Member General Account List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                      <th>member Number</th>
                      <th>Member Name</th>
                      <th>Gl Account</th>
                      <th>Add GL A/C</th>
                      <th>Fund Assigned</th>
                    </tr>
                  </thead>


                 <!-- =============================== -->
                 <tbody>
                    <?php
                    $sql = "SELECT member_id,member_no, full_name, gl_acc_code FROM fund_member order by member_no";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row['member_no'] . "</td>";
                      echo "<td>" . $row['full_name'] . "</td>";
                      echo "<td>" . $row['gl_acc_code'] . "</td>";
                    ?> 
                   
                   <td><a <?php if ($row['gl_acc_code'] > '0') {
                                echo "onclick='return false";
                              } ?> <?php echo "href='bodri_gl_account_add.php?id=" . $row['member_id'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Add Gl Code</a>
                      </td>
                      <td><a  <?php echo "href='doner_fund_assigned.php?id=" . $row['member_id'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Fund Assigned</a>
                      </td>
                    <?php

                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
<!-- ==================================Fund Assigned============== -->
            <div class="card" id="fundTypeForm">
              
              </div>
            </div>
          <?php
        } else {
          echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
        } ?>
          <!-- Supplier Account View start -->
          </div>
        </div>
      </div>
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<!-- Data table plugin-->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#sampleTable').DataTable();
  $('#memberTable').DataTable();
</script>
<script type="text/javascript">
  function auto_fill_address() {
    var same_addr = document.getElementById("both_same").checked;
    // var same_addr = $("#both_same").val();
    var village = $("#village").val();
    var division_list = $('#division-list').val();
    var district_list = $('#district-list').val();
    var upazilla_list = $('#upazilla-list').val();
    var p_office = $("#p_office").val();
    if (same_addr) {
      if ((village == '' || village == null) || (p_office == '' || p_office == null)) {
        alert('please fill address and post');
        document.getElementById("both_same").checked = false;
      } else {
        $("#p_village").val(village);
        $("#p_p_office").val(p_office);
        $('#division-list').val(division_list);
        $('#district-list').val(district_list);
        $('#upazilla-list').val(upazilla_list);
      }
    } else {
      $("#p_village").val('');
      $("#p_p_office").val('');
      $('#division-list1').val('');
      $('#district-list1').val('');
      $('#upazilla-list1').val('');
    }
  }
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#901000").addClass('active');
    $("#900000").addClass('active');
    $("#900000").addClass('is-expanded')
  });

  // on change
  $('#submit').hide();
  $(document).on('change', '.member', function() {
    $('.member').val($(this).val());
    $(".member").addClass("intro");
    // show and hide
    $('#submit').show();
  });


  $('#memberGLAddForm').hide();
  $('#memberListForm').hide();
  $('#fundTypeForm').hide();
  
  // memberAddBtn
  $('#memberAddBtn').on('click', function() {
    $('#memberForm').show();
    $('#memberListForm').hide();
    $('#memberGLAddForm').hide();
    $('#fundTypeForm').hide();

  });
  // memberistBtn
  $('#memberListBtn').on('click', function() {
    $('#memberListForm').show();
    $('#memberGLAddForm').hide();
    $('#fundTypeForm').hide();
    $('#memberForm').hide();
  });
  // memberGlListBtn
  $("#memberGlListBtn").click(function() {

    $("#memberGLAddForm").show();
    $("#memberForm").hide();
    $("#memberListForm").hide();
    $('#fundTypeForm').hide();
  });
  // fundTypeBtn
  $("#fundTypeBtn").click(function() {
    $('#fundTypeForm').show();
    $("#memberListForm").hide();
    $('#memberGLAddForm').hide();
    $('#memberForm').hide();
  });
</script>

<script>
  function getDistrict(val) {
    $.ajax({
      type: "POST",
      url: "../common/getDistrict.php",
      data: 'division_id=' + val,
      success: function(data) {
        $("#district_id").html(data);
        getUpazilas();
      }
    });
  }

  function getUpazilas(val) {
    $.ajax({
      type: "POST",
      // url: "../common/getUpazilas.php",
      url: "../common/getDistrict.php",
      data: 'district_id=' + val,
      success: function(data) {
        $("#upazilla_id").html(data);
      }
    });
  }

  function p_getDistrict(val) {
    $.ajax({
      type: "POST",
      url: "../common/getDistrict1.php",
      data: 'p_division_id=' + val,
      success: function(data) {
        $("#p_district_id").html(data);
        p_getUpazilas();
      }
    });
  }

  function p_getUpazilas(val) {
    $.ajax({
      type: "POST",
      // url: "../common/getUpazilas.php",
      url: "../common/getDistrict1.php",
      data: 'p_district_id=' + val,
      success: function(data) {
        $("#p_upazilla_id").html(data);
      }
    });
  }

  function get_ref(val) {
    $.ajax({
      type: "POST",
      url: "getRefInfo.php",
      data: 'reffered_id=' + val,
      success: function(data) {
        $("#get_id").html(data);
      }
    });
  }

  //   $(document).ready(function() {
  //     $('.both_same').on('click', function name() {
  // var both_same =  $('.both_same').val();
  //   if(both_same.checked) {
  //     alert(this.value);
  //   } else {
  //     alert();
  //   }

  //     });
  //   });
</script>
<?php
$conn->close();
?>
</body>

</html>