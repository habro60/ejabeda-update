<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
$pid = 1305000;
$seprt_cs_info = $_SESSION['seprt_cs_info'];
$role_no = $_SESSION['sa_role_no'];

// auth_page($conn,$pid,$role_no);
$querys = "insert into bach_no (username) values ('$_SESSION[username]')";
$returns = mysqli_query($conn, $querys);
$lastRows = $conn->insert_id;
$regular_pay_flag='0';
// $bill_for_month=$_POST['bill_for_month'];

if (isset($_POST['submit'])) {
   
  $bill_pay_method1= $_POST['bill_pay_method1'];
  $bill_for_month= $_POST['bill_for_month1'];
  $bill_process_date =  $_POST['bill_date1'];
  $bill_date = $_POST['bill_date1'];
  $bill_last_pay_date = $_POST['bill_last_pay_date1'];
  $ss_org_no = $_SESSION['ss_org_no'];

// =============Fixed Bill============
  if ($bill_pay_method1 =='fixed') {
      // $bill_for_month= $_POST['bill_for_month1'];
      // $bill_process_date =  $_POST['bill_date1'];
      // $bill_date = $_POST['bill_date1'];
      // $bill_last_pay_date = $_POST['bill_last_pay_date1'];
      $ss_org_no = $_SESSION['ss_org_no'];

      $query1="INSERT INTO apart_owner_bill_detail (`id`,`office_code`,`owner_id`,`flat_no`, bill_for_month, bill_date,`bill_charge_code`,`bill_charge_name`,bill_last_pay_date,`pay_method`,`pay_curr`,`bill_amount`,`owner_gl_code`,`link_gl_acc_code`,bill_process_date, batch_no, bill_paid_flag,regular_pay_flag,prev_unit,curr_unit,net_unit,`ss_creator`,`ss_created_on`,ss_org_no ) SELECT null, office_code,owner_id,flat_no, '$bill_for_month', '$bill_date', bill_charge_code,bill_charge_name,'$bill_last_pay_date', 'Fixed', pay_curr, bill_fixed_amt,gl_acc_code,link_gl_acc_code, '$bill_date', '$lastRows', '0','0', '0','0','0', 'admin','$bill_process_date','$ss_org_no' FROM bill_detail_view ";
      echo $query1;
      exit;
      $conn->query($query1);

      $ss_org_no = $_SESSION['ss_org_no'];
      $bill_process_date1 =  $_POST['bill_date1'];
      $insertBill = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `cr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) select null,apart_owner_bill_detail.office_code, year(apart_owner_bill_detail.ss_created_on), '$lastRows','$bill_process_date1', apart_owner_bill_detail.link_gl_acc_code, 'Bill','CR', concat(',', apart_owner_bill_detail.bill_charge_name,'  for  ', date_format(apart_owner_bill_detail.bill_date, '%M %Y')), sum(apart_owner_bill_detail.bill_amount), apart_owner_bill_detail.ss_creator, apart_owner_bill_detail.ss_created_on,apart_owner_bill_detail.ss_org_no from apart_owner_bill_detail where apart_owner_bill_detail.bill_for_month = '$bill_for_month' and apart_owner_bill_detail.pay_method='Fixed' group by apart_owner_bill_detail.bill_charge_code order by apart_owner_bill_detail.bill_charge_code";

    //   echo $insertBill;
    //   exit;
      $conn->query($insertBill);
      if ($conn->affected_rows == '1') {
        $message = "cr Save Successfully!!";
      }
    
      $insertOwner = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `dr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) select null,apart_owner_bill_detail.office_code, year(apart_owner_bill_detail.ss_created_on), '$lastRows', '$bill_process_date1', apart_owner_bill_detail.owner_gl_code, 'Bill','DR', concat(',', 'Bill and Charge','  for  ',date_format(apart_owner_bill_detail.bill_date,'%M %Y')), sum(apart_owner_bill_detail.bill_amount), apart_owner_bill_detail.ss_creator, apart_owner_bill_detail.ss_created_on, apart_owner_bill_detail.ss_org_no from apart_owner_bill_detail where apart_owner_bill_detail.bill_for_month = '$bill_for_month' and apart_owner_bill_detail.pay_method='Fixed' group by apart_owner_bill_detail.owner_gl_code order by apart_owner_bill_detail.owner_gl_code";
      
      $conn->query($insertOwner);
      if ($conn->affected_rows == 1) {
        $message = "cr Save Successfully!!";
      }




  } else 
  
  // ====================Vraiable Bill==================
  
  {
    $query2="INSERT INTO apart_owner_bill_detail (`id`,`office_code`,`owner_id`,`flat_no`, bill_for_month, bill_date,`bill_charge_code`,`bill_charge_name`,`pay_method`,`pay_curr`,prev_unit, curr_unit, net_unit,`bill_amount`,`owner_gl_code`,`link_gl_acc_code`,bill_process_date, batch_no, bill_paid_flag) 

    SELECT null, office_code,owner_id,flat_no,  '$bill_for_month', '$bill_date', bill_charge_code,bill_charge_name, 'variable', pay_curr, prev_unit, curr_unit,net_unit, bill_amount, owner_gl_code, link_gl_acc_code, '$bill_process_date', '$lastRows', '0'  FROM  monthly_bill_entry where bill_for_month='$bill_for_month'";
     $conn->query($query2);


     $bill_process_date1 =  $_POST['bill_date1'];
     $insertBill = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `cr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) select null,apart_owner_bill_detail.office_code, year(apart_owner_bill_detail.ss_created_on), '$lastRows','$bill_process_date1', apart_owner_bill_detail.link_gl_acc_code, 'Bill','CR', concat(',', apart_owner_bill_detail.bill_charge_name,'  for  ', date_format(apart_owner_bill_detail.bill_date, '%M %Y')), sum(apart_owner_bill_detail.bill_amount), apart_owner_bill_detail.ss_creator, apart_owner_bill_detail.ss_created_on, apart_owner_bill_detail.ss_org_no from apart_owner_bill_detail where apart_owner_bill_detail.bill_for_month = '$bill_for_month' and apart_owner_bill_detail.pay_method='variable' group by apart_owner_bill_detail.bill_charge_code order by apart_owner_bill_detail.bill_charge_code";
   
     $conn->query($insertBill);
     if ($conn->affected_rows == '1') {
       $message = "cr Save Successfully!!";
     }
   
     $insertOwner = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `dr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) select null,apart_owner_bill_detail.office_code, year(apart_owner_bill_detail.ss_created_on), '$lastRows', '$bill_process_date1', apart_owner_bill_detail.owner_gl_code, 'Bill','DR', concat(',', 'Bill and Charge','  for  ',date_format(apart_owner_bill_detail.bill_date,'%M %Y')), sum(apart_owner_bill_detail.bill_amount), apart_owner_bill_detail.ss_creator, apart_owner_bill_detail.ss_created_on, apart_owner_bill_detail.ss_org_no from apart_owner_bill_detail where apart_owner_bill_detail.bill_for_month = '$bill_for_month' and apart_owner_bill_detail.pay_method='variable' group by apart_owner_bill_detail.owner_gl_code  order by apart_owner_bill_detail.owner_gl_code";
     
     $conn->query($insertOwner);
     if ($conn->affected_rows == 1) {
       $message = "cr Save Successfully!!";
     }
  }
  
      // echo $query;
      // exit;
 
      // $conn->query($query);
      if ($conn->affected_rows == TRUE) {
        $message = "Successfully";
      } 
     else {
      $assign_failled = "Failled";
    }
  // =========================End Insert=============
 



  header('refresh:1;owner_mth_bill_process_2.php');
  echo "<meta http-equiv=\"refresh\" content=\"0;URL=owner_mth_bill_process_2.php\">";
 } 

require '../source/sidebar.php';
require '../source/header.php';
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Monthly Bill Process</h1>
    </div>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>
    <div class="container">
      <!-- ====== button define====== -->
      <table>
        <tbody>
          <td>
            <button id="fixedBillBtn" class="btn btn-success"><i class="fa fa-plus"></i>Fixed Bill Process</button>
          </td>
          <td>
            <button id="variableBillBtn" class="btn btn-primary"><i class="fa fa-eye"></i>Variable Bill Process</button>
          </td>
        </tbody>
      </table>
      <!-- =======button Define closed=====-->
      <div class="tile" id="fixedBill">
        <div class="card">
          <div class="card-header" style="background-color:#85C1E9">
            <h4 style="text-align:center"> Fixed Bill Process</h4>
          </div>
          <table class="table bg-light table-bordered table-sm">
            <thead>
              <tr>
                <th>Fixed Bill/Charge Name</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "select apart_bill_charge_setup.bill_pay_method,apart_bill_charge_setup.bill_charge_name from apart_bill_charge_setup where apart_bill_charge_setup.bill_pay_method='Fixed'";
              $query = mysqli_query($conn, $sql);
              while ($rows = $query->fetch_assoc()) {
              ?>
                <tr>
                  <td>
                    <input type="text" name="bill_charge_name[]" class="form-control" value="<?php echo $rows['bill_charge_name']; ?>" style="width: 100%" readonly>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- fixed bill query -->
        <table class="table bg-light table-bordered table-sm">
          <th><label for="">Month </label> <span id="checkmth_status"> </span></th>
          <th><label for="">Process Date </label> <span id="checkdate_status"></span></th>
          <th><label for="">Last Payment Date </label> <span id="checkpaydate_status"></span></th>
          <th>
            <tbody>
              <form method="POST">
                <div class="search-box">
                  <tr>
                    <td>
                      <input type="month" name="bill_for_month" class="form-control" id="Fmth" onBlur="FmonthCheck()" placeholder="mm/yyyy" reruired>
                    </td>
                    <td>
                      <input type="date" name="bill_da" class="form-control" id="Fbilldate" onBlur="FcheckDate()" placeholder="mm/dd/yyyy" required>
                    </td>
                    <td>
                      <input type="date" name="bill_last_pay_date" class="form-control" id="Fpaydate" onchange="FcheckPayDate()" placeholder="mm/dd/yyyy" required>
                    </td>
                    <td><input class="btn btn-info" style="width: 100%" id="search" onclick="fixedBill()" value="Search Bill" readonly></td>
                  </tr>
                </div>
              </form>
            </tbody>
        </table>
        <div id="fixed_bill_result">
          fixed bill result
        </div>
        <?php
        // }
        ?>
      </div>
      <!-- variable -->
      <div id="variableBill">
        <div class="card">
          <div class="card-header" style="background-color:#85C1E9">
            <h4 style="text-align:center"> Variable Process</h4>
          </div>
          <!-- =====Display Fixed Bill/Charge name ====  -->
          <table class="bordered" style="width:100%">
            <thead>
              <tr>
                <th> Variable Bill/Charge Name</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "select apart_bill_charge_setup.bill_pay_method,apart_bill_charge_setup.bill_charge_name from apart_bill_charge_setup where apart_bill_charge_setup.bill_pay_method='variable'";
              $query = mysqli_query($conn, $sql);
              while ($rows = $query->fetch_assoc()) {
              ?>
                <tr>
                  <td>
                    <input type="text" name="bill_charge_name[]" class="form-control" value="<?php echo $rows['bill_charge_name']; ?>" style="width: 100%" readonly>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
          <!-- ========== Start Varable Bill / Charge Process  ========  -->
          <table class="table bg-light table-bordered table-sm">
            <th><label for="">Month </label> <span id="checkmth_status"> </span></th>
            <th><label for="">process Date </label> <span id="checkdate_status"></span></th>
            <th><label for="">Payment Date </label> <span id="checkpaydate_status"></span></th>
            <th>
              <tbody>
                <form method="POST">
                  <div class="search-box">
                    <tr>
                      <td>
                        <input type="month" name="bill_for_month2" class="form-control" id="Fmth2" onBlur="FmonthCheck2()" value="" placeholder="mm/yyyy" reruired>
                      </td>
                      <td>
                        <input type="date" name="bill_dat2" class="form-control" id="Fbilldate2" onBlur="FcheckDate2()" value="" placeholder="mm/dd/yyyy" required>
                      </td>
                      <td>
                        <input type="date" name="bill_last_pay_date2" class="form-control" id="Fpaydate2" onchange="FcheckPayDate2()" value="" placeholder="mm/dd/yyyy" required>
                      </td>
                      <td><input class="btn btn-info" style="width: 100%" id="search2" onclick="variableBill()" value="Search Bill" readonly></td>
                    </tr>
                  </div>
                </form>
              </tbody>
          </table>
          <!-- </div> -->
          <?php
          if (!empty($_POST['bill_for_month']) && $_POST['bill_for_month'] <= $_POST['bill_date']) {
          }
          ?>
          <div id="variable_bill_result">
            variable bill result
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
    <?php
  } else {
    echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
  } ?>
    </div>
    </div>
    </div>
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
    $("#1305000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded');
  });
</script>
<script type="text/javascript">
  $('#variableBill').hide();
  // Fixed Bill Process
  $('#variableBillBtn').on('click', function() {
    $('#fixedBill').hide();
    $('#variableBill').show();
  });

  // variable Bill process
  $('#fixedBillBtn').on('click', function() {
    $('#fixedBill').show();
    $('#variableBill').hide();
  });
</script>
<script>
  // fixed_bill_result

  function fixedBill(fmth) {
    var Fmth = $("#Fmth").val();
    var Fbilldate = $("#Fbilldate").val();
    var Fpaydate = $("#Fpaydate").val();

    $.ajax({
      url: 'getFixedBill_2.php',
      method: 'POST',
      dataType: 'text',
      data: {
        bill_for_month: Fmth,
        bill_last_pay_date: Fpaydate,
        bill_date: Fbilldate
      },
      success: function(response) {
        $("#fixed_bill_result").html(response);
      }
    });
  }

  function variableBill() {
    var Fmth = $("#Fmth2").val();
    var Fbilldate = $("#Fbilldate2").val();
    var Fpaydate = $("#Fpaydate2").val();
    $.ajax({

      url: 'getVariableBill_2.php',
      method: 'POST',
      dataType: 'text',
      data: {
        bill_for_month: Fmth,
        bill_last_pay_date: Fpaydate,
        bill_date: Fbilldate
      },
      success: function(response) {
        $("#variable_bill_result").html(response);
      }
    });
  }

  function FmonthCheck() {

    $("#loaderIcon").show();
    jQuery.ajax({
      url: "../common/check_availability.php",
      data: 'Fmth=' + $("#Fmth").val(),
      type: "POST",
      success: function(data) {
        if (data == 5) {
          $("#checkmth_status").html("<span style='color:red'>(This month bill  Already process)</span>");
          $("#Fbilldate").attr("disabled", true);
          $("#Fpaydate").attr("disabled", true);
          $("#search").attr("disabled", true);
        } else {
          $("#checkmth_status").html(data);
          $("#Fbilldate").attr("disabled", false);
          $("#Fpaydate").attr("disabled", false);
          $("#search").attr("disabled", false);
        }
        $("#loaderIcon").hide();
      },
      error: function() {}
    });
  }

  function FcheckDate() {
    $("#loaderIcon").show();
    jQuery.ajax({
      url: "../common/check_availability.php",
      data: 'Fbilldate=' + $("#Fbilldate").val(),
      type: "POST",
      success: function(data) {
        $("#checkdate_status").html(data);
        $("#loaderIcon").hide();
      },
      error: function() {}
    });
  }

  function FcheckPayDate() {
      var Fbilldate = $("#Fbilldate").val();
      var Fpaydate = $("#Fpaydate").val();
      var search = $("#search").val();
      if (Fbilldate > Fpaydate){
      $("#search").attr("disabled", true);
      $("#Fpaydate").css({
        "color": "red",
        "border": "2px solid red"
      });
    } else {
         $("#search").attr("disabled", false);
      $("#Fpaydate").css({
        "color": "black",
        "border": "2px solid gray"
      });
    }
    if (Fbilldate==false){
        alert("System Error!! Input Right Date");
          $("#Fbilldate").css({
        "color": "red",
        "border": "2px solid red"
      });
    }else {
         $("#Fbilldate").css({
        "color": "black",
        "border": "2px solid gray"
      });
    }
    $("#loaderIcon").show();
    jQuery.ajax({
      url: "../common/check_availability.php",
      data: 'Fpaydate=' + $("#Fpaydate").val(),
      type: "POST",
      success: function(data) {
        $("#checkpaydate_status").html(data);
        $("#loaderIcon").hide();
      },
      error: function() {}
    });
  }
  
//

    function FcheckPayDate2() {
      var Fbilldate2 = $("#Fbilldate2").val();
      var Fpaydate2 = $("#Fpaydate2").val();
      var search2 = $("#search2").val();
      if (Fbilldate2 > Fpaydate2){
      $("#search2").attr("disabled", true);
      $("#Fpaydate2").css({
        "color": "red",
        "border": "2px solid red"
      });
    } else {
         $("#search2").attr("disabled", false);
      $("#Fpaydate2").css({
        "color": "black",
        "border": "2px solid gray"
      });
    }
     if (Fbilldate2==false){
        alert("System Error!! Input Right Date");
          $("#Fbilldate2").css({
        "color": "red",
        "border": "2px solid red"
      });
    }else {
         $("#Fbilldate2").css({
        "color": "black",
        "border": "2px solid gray"
      });
    }
    }
  function VmonthCheck() {
    $("#loaderIcon").show();
    jQuery.ajax({
      url: "../common/check_availability.php",
      data: 'Vmth=' + $("#Vmth").val(),
      type: "POST",
      success: function(data) {
        if (data == 5) {
          $("#checkmth_status").html("<span style='color:red'>(This month bill  Already process)</span>");
          $("#Vbilldate").attr("disabled", true);
          $("#Vpaydate").attr("disabled", true);
          $("#search").attr("disabled", true);
        } else {
          $("#checkmth_status").html(data);
          $("#Vbilldate").attr("disabled", false);
          $("#Vpaydate").attr("disabled", false);
          $("#search").attr("disabled", false);
        }
        $("#loaderIcon").hide();
      },
      error: function() {}
    });
  }

  function VcheckDate() {
    $("#loaderIcon").show();
    jQuery.ajax({
      url: "../common/check_availability.php",
      data: 'Vbilldate=' + $("#Vbilldate").val(),
      type: "POST",
      success: function(data) {
        $("#checkdate_status").html(data);
        $("#loaderIcon").hide();
      },
      error: function() {}
    });
  }

  function VcheckPayDate() {
    $("#loaderIcon").show();
    jQuery.ajax({
      url: "../common/check_availability.php",
      data: 'Vpaydate=' + $("#Vpaydate").val(),
      type: "POST",
      success: function(data) {
        $("#checkpaydate_status").html(data);
        $("#loaderIcon").hide();
      },
      error: function() {}
    });
  }
</script>
</body>

</html>