<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['submit'])) {

  $office_code = $conn->escape_string($_SESSION['office_code']);
  $flat_no = $conn->escape_string($_POST['flat_no']);
  $flat_area = $conn->escape_string($_POST['flat_area']);
  $side_of_flat = $conn->escape_string($_POST['side_of_flat']);
  $building = $conn->escape_string($_POST['building']);
  $block_no = $conn->escape_string($_POST['block_no']);
  $flat_title = $conn->escape_string($_POST['flat_title']);
  // $flat_status = $conn->escape_string($_POST['flat_status']);
  // $status_date = $conn->escape_string($_POST['status_date']);
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertData = "INSERT INTO flat_info (office_code, flat_no, flat_area,side_of_flat, building, `block_no`,flat_title,billing_gl_code,flat_status, status_date,ss_creator,ss_created_on,ss_modifier,ss_modified_on,ss_org_no) values ('$office_code','$flat_no','$flat_area','$side_of_flat','$building','$block_no','$flat_title','0','0',now(), '$ss_creator','$ss_created_on','$ss_creator','$ss_created_on','$ss_org_no')";
  $conn->query($insertData);

  echo $insertData;
  exit;

  if ($conn->affected_rows == 1) {
    $message = "Save owner Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:1;flat_list_info.php');
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
      <h1><i class="fa fa-dashboard"></i> Flat/Shop Information </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>


    <!-- ===== button define ====== -->
    <div>
      <button id="flatAddBtn" class="btn btn-success"><i class="fa fa-plus"></i>Add Flat/Shop Information</button>
      <button id="flatListBtn" class="btn btn-primary"><i class="fa fa-eye"></i>View and Edit Flat/Shop List </button>
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
                        Add Flat/Shop Information
                      </div>
                      <div class="card-body">
                        <!---=====Flat No.======-->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Flat/Shop Number</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="flat_no">
                          </div>
                        </div>
                        <!---======Flat area =======-->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Flat/Shop Area</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="flat_area">
                          </div>
                        </div>
                        <!---====== Flat Side Location =====--->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Side Location of Flat/Shop</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="side_of_flat">
                          </div>
                        </div>
                        <!--====== Building Location of Flat =======--->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Building Location of Flat/Shop</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="building">
                          </div>
                        </div>
                        <!-- ====== block_no of a Flat =======-->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Flat/Shop in a Block</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="block_no" required>
                          </div>
                        </div>
                        <!-- ====== Flat Title =======-->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Flat/Shop Title</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="flat_title" required>
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
        <h5 style="text-align: center">Flat/Shop List </h5>
        <!-- General Account View start -->
        <table class="table table-hover table-bordered" id="memberTable">
          <thead>
            <tr>
              <th>Sl.No.</th>
              <th>Office</th>
              <th>Flat/Shop Number</th>
              <th>Flat/Shop Area</th>
              <th>Side Location</th>
              <th>Building Location</th>
              <th> Block</Th>
              <th> Flat/Shop Title</Th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $sql = "SELECT flat_info.id,flat_info.office_code,flat_info.flat_no,flat_info.flat_area,flat_info.side_of_flat,flat_info.building,flat_info.block_no,flat_info.flat_title,office_info.office_name FROM flat_info, office_info WHERE flat_info.office_code=office_info.office_code";
            //use for MySQLi-OOP
            $query = $conn->query($sql);
            while ($row = $query->fetch_assoc()) {
              $no++;
              echo
                "<tr>
                       <td>" . $no . "</td>
                       <td>" . $row['office_name'] . "</td>
                       <td>" . $row['flat_no'] . "</td>
                       <td>" . $row['flat_area'] . "</td>
                       <td>" . $row['side_of_flat'] . "</td>
                       <td>" . $row['building'] . "</td>
                       <td>" . $row['block_no'] . "</td>
                       <td>" . $row['flat_title'] . "</td>
                       <td><a target='_blank' href='flat_list_edit_info.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>



                       <a target='_blank' href='apartment_setup.php?id=" . $row['id'] . "' class='btn btn-info btn-sm mt-1'><span class='fa fa-plus'></span>Setup</a>


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