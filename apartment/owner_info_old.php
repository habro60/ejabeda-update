<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];

if (isset($_POST['ownerSubmit'])) {
  $office_code = $_SESSION['office_code'];
  $owner_id = $conn->escape_string($_POST['owner_id']);
  $owner_name = $conn->escape_string($_POST['owner_name']);
  $flat_no = $conn->escape_string($_POST['flat_no']);
  $father_hus_name = $conn->escape_string($_POST['father_hus_name']);
  $mother_name = $conn->escape_string($_POST['mother_name']);
  $nid = $conn->escape_string($_POST['nid']);
  $passport_no = $conn->escape_string($_POST['passport_no']);
  $date_of_birth = $conn->escape_string($_POST['date_of_birth']);
  $mobile_no = $conn->escape_string($_POST['mobile_no']);
  $intercom_number = $conn->escape_string($_POST['intercom_number']);
  $permanent_add = $conn->escape_string($_POST['permanent_add']);
  $profession = $conn->escape_string($_POST['profession']);
  $upload_dir = '../upload/';
  $imgName = $_FILES['image']['name'];
  $imgTmp = $_FILES['image']['tmp_name'];
  $imgSize = $_FILES['image']['size'];
  $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
  $date = date("d-m-Y");
  $ownerPic = $imgName . '_' . $date . '_' . rand(1000, 9999) . '.' . $imgExt;
  move_uploaded_file($imgTmp, $upload_dir . $ownerPic);

  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertownerQuery = "INSERT INTO `apart_owner_info`(`id`,`office_code`,`owner_id`,`owner_name`, `flat_no`,`father_hus_name`,`mother_name`,`nid`, `passport_no`,`date_of_birth`, mobile_no, intercom_number, permanent_add,profession, gl_acc_code, owner_image, ss_creator,ss_created_on,ss_org_no) values  (NULL,'$office_code','$owner_id','$owner_name','$flat_no','$father_hus_name','$mother_name','$nid','$passport_no','$date_of_birth','$mobile_no','$intercom_number','$permanent_add','$profession','0','$ownerPic','$ss_creator','$ss_created_on','$ss_org_no')";

  $conn->query($insertownerQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save owner Successfully!";
  } else {
    $mess = "Failled!";
  }
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=owner_info.php\">";
}
// service facility ... 
if (isset($_POST['assignServices'])) {
  $a = $_POST['owner'];
  for ($count = 0; $count < count($_POST['owner_id']); ++$count) {
    $id = $_POST['id'][$count];
    $owner_id = $_POST['owner_id'][$count];
    $allow_flag = $_POST['allow_flag'][$count];
    $effect_date = $_POST['effect_date'][$count];
    $bill_fixed_amt = $_POST['bill_fixed_amt'][$count];
    $terminate_date = $_POST['terminate_date'][$count];
    $ss_creator = $_SESSION['username'];
    $ss_creator_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    if ($owner_id > 0) {
      $query = "update `apart_owner_sevice_facility` set `allow_flag`='$allow_flag', `bill_fixed_amt`='$bill_fixed_amt',`effect_date`='$effect_date',`terminate_date`='$terminate_date', ss_creator='$ss_creator', ss_creator_on='$ss_creator_on', ss_org_no='$ss_org_no' where id='$id'";
      $conn->query($query);
    }
    if ($conn->affected_rows == TRUE) {
      $message = "Successfully";
    } else {
      $assign_menu_failled = "Failled";
    }
  }
//   header('refresh:1;owner_info.php');
  echo "<meta http-equiv=\"refresh\" content=\"0;URL=owner_info.php\">";
}
?>

<?php
require "../source/top.php";
$pid = 1301000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Owner Information</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php

  if ($seprt_cs_info == 'Y') { ?>
    <!-- =================-- button define================= -->
    <div>
      <button id="ownerAddBtn" class="btn btn-success col-md-2"><i class="fa fa-plus"></i>Add Owner info. </button>
      <button id="GLAddBtn" class="btn btn-info col-md-2"><i class="fa fa-plus"></i>GL A/C For Owner</button>
      <button id="ownerListBtn" class="btn btn-primary col-md-3"><i class="fa fa-eye"></i> Owner List </button>
      <button id="servicesListBtn" class="btn btn-primary col-md-2"><i class="fa fa-eye"></i> Service Facility</button>
      <button id="assignedFlatBtn" class="btn btn-primary col-md-2"><i class="fa fa-eye"></i> Assigned Flat</button>
    </div>
    <!-- ====================button Define closed=============== -->
    <div class="row">
      <div class="col-md-12">
        <div>
          <br>
          <!-- Owner Account Information end -->
          <div id="ownerForm" class="collapse">
            <div style="padding:5px">
              <!-- form start  -->
              <!-- <form action="" method="post"> -->
              <form method="post" enctype="multipart/form-data">
                <!--Owner under Office -->
          
                <!-- owner_id  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Owner ID</label>
                  <div class="col-sm-6">
                    <input type="text" name="owner_id" class="form-control" onclick="Funww()" id="more">
                  </div>
                </div>
                <!-- owner_name  -->
                <script>
                  function owner_check_availability() {
                    var name = $("#owner_name").val();
                    $("#loaderIcon").show();
                    jQuery.ajax({
                      url: "owner_check_availability.php",
                      data: 'owner_name=' + name,
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
                    <input type="text" class="form-control" id="owner_name" onkeyup="owner_check_availability()" name="owner_name" required>
                    <tr>
                      <th width="24%" scope="row"></th>
                      <td><span id="name_availability_status"></span></td>
                    </tr>
                  </div>
                </div>

                <!-- Flat No. -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Residential No.</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="flat_no">
                  </div>
                </div>
                <!-- father_hus_name -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Father Name</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="father_hus_name">
                  </div>
                </div>
                <!-- mother_name -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Mother Name</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="mother_name">
                  </div>
                </div>
                <!-- NID -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NID</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="nid">
                  </div>
                </div>
                <!-- passport_no  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Passport No.</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="passport_no">
                  </div>
                </div>
                <!-- date_of_birth  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Date of Birth.</label>
                  <div class="col-sm-6">
                    <input type="date" class="form-control" id="" name="date_of_birth">
                  </div>
                </div>
                <!-- Mobile No.  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Mobile Number</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="mobile_no" required>
                  </div>
                </div>
                <!-- intercom_number  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Intercome Number</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="intercom_number">
                  </div>
                </div>
                <!-- permanent_add  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Parmenant Address</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="permanent_add">
                  </div>
                </div>
                <!-- profession  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Profession</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="profession">
                  </div>
                </div>
                <!-- owner_image  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Owner Photograph</label>
                  <div class="col-sm-6">
                    <input type="file" name="image" class="form-control">
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
              title: "oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
          } else {
          }
          ?>

          <!-- ========================== GL Add A/C==================== -->
          <div id="table">
            <!-- table view start  -->
            <div class="tile" id="GLAddForm">
              <div class="tile-body">
                <h5 style="text-align: center">Owner General Account List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="GLAddTable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Category</th>
                      <th>Account Code</th>
                      <th>Account Name</th>
                      <th>Printing GL Code</th>
                      <th>Postable</th>
                      <th>Account Type</th>
                      <th>Add Owner GL A/C</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT gl_acc_code.id, gl_acc_code.category_code,gl_acc_code.acc_code,gl_acc_code.acc_head,gl_acc_code.rep_glcode,gl_acc_code.parent_acc_code,
                    gl_acc_code.postable_acc,gl_acc_code.acc_level,gl_acc_code.acc_type,code_master.hardcode,code_master.softcode,code_master.description,code_master.sort_des
                     FROM gl_acc_code,code_master where gl_acc_code.category_code=code_master.softcode AND code_master.hardcode='acat'AND acc_type=7 and subsidiary_group_code='800' 
                     ORDER by acc_code";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row['id'] . "</td>";
                      echo "<td>" . $row['description'] . "</td>";
                      echo "<td>" . $row['acc_code'] . "</td>";
                      echo "<td>" . $row['acc_head'] . "</td>";
                      echo "<td>" . $row['rep_glcode'] . "</td>";
                      echo "<td>" . $row['postable_acc'] . "</td>";
                      echo "<td>" . $row['acc_type'] . "</td>";
                    ?>

                      <td><a <?php if ($row['postable_acc'] != 'N') {
                                echo "onclick='return false";
                              } ?> <?php echo "href='owner_gl_account_add.php?id=" . $row['id'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Add</a>
                      </td>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- ======= Assigned Flat ======= -->

            <div class="card" id="assignedFlat">
              <div class="card-header" style="background-color:#85C1E9">
                <h4 style="text-align:center">Assign Flat to Owner</h4>
              </div>
              <form method="POST">
                <table class="table bg-light table-bordered table-sm">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Flat Number</th>
                      <th>Flat Area</th>
                      <th>Side</th>
                      <th>location</th>
                      <th>Block Number</th>
                      <th>Assigned To Owner</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT flat_info.id,flat_info.office_code, flat_info.flat_no, flat_info.flat_area, flat_info.side_of_flat, flat_info.building, flat_info.block_no, flat_info.owner_id,flat_info.flat_status FROM `flat_info` order by flat_info.id";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                    ?>
                      <tr>
                        <input type="hidden" name="flat_status[]" class="form-control" value="<?php echo $row['flat_status']; ?>" style="width: 100%" readonly>
                        <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $row['office_code']; ?>" style="width: 100%" readonly>
                        <td>
                          <input type="text" name="id[]" class="form-control" value="<?php echo $row['id']; ?>" style="width: 100%" readonly>
                        </td>
                        <td>
                          <input type="text" name="flat_no[]" class="form-control" value="<?php echo $row['flat_no']; ?>" style="width: 100%" readonly>
                        </td>
                        <td>
                          <input type="text" name="flat_area[]" class="form-control" value="<?php echo $row['flat_area']; ?>" style="width: 100%" readonly>
                        </td>
                        <td>
                          <input type="text" name="side_of_flat[]" class="form-control" value="<?php echo $row['side_of_flat']; ?>" style="width: 100%" readonly>
                        </td>
                        <td>
                          <input type="text" name="building[]" class="form-control" value="<?php echo $row['building']; ?>" style="width: 100%" readonly>
                        </td>
                        <td>
                          <input type="text" name="block_no[]" class="form-control" value="<?php echo $row['block_no']; ?>" style="width: 100%" readonly>
                        </td>

                        <input type="hidden" name="owner_id[]" class="form-control" value="<?php echo $row['owner_id']; ?>" readonly>

                        <td>
                          <!-- Owner for Flat -->
                          <select name="owner_no[]" class="form-control" id="owner_id<?php echo $row['id']; ?>" onchange="ownerAssign('<?php echo $row['id']; ?>')" <?php if ($row['flat_status'] == 1) {
                                                                                                                                                                      echo 'disabled';
                                                                                                                                                                    } ?> style="width: 200px">

                            <option value="">- Select owner -</option>
                            <?php
                            $selectQuery = 'SELECT owner_id, owner_name FROM `apart_owner_info`';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                              while ($row_owner = $selectQueryResult->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $row_owner['owner_id']; ?>" <?php if ($row_owner['owner_id'] == $row['owner_id']) { ?> selected="selected" <?php } ?>><?php echo $row_owner['owner_name']; ?></option>

                            <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>

                  </tbody>
                </table>
              </form>
            </div>
          </div>
          <!-- =====Owner List ======= -->
          <div class="tile" id="ownerListForm">
            <div class="tile-body">
              <h5 style="text-align: center">Owner List</h5>
              <!-- General Account View start -->
              <table class="table table-hover table-bordered" id="ownerListTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Project</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Residential No.</th>
                    <th>Father</th>
                    <th>Mother </th>
                    <th>NID</th>
                    <th>Birth Date</th>
                    <th>Mobile No.</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no =0;
                  $sql = "SELECT apart_owner_info.id,apart_owner_info.owner_name,apart_owner_info.flat_no,apart_owner_info.father_hus_name,apart_owner_info.mother_name,apart_owner_info.nid,apart_owner_info.passport_no, apart_owner_info.date_of_birth,apart_owner_info.mobile_no,apart_owner_info.owner_image,office_info.office_code, office_info.office_name FROM `apart_owner_info`, office_info where apart_owner_info.office_code=office_info.office_code";
                  $query = $conn->query($sql);
                  while ($rows = $query->fetch_assoc()) {
                    $no ++;
                    echo
                      "<tr>
                  <td>" . $no . "</td>
                  <td>" . $rows['office_name'] . "</td>
                  <td><img src='../upload/" . $rows['owner_image'] . "' style='width:50px;height:50px'></td>
									<td>" . $rows['owner_name'] . "</td>
									<td>" . $rows['flat_no'] . "</td>
									<td>" . $rows['father_hus_name'] . "</td>
									<td>" . $rows['mother_name'] . "</td>
									<td>" . $rows['nid'] . "</td>
									<td>" . $rows['date_of_birth'] . "</td>
                  <td>" . $rows['mobile_no'] . "</td>
                  
                  <td><a target='_blank' href='owner_edit_info.php?id=" . $rows['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                  </td>
								</tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- =====Services Facility===== -->
          <div class="card" id="servicesListForm">
            <div class="card-header" style="background-color:#85C1E9">
              <h4 style="text-align:center">Assign Services to Owner</h4>
            </div>
            <div class="card-body">
              <table style="width: 100%">
                <th>Assign following services to Ownner</th>
                <th>Flat No</th>
                <th></th>
                <tbody>
                  <tr>
                    <form method="POST" name="search">
                      <div class="search-box">
                        <td>
                          <select id="owner_id" class="form-control">
                            <option value="">- Select owner -</option>
                            <?php
                            $selectQuery = 'SELECT owner_id, owner_name FROM `apart_owner_info`';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                              while ($row = $selectQueryResult->fetch_assoc()) {
                                echo '<option value="' . $row['owner_id'] . '">' . $row['owner_name'] . '</option>';
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td>
                          <select id="flat_no" class="form-control">
                            <option value="">- Select Flat -</option>
                            <?php
                            $selectQuery = 'SELECT id, flat_no FROM `flat_info`';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                              while ($row = $selectQueryResult->fetch_assoc()) {
                                echo '<option value="' . $row['flat_no'] . '">' . $row['flat_no'] . '</option>';
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td><input class="btn btn-info" id="search" value=" Search Now !" onclick="serviceAssign()" readonly></td>
                      </div>
                    </form>
                  </tr>
                </tbody>
              </table> <br>
              <div id="serviceResult">
                <!-- serviceResult -->
              </div>
            </div>
          </div>
        <?php
      } else {
        echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
      } ?>
        <!-- end of service facility -->
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
<!--  -->
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script type="text/javascript">
  $('#GLAddTable').DataTable();
  $('#ownerListTable').DataTable();
  $('#servicesListTable').DataTable();
</script>
<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#1301000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded');
  });
  // more informatino script start
  $('#more_show').hide();
  var id = this.value;
  $('#more').on('click', function() {
    $('#more_show').show(1000);
  });
  //=========
  $('.group').on('click', function() {
    $('#more_show').hide();
  });
  //=========
  function ownerAssign(id) {
    $.confirm({
      title: 'Assigned To Owner',
      content: 'Are You Assign To Owner !!',
      btnClass: 'btn-btn info',
      buttons: {
        Assign: function() {
          var owner_id = $('#owner_id' + id).val();
          // alert(owner_id);
          $.ajax({
            type: "POST",
            url: "getFlatUpdate.php",
            data: {
              id: id,
              owner_id: owner_id
            },
            dataType: "JSON",
            success: function(response) {
              $("#owner_id" + id).attr("disabled", true);
              $.alert('Assigned Successfull!');
            },
            error: function(response) {
              alert('Assign Failled!');
              // location.reload();
            }
          });
         
        },
        cancel: function() {
          $.alert('Canceled!');
        }
      }
    })
  }
  
  // on change
  $('#submit').hide();
  $(document).on('change', '.owner', function() {
    $('.owner').val($(this).val());
    $(".owner").addClass("intro");
    // show and hide
    $('#submit').show();
  });
  $('#GLAddForm').hide();
  $('#ownerListForm').hide();
  $('#assignedFlat').hide();
  // $('#servicesListForm').hide();

  // ownerAddBtn
  $('#ownerAddBtn').on('click', function() {
    $('#ownerForm').toggle();
    $('#table').toggle();
  });
  // ownerListBtn
  $('#ownerListBtn').on('click', function() {
    $('#ownerListForm').show();
    $('#GLAddForm').hide();
    $('#servicesListForm').hide();
    $('#assignedFlat').hide();

  });
  // GLAddBtn
  $("#GLAddBtn").click(function() {
    $("#GLAddForm").show();
    $("#ownerListForm").hide();
    $('#servicesListForm').hide();
    $('#assignedFlat').hide();
  });
  // servicesListBtn
  $("#servicesListBtn").click(function() {
    $('#servicesListForm').show();
    $("#ownerListForm").hide();
    $('#GLAddForm').hide();
    $('#assignedFlat').hide();

  });
  // assigned FlatBtn
  $("#assignedFlatBtn").click(function() {
    $('#assignedFlat').show();
    $("#ownerListForm").hide();
    $('#GLAddForm').hide();
    $('#servicesListForm').hide();

  });
  //

  function serviceAssign() {
    var owner_id = $('#owner_id').val();
    var flat_no = $('#flat_no').val();
    $.ajax({
      type: "POST",
      url: "getServiceFacility.php",
      data: {
        owner_id: owner_id,
        flat_no: flat_no
      },
      dataType: "Text",
      success: function(response) {
        $('#serviceResult').html(response);
      }
    });
  }
</script>
<?php
$conn->close();
?>
</body>

</html>