<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['tenantSubmit'])) {

  // $office_code = $_SESSION['office_code'];
  $id = $conn->escape_string($_POST['id']);
  $office_code = $conn->escape_string($_POST['office_code']);
  $tenant_id = $conn->escape_string($_POST['tenant_id']);
  $tenant_name = $conn->escape_string($_POST['tenant_name']);
  $tenant_under_owner_id = $conn->escape_string($_POST['tenant_under_owner_id']);
  $flat_no = $conn->escape_string($_POST['flat_no']);
  $father_hus_name = $conn->escape_string($_POST['father_hus_name']);
  $mother_name = $conn->escape_string($_POST['mother_name']);
  $nid = $conn->escape_string($_POST['nid']);
  $passport_no = $conn->escape_string($_POST['passport_no']);
  $date_of_birth = $conn->escape_string($_POST['date_of_birth']);
  $mobile_no = $conn->escape_string($_POST['mobile_no']);
  $permanent_add = $conn->escape_string($_POST['permanent_add']);
  $profession = $conn->escape_string($_POST['profession']);
  $contract_date = $conn->escape_string($_POST['contract_date']);
  $contract_period = $conn->escape_string($_POST['contract_period']);
  $contract_expiry_date = $conn->escape_string($_POST['contract_expiry_date']);
  $tenant_image = $conn->escape_string($_POST['tenant_image']);
  
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $inserttenantQuery = "UPDATE `apart_tenant_info`set office_code = '$office_code', tenant_name ='$tenant_name', flat_no='$flat_no', tenant_under_owner_id ='$tenant_under_owner_id', father_hus_name='$father_hus_name', mother_name='$mother_name',nid='$nid',passport_no='$passport_no',date_of_birth='$date_of_birth', mobile_NO='$mobile_no', permanent_add='$permanent_add', profession='$profession',contract_date='$contract_date',contract_period='$contract_period', contract_expiry_date='$contract_expiry_date', ss_modifier='$ss_modifier',ss_modified_on='$ss_modified_on',ss_org_no='$ss_org_no' WHERE id='$id'";
  // echo $insertcustomerQuery;
  // exit();
  $conn->query($inserttenantQuery);
  if ($conn->affected_rows == 1) {
    $message = "Update Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:2;tenant_info.php');
}
?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $selectQueryEdit = "SELECT * FROM `apart_tenant_info` WHERE id='$id'";
  $selectQueryEditResult = $conn->query($selectQueryEdit);
  $rows = $selectQueryEditResult->fetch_assoc();
}
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Edit Tenant Information </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div>
        <!-- Owner Information end -->
        <div id="OwnerForm">
          <div style="padding:5px">
            <!-- form start  -->
            <form action="" method="post">
              <input type="text" class="form-control" id="cust_name" value="<?php echo $rows['id']; ?>" name="id" hidden>
              <!-- Under Project  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Under Project</label>
                <div class="col-sm-6">
                  <select name="office_code" class="form-control" required>
                    <option value="">-Select office Code -</option>
                    <?php
                    require '../database.php';
                    $selectQuery = 'SELECT office_code, office_name from office_info';
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row_off = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php                 
                    echo '<option value="' . $row_off['office_code'] . '"=="' . $row['office_code'] . '" selected="selected">' . $row_off['office_name'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- Tenent ID  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tenant ID</label>
                <div class="col-sm-6">
                    <input type="text" name="tenant_id" value="<?php echo $rows['tenant_id']; ?>" class="form-control" onclick="Funww()" id="more">
                </div>
              </div>
               
              <!-- tenant_name  -->
              <script>
                function tenant_check_availability() {
                  var name = $("#tenant_name").val();
                  $("#loaderIcon").show();
                  jQuery.ajax({
                    url: "owner_check_availability.php",
                    data: 'tenant_name=' + name,
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
                <label class="col-sm-2 col-form-label">Tenant Name</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="tenant_name" value="<?php echo $rows['tenant_name']; ?>" onkeyup="owner_check_availability()" name="tenant_name" required>
                  <tr>
                    <th width="24%" scope="row"></th>
                    <td><span id="name_availability_status"></span></td>
                  </tr>
                </div>
              </div>
 
             <!-- Tenant under owner Id  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tenant Under Owner.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="tenant_under_owner_id" value="<?php echo $rows['tenant_under_owner_id']; ?>">
                </div>
              </div>

              <!-- flat_no  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Flat No.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="flat_no" value="<?php echo $rows['flat_no']; ?>">
                </div>
              </div>

              <!-- father_hus_name -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Father's/Husban  Name</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="" name="father_hus_name" value="<?php echo $rows['father_hus_name']; ?>">
                </div>
              </div>
              <!-- mother_name -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Mother's Name</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="mother_name" value="<?php echo $rows['mother_name']; ?>">
                </div>
              </div>
              <!-- nid -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">NID</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="nid" value="<?php echo $rows['nid']; ?>">
                </div>
              </div>
              <!-- passport_no -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Passport No.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="passport_no" value="<?php echo $rows['passport_no']; ?>">
                </div>
              </div>
              <!-- date_of_birth  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Date of Birth</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="date_of_birth" value="<?php echo $rows['date_of_birth']; ?>" required>
                </div>
              </div>
              <!-- mobile_no  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Mobile No.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="mobile_no" value="<?php echo $rows['mobile_no']; ?>" required>
                </div>
              </div>
             <!-- permanent_add  -->
               <div class="form-group row">
                <label class="col-sm-2 col-form-label">Parment Address.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="permanent_add" value="<?php echo $rows['permanent_add']; ?>" required>
                </div>
              </div>
              <!-- profession  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Profession</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="profession" value="<?php echo $rows['profession']; ?>" required>
                </div>
              </div>
              <!-- contract_date  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contract Date</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="contract_date" value="<?php echo $rows['contract_date']; ?>" required>
                </div>
              </div>
              <!-- contract_Period  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contract Period</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="contract_period" value="<?php echo $rows['contract_period']; ?>" required>
                </div>
              </div>
             <!-- contract_expiry_date  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contract Expiry Date</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="contract_expiry_date" value="<?php echo $rows['contract_expiry_date']; ?>" required>
                </div>
              </div>

              <!-- submit  -->
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="tenantSubmit">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- Tenant Info start -->
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
              title: "Oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
        } else {
        }
        ?>
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
<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#301000").addClass('active');
    $("#300000").addClass('active');
    $("#300000").addClass('is-expanded');
  });
</script>
<?php
$conn->close();
?>
</body>

</html>