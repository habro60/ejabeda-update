<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['submit'])) {

  $office_code = $conn->escape_string($_SESSION['office_code']);

 
  $member_id = $conn->escape_string($_POST['member_id']);
  $member_name = $conn->escape_string($_POST['member_name']);
  $member_position = $conn->escape_string($_POST['member_position']);
  $flat_no = $conn->escape_string($_POST['flat_no']);
  $mobile_no = $conn->escape_string($_POST['mobile_no']);
  $formation_date = $conn->escape_string($_POST['formation_date']);
  // $flat_status = $conn->escape_string($_POST['flat_status']);
  // $status_date = $conn->escape_string($_POST['status_date']);
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertData = "INSERT INTO committee_info (id,office_code, flat_no, member_id,member_name, member_position, mobile_no,`formation_date`,committee_status, status_date,ss_creator,ss_created_on,ss_modifier,ss_modified_on,ss_org_no) values (null,'$office_code','$flat_no','$member_id','$member_name','$member_position','$mobile_no','$formation_date','0',now(), '$ss_creator','$ss_created_on','$ss_creator','$ss_created_on','$ss_org_no')";

  echo $insertData;
  exit;
  $conn->query($insertData);

  if ($conn->affected_rows == 1) {
    $message = "Save owner Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:1;committee_info.php');
}

require "../source/top.php";
$pid = 1310000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Committee Information </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>


    <!-- ===== button define ====== -->
    <div>
      <button id="flatAddBtn" class="btn btn-success"><i class="fa fa-plus"></i>Add Member of Committee</button>
      <button id="flatListBtn" class="btn btn-primary"><i class="fa fa-eye"></i>View and EditMember Info. </button>
    </div>
    <!-- ====== button Define closed ====== -->
    <div class="row">
      <div class="col-md-12">
        <div>
          <div id="flatAdd" class="collapse">
            <div style="padding:5px">
              <!-- form start  -->
              <form method="post">
                <!-- ======= Office Code ======-->
                <div class="form-row form-group">
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-header">
                        Add Member Information
                      </div>
                      <div class="card-body">
                        <!---=====Member Name.======-->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Member ID</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="member_id">
                          </div>
                        </div>
                        <!---======Member Name =======-->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Member Name</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                           <div> <select name="member_name" id="member_name" class="form-control" style="width: 120px" required>                   
                            <option value="">- Member -</option>
                            <?php
                            $selectQuery = 'SELECT *  from apart_owner_info';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                              while ($notice = $selectQueryResult->fetch_assoc()) {
                            ?>
                            <?php
                                echo '<option value="' . $notice['owner_name'] . '" >' . $notice['owner_name'] . '</option>';
                              }
                            }
                            ?>
                          </select>
                            </div>
                        </div>
                        </div>
                        <!---====== Member Position =====--->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Member Position</label>
                          <label class="col-form-label">:</label>
                          <div class="col">

                          <div> <select name="member_position" id="member_name" class="form-control" style="width: 120px" required>                   
                            <option value="">- Position -</option>
                            <?php
                            $selectQuery = "SELECT *  from code_master where hardcode='comtp' and softcode>'0'";
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                              while ($notice = $selectQueryResult->fetch_assoc()) {
                            ?>
                            <?php
                                echo '<option value="' . $notice['softcode'] . '" >' . $notice['description'] . '</option>';
                              }
                            }
                            ?>
                          </select>
                          </div>
                          </div>
                        </div>
                        <!--====== Flat Na =======--->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Flat Number</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                          <div> <select name="flat_no" id="" class="form-control" style="width: 120px" required>                   
                            <option value="">- Flat No. -</option>
                            <?php
                            $selectQuery = 'SELECT *  from flat_info';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                              while ($notice = $selectQueryResult->fetch_assoc()) {
                            ?>
                            <?php
                                echo '<option value="' . $notice['flat_no'] . '" >' . $notice['flat_no'] . '</option>';
                              }
                            }
                            ?>
                          </select>
                          </div>
                          </div>
                        </div>
                        <!-- ====== Mobile No  =======-->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Mobile Number</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="mobile_no" required>
                          </div>
                        </div>
                        <!-- ====== formation_date  =======-->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Committee Formation Date</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="formation_date" required>
                          </div>
                        </div>
                        <div>
                          <input type="hidden" name="activation_key" value="0">
                          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
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
    <!-- ====== flat View List ====== -->
    <div class="tile" id="flatList">
      <div class="tile-body">
        <h5 style="text-align: center">Committee Member List </h5>
        <!-- General Account View start -->
        <table class="table table-hover table-bordered" id="memberTable">
          <thead>
            <tr>
              <th>Sl.No.</th>
              <th>Office</th>
              <th>Member ID</th>
              <th>Name</th>
              <th>Position</th>
              <th>Flat Number</th>
              <th>Mobile Number</th>
              <th>Committee Formed Date</th>
              
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $sql = "SELECT committee_info.id,committee_info.office_code,committee_info.flat_no,committee_info.member_id,committee_info.member_name,committee_info.member_position,committee_info.formation_date,committee_info.mobile_no, office_info.office_name, code_master.description FROM committee_info, office_info, code_master WHERE committee_info.office_code=office_info.office_code and code_master.hardcode='comtp' and code_master.softcode= committee_info.member_position";
            //use for MySQLi-OOP
            $query = $conn->query($sql);
            while ($row = $query->fetch_assoc()) {
              $no++;
              echo
                "<tr>
                       <td>" . $no . "</td>
                       <td>" . $row['office_name'] . "</td>
                       <td>" . $row['member_id'] . "</td>
                       <td>" . $row['member_name'] . "</td>
                       <td>" . $row['description'] . "</td>
                       <td>" . $row['flat_no'] . "</td>
                       <td>" . $row['mobile_no'] . "</td>
                       <td>" . $row['formation_date'] . "</td>
                       <td><a target='_blank' href='committee_info_edit.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                  </td>
								</tr>";
            }
            ?>
          </tbody>
        </table>
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
  $('#memberTable').DataTable();
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#1310000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded')
  });

  $('#flatList').hide();

  // flatAddBtn
  $('#flatAddBtn').on('click', function() {
    $('#flatAdd').show();
    $('#flatList').hide();

  });
  // memberistBtn
  $('#flatListBtn').on('click', function() {
    $('#flatList').show();
    $('#flatAdd').hide();
  });
</script>
<?php
$conn->close();

?>
</body>

</html>