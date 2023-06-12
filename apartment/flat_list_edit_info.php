<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['editSubmit'])) {
  $id = intval($_GET['id']);
  $office_code = $_SESSION['office_code'];
  // $office_code = $conn->escape_string($_POST['office_code']);
  $flat_no = $conn->escape_string($_POST['flat_no']);
  $flat_area = $conn->escape_string($_POST['flat_area']);
  $side_of_flat = $conn->escape_string($_POST['side_of_flat']);
  $building = $conn->escape_string($_POST['building']);
  $block_no = $conn->escape_string($_POST['block_no']);
  $flat_title = $conn->escape_string($_POST['flat_title']);
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $updateQuery = "UPDATE `flat_info` SET `id`='$id',`office_code`='$office_code',`flat_no`='$flat_no',`flat_area`='$flat_area',`side_of_flat`='$side_of_flat', `building`='$building', block_no='$block_no',flat_title='$flat_title',`ss_modifier`='$ss_modifier',`ss_modified_on`=now(),`ss_org_no`='$ss_org_no' where id='$id'";


  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) {
    $message = "Update Successfully!";
    header('refresh:1;flat_list_info.php');
  } else {
    $mess = "Failled!";
  }
  
}
?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $selectQueryEdit = "SELECT * FROM flat_info where id='$id'";
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
      <h1><i class="fa fa-dashboard"></i> Edit Flat Information </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div>
        <!--  Flat Information -->
        <div id="">
          <div style="padding:5px">
            <!-- form start  -->
            <form action="" method="post">
              <input type="text" class="form-control" id="" value="<?php echo $rows['id']; ?>" name="id" hidden>

              <!-- Flat No  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Flat Number</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="flat_no" value="<?php echo $rows['flat_no']; ?>"readonly>
                </div>
              </div>
              <!-- Flat Area  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Flat Area</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="flat_area" value="<?php echo $rows['flat_area']; ?>">
                </div>
              </div>
              <!-- Side Location of Flat  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Side location of Flat</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="side_of_flat" value="<?php echo $rows['side_of_flat']; ?>">
                </div>
              </div>
              <!-- Building of Flat -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Building Location of Flat</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="building" value="<?php echo $rows['building']; ?>">
                </div>
              </div>
              <!-- block_no of Flat   -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Block of Flat </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="block_no" value="<?php echo $rows['block_no']; ?>">
                </div>
              </div>
               <!-- flat Title   -->
               <div class="form-group row">
                <label class="col-sm-2 col-form-label">Flat/Shope Title </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="flat_title" value="<?php echo $rows['flat_title']; ?>">
                </div>
              </div>



              <!-- submit  -->
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="editSubmit">Submit</button>
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