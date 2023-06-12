<?php
require "../auth/auth.php";
require "../database.php";
if (!empty($_GET['id'])) {
  $emp_no = $_GET['id'];
  $sql = "SELECT * FROM sm_hr_emp WHERE emp_no = $emp_no";
  $query = $conn->query($sql);
  $data = $query->fetch_assoc();
}

if (isset($_POST['SubBtn'])) {
  $emp_id = ($_POST['emp_id']);
  $office_code = $conn->real_escape_string($_POST['office_type']);
  $desig_code = $conn->real_escape_string($_POST['desig_code']);
  $join_date = $conn->real_escape_string($_POST['join_date']);
  $f_name = $conn->real_escape_string($_POST['f_name']);
  $l_name = $conn->real_escape_string($_POST['l_name']);
  $father_name = $conn->real_escape_string($_POST['father_name']);
  $mother_name = $conn->real_escape_string($_POST['mother_name']);
  $husband_name = $conn->real_escape_string($_POST['husband_name']);
  $gender = $conn->real_escape_string($_POST['gender']);
  $dob = $conn->real_escape_string($_POST['dob']);
  $blood_group = $conn->real_escape_string($_POST['blood_group']);
  $religion = $conn->real_escape_string($_POST['religion']);
  $marital_status = $conn->real_escape_string($_POST['marital_status']);
  $email_personal = $conn->real_escape_string($_POST['email_personal']);
  $email_official = $conn->real_escape_string($_POST['email_official']);
  $phone_home = $conn->real_escape_string($_POST['phone_home']);
  $phone_mobile = $conn->real_escape_string($_POST['phone_mobile']);
  $phone_office = $conn->real_escape_string($_POST['phone_office']);
  $nationality = $conn->real_escape_string($_POST['nationality']);
  $village = $conn->real_escape_string($_POST['village']);
  $division = $conn->real_escape_string($_POST['division']);
  $district = $conn->real_escape_string($_POST['district']);
  $upazila = $conn->real_escape_string($_POST['upazila']);
  $p_office = $conn->real_escape_string($_POST['p_office']);
  $p_code = $conn->real_escape_string($_POST['p_code']);
  $p_village = $conn->real_escape_string($_POST['p_village']);
  $p_division = $conn->real_escape_string($_POST['p_division']);
  $p_district = $conn->real_escape_string($_POST['p_district']);
  $p_upazila = $conn->real_escape_string($_POST['p_upazila']);
  $p_p_office = $conn->real_escape_string($_POST['p_p_office']);
  $p_p_code = $conn->real_escape_string($_POST['p_p_code']);
  $nid = $conn->real_escape_string($_POST['nid']);
  $passport_no = $conn->real_escape_string($_POST['passport_no']);
  $driving_lc_no = $conn->real_escape_string($_POST['driving_lc_no']);
  $tin_no = $conn->real_escape_string($_POST['tin_no']);
  $next_incr_date = $conn->real_escape_string($_POST['next_incr_date']);
  $upload_dir = '../upload/';
  $imgName = $_FILES['image']['name'];
  $imgTmp = $_FILES['image']['tmp_name'];
  $imgSize = $_FILES['image']['size'];
  $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
  $date = date("d-m-Y");
  $userPic = $imgName . '_' . $date . '_' . rand(1000, 9999) . '.' . $imgExt;
  move_uploaded_file($imgTmp, $upload_dir . $userPic);
  $ss_creator = $_SESSION['username'];
  $ss_org_no = $_SESSION['org_no'];
  $updateQuery = "UPDATE `sm_hr_emp` SET `emp_id`='$emp_id',`office_code`='$office_code',`desig_code`='$desig_code',
  `join_date`='$join_date',`f_name`='$f_name',`l_name`='$l_name',`father_name`='$father_name',
  `mother_name`='$mother_name',`husband_name`='$husband_name',`gender`='$gender',`dob`='$dob',`blood_group`='$blood_group',
  `religion`='$religion', `marital_status`='$marital_status',`email_personal`='$email_personal',`email_official`='$email_official',
  `phone_home`='$phone_home',`phone_mobile`='$phone_mobile',`phone_office`='$phone_office',`nationality`='$nationality',
  `village`='$village',`division`='$division',`district` = '$district',`upazila`='$upazila',`p_office`='$p_office',
  `p_code`='$p_code', `p_village`= '$p_village', `p_division`='$p_division',`p_district`='$p_district', `p_upazila`= '$p_upazila',
   `p_p_office`='$p_p_office',`p_p_code`='$p_p_code', `nid`='$nid',`passport_no`='$passport_no',`driving_lc_no`='$driving_lc_no',
   `tin_no`='$tin_no', `next_incr_date`='$next_incr_date', `employee_image` = '$userPic',`ss_creator`='$ss_creator',`ss_modified_on`=now(),
   `ss_org_no`='$ss_org_no' WHERE `emp_no`=$emp_no";
  // echo $updateQuery;
  // exit;
  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) {
    $message = "Update Successfully";
    header('refresh:1;hr_emp_list.php');
  } else {
    $mess = "Failled!";
    header('refresh:1;hr_emp_list.php?id=$emp_no');
  }
}

require "../source/top.php";
$pid = 601000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Edit Employee </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index/index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-10 mx-auto">
      <!-- -------------------------------->
      <?php if (isset($message)) echo $message; ?>
      <form method="post" enctype="multipart/form-data">
        <!-- emp_id user name part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Office</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="office_type" class="form-control select2" required>
              <option value="">----Select any----</option>
              <?php
              $selectQuery = 'SELECT * FROM `office_info`';
              $selectQueryResult = $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($row = $selectQueryResult->fetch_assoc()) {
              ?>
                  <option value="<?php echo $row['office_code']; ?>" <?php echo $row['office_code'] == $data['office_code'] ? "selected" : "" ?>>
                    <?php echo $row['office_name']; ?>
                  </option>
              <?php
                }
              }
              ?>
            </select>
          </div>
          <!-- script start -->
          <script>
            function checkUserAvailability() {
              $("#loaderIcon").show();
              jQuery.ajax({
                url: "../common/check_availability.php",
                data: 'userid=' + $("#userid").val(),
                type: "POST",
                success: function(data) {
                  $("#user-availability-status").html(data);
                  $("#loaderIcon").hide();
                },
                error: function() {}
              });
            }
          </script>
          <!-- script stop -->
          <label class="col-sm-2 col-form-label">Employee ID</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="emp_id" value="<?php echo $data['emp_id']; ?>" id="userid" class="form-control" placeholder="User ID">
            <tr>
              <th width="24%" scope="row"></th>
              <td><span id="user-availability-status"></span></td>
            </tr>
          </div>
        </div>
        <!-- Designation Code -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Designation Code</label>
          <label class="col-form-label">:</label>
          <div class="col">
          <select name="desig_code" class="form-control select2" required>
              <option value="">----Select any----</option>
              <?php
              $selectQuery = 'SELECT * FROM `hr_desig`';
              $selectQueryResult = $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($row = $selectQueryResult->fetch_assoc()) {
              ?>
                  <option value="<?php echo $row['desig_code']; ?>" <?php echo $row['desig_code'] == $data['desig_code'] ? "selected" : "" ?>>
                    <?php echo $row['desig_desc']; ?>
                  </option>
              <?php
                }
              }
              ?>
            </select>
          </div>
          <label class="col-sm-2 col-form-label">Join Date</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="date" name="join_date" value="<?php echo $data['join_date']; ?>" class="form-control">
            <!-- -->
          </div>
        </div>
        <!-- Name part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">First Name <span style="color:red">*</span></label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="f_name" value="<?php echo $data['f_name']; ?>" class="form-control" placeholder="First Name" required>
          </div>
          <label class="col-sm-2 col-form-label">Last Name <span style="color:red">*</span></label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="l_name" value="<?php echo $data['l_name']; ?>" class="form-control" placeholder="Last Name">
          </div>
        </div>
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Father Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="father_name" value="<?php echo $data['father_name']; ?>" class="form-control" placeholder="Father Name">
          </div>
          <label class="col-sm-2 col-form-label">Mother Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="mother_name" value="<?php echo $data['mother_name']; ?>" class="form-control" placeholder="Mother Name">
          </div>
        </div>
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Husband Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="husband_name" value="<?php echo $data['husband_name']; ?>" class="form-control" placeholder="Husband Name">
          </div>
          <label class="col-sm-2 col-form-label">Gender</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <select required name="gender" id="" class="form-control">
                  <option value="1" <?php if ($data['gender']== "1") {echo 'selected="selected"';} ?>>Male</option>
                   <option value="2" <?php if ($data['gender']== "2") {echo 'selected="selected"';} ?>>Female</option>
                  <option value="3" <?php if ($data['gender']== "3") {echo 'selected="selected"';} ?>>Other</option>
             </select>
          </div>
        </div>
        <!-- date of birth and blood group part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Date of Birth</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="date" name="dob" value="<?php echo $data['dob']; ?>" class="form-control">
          </div>
          <label class="col-sm-2 col-form-label">Blood Group</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="blood_group" class="form-control">
              <option value="">----Select any----</option>
              <option value="A+"<?php if ($data['blood_group']== "A+") {echo 'selected="selected"';} ?>>A+</option>
              <option value="A-"<?php if ($data['blood_group']== "A-") {echo 'selected="selected"';} ?>>A-</option>
              <option value="B+"<?php if ($data['blood_group']== "B+") {echo 'selected="selected"';} ?>>B+</option>
              <option value="B-"<?php if ($data['blood_group']== "B-+") {echo 'selected="selected"';} ?>>B-</option>
              <option value="AB+"<?php if ($data['blood_group']== "AB+") {echo 'selected="selected"';} ?>>AB+</option>
              <option value="AB-"<?php if ($data['blood_group']== "AB-") {echo 'selected="selected"';} ?>>AB-</option>
              <option value="O+"<?php if ($data['blood_group']== "O+") {echo 'selected="selected"';} ?>>O+</option>
              <option value="O-"><?php if ($data['blood_group']== "O-") {echo 'selected="selected"';} ?>O-</option>
            </select>
          </div>
        </div>
        <!-- religion nationality part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Religion</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="religion" class="form-control">
              <option value="">----Select any----</option>
              <option value="Islam"<?php if ($data['religion']== "Islam") {echo 'selected="selected"';} ?>>Islam</option>
              <option value="Hinduism"<?php if ($data['religion']== "Hinduism") {echo 'selected="selected"';} ?>>Hinduism</option>
              <option value="Buddhism"<?php if ($data['religion']== "Buddhism") {echo 'selected="selected"';} ?>>Buddhism</option>
              <option value="Christianity"<?php if ($data['religion']== "Christianity") {echo 'selected="selected"';} ?>>Christianity</option>
              <option value="Other"<?php if ($data['religion']== "Other") {echo 'selected="selected"';} ?>>Other</option>
            </select>
          </div>
          <label class="col-sm-2 col-form-label">Marital Status</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="marital_status" id="" class="form-control">
              <option value="">---select---</option>
              <option value="Unmarried"<?php if ($data['marital_status']== "Unmarried") {echo 'selected="selected"';} ?>>Unmarried</option>
              <option value="Married"<?php if ($data['marital_status']== "Married") {echo 'selected="selected"';} ?>>Married</option>
              <option value="widow"<?php if ($data['marital_status']== "Widw") {echo 'selected="selected"';} ?>>Widow</option>
              <option value="divorced"<?php if ($data['marital_status']== "divorced") {echo 'selected="selected"';} ?>>Divorced</option>
              
            </select>
          </div>
        </div>
        <!-- script start -->
        <script>
          function checkemailAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
              url: "../common/check_availability.php",
              data: 'emailid=' + $("#emailid").val(),
              type: "POST",
              success: function(data) {
                $("#email-availability-status").html(data);
                $("#loaderIcon").hide();
              },
              error: function() {}
            });
          }
        </script>
        <!-- script stop -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Email Personal</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="email" name="email_personal" class="form-control" id="emailid" value="<?php echo $data['email_personal']; ?>" placeholder="admin@domain.com">
            <tr>
              <th width="24%" scope="row"></th>
              <td><span id="email-availability-status"></span></td>
            </tr>
          </div>
          <!-- script start -->
          <script>
            function checkemailAvailabilityp() {
              $("#loaderIcon").show();
              jQuery.ajax({
                url: "../common/check_availability.php",
                data: 'pemailid=' + $("#pemailid").val(),
                type: "POST",
                success: function(data) {
                  $("#email-availability-statusp").html(data);
                  $("#loaderIcon").hide();
                },
                error: function() {}
              });
            }
          </script>
          <!-- script end  -->
          <label class="col-sm-2 col-form-label">Email Office</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="email" name="email_official" class="form-control" id="pemailid" value="<?php echo $data['email_official']; ?>" placeholder="admin@domain.com">
            <tr>
              <th width="24%" scope="row"></th>
              <td><span id="email-availability-statusp"></span></td>
            </tr>
          </div>
        </div>
        <!-- phone no  -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Phone Home</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="tel" id="" name="phone_home" value="<?php echo $data['phone_home']; ?>" class="form-control">
          </div>
          <label class="col-sm-2 col-form-label">Mobile No<span style="color:red">*</span></label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="tel" id="" name="phone_mobile" value="<?php echo $data['phone_mobile']; ?>" class="form-control" required>
          </div>
        </div>
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Phone Office</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="tel" id="" name="phone_office" value="<?php echo $data['phone_office']; ?>" class="form-control">
          </div>
          <label class="col-sm-2 col-form-label">Nationality</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="nationality" id="" value="<?php echo $data['nationality']; ?>" class="form-control">
              <option value="Bangladeshi">Bangladeshi</option>
            </select>
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
                  <label class="col-sm-5 col-form-label">Village/Road/House/Flat</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" class="form-control" name="village" value="<?php echo $data['village']; ?>" placeholder="Village/Road#/House#/Flat#">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Division</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="division" id="division_id" class="form-control" onChange="getDistrict(this.value);">
                    <option value="">Select Division</option>
                      <?php
                      
                      $selectQuery = 'SELECT * FROM `divisions`';
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $data['division'] ? "selected" : "" ?>>
                            <?php echo $row['name']; ?>
                          </option>
                      <?php
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
                    <?php
                      
                      $selectQuery = 'SELECT * FROM `districts`';
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $data['district'] ? "selected" : "" ?>>
                            <?php echo $row['name']; ?>
                          </option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">P.S./Upazila</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="upazila" id="upazilla_id" class="form-control">
                    <?php
                      
                      $selectQuery = 'SELECT * FROM `upazilas`';
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $data['upazila'] ? "selected" : "" ?>>
                            <?php echo $row['name']; ?>
                          </option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Post Office</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_office" value="<?php echo $data['p_office']; ?>" class="form-control">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Post Code</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_code" value="<?php echo $data['p_code']; ?>" class="form-control">
                  </div>
                </div>
                <!--------------------------------------------->
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card">
              <div class="card-header">
                Parmanant Address
              </div>
              <div class="card-body">
                <!------------------------------------------------>
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Village/Road/House/Flat</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_village" value="<?php echo $data['p_village']; ?>" class="form-control" placeholder="Village/Road#/House#/Flat#">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Division</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="p_division" id="p_division_id" class="form-control" onChange="p_getDistrict(this.value);">
                    <option value="">Select Division</option>
                      <?php
                      
                      $selectQuery = 'SELECT * FROM `divisions`';
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $data['p_division'] ? "selected" : "" ?>>
                            <?php echo $row['name']; ?>
                          </option>
                      <?php
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
                    <?php
                      
                      $selectQuery = 'SELECT * FROM `districts`';
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $data['p_district'] ? "selected" : "" ?>>
                            <?php echo $row['name']; ?>
                          </option>
                      <?php
                        }
                      }
                      ?>
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
                  <label class="col-sm-5 col-form-label">Post Office</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_p_office" value="<?php echo $data['p_p_office']; ?>" class="form-control">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Post Code</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_p_code" value="<?php echo $data['p_p_code']; ?>" class="form-control">
                  </div>
                </div>
                <!--------------------------------------------->
              </div>
            </div>
          </div>
        </div>

        <!-- nid/pasport part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">National ID No</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="number" name="nid" value="<?php echo $data['nid']; ?>" class="form-control" placeholder="Nationa ID No">
          </div>
          <label class="col-sm-2 col-form-label">Passport</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="passport_no" value="<?php echo $data['passport_no']; ?>" class="form-control" placeholder="Passport No">
          </div>
        </div>
        <!-- driving tin  part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Driving LC No</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="driving_lc_no" value="<?php echo $data['driving_lc_no']; ?>" class="form-control">
          </div>
          <label class="col-sm-2 col-form-label">TIN No</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="tin_no" value="<?php echo $data['tin_no']; ?>" class="form-control">
          </div>
        </div>
        <!-- salary incriment date  part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Next Incriment date</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="date" name="next_incr_date" value="<?php echo $data['next_incr_date']; ?>" class="form-control">
          </div>
          <label class="col-sm-2 col-form-label">Picture</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="file" name="image" class="form-control">
          </div>
        </div>
        <input type="submit" value="Submit" id="register" class=" btn btn-primary form-control text-center" name="SubBtn">
      </form>
      <!-- -------------------------------->
      <?php
      if (!empty($message)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Update Successfully!!",
                "Welcome ' . $message . '",
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
              text: "Sorry ' . $mess . '",
            });
          </script>';
      } else {
      }
      ?>
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
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#601000").addClass('active');
    $("#600000").addClass('active');
    $("#600000").addClass('is-expanded');
  });
</script>

</body>

</html>