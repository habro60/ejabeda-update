<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['submit'])) {

  //$select_month = $conn->escape_string($_SESSION['select_month']);
  // $desig_code = $conn->escape_string($_POST['desig_code']);
  // $desig_desc = $conn->escape_string($_POST['desig_desc']);
  // $short_desc = $conn->escape_string($_POST['short_desc']);
  $grade_code = $conn->escape_string($_POST['grade_code']);
  // //$desig_creat_dt = date('Y-m-d H:i:s');
  // //$desig_abolished_dt = $conn->escape_string($_POST['desig_abolished_dt']);
  // //$temporary = $conn->escape_string($_POST['temporary']);
  // //$rec_status = $conn->escape_string($_POST['rec_status']);
  // //$remarks = $conn->escape_string($_POST['remarks']);
  // $ref_no = $conn->escape_string($_POST['ref_no']);
  // $ref_date = $conn->escape_string($_POST['ref_date']);
  // //$effect_date = $conn->escape_string($_POST['effect_date']);

  // $ss_creator = $_SESSION['username'];
  // $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  // $ss_org_no = $_SESSION['org_no'];

  $insertData = "INSERT INTO hr_allowance_setup (office_code, year_of_scale, grade_code, desig_code, 
    allowance_code, allowance_desc,  allowance_type, allowance_amt, ref_no, ref_date, is_current, 
    ss_creator, ss_created_on,ss_modifier,ss_modified_on,ss_org_no) values('$office_code', '$year_of_scale',
    '$grade_code', '$desig_code','$allowance_code', '$allowance_desc','$allowance_type','$allowance_amt',
    '$ref_no', '$ref_date', '1', '$ss_creator','$ss_created_on','$ss_creator',
    '$ss_created_on','$ss_org_no')";


// echo $insertData;
//    exit;

    $conn->query($insertData);

    if ($conn->affected_rows == 1) {
        $message = "Save owner Successfully!";
    } else {
        $mess = "Failled!";
    }
    header('refresh:1;hr_hr_basicpay_setup.php');
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
        <h1><i class="fa fa-dashboard"></i> Payroll Calculation </h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
      </ul>
    </div>
    <?php if ($seprt_cs_info == 'Y') { ?>


      <!-- ===== button define ====== -->
      <div>
        <div><button id="BasicPayBtn" class="btn btn-success"><i class=""></i>Employee Basic Pay Setup</button>
          <!-- <button id="allemppayrollBtn" class="btn btn-primary"><i class=""></i>Payroll for all employees</button> -->
          <!--</div><br><button id="desigListBtn" class="btn btn-primary"><i class=""></i>Payroll for a month</button>-->
        </div>
        <!-- ====== button Define closed ====== -->
        <div class="row">
          <div class="col-md-12">
            <div>
                 <div id="BasicPay" class="collapse">
                    <div style="padding:5px">
                        <h5 style="text-align: center">Basic pay for employees</h5>
                    </div>
                      <form method="post">
                      
                            <table class="table table-hover table-bordered" id="scaletable">
                              <thead>
                                <tr>
                                  <th>Employee number</th>
                                  <th>Designation Code</th>
                                  <th>Grade Code</th>
                                  <th>Joining Date</th>
                                  <th>Start Pay Amount</Th>
                                  <th>Increment Amount</th>
                                  <th>Last Pay Amount</th>
                                </tr>
                              </thead>
                            <tbody>
                           <?php>
                            $sql = "SELECT sm_hr_emp.emp_id, sm_hr_emp.desig_code, sm_hr_emp.grade_code, sm_hr_emp.join_date, 
                            hr_pscale_setup.start_pay_amt, hr_pscale_setup.increment_amt, hr_pscale_setup.last_pay_amt FROM sm_hr_emp, 
                            hr_pscale_setup WHERE sm_hr_emp.desig_code=hr_pscale_setup.desig_code and 
                            sm_hr_emp.grade_code=hr_pscale_setup.grade_code";
                           $query = $conn->query($sql);
                            while ($row = $query->fetch_assoc()) {
                            $no++;
                       echo
                              "<tr>
                                     <td>" . $row['emp_id'] . "</td>
                                     <td>" . $row['desig_code'] . "</td>
                                     <td>" . $row['grade_code'] . "</td>
                                     <td>" . $row['join_date'] . "</td>
                                     <td>" . $row['start_pay_amt'] . "</td>
                                     <td>" . $row['increment_amt'] . "</td>
                                     <td>" . $row['last_pay_amt'] . "</td>
                              </tr>";
                          }                  
                   
                      <div>
                      ---------
                    }
                    ?>
                </tbody>
            </table>
                       </div>
                         <input type="hidden" name="activation_key" value="0">
                        <button type="submit" class="btn btn-success" name="submit">Submit</button>
                      </div>

    </div>
<?php
} else {
    echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
} ?>



                    
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
      
      echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
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