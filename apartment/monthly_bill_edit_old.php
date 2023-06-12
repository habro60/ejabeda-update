<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['editSubmit'])) {
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
  $fixed_rent = $conn->escape_string($_POST['fixed_rent']);
  $vat_rate = $conn->escape_string($_POST['vat_rate']);
  $curr_unit_dt =$conn->escape_string($_POST['curr_unit_dt']);
  $net_unit = $conn->escape_string ($_POST['net_unit']);
  $net_unit = ($curr_unit - $prev_unit);
  $bill_amount = $conn->escape_string($_POST['bill_amount']);
  $bill_amount= (($net_unit * $per_unit_rate) + $fixed_rent + (($net_unit * $per_unit_rate)*$vat_rate)/100);
  $bill_amount= (($net_unit * $per_unit_rate) + ((($net_unit * $per_unit_rate) * $fixed_rent)/100) + (($net_unit * $per_unit_rate)*$vat_rate)/100);
  
   $bill_demand_amt= ($net_unit * $per_unit_rate) + ((($net_unit * $per_unit_rate) * $fixed_rent)/100);
   $vat_amt = (($bill_demand_amt * $vat_rate)/100);
   $bill_amount = $bill_demand_amt + $vat_amt;
   if ($net_unit <='35') {
    $bill_amount='500';

}
   if ($flat_no=='7010') {
       $bill_amount='750';

   }
  $updateQuery = "UPDATE monthly_bill_entry SET bill_for_month='$bill_for_month',prev_unit='$prev_unit',prev_unit_dt='$prev_unit_dt',curr_unit='$curr_unit',curr_unit_dt='$curr_unit_dt',net_unit= '$net_unit',bill_amount='$bill_amount',`ss_modifier`='$ss_modifier',`ss_modified_on`=now(),`ss_org_no`='$ss_org_no' where flat_no='$flat_no'
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
  header('refresh:1;monthly_bill_entry.php');
}
?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  // $selectQueryEdit = "SELECT * FROM monthly_bill_entry where id='$id'";
  $selectQueryEdit ="SELECT monthly_bill_entry.id,monthly_bill_entry.bill_for_month,monthly_bill_entry.owner_id,monthly_bill_entry.flat_no,monthly_bill_entry.bill_charge_code,monthly_bill_entry.bill_charge_name,monthly_bill_entry.bill_paid_flag,monthly_bill_entry.bill_pay_method,monthly_bill_entry.prev_unit,monthly_bill_entry.prev_unit_dt,monthly_bill_entry.curr_unit,monthly_bill_entry.curr_unit_dt,monthly_bill_entry.net_unit,unit_rate.fixed_rent,unit_rate.vat_rate,unit_rate.per_unit_rate,apart_owner_info.owner_name FROM monthly_bill_entry, unit_rate,apart_owner_info where monthly_bill_entry.bill_charge_code=unit_rate.bill_charge_code and monthly_bill_entry.owner_id=apart_owner_info.owner_id and monthly_bill_entry.id='$id'";
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
      <h1><i class="fa fa-dashboard"></i> Input Bill Information </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div>
        <!--  Flat Information -->
        <div id="">
          <div style="padding:5px">
            <!-- form start  -->
            <form action="" method="post">
              <input type="text" class="form-control" id="" value="<?php echo $rows['id']; ?>" name="id" hidden>
              <input type="text" class="form-control" id="" value="<?php echo $rows['per_unit_rate']; ?>" name="per_unit_rate" hidden>
              <input type="text" class="form-control" id="" value="<?php echo $rows['fixed_rent']; ?>" name="fixed_rent" hidden>
              <input type="text" class="form-control" id="" value="<?php echo $rows['vat_rate']; ?>" name="vat_rate" hidden>
              <input type="text" class="form-control" id="" value="<?php echo $rows['flat_no']; ?>" name="flat_no" hidden>
              <!-- Bill for Month   -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Bill For Month</label>
                <div class="col-sm-6">
                  <input type="month" class="form-control" id="" name="bill_for_month" value="<?php echo $rows['bill_for_month']; ?>">
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