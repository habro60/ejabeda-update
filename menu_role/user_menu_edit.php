<?php
require "../auth/auth.php";
require "../database.php";
//update query
if (isset($_POST['submit'])) {
  $menu_no = $_POST['menu_no'];
  $menu_name = $_POST['menu_name'];
  $menu_obj_name = $_POST['menu_obj_name'];
  $menu_type = $_POST['menu_type'];
  $p_menu_no = $_POST['p_menu_no'];
  $active_stat = $_POST['active_stat'];
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
  

  $idno = $_GET['recortid'];
  $updateQuery = "UPDATE `sm_menu` SET menu_no='$menu_no', menu_name='$menu_name', menu_obj_name='$menu_obj_name', menu_type='$menu_type',p_menu_no='$p_menu_no',active_stat='$active_stat', ss_modifier='$ss_modifier', ss_modified_on='$ss_modified_on' WHERE id = '$idno'";
  // echo $updateQuery; exit;
  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) { 
    $message = "Update Successfully";
  } else {
     $mess = "Update Failed";
    
    }
  
  
  
  header("Location:user_menu.php");
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
    <?php if (isset($message)) echo $message; ?>

      <input type="hidden" name="recid" value="<?php echo $row['id']; ?>"/>
      <form role="form" action="" method="post">
      <div class="form-row">
    <div class="form-group col-md-2">
      <label>Sub Menu No</label>
      <input type="text" class="form-control" name="menu_no" value="<?php echo $row['menu_no']; ?>">
    </div>
    <div class="form-group col-md-3">
      <label>Sub Menu Name</label>
      <input type="text" name="menu_name" id="" class="form-control" value="<?php echo $row['menu_name']; ?>">
    </div>
    <div class="form-group col-md-3">
      <label>URL</label>
      <input type="text" class="form-control" name="menu_obj_name" value="<?php echo $row['menu_obj_name']; ?>">
    </div>
    <div class="form-group col-md-2">
      <label>Sub Menu Type</label>
      <select name="menu_type" id="" class="form-control">
       
        <option value="1"<?php if($row['menu_type']==1)echo 'selected="selected"';?>>Form</option>
        <option value="0"<?php if($row['menu_type']==0)echo 'selected="selected"';?>>Report</option>
      </select>
    </div>
     <!-- hidden -->
     <input type="number" class="form-control" name="p_menu_no" value="<?php echo $row['p_menu_no']; ?>" hidden>

    <div class="form-group col-md-2">
      <label>Active Status</label>
      <select name="active_stat" id="" class="form-control">
        <option value="1"<?php if($row['active_stat']==1)echo 'selected="selected"';?>>Yes</option>
        <option value="0"<?php if($row['active_stat']==0)echo 'selected="selected"';?>>No</option>
      </select>
    </div>
  
  </div>
         <!------------------------------------------------------------------>
            <input name="submit" type="submit" value="Update" class=" btn btn-primary form-control text-center" />
      </form>
      <!-- -------------------------------->
    </div>
  </div>
</main>
       <?php
          if (!empty($message)) {
            echo '<script type="text/javascript">
            Swal.fire(
                "Update Successfully!!",
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
              title: "Update Failed...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
          } else {
          }
          ?>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>


<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
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