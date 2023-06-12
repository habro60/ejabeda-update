<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['SubBtn'])) {
  $office_code = $_SESSION['office_code'];
  $role_no = $_POST['role_no'];
  $role_name = $_POST['role_name'];
  $active_stat = $_POST['active_stat'];
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertQuery = "INSERT INTO `sm_role` (id, office_code, role_no,role_name, active_stat, ss_creator, ss_created_on, ss_modifier, ss_modified_on, ss_org_no) VALUES (NULL,'$office_code','$role_no','$role_name','$active_stat','$ss_creator','$ss_created_on','$ss_modifier','$ss_modified_on', '$ss_org_no')";
 
  // echo $insertQuery; exit;
  $conn->query($insertQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
    
  }
  header("refresh:1;user_roles.php");
}
require "../source/top.php";
$pid= 106000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-user"></i> User Role Table</h1>
    </div>
  </div>
  <!-- sample  -->
  <button data-toggle="collapse" data-target="#demo" class="btn btn-success float-right"><i class="fa fa-plus" aria-hidden="true"></i>Add User Role</button>
  <br>
  <hr>
  <div id="demo" class="collapse">
    <div style="padding:5px;">
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
      <?php
      if (!empty($message)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "User Create Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
            )
            </script>';
      }
      ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <table class="table table-hover table-bordered table-sm" id="sampleTable">
            <thead>
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
            </thead>
            <tbody>
              <?php     
              $sql = "SELECT * FROM `sm_role`";
              //use for MySQLi-OOP
              $query = $conn->query($sql);
              while ($row = $query->fetch_assoc()) {
                echo
                  "<tr>
									<td>" . $row['id'] . "</td>
									<td>" . $row['role_no'] . "</td>
									<td>" . $row['role_name'] . "</td>
									<td>" . $row['active_stat'] . "</td>
									<td>" . $row['ss_creator'] . "</td>
									<td>" . $row['ss_created_on'] . "</td>
									<td>" . $row['ss_modifier'] . "</td>
									<td>" . $row['ss_modified_on'] . "</td>
                  <td><a target='_blank' href='user_roles_edit.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                  </td>
								</tr>";
                // include('edit_delete_modal.php');
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- sample  -->
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- table  -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#sampleTable').DataTable();
</script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#106000").addClass('active');
    $("#100000").addClass('active');
    $("#100000").addClass('is-expanded');
  });
</script>
</body>

</html>