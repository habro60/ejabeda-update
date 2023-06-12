<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['SubBtn'])) {
  $emp_id = ($_POST['emp_id']);
  $office_code = $conn->real_escape_string($_POST['office_type']);
  $job_title_no = $conn->real_escape_string($_POST['job_title_no']);
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
  $insertQuery = "INSERT INTO `sm_hr_emp` (`emp_no`,`emp_id`,`office_code`,`job_title_no`,`join_date`,`f_name`,`l_name`,`father_name`,`mother_name`,`husband_name`,`gender`,`dob`,`blood_group`,`religion`,`marital_status`,`email_personal`,`email_official`,`phone_home`,`phone_mobile`,`phone_office`,`nationality`,`village`,`division`,`district`,`upazila`,`p_office`,`p_code`,`p_village`,`p_division`,`p_district`,`p_upazila`,`p_p_office`,`p_p_code`,`nid`,`passport_no`,`driving_lc_no`,`tin_no`,`next_incr_date`,`employee_image`,`ss_creator`,`ss_created_on`,`ss_org_no`) VALUES (NULL,'$emp_id','$office_code','$job_title_no','$join_date','$f_name','$l_name','$father_name','$mother_name','$husband_name','$gender','$dob','$blood_group','$religion','$marital_status','$email_personal','$email_official','$phone_home','$phone_mobile','$phone_office','$nationality','$village','$division','$district','$upazila','$p_office','$p_code','$p_village','$p_division','$p_district','$p_upazila','$p_p_office','$p_p_code','$nid','$passport_no','$driving_lc_no','$tin_no','$next_incr_date','$userPic','$ss_creator',now(),'$ss_org_no')";

  $conn->query($insertQuery);

  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
  } else {
    $mess = "Failled!";
  }
  header('refresh:1;hr_emp.php');
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
      <h1><i class="fa fa-dashboard"></i> Add Employee </h1>
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
          <label class="col-sm-2 col-form-label">Office <span style="color:red">*</span></label>
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
              <?php
                  echo '<option value="' . $row['office_code'] . '">' . $row['office_name'] . '</option>';
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
            <input type="text" name="emp_id" id="userid" class="form-control" onBlur="checkUserAvailability()" placeholder="User ID" >
            <tr>
              <th width="24%" scope="row"></th>
              <td><span id="user-availability-status"></span></td>
            </tr>
          </div>
        </div>
        <!-- job_title -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Job Title</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="job_title_no" class="form-control">
          </div>
          <label class="col-sm-2 col-form-label">Join Date</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="date" name="join_date" class="form-control" >
            <!-- -->
          </div>
        </div>
        <!-- Name part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">First Name <span style="color:red">*</span></label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="f_name" class="form-control" placeholder="First Name" required>
          </div>
          <label class="col-sm-2 col-form-label">Last Name <span style="color:red">*</span></label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="l_name" class="form-control" placeholder="Last Name" required>
          </div>
        </div>
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Father Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="father_name" class="form-control" placeholder="Father Name" >
          </div>
          <label class="col-sm-2 col-form-label">Mother Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="mother_name" class="form-control" placeholder="Mother Name">
          </div>
        </div>
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Husband Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="husband_name" class="form-control" placeholder="Husband Name">
          </div>
          <label class="col-sm-2 col-form-label">Gender</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <select name="gender" class="form-control">
              <option value="">----Select any----</option>
              <option value="1">Male</option>
              <option value="2">Female</option>
              <option value="3">Other</option>
            </select>
          </div>
        </div>
        <!-- date of birth and blood group part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Date of Birth</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="date" name="dob" class="form-control" >
          </div>
          <label class="col-sm-2 col-form-label">Blood Group</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="blood_group" class="form-control">
              <option value="">----Select any----</option>
              <option value="A+">A+</option>
              <option value="A-">A-</option>
              <option value="B+">B+</option>
              <option value="B-">B-</option>
              <option value="AB+">AB+</option>
              <option value="AB-">AB-</option>
              <option value="O+">O+</option>
              <option value="O-">O-</option>
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
              <option value="Islam">Islam</option>
              <option value="Hinduism">Hinduism</option>
              <option value="Buddhism">Buddhism</option>
              <option value="Christianity">Christianity</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <label class="col-sm-2 col-form-label">Marital Status</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="marital_status" id="" class="form-control">
              <option value="">---select---</option>
              <option value="Unmarried">Unmarried</option>
              <option value="Married">Married</option>
              <option value="widow">Widow</option>
              <option value="divorced">Divorced</option>
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
            <input type="email" name="email_personal" class="form-control" id="emailid" onBlur="checkemailAvailability()" placeholder="admin@domain.com">
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
            <input type="email" name="email_official" class="form-control" id="pemailid" onBlur="checkemailAvailabilityp()" placeholder="admin@domain.com">
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
            <input type="tel" id="" name="phone_home" class="form-control">
          </div>
          <label class="col-sm-2 col-form-label">Mobile No <span style="color:red">*</span></label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="tel" id="" name="phone_mobile" class="form-control" required>
          </div>
        </div>
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Phone Office</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="tel" id="" name="phone_office" class="form-control">
          </div>
          <label class="col-sm-2 col-form-label">Nationality</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="nationality" id="" class="form-control">
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
                <?php
                require_once("../dbcontroller.php");
                $db_handle = new DBController();
                $query = "SELECT * FROM divisions";
                $results = $db_handle->runQuery($query);
                ?>
                <!------------------------------------------------>
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Village/Road/House/Flat</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" class="form-control" name="village" placeholder="Village/Road#/House#/Flat#">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Division</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="division" id="division-list" class="form-control" onChange="getDistrict(this.value);">
                      <option value="">Select Division</option>
                      <?php
                      foreach ($results as $division) {
                      ?>
                        <option value="<?php echo $division["id"]; ?>"><?php echo $division["name"]; ?></option>
                      <?php
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
                    <select name="district" id="district-list" class="form-control" onChange="getUpazilas(this.value);">
                      <option value="">Select Distict</option>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">P.S./Upazila</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="upazila" id="upazilla-list" class="form-control">
                      <option value="">Select Upazila</option>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Post Office</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_office" class="form-control">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Post Code</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_code" class="form-control">
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
                    <input type="text" name="p_village" class="form-control" placeholder="Village/Road#/House#/Flat#">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Division</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="p_division" id="division-list1" class="form-control" onChange="getDistrict1(this.value);">
                      <option value="">Select Division</option>
                      <?php
                      foreach ($results as $division) {
                      ?>
                        <option value="<?php echo $division["id"]; ?>"><?php echo $division["name"]; ?></option>
                      <?php
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
                    <select name="p_district" id="district-list1" class="form-control" onChange="getUpazilas1(this.value);">
                      <option value="">Select District</option>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">P.S./Upazila</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="p_upazila" id="upazilla-list1" class="form-control">
                      <option value="">Select Upazila</option>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Post Office</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_p_office" class="form-control">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Post Code</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_p_code" class="form-control">
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
            <input type="number" name="nid" class="form-control" placeholder="Nationa ID No" >
          </div>
          <label class="col-sm-2 col-form-label">Passport</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="passport_no" class="form-control" placeholder="Passport No">
          </div>
        </div>
        <!-- driving tin  part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Driving LC No</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="driving_lc_no" class="form-control">
          </div>
          <label class="col-sm-2 col-form-label">TIN No</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="tin_no" class="form-control">
          </div>
        </div>
        <!-- salary incriment date  part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Next Incriment date</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="date" name="next_incr_date" class="form-control">
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
        $("#district-list").html(data);
        getUpazilas();
      }
    });
  }

  function getUpazilas(val) {
    $.ajax({
      type: "POST",
      url: "../common/getUpazilas.php",
      data: 'district_id=' + val,
      success: function(data) {
        $("#upazilla-list").html(data);
      }
    });
  }

  function getDistrict1(val) {
    $.ajax({
      type: "POST",
      url: "../common/getDistrict.php",
      data: 'division_id=' + val,
      success: function(data) {
        $("#district-list1").html(data);
        getUpazilas1();
      }
    });
  }

  function getUpazilas1(val) {
    $.ajax({
      type: "POST",
      url: "../common/getUpazilas.php",
      data: 'district_id=' + val,
      success: function(data) {
        $("#upazilla-list1").html(data);
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