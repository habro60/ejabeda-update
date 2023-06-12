<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['update'])) {
  $office_code = $_SESSION['office_code'];
  // $sa_role_no = $_SESSION['sa_role_no'];
  $id = $conn->escape_string($_POST['id']);
  // $username = $conn->escape_string($_POST['username']);
  $password = $conn->escape_string($_POST['password']);
  $confirm_password = $conn->escape_string($_POST['confirm_password']);
  $hash = password_hash($password, PASSWORD_BCRYPT);
  
  $ss_creator = $_SESSION['username'];
  $ss_created_on = 
  $ss_org_no = $_SESSION['org_no'];
  // echo $password . "<br>" . $confirm_password;
  // exit;
  if ($password == $confirm_password) {
    $updateQuery="UPDATE user_info set `password`='$hash', `ss_modifier`='$ss_creator', `ss_modified_on`=curdate() where `id`='$id' ";
    // echo $updateQuery;
    // exit;
    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {
      $user_password_change_success = "Successfully";
      header("refresh:1;user_password_change.php");
    } else {

      $user_password_change_failled = "Failled!!";
     
    }
  } else {
    $confirm = "Failled!!";

    header("refresh:1;user_password_change.php?");
  }
}



require '../source/top.php';
require '../source/sidebar.php';
require '../source/header.php';
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> User Password Change </h1>
      
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <form method="post">
       <?php
      $office_code = $_SESSION['office_code'];
      $role_no     = $_SESSION['sa_role_no']; 
      $org_name    = $_SESSION['org_name'];
      $org_no      = $_SESSION['org_no']; 
      $id=$_SESSION["id"];
      $username=$_SESSION["username"];
      $sql="SELECT user_info.id,user_info.username,sm_role.role_name FROM `user_info`,sm_role WHERE user_info.sa_role_no=sm_role.role_no and user_info.id='$id'";
      $Query = $conn->query($sql);
      $rows = $Query->fetch_assoc();
      ?>

        <div class="form-group row">
          <label class="col-sm-2 col-form-label">User ID</label>
          <label>:</label>
          <div class="col-sm-6">
            <input type="text" name="id" value="<?php echo $rows['id'];?>" id="id" class="form-control" placeholder="id" readonly>
          </div>
        </div>
       <div class="form-group row">
          <label class="col-sm-2 col-form-label">User Name</label>
          <label>:</label>
          <div class="col-sm-6">
            <input type="text" name="username" value="<?php echo $rows['username'];?>" id="username" class="form-control" placeholder="username">
          </div>
        </div>


        <div class="form-group row">
          <label class="col-sm-2 col-form-label">New Password</label>
          <label>:</label>
          <div class="col-sm-6">
            <input type="password" name="password" value="" id="password" class="form-control" placeholder="Password" required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Confirm New Password</label>
          <label>:</label>
          <div class="col-sm-6">
            <input type="password" name="confirm_password" value="" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
            <span id="conf"></span>
          </div>
        </div>
        
        
        <div class="form-group row">
          <div class="col-sm-10">
            <input type="submit" name="update" value=" + Change P/W" class="btn btn-info" />
            <input type="reset" class="btn btn-danger" name="subBtn" value="cancel">
          </div>
        </div>
      </form>
    </div>
    <?php
    if (!empty($user_password_change_success)) {
      echo '<script type="text/javascript">
            Swal.fire(
                "User Create Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
            )
            </script>';
    }
    if (!empty($user_password_change_failled)) {
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