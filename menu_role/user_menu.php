<?php
require "../auth/auth.php";
require "../database.php";
?>
<?php
if (isset($_POST['SubBtn'])) {
  $office_code = $_SESSION['office_code'];
  $menu_no = $_POST['menu_no'];
  $menu_name = $_POST['menu_name'];
  $menu_obj_name = $_POST['menu_obj_name'];
  $menu_type = $_POST['menu_type'];
  $p_menu_no = $_POST['p_menu_no'];
  $active_stat = $_POST['active_stat'];
  $lavel_no = $_POST['lavel_no'];
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertQuery = "INSERT INTO `sm_menu` (`id`,`office_code`, `menu_no`, `menu_name`, `menu_obj_name`,`menu_type`,`p_menu_no`, `active_stat`,`lavel_no`,`ss_creator`,`ss_created_on`,`ss_org_no`) VALUES (NULL,'$office_code','$menu_no','$menu_name','$menu_obj_name','$menu_type','$p_menu_no','$active_stat','$lavel_no','$ss_creator',now(),'$ss_org_no')";
  
  // echo $insertQuery;
  // exit;
     $conn->query($insertQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
  }

  header("refresh:1;user_menu.php");
}
?>
<?php
require "../source/top.php";
$pid= 108000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<?php
$query = "Select Max(menu_no) From sm_menu where lavel_no=1";
$returnD = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($returnD);
$maxRows = $result['Max(menu_no)'];
if (empty($maxRows)) {
  $lastRow = 100000;
} else {
  $lastRow = $maxRows + 100000;
}

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-navicon"></i> User Menu Table</h1>
    </div>

    <!-- <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Blank Page</a></li>
    </ul> -->
  </div>
  <!-- sample  -->
  <div class="row">
    <div class="col-md-12">
      <!-- collapse -->
      <button data-toggle="collapse" data-target="#demo" class="btn btn-success float-right"><i class="fa fa-plus" aria-hidden="true"></i>Main Menu Open</button>
      <br>
      <hr>
      <div id="demo" class="collapse">
        <div style="padding:5px;">

          <form action="" method="post">
            <!-- mamber part  -->
            <div class="form-row">
              <div class="form-group col-md-2">
                <label>Menu No</label>
                <input type="text" name="menu_no" readonly class="form-control" required autofocus placeholder="ID" value=<?php if (!empty($lastRow)) {
                                                                                                                            echo $lastRow;
                                                                                                                          } ?>>

              </div>
              <div class="form-group col-md-3">
                <label>Menu Name</label>
                <input type="text" name="menu_name" id="" class="form-control">
              </div>
              <div class="form-group col-md-3">
                <label>URL</label>
                <input type="text" class="form-control" name="menu_obj_name">
              </div>
              <div class="form-group col-md-1">
                <label>Menu Type</label>
                <select name="menu_type" id="" class="form-control">
                  <option value="">Select</option>
                  <option value="1">Form</option>
                  <option value="0">Report</option>
                </select>
              </div>
              <!-- hidden -->
              <input type="number" class="form-control" name="p_menu_no" value="0" hidden>
              <input type="text" name="lavel_no" class="form-control" required autofocus placeholder="ID" value="1" hidden>

              <div class="form-group col-md-1">
                <label>Active Status</label>
                <select name="active_stat" id="" class="form-control">
                  <option value="">Select</option>
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>

              </div>
              <div class="form-group col-md-2">
                <label>Active Status</label>
                <input type="submit" value="Submit" class=" btn btn-primary form-control text-center" name="SubBtn">
              </div>
            </div>
          </form>
          <hr>
          <?php
          if (!empty($message)) {
            echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
            )
            </script>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <!-- menu table  -->
  <div class="tile">
    <div class="tile-body">
      <table class="table table-hover table-bordered table-sm" id="sampleTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>menu_no</th>
            <th>menu_name</th>
            <th>menu_obj_name</th>
            <th>Menu Type</th>
            <th>P_Menu_ID</th>
            <th>lavel</th>
            <th>active_stat</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM `sm_menu`";
          $query = $conn->query($sql);
          while ($rows = $query->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $rows['id'] . "</td>";
            echo "<td>" . $rows['menu_no'] . "</td>";
            echo "<td>" . $rows['menu_name'] . "</td>";
            echo "<td>" . $rows['menu_obj_name'] . "</td>";
            echo "<td>" . $rows['menu_type'] . "</td>";
            echo "<td>" . $rows['p_menu_no'] . "</td>";
            echo "<td>" . $rows['lavel_no'] . "</td>";
            echo "<td>" . $rows['active_stat'] . "</td>";
          ?>
            <td><a <?php if ($rows['lavel_no'] != 1) {
                      echo "onclick='return false";
                    } ?> <?php echo "href='user_menu_add.php?id=" . $rows['id'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span></a>
              <a <?php echo "href='user_menu_edit.php?recortid=" . $rows['id'] . "'"; ?> class='btn btn-success btn-sm'><span class='fa fa-edit'></span></a>
              <a <?php echo "href='#delete_" . $rows['id'] . "'"; ?> class='btn btn-danger btn-sm' data-toggle='modal'><span class='fa fa-trash'></span></a>
            </td>
          <?php
            include('edit_delete_modal.php');
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- menu table end  -->
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- Data table plugin-->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#sampleTable').DataTable();
  $(document).ready(function() {
    $("#108000").addClass('active');
    $("#100000").addClass('active');
    $("#100000").addClass('is-expanded');
  });
</script>
</body>

</html>