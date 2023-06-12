<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['suppomerSubmit'])) {
  $id = $conn->escape_string($_POST['id']);
  $office_code = $_SESSION['office_code'];
  $supp_type = $conn->escape_string($_POST['supp_type']);
  $supp_name = $conn->escape_string($_POST['supp_name']);
  $supp_add = $conn->escape_string($_POST['supp_add']);
  $supp_business_category = $conn->escape_string($_POST['supp_business_category']);
  $supp_contact_per = $conn->escape_string($_POST['supp_contact_per']);
  $supp_location_code = $conn->escape_string($_POST['supp_location_code']);
  $supp_TIN_no = $conn->escape_string($_POST['supp_TIN_no']);
  $supp_VAT_no = $conn->escape_string($_POST['supp_VAT_no']);
  $supp_TDS_no = $conn->escape_string($_POST['supp_TDS_no']);
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertsuppomerQuery = "UPDATE `supp_info` SET `id`='$id',`office_code`='$office_code',`supp_type`='$supp_type',`supp_name`='$supp_name', `supp_add`='$supp_add',`supp_business_category`='$supp_business_category',`supp_contact_per`='$supp_contact_per',`supp_location_code`='$supp_location_code',`supp_TIN_no`='$supp_TIN_no',`supp_VAT_no`='$supp_VAT_no',`supp_TDS_no`='$supp_TDS_no',`ss_modifier`='$ss_modifier',`ss_modified_on`='$ss_modified_on',`ss_org_no`='$ss_org_no' WHERE id='$id'";

  $conn->query($insertsuppomerQuery);
  if ($conn->affected_rows == 1) {
    $message = "Upadate Successfully!";
  } else {
    $mess = "Failled!";
  }
//   header('refresh:2;supp_info.php');
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=supp_info.php\">";
}
?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $selectQueryEdit = "SELECT * FROM `supp_info` WHERE id='$id'";
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
      <h1><i class="fa fa-dashboard"></i> Edit Supplier Information </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div>
        <!-- suppomer Account Information end -->
        <div id="suppomerForm">
          <div style="padding:5px">
            <!-- form start  -->
            <form action="" method="post">
              <!-- acc conde  -->
              <input type="text" name="id" id="id" value="<?php echo $rows['id']; ?>" hidden>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-6">
                  <select name="supp_type" class="form-control" required>
                    <option value="">-Select suppomer Type-</option>
                    <?php
                    require '../database.php';
                    $selectQuery = "SELECT * FROM `code_master` where hardcode='SUPTP' AND softcode !='0'";
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php
                        echo '<option value="' . $row['softcode'] . '"=="' . $row['supp_type'] . '" selected="selected">' . $row['description'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- supp_name  -->
              <script>
                function supp_check_availability() {
                  var name = $("#supp_name").val();
                  $("#loaderIcon").show();
                  jQuery.ajax({
                    url: "supp_check_availability.php",
                    data: 'supp_name=' + name,
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
                  <input type="text" class="form-control" id="supp_name" value="<?php echo $rows['supp_name']; ?>" onkeyup="supp_check_availability()" name="supp_name" required>
                  <tr>
                    <th width="24%" scope="row"></th>
                    <td><span id="name_availability_status"></span></td>
                  </tr>
                </div>
              </div>

              <!-- supp_add  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-6">
                  <input type="text" name="supp_add" value="<?php echo $rows['supp_add']; ?>" class="form-control" onclick="Fu()" id="more">
                </div>
              </div>
              <!-- supp_business_category -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Business Category</label>
                <div class="col-sm-6">
                  <select name="supp_business_category" class="form-control" required>
                    <option value="">-Select Bussiness Category-</option>
                    <?php
                    require '../database.php';
                    $selectQuery = "SELECT * FROM `code_master` where hardcode='BUSCA' AND softcode !='0'";
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row = $selectQueryResult->fetch_assoc()) {
                    ?>
                        <option value="<?php echo $row['description']; ?>" <?php if($rows['supp_business_category']==$row['description']) { echo 'selected=selected';}?>><?php echo $row['description']; ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- supp_contact_per -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contact Person</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="supp_contact_per" value="<?php echo $rows['supp_contact_per']; ?>">
                </div>
              </div>
              <!-- supp_location_code -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Location</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="supp_location_code" value="<?php echo $rows['supp_location_code']; ?>">
                </div>
              </div>
              <!-- supp_TIN_no -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">TIN No</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="supp_TIN_no" value="<?php echo $rows['supp_TIN_no']; ?>">
                </div>
              </div>
              <!-- supp_VAT_no -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">VAT No</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="supp_VAT_no" value="<?php echo $rows['supp_VAT_no']; ?>">
                </div>
              </div>
              <!-- supp_TDS_no  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">TDS No</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="supp_TDS_no" value="<?php echo $rows['supp_TDS_no']; ?>" required>
                </div>
              </div>
              <!-- submit  -->
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="suppomerSubmit">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- suppomer Account Information start -->
        <!-- form close  -->
        <?php
        if (!empty($message)) {
          echo '<script type="text/javascript">
            Swal.fire(
                "Update Successfully!!",
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