<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['subBtn'])) {
 $voucher_no =  $_POST['batch_no'];

 $sql = "INSERT INTO `tran_details_reverse` (tran_no, `auto_tran_no`, `office_code`, `year_code`, `batch_no`, `tran_date`, `back_value_date`, `gl_acc_code`, `tran_mode`, `vaucher_type`, `dr_amt_loc`, `cr_amt_loc`, `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no`) select  `tran_no`, `auto_tran_no`, `office_code`, `year_code`, `batch_no`, `tran_date`, `back_value_date`, `gl_acc_code`, `tran_mode`, `vaucher_type`, `dr_amt_loc`, `cr_amt_loc`, '0.00', '0.00', `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`,`exch_rate`,  `description`, 'Y', `rev_tran_no`, 'Y', '1', `verified_by_1`, `verified_date_1`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no` from tran_details  where batch_no='$voucher_no'";
 $conn->query($sql);

$sql2= "DELETE FROM `tran_details` WHERE `batch_no`= '$voucher_no'";
$conn->query($sql2);
$sqlQuery="select member_id,paid_date, paid_amount, from_date from fund_receive_detail where `batch_no`='$voucher_no'";
$selectQueryReuslt = $conn->query($sqlQuery);
$row = $selectQueryReuslt->fetch_assoc();

$member_id = $row['member_id'];
$from_date = $row['from_date'];
$paid_amount = $row['paid_amount'];

$sqlUpdate="update `donner_fund_detail` set `last_paid_date`='$from_date', `donner_paid_amt`=(`donner_paid_amt` -'$paid_amount') where `member_id`='$member_id'";

// $sqlUpdate ="update donner_fun_detail set last_paid_date='$from_date', donner_paid_amt = (donner_paid_amount -'$paid_amount') where member_id='$member_id'";
$conn->query($sqlUpdate);

$sql2="DELETE FROM `fund_receive_detail` WHERE `batch_no`= '$voucher_no'";
$conn->query($sql2);


if ($conn->affected_rows) {
  $message = "Save supp Successfully!";
} else {
  $mess = "Failled!";
}
 header('refresh:1;../bodri_qafela/collection_reverse.php');
}
require '../source/top.php';
$pid = 913000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require '../source/sidebar.php';
require '../source/header.php';
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Collection Reverse</h1>
    </div>
  </div>
  <table>
    <form method="POST">
      <tr>
        <td>
          <input type="number" name="batch_no" id="" class="form-control" placeholder="Input Voucher No">

        </td>
        <td><input type="submit" name="submit" value="submit" class="form-control btn-info"></td>
      </tr>
    </form>
  </table>
  <?php
  if (isset($_POST['submit'])) {
    $batch_no = $_POST['batch_no'];
  ?>
    <form action="" method="post">
      <table class="table table-hover table-bordered table-sm">
        <thead>
          <tr>
            <th>Transaction Number</th>
            <th>Voucher/Batch Number</th>
            <th>Transaction Date</th>
            <th>Transaction Mode</th>
            <th>GL Account Head</th>
            <th>Debit Amount</th>
            <th>Credit Amount</th>
          </tr>
        </thead>
        <tbody>
          <?php
        
          $sql = "SELECT tran_details.tran_no, tran_details.tran_date, tran_details.batch_no, tran_details.tran_mode, tran_details.gl_acc_code, tran_details.dr_amt_loc, tran_details.cr_amt_loc, gl_acc_code.acc_head,fund_receive_detail.from_date,fund_receive_detail.paid_date, donner_fund_detail.donner_paid_amt  FROM `tran_details`, gl_acc_code, fund_receive_detail,donner_fund_detail where  tran_details.gl_acc_code=gl_acc_code.acc_code and fund_receive_detail.batch_no=tran_details.batch_no and fund_receive_detail.member_id=donner_fund_detail.member_id  and fund_receive_detail.paid_upto=donner_fund_detail.last_paid_date and tran_details.batch_no='$batch_no'";
          
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['tran_no'] . '</td>';
            echo '<td>' . $row['batch_no'] . '</td>';
            echo '<td>' . $row['tran_date'] . '</td>';
            echo '<td>' . $row['tran_mode'] . '</td>';
            echo '<td>' . $row['acc_head'] . '</td>';
            echo '<td>' . $row['dr_amt_loc'] . '</td>';
            echo '<td>' . $row['cr_amt_loc'] . '</td>';
           
          
          }
          ?>
        </tbody>
      </table>
  <?php
  $sql = "SELECT * FROM `tran_details` where batch_no='$batch_no'";
  $selectQueryResult = $conn->query($sql);
  $row = $selectQueryResult->fetch_array();
 ?>
 <input type="text" name="batch_no" id="" value="<?php echo $row ['batch_no'];?>" hidden>

      <input type="submit" name="subBtn" value="Reverse Voucher" class="btn btn-info pull-right">
    </form>
  <?php
  } else {
    echo "<h2 style='text-align:center'>Input Our Voucher No</h2>";
  }
  ?>
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
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- table  -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#sampleTable').DataTable();
</script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#dashboard").addClass('active');
  });
  $(document).ready(function() {
    $("#408000").addClass('active');
    $("#400000").addClass('active');
    $("#400000").addClass('is-expanded');
  });
</script>
</body>

</html>