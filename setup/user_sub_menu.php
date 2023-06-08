<?php
if (isset($_POST['SubBtn'])) {
  require "../database.php";
  $submenu_no = $_POST['submenu_no'];
  $menu_no = $_POST['menu_no'];
  $submenu_name = $_POST['submenu_name'];
  $submenu_obj_name = $_POST['submenu_obj_name'];
  $p_submenu_no = $_POST['p_submenu_no'];
  $is_root = $_POST['is_root'];
  $submenu_type = $_POST['submenu_type'];
  $disp_sl_no = $_POST['disp_sl_no'];
  $can_view = $_POST['can_view'];
  $can_modify = $_POST['can_modify'];
  $can_remove = $_POST['can_remove'];
  $can_create = $_POST['can_create'];
  $active_stat = $_POST['active_stat'];

  $insertQuery = "INSERT INTO `sm_submenu` VALUES (NULL,'$submenu_no','$menu_no','$submenu_name','$submenu_obj_name','$p_submenu_no','$is_root','$submenu_type','$disp_sl_no','$can_view','$can_modify','$can_remove','$can_create','$active_stat','',now(), '', now(),'')";
  $conn->query($insertQuery);
  // echo $insertQuery; exit;
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
  }
  $conn->close();
  header("Location:user_sub_menu.php");
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
      <h1><i class="fa fa-dashboard"></i> User Sub Menu Table</h1>
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
        <!--  part 1  -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Sub Menu No</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="submenu_no" class="form-control" required>
          </div>
          <label class="col-sm-2 col-form-label">Menu No</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <select name="menu_no" class="form-control" required>
              <!---------------------------------------------->
              <?php
              require "../database.php";
              $selectQuery = "SELECT menu_no,menu_name,is_root FROM sm_menu where is_root=1";
              $selectQueryResult =  $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($row = $selectQueryResult->fetch_assoc()) {
                  echo '<option value="' . $row['menu_no'] . '">' . $row['menu_name'] . '</option>';
                }
              }
              ?>
            </select>
            <!------------------------------------------------>
          </div>

          <label class="col-sm-2 col-form-label">Submenu Name</label>
          <label for="" class="col-form-label">:</0label>
          <div class="col">
            <input type="text" name="submenu_name" class="form-control" require>
          </div>
        </div>


        <!-- part 2 -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Sub Menu Obj Name</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="submenu_obj_name" class="form-control">
          </div>
          <label class="col-sm-2 col-form-label">P Sub Menu No</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="p_submenu_no" id="" class="form-control">
          </div>

          <label class="col-sm-2 col-form-label">Is Root</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <label class="form-check-label " style="margin-left: 20px">
              <input type="radio" class="form-check-input" name="is_root" value="1" checked>
              Yes
            </label>

            <label class="form-check-label" style="margin-left: 30px">
              <input type="radio" class="form-check-input" name="is_root" value="0" checked>
              No
            </label>
          </div>
        </div>
        <!-- part 3 -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Submenu Type</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <label class="form-check-label " style="margin-left: 20px">
              <input type="radio" class="form-check-input" name="submenu_type" value="F" checked>
              Form
            </label>
            <label class="form-check-label" style="margin-left: 30px">
              <input type="radio" class="form-check-input" name="submenu_type" value="R" checked>
              Report
            </label>
          </div>
          <label class="col-sm-2 col-form-label">Dis Sl No</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="number" name="disp_sl_no" class="form-control">
          </div>

          <label class="col-sm-2 col-form-label">Can View</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <label class="form-check-label " style="margin-left: 20px">
              <input type="radio" class="form-check-input" name="can_view" value="1" checked>
              Yes
            </label>

            <label class="form-check-label" style="margin-left: 30px">
              <input type="radio" class="form-check-input" name="can_view" value="0" checked>
              No
            </label>
          </div>
        </div>

        <!-- part 4 -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Can Modify</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <label class="form-check-label " style="margin-left: 20px">
              <input type="radio" class="form-check-input" name="can_modify" value="1" checked>
              Yes
            </label>

            <label class="form-check-label" style="margin-left: 30px">
              <input type="radio" class="form-check-input" name="can_modify" value="0" checked>
              No
            </label>
          </div>
          <label class="col-sm-2 col-form-label">Can Remove</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <label class="form-check-label " style="margin-left: 20px">
              <input type="radio" class="form-check-input" name="can_remove" value="1" checked>
              Yes
            </label>

            <label class="form-check-label" style="margin-left: 30px">
              <input type="radio" class="form-check-input" name="can_remove" value="0" checked>
              No
            </label>
          </div>
          <label class="col-sm-2 col-form-label">Can Create</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <label class="form-check-label " style="margin-left: 20px">
              <input type="radio" class="form-check-input" name="can_create" value="1" checked>
              Yes
            </label>

            <label class="form-check-label" style="margin-left: 30px">
              <input type="radio" class="form-check-input" name="can_create" value="0" checked>
              No
            </label>
          </div>
        </div>
        <!-- Name part -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Active Status</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <label class="form-check-label " style="margin-left: 20px">
              <input type="radio" class="form-check-input" name="active_stat" value="1" checked>
              Yes
            </label>

            <label class="form-check-label" style="margin-left: 30px">
              <input type="radio" class="form-check-input" name="active_stat" value="0" checked>
              No
            </label>
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
      <th>submenu_no</th>
      <th>menu_no</th>
      <th>submenu_name</th>
      <th>submenu_obj_name</th>
      <th>is_root</th>
      <th>active_stat</th>
      <th>Action</th>
    </tr>
    <?php
    require "../database.php";
    $selectQuery = "SELECT * FROM `sm_submenu`";
    $selectQueryResult = $conn->query($selectQuery);
    //echo "$selectQueryResult->num_rows";	
    if ($selectQueryResult->num_rows) {

      while ($rows = $selectQueryResult->fetch_array()) {
        echo "<tr>";
        echo "<td>" . $rows['id'] . "</td>";
        echo "<td>" . $rows['submenu_no'] . "</td>";
        echo "<td>" . $rows['menu_no'] . "</td>";
        echo "<td>" . $rows['submenu_name'] . "</td>";
        echo "<td>" . $rows['submenu_obj_name'] . "</td>";
        echo "<td>" . $rows['is_root'] . "</td>";
        echo "<td>" . $rows['active_stat'] . "</td>";
        echo "<td><a href='user_menu_edit.php?recortid=" . $rows['id'] . "' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span> Edit</a>
                    <a href='#delete_" . $rows['id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
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