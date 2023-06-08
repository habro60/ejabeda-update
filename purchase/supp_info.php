<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['supplierSubmit'])) {
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
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];
  $insertSupplierQuery = "INSERT INTO `supp_info`(`id`,`office_code`,`supp_type`,`supp_name`, `supp_add`,`supp_business_category`, `supp_contact_per`,`supp_location_code`,`supp_TIN_no`,`supp_VAT_no`,`supp_TDS_no`,`gl_acc_code`,`ss_creator`,`ss_created_on`,`ss_modified_on`,`ss_org_no`) values (NULL,'$office_code','$supp_type','$supp_name','$supp_add','$supp_business_category','$supp_contact_per','$supp_location_code','$supp_TIN_no','$supp_VAT_no','$supp_TDS_no','0','$ss_creator','$ss_created_on','$ss_created_on','$ss_org_no')";
//   echo $insertSupplierQuery;
//   exit;
  $conn->query($insertSupplierQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save supp Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:1;supp_info.php');
 echo "<meta http-equiv=\"refresh\" content=\"0;URL=supp_info.php\">";
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
$pid = 1005000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Supplier Information</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>
    <!-- button -->
    <div>
      <button id="supplierAddBtn" class="btn btn-success col-3"><i class="fa fa-plus" aria-hidden="true"></i> Add Supplier info. </button>
      <button id="supplierGeneralAccount" class="btn btn-info col-3"><i class="fa fa-plus"></i>GL A/C For Supplier</button>
      <button id="supplierListView" class="btn btn-primary col-3"><i class="fa fa-eye" aria-hidden="true"></i> Supplier List </button>
    </div>
    <!-- button -->
    <div class="row">
      <div class="col-md-12">
        <div>
          <br>
          <!-- General Account Information start -->

          <!-- Supplier Account Information end -->
          <div id="supplierForm" class="collapse">
            <div style="padding:5px">
              <!-- form start  -->
              <form action="" method="post">
                <!-- acc conde  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Type</label>
                  <div class="col-sm-6">
                    <select name="supp_type" class="form-control" required>
                      <option value="">-Select Supplier Type-</option>
                      <?php
                      require '../database.php';
                      $selectQuery = 'SELECT * FROM `code_master` where hardcode="SUPTP" AND softcode>0';
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
                    <input type="text" class="form-control" id="supp_name" name="supp_name" onkeyup="supp_check_availability()" required>
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
                    <input type="text" name="supp_add" class="form-control" onclick="Funww()" id="more">
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
                      $selectQuery = 'SELECT * FROM `code_master` where hardcode="BUSCA" AND softcode>0';
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row = $selectQueryResult->fetch_assoc()) {
                      ?>
                      <?php
                          echo '<option value="' . $row['description'] . '">' . $row['description'] . '</option>';
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
                    <input type="text" class="form-control" id="" name="supp_contact_per">
                  </div>
                </div>
                <!-- supp_location_code -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Location</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="supp_location_code">
                  </div>
                </div>
                <!-- supp_TIN_no -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TIN No</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="supp_TIN_no">
                  </div>
                </div>
                <!-- supp_VAT_no -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">VAT No</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="supp_VAT_no">
                  </div>
                </div>
                <!-- supp_TDS_no  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TDS No</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="supp_TDS_no">
                  </div>
                </div>
                <!-- submit  -->
                <div class="form-group row">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" name="supplierSubmit">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- Supplier Account Information start -->
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
          <!-- supplier View -->
          <div id="table">
            <div class="tile" id="supplierViewList">
              <div class="tile-body">
                <h5 style="text-align: center">Supplier List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="supplierTable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Type</th>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Category</th>
                      <th>contact</th>
                      <th>location</th>
                      <th>TIN No</th>
                      <th>Gl A/C</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT supp_info.id, supp_info.supp_type,supp_info.supp_name, supp_info.supp_add, supp_info.supp_business_category, supp_info.supp_contact_per, supp_info.supp_location_code,supp_info.supp_TIN_no,supp_info.gl_acc_code, code_master.description FROM supp_info, code_master WHERE code_master.hardcode='SUPTP' AND code_master.softcode>0 AND supp_info.supp_type=code_master.softcode";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                      echo
                        "<tr>
									<td>" . $rows['id'] . "</td>
									<td>" . $rows['description'] . "</td>
									<td>" . $rows['supp_name'] . "</td>
									<td>" . $rows['supp_add'] . "</td>
									<td>" . $rows['supp_business_category'] . "</td>
									<td>" . $rows['supp_contact_per'] . "</td>
									<td>" . $rows['supp_location_code'] . "</td>
									<td>" . $rows['supp_TIN_no'] . "</td>
									<td>" . $rows['gl_acc_code'] . "</td>
                  <td><a target='_blank' href='supp_info_edit.php?id=" . $rows['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                  </td>
								</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- table view start  -->
            <div class="tile" id="supplierGeneralAcc">
              <div class="tile-body">
                <h5 style="text-align: center">Supplier General Account List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Category</th>
                      <th>Account Code</th>
                      <th>Account Name</th>
                      <th>Printing GL Code</th>
                      <th>Group/Ledger</th>
                      <th>Account Type</th>
                      <th>Add Supplier GL A/C</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT gl_acc_code.id, gl_acc_code.category_code,gl_acc_code.acc_code,gl_acc_code.acc_head,gl_acc_code.rep_glcode,gl_acc_code.parent_acc_code,gl_acc_code.postable_acc,gl_acc_code.acc_level,gl_acc_code.acc_type,code_master.hardcode,code_master.softcode,code_master.description,code_master.sort_des FROM gl_acc_code,code_master where gl_acc_code.category_code=code_master.softcode AND code_master.hardcode='acat'AND subsidiary_group_code='300' and gl_acc_code.acc_type='6' ORDER by acc_code";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $rows['id'] . "</td>";
                      echo "<td>" . $rows['description'] . "</td>";
                      echo "<td>" . $rows['acc_code'] . "</td>";
                      echo "<td>" . $rows['acc_head'] . "</td>";
                      echo "<td>" . $rows['rep_glcode'] . "</td>";
                       ?>
                     <td style="text-align: left"><?php if ($rows['postable_acc'] =='N') {
                                                            echo "Group A/C"; 
                                                        } else {
                                                            echo "Ledger A/C";
                                                        }?></td>  

                     
                      <td style="text-align: left"><?php if ($rows['acc_type'] =='6') {
                                                        echo "Payable A/C"; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                      <!--echo "<td>" . $rows['postable_acc'] . "</td>";-->
                      <!--echo "<td>" . $rows['acc_type'] . "</td>";-->
                    
                      <td><a <?php if ($rows['postable_acc'] != 'N') {
                                echo "onclick='return false";
                              } ?> <?php echo "href='supplier_gl_account_add.php?id=" . $rows['id'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Add</a>
                      </td>
                    <?php

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
        <!-- Supplier Account View start -->
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
  $('#supplierTable').DataTable();
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#1005000").addClass('active');
    $("#1000000").addClass('active');
    $("#1000000").addClass('is-expanded')
  });

  $('#supplierGeneralAcc').hide();
  // supplierAddBtn
  $('#supplierAddBtn').on('click', function() {
    $('#supplierForm').toggle();
    $('#table').toggle();
  });
  // supplierListView
  $('#supplierListView').on('click', function() {
    $('#supplierViewList').show();
    $('#supplierGeneralAcc').hide();
  });
  // supplierGeneralAccount
  $("#supplierGeneralAccount").click(function() {
    $("#supplierViewList").hide();
    $("#supplierGeneralAcc").show();
  });
</script>
<?php
$conn->close();

?>
</body>

</html>