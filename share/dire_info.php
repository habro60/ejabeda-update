<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['directorSubmit'])) {
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
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];
  $insertdirectorQuery = "INSERT INTO `dire_info`(`id`,`office_code`,`dire_type`,`dire_name`, `dire_add`,`dire_business_category`, `dire_contact_per`,`dire_location_code`,`dire_TIN_no`,`dire_VAT_no`,`dire_TDS_no`,`authoraize_capital`,`share_of_dire`,`share_purchase_date`,`share_transfer_date`,`ss_creator`,`ss_created_on`,`ss_org_no`) values (NULL,'$office_code','$dire_type','$dire_name','$dire_add','$dire_business_category','$dire_contact_per','$dire_location_code','$dire_TIN_no','$dire_VAT_no','$dire_TDS_no','$authoraize_capital','$share_of_dire','$share_purchase_date','$share_transfer_date','$ss_creator','$ss_created_on','$ss_org_no')";
  // echo $insertdirectorQuery;
  // exit;
  $conn->query($insertdirectorQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save dire Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:1;dire_info.php');
}

$query = "Select Max(acc_code) From gl_acc_code where acc_level=1";
$returnDrow = mysqli_query($conn, $query);
$resultrow = mysqli_fetch_assoc($returnDrow);
$maxRowsrow = $resultrow['Max(acc_code)'];
if (empty($maxRowsrow)) {
  $lastRowrow = $maxRowsrow = 100000000000;
} else {
  $lastRowrow = $maxRowsrow + 100000000000;
}
require "../source/top.php";
$pid = 1201000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Director Information</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>
    <!-- button -->
    <div>
      <button id="directorAddBtn" class="btn btn-success col-3"><i class="fa fa-plus" aria-hidden="true"></i> Add director info. </button>
      <button id="directorGeneralAccount" class="btn btn-info col-3"><i class="fa fa-plus"></i>GL A/C For director</button>
      <button id="directorListView" class="btn btn-primary col-3"><i class="fa fa-eye" aria-hidden="true"></i> director List </button>
    </div>
    <!-- button -->
    <div class="row">
      <div class="col-md-12">
        <div>
          <br>
          <!-- General Account Information start -->

          <!-- director Account Information end -->
          <div id="directorForm" class="collapse">
            <div style="padding:5px">
              <!-- form start  -->
              <form action="" method="post">
                <!-- acc conde  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Type</label>
                  <div class="col-sm-6">
                    <select name="dire_type" class="form-control" required>
                      <option value="">-Select director Type-</option>
                      <?php
                      require '../database.php';
                      $selectQuery = 'SELECT * FROM `code_master` where hardcode="DIRTP" AND softcode>0';
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                      ?>
                      <?php
                          echo '<option value="' . $row['softcode'] . '">' . $row['description'] . '</option>';
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
                    <input type="text" class="form-control" id="dire_name" name="dire_name" onkeyup="dire_check_availability()" required>
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
                    <input type="text" name="dire_add" class="form-control" onclick="Funww()" id="more">
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
                      $selectQuery = "SELECT * FROM `code_master` where hardcode='BUSCA' AND softcode>'0'";
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                      ?>
                      <?php
                          echo '<option value="' . $row['softcode'] . '">' . $row['description'] . '</option>';
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
                    <input type="text" class="form-control" id="" name="dire_contact_per">
                  </div>
                </div>
                <!-- dire_location_code -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Location</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="dire_location_code">
                  </div>
                </div>
                <!-- dire_TIN_no -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TIN No</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="dire_TIN_no">
                  </div>
                </div>
                <!-- dire_VAT_no -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">VAT No</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="dire_VAT_no">
                  </div>
                </div>
                <!-- dire_TDS_no  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TDS No</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="dire_TDS_no" required>
                  </div>
                </div>

                <!-- authoraize_capital -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Authorize Capital</label>
                  <div class="col-sm-6">
                    <input type="number" class="form-control" id="" name="authoraize_capital">
                  </div>
                </div>
                <!-- share_of_dire -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Share of Director (In %)</label>
                  <div class="col-sm-6">
                    <input type="number" class="form-control" id="" name="share_of_dire">
                  </div>
                </div>
                <!-- paid_up_capital -->
                <!-- <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Paid up Capital</label>
                  <div class="col-sm-6">
                    <input type="number" class="form-control" id="" name="paid_up_capital">
                  </div>
                </div> -->
                <!-- share_purchase_date -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Share Purchase Date</label>
                  <div class="col-sm-6">
                    <input type="date" class="form-control" id="" name="share_purchase_date">
                  </div>
                </div>
                <!-- share_transfer_date -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Share Transfer Date</label>
                  <div class="col-sm-6">
                    <input type="Date" class="form-control" id="" name="share_transfer_date">
                  </div>
                </div>
                <!-- submit  -->
                <div class="form-group row">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" name="directorSubmit">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- director Account Information start -->
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
          <!-- director View -->
          <div id="table">
            <div class="tile" id="directorViewList">
              <div class="tile-body">
                <h5 style="text-align: center">Director List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="directorTable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Office Name</th>
                      <th>Type</th>
                      <th>Name</th>
                      <th>Address</th>
                      <th>contact</th>
                      <th>Location</th>
                      <th>TIN No</th>
                      <th>GL A/C</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // $sql = "SELECT * FROM dire_info";
                    $sql = "SELECT dire_info.id,dire_info.office_code,dire_info.dire_type,dire_info.dire_name,dire_info.dire_add,dire_info.dire_contact_per,dire_info.dire_location_code,dire_info.dire_TIN_no,dire_info.gl_acc_code,office_info.office_code,office_info.office_name, code_master.hardcode, code_master.softcode, code_master.description FROM `dire_info` JOIN `office_info` JOIN code_master WHERE dire_info.office_code=office_info.office_code AND code_master.softcode = dire_info.dire_type AND hardcode='DIRTP'";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?php echo  $rows['id']; ?></td>
                        <td><?php echo  $rows['office_name']; ?></td>
                        <td><?php echo  $rows['description']; ?></td>
                        <td><?php echo  $rows['dire_name']; ?></td>
                        <td><?php echo  $rows['dire_add']; ?></td>
                        <td><?php echo  $rows['dire_contact_per']; ?></td>
                        <td><?php echo  $rows['dire_location_code']; ?></td>
                        <td><?php echo  $rows['dire_TIN_no']; ?></td>
                        <td><?php if ($rows['gl_acc_code'] > 0) {
                              echo  $rows['gl_acc_code'];
                            } else {
                              echo '<button class="btn-info">Director G/A Not Create</button>';
                            } ?></td>
                        <td><a target='_blank' href='dire_info_edit.php?id=<?php echo  $rows['id']; ?>' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- table view start  -->
            <div class="tile" id="directorGeneralAcc">
              <div class="tile-body">
                <h5 style="text-align: center">Director General Account List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Category</th>
                      <th>Account Code</th>
                      <th>Account Name</th>
                      <th>GL Code</th>
                      <th>Parent Acc</th>
                      <th>Postable</th>
                      <th>Account Level</th>
                      <th>Account Type</th>
                      <th>Add director GL A/C</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT gl_acc_code.id, gl_acc_code.category_code,gl_acc_code.acc_code,gl_acc_code.acc_head,gl_acc_code.rep_glcode,gl_acc_code.parent_acc_code,gl_acc_code.postable_acc,gl_acc_code.acc_level,gl_acc_code.acc_type,code_master.hardcode,code_master.softcode,code_master.description,code_master.sort_des FROM gl_acc_code,code_master where gl_acc_code.category_code=code_master.softcode AND code_master.hardcode='acat'AND gl_acc_code.acc_type='8' ORDER by acc_code";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                      echo
                        "<tr>
									<td>" . $rows['id'] . "</td>
									<td>" . $rows['description'] . "</td>
									<td>" . $rows['acc_code'] . "</td>
									<td>" . $rows['acc_head'] . "</td>
									<td>" . $rows['rep_glcode'] . "</td>
									<td>" . $rows['parent_acc_code'] . "</td>
									<td>" . $rows['postable_acc'] . "</td>
									<td>" . $rows['acc_level'] . "</td>
									<td>" . $rows['acc_type'] . "</td>
                  <td><a target='_blank' href='dire_gl_account_add.php?id=" . $rows['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Add</a>
								</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <?php
      } else {
        echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
      } ?>
        <!-- director Account View start -->
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
<script type="text/javascript">
  $('#sampleTable').DataTable();
  $('#directorTable').DataTable();
</script>
f<script type="text/javascript">
  $(document).ready(function() {
    $("#1201000").addClass('active');
    $("#1200000").addClass('active');
    $("#1200000").addClass('is-expanded')
  });

  $('#directorGeneralAcc').hide();
  // directorAddBtn
  $('#directorAddBtn').on('click', function() {
    $('#directorForm').toggle();
    $('#table').toggle();
  });
  // directorListView
  $('#directorListView').on('click', function() {
    $('#directorViewList').show();
    $('#directorGeneralAcc').hide();
  });
  // directorGeneralAccount
  $("#directorGeneralAccount").click(function() {
    $("#directorViewList").hide();
    $("#directorGeneralAcc").show();
  });
</script>
<?php
$conn->close();

?>
</body>

</html>