<?php
if (isset($_POST['SubBtn'])) {
  require "../database.php";
  $role_no = $_POST['role_no'];
  $role_name = $_POST['role_name'];
  $active_stat = $_POST['active_stat'];

  $insertQuery = "INSERT INTO `sm_role` VALUES (NULL,'$role_no','$role_name','$active_stat','',now(), '', now())";
  $conn->query($insertQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
  }
  $conn->close();
  header("Location:user_roles_add.php");
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
      <h1><i class="fa fa-dashboard"></i> User Role Table</h1>
    </div>
    <!-- <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Blank Page</a></li>
    </ul> -->
  </div>
  <!-- sample  -->

  <div class="row">
    <div class="col-md-12">
      <!-- -------------------------------->
      <?php if (isset($message)) echo $message; ?>
      <form action="" method="post">
        <!-- mamber part  -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">ROLE_NO</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="number" name="role_no" class="form-control">
          </div>
          <label class="col-sm-2 col-form-label">ROLE_NAME</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="role_name" id="" class="form-control">
          </div>

          <label class="col-sm-2 col-form-label">Active Status</label>
          <label for="" class="col-form-label" style="margin-right: 40px">:</label>
          <div class="col">
            <label class="form-check-label " style="margin-right: 40px">
              <input type="radio" class="form-check-input" name="active_stat" id="optionsRadios1" value="1" checked>
              Active
            </label>

            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="active_stat" id="optionsRadios1" value="0" checked>
              In-Active
            </label>
          </div>
          <!-- Name part -->
          <div class="form-row form-group">

          </div>

        </div>

        <!-- ------------------------------------------------------------ -->
        <input type="submit" value="Submit" id="register" class=" btn btn-primary form-control text-center" name="SubBtn">
      </form>
      <!-- -------------------------------->
    </div>
  </div>
  <!-- view -->
  <table class="table table-hover table-bordered table-responsive">
    <tr>
      <th>ID</th>
      <th>Role No</th>
      <th>Role Name</th>
      <th>Active Status</th>
      <th>Creator</th>
      <th>Creatated Date</th>
      <th>Modifier</th>
      <th>Modifier Date Date</th>
      <th>Action</th>
    </tr>
    <?php
    require "../database.php";
    $selectQuery = "SELECT * FROM `sm_role`";
    $selectQueryResult = $conn->query($selectQuery);
    //echo "$selectQueryResult->num_rows";	
    if ($selectQueryResult->num_rows) {

      while ($rows = $selectQueryResult->fetch_array()) {
        echo "<tr>";
        echo "<td>" . $rows['id'] . "</td>";
        echo "<td>" . $rows['role_no'] . "</td>";
        echo "<td>" . $rows['role_name'] . "</td>";
        echo "<td>" . $rows['active_stat'] . "</td>";
        echo "<td>" . $rows['ss_creator'] . "</td>";
        echo "<td>" . $rows['ss_created_on'] . "</td>";
        echo "<td>" . $rows['ss_modifier'] . "</td>";
        echo "<td>" . $rows['ss_modified_on'] . "</td>";
        echo "<td><a href='user_roles_edit.php?recortid=".$rows['id']."' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span> Edit</a>
                    <a href='#delete_".$rows['id']."' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
									</td>";
      }
    }

    ?>
  </table>
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jquesr_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#common").addClass('active');
    $("#regform").addClass('active');
    $("#common").addClass('is-expanded');

  });
</script>

</body>

</html>