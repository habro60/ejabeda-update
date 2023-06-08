<?php
require "../auth/auth.php";
require "../database.php";

 
if (isset($_POST['assignServices'])) {

  $own_id = $_POST['owner_id'];
  $flat_no = $_POST['flat_no'];

  $a = $_POST['owner'];
  for ($count = 0; $count < count($_POST['owner_id']); ++$count) {
    $id = $_POST['id'][$count];

    $owner_id = $_POST['owner_id'][$count];
    //$flat_no = $_POST['flat_no'][$count];

    $allow_flag = $_POST['allow_flag'][$count];
    $effect_date = $_POST['effect_date'][$count];
    $bill_fixed_amt = $_POST['bill_fixed_amt'][$count];
    $terminate_date = $_POST['terminate_date'][$count];
    $ss_creator = $_SESSION['username'];
    $ss_creator_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    if ($owner_id > 0) {
      $query = "update `apart_owner_sevice_facility` set `allow_flag`='$allow_flag', `bill_fixed_amt`='$bill_fixed_amt',`effect_date`='$effect_date',`terminate_date`='$terminate_date', ss_creator='$ss_creator', ss_creator_on='$ss_creator_on', ss_org_no='$ss_org_no' where id='$id'";
      $conn->query($query);
    }
    if ($conn->affected_rows == TRUE) {
      $message = "Successfully";
    } else {
      $assign_menu_failled = "Failled";
    }

    // $query22 ="select * from monthly_bill_entry";
    // $return = mysqli_query($conn, $query22);
    // $rowcount = mysqli_num_rows($return); 
     
     //$sql= "INSERT INTO `monthly_bill_entry`(`owner_id`, `flat_no`) VALUES ('2','1111')";

  }

  $sql= "INSERT INTO `monthly_bill_entry`(`owner_id`,`flat_no`,`bill_for_month`,`bill_charge_code`, `bill_charge_name`,`bill_pay_method`) VALUES ('$a','$flat_no','0000-00-00','6','Electric Bill','variable')";
  // $sql= "INSERT INTO `monthly_bill_entry`(`owner_id`,`flat_no`,`bill_for_month`) VALUES ('$a','$flat_no',NULL)";
    mysqli_query($conn, $sql) or die( mysqli_error($conn));

//   header('refresh:1;owner_info.php');
  echo "<meta http-equiv=\"refresh\" content=\"0;URL=owner_info.php\">";
}
?>

<?php
require "../source/top.php";
$pid = 1301000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";

if (isset($_GET['flat_no'])) {
  $flat_no = $_GET['flat_no'];
  $owner_id = $_GET['owner_id'];
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Owner Services Facility</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
    
    <div class="row">
      <div class="col-md-12">
          <div class="card" id="servicesListForm">
            <div class="card-header" style="background-color:#85C1E9">
              <h4 style="text-align:center">Assign Services to Owner</h4>
            </div>
            <div class="card-body">
              <table style="width: 100%">
                <tbody>
                  <tr>
                    <form method="POST">
                          <table class="table bg-light table-bordered table-sm">
                   <thead>
                         <tr>
                            <th>Owner Name</th>
                            <th>Flat Number</th>
                            <th>Services Name</th>
                            <th>Pay Method</th>
                            <th>Bill Amount</th>
                            <th>Effect Date</th>
                            <th>Terminat Name</th>
                            <th>Active Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $disflag = '0';
                        $sqlowner ="SELECT owner_id, Flat_no FROM apart_owner_sevice_facility where owner_id='$owner_id' AND flat_no='$flat_no'";
                        $queryowner = mysqli_query($conn, $sqlowner);
                        $rowcount = mysqli_num_rows($queryowner);
                        if ($rowcount == '0') {
                            $Sqlinsert = "INSERT INTO `apart_owner_sevice_facility` (`office_code`,`owner_id`,`flat_no`,`bill_charge_code`,`bill_charge_name`, `bill_pay_frequency`, bill_pay_method,pay_curr,bill_fixed_amt, ss_creator, ss_creator_on, ss_org_no) SELECT flat_info.office_code,flat_info.owner_id, flat_info.flat_no, apart_bill_charge_setup.bill_charge_code,apart_bill_charge_setup.bill_charge_name, apart_bill_charge_setup.bill_pay_frequency,apart_bill_charge_setup.bill_pay_method,apart_bill_charge_setup.pay_curr,apart_bill_charge_setup.bill_fixed_amt, apart_bill_charge_setup.ss_creator, apart_bill_charge_setup.ss_created_on, apart_bill_charge_setup.ss_org_no FROM flat_info, apart_bill_charge_setup  WHERE flat_info.owner_id ='$owner_id' AND flat_info.flat_no='$flat_no'";
                            $query = mysqli_query($conn, $Sqlinsert);
                        }
                        $sql = "SELECT apart_owner_sevice_facility.id,apart_owner_sevice_facility.office_code,apart_owner_sevice_facility.owner_id,apart_owner_sevice_facility.flat_no, apart_owner_sevice_facility.bill_charge_code, apart_owner_sevice_facility.bill_charge_name,apart_owner_sevice_facility.bill_pay_frequency,apart_owner_sevice_facility.bill_pay_method,apart_owner_sevice_facility.pay_curr,apart_owner_sevice_facility.bill_fixed_amt, apart_owner_sevice_facility.effect_date,apart_owner_sevice_facility.terminate_date, apart_owner_sevice_facility.allow_flag,apart_owner_info.owner_name FROM apart_owner_sevice_facility, apart_owner_info WHERE apart_owner_sevice_facility.owner_id=apart_owner_info.owner_id AND apart_owner_sevice_facility.owner_id='$owner_id' AND apart_owner_sevice_facility.flat_no='$flat_no' order by apart_owner_sevice_facility.id ,apart_owner_sevice_facility.bill_charge_code";
                        $query = mysqli_query($conn, $sql);
                        if (!empty($query)) {
                            if (is_array($query) || is_object($query)) {
                                while ($rows = $query->fetch_assoc()) {
                        ?>
                                    <tr>
                                        <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>
                                        <input type="hidden" name="bill_charge_code[]" class="form-control" value="<?php echo $rows['bill_charge_code']; ?>" style="width: 100%" readonly>
                                        <td style="background-color:powderblue; text-align: left; width:220px; font-weight:bold"><?php if ($rows['flat_no'] > $disflag) {
                                                                                                        echo $rows['owner_name'];
                                                                                                        $disflag = $rows['flat_no'];
                                                                                                    } else {
                                                                                                        echo "";
                                                                                                    } ?></td>
                                        <td>
                                            <input type="text" name="flat_no" class="form-control" value="<?php echo $rows['flat_no']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td hidden>
                                            <input type="text" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="bill_charge_name[]" class="form-control" value="<?php echo $rows['bill_charge_name']; ?>" style="width: 180px" readonly>
                                        </td>
                                        <td>
                                            <input type="text" name="bill_pay_method[]" class="form-control" value="<?php echo $rows['bill_pay_method']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td hidden>
                                            <input type="text" name="pay_curr[]" class="form-control" value="<?php echo $rows['pay_curr']; ?>" style="width: 100%" readonly>
                                        </td>
                                        <td >
                                            <input type="text" name="bill_fixed_amt[]" class="form-control" value="<?php echo $rows['bill_fixed_amt']; ?>" style="width: 100px" required>
                                        </td>
                                        <td>
                                            <input type="date" name="effect_date[]" class="form-control" value="<?php echo $rows['effect_date']; ?>" style="width: 170px">
                                        </td>
                                        <td>
                                            <input type="date" name="terminate_date[]" class="form-control" value="<?php echo $rows['terminate_date']; ?>" style="width: 170px">
                                        </td>
                                        <td>
                                            <select name="allow_flag[]" class="form-control" style="width: 100px">
                                                <option value="1" <?php if ($rows['allow_flag'] == 1) { ?> selected="selected" <?php } ?>>Active</option>
                                                <option value="0" <?php if ($rows['allow_flag'] == 0) { ?> selected="selected" <?php } ?>>Inactive</option>
                                            </select>
                                        </td>
                                        <input type="hidden" name="owner_id[]" value="<?php echo $rows['owner_id']; ?>" class="owner">
                                    </tr>
                                    <input type="hidden" name="owner" value="<?php echo $rows['owner_id']; ?>">
                            <?php
                                }
                            }
                            ?>
                    </tbody>
                </table>
    <input name="assignServices" type="submit" id="submit" value="Assigned Services" class="btn btn-info pull-right submit" />
<?php
            }
?>
</form>
          </div>
        <?php
      } else {
        echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
      } ?>
        <!-- end of service facility -->
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
              title: "oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
          } else {
          }
          ?>

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
<!--  -->
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script type="text/javascript">
  
</script>
<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#1301000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded');
  });
  // more informatino script start
  $('#more_show').hide();
  var id = this.value;
  $('#more').on('click', function() {
    $('#more_show').show(1000);
  });
 
</script>
<?php
$conn->close();
?>
</body>

</html>