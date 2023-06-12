<?php
require "../auth/auth.php";
require "../database.php";
//update query
if (isset($_POST['submit'])) {
  $member_type = $_POST['member_type'];
  $full_name = $_POST['fullname'];
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
  $p_code = $_POST['p_code'];
  $p_village = $_POST['p_village'];
  $p_division = $_POST['p_division'];
  $p_district = $_POST['p_district'];
  $p_upazila = $_POST['p_upazila'];
  $p_p_office = $_POST['p_p_office'];
  $p_p_code = $_POST['p_p_code'];
  $donation_type = $_POST['donation_type'];
  $payment_type = $_POST['payment_type'];
  $annul_c_tk = $_POST['annul_c_tk'];
  $referred_person_type = $_POST['referred_person_type'];
  $referred_person_id = $_POST['referred_person_id'];
  $referred_person = $_POST['referred_person'];
  $annual_con_in_fc = $_POST['annual_con_in_fc'];
  $currency_type = $_POST['currency_type'];
  $currency_rate = $_POST['currency_rate'];
  $activation_key = $_POST['activation_key'];
  $paid_amount = $_POST['paid_amount'];
  $paid_date = $_POST['paid_date'];
  $created_by = $_POST['created_by'];
  $created_date = date("Y-m-d H:i:s");
  $modify_by = $_POST['modify_by'];
  $modify_date = date("Y-m-d H:i:s");
  $idno = $_GET['recortid'];
  $updateQuery = "UPDATE `fund_member` SET member_type='$member_type', full_name='$full_name', father_name='$father_name', mother_name='$mother_name', husband_name='$husband_name', email='$email', mobile='$mobile', nid_birth_no='$nid_birth_no', passport_no='$passport_no',blood_group='$blood_group', dob='$dob', village='$village', division='$division', district='$district', upazila='$upazila', p_office='$p_office', p_code='$p_code', p_village='$p_village', p_division='$p_division', p_district='$p_district', p_upazila='$p_upazila', p_p_office='$p_p_office', p_p_code='$p_p_code',donation_type='$donation_type', payment_type='$payment_type', annul_c_tk='$annul_c_tk', referred_person_type='$referred_person_type', referred_person_id='$referred_person_id', referred_person='$referred_person', annual_con_in_fc='$annual_con_in_fc', currency_type='$currency_type', currency_rate='$currency_rate', activation_key='$activation_key',paid_amount='$paid_amount',paid_date='$paid_date',created_by='$created_by',created_date='$created_date',modify_by='$modify_by', modify_date='$modify_date' WHERE member_id = '$idno'";
  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:2;../bodri_qafela/member_view.php');
}
//select query start
if (isset($_GET['recortid'])) {
  $idno = $_GET['recortid'];
  $selectQuery = "SELECT * FROM `fund_member` WHERE member_id=$idno";
  // echo $selectQuery; exit;
  $selectQueryResult = $conn->query($selectQuery);
  //if($selectQueryResult->num_rows){		
  $row = $selectQueryResult->fetch_array();
  //}
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
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <input type="hidden" name="recid" value="<?php echo $row['member_id']; ?>" />
      <form role="form" action="#" method="post">

        <!-- mamber part  -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Member ID</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="member_id" class="form-control" value="<?php echo $row['member_id']; ?>" readonly>
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
            <input type="text" name="fullname" class="form-control" placeholder="Full Name" value="<?php echo $row['full_name']; ?>" readonly>
          </div>
          <label class="col-sm-2 col-form-label">Father Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="f_name" class="form-control" placeholder="Father Name" value="<?php echo $row['father_name']; ?>">
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
            <input type="email" name="email" readonly class="form-control" placeholder="admin@domain.com" value="<?php echo $row['email']; ?>">
          </div>
          <label class="col-sm-2 col-form-label">Mobile No</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="tel" name="mobile" readonly class="form-control" placeholder="Example:+8801234567890" value="<?php echo $row['mobile']; ?>">
          </div>
        </div>
        <!-- nid/pasport part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">NID/Birth Cer. No</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="nid_birth_no" class="form-control" value="<?php echo $row['nid_birth_no']; ?>" placeholder="NID/Birth Cert. no" required>
          </div>
          <label class="col-sm-2 col-form-label">Pasport</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="passport_no" class="form-control" placeholder="Passport No" value="<?php echo $row['passport_no']; ?>" required>
          </div>
        </div>
        <!-- date of birth and blood group part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Blood Group</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="blood_group" class="form-control" required>
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
                    <input type="text" class="form-control" name="village" placeholder="Village/Road#/House#/Flat#" value="<?php echo $row['village']; ?>">
                  </div>
                </div>
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Division</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="division" id="division-list" required class="form-control" onChange="getDistrict(this.value);">
                      <?php
                      foreach ($results as $division) {
                      ?>
                        <option value="<?php echo $division["id"]; ?>" <?php if ($row['division'] == $division["id"]) {
                                                                          echo "selected";
                                                                        }
                                                                        ?>><?php echo $division["name"]; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <?php
              
                $db_handle = new DBController();
                $query = "SELECT * FROM districts";
                $results = $db_handle->runQuery($query);
                ?>
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Dristrict</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="district" id="district-list" required class="form-control" onChange="getUpazilas(this.value);">
                      <?php
                      foreach ($results as $district) {
                      ?>
                        <option value="<?php echo $district["id"]; ?>" <?php if ($row['district'] == $district["id"]) {
                                                                          echo "selected";
                                                                        }
                                                                        ?>><?php echo $district["name"]; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <?php
              
                $db_handle = new DBController();
                $query = "SELECT * FROM upazilas";
                $results = $db_handle->runQuery($query);
                ?>
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">P.S./Upazila</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="upazila" id="upazilla-list" required class="form-control">
                      <?php
                      foreach ($results as $upazzila) {
                      ?>
                        <option value="<?php echo $upazzila["id"]; ?>" <?php if ($row['upazila'] == $upazzila["id"]) {
                                                                          echo "selected";
                                                                        }
                                                                        ?>><?php echo $upazzila["name"]; ?></option>
                      <?php
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
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Post Code</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_code" class="form-control" value="<?php echo $row['p_code']; ?>">
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
                    <input type="text" name="p_village" class="form-control" placeholder="Village/Road#/House#/Flat#" value="<?php echo $row['p_village']; ?>">
                  </div>
                </div>
                <!------------------------------------------->
                <?php
               
                $db_handle = new DBController();
                $query = "SELECT * FROM divisions";
                $results = $db_handle->runQuery($query);
                ?>
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Division</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="p_division" id="division-list1" required class="form-control" onChange="getDistrict1(this.value);">
                      <?php
                      foreach ($results as $divisions) {
                      ?>
                        <option value="<?php echo $divisions["id"]; ?>" <?php if ($row['p_division'] == $divisions["id"]) {
                                                                          echo "selected";
                                                                        }
                                                                        ?>><?php echo $divisions["name"]; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <?php
                
                $db_handle = new DBController();
                $query = "SELECT * FROM districts";
                $results = $db_handle->runQuery($query);
                ?>
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Dristrict</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="p_district" id="district-list1" required class="form-control" onChange="getUpazilas1(this.value);">
                      <?php
                      foreach ($results as $district) {
                      ?>
                        <option value="<?php echo $district["id"]; ?>" <?php if ($row['p_district'] == $district["id"]) {
                                                                          echo "selected";
                                                                        }
                                                                        ?>><?php echo $district["name"]; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <!------------------------------------------->
                <?php
           
                $db_handle = new DBController();
                $query = "SELECT * FROM upazilas";
                $results = $db_handle->runQuery($query);
                ?>
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">P.S./Upazila</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <select name="p_upazila" id="upazilla-list1" class="form-control" required>
                      <?php
                      foreach ($results as $upazzila) {
                      ?>
                        <option value="<?php echo $upazzila["id"]; ?>" <?php if ($row['p_upazila'] == $upazzila["id"]) {
                                                                          echo "selected";
                                                                        }
                                                                        ?>><?php echo $upazzila["name"]; ?></option>
                      <?php
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
                <!------------------------------------------->
                <div class="form-row form-group">
                  <label class="col-sm-5 col-form-label">Post Code</label>
                  <label class="col-form-label">:</label>
                  <div class="col">
                    <input type="text" name="p_p_code" class="form-control" value="<?php echo $row['p_p_code']; ?>">
                  </div>
                </div>
                <!--------------------------------------------->
              </div>
            </div>
          </div>
        </div>
        <!----------------------end address part--------------------------->

        <!-- donation type/payment/contrinutionreffered type -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Donation Type</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="donation_type" class="form-control">
              <!---------------------------------------------->
              <?php
             
              $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "DOTY" AND `softcode`>0';
              $selectQueryResult =  $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($rows = $selectQueryResult->fetch_assoc()) {
              ?>
                  <option value="<?php echo $rows['softcode']; ?>" <?php if ($row['donation_type'] == $rows['softcode']) {
                                                                      echo "selected";
                                                                    } ?>><?php echo $rows['description']; ?></option>
              <?php
                }
              }
              ?>
            </select>
          </div>
          <label class="col-sm-2 col-form-label">Payment Type</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="payment_type" class="form-control">
              <!---------------------------------------------->
              <?php
             
              $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "DTYPE" AND `softcode`>0';
              $selectQueryResult =  $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($rows = $selectQueryResult->fetch_assoc()) {
              ?>
                  <option value="<?php echo $rows['softcode']; ?>" <?php if ($row['payment_type'] == $rows['softcode']) {
                                                                      echo "selected";
                                                                    } ?>><?php echo $rows['description']; ?></option>
              <?php
                }
              }
              ?>
            </select>
          </div>
          <label class="col-sm-3 col-form-label">Annual Contribution in Taka</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="number" name="annul_c_tk" class="form-control" placeholder="In TK." value="<?php echo $row['annul_c_tk']; ?>">
          </div>
        </div>
        <!-- -------------------------------------------------- -->
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
        <!-- ---------------------currency type start----------------- -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Annual Contribution in FC</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="number" name="annual_con_in_fc" class="form-control" value="<?php echo $row['annual_con_in_fc']; ?>">
          </div>
          <label class="col-sm-2 col-form-label">Currency Type</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <select name="currency_type" class="form-control">
              <!---------------------------------------------->
              <?php
             
              $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "CURT" AND `softcode`>0';
              $selectQueryResult =  $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($rows = $selectQueryResult->fetch_assoc()) {
              ?>
                  <option value="<?php echo $rows['softcode']; ?>" <?php if ($row['currency_type'] == $rows['softcode']) {
                                                                      echo "selected";
                                                                    } ?>><?php echo $rows['description']; ?></option>
              <?php
                }
              }
              ?>
            </select>
          </div>
          <label class="col-sm-3 col-form-label">Currency Rate</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="number" name="currency_rate" class="form-control" placeholder="Currency Rate" value="<?php echo $row['currency_rate']; ?>">
          </div>
        </div>
        <!----------------------- currency type End --------------------->
        <!-- extra  -->
        <input type="hidden" name="activation_key" value="<?php echo $row['activation_key']; ?>">
        <input type="hidden" name="paid_amount">
        <input type="hidden" name="paid_date">
        <input type="hidden" name="created_by">
        <input type="hidden" name="modify_by">

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