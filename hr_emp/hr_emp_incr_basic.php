<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['submit'])) {

  // echo "akib";
  for ($count=0; $count < ($_POST['emp_id']); ++$count ) {
        $emp_id = $_POST['emp_id'][$count];
        $desig_code = $_POST['desig_code'][$count];
        $grade_code = $_POST['grade_code'][$count];
        
       
        $increment_type = $_POST['increment_type'][$count];
        $start_pay_amt = $_POST['start_pay_amt'][$count];
        $increment_slno = $_POST['increment_slno'][$count];
        $increment_amt = $_POST['increment_amt'][$count];
        $increment_percent = $_POST['increment_percent'][$count];
        $year_of_scale = $_POST['year_of_scale'][$count];
        $last_pay_amt = $_POST['last_pay_amt'][$count];

        $office_code = $_SESSION['office_code'];
        $ss_creator = $_SESSION['username'];
        $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
        $ss_org_no = $_SESSION['org_no'];
        
    if ($emp_id > 0 ){
     $insertData = "INSERT INTO hr_emp_basic_pay (id, emp_id, office_code, year_of_scale, desig_code, grade_code, 
    increment_type, start_pay_amt,increment_slno,  increment_amt, increment_percent, last_pay_amt, ss_creator, ss_created_on,ss_modifier, 
    ss_modified_on,ss_org_no) 
    values(null,'$emp_id', '$office_code', '$year_of_scale',  '$desig_code','$grade_code','$increment_type',  ' $start_pay_amt', '$increment_slno', '$increment_amt',  
    '$increment_percent', '$last_pay_amt', '$ss_creator','$ss_created_on','$ss_creator','$ss_created_on','$ss_org_no')";
      
  // echo $insertData;
  // exit;

  $conn->query($insertData);
    }
  if ($conn->affected_rows == 1) {
    $message = "Save owner Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:1;hr_basicpay_setup.php');
}
}



require "../source/top.php";
$pid = 603000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Basic pay Calculation </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>


    <!-- ===== button define ====== -->
    <!-- <div>
      <div><button id="BasicPayBtn" class="btn btn-success"><i class=""></i>Employee Basic Pay Setup</button>
        <button id="allemppayrollBtn" class="btn btn-primary"><i class=""></i>Payroll for all employees</button> -->
        <!--</div><br><button id="desigListBtn" class="btn btn-primary"><i class=""></i>Payroll for a month</button>-->
      <!-- </div> --> 
      <!-- ====== button Define closed ====== -->
      <div class="tile" id="desigList">
        <div class="tile-body">
          <h5 style="text-align: center">Employee Basic Pay Setup</h5>
          <!-- General Account View start -->
          
              <form method="post">
              
          <table class="table table-hover table-bordered" id="memberTable">
            <thead>
              <tr>
                <th>Employee ID</th>
                <th>Designation Code</th>
                <th>Joining Date</th>
                <th>Start Pay Amount</Th>
                <th>Increment Amount</th>
                <th>Last Pay Amount</th>
                <th>Increment Percentage</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              $sql = "SELECT sm_hr_emp.emp_id, sm_hr_emp.desig_code,  sm_hr_emp.join_date, hr_pscale_setup.start_pay_amt, 
              hr_pscale_setup.year_of_scale, hr_pscale_setup.increment_slno,hr_pscale_setup.increment_amt,  hr_pscale_setup.increment_type, hr_pscale_setup.increment_percent, hr_pscale_setup.last_pay_amt, sm_hr_emp.join_date FROM 
             sm_hr_emp, hr_pscale_setup where hr_pscale_setup.increment_slno = YEAR(CURDATE()) - YEAR(sm_hr_emp.join_date)- (DATE_FORMAT(CURDATE(), '%m%d') <
             DATE_FORMAT(sm_hr_emp.join_date, '%m%d')) and sm_hr_emp.desig_code=hr_pscale_setup.desig_code";
 

              $query = $conn->query($sql);
              
              while ($row = $query->fetch_assoc()) {
              ?>
                <tr>
                    <input type="hidden" name="increment_type[]" class="form-control" value="<?php echo $row['increment_type']; ?>" style="width: 100%" readonly>
                    <input type="hidden" name="year_of_scale[]" class="form-control" value="<?php echo $row['year_of_scale']; ?>" style="width: 100%" readonly>
                    <input type="hidden" name="increment_slno[]" class="form-control" value="<?php echo $row['increment_slno']; ?>" style="width: 100%" readonly>
                  <td>
                    <input type="text" name="emp_id[]" class="form-control" value="<?php echo $row['emp_id']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="text" name="desig_code[]" class="form-control" value="<?php echo $row['desig_code']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="text" name="join_date[]" class="form-control" value="<?php echo $row['join_date']; ?>" style="width: 100%" readonly>
                  </td>
                 
                  <td>
                    <input type="text" name="start_pay_amt[]" class="form-control" value="<?php echo $row['start_pay_amt']; ?>" style="width: 100%" readonly>
                  </td>
                  
                  <td>
                    <input type="text" name="increment_amt[]" class="form-control" value="<?php echo $row['increment_amt']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="text" name="last_pay_amt[]" class="form-control" value="<?php echo $row['last_pay_amt']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="text" name="increment_percent[]" class="form-control" value="<?php echo $row['increment_percent']; ?>" style="width: 100%" readonly>
                  </td>
                 
                </tr>
              <?php
              }
              ?>
            </tbody>

          </table>
        </div>
        <input type="hidden" name="activation_key" value="0">
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      </div>

    </div>
    </div>
    </form>
  <?php
  } else {
    // echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
  } ?>
  <!-- Supplier Account View start -->
  </div>
  </div>
  </div>
</main>

<?php
if (!empty($message)) {
  echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
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
              title: "Oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
} else {

  // echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
} ?>
</div>
</div>
</div>
</main>
<!-- Essential javascripts for application to work-->
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
  $('#gradeTable').DataTable();
  $('#memberTable').DataTable();
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#1310000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded')
  });

  // desigAddBtn
  $('#BasicPayBtn').on('click', function() {
    $('#BasicPay').show();

  });
</script>
<?php
$conn->close();

?>
</body>

</html>