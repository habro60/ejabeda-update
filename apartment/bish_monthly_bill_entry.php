<?php

require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
require '../source/sidebar.php';
require '../source/header.php';

$pid = 1314000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
   
    <script src="https://kit.fontawesome.com/f826455fa9.js" crossorigin="anonymous"></script>

    <title>Driver</title>
  </head>
  <body>


  <main class="app-content">
        <div class="card">
            <div class="card-header">

                <h3 class="card-title text-center">Input Monthly Bill</h3>

                <div class="container">
                    <div style="text-align: right;">
                    <a href="monthly_bill_summary.php" class="btn btn-outline-success btn-sm text-right">
                            <i class="fas fa-eye fa-w-20"></i><span> Bill Summary Info</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-hover table-bordered table-sm" id="studentTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                        <th>sl. No.</th>
                              <th>Bill For Month</th>
                              <th>Flat Number</th>
                              <th>Privious Reading</th>
                              <th>Privious Reading Date</th>
                              <th>Current Reading</th>
                              <th>Current Reading Date</th>
                              <th>Net Unit</th>
                              <th>bill Amount</th>
                              <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php

$query ="select * from monthly_bill_entry";
$return = mysqli_query($conn, $query);
$rowcount = mysqli_num_rows($return);

if ($rowcount == '0') {

     $sql="INSERT INTO `monthly_bill_entry` (`id`, `office_code`, `owner_id`, `flat_no`, `bill_for_month`, `bill_date`, `bill_charge_code`, `bill_charge_name`, `bill_last_pay_date`, `bill_paid_flag`, `bill_pay_method`, `pay_curr`, `bill_amount`, `owner_gl_code`, `link_gl_acc_code`, `bill_process_date`, `batch_no`, `regular_pay_flag`, `prev_unit`, `prev_unit_dt`, `curr_unit`, `curr_unit_dt`, `net_unit`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modified_on`, `ss_org_no`)
     select null,apart_owner_sevice_facility.office_code, apart_owner_sevice_facility.owner_id, apart_owner_sevice_facility.flat_no, '2021-12', '2021-12-01',  apart_owner_sevice_facility.bill_charge_code, apart_owner_sevice_facility.bill_charge_name, '2021-12-01', '0', apart_owner_sevice_facility.bill_pay_method, '1', '0', apart_owner_info.gl_acc_code,apart_bill_charge_setup.link_gl_acc_code,'2021-12-01', '1', '1', '0', '2021-11-30', '0', '2021-12-01', '0','admin', '2021-12-01','admin321','2021-12-01', '1100000000' from apart_owner_sevice_facility, apart_bill_charge_setup, apart_owner_info where apart_owner_sevice_facility.bill_charge_code=apart_bill_charge_setup.bill_charge_code and apart_owner_sevice_facility.bill_pay_method='Variable' and apart_owner_sevice_facility.owner_id=apart_owner_info.owner_id
     ";

      $query = mysqli_query($conn, $sql);
     
      $viewsql ="select * from monthly_bill_entry order by flat_no";
} else

    {   

$viewsql ="select * from monthly_bill_entry order by flat_no";
}
$no='0';
$query = $conn->query($viewsql);
while ($row = $query->fetch_assoc()) {
$no++;

                        
   
                    ?>

                        <tr>

                            <td>
                                <?php echo $no; ?>
                            </td>
                            <td>
                                <?php echo $row['bill_for_month'] ?>
                            </td>
                            <td>
                                <?php echo $row['flat_no'] ?>
                            </td>
                           
                            <td>
                                <?php echo $row['prev_unit'] ?>
                            </td>
                            <td>
                                <?php echo $row['prev_unit_dt'] ?>
                            </td>
                            <td>
                                <?php echo $row['curr_unit'] ?>
                            </td>
                            <td>
                                <?php echo $row['curr_unit_dt'] ?>
                            </td>
                            <td>
                                <?php echo $row['net_unit'] ?>
                            </td>
                            <td>
                                <?php echo $row['bill_amount'] ?>
                            </td>
                            

                            <td>
                               
                                <a href="#edit<?= $row['id'] ?>" class="btn btn-outline-info btn-sm"
                                data-toggle="modal"><i
                                        class="far fa-edit"></i></a>
                                
                            </td>

                        </tr>

                        <?php
                    }
                        
                        ?>

                    </tbody>
                   
                </table>

            </div>
        </div>
                </main>



    


    <!-- Edit Modal Start -->

    <?php

$query ="select * from monthly_bill_entry";
$return = mysqli_query($conn, $query);
$rowcount = mysqli_num_rows($return);

if ($rowcount == '0') {

     $sql="INSERT INTO `monthly_bill_entry` (`id`, `office_code`, `owner_id`, `flat_no`, `bill_for_month`, `bill_date`, `bill_charge_code`, `bill_charge_name`, `bill_last_pay_date`, `bill_paid_flag`, `bill_pay_method`, `pay_curr`, `bill_amount`, `owner_gl_code`, `link_gl_acc_code`, `bill_process_date`, `batch_no`, `regular_pay_flag`, `prev_unit`, `prev_unit_dt`, `curr_unit`, `curr_unit_dt`, `net_unit`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modified_on`, `ss_org_no`)
     select null,apart_owner_sevice_facility.office_code, apart_owner_sevice_facility.owner_id, apart_owner_sevice_facility.flat_no, '2021-12', '2021-12-01',  apart_owner_sevice_facility.bill_charge_code, apart_owner_sevice_facility.bill_charge_name, '2021-12-01', '0', apart_owner_sevice_facility.bill_pay_method, '1', '0', apart_owner_info.gl_acc_code,apart_bill_charge_setup.link_gl_acc_code,'2021-12-01', '1', '1', '0', '2021-11-30', '0', '2021-12-01', '0','admin', '2021-12-01','admin321','2021-12-01', '1100000000' from apart_owner_sevice_facility, apart_bill_charge_setup, apart_owner_info where apart_owner_sevice_facility.bill_charge_code=apart_bill_charge_setup.bill_charge_code and apart_owner_sevice_facility.bill_pay_method='Variable' and apart_owner_sevice_facility.owner_id=apart_owner_info.owner_id
     ";

      $query = mysqli_query($conn, $sql);
     
      $viewsql ="select * from monthly_bill_entry order by flat_no";
      // $viewsql ="select * , apart_owner_sevice_facility.allow_flag from monthly_bill_entry LEFT JOIN apart_owner_sevice_facility ON monthly_bill_entry.flat_no=apart_owner_sevice_facility.flat_no WHERE apart_owner_sevice_facility.allow_flag=1";
} else

    {   

$viewsql ="select * from monthly_bill_entry order by flat_no";
}
$no='0';
$query = $conn->query($viewsql);
while ($row = $query->fetch_assoc()) {

        $id = $row['id'];

        $query2 = "SELECT monthly_bill_entry.id,monthly_bill_entry.bill_for_month,monthly_bill_entry.owner_id,monthly_bill_entry.flat_no,monthly_bill_entry.bill_charge_code,monthly_bill_entry.bill_charge_name,monthly_bill_entry.bill_paid_flag,monthly_bill_entry.bill_pay_method,monthly_bill_entry.prev_unit,monthly_bill_entry.prev_unit_dt,monthly_bill_entry.curr_unit,monthly_bill_entry.curr_unit_dt,monthly_bill_entry.net_unit,unit_rate.fixed_rent,unit_rate.vat_rate,unit_rate.per_unit_rate,apart_owner_info.owner_name FROM monthly_bill_entry, unit_rate,apart_owner_info where monthly_bill_entry.bill_charge_code=unit_rate.bill_charge_code and monthly_bill_entry.owner_id=apart_owner_info.owner_id and monthly_bill_entry.id='$id'";
        
        $result2 = mysqli_query($conn, $query2) or die( mysqli_error($conn));
    
        $rows = mysqli_fetch_assoc($result2);

    ?>

    <div class="modal fade" id="edit<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Monthly Bill</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">

                    <input type="text" class="form-control" id="" value="<?php echo $rows['id']; ?>" name="id" hidden>
              
              <input type="text" class="form-control" id="" value="<?php echo $rows['fixed_rent']; ?>" name="fixed_rent" hidden>
              <input type="text" class="form-control" id="" value="<?php echo $rows['per_unit_rate']; ?>" name="per_unit_rate" hidden>
              <input type="text" class="form-control" id="" value="<?php echo $rows['vat_rate']; ?>" name="vat_rate" hidden>
              <input type="text" class="form-control" id="" value="<?php echo $rows['flat_no']; ?>" name="flat_no" hidden>

                        <!-- Bill for Month   -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Bill For Month</label>
                <div class="col-sm-6">
                  <input type="month" class="form-control" id="" name="bill_for_month" value="<?php echo $rows['bill_for_month']; ?>">
                  <!-- <input type="month" class="form-control" id="" name="bill_for_month" value="<?php echo date('Y-m'); ?>"> -->
                </div>
              </div>

                       <!-- Flat No  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Shop/Flat No. & Name</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="owner_name" value="<?php  echo $rows['owner_name']; ?>" readonly>
                </div>
              </div>
              <!-- previous unit  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Previous Reading</label>
                <div class="col-sm-6">
                  <!-- <input type="text" class="form-control" id="" name="prev_unit" value="<?php echo $rows['prev_unit']; ?>" > -->
                  <input type="text" class="form-control" id="" name="prev_unit" value="<?php echo $rows['curr_unit']; ?>" readonly>
                </div>
              </div>
               <!-- previous unit date -->
               <div class="form-group row">
                <label class="col-sm-2 col-form-label">Previous Reading date</label>
                <div class="col-sm-6">
                  <input type="date" class="form-control" id="" name="prev_unit_dt" value="<?php echo $rows['curr_unit_dt']; ?>" readonly>
                </div>
              </div>
             
               <!-- current unit  -->
                <div class="form-group row">
                <label class="col-sm-2 col-form-label">Current Reading</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="curr_unit" value="<?php echo $rows['curr_unit']; ?>">
                </div>
              </div>
               <!-- current unit  date -->
               <div class="form-group row">
                <label class="col-sm-2 col-form-label">Current Reading date </label>
                <div class="col-sm-6">
                  <input type="date" class="form-control" id="" name="curr_unit_dt" value="<?php echo $rows['curr_unit_dt']; ?>">
                </div>
              </div>
              <!-- Net bill unit  -->
              <!-- <div class="form-group row">
                <label class="col-sm-2 col-form-label">Net Unit</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="net_unit" value="<?php echo $net_unit=($rows['prev_unit']-$rows['prev_unit']);?>" readonly>
                </div>
              </div> -->
              <!--bill amount  -->
              <!-- <div class="form-group row">
                <label class="col-sm-2 col-form-label">Bill Amount</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="bill_amount" value="<?php echo ''; ?>">
                </div>
              </div> -->


                        <button type="submit" name="updateMonthlyBill" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>

    <?php

        }

        if (isset($_POST['updateMonthlyBill'])) {
          $id = intval($_GET['id']);
          $office_code = $_SESSION['office_code'];
          
          $ss_modifier = $_SESSION['username'];
          $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
          $ss_org_no = $_SESSION['org_no'];
        
          // $owner_id = $conn->escape_string($_POST['owner_id']);
          $flat_no = $conn->escape_string($_POST['flat_no']);
          $bill_for_month = $conn->escape_string($_POST['bill_for_month']);
          $prev_unit = $conn->escape_string($_POST['prev_unit']);
          $prev_unit_dt = $conn->escape_string($_POST['prev_unit_dt']);
          $curr_unit = $conn->escape_string($_POST['curr_unit']);
          $per_unit_rate = $conn->escape_string($_POST['per_unit_rate']);
          $vat_rate = $conn->escape_string($_POST['vat_rate']);
          $fixed_rent = $conn->escape_string($_POST['fixed_rent']);
          $curr_unit_dt =$conn->escape_string($_POST['curr_unit_dt']);
          $net_unit = $conn->escape_string ($_POST['net_unit']);
          $net_unit = ($curr_unit - $prev_unit);
          $bill_amount = $conn->escape_string($_POST['bill_amount']);
          // $bill_amount= (($net_unit * $per_unit_rate) + $fixed_rent + (($net_unit * $per_unit_rate)*$vat_rate)/100);
          // $bill_amount= (($net_unit * $per_unit_rate) + ((($net_unit * $per_unit_rate) * $fixed_rent)/100) + (($net_unit * $per_unit_rate)*$vat_rate)/100);
          
           $bill_demand_amt= ($net_unit * $per_unit_rate) + ((($net_unit * $per_unit_rate) * $fixed_rent)/100);
           $vat_amt = (($bill_demand_amt * $vat_rate)/100);
           $bill_amount = $bill_demand_amt + $vat_amt;
           if ($net_unit <='35') {
            $bill_amount='500';
        
        }
           if ($flat_no=='7010') {
               $bill_amount='750';
                
           }
           if ($flat_no=='5000') {
            $bill_demand_amt= ($net_unit * 11.00);
                $vat_amt = (($bill_demand_amt * 5.00)/100);
            $bill_amount = $bill_demand_amt + $vat_amt+600+300 ;
        
        
        }
           
           if ($flat_no=='5011') {
                $bill_demand_amt= ($net_unit * 9.80) + ((($net_unit * 9.80) * 17.50)/100);
                $vat_amt = (($bill_demand_amt * 5.00)/100);
                $bill_amount = $bill_demand_amt + $vat_amt;
        
        
        }
        $updateQuery = "UPDATE monthly_bill_entry SET bill_for_month='$bill_for_month',prev_unit='$prev_unit',prev_unit_dt='$prev_unit_dt',curr_unit='$curr_unit',curr_unit_dt='$curr_unit_dt',net_unit= '$net_unit',bill_amount='$bill_amount',per_unit_rate='$per_unit_rate',vat_rate='$vat_rate',fixed_rent='$fixed_rent',`ss_modifier`='$ss_modifier',`ss_modified_on`=now(),`ss_org_no`='$ss_org_no' where flat_no='$flat_no'
        ";
          // change on 29-06-2021 for direct input electric bill
          // $updateQuery = "UPDATE monthly_bill_entry SET bill_amount='$bill_amount',`ss_modifier`='$ss_modifier',`ss_modified_on`=now(),`ss_org_no`='$ss_org_no' where flat_no='$flat_no'
          // ";
        
          // echo  $updateQuery;
          // exit;
        
        //
          $conn->query($updateQuery);
          if ($conn->affected_rows == 1) {
            $message = "Update Successfully!";
            
          } else {
            $mess = "Failled!";
          }
          // header('refresh:1;monthly_bill_edit.php');
          //header('refresh:1;monthly_bill_entry.php');
          echo "<meta http-equiv=\"refresh\" content=\"0;URL=monthly_bill_entry.php\">";
        }
            
    ?>

    <!-- Edit Modal End -->


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