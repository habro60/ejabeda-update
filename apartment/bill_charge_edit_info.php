<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['editSubmit'])) {

  // $office_code = $_SESSION['office_code'];
  $id = $conn->escape_string($_POST['id']);
  $office_code = $conn->escape_string($_POST['office_code']);
  $effect_date = $conn->escape_string($_POST['effect_date']);
  $bill_charge_code = $conn->escape_string($_POST['bill_charge_code']);
  $bill_charge_name = $conn->escape_string($_POST['bill_charge_name']);
  $bill_pay_frequency = $conn->escape_string($_POST['bill_pay_frequency']);
  
  $bill_pay_method = $conn->escape_string($_POST['bill_pay_method']);
  $pay_curr = $conn->escape_string($_POST['pay_curr']);
  $bill_fixed_amt = $conn->escape_string($_POST['bill_fixed_amt']);
  $link_gl_acc_code = $conn->escape_string($_POST['link_gl_acc_code']);
  $is_current = $conn->escape_string($_POST['is_current']);
  // $gl_acc_code = $conn->escape_string($_POST['gl_acc_code']);
  

  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];    
  $ss_org_no = $_SESSION['org_no'];

  $updateQuery = "UPDATE `apart_bill_charge_setup` SET `id`='$id',`office_code`='$office_code',`effect_date`='$effect_date',`bill_charge_code`='$bill_charge_code', `bill_charge_name`='$bill_charge_name', `bill_pay_frequency`='$bill_pay_frequency',`bill_pay_method`='$bill_pay_method',`pay_curr`='$pay_curr',`bill_fixed_amt`='$bill_fixed_amt',
  `link_gl_acc_code`='$link_gl_acc_code',`is_current`='$is_current',`ss_modifier`='$ss_modifier',`ss_modified_on`='$ss_modified_on',`ss_org_no`='$ss_org_no' where id='$id'";

  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) {
    $message = "Update Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:2;bill_charge_setup.php');
}
?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $selectQueryEdit = "SELECT * FROM `apart_bill_charge_setup` WHERE id='$id'";
  $selectQueryEditResult = $conn->query($selectQueryEdit);
  $rows = $selectQueryEditResult->fetch_assoc();
}
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Bill & Charges Edit </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div>
        <!-- Owner Information end -->
        <div id="OwnerForm">
          <div style="padding:5px">
            <!-- form start  -->
            <form action="" method="post">
                 <input type="text" class="form-control" id="id" value="<?php echo $rows['id']; ?>" name="id" hidden>
                <div class="form-group row">
                <label class="col-sm-2 col-form-label">Under Project</label>
                <div class="col-sm-6">
               
                  <select name="office_code" class="form-control" required>
                    <option value="">-Select office Code -</option>
                    <?php
                    $selectQuery = "SELECT office_code, office_name from office_info ";
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row_off = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php                 
                    echo '<option value="' . $row_off['office_code'] . '"=="' . $row['office_code'] . '" selected="selected">' . $row_off['office_name'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- effect_date  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">effect_date</label>
                <div class="col-sm-6">
                    <input type="text" name="effect_date" value="<?php echo $rows['effect_date']; ?>" class="form-control" onclick="Funww()" id="more">
                </div>
              </div>
               
              <!-- bill_charge_code  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Bill Charge Code.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="bill_charge_code" value="<?php echo $rows['bill_charge_code']; ?>">
                </div>
              </div>

              <!-- bill_charge_name -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Bill Charge Name</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="" name="bill_charge_name" value="<?php echo $rows['bill_charge_name']; ?>">
                </div>
              </div>
             
              
               <!-- Fund pay_frequeny-->
               <div class="form-group row">
                <label class="col-sm-2 col-form-label">Fund Pay Frequency</label>
                <div class="col-sm-6">

                       <select required name="bill_pay_frequency" id="" class="form-control">
                                <option value="Monthly" <?php if ($rows['bill_pay_frequency']== "Monthly") {echo 'selected="selected"';} ?>>Monthly</option>
                                <option value="Quarterly" <?php if ($rows['bill_pay_frequency']== "Quarterly") {echo 'selected="selected"';} ?>>Quarterly</option>
                                <option value="Half_yearly" <?php if ($rows['bill_pay_frequency']== "Half_yearly") {echo 'selected="selected"';} ?>>Half_yearly</option>
                                <option value="Yearly" <?php if ($rows['bill_pay_frequency']== "Yearly") {echo 'selected="selected"';} ?>>Yearly</option>
                                <option value="Others" <?php if ($rows['bill_pay_frequency']== "Others") {echo 'selected="selected"';} ?>>Others</option>
                         </select>
                      </div>
                   </div>
               <!-- Fund pay_method -->
               <div class="form-group row">
                <label class="col-sm-2 col-form-label">Bill Pay Method</label>
                <div class="col-sm-6">
                     <select name="bill_pay_method" id="" class="form-control hh" style="width: 100%">
                        <option value="Fixed" <?php if ($rows['bill_pay_method'] == 'Fixed') { ?> selected="selected" <?php } ?>>Fixed</option>
                        <option value="Percentage" <?php if ($rows['bill_pay_method'] == 'Percentage') { ?> selected="selected" <?php } ?>>Percentage</option>
                        <option value="Variable" <?php if ($rows['bill_pay_method'] == 'Variable') { ?> selected="selected" <?php } ?>>Variable</option>
                      </select>
                </div>
              </div>
              <!-- ===================currency================= -->
              <div class="form-group row"> 
                          <label class="col-sm-2 col-form-label">Currency</label>
                          <div class="col-sm-6">

                           <select name="pay_curr" id="" class="form-control" required>
          
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
              <!-- bill_fixed_amt  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Fixed Bill Amt.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="bill_fixed_amt" value="<?php echo $rows['bill_fixed_amt']; ?>" required>
                </div>
              </div>
              
               <!--link_gl_acc_code  -->
               <div class="form-group row">
                <label class="col-sm-2 col-form-label">Link GL A/C</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="link_gl_acc_code" value="<?php echo $rows['link_gl_acc_code']; ?>" required>
                </div>
              </div>
              <!-- submit  -->
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="editSubmit">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        
        <!-- form close  -->
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
<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#301000").addClass('active');
    $("#300000").addClass('active');
    $("#300000").addClass('is-expanded');
  });
</script>
<?php
$conn->close();
?>
</body>

</html>