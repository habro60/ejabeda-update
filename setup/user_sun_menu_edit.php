<?php
require "../database.php";
//update query
if (isset($_POST['submit'])) {
  $menu_no = $_POST['menu_no'];
  $menu_name = $_POST['menu_name'];
  $is_root = $_POST['is_root'];
  $menu_obj_name = $_POST['menu_obj_name'];
  $menu_type = $_POST['menu_type'];
  $active_stat = $_POST['active_stat'];

  $ss_creator = $_POST['ss_creator'];
  $ss_created_on = date("Y-m-d H:i:s");
  $ss_modifier = $_POST['ss_modifier'];
  $ss_modified_on = date("Y-m-d H:i:s");
  $ss_org_no=$_POST['ss_org_no'];
  $disp_sl_no=$_POST['disp_sl_no'];


  $idno = $_GET['recortid'];
  $updateQuery = "UPDATE `sm_menu` SET menu_no='$menu_no', menu_name='$menu_name', is_root='$is_root',menu_obj_name='$menu_obj_name', menu_type='$menu_type',active_stat='$active_stat', ss_creator='$ss_creator',ss_created_on='$ss_created_on',ss_modifier='$ss_modifier', ss_modified_on='$ss_modified_on', ss_org_no='$ss_org_no', disp_sl_no='$disp_sl_no' WHERE id = '$idno'";
  // echo $updateQuery; exit;
  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) { 
    // $message = "Update Successfully";
  }
}
//select query start
if (isset($_GET['recortid'])) {
  $idno = $_GET['recortid'];
  $selectQuery = "SELECT * FROM `sm_menu` WHERE id=$idno";
  // echo $selectQuery; exit;
  $selectQueryResult = $conn->query($selectQuery);
  //if($selectQueryResult->num_rows){		
  $row = $selectQueryResult->fetch_array();
  //}
}
$conn->close();
?>
<?php
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Menu Edit</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
    <!-- <?php if (isset($message)) echo $message; ?> -->

      <input type="hidden" name="recid" value="<?php echo $row['id']; ?>"/>
      <form role="form" action="" method="post">

        <!-- mamber part  -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Menu No</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="menu_no" class="form-control" value="<?php echo $row['menu_no']; ?>">
          </div>
          <label class="col-sm-2 col-form-label">Menu Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="menu_name" class="form-control" value="<?php echo $row['menu_name']; ?>">
          </div>

          <label class="col-sm-2 col-form-label">Is Root</label>
          <label class="col-form-label" style="margin-right: 40px">:</label>
          <div class="col">
            <label class="form-check-label " style="margin-right: 40px">
              <input type="radio" class="form-check-input" name="is_root" value="1" <?php if ($row['is_root'] == 1) {echo "checked";} ?>>
              Yes
            </label>

            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="is_root" value="0" <?php if ($row['is_root'] == 0) {echo "checked";} ?>>
              No
            </label>
          </div>
        </div>
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">menu_obj_name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="menu_obj_name" class="form-control" value="<?php echo $row['menu_obj_name']; ?>">
          </div>
          <label class="col-sm-2 col-form-label">Menu type</label>
          <label class="col-form-label" style="margin-right: 40px">:</label>
          <div class="col">
            <label class="form-check-label " style="margin-right: 40px">
              <input type="radio" class="form-check-input" name="menu_type" value="1" <?php if ($row['menu_type'] == 1) {echo "checked";} ?>>
              Form
            </label>

            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="menu_type" value="0" <?php if ($row['menu_type'] == 0) {echo "checked";} ?>>
              Report
            </label>
          </div>


          <label class="col-sm-2 col-form-label">Active Status</label>
          <label class="col-form-label" style="margin-right: 40px">:</label>
          <div class="col">
            <label class="form-check-label " style="margin-right: 40px">
              <input type="radio" class="form-check-input" name="active_stat" value="1" <?php if ($row['active_stat'] == 1) {echo "checked";} ?>>
              Active
            </label>

            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="active_stat" value="0" <?php if ($row['active_stat'] == 0) {echo "checked";} ?>>
              In-Active
            </label>
          </div>
         

            <!----------------------- currency type End --------------------->
            <!-- extra  -->

            <input type="hidden" name="ss_creator">
            <input type="hidden" name="ss_modifier">
            <input type="hidden" name="ss_org_no">
            <input type="hidden" name="disp_sl_no">

            <!------------------------------------------------------------------>
            <input name="submit" type="submit" value="Update" class=" btn btn-primary form-control text-center" />
      </form>
      <!-- -------------------------------->
    </div>
  </div>
</main>
<!-- Essential javascripts for application to work-->
<script src="../s/jquery-3.2.1.min.js"></script>
<script src="../s/popper.min.js"></script>
<script src="../s/bootstrap.min.js"></script>
<script src="../s/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>

<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#common").addClass('active');
    $("#regform").addClass('active');
  });
</script>

</body>

</html>