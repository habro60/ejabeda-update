<?php
session_start();
if (isset($_SESSION["username"])) {
  header("Location: index/index.php");
}

require_once('database.php');

if (isset($_POST['login_user'])) {
  $username =  $_POST['username'];
  $password =  $_POST['password'];
  $office_code =  $_POST['office_code'];
  $user_validity_date = date('Y-m-d');
  $username = strip_tags(mysqli_real_escape_string($conn, trim($username)));
  $password = strip_tags(mysqli_real_escape_string($conn, trim($password)));
  $office_code = strip_tags(mysqli_real_escape_string($conn, trim($office_code)));
  $query = "SELECT * FROM `user_info`, org_info WHERE username='" . $username . "' AND office_code='" . $office_code . "' AND user_validity_date > $user_validity_date";
  // $query = "SELECT * FROM `user_info`, org_info WHERE username='" . $username . "' AND office_code='" . $office_code . "' AND user_status='1' AND user_validity_date > $user_validity_date";
  // echo $query;
  // exit;
  $result = $conn->query($query);
  $rowcount = mysqli_num_rows($result);
  if ($rowcount > 0) {
    while ($row = $result->fetch_assoc()) {
      if ($row['user_status'] == 1) {
        // ======== user_info ========
        $id = $row['id'];
        $office_code = $row['office_code'];
        $username = $row['username'];
        $sa_role_no = $row['sa_role_no']; 
        $link_id = $row['link_id'];
        $employee_image = $row['employee_image'];
        
        // ======== org_info ========
        $org_no = $row['org_no'];
        $org_name = $row['org_name'];
        $org_addr1 = $row['org_addr1'];
        $org_email = $row['org_email'];
        $org_website = $row['org_website'];
        $org_tel = $row['org_tel'];
        $org_logo = $row['org_logo'];
        $org_fin_month = $row['org_fin_month'];
        $org_budget_year = $row['org_fin_year_st'];
        $org_budget_year = $row['org_budget_year'];
        $org_eod_bod_proceorg_date = $row['org_eod_bod_proceorg_date'];
        $org_eod_bod_flag = $row['org_eod_bod_flag'];
        $org_rep_footer1 = $row['org_rep_footer1'];
        $org_rep_footer2 = $row['org_rep_footer2'];
        $seprt_cs_info = $row['seprt_cs_info'];

        if (password_verify($password, $row["password"])) {
          // ======== user_info ========
          $_SESSION["id"] = $id;
          $_SESSION["username"] = $username;
          $_SESSION["employee_image"] = $employee_image;
          $_SESSION["link_id"] = $link_id;
          // Store data in session variables
          $_SESSION["loggedin"] = true;
          $_SESSION["office_code"] = $office_code;
          $_SESSION["sa_role_no"] = $sa_role_no;
          // ======== org_info ========
          $_SESSION["org_no"] = $org_no;
          $_SESSION["org_name"] = $org_name;
          $_SESSION["org_addr1"] = $org_addr1;
          $_SESSION["org_email"] = $org_email;
          $_SESSION["org_website"] = $org_website;
          $_SESSION["org_tel"] = $org_tel;
          $_SESSION["org_logo"] = $org_logo;
          $_SESSION["org_fin_month"] = $org_fin_month;
          $_SESSION["org_eod_bod_proceorg_date"] = $org_eod_bod_proceorg_date;
          $_SESSION["org_fin_year_st"] = $org_budget_year;
          $_SESSION["org_budget_year"] = $org_budget_year;
          $_SESSION['org_rep_footer1'] = $org_rep_footer1;
          $_SESSION['org_rep_footer2'] = $org_rep_footer2;
          $_SESSION['seprt_cs_info'] = $seprt_cs_info;
          header("Location: index/index.php");
        } else {
          //return false;  
          echo '<script>alert("Password Wrong")</script>';
        }
      } else {
        echo '<script>alert("User Inactive")</script>';
      }
    }
  } else {
    // while false
    echo '<script>alert("Office Code Or Password Wrong!!")</script>';
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Login - Accounting SOft</title>
</head>

<body>
<section class="backimg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    
    <div class="login-box">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
        <h6 style="text-align: center"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h6>
        <hr>
        <div class="form-group <?php // echo (!empty($username_err)) ? 'has-error' : ''; ?>">
          <label class="control-label">OFFICE</label>
          <select name="office_code" class="form-control select2" required>
            <!-- <option value="">-Select Office Type-</option> -->
            <?php
            require 'database.php';
            $selectQuery = 'SELECT office_code, office_name FROM `office_info`';
            $selectQueryResult = $conn->query($selectQuery);
            if ($selectQueryResult->num_rows) {
              while ($row = $selectQueryResult->fetch_assoc()) {
            ?>
            <?php
                echo '<option value="' . $row['office_code'] . '">' . $row['office_name'] . '</option>';
              }
            }
            ?>
          </select>
          <span class="help-block"><?php // echo $username_err; ?></span>
        </div>
        <div class="form-group <?php // echo (!empty($username_err)) ? 'has-error' : ''; ?>">
          <label class="control-label">USERNAME</label>
          <input class="form-control" type="text" placeholder="User Name" autofocus name="username" value="<?php // echo $username; ?>">
          <span class="help-block"><?php // echo $username_err; ?></span>
        </div>
        <div class="form-group <?php // echo (!empty($password_err)) ? 'has-error' : ''; ?>">
          <label class="control-label">PASSWORD</label>
          <input class="form-control" type="password" placeholder="Password" name="password">
          <span class="help-block"><?php // echo $password_err; ?></span>
        </div>
        <div class="form-group">
          <div class="utility">
            <div class="animated-checkbox">
              <label>
                <!-- <input type="checkbox"><span class="label-text">Stay Signed in</span> -->
                <input type="submit" class="btn btn-primary btn-block" value="SIGN IN" name="login_user">
              </label>
            </div>
            <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
          </div>
        </div>
        <!-- <div class="form-group btn-container">
          <input type="submit" class="btn btn-primary" value="SIGN IN">
        </div> -->
      </form>
      <form class="forget-form" action="index.html">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
        <div class="form-group">
          <label class="control-label">EMAIL</label>
          <input class="form-control" type="text" placeholder="Email">
        </div>
        <div class="form-group btn-container">
          <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
        </div>
        <div class="form-group mt-3">
          <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
        </div>
      </form>
    </div>
  </section>
  <!-- Essential javascripts for application to work-->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="js/plugins/pace.min.js"></script>
  <script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function() {
      $('.login-box').toggleClass('flipped');
      return false;
    });
  </script>
</body>

</html>