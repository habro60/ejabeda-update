<?php
require "../auth/auth.php";
require "../database.php";

 
if (isset($_POST['assignServices'])) {
    for ($count = 0; $count < count($_POST['member_id']); ++$count) {
    $id = $_POST['id'][$count];
    $member_id = $_POST['member_id'][$count];
    $allow_flag = $_POST['allow_flag'][$count];
    $effect_date = $_POST['effect_date'][$count];
    $donner_pay_amt=$_POST['donner_pay_amt'][$count];
    $num_of_pay=$_POST['num_of_pay'][$count];
    $terminate_date = $_POST['terminate_date'][$count];
    $ss_creator = $_SESSION['username'];
    $ss_creator_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    if ($member_id > 0) {
      $query = "update donner_fund_detail set `allow_flag`='$allow_flag', `donner_pay_amt`='$donner_pay_amt',`num_of_pay`='$num_of_pay',`last_paid_date`='$effect_date',`effect_date`='$effect_date',`terminate_date`='$terminate_date', ss_creator='$ss_creator', ss_creator_on='$ss_creator_on', ss_org_no='$ss_org_no' where id='$id'";
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
echo "<meta http-equiv=\"refresh\" content=\"0;URL=bodri_mem_reg.php\">";
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
  $member_id = $_GET['id'];
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Donor/Member Fund Assigned</h1>
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
              <h4 style="text-align:center">Assign Donor/Member Contribution</h4>
            </div>
            <div class="card-body">
              <table style="width: 100%">
                <tbody>
                  <tr>
                    <form method="POST">
                          <table class="table bg-light table-bordered table-sm">
                   <thead>
                         <tr>
                          <th>Donner</th>
                          <th>fund Name</th>
                          <th>Pay Frequency</th>
                          <th>Pay Method</th>
                          <!-- <th>Pay Amount</th> -->
                          <th>Donner Pay Amount</th>
                          <th>Number of Pay</th>
                          <th>Effect Date</th>
                          <th>Terminated Date</th>
                          <th style="width: 100px;">Active Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $disflag = '1';
                        $sql ="SELECT member_id  FROM donner_fund_detail where member_id='$member_id'";
                        $query = mysqli_query($conn, $sql);
                        $rowcount = mysqli_num_rows($query);
                        if ($rowcount == '0') {
                            $Sqlinsert = "INSERT INTO  donner_fund_detail (office_code,member_id, gl_acc_code,fund_type, fund_type_desc, fund_pay_frequency, pay_method, pay_curr, pay_amt, num_of_pay, donner_pay_amt,num_of_paid,allow_flag, effect_date, terminate_date,`ss_creator`,`ss_creator_on`,`ss_org_no`)  select `office_code`,'$member_id','0',`fund_type`,`fund_type_desc`,`fund_pay_frequency`,`pay_method`,`pay_curr`,`pay_amt`,'0','0','0','0','9999-09-99','9999-99-99',`ss_creator`,`ss_created_on`,`ss_org_no` from fund_type_setup ";
                            $query = mysqli_query($conn, $Sqlinsert);
                        }
                        $sql = "select donner_fund_detail.id,donner_fund_detail.office_code,donner_fund_detail.member_id,donner_fund_detail.fund_type,donner_fund_detail.fund_type_desc,donner_fund_detail.fund_pay_frequency,donner_fund_detail.pay_method,donner_fund_detail.pay_curr,donner_fund_detail.pay_amt,donner_fund_detail.allow_flag,donner_fund_detail.num_of_pay,donner_fund_detail.donner_pay_amt,donner_fund_detail.num_of_paid,donner_fund_detail.donner_paid_amt,donner_fund_detail.fund_paid_flag,donner_fund_detail.last_paid_date,donner_fund_detail.effect_date,donner_fund_detail.terminate_date,fund_member.full_name from donner_fund_detail,fund_member where fund_member.member_id=donner_fund_detail.member_id and donner_fund_detail.member_id='$member_id'";
                        $query = mysqli_query($conn, $sql);
                        if (!empty($query)) {
                            if (is_array($query) || is_object($query)) {
                                while ($rows = $query->fetch_assoc()) {
                        ?>
                          <tr>
                              <input type="hidden" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                          
                                <input type="hidden" name="pay_amt[]" class="form-control" value="<?php echo $rows['pay_amt']; ?>" style="width: 100%" readonly>
                              
                              <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>
                              <input type="hidden" name="fund_type[]" class="form-control" value="<?php echo $rows['fund_type']; ?>" style="width: 100%" readonly>
                              
                              <td style="background-color:powderblue; text-align: left"><strong><?php if ($disflag == 1) {
                                                                                                  echo $rows['full_name'];
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
                                <input type="text" name="pay_method[]" class="form-control" value="<?php echo $rows['pay_method']; ?>" style="width: 100%" readonly>

                              </td>
                             
                             
                              <td>
                                <input type="text" name="donner_pay_amt[]" class="form-control" value="<?php echo $rows['donner_pay_amt']; ?>" style="width: 100%">
                              </td>
                              <td>
                                <input type="text" name="num_of_pay[]" class="form-control" value="<?php echo $rows['num_of_pay']; ?>" style="width: 100%">
                              </td>
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
                              <input type="hidden" name="member_id[]" value="<?php echo $rows['member_id']; ?>" class="">
                            </tr>
                                <input type="hidden" name="member" value="<?php echo $rows['member_id']; ?>">
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