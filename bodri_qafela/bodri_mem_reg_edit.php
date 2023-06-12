<?php
require "../auth/auth.php";
require "../database.php";
//update query
if (isset($_POST['submit'])) {
  $member_no = $_POST['member_no'];
  $member_type = $_POST['member_type'];
  $full_name = $_POST['fullname'];
  $father_name = $_POST['f_name'];
  $shop_name = $_POST['shop_name'];
  $shop_owner_name = $_POST['shop_owner_name'];

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
  $referred_person = $_POST['referred_person'];
  
  
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_modified=$_SESSION['username'];
  $ss_modified_on=$_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];
  
  $id = $_GET['id'];
  $updateQuery = "UPDATE `fund_member` SET member_type='$member_type', member_no='$member_no',full_name='$full_name', father_name='$father_name',shop_name='$shop_name',shop_owner_name='$shop_owner_name', mother_name='$mother_name', husband_name='$husband_name', email='$email', mobile='$mobile', nid_birth_no='$nid_birth_no', passport_no='$passport_no',blood_group='$blood_group', dob='$dob', village='$village', division='$division', district='$district', upazila='$upazila', p_office='$p_office', p_village='$p_village', p_division='$p_division', p_district='$p_district', p_upazila='$p_upazila', p_p_office='$p_p_office', referred_person_type='$referred_person_type', referred_person_id='$referred_person_id', referred_person='$referred_person', ss_creator='$ss_creator',ss_creator_on='$ss_created_on',ss_modified='$ss_modified', ss_modified_on='$modified_on' WHERE member_id = '$id'";

  // echo $updateQuery;
  // exit;
  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:2;../bodri_qafela/bodri_mem_reg.php');
}
?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $selectQueryEdit = "SELECT * FROM `fund_member` WHERE member_id='$id'";
  $selectQueryEditResult = $conn->query($selectQueryEdit);
  $row = $selectQueryEditResult->fetch_assoc();
}
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Member Registration</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
    <a href="bodri_mem_reg.php" class="btn btn-outline-info btn-sm mt-1">
<i class="fa fa-arrow-left"></i><span> BACK</span></a>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <input type="hidden" name="recid" value="<?php echo $row['member_id']; ?>" />
      <form role="form" action="#" method="post">

        <!-- mamber part  -->
        <div class="form-row form-group">
        <input type="hidden" name="member_id" class="form-control" value="<?php echo $row['member_id']; ?>" readonly>
          <label class="col-sm-2 col-form-label">Member No.</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="member_no" class="form-control" value="<?php echo $row['member_no']; ?>" readonly>
          </div>
          <label class="col-sm-2 col-form-label">Member Type</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="member_type" id="" class="form-control">

              <!---------------------------------------------->
              <?php
              $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "MTYPE" AND `softcode`>0';
              $selectQueryResult =  $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($rows = $selectQueryResult->fetch_assoc()) {
              ?>
                  <option value="<?php echo $rows['softcode']; ?>" <?php if ($row['member_type'] == $rows['softcode']) {
                                                                      echo "selected";
                                                                    } ?>><?php echo $rows['description']; ?></option>
              <?php
                }
              }
              ?>
            </select>
            <!------------------------------------->
          </div>
        </div>

        <!-- Name part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Full Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="fullname" class="form-control" placeholder="Full Name" value="<?php echo $row['full_name']; ?>" >
          </div>
          <label class="col-sm-2 col-form-label">Father Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="f_name" class="form-control" placeholder="Father Name" value="<?php echo $row['father_name']; ?>">
          </div>
        </div>
        <!-- Shop Name  -->
          <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Shop Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="shop_name" class="form-control" placeholder="shop Name" value="<?php echo $row['shop_name']; ?>" >
          </div>
          <label class="col-sm-2 col-form-label">Shop Owner Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="shop_owner_name" class="form-control" placeholder="Shop Owner Name" value="<?php echo $row['shop_owner_name']; ?>">
          </div>
        </div>
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Mother Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="m_name" class="form-control" placeholder="Mother Name" value="<?php echo $row['mother_name']; ?>">
          </div>
          <label class="col-sm-2 col-form-label">Soause Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="h_name" class="form-control" placeholder="Spouse Name(if applicable)" value="<?php echo $row['husband_name']; ?>">
          </div>
        </div>
        <!-- contract part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Email</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="email" name="email"  class="form-control" placeholder="admin@domain.com" value="<?php echo $row['email']; ?>">
          </div>
          <label class="col-sm-2 col-form-label">Mobile No</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="tel" name="mobile"  class="form-control" placeholder="Example:+8801234567890" value="<?php echo $row['mobile']; ?>">
          </div>
        </div>
        <!-- nid/pasport part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">NID/Birth Cer. No</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="nid_birth_no" class="form-control" value="<?php echo $row['nid_birth_no']; ?>" placeholder="NID/Birth Cert. no" >
          </div>
          <label class="col-sm-2 col-form-label">Pasport</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="passport_no" class="form-control" placeholder="Passport No" value="<?php echo $row['passport_no']; ?>" >
          </div>
        </div>
        <!-- date of birth and blood group part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Blood Group</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="blood_group" class="form-control" >
              <!---------------------------------------------->
              <?php
             
              $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "BGTYP" AND `softcode`>0';
              $selectQueryResult =  $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($rows = $selectQueryResult->fetch_assoc()) {
              ?>
                  <option value="<?php echo $rows['softcode']; ?>" <?php if ($row['blood_group'] == $rows['softcode']) {
                                                                      echo "selected";
                                                                    } ?>><?php echo $rows['description']; ?></option>
              <?php
                }
              }
              ?>
            </select>
          </div>
          <label class="col-sm-2 col-form-label">Date OF Birth</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="date" name="dob" class="form-control" value="<?php echo $row['dob']; ?>" required>
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
               
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Village/Road/House/Flat</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" class="form-control" name="village" placeholder="Village/Road#/House#/Flat#" value="<?php echo $row['village']; ?>">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Division</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                  
                            <select name="division" id="division_id" required class="form-control" onChange="getDistrict(this.value);">
                               <option value="">-Select Division -</option>
                               <?php
                                $selectQuery = "SELECT * from divisions";
                                $selectQueryResult = $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                  while ($row_div = $selectQueryResult->fetch_assoc()) {
                                ?>
                                 <option value="<?php echo $row_div['id']; ?>" <?php echo $row_div['id'] == $row['division'] ? "selected" : "" ?>>
                                    <?php echo $row_div['name']; ?>
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
                    <select name="district" id="district_id" required class="form-control" onChange="getUpazilas(this.value);">
                                <option value="">-Select Districtn -</option>
                               <?php
                                $selectQuery = "SELECT * FROM districts ";
                                $selectQueryResult = $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                  while ($row_dist = $selectQueryResult->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row_dist['id']; ?>" <?php echo $row_dist['id'] == $row['district'] ? "selected" : "" ?>>
                                    <?php echo $row_dist['name']; ?>
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
                    <select name="upazila" id="upazilla-list" required class="form-control">
                    <option value="">-Select upazila  -</option>
                               <?php
                                $selectQuery = "SELECT * FROM upazilas ";
                                $selectQueryResult = $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                  while ($row_upz = $selectQueryResult->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row_upz['id']; ?>" <?php echo $row_upz['id'] == $row['upazila'] ? "selected" : "" ?>>
                                    <?php echo $row_upz['name']; ?>
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
                    <input type="text" name="p_office" class="form-control" value="<?php echo $row['p_office']; ?>">
                  </div>
                </div>
               
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
                    <input type="text" name="p_village" class="form-control" placeholder="Village/Road#/House#/Flat#" value="<?php echo $row['p_village']; ?>">
                  </div>
                </div>
                <!------------------------------------------->
                
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Division</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="p_division" id="p_division_id" required class="form-control" onChange="p_getDistrict(this.value);">
                    <option value="">-Select Division -</option>
                               <?php
                                $selectQuery = "SELECT * from divisions";
                                $selectQueryResult = $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                  while ($row_div = $selectQueryResult->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row_div['id']; ?>" <?php echo $row_div['id'] == $row['p_division'] ? "selected" : "" ?>>
                                    <?php echo $row_div['name']; ?>
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
                    <select name="p_district" id="p_district_id" required class="form-control" onChange="p_getUpazilas(this.value);">
                    <option value="">-Select Districtn -</option>
                               <?php
                                $selectQuery = "SELECT * FROM districts";
                                $selectQueryResult = $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                  while ($row_dist = $selectQueryResult->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row_dist['id']; ?>" <?php echo $row_dist['id'] == $row['p_district'] ? "selected" : "" ?>>
                                    <?php echo $row_dist['name']; ?>
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
                    <select name="p_upazila" id="p_upazilla_id" class="form-control" required>
                    <option value="">-Select upazila  -</option>
                               <?php
                                $selectQuery = "SELECT * FROM upazilas";
                                $selectQueryResult = $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                  while ($row_upz = $selectQueryResult->fetch_assoc()) {
                                ?>
                                 <option value="<?php echo $row_upz['id']; ?>" <?php echo $row_upz['id'] == $row['p_upazila'] ? "selected" : "" ?>>
                                    <?php echo $row_upz['name']; ?>
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
                    <input type="text" name="p_p_office" class="form-control" value="<?php echo $row['p_p_office']; ?>">
                  </div>
                </div>
                </div>
            </div>
          </div>
        </div>
             
         
        <!-- ---------------------Referred type start----------------- -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Referred Person Type</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="referred_person_type" class="form-control">
              <!---------------------------------------------->
              <?php
             
              $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "RTYPE" AND `softcode`>0';
              $selectQueryResult =  $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($rows = $selectQueryResult->fetch_assoc()) {
              ?>
                  <option value="<?php echo $rows['softcode']; ?>" <?php if ($row['referred_person_type'] == $rows['softcode']) {
                                                                      echo "selected";
                                                                    } ?>><?php echo $rows['description']; ?></option>
              <?php
                }
              }
              ?>
            </select>
          </div>
          <label class="col-sm-2 col-form-label">Referred Person ID</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="referred_person_id" class="form-control">
              <!---------------------------------------------->
              <?php
             
              $selectQuery = 'SELECT id,reffered_id,full_name FROM `fund_ref_info`';
              $selectQueryResult =  $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($rows = $selectQueryResult->fetch_assoc()) {
              ?>
                  <option value="<?php echo $rows['reffered_id']; ?>" <?php if ($row['referred_person_id'] == $rows['reffered_id']) {
                                                                        echo "selected";
                                                                      } ?>><?php echo $rows['reffered_id']; ?></option>
              <?php
                }
              }
              ?>
            </select>
          </div>
          <label class="col-sm-3 col-form-label">Referred Person</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="referred_person" class="form-control" placeholder="Person Name" value="<?php echo $row['referred_person']; ?>" required>
          </div>
        </div>
        <!----------------------- Referred type End --------------------->
       
        <input type="hidden" name="ss_creator">
        <input type="hidden" name="ss_modified">

        <!------------------------------------------------------------------>
        <input name="submit" type="submit" id="register" value="Update" class=" btn btn-primary form-control text-center" />
      </form>
      <!-- -------------------------------->
      <?php
      if (!empty($message)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Member Edit Successfully!!",
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
<!-- The java../plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- division.district.upajila  -->
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
      
      url: "../common/getDistrict1.php",
      data: 'p_district_id=' + val,
      success: function(data) {
        $("#p_upazilla_id").html(data);
      }
    });
  }

</script>

<!-- registration_division_district_upazila_jqu_script -->

<!-- Google analytics script-->
<script type="text/javascript">
  if (document.location.hostname == 'pratikborsadiya.in') {
    (function(i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function() {
        (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date();
      a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-72504830-1', 'auto');
    ga('send', 'pageview');
  }
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#common").addClass('active');
    $("#regform").addClass('active');
  });
</script>

</body>

</html>