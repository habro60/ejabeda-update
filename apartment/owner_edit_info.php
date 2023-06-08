<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $selectQueryEdit = "SELECT * FROM `apart_owner_info` WHERE id='$id'";
  $selectQueryEditResult = $conn->query($selectQueryEdit);
  $rows = $selectQueryEditResult->fetch_assoc();
}
if (isset($_POST['ownerSubmit'])) {

  $office_code = $_SESSION['office_code'];
  $id = $conn->escape_string($_POST['id']);
  $owner_id = $conn->escape_string($_POST['owner_id']);
  $owner_name = $conn->escape_string($_POST['owner_name']);
  // $flat_no = $conn->escape_string($_POST['flat_no']);
  $father_hus_name = $conn->escape_string($_POST['father_hus_name']);
  $mother_name = $conn->escape_string($_POST['mother_name']);
  $nid = $conn->escape_string($_POST['nid']);
  $passport_no = $conn->escape_string($_POST['passport_no']);
  $date_of_birth = $conn->escape_string($_POST['date_of_birth']);
  $mobile_no = $conn->escape_string($_POST['mobile_no']);
  $intercom_number = $conn->escape_string($_POST['intercom_number']);
  $permanent_add = $conn->escape_string($_POST['permanent_add']);
  $profession = $conn->escape_string($_POST['profession']);

  // file upload ......
  $imgName = $_FILES['image']['name'];
  $imgTmp = $_FILES['image']['tmp_name'];
  $imgSize = $_FILES['image']['size'];

  if ($imgName) {
    $upload_dir = '../upload/';
    $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
    $date = date("d-m-Y");
    $ownerPic = $imgName . '_' . $date . '_' . rand(1000, 9999) . '.' . $imgExt;
    unlink($upload_dir . $rows['owner_image']);
    move_uploaded_file($imgTmp, $upload_dir . $ownerPic);
  } else {
    $ownerPic =  $rows['owner_image'];
  }
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertownerQuery = "UPDATE `apart_owner_info` SET `id`='$id',`office_code`='$office_code',`owner_id`='$owner_id',`owner_name`='$owner_name', `father_hus_name`='$father_hus_name', `mother_name`='$mother_name',`nid`='$nid',`passport_no`='$passport_no',`date_of_birth`='$date_of_birth', `mobile_no`='$mobile_no', intercom_number='$intercom_number', `permanent_add`='$permanent_add', `profession`='$profession', `owner_image`='$ownerPic',`ss_modifier`='$ss_modifier',`ss_modified_on`='$ss_modified_on',`ss_org_no`='$ss_org_no' WHERE id='$id'";
    // echo $insertownerQuery;
    // exit;


  $conn->query($insertownerQuery);
  if ($conn->affected_rows == 1) {
    $message = "Update Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:1;owner_info.php');
}
?>
<?php
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Edit Owner Information </h1>
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
            <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" class="form-control" id="" value="<?php echo $rows['id']; ?>" name="id">
              <!-- owner ID  -->
              <input type="hidden" name="owner_id" value="<?php echo $rows['owner_id']; ?>" class="form-control" onclick="Funww()" id="more">
              <!-- <div>
                <img class="app-sidebar__user-avatar" src="../upload/<?php echo $rows['owner_image']; ?>" height="50px" width="50px" alt="User Image">
              </div> -->
              <!-- owner_name  -->
              <!-- <script>
                function owner_check_availability() {
                  var name = $("#owner_name").val();
                  $("#loaderIcon").show();
                  jQuery.ajax({
                    url: "owner_check_availability.php",
                    data: 'cust_name=' + name,
                    type: "POST",
                    success: function(data) {
                      $("#name_availability_status").html(data);
                      $("#loaderIcon").hide();
                    },
                    error: function() {}
                  });
                }
              </script> -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-6">
                  <input type="text" name="owner_name" class="form-control" id="owner_name" value="<?php echo $rows['owner_name']; ?>" required>

                  <!-- <input type="text" class="form-control" id="owner_name" value="<?php echo $rows['owner_name']; ?>" onkeyup="owner_check_availability()" name="owner_name" required> -->
                  <tr>
                    <th width="24%" scope="row"></th>
                    <td><span id="name_availability_status"></span></td>
                  </tr>
                </div>
              </div>

              <!-- flat_no  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Residential No.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="flat_no" value="<?php echo $rows['flat_no']; ?>" readonly>
                </div>
              </div>

              <!-- father_hus_name -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Father's/Husban Name</label>
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
                  <input type="date" class="form-control" id="" name="date_of_birth" value="<?php echo $rows['date_of_birth']; ?>" required>
                </div>
              </div>
              <!-- mobile_no  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Mobile Number.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="mobile_no" value="<?php echo $rows['mobile_no']; ?>" required>
                </div>
              </div>
              <!-- intercom_number  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Inter Com Number.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="intercom_number" value="<?php echo $rows['intercom_number']; ?>" required>
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
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Owner Photograph</label>
                <div class="col-sm-6">
                  <!-- <input type="file" name="image" class="form-control"> -->
                  <input type="file" class="form-control" id="" name="image" accept="image/*" value="<?php echo $rows['owner_image']; ?>">
                </div>
              </div>
              <!-- submit  -->
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="ownerSubmit">Submit</button>
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