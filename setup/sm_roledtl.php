<?php
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> SM Role DTL</h1>
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
      <form action="../menu_role/form.php" method="post">
        <!--  part 1  -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Branch Code</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="branch_code" class="form-control" required>
          </div>
          <label class="col-sm-2 col-form-label">Role No</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <select name="role_no" class="form-control" required>
              <!---------------------------------------------->
              <?php
              require "../database.php";
              $selectQuery = "SELECT role_no,role_name,active_stat FROM sm_role where active_stat=1";
              $selectQueryResult =  $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($row = $selectQueryResult->fetch_assoc()) {
                  echo '<option value="' . $row['role_no'] . '">' . $row['role_name'] . '</option>';
                }
              }
              ?>
            </select>
          </div>
          <label class="col-sm-2 col-form-label">Menu No</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <select name="menu_no" class="form-control" required>
              <option value="" selected="selected">----Select Menu---</option>
              <!---------------------------------------------->
              <?php
              require "../database.php";
              $selectQuery = "SELECT menu_no, menu_name, is_root FROM sm_menu WHERE is_root=1";
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
        </div>
        <!-- ---------------------------------------------- -->
        
        <table class="table table-hover border border-dark ">
    <tr>
      <th>Sub MEnu Np</th>
      <th>menu_no</th>
      <th>Sub MEnu Name</th>
      <th>Sub Menu Object</th>
     
      <th>Action</th>
    </tr>
    <?php
    require "../database.php";
    $selectQuery = "SELECT * FROM `sm_submenu` where menu_no= menu_no ";
    $selectQueryResult = $conn->query($selectQuery);
    //echo "$selectQueryResult->num_rows";	
    if ($selectQueryResult->num_rows) {

      while ($rows = $selectQueryResult->fetch_array()) {
        echo "<tr>";
        echo "<td>" . $rows['submenu_no'] . "</td>";
        echo "<td>" . $rows['menu_no'] . "</td>";
        echo "<td>" . $rows['submenu_name'] . "</td>";
        echo "<td>" . $rows['submenu_obj_name'] . "</td>";
        echo "<td>  <button class='btn'>Add</button> </td>";
      }
    }

    ?>
  </table>
        <!-- -------  -->
        <!-- part 2 -->
        <!-- <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Sub Menu No</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="submenu_no" class="form-control">
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
        </div>
        


        <div class="form-row form-group">
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
        </div> -->
        <!-- ------------------------------------------------------------ -->
        <input type="submit" value="Submit" class=" btn btn-primary form-control text-center" name="SubBtn">
      </form>
      <!-- -------------------------------->
    </div>
  </div>
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../script plugin to display page loading on top-->

<script src="../js/plugins/pace.min.js"></script>
<!-- get sub menu  -->
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