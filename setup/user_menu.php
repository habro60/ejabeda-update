<?php
require "../database.php";
?>
<?php
if (isset($_POST['SubBtn'])) {
  $menu_no = $_POST['menu_no'];
  $menu_name = $_POST['menu_name'];
  $menu_obj_name = $_POST['menu_obj_name'];
  $menu_type = $_POST['menu_type'];
  $p_menu_no = $_POST['p_menu_no'];
  $active_stat = $_POST['active_stat'];
  $lavel_no = $_POST['lavel_no'];

  $insertQuery = "INSERT INTO `sm_menu` (`id`, `menu_no`, `menu_name`, `menu_obj_name`,`menu_type`,`p_menu_no`, `active_stat`,`lavel_no`,`ss_created_on`) VALUES (NULL,'$menu_no','$menu_name','$menu_obj_name','$menu_type','$p_menu_no','$active_stat','$lavel_no',now())";


  $conn->query($insertQuery);
  // echo $insertQuery; exit;
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
  }
 
  header("Location:user_menu.php");
}
?>
<?php
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<?php
$query = "Select Max(menu_no) From sm_menu where lavel_no=1";
$returnD = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($returnD);
$demo=$result['max(menu_no)'];
$maxRows = $result['Max(menu_no)'];
if (empty($maxRows)) {
  $lastRow = $maxRows=100000;
} else {
  $lastRow = $maxRows + 100000;
}

?>

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> User Menu Table</h1>
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
        <div class="form-row">
    <div class="form-group col-md-2">
      <label>Menu No</label>
      <input type="text" name="menu_no" readonly class="form-control" required autofocus placeholder="ID" value=<?php if (!empty($lastRow)) {echo $lastRow;} ?>>
      
    </div>
    <div class="form-group col-md-3">
      <label>Menu Name</label>
      <input type="text" name="menu_name" id="" class="form-control">
    </div>
    <div class="form-group col-md-3">
      <label>URL</label>
      <input type="text" class="form-control" name="menu_obj_name">
    </div>
    <div class="form-group col-md-2">
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

    <div class="form-group col-md-2">
      <label>Active Status</label>
      <select name="active_stat" id="" class="form-control">
        <option value="">Select</option>
        <option value="1">Yes</option>
        <option value="0">No</option>
      </select>
    </div>
  
  </div>

        <!-- ------------------------------------------------------------ -->
        <input type="submit" value="Submit" class=" btn btn-primary form-control text-center" name="SubBtn">
      </form>
      <!-- -------------------------------->
    </div>
  </div>
  <!-- view -->
  <table class="table table-hover table-bordered table-responsive">
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
    <?php
    $selectQuery = "SELECT * FROM `sm_menu` ORDER by menu_no";
    $selectQueryResult = $conn->query($selectQuery);
    //echo "$selectQueryResult->num_rows";	
    if ($selectQueryResult->num_rows) {

      while ($rows = $selectQueryResult->fetch_array()) {
        echo "<tr>";
        echo "<td>" . $rows['id'] . "</td>";
        echo "<td>" . $rows['menu_no'] . "</td>";
        echo "<td>" . $rows['menu_name'] . "</td>";
        echo "<td>" . $rows['menu_obj_name'] . "</td>";
        echo "<td>" . $rows['menu_type'] . "</td>";
        echo "<td>" . $rows['p_menu_no'] . "</td>";
        echo "<td>" . $rows['lavel_no'] . "</td>";
        echo "<td>" . $rows['active_stat'] . "</td>";
        echo "<td><a id='' href='user_menu_add.php?id=" . $rows['id'] . "' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-edit'></span> Add Submenu</a>
        <a href='user_menu_edit.php?recortid=" . $rows['id'] . "' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-edit'></span> Edit</a>
        <a href='#delete_" . $rows['id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
        
                  </td>";
              include('edit_delete_modal.php');                  
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
    $("#setup").addClass('active');
    $("#usermenu").addClass('active');
    $("#setup").addClass('is-expanded');

  });
</script>
<?php
 $conn->close();
 ?>
</body>

</html>