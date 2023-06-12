<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['SubBtn'])) {
  $error = false;
  $office_code = $_SESSION['office_code'];
  $referred_type = $_POST['referred_type'];
  $reffered_id = $_POST['reffered_id'];
  $full_name = $_POST['fullname'];
  $father_name = $_POST['f_name'];
  $mother_name = $_POST['m_name'];
  $husband_name = $_POST['h_name'];
  $email = $_POST['email'];
  $mobile = $_POST['mobile'];
  $village = $_POST['village'];
  $division = $_POST['division'];
  $district = $_POST['district'];
  $upazila = $_POST['upazila'];
  $p_office = $_POST['p_office'];
  $p_code = $_POST['p_code'];
  $p_village = $_POST['p_village'];
  $p_division = $_POST['p_division'];
  $p_district = $_POST['p_district'];
  $p_upazila = $_POST['p_upazila'];
  $p_p_office = $_POST['p_p_office'];
  $p_p_code = $_POST['p_p_code'];
  $ss_org_no = $_SESSION['org_no'];
  $insertQuery = "INSERT INTO `fund_ref_info` VALUES (NULL,'$office_code','$referred_type','$reffered_id','$full_name','$father_name','$mother_name','$husband_name','$email','$mobile','$village','$division','$district','$upazila','$p_office','$p_code','$p_village','$p_division','$p_district','$p_upazila','$p_p_office','$p_p_code','',now(),'',now(),'$ss_org_no')";

  $conn->query($insertQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:2;../bodri_qafela/referred_person_view.php');
}
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Referance Information</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <!-- -------------------------------->
      <form action="" method="post">
        <!-- Referred  Type part  -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Referred Type</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <!-- ------------------------------------ -->
            <select name="referred_type" id="" class="form-control">
              <?php
              $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "RTYPE" AND `softcode`>0';
              $selectQueryResult =  $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($row = $selectQueryResult->fetch_assoc()) {
                  echo '<option value="' . $row['softcode'] . '">' . $row['softcode'] . "." . $row['description'] . '</option>';
                }
              }
              ?>
            </select>
            <!-- ------------------------------------- -->
          </div>
          <!-- script start  -->
        <script>
          function checkidAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
              url: "../common/check_availability.php",
              data: 'refid=' + $("#refid").val(),
              type: "POST",
              success: function(data) {
                $("#id-availability-status").html(data);
                $("#loaderIcon").hide();
              },
              error: function() {}
            });
          }
        </script>
        <!-- script stop  -->
          <label class="col-sm-2 col-form-label">Reffered ID</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="number" class="form-control"  name="reffered_id" id="refid" onBlur="checkidAvailability()">
            <tr>
              <th width="24%" scope="row"></th>
              <td><span id="id-availability-status"></span></td>
            </tr>
          </div>
        </div>
        <!-- Name part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Full Name</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
          </div>
          <label class="col-sm-2 col-form-label">Father Name</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="f_name" class="form-control" placeholder="Father Name">
          </div>
        </div>
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Mother Name</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="m_name" class="form-control" placeholder="Mother Name">
          </div>
          <label class="col-sm-2 col-form-label">Husband Name</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="h_name" class="form-control" placeholder="(if applicable)">
          </div>
        </div>
        <!-- --------------------------name part end------------------------ -->
        <!-- -----------------------contract start part ----------------------->
        <!-- script start  -->
        <script>
          function checkemailAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
              url: "../common/check_availability.php",
              data: 'refemailid=' + $("#emailid").val(),
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
            <input type="email" name="email" class="form-control" id="emailid" onBlur="checkemailAvailability()" placeholder="Input Email">
            <tr>
              <th width="24%" scope="row"></th>
              <td><span id="email-availability-status"></span></td>
            </tr>
          </div>
          <label class="col-sm-2 col-form-label">Mobile No</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="tel" id="phone" name="mobile" class="form-control" required>
          </div>
        </div>
        <!-- ------------------------contract part end --------------------- -->
        <!-- address part -->
        <div class="form-row form-group">
          <div class="col-sm-6">
            <div class="card">
              <div class="card-header">
                Present Address
              </div>
              <div class="card-body">
                <!--------------------address script and Jquery---------------------------->
                <?php
                require_once("../dbcontroller.php");
                $db_handle = new DBController();
                $query = "SELECT * FROM divisions";
                $results = $db_handle->runQuery($query);
                ?>
                <!------------------------------------------------>
                <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Village/Road/House/Flat</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" class="form-control" name="village" placeholder="Village/Road#/House#/Flat#">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Division</label>
                  <label for="" class="col-form-label">:</label>
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
                  <label for="inputPassword" class="col-sm-5 col-form-label">Dristrict</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <select name="district" id="district-list" class="form-control" onChange="getUpazilas(this.value);">
                      <option value="">Select Distict</option>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">P.S./Upazila</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <select name="upazila" id="upazilla-list" class="form-control">
                      <option value="">Select Upazila</option>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Post Office</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_office" class="form-control">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Post Code</label>
                  <label for="" class="col-form-label">:</label>
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
                  <label for="inputPassword" class="col-sm-5 col-form-label">Village/Road/House/Flat</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_village" class="form-control" placeholder="Village/Road#/House#/Flat#">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Division</label>
                  <label for="" class="col-form-label">:</label>
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
                  <label for="inputPassword" class="col-sm-5 col-form-label">Dristrict</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <select name="p_district" id="district-list1" class="form-control" onChange="getUpazilas1(this.value);">
                      <option value="">Select Dristict</option>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">P.S./Upazila</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <select name="p_upazila" id="upazilla-list1" class="form-control">
                      <option value="">Select Upazila</option>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Post Office</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_p_office" class="form-control">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Post Code</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_p_code" class="form-control">
                  </div>
                </div>
                <!--------------------------------------------->
              </div>
            </div>
          </div>
        </div>
        <!-- ---End address part--- -->

        <input type="submit" value="Submit" class=" btn btn-primary form-control text-center" name="SubBtn">
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
<!-- registration_division_district_upazila_jquesr_script -->
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
  $(document).ready(function() {
    $("#902000").addClass('active');
    $("#900000").addClass('active');
    $("#900000").addClass('is-expanded');

  });
</script>

</body>

</html>