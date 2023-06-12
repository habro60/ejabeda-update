<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['ownerSubmit'])) {
    // $office_code = $_SESSION['office_code'];
    $office_code = $conn->escape_string($_POST['office_code']);
    $effect_date = $conn->escape_string($_POST['effect_date']);
    $bill_charge_code = $conn->escape_string($_POST['bill_charge_code']);
    $bill_charge_name = $conn->escape_string($_POST['bill_charge_name']);
    $bill_pay_frequeny = $conn->escape_string($_POST['bill_pay_frequeny']);
    $bill_pay_method = $conn->escape_string($_POST['bill_pay_method']);
    $pay_curr = $conn->escape_string($_POST['pay_curr']);
    $bill_fixed_amt = $conn->escape_string($_POST['bill_fixed_amt']);
    $link_gl_acc_code = $conn->escape_string($_POST['link_gl_acc_code']);
    $ss_creator = $_SESSION['username'];
    $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];
    
     $insertData = "INSERT INTO apart_bill_charge_setup (id, office_code, effect_date, bill_charge_code, bill_charge_name, bill_pay_frequency, bill_pay_method, pay_curr, bill_fixed_amt, link_gl_acc_code,is_current, ss_creator,ss_created_on,ss_org_no) values (NULL,'$office_code','$effect_date','$bill_charge_code','$bill_charge_name','$bill_pay_frequeny','$bill_pay_method','$pay_curr','$bill_fixed_amt','$link_gl_acc_code','1','$ss_creator','$ss_created_on','$ss_org_no')";
  
    //  echo $insertData;
    //  exit;
  
    $conn->query($insertData);
    if ($conn->affected_rows == 1) {
      $message = "Save owner Successfully!";
    } else {
      $mess = "Failled!";
    }
  
     // Service Facitiy Insert ....
  $selectCharge = "SELECT * FROM `apart_owner_sevice_facility`  WHERE bill_charge_code='$bill_charge_code'";
  $ResultCharge = $conn->query($selectCharge);
  // $data = $ResultCharge->fetch_assoc();
  $data_num = mysqli_num_rows($ResultCharge);
  if ($data_num == '0') {
      $insertData = "INSERT INTO `apart_owner_sevice_facility` (`office_code`,`owner_id`,`flat_no`,`bill_charge_code`,`bill_charge_name`, `bill_pay_frequency`, bill_pay_method,pay_curr,bill_fixed_amt,ss_creator,ss_creator_on,`ss_org_no`) SELECT flat_info.office_code,flat_info.owner_id, flat_info.flat_no, apart_bill_charge_setup.bill_charge_code,  apart_bill_charge_setup.bill_charge_name, apart_bill_charge_setup.bill_pay_frequency,apart_bill_charge_setup.bill_pay_method,apart_bill_charge_setup.pay_curr, apart_bill_charge_setup.bill_fixed_amt,apart_bill_charge_setup.ss_creator,apart_bill_charge_setup.ss_created_on,apart_bill_charge_setup.ss_org_no FROM flat_info, apart_bill_charge_setup  WHERE apart_bill_charge_setup.bill_charge_code='$bill_charge_code'";
      $conn->query($insertData);
  } else {
}
  
    header('refresh:1;bill_charge_setup.php');
}
// ===================================
if (isset($_POST['submit'])) {

  $office_code = $_SESSION['office_code'];
  $id = $conn->escape_string($_POST['id']);
  $effect_date = $conn->escape_string($_POST['effect_date']);
  $fixed_rent = $conn->escape_string($_POST['fixed_rent']);
  $vat_rate = $conn->escape_string($_POST['vat_rate']);
  $per_unit_rate = $conn->escape_string($_POST['per_unit_rate']);
  $is_current = '1';

  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];    
  $ss_org_no = $_SESSION['org_no'];

  $updateQuery = "UPDATE `unit_rate` SET fixed_rent='$fixed_rent',vat_rate='$vat_rate',per_unit_rate='$per_unit_rate',`is_current`='1',`ss_modifier`='$ss_modifier',`ss_modified_on`='$ss_modified_on',`ss_org_no`='$ss_org_no' where id='$id'
  ";
// echo $updateQuery;
// exit;
  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) {
    $message = "Update Successfully!";
  } else {
    $mess = "Failled!";
  }
}
// ======================
  ?>
  <?php

require "../source/top.php";
$pid = 1303000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Bill and Charge Setup </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>


    <!-- ===== button define ====== -->
    <div>
      <button id="chargeAddBtn" class="btn btn-success"><i class="fa fa-plus"></i>Bill and Charge Define</button>
      <button id="chargeListBtn" class="btn btn-primary"><i class="fa fa-eye"></i>View Bill and Charge List</button>
      <button id="billUnitBtn" class="btn btn-primary"><i class="fa fa-eye"></i>Bill Unit Rate Setup</button>
    </div>
    <!-- ====== button Define closed ====== -->
    <div class="row">
      <div class="col-md-12">
        <div>
          <div id="flatAdd" class="collapse">
            <div style="padding:5px">
              <!-- form start  -->
              <form method="post">
              <form method="post" enctype="multipart/form-data">
              <!-- emp_id user name part -->
              <div class="form-row form-group">
                <label class="col-sm-2 col-form-label">Office</label>
                <label class="col-form-label">:</label>
                <div class="col-sm-6">
                  <select name="office_code" class="form-control select2">
                    <option value="">----Select any----</option>
                    <?php
                    $selectQuery = 'SELECT * FROM `office_info`';
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
                </div>
              </div>

              <!-- effect_date -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Effect Date.</label>
                <label class="col-form-label">:</label>
                <div class="col-sm-6">
                  <input type="date" class="form-control" id="" name="effect_date">
                </div>
              </div>
              <!-- bill_charge_code -->
              <div class="form-row form-group">
                <label class="col-sm-2 col-form-label">Bill & Charge Code</label>
                <label class="col-form-label">:</label>
                <div class="col-sm-6">
                  <select name="bill_charge_code" class="form-control select2" id="bill_charge_code" onchange="billName()" required>
                    <option value="">----Select any----</option>
                    <?php
                    $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "billt" AND `softcode`>0';
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
                </div>
                </div>
                <div>
                <input type="hidden" name="bill_charge_name" id="bill_charge_name"  value="">
              </div>
              <!-- bill_pay_frequeny -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Bill Pay Frequency</label>
                <label class="col-form-label">:</label>
                <div class="col-sm-6">
                  <select name="bill_pay_frequeny" class="form-control select2">
                    <option value="Monthly">Monthly</option>
                    <option value="Quarterly">Quarterly</option>
                    <option value="halfYearly">Half Yearly</option>
                    <option value="Yearly">Yearly</option>
                  </select>
                </div>
              </div>
              <!-- bill_pay_method  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Bill Pay Method</label>
                <label class="col-form-label">:</label>
                <div class="col-sm-6">
                  <select name="bill_pay_method" id="bill_pay_method" onchange="payMethod()" class="form-control select4" required>
                    <option value="fixed">Fixed</option>
                    <option value="variable">Variable</option>
                  </select>
                </div>
              </div>
              <!-- ===============Pay currency ========================== -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Currency</label>
                <label class="col-form-label">:</label>
                <div class="col-sm-6">
                  <select name="pay_curr" class="form-control select4">
                    <?php

                    $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "CURT" AND `softcode`>0';
                    $selectQueryResult =  $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row = $selectQueryResult->fetch_assoc()) {
                        echo '<option value="' . $row['softcode'] . '">' . $row['softcode'] . '. ' . $row['description'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- bill_fixed_amt-->
              <div class="form-group row" id="fixed_amt">
                <label class="col-sm-2 col-form-label">Fixed Bill Amt.</label>
                <label class="col-form-label">:</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="bill_fixed_amt" name="bill_fixed_amt" required>
                </div>
              </div>

              <!-- link_gl_acc_code  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">link GL.A/C.</label>
                <label class="col-form-label">:</label>
                <div class="col-sm-6">
                  <select class="form-control select2" name="link_gl_acc_code" style="width:250px" required>
                    <option value="">---Select Link Account---</option>
                    <?php
                    $selectQuery = "SELECT * FROM `gl_acc_code` where category_code = 1 or category_code = 2 or category_code = 3  and postable_acc= 'Y' ORDER by acc_code";
                    $selectQueryResult =  $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($drrow = $selectQueryResult->fetch_assoc()) {
                        echo '<option value="' . $drrow['acc_code'] . '">'  . $drrow['acc_head'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- submit  -->
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="ownerSubmit">Submit</button>
                </div>
              </div> 
              </form>
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
<!-- ===================unit rate========== -->
       <div class="tile" id="billUnit">
       
       <form action="" method="post">
                                
              <?php
               $selectQuery = "SELECT * from unit_rate ";
               $selectQueryResult = $conn->query($selectQuery);
               $rows = $selectQueryResult->fetch_assoc();
               ?>
               <div class="col-md-12">
              <!-- effect_date  -->
              <div class="form-group row">
                <label class="col-sm-6 col-form-label">ID</label>
                <div class="col-sm-6">
                    <input input type="text" class="form-control"  name="id" value="<?php echo $rows['id']; ?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-6 col-form-label">effect_date</label>
                <div class="col-sm-6">
                    <input type="text" name="effect_date" value="<?php echo $rows['effect_date']; ?>" class="form-control" onclick="Funww()" id="more">
                </div>
              </div>
               
              <!-- bill_charge_code  -->
              <div class="form-group row"> 
              
                          <label class="col-sm-6 col-form-label">Charge Name</label>
                          <div class="col-sm-6">

                           <select name="bill_charge_code" id="" class="form-control" required>
          
                          <option value="">----Select Service ---</option>
                          <?php
                          $selectQuery = "SELECT * FROM `apart_bill_charge_setup` WHERE `bill_pay_method`= 'variable'";
                           $selectQueryResult =  $conn->query($selectQuery);
                          if ($selectQueryResult->num_rows) {
                          while ($row = $selectQueryResult->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $row['bill_charge_code']; ?>" <?php if ($rows['bill_charge_code'] == $row['bill_charge_code']) {
                                                                    echo "selected";
                                                                  } ?>><?php echo $row['bill_charge_name']; ?></option>

                           <?php
                             }
                           }
                         ?>
                         </select>
                     </div>
                   </div>

             <!-- ====Device Rent================== -->
              <div class="form-group row">
                <label class="col-sm-6 col-form-label">Device Rent in %.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="fixed_rent" value="<?php echo $rows['fixed_rent']; ?>" required>
                </div>
              </div>
              <!-- ====Vat Amt================== -->
              <div class="form-group row">
                <label class="col-sm-6 col-form-label">Vat in %.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="vat_rate" value="<?php echo $rows['vat_rate']; ?>" required>
                </div>
              </div>
              <!-- ====From Unit================== -->
              <div class="form-group row">
                <label class="col-sm-6 col-form-label">From Unit</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="from_unit" value="<?php echo $rows['from_unit']; ?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-6 col-form-label">To Unit</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="to_unit" value="<?php echo $rows['to_unit']; ?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-6 col-form-label">Per Unit Rate</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="per_unit_rate" value="<?php echo $rows['per_unit_rate']; ?>" required>
                </div>
              </div>
              <!-- ===================currency================= -->
              <div class="form-group row"> 
                          <label class="col-sm-6 col-form-label">Currency</label>
                          <div class="col-sm-6">

                           <select name="pay_curr" id="" class="form-control" readonly>
          
                          <option value="">----Select currency---</option>
                          <?php
                          $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "CURT" AND `softcode`>0';
                           $selectQueryResult =  $conn->query($selectQuery);
                       if ($selectQueryResult->num_rows) {
                          while ($row = $selectQueryResult->fetch_assoc()) {
                          ?>
                          <option value="<?php echo $row['softcode']; ?>" <?php if ($rows['pay_curr'] == $row['softcode']) {
                                                                    echo "selected";
                                                                  } ?>><?php echo $row['description']; ?></option>

                           <?php
                             }
                           }
                         ?>
                         </select>
                     </div>
                   </div>
                   <!-- submit  -->
                 <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
              </div>
             </div>
          </form>
    </div>
    <!-- ====== flat View List ====== -->
    <div class="tile" id="flatList">
    <div class="tile-body">
          <h5 style="text-align: center">Bill & Charge Setup</h5>
          <table class="table table-hover table-bordered" id="ownerListTable">
            <thead>
              <tr>
                <th>Sl.No.</th>
                <th>Office Code</th>
                <th>Effect Date</th>
                <th> Bill & charge Name</th>
                <th> Bill Pay Freqency</th>
                <th> Pay Method</TH>
                <th> Currency</TH>
                <th>Fixed Bill Amt.</th>
                <th>Link GL account</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM `apart_bill_charge_setup`";
              $query = $conn->query($sql);
              while ($row = $query->fetch_assoc()) {
                echo
                  "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['office_code'] . "</td>
                        <td>" . $row['effect_date'] . "</td>
                        <td>" . $row['bill_charge_name'] . "</td>
                        <td>" . $row['bill_pay_frequency'] . "</td>
                        <td>" . $row['bill_pay_method'] . "</td>
                        <td>" . $row['pay_curr'] . "</td>
                        <td>" . $row['bill_fixed_amt'] . "</td>
                        <td>" . $row['link_gl_acc_code'] . "</td>
                  <td><a target='_blank' href='bill_charge_edit_info.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                  </td>
								</tr>";
                // include('edit_delete_modal.php');
              }
              ?>
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
  $('#sampleTable').DataTable();
  $('#memberTable').DataTable();
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#1310000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded')
  });

  $('#flatList').hide();

  // chargeAddBtn
  $('#chargeAddBtn').on('click', function() {
    $('#flatAdd').show();
    $('#flatList').hide();
    $('#billUnit').hide();

  });
  // memberistBtn
  $('#chargeListBtn').on('click', function() {
    $('#flatList').show();
    $('#flatAdd').hide();
    $('#billUnit').hide();
  });
// unit rate setup
$('#billUnitBtn').on('click', function() {
    $('#billUnit').show();
    $('#flatAdd').hide();
    $('#flatList').hide();
  });
  
</script>
<?php
$conn->close();

?>
</body>

</html>