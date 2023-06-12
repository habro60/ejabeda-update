<?php
require "../auth/auth.php";
require "../database.php";
?>
<?php
//update query
if (isset($_POST['submit'])) {
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
  $ss_org_no= $_SESSION['org_no'];
  
  $insertQuery = "INSERT INTO `sm_menu` (`id`,`office_code`, `menu_no`, `menu_name`, `menu_obj_name`,`menu_type`,`p_menu_no`, `active_stat`,`lavel_no`,`ss_creator`,`ss_created_on`,ss_modifier, ss_modified_on,`ss_org_no`) VALUES (NULL,'$office_code','$menu_no','$menu_name','$menu_obj_name','$menu_type','$p_menu_no','$active_stat','$lavel_no','$ss_creator','$ss_created_on','$ss_modifier', '$ss_modified_on','$ss_org_no')";

  $conn->query($insertQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
  }
  header("refresh:2;user_menu.php");
}
if (isset($_GET['id'])) {
  $selectQuery = "select * from sm_menu where id='" . $_GET['id'] . "'";
  $selectQueryReuslt = $conn->query($selectQuery);
  $row = $selectQueryReuslt->fetch_assoc();
}
?>
<!-- new  -->
<?php
$query = "Select Max(menu_no) From sm_menu where id= $_GET[id]";
$returnD = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($returnD);
$maxRows = $result['Max(menu_no)'];
$selectQuery = "SELECT * FROM `sm_menu`";
$selectQueryResult = $conn->query($selectQuery);
if ($selectQueryResult->num_rows) {
  while ($rowss = $selectQueryResult->fetch_array()) {
?>
    <?php
    if ($_GET['id'] != $rowss['p_menu_no']) {
      if ($row['lavel_no'] == 1) {
        if (empty($row['menu_no'])) {
          $lastRow = $row['menu_no'] + 1000;
        } else {
          $lastRow = $maxRows + 1000;
        }
      } elseif ($row['lavel_no'] == 2) {
        if (empty($row['menu_no'])) {
          $lastRow = $row['menu_no'] + 10;
        } else {
          $lastRow = $maxRows + 10;
        }
      } elseif ($row['lavel_no'] == 3) {
        if (empty($row['menu_no'])) {
          $lastRow = $row['menu_no'] + 1;
        } else {
          $lastRow = $maxRows + 1;
        }
      }
    } else {
      $query = "Select Max(menu_no) From sm_menu where $_GET[id]=p_menu_no";
      $returnD = mysqli_query($conn, $query);
      $result = mysqli_fetch_assoc($returnD);
      $maxRows = $result['Max(menu_no)'];
      if ($row['lavel_no'] == 1) {
        $lastRow = $maxRows + 1000;
      } elseif ($row['lavel_no'] == 2) {
        $lastRow = $maxRows + 10;
      } elseif ($row['lavel_no'] == 3) {
        $lastRow = $maxRows + 1;
      }
    }

    ?>
<?php
  }
}
?>
<!-- new end  -->
<?php
$maxRows1 = $row['lavel_no'];
if (empty($maxRows1)) {
  $lastRows = $maxRows1 = 1;
} else {
  $lastRows = $maxRows1 + 1;
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
      <h1><i class="fa fa-dashboard"></i> <?php echo $row['menu_no']; ?> <?php echo $row['menu_name']; ?></h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <form action="" method="post">
        <div class="form-row">
          <div class="form-group col-md-2">
            <label>Menu No</label>
            <input type="text" name="menu_no" readonly class="form-control" required autofocus placeholder="ID" value=<?php echo $lastRow; ?>>
          </div>
          <div class="form-group col-md-3">
            <label>Sub Menu Name</label>
            <input type="text" name="menu_name" id="" class="form-control">
          </div>
          <div class="form-group col-md-3">
            <label>URL</label>
            <input type="text" class="form-control" name="menu_obj_name">
          </div>
          <div class="form-group col-md-2">
            <label>Sub Menu Type</label>
            <select name="menu_type" id="" class="form-control">
              <option value="">Select</option>
              <option value="1">Form</option>
              <option value="0">Report</option>
            </select>
          </div>
          <!-- hidden -->
          <input type="number" class="form-control" name="p_menu_no" value="<?php echo $row['id']; ?>" hidden>
          <input type="text" name="lavel_no" class="form-control" required autofocus placeholder="ID" value=<?php if (!empty($lastRows)) {
                                                                                                              echo $lastRows;
                                                                                                            } ?> hidden>
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
        <input type="submit" value="Submit" class=" btn btn-primary form-control text-center" name="submit">
      </form>
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
</main>
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
    $("#202000").addClass('active');
    $("#200000").addClass('active');
    $("#200000").addClass('is-expanded');

  });
</script>
<?php
$conn->close();
?>
</body>

</html>