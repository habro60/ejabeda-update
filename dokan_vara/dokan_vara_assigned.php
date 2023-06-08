<?php
require "../auth/auth.php";
require "../database.php";

 
if (isset($_POST['assignServices'])) {
    for ($count = 0; $count < count($_POST['flat_no']); ++$count) {
    $id = $_POST['id'][$count];
    $flat_no = $_POST['flat_no'][$count];
    $allow_flag = $_POST['allow_flag'][$count];
    $effect_date = $_POST['effect_date'][$count];
    $donner_pay_amt=$_POST['donner_pay_amt'][$count];
    $pay_amt=$_POST['donner_pay_amt'][$count];
    // $num_of_pay=$_POST['num_of_pay'][$count];
    $terminate_date = $_POST['terminate_date'][$count];
    $ss_creator = $_SESSION['username'];
    $ss_creator_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    if ($flat_no > 0) {
      $query = "update dokan_vara_detail set `allow_flag`='$allow_flag', `pay_amt`='$donner_pay_amt',`donner_pay_amt`='$donner_pay_amt',`num_of_pay`='120',`last_paid_date`='$effect_date',`effect_date`='$effect_date',`terminate_date`='$terminate_date', ss_creator='$ss_creator', ss_creator_on='$ss_creator_on', ss_org_no='$ss_org_no' where id='$id'";
      // echo  $query;
      // exit;
      $conn->query($query);
    }
    if ($conn->affected_rows == TRUE) {
      $message = "Successfully";
    } else {
      $assign_menu_failled = "Failled";
    }
  }
//   header('refresh:1;doner_fund_assigned.php');
echo "<meta http-equiv=\"refresh\" content=\"0;URL=dokan_vara_assigned.php\">";
}
?>

<?php
require "../source/top.php";
$pid = 1301000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";

if (isset($_GET['id'])) {
  $id = $_GET['id'];
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Dokan Vara Assigned</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
    
    <div class="row">
      <div class="col-md-12">
          <div class="card" id="donorFundAssigned">
            <div class="card-header" style="background-color:#85C1E9">
              <h4 style="text-align:center">Assign Dokan Vara</h4>
            </div>
            <div class="card-body">
              <table style="width: 100%">
                <tbody>
                  <tr>
                    <form method="POST">
                          <table class="table bg-light table-bordered table-sm">
                   <thead>
                         <tr>
                          <th>Shop Owner</th>
                          <th>Particulars</th>
                          <th>Pay Frequency</th>
                          <th>Pay Method</th>
                          <th>Owner Pay Amount</th>
                          <!-- <th>Number of Pay</th> -->
                          <th>Effect Date</th>
                          <th>Terminated Date</th>
                          <th style="width: 100px;">Active Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $disflag = '1';
                        $sql="SELECT id,office_code,`flat_no` FROM `dokan_vara_detail` WHERE `flat_no`='$id'";
                        $query = mysqli_query($conn, $sql);
                        $rowcount = mysqli_num_rows($query);
                        if ($rowcount == '0') {
                            $Sqlinsert = "INSERT INTO  dokan_vara_detail (id,office_code,flat_no, gl_acc_code,fund_type, fund_type_desc, fund_pay_frequency, pay_method, pay_curr, pay_amt, num_of_pay, donner_pay_amt,num_of_paid,allow_flag, effect_date, terminate_date,`ss_creator`,`ss_creator_on`,`ss_org_no`)  select null, `office_code`,`flat_no`,'0','9','Dokan Vara','daily','Fixed','1','0','0','0','0','0','9999-09-09','9999-09-09',`ss_creator`,`ss_created_on`,`ss_org_no` from flat_info where flat_no='$id'";
                            $query = mysqli_query($conn, $Sqlinsert);
                        }
                        $sql = "select dokan_vara_detail.id,dokan_vara_detail.office_code,dokan_vara_detail.flat_no,dokan_vara_detail.fund_type,dokan_vara_detail.fund_type_desc,dokan_vara_detail.fund_pay_frequency,dokan_vara_detail.pay_method,dokan_vara_detail.pay_curr,dokan_vara_detail.pay_amt,dokan_vara_detail.allow_flag,dokan_vara_detail.num_of_pay,dokan_vara_detail.donner_pay_amt,dokan_vara_detail.num_of_paid,dokan_vara_detail.donner_paid_amt,dokan_vara_detail.fund_paid_flag,dokan_vara_detail.last_paid_date,dokan_vara_detail.effect_date,dokan_vara_detail.terminate_date,flat_info.flat_title from dokan_vara_detail,flat_info where flat_info.flat_no=dokan_vara_detail.flat_no and dokan_vara_detail.flat_no='$id'";
                        $query = mysqli_query($conn, $sql);
                        if (!empty($query)) {
                            if (is_array($query) || is_object($query)) {
                                while ($rows = $query->fetch_assoc()) {
                        ?>
                          <tr>
                              <input type="hidden" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                              <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>
                              <input type="hidden" name="fund_type[]" class="form-control" value="<?php echo $rows['fund_type']; ?>" style="width: 100%" readonly>
                              
                              <td style="background-color:powderblue; text-align: left"><strong><?php if ($disflag == 1) {
                                                                                                  echo $rows['flat_title'];
                                                                                                  $disflag = 0;
                                                                                                } else {
                                                                                                  echo "";
                                                                                                } ?></strong>
                              </td>
                              <td>
                                <input type="text" name="fund_type_desc[]" class="form-control" value="<?php echo $rows['fund_type_desc']; ?>" style="width: 100%" readonly>
                              </td>
                              <td>
                                <input type="text" name="fund_pay_frequency[]" class="form-control" value="<?php echo $rows['fund_pay_frequency']; ?>" style="width: 100%" readonly>

                              </td>
                              <td>
                                <input type="text" name="pay_method[]" class="form-control" value="<?php echo $rows['pay_method']; ?>" style="width: 100%" readonly >

                              </td>
                             
                              
                              <td>
                                <input type="text" name="donner_pay_amt[]" class="form-control" value="<?php echo $rows['donner_pay_amt']; ?>" style="width: 100%">
                              </td>
                              <!-- <td>
                                <input type="text" name="num_of_pay[]" class="form-control" value="<?php echo $rows['num_of_pay']; ?>" style="width: 100%">
                              </td> -->
                              <td>
                                <input type="date" name="effect_date[]" class="form-control" value="<?php echo $rows['effect_date']; ?>" style="width: 100%">
                              </td>
                              <td>
                                <input type="date" name="terminate_date[]" class="form-control" value="<?php echo $rows['terminate_date']; ?>" style="width: 100%">
                              </td>
                              <td>
                                <select name="allow_flag[]" id="" class="form-control hh" style="width: 100%">
                                  <option value="1" <?php if ($rows['allow_flag'] == 1) { ?> selected="selected" <?php } ?>>Allow</option>
                                  <option value="0" <?php if ($rows['allow_flag'] == 0) { ?> selected="selected" <?php } ?>>Not Allow</option>
                                </select>
                              </td>
                              <input type="hidden" name="flat_no[]" value="<?php echo $rows['flat_no']; ?>" class="">
                            </tr>
                                <input type="hidden" name="flat_no" value="<?php echo $rows['flat_no']; ?>">
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