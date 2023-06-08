<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['customerSubmit'])) {

  // $office_code = $_SESSION['office_code'];
  $office_code = $conn->escape_string($_POST['office_code']);
  $id = $conn->escape_string($_POST['id']);
  $cust_type = $conn->escape_string($_POST['cust_type']);
  $cust_name = $conn->escape_string($_POST['cust_name']);
  $cust_add = $conn->escape_string($_POST['cust_add']);
  $cust_contact_per = $conn->escape_string($_POST['cust_contact_per']);
  $cust_location_code = $conn->escape_string($_POST['cust_location_code']);
  $cust_TIN_no = $conn->escape_string($_POST['cust_TIN_no']);
  $cust_VAT_no = $conn->escape_string($_POST['cust_VAT_no']);
  $cust_TDS_no = $conn->escape_string($_POST['cust_TDS_no']);
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertcustomerQuery = "UPDATE `cust_info` SET `id`='$id',`office_code`='$office_code',`cust_type`='$cust_type',`cust_name`='$cust_name', `cust_add`='$cust_add',`cust_contact_per`='$cust_contact_per',`cust_location_code`='$cust_location_code',`cust_TIN_no`='$cust_TIN_no',`cust_VAT_no`='$cust_VAT_no',`cust_TDS_no`='$cust_TDS_no',`ss_modifier`='$ss_modifier',`ss_modified_on`='$ss_modified_on',`ss_org_no`='$ss_org_no' WHERE id='$id'";
  // echo $insertcustomerQuery;
  // exit();
  $conn->query($insertcustomerQuery);
  if ($conn->affected_rows == 1) {
    $message = "Update Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:2;cust_info.php');
}
?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $selectQueryEdit = "SELECT * FROM `cust_info` WHERE id='$id'";
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
      <h1><i class="fa fa-dashboard"></i> Edit Customer Information </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div>
        <!-- customer Account Information end -->
        <div id="customerForm">
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
              <!-- Customer Type  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Customer Type</label>
                <div class="col-sm-6">
                  <select name="cust_type" class="form-control" required>
                    <option value="">-Select Customer Type-</option>
                    <?php
                    require '../database.php';
                    $selectQuery = 'SELECT * FROM `code_master` where hardcode="CUSTP" AND softcode>0';
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php
                        echo '<option value="' . $row['softcode'] . '"=="' . $row['cust_type'] . '" selected="selected">' . $row['description'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- cust_name  -->
              <script>
                function cust_check_availability() {
                  var name = $("#cust_name").val();
                  $("#loaderIcon").show();
                  jQuery.ajax({
                    url: "cust_check_availability.php",
                    data: 'cust_name=' + name,
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
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="cust_name" value="<?php echo $rows['cust_name']; ?>" onkeyup="cust_check_availability()" name="cust_name" required>
                  <tr>
                    <th width="24%" scope="row"></th>
                    <td><span id="name_availability_status"></span></td>
                  </tr>
                </div>
              </div>

              <!-- cust_add  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-6">
                  <input type="text" name="cust_add" value="<?php echo $rows['cust_add']; ?>" class="form-control" onclick="Funww()" id="more">
                </div>
              </div>

              <!-- cust_contact_per -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contact Person</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="cust_contact_per" value="<?php echo $rows['cust_contact_per']; ?>">
                </div>
              </div>
              <!-- cust_location_code -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Location</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="cust_location_code" value="<?php echo $rows['cust_location_code']; ?>">
                </div>
              </div>
              <!-- cust_TIN_no -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">TIN No</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="cust_TIN_no" value="<?php echo $rows['cust_TIN_no']; ?>">
                </div>
              </div>
              <!-- cust_VAT_no -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">VAT No</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="cust_VAT_no" value="<?php echo $rows['cust_VAT_no']; ?>">
                </div>
              </div>
              <!-- cust_TDS_no  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">TDS No</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="cust_TDS_no" value="<?php echo $rows['cust_TDS_no']; ?>" required>
                </div>
              </div>
              <!-- submit  -->
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="customerSubmit">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- customer Account Information start -->
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