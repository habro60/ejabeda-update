<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['direomerSubmit'])) {
  $id = $conn->escape_string($_POST['id']);
  $office_code = $_SESSION['office_code'];
  $dire_type = $conn->escape_string($_POST['dire_type']);
  $dire_name = $conn->escape_string($_POST['dire_name']);
  $dire_add = $conn->escape_string($_POST['dire_add']);
  $dire_business_category = $conn->escape_string($_POST['dire_business_category']);
  $dire_contact_per = $conn->escape_string($_POST['dire_contact_per']);
  $dire_location_code = $conn->escape_string($_POST['dire_location_code']);
  $dire_TIN_no = $conn->escape_string($_POST['dire_TIN_no']);
  $dire_VAT_no = $conn->escape_string($_POST['dire_VAT_no']);
  $dire_TDS_no = $conn->escape_string($_POST['dire_TDS_no']);
  // share
  $authoraize_capital = $conn->escape_string($_POST['authoraize_capital']);
  $share_of_dire = $conn->escape_string($_POST['share_of_dire']);
  // $paid_up_capital = $conn->escape_string($_POST['paid_up_capital']);
  $share_purchase_date = $conn->escape_string($_POST['share_purchase_date']);
  $share_transfer_date = $conn->escape_string($_POST['share_transfer_date']);
  // share
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertdireomerQuery = "UPDATE `dire_info` SET `id`='$id',`office_code`='$office_code',`dire_type`='$dire_type',`dire_name`='$dire_name', `dire_add`='$dire_add',`dire_business_category`='$dire_business_category',`dire_contact_per`='$dire_contact_per',`dire_location_code`='$dire_location_code',`dire_TIN_no`='$dire_TIN_no',`dire_VAT_no`='$dire_VAT_no',`dire_TDS_no`='$dire_TDS_no',`authoraize_capital`='$authoraize_capital',`share_of_dire`='$share_of_dire',`share_purchase_date`='$share_purchase_date',`share_transfer_date`='$share_transfer_date',`ss_modifier`='$ss_modifier',`ss_modified_on`='$ss_modified_on',`ss_org_no`='$ss_org_no' WHERE id='$id'";
  // echo $insertdireomerQuery;
  // exit;
  $conn->query($insertdireomerQuery);
  if ($conn->affected_rows == 1) {
    $message = "Upadate Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:2;dire_info.php');
}
?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $selectQueryEdit = "SELECT * FROM `dire_info` WHERE id='$id'";
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
      <h1><i class="fa fa-dashboard"></i> Edit Director Information </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div>
        <!-- direomer Account Information end -->
        <div id="direomerForm">
          <div style="padding:5px">
            <!-- form start  -->
            <form action="" method="post">
              <!-- acc conde  -->
              <input type="text" name="id" id="id" value="<?php echo $rows['id']; ?>" hidden>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-6">
                  <select name="dire_type" class="form-control" required>
                    <option value="">-Select direomer Type-</option>
                    <?php
                    require '../database.php';
                    $selectQuery = 'SELECT * FROM `code_master` where hardcode="DIRTP" AND softcode>0';
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php
                        echo '<option value="' . $row['softcode'] . '==' . $row['dire_type'] . '" selected="selected">' . $row['description'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- dire_name  -->
              <script>
                function dire_check_availability() {
                  var name = $("#dire_name").val();
                  $("#loaderIcon").show();
                  jQuery.ajax({
                    url: "dire_check_availability.php",
                    data: 'dire_name=' + name,
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
                  <input type="text" class="form-control" id="dire_name" value="<?php echo $rows['dire_name']; ?>" onkeyup="dire_check_availability()" name="dire_name" required>
                  <tr>
                    <th width="24%" scope="row"></th>
                    <td><span id="name_availability_status"></span></td>
                  </tr>
                </div>
              </div>

              <!-- dire_add  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-6">
                  <input type="text" name="dire_add" value="<?php echo $rows['dire_add']; ?>" class="form-control" onclick="Fu()" id="more">
                </div>
              </div>
              <!-- dire_business_category -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Business Category</label>
                <div class="col-sm-6">
                  <select name="dire_business_category" class="form-control" required>
                    <option value="">-Select Bussiness Category-</option>
                    <?php
                    require '../database.php';
                    $selectQuery = 'SELECT * FROM `code_master` where hardcode="BUSCA" AND softcode>0';
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php
                        echo '<option value="' . $row['softcode'] . '==' . $row['dire_business_category'] . '" selected="selected">' . $row['description'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- dire_contact_per -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Contact Person</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="dire_contact_per" value="<?php echo $rows['dire_contact_per']; ?>">
                </div>
              </div>
              <!-- dire_location_code -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Location</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="dire_location_code" value="<?php echo $rows['dire_location_code']; ?>">
                </div>
              </div>
              <!-- dire_TIN_no -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">TIN No</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="dire_TIN_no" value="<?php echo $rows['dire_TIN_no']; ?>">
                </div>
              </div>
              <!-- dire_VAT_no -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">VAT No</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="dire_VAT_no" value="<?php echo $rows['dire_VAT_no']; ?>">
                </div>
              </div>
              <!-- dire_TDS_no  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">TDS No</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="dire_TDS_no" value="<?php echo $rows['dire_TDS_no']; ?>" required>
                </div>
              </div>
                 <!-- authoraize_share -->
                 <div class="form-group row">
                <label class="col-sm-2 col-form-label">Authorize Capital</label>
                <div class="col-sm-6">
                  <input type="number" class="form-control" id="" name="authoraize_capital" value="<?php echo $rows['authoraize_capital']; ?>">
                </div>
              </div>
              <!-- share_of_dire -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Share of Director (In %)</label>
                <div class="col-sm-6">
                  <input type="number" class="form-control" id="" name="share_of_dire" value="<?php echo $rows['share_of_dire']; ?>">
                </div>
              </div>
                <!-- paid_up_capital -->
                <!-- <div class="form-group row">
                <label class="col-sm-2 col-form-label">Paid up Capital</label>
                <div class="col-sm-6">
                  <input type="number" class="form-control" id="" name="paid_up_capital" value="<?php // echo $rows['paid_up_capital']; ?>">
                </div>
              </div> -->
              <!-- share_purchase_date -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Share Purchase Date</label>
                <div class="col-sm-6">
                  <input type="date" class="form-control" id="" name="share_purchase_date" value="<?php echo $rows['share_purchase_date']; ?>">
                </div>
              </div>
              <!-- share_transfer_date -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Share Transfer Date</label>
                <div class="col-sm-6">
                  <input type="Date" class="form-control" id="" name="share_transfer_date" value="<?php echo $rows['share_transfer_date']; ?>">
                </div>
              </div>
              <!-- submit  -->
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="direomerSubmit">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- direomer Account Information start -->
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