<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['editSubmit'])) {
  $id = intval($_GET['id']);
  $office_code = $conn->escape_string($_POST['office_code']);
  $effect_date = $conn->escape_string($_POST['effect_date']);
  $fund_type = $conn->escape_string($_POST['fund_type']);
  $fund_type_desc = $conn->escape_string($_POST['fund_type_desc']);
  $fund_pay_frequency = $conn->escape_string($_POST['fund_pay_frequency']);
  $pay_method = $conn->escape_string($_POST['pay_method']);
  $pay_amt = $conn->escape_string($_POST['pay_amt']);
  $pay_curr = $conn->escape_string($_POST['pay_curr']);
  
  
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];    
  $ss_org_no = $_SESSION['org_no'];

  $updateQuery = "UPDATE `fund_type_setup` SET `id`='$id',`office_code`='$office_code',`effect_date`='$effect_date',`fund_type`='$fund_type', `fund_type_desc`='$fund_type_desc', `fund_pay_frequency`='$fund_pay_frequency',`pay_method`='$pay_method', pay_curr='$pay_curr',`pay_amt`='$pay_amt',`ss_modifier`='bisnu',`ss_modified_on`='2020-06-02',`ss_org_no`='9900' where id='$id'";

  
  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) {
    $message = "Update Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:2;bodri_fund_setup.php');
}
?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $selectQueryEdit = "SELECT * FROM `fund_type_setup` WHERE id='$id'";
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
      <h1><i class="fa fa-dashboard"></i> Fund type Edit </h1>
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
        <div id="">
          <div style="padding:5px">
            <!-- form start  -->
            <form action="" method="post">
                  <input type="text" class="form-control" id="" value="<?php echo $rows['id']; ?>" name="id" hidden>
                
                 <div class="form-group row">
                <label class="col-sm-2 col-form-label">under Office </label>
                <div class="col-sm-6">
                    <input type="text" name="office_code" value="<?php echo $rows['office_code']; ?>">
                </div>
              </div>
               
              <!-- fund type  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Fund Type</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="fund_type" value="<?php echo $rows['fund_type']; ?>">
                </div>
              </div>
              
              <!-- Fund Name_name -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Fund Type Name</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="" name="fund_type_desc" value="<?php echo $rows['fund_type_desc']; ?>">
                </div>
              </div>
               <!-- effect date   -->
               <div class="form-group row">
                <label class="col-sm-2 col-form-label">Effect Daate </label>
                <div class="col-sm-6">
                  <input type="date" class="form-control" id="" name="effect_date" value="<?php echo $rows['effect_date']; ?>">
                </div>
              </div>
              <!-- Fund pay_frequeny-->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Fund Pay Frequency</label>
                <div class="col-sm-6">

                       <select required name="fund_pay_frequency" id="" class="form-control">
                               <option value="Daily" <?php if ($rows['fund_pay_frequency']== "Daily") {echo 'selected="selected"';} ?>>Daily</option>

                               <option value="Weekly" <?php if ($rows['fund_pay_frequency']== "Weekly") {echo 'selected="selected"';} ?>>Weekly</option>

                                <option value="Monthly" <?php if ($rows['fund_pay_frequency']== "Monthly") {echo 'selected="selected"';} ?>>Monthly</option>
                                <option value="Quarterly" <?php if ($rows['fund_pay_frequency']== "Quarterly") {echo 'selected="selected"';} ?>>Quarterly</option>
                                <option value="Half_yearly" <?php if ($rows['fund_pay_frequency']== "Half_yearly") {echo 'selected="selected"';} ?>>Half_yearly</option>
                                <option value="Yearly" <?php if ($rows['fund_pay_frequency']== "Yearly") {echo 'selected="selected"';} ?>>Yearly</option>
                                <option value="Others" <?php if ($rows['fund_pay_frequency']== "On demand") {echo 'selected="selected"';} ?>>On Demand</option>
                         </select>
                      </div>
                   </div>
             
              <!-- Fund pay_method -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Pay Method</label>
                <div class="col-sm-6">
                     <select name="pay_method" id="" class="form-control hh" style="width: 100%">
                        <option value="Fixed" <?php if ($rows['pay_method'] == 'Fixed') { ?> selected="selected" <?php } ?>>Fixed</option>
                        <option value="Percentage" <?php if ($rows['pay_method'] == 'Percentage') { ?> selected="selected" <?php } ?>>Percentage</option>
                        <option value="Variable" <?php if ($rows['pay_method'] == 'Variable') { ?> selected="selected" <?php } ?>>Variable</option>
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
                          $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "CURR" AND `softcode`>0';
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

              <!-- Pay_amt  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Pay Amt.</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="pay_amt" value="<?php echo $rows['pay_amt']; ?>" required>
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