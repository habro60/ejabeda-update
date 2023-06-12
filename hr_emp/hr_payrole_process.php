<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['submit'])) {

  // $select_month = $conn->escape_string($_SESSION['select_month']);
   $date= $conn->escape_string($_POST['bill_for_month']);
   
   $year_diff="select
   YEAR(' $date') - YEAR(sm_hr_emp.join_date) AS year_diff 
   from sm_hr_emp";
   $query = $conn->query($year_diff);
   $rows = mysqli_num_rows($query);
   $row = $query->fetch_assoc();
   $y_diff=$row['year_diff'];
   $_SESSION['current_date'] =  $date;
   $_SESSION['year_diff'] = $y_diff;
  

?>
  <div class="tile" id="payrollgrade">
    <div class="tile-body">
        
      <h5 style="text-align: center">Payroll list for all employees by grades</h5>
      <!-- General Account View start -->
<?php


}
  ?>


  <?php

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
   
        <!-- <div><button id="payrollgradeBtn" class="btn btn-success"><i class=""></i>Payroll for a grade</button> -->
          <!-- <button id="allemppayrollBtn" class="btn btn-primary"><i class=""></i>Payroll process for all employees</button> -->
          <!--</div><br><button id="desigListBtn" class="btn btn-primary"><i class=""></i>Payroll for a month</button>-->
        </div>
        <!-- ====== button Define closed ====== -->
        <div class="row">
          <div class="col-md-12">
            <div>
              <div id="payrollgrade" class="collapse">
                <div style="padding:5px">
                  <!-- form start  -->
                  <form method="post">
                    <!-- ======= Office Code ======-->
                    <!-- <div class="form-row form-group">
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-header">
                        Select Grade for Payroll
                      </div>
                      <div class="card-body"> -->
                    <!-- -=====Office Code======
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Office Code</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="office_code">
                          </div>
                        </div> -->
                    <!---======Grade Selector=======-->
                    <div class="form-group row">
                      <label class="col-sm-5 col-form-label">Grade Code</label>
                      <label class="col-form-label">:</label>
                      <div class="col">
                        <input type="text" class="form-control" id="" name="grade_code">
                      </div>
                      <div>
                        <input type="hidden" name="activation_key" value="0">
                        <button type="submit" class="btn btn-success" name="submit">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

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
        }
        ?>
        <div class="tile" id="allemppayroll">
      

          <div class="tile-body">
       


            <h5 style="margin-left: 37%;">Payroll list for all employees</h5><br>
            <div style="text-align: right;
    
            ">
                       
                       <a id='print' title="Print" class="btn btn-outline-success btn-sm" href="../fpdf184/all_emp.php"><i class="fa fa-print"></i>PRINT</a>
                   </div>

            <form method="POST">
                <div style="margin-left: 30%;">
                <input  type="date" required name="bill_for_month" class="form-control col-6" id="Fmth" onBlur="FmonthCheck()" placeholder="mm/yyyy" reruired>
                <input type="submit" name="submit" id="submitBtn" class="btn btn-info col-6" value="Salary View" >
                </div>
            </form>
      
            <!-- General Account View start -->
            <table class="table table-hover table-bordered" id="memberTable">
              <thead>
                <tr>
                  <th>Employee number</th>
                  <th>Full Name</th>
                  <th>Designation</th>
                  <th>Basic Salary</th>
                  <th>Total Allowance Amount</th>
                  <th>Total Deduction Amount</th>
                  <th>Netpay</th>
                  <th>Action</th>
                </tr>
              </thead>

              
              <tbody>
                <?php
                if (isset($_POST['submit'])) {

                    // $select_month = $conn->escape_string($_SESSION['select_month']);
                    $date= $conn->escape_string($_POST['bill_for_month']);


                $sql = "SELECT sm_hr_emp.emp_id,sm_hr_emp.f_name,sm_hr_emp.desig_code,hr_desig.desig_desc,hr_desig.grade_code FROM sm_hr_emp INNER JOIN hr_desig ON hr_desig.desig_code=sm_hr_emp.desig_code";
               
                $query = $conn->query($sql);
                $index=[];
                $a = [];
                $b = [];
                $c = [];
                $d = [];
                $e = [];
                $f = [];
                $g = [];
                $h=[];
                $i=0;
                $t_net_p=0;
                while ($row = $query->fetch_assoc()) {
                  $emp_desig_code=$row['desig_code'];
                  $emp_id=$row['emp_id'];
                  $total_allowance=0;
                  $total_dedaction=0;
                  $year_diff="select
                  YEAR(' $date') - YEAR(sm_hr_emp.join_date) AS year_diff 
                  from sm_hr_emp  WHERE sm_hr_emp.emp_id='$emp_id'";
                  $query2 = $conn->query($year_diff);
                  $y_diff_row = $query2->fetch_assoc();
                  $y_diff=($y_diff_row['year_diff']+1);
               if($y_diff<=0){
                $last_scale=0;
               }else{
                 
                $sql1 = "SELECT hr_pscale_setup.last_pay_amt FROM hr_pscale_setup WHERE hr_pscale_setup.increment_slno='$y_diff' AND hr_pscale_setup.desig_code='$emp_desig_code'";
               
                //use for MySQLi-OOP
                  $query3 = $conn->query($sql1);
                  $last_scale_row = $query3->fetch_assoc();
                  if(isset($last_scale_row['last_pay_amt'])==''){

                    $last_scale=0;


                  }else{
                    $last_scale=$last_scale_row['last_pay_amt'];
                  }
                  
               }
                  

                  

                 


                  $sql2 = "SELECT hr_allowance_setup.allowance_type,hr_allowance_setup.allowance_amt FROM hr_allowance_setup WHERE hr_allowance_setup.desig_code='$emp_desig_code' ";
               
                  //use for MySQLi-OOP
                    $query4 = $conn->query($sql2);

                    while( $total_allowance_row = $query4->fetch_assoc()){
                      if($total_allowance_row['allowance_type']=='fixed'){

                        $total_allowance=$total_allowance + $total_allowance_row['allowance_amt'];
                       
                      }elseif($total_allowance_row['allowance_type']=='percentage'){
                        $result=(($total_allowance_row['allowance_amt']*$last_scale))/100;
                        $total_allowance=$total_allowance+ $result;
                        
  
                      }

                    }

                   
                    $sql3 = "SELECT hr_deduction_setup.deduction_type,hr_deduction_setup.deduction_amt FROM hr_deduction_setup WHERE hr_deduction_setup.desig_code='$emp_desig_code'";
               
              
                    $query5 = $conn->query($sql3);
                   

                    while( $total_dedaction_row = $query5->fetch_assoc()){
                      if($total_dedaction_row['deduction_type']=='fixed'){

                        $total_dedaction=$total_dedaction + $total_dedaction_row['deduction_amt'];
                       
                      }elseif($total_dedaction_row['deduction_type']=='percentage'){
                        $result=(($total_dedaction_row['deduction_amt']*$last_scale))/100;
                        $total_dedaction=$total_dedaction+ $result;
                        
  
                      }

                    }

                    
                  
                    // $total_dedaction=$total_dedaction_row['total_dedaction'];
            if($last_scale!=0){
              $total_netpay=($last_scale+$total_allowance-$total_dedaction);
            }else{
              $total_netpay=0;
            }
            $t_net_p=$t_net_p+$total_netpay;

            array_push($index,$i);
            array_push($a,$row['emp_id']);
            array_push($b,$row['f_name']);
            array_push($c,$row['desig_desc']);
            array_push($d,$last_scale);
            array_push($e,$total_allowance);
            array_push($f,$total_dedaction);
            array_push($g,$total_netpay);
                  
                  echo
                  "<tr>
                       <td>" . $row['emp_id'] . "</td>
                       <td>" . $row['f_name'] . "</td>
                       <td>" . $row['desig_desc'] . "</td>
                       <td>" . $last_scale  . "</td>
                       <td>" . $total_allowance . "</td>
                       <td>" . $total_dedaction. "</td>
                       <td>" . $total_netpay . "</td>"


                       
                       
                ?>
                      <td><div style="text-align: right;
    
    ">
               
               <a id='print' title="Print" class="btn btn-outline-success btn-sm" href='../fpdf184/single_employee_payrole_report.php?id=<?php echo $index[$i]; ?>'><i class="fa fa-print"></i>PRINT</a>
           </div></td>
           
                       
               
              
    
       
                  </tr>
                  
                       
                <?php
                $i++;
                }
                }
                ?>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td><?php echo $t_net_p ?? 0 ?></td>"
                       
              </tbody>
            </table>
          </div>
        </div>
      <?php
    } else {
      echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
    } ?>
      <!-- Supplier Account View start -->
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

    // $('#allemppayroll').hide();

    // desigAddBtn
    // $('#payrollgradeBtn').on('click', function() {
    //   $('#payrollgrade').show();

    // });
    // memberistBtn
    $('#allemppayrollBtn').on('click', function() {
      $('#allemppayroll').show();
    });
  </script>
  <?php
  $conn->close();

  ?>
  </body>

  </html>