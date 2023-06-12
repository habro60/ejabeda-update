<?php
session_start();
if (isset($_SESSION["username"])) {
  header("Location: index/index.php");
}

if (isset($_POST['login_user'])) {
if ($_POST['org_no'] == '1000000000') { 
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_green_daru_apart");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_green_daru_apart;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

}elseif ($_POST['org_no'] == '1100000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_vorosha");
  $conn->set_charset("utf8");
  $connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_vorosha;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
  $connect->exec("set names utf8");

} elseif ($_POST['org_no'] == '1200000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_kah_high_school");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_kah_high_school;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

}elseif ($_POST['org_no'] == '1300000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_sheltech");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_sheltech;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");
  	
}elseif ($_POST['org_no'] == '1400000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_pastry_ghar");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_pastry_ghar;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");	

}elseif ($_POST['org_no'] == '1500000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_habro");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_habro;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

} elseif ($_POST['org_no'] == '1600000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_15eng");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_15eng;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

}elseif ($_POST['org_no'] == '1700000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_landmark_Apt");
  $conn->set_charset("utf8");
  $connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_landmark_Apt;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
  $connect->exec("set names utf8");

} elseif ($_POST['org_no'] == '1800000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_banik");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_banik;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

}elseif ($_POST['org_no'] == '1900000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_hashem");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_hashem;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

}elseif ($_POST['org_no'] == '2000000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_darululo_dhaka");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_darululo_dhaka;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");
   
}elseif ($_POST['org_no'] == '2100000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_karna_ind");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_karna_ind;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");
    
}elseif ($_POST['org_no'] == '2200000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_rupganj_somaj");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_rupganj_somaj;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

}elseif ($_POST['org_no'] == '5000000000') {
  $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_demo");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_demo;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");
  
  }
  


  $username =  $_POST['username'];
  $password =  $_POST['password'];
  $office_code =  $_POST['office_code'];
  $user_validity_date = date('Y-m-d');
  $username = strip_tags(mysqli_real_escape_string($conn, trim($username)));
  $password = strip_tags(mysqli_real_escape_string($conn, trim($password)));
  $office_code = strip_tags(mysqli_real_escape_string($conn, trim($office_code)));
  $query = "SELECT * FROM `user_info`, org_info WHERE username='" . $username . "' AND office_code='" . $office_code . "' AND user_validity_date > $user_validity_date";

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
    <h6 style="text-align: center"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h6>
    <hr>
    <div class="login-box">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
        <div class="form-group">
          <label class="control-label">ORGANIZATION ID</label>
          <input type="number" name="org_no" class="form-control" id="org_no" required>
          <span class="help-block"></span>
        </div>
        <div class="form-group">
          <label class="control-label">OFFICE</label>
          <input type="number" name="office_code" class="form-control" required>
          <span class="help-block"></span>
        </div>
        <div class="form-group">
          <label class="control-label">USERNAME</label>
          <input class="form-control" type="text" placeholder="User Name" autofocus name="username" value="">
          <span class="help-block"></span>
        </div>
        <div class="form-group">
          <label class="control-label">PASSWORD</label>
          <input class="form-control" type="password" placeholder="Password" name="password">
          <span class="help-block">
        </div>
        <div class="form-group">
          <div class="utility">
            <div class="animated-checkbox">
              <label>
                <input type="submit" class="btn btn-primary btn-block" value="SIGN IN" name="login_user">
              </label>
            </div>
            <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
          </div>
        </div>
      </form>
      <form class="forget-form">
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
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="jquery.bongabdo.js"></script>
  <script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function() {
      $('.login-box').toggleClass('flipped');
      return false;
    });
// bongabdo
    $(document).ready(function() {
      $('.bongabdo').bongabdo();
    });
    $('.bongabdo').bongabdo({
      date: '2018-04-14'
    });
  </script>
</body>

</html>



