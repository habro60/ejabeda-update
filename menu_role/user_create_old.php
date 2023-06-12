<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
$pid = 501000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require '../source/sidebar.php';
require '../source/header.php';
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> User Create</h1>
    </div>
  </div>
  <table>
    <form method="POST">
      <tr>
        <td>
          <select name="user_group" class="form-control select2" style="width: 200px" required>
            <option value="">-Select User Group-</option>
            <?php
            $selectQuery = 'SELECT * FROM `code_master` where hardcode="USERG" AND softcode>0';
            $selectQueryResult = $conn->query($selectQuery);
            if ($selectQueryResult->num_rows) {
              while ($row = $selectQueryResult->fetch_assoc()) {
            ?>
            <?php
                echo '<option value="' . $row['softcode'] . '">' . $row['description'] . '</option>';
              }
            }
            ?>
          </select>
        </td>
        <td><input type="submit" name="submit" value="submit" class="form-control btn-info"></td>
      </tr>
    </form>
  </table>
  <?php
  if (isset($_POST['submit'])) {
    $user_group = $_POST['user_group'];
    // echo $user_group;
    // exit;
    if ($user_group == '0100') {
  ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
          <th>Office Code</th>
            <th>Employee No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT sm_hr_emp.emp_no, sm_hr_emp.office_code,sm_hr_emp.f_name, sm_hr_emp.l_name, employee_image, office_info.office_name FROM `sm_hr_emp`, office_info WHERE sm_hr_emp.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            echo '<td>' . $row['emp_no'] . '</td>';
            echo '<td>' . $row['f_name'] . '</td>';
            echo '<td>' . $row['l_name'] . '</td>';
            echo '<td> <a  type="button" class="btn btn-xs btn-warning"  href="user_password_change_emp.php?id=' . $row['emp_no'] . '&&user_group=' . $user_group . '&&name=' . str_replace(' ', '', $row['f_name']) . '&&image=' . $row['employee_image'] . '&&offi=' . $row['office_code'] . '"> Create User </a></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '0200') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>Office Code</th>
            <th>Customer Id</th>
            <th>Customer Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT cust_info.`id`,cust_info.`office_code`,cust_info.`cust_name`,cust_info.`image`, office_info.office_name FROM `cust_info` , `office_info` WHERE cust_info.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['cust_name'] . '</td>';
            echo '<td> <a  type="button" class="btn btn-xs btn-warning"  href="user_password_change.php?id=' . $row['id'] . '&&user_group=' . $user_group . '&&name=' . str_replace(' ', '', $row['cust_name']) . '&&image=' . $row['image'] . '&&offi=' . $row['office_code'] . '"> Create User </a></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '0300') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>Office Code</th>
            <th>Supplier Id</th>
            <th>Supplier Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT supp_info.`id`, supp_info.`office_code`, supp_info.`supp_name`, supp_info.`image`, office_info.office_name FROM `supp_info`, `office_info` WHERE supp_info.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['supp_name'] . '</td>';
            echo '<td> <a  type="button" class="btn btn-xs btn-warning"  href="user_password_change.php?id=' . $row['id'] . '&&user_group=' . $user_group . '&&name=' . str_replace(' ', '', $row['supp_name']) . '&&image=' . $row['image'] . '&&offi=' . $row['office_code'] . '"> Create User </a></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '0400') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
          <th>Office Code</th>
            <th>Member No</th>
            <th>Full Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT fund_member.office_code, fund_member.`member_id`, fund_member.`full_name`, office_info.office_name FROM `fund_member`, `office_info` WHERE fund_member.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            echo '<td>' . $row['member_id'] . '</td>';
            echo '<td>' . $row['full_name'] . '</td>';
            echo '<td> <a  type="button" class="btn btn-xs btn-warning"  href="user_password_change.php?id=' . $row['member_id'] . '&&user_group=' . $user_group . '&&name=' . str_replace(' ', '', $row['full_name']) . '&&offi=' . $row['office_code'] . '"> Create User </a></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '0500') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
          <th>Office Code</th>
            <th>Employee No</th>
             <th>First Name</th>
            <th>Last Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT sm_hr_emp.emp_no, sm_hr_emp.office_code,sm_hr_emp.f_name, sm_hr_emp.l_name, employee_image, office_info.office_name FROM `sm_hr_emp`, office_info WHERE sm_hr_emp.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            echo '<td>' . $row['emp_no'] . '</td>';
            echo '<td>' . $row['f_name'] . '</td>';
            echo '<td>' . $row['l_name'] . '</td>';
            echo '<td> <a  type="button" class="btn btn-xs btn-warning"  href="user_password_change.php?emp_no=' . $row['emp_no'] . '"> Create User </a></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '0600') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
           <th>Office Code</th>
            <th>Employee No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT sm_hr_emp.emp_no, sm_hr_emp.office_code,sm_hr_emp.f_name, sm_hr_emp.l_name, employee_image, office_info.office_name FROM `sm_hr_emp`, office_info WHERE sm_hr_emp.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            echo '<td>' . $row['emp_no'] . '</td>';
            echo '<td>' . $row['f_name'] . '</td>';
            echo '<td>' . $row['l_name'] . '</td>';
            echo '<td> <a  type="button" class="btn btn-xs btn-warning"  href="user_password_change.php?emp_no=' . $row['emp_no'] . '"> Create User </a></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '0800') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
          <th>Office Code</th>
            <th>Owner ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT apart_owner_info.office_code, apart_owner_info.`owner_id`, apart_owner_info.`owner_name`, office_info.office_name FROM `apart_owner_info`, `office_info` WHERE apart_owner_info.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            echo '<td>' . $row['owner_id'] . '</td>';
            echo '<td>' . $row['owner_name'] . '</td>';
            echo '<td> <a  type="button" class="btn btn-xs btn-warning"  href="user_password_change.php?id=' . $row['owner_id'] . '&&user_group=' . $user_group . '&&name=' . str_replace(' ', '', $row['owner_name']) . '&&offi=' . $row['office_code'] . '"> Create User </a></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } else {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
          <th>Office Code</th>
            <th>Employee No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT sm_hr_emp.emp_no, sm_hr_emp.office_code,sm_hr_emp.f_name, sm_hr_emp.l_name, employee_image, office_info.office_name FROM `sm_hr_emp`, office_info WHERE sm_hr_emp.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            echo '<td>' . $row['emp_no'] . '</td>';
            echo '<td>' . $row['f_name'] . '</td>';
            echo '<td>' . $row['l_name'] . '</td>';
            echo '<td> <a  type="button" class="btn btn-xs btn-warning"  href="user_password_change.php?emp_no=' . $row['emp_no'] . '"> Create User </a></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    }
    ?>

  <?php
  } else {
  }
  ?>

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
    $("#dashboard").addClass('active');
  });
  $(document).ready(function() {
    $("#501000").addClass('active');
    $("#500000").addClass('active');
    $("#500000").addClass('is-expanded');
  });
</script>
</body>

</html>