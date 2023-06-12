<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];

if (isset($_POST['ownerSubmit'])) {

  $sql="SELECT max(owner_id) as last_owner_id FROM `apart_owner_info`";
  $sqlResult = $conn->query($sql);
  $rows = $sqlResult->fetch_assoc();
  $last_owner_id = ($rows['last_owner_id'] + '1');
  
  $office_code = $_SESSION['office_code'];
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

  $insertownerQuery = "INSERT INTO `apart_owner_info`(`id`,`office_code`,`owner_id`,`owner_name`, `father_hus_name`,`mother_name`,`nid`, `passport_no`,`date_of_birth`, mobile_no, intercom_number, permanent_add,profession, gl_acc_code, owner_image, ss_creator,ss_created_on,ss_org_no) values  (NULL,'$office_code','$last_owner_id','$owner_name','$father_hus_name','$mother_name','$nid','$passport_no','$date_of_birth','$mobile_no','$intercom_number','$permanent_add','$profession','0','$ownerPic','$ss_creator','$ss_created_on','$ss_org_no')";

  $conn->query($insertownerQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save owner Successfully!";
  } else {
    $mess = "Failled!";
  }
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
      <button id="ownerListBtn" class="btn btn-primary col-md-3"><i class="fa fa-eye"></i> Owner List </button>
      <button id="FlatDetailsBtn" class="btn btn-info col-md-2"><i class="fa fa-plus"></i>Flat Details</button>
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

                <!-- Flat No.
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Residential No.</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="flat_no">
                  </div>
                </div> -->
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
            <div class="tile" id="FlatDetails">
              <div class="tile-body">
                <h5 style="text-align: center">Flat Detail Information</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="GLAddTable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Flat/Shop Number</th>
                      <th>Flte/Shop Name</th>
                      <th>Owner ID</th>
                      <th>Billing GL A/C</th>
                      <th>Action To Set Owner</th>
                      <th>Action To Set GL A/c</th>
                      <th>Action To Define Services</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT flat_info.id, flat_info.flat_no , flat_info.flat_title, flat_info.owner_id, flat_info.billing_gl_code FROM flat_info order by flat_info.flat_no";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row['id'] . "</td>";
                      echo "<td>" . $row['flat_no'] . "</td>";
                      echo "<td>" . $row['flat_title'] . "</td>";
                      echo "<td>" . $row['owner_id'] . "</td>";
                      echo "<td>" . $row['billing_gl_code'] . "</td>";
                    ?> 
                    <!-- <td><a <?php if ($row['owner_id']   > '0') {
                           echo "onclick='return false";
                          } ?> <?php  echo "href='owner_flat_assigned.php?id=" . $row['id'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Assigned Owner</a>
                      </td>  
                      echo "<td>" . $row['flat_no'] . "</td>"; 
                      echo "<td>" . $row['flat_title'] . "</td>";
                      echo "<td>" . $row['owner_id'] . "</td>";
                      echo "<td>" . $row['billing_gl_code'] . "</td>";
                    ?>  -->
                    <td><a <?php if ($row['owner_id'] > '0') {
                           echo "onclick='return false";
                          } ?> <?php  echo "href='owner_flat_assigned.php?id=" . $row['id'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Assigned Owner</a>
                      </td> 
                    </td>


                    <td> <a <?php if ($row['billing_gl_code'] > '0') {
                           echo "onclick='return false";
                          } ?> href="owner_gl_account_add.php?flat_no=<?php echo  $row['flat_no']; ?>&owner_id=<?php echo  $row['owner_id']; ?>"class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Billing GL A/C</a> </td>

                    <td> <a  href="owner_services_facility.php?flat_no=<?php echo  $row['flat_no']; ?>&owner_id=<?php echo  $row['owner_id']; ?>"class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Add Service Facility</a> </td> 
                    
                    
                    <!-- <td><a <?php  echo "href='owner_services_facility.php?id=" . $row['id'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Add Service Facility</a>
                      </td> -->
                    <?php

                    }
                    ?>
                  </tbody>
                </table>
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
  
  // $('#FlatDetails').hide();
  $('#ownerListForm').hide();
  $('#ownerForm').hide();
  
  
  $('#ownerAddBtn').on('click', function() {
    $('#ownerForm').toggle();
    $('#FlatDetails').hide();
    $("#ownerListForm").hide();
  });
  // ownerListBtn
  $('#ownerListBtn').on('click', function() {
    $('#ownerListForm').show();
    $('#FlatDetails').hide();
    $('#ownerForm').hide();
    

  });
  // FlatDetailsBtn
  $("#FlatDetailsBtn").click(function() {
    $("#FlatDetails").show();
    $("#ownerListForm").hide();
    $('#ownerForm').hide();
    
  });
  
</script>
<?php
$conn->close();
?>
</body>

</html>