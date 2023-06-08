<?php

require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
$pid = 1003000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
require "../setting/setting.php";

// session //
$office_code = $_SESSION['office_code'];
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_addr1 = $_SESSION['org_addr1'];
$org_email = $_SESSION['org_email'];
$org_tel = $_SESSION['org_tel'];  
$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];

function timeago($datetime, $full = false) {
    date_default_timezone_set('Asia/Dhaka');
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
    'y' => 'yr',
    'm' => 'mon',
    'w' => 'week',
    'd' => 'day',
    'h' => 'hr',
    'i' => 'min',
    's' => 'sec',
    );
    foreach ($string as $k => &$v) {
    if ($diff->$k) {
        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } 
    else {
        unset($string[$k]);
    }
    }
    if (!$full) {
    $string = array_slice($string, 0, 1);
    }
    
    return $string ? implode(', ', $string) . '' : 'just now';
}


?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
   
    <script src="https://kit.fontawesome.com/f826455fa9.js" crossorigin="anonymous"></script>

    <title>Vehicles Report</title>
  </head>
  <body>


  <main class="app-content">
        <div class="card">
            <div class="card-header">

                <h3 class="card-title">Parking Bill</h3>

            </div>

            <div class="card-body">
               
            <div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">

                        <form method="POST" enctype="multipart/form-data" name="datereports" action="generate-reports.php">

                            <div class="panel-body">
            
                           
        <table class="table-responsive">
            <tbody>
                <tr>
                    <?php
                    if ($role_no == '99') {
                        $option = "SELECT office_code,office_name from office_info";
                        $query = $conn->query($option);
                    ?>
                        <td>
                            <select name="officeId" class="form-control select2" id="" style="width: 180px;">
                                <option value="">-Select Office-</option>
                                <?php
                                while ($rows = $query->fetch_assoc()) {
                                    echo '<option value=' . $rows['office_code'] . '>' . $rows['office_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    <?php
                    }
                    ?>
                    <td>
                        <input type="date" name="startdate" value="<?php echo $startdate; ?>" class="form-control" required>
                    </td>
                    <td>
                        <input type="date" name="enddate" value="<?php echo $enddate; ?>" class="form-control" required>
                    </td>
                    <td>
                        <input type="submit" name="submit" id="submitBtn" class="btn btn-info" value="Report View">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
                        
                    
					</div>
				</div>
				
				
				
</div><!--/.row-->

            </div>
        </div>
</main>


   
    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<!-- Data table plugin-->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#studentTable').DataTable();
 
</script>

  </body>
</html>