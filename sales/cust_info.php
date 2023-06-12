<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['customerSubmit'])) {
  // $office_code = $_SESSION['office_code'];
  $office_code = $conn->escape_string($_POST['office_code']);
  $cust_type = $conn->escape_string($_POST['cust_type']);
  $cust_name = $conn->escape_string($_POST['cust_name']);
  $cust_add = $conn->escape_string($_POST['cust_add']);
  $cust_business_category= '1';
  $cust_contact_per = $conn->escape_string($_POST['cust_contact_per']);
  $cust_location_code = $conn->escape_string($_POST['cust_location_code']);
  $cust_TIN_no = $conn->escape_string($_POST['cust_TIN_no']);
  $cust_VAT_no = $conn->escape_string($_POST['cust_VAT_no']);
  $cust_TDS_no = $conn->escape_string($_POST['cust_TDS_no']);
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertcustomerQuery = "INSERT INTO `cust_info`(`id`,`office_code`,`cust_type`,`cust_name`, `cust_add`,`cust_business_category`,`cust_contact_per`,`cust_location_code`,`cust_TIN_no`,`cust_VAT_no`,`cust_TDS_no`,`gl_acc_code`,`ss_creator`,`ss_created_on`,`ss_modified_on`,`ss_org_no`) values (NULL,'$office_code','$cust_type','$cust_name','$cust_add','$cust_business_category','$cust_contact_per','$cust_location_code','$cust_TIN_no','$cust_VAT_no','$cust_TDS_no','0','$ss_creator','$ss_created_on','$ss_created_on','$ss_org_no')";

  $conn->query($insertcustomerQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save cust Successfully!";
  } else {
    $mess = "Failled!";
  }
     //   header('refresh:1;cust_info.php');
     echo "<meta http-equiv=\"refresh\" content=\"0;URL=cust_info.php\">";
}
?>
<?php
require "../source/top.php";
$pid = 1102000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Customer Information</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>
    <!-- button -->
    <div>
      <button id="customerAddBtn" class="btn btn-success col-3"><i class="fa fa-plus"></i>Add Customer info. </button>
      <button id="customerGeneralAccount" class="btn btn-info col-3"><i class="fa fa-plus"></i>GL A/C For Customer</button>
      <button id="customerListView" class="btn btn-primary col-3"><i class="fa fa-eye"></i> Customer List </button>
    </div>
    <!-- button -->
    <div class="row">
      <div class="col-md-12">
        <div>
          <br>
          <!-- customer Account Information end -->
          <div id="customerForm" class="collapse">
            <div style="padding:5px">
              <!-- form start  -->
              <form action="" method="post">
                <!-- Customer under Office -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Customer Under Project</label>
                  <div class="col-sm-6">
                    <select name="office_code" class="form-control" required>
                      <option value="">-Select Office Code-</option>
                      <?php
                      require '../database.php';
                      $selectQuery = 'SELECT office_code, office_name FROM office_info';
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row_off = $selectQueryResult->fetch_assoc()) {
                      ?>
                      <?php
                          echo '<option value="' . $row_off['office_code'] . '">' . $row_off['office_name'] . '</option>';
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
                          echo '<option value="' . $row['softcode'] . '">' . $row['description'] . '</option>';
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
                    <input type="text" class="form-control" id="cust_name" onkeyup="cust_check_availability()" name="cust_name" required>
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
                    <input type="text" name="cust_add" class="form-control" onclick="Funww()" id="more" required>
                  </div>
                </div>

                <!-- cust_contact_per -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Contact</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="cust_contact_per">
                  </div>
                </div>
                <!-- cust_location_code -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Location</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="cust_location_code">
                  </div>
                </div>
                <!-- cust_TIN_no -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TIN No</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="cust_TIN_no">
                  </div>
                </div>
                <!-- cust_VAT_no -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">VAT No</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="cust_VAT_no">
                  </div>
                </div>
                <!-- cust_TDS_no  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">TDS No</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="cust_TDS_no">
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
          <div id="table">
            <!-- table view start  -->
            <div class="tile" id="customerGeneralAcc">
              <div class="tile-body">
                <h5 style="text-align: center">Customer General Account List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="customerGeneralAccListTable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Category</th>
                      <th>Account Code</th>
                      <th>Account Name</th>
                      <th>Printing GL Code</th>
                      <th>Ledger</th>
                      <th>Account Type</th>
                      <th>Add Customer GL A/C</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT gl_acc_code.id, gl_acc_code.category_code,gl_acc_code.acc_code,gl_acc_code.acc_head,gl_acc_code.rep_glcode,gl_acc_code.parent_acc_code,gl_acc_code.postable_acc,gl_acc_code.acc_level,gl_acc_code.acc_type,gl_acc_code.subsidiary_group_code,code_master.hardcode,code_master.softcode,code_master.description,code_master.sort_des FROM gl_acc_code,code_master where gl_acc_code.category_code=code_master.softcode AND code_master.hardcode='acat'AND gl_acc_code.acc_type='7' and subsidiary_group_code= '200' ORDER by acc_code";
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
                              } ?> <?php echo "href='cust_gl_account_add.php?id=" . $row['id'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Add</a>
                      </td>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tile" id="customerViewList">
              <div class="tile-body">
                <h5 style="text-align: center">Customer List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="customerListTable">
                  <thead>
                    <tr>

                      <th>ID</th>
                      <th>Under Project</th>
                      <th>Type</th>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Business Category</th>
                      <th>contact</th>
                      <th>location</th>
                      <th>TIN No</th>
                      <th>VAT No</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT * FROM `cust_info`";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                      echo
                        "<tr>
                  <td>" . $rows['id'] . "</td>
                  <td>" . $rows['office_code'] . "</td>
									<td>" . $rows['cust_type'] . "</td>
									<td>" . $rows['cust_name'] . "</td>
									<td>" . $rows['cust_add'] . "</td>
									<td>" . $rows['cust_business_category'] . "</td>
									<td>" . $rows['cust_contact_per'] . "</td>
									<td>" . $rows['cust_location_code'] . "</td>
									<td>" . $rows['cust_TIN_no'] . "</td>
									<td>" . $rows['cust_VAT_no'] . "</td>
                  <td><a target='_blank' href='cust_info_edit.php?id=" . $rows['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                  </td>
								</tr>";
                      // include('edit_delete_modal.php');
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- customer Account View start -->
          <?php
        } else {
          echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
        } ?>
          </div>
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
  $('#customerGeneralAccListTable').DataTable();
  $('#customerListTable').DataTable();
</script>
<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#1102000").addClass('active');
    $("#1100000").addClass('active');
    $("#1100000").addClass('is-expanded');
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
  $('#aaa').on('change', function() {
    //  alert(this.value);
    var id = this.value;
    if (id == Y) {
      // alert('ok');
      $.ajax({
        type: "post",
        url: "get_more_info.php",
        data: "id=" + id,
        dataType: "JOSN",
        success: function(response) {}
      });
    }

  });
  $('#customerGeneralAcc').hide();
  // customerAddBtn
  $('#customerAddBtn').on('click', function() {
    $('#customerForm').toggle();
    $('#table').toggle();
  });
  // customerListView
  $('#customerListView').on('click', function() {
    $('#customerViewList').show();
    $('#customerGeneralAcc').hide();
  });
  // customerGeneralAccount
  $("#customerGeneralAccount").click(function() {
    $("#customerViewList").hide();
    $("#customerGeneralAcc").show();
  });
</script>
<?php
$conn->close();
?>
</body>

</html>