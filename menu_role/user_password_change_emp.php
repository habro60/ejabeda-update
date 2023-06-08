<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['update'])) {
  // $office_code = $_SESSION['office_code'];
  $office_code = $_POST['office_code'];
  $sa_role_no = $conn->escape_string($_POST['sa_role_no']);
  $user_group = $conn->escape_string($_POST['user_group']);
  $username = $conn->escape_string($_POST['username']);
  $password = $conn->escape_string($_POST['password']);
  $confirm_password = $conn->escape_string($_POST['confirm_password']);
  $hash = password_hash($password, PASSWORD_BCRYPT);
  $password_validity = $conn->escape_string($_POST['password_validity']);
  $user_status = '1';
  $employee_image = $conn->escape_string($_POST['employee_image']);
  $user_validity_date = date('Y-m-d ', strtotime("+ $password_validity days"));
  $ss_creator = $_SESSION['username'];
  $ss_org_no = $_SESSION['org_no'];
  // echo $password . "<br>" . $confirm_password;
  // exit;
  if ($password == $confirm_password) {
    $updateQuery = "INSERT INTO  `user_info` (`id`,`office_code`,`username`,`password`,`sa_role_no`,  `user_create_date`, `user_validity_date`,`user_valid_days`,`user_status`,`user_group`,`employee_image`,`ss_creator`,`ss_created_on`,`ss_org_no`) VALUES(NULL,'$office_code','$username','$hash','$sa_role_no',now(),'$user_validity_date','$password_validity','$user_status','$user_group','$employee_image','$ss_creator',now(),'$ss_org_no')";
    // echo $updateQuery;
    // exit;
    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {
      $user_create_success = "Successfully";
      header("refresh:2;user_create.php");
    } else {
      $user_create_failled = "Failled!!";
      header("refresh:1;user_password_change.php?id=" . $_GET['id'] . "&&user_group=" . $_GET['user_group'] . "&&name=" . $_GET['name'] . "&&image=" . $_GET['image'] . "&&offi=" . $_GET['offi'] . "");
    }
  } else {
    $confirm = "Failled!!";
    header("refresh:1;user_password_change.php?id=" . $_GET['id'] . "&&user_group=" . $_GET['user_group'] . "&&name=" . $_GET['name'] . "&&image=" . $_GET['image'] . "&&offi=" . $_GET['offi'] . "");
  }
}
if (isset($_GET['id']) && isset($_GET['user_group']) && isset($_GET['name'])) {
}

require '../source/top.php';
require '../source/sidebar.php';
require '../source/header.php';
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> User Create <b><?php echo str_replace(' ', '', $_GET['name']); ?></b></h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <form method="post">

        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Given Role </label>
          <label>:</label>
          <div class="col-sm-6">
            <select name="sa_role_no" class="form-control" required>
              <option value="">- Select Role -</option>
              <?php
              $selectQuery = 'SELECT role_no , role_name FROM `sm_role`';
              $selectQueryResult = $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($rows = $selectQueryResult->fetch_assoc()) {
              ?>
                  <option value="<?php echo $rows['role_no']; ?>" <?php if ($rows['role_no'] == $_GET['user_group']) {
                                                                    echo 'selected';
                                                                  } ?>><?php echo $rows['role_name']; ?></option>';
              <?php
                }
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">User Name </label>
          <label>:</label>
          <div class="col-sm-6">
            <input type="text" name="username" id="username" maxlength="15" value="<?php echo $_GET['name']; ?>" class="form-control" required>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Password</label>
          <label>:</label>
          <div class="col-sm-6">
            <input type="password" name="password" value="" id="password" class="form-control" placeholder="Password" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Confirm Password</label>
          <label>:</label>
          <div class="col-sm-6">
            <input type="password" name="confirm_password" value="" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
            <span id="conf"></span>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Password Validity</label>
          <label>:</label>
          <div class="col-sm-6">
            <input type="text" name="password_validity" value="" class="form-control" placeholder="Validity Days" required>
          </div>
        </div>
        <!--  -->
        <div class="form-group row">

          <div class="col-sm-6">
            <input type="text" name="employee_image" value="<?php echo $_GET['image']; ?>" class="form-control" placeholder="Image" hidden>
            <input type="text" name="office_code" value="<?php echo $_GET['offi']; ?>" class="form-control" placeholder="office_code" hidden>
          </div>
        </div>
        <!--  -->
        <input type="hidden" name="id" id="id" class="form-control" value="<?php echo $_GET['id']; ?>">
        <input type="hidden" name="user_group" id="user_group" class="form-control" value="<?php echo $_GET['user_group']; ?>">
        <!--  -->
        <div class="form-group row">
          <div class="col-sm-10">
            <input type="submit" name="update" value=" + Create User" class="btn btn-info" />
            <input type="reset" class="btn btn-danger" name="subBtn" value="cancel">
          </div>
        </div>
      </form>
    </div>
    <?php
    if (!empty($user_create_success)) {
      echo '<script type="text/javascript">
            Swal.fire(
                "User Create Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
            )
            </script>';
    }
    if (!empty($user_create_failled)) {
      echo '<script type="text/javascript">
      Swal.fire(
        "Failled !!",
        "Sorry ' . $_SESSION['username'] . '",
        "success"
      )
            </script>';
    }
    if (!empty($confirm)) {
      echo '<script type="text/javascript">
      Swal.fire(
        "Sorry ' . $_SESSION['username'] . '",
        "Confirm Your Password !!",
        "success"
      )
            </script>';
    }
    ?>
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
<script src="../js/select2.full.min.js"></script>
<script src="../js/bootstrap.min"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#accinfo").addClass('active');
    $("#gl_acc").addClass('active');
    $("#accinfo").addClass('is-expanded');
  });
</script>
<script>
  var password = document.getElementById("password");
  var confirmpassword = document.getElementById("confirm_password");
  confirmpassword.onkeyup = function() {
    if (password.value == confirmpassword.value) {
      document.getElementById("conf").innerHTML = "<strong style='font-weight:10px;color:green'>Password Match</strong>";
    } else {
      document.getElementById("conf").innerHTML = "<strong style='font-weight:10px;color:red'> Not Password Match !</strong>";
    }
  }
</script>
<?php
$conn->close();
?>
</body>

</html>