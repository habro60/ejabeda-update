<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['submit'])) {

  $office_code = $_SESSION['office_code'];
  $effect_date = $conn->escape_string($_POST['effect_date']);
  $fund_type = $conn->escape_string($_POST['fund_type']);
  $fund_type_desc = $conn->escape_string($_POST['fund_type_desc']);
  $fund_pay_frequeny = $conn->escape_string($_POST['fund_pay_frequeny']);
  $pay_method = $conn->escape_string($_POST['pay_method']);
  $pay_amt = $conn->escape_string($_POST['pay_amt']);
  $pay_curr = $conn->escape_string($_POST['pay_curr']);
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertData = "INSERT INTO fund_type_setup (office_code, effect_date, fund_type, fund_type_desc, fund_pay_frequency,pay_method,pay_curr, pay_amt,is_current,ss_creator,ss_created_on,ss_modifier,ss_modified_on,ss_org_no) values ('$office_code','$effect_date','$fund_type','$fund_type_desc','$fund_pay_frequeny','$pay_method','$pay_curr', '$pay_amt','1','$ss_creator','$ss_created_on','','$ss_created_on','$ss_org_no')";

  // echo $insertData;
  // exit;
  
  $conn->query($insertData);
  if ($conn->affected_rows == 1) {
    $message = "Save owner Successfully!";
  } else {
    $mess = "Failled!";
  }

  $selectCharge = "SELECT * FROM donner_fund_detail  WHERE `fund_type`='$fund_type';";
  $ResultCharge = $conn->query($selectCharge);
  // $data = $ResultCharge->fetch_assoc();
  $data_num = mysqli_num_rows($ResultCharge);
  if ($data_num == 0) {
      $insertData = "INSERT INTO  donner_fund_detail (office_code,member_id, gl_acc_code,fund_type, fund_type_desc, fund_pay_frequency, pay_method, pay_curr, pay_amt, num_of_pay, donner_pay_amt,num_of_paid,allow_flag, effect_date, terminate_date,`ss_creator`,`ss_creator_on`,`ss_org_no`)  select fund_member.office_code,fund_member.member_id,fund_member.gl_acc_code,fund_type_setup.fund_type,fund_type_setup.fund_type_desc,fund_type_setup.fund_pay_frequency,fund_type_setup.pay_method,fund_type_setup.pay_curr,fund_type_setup.pay_amt,'0','0','0','0','9999-09-99','9999-99-99',fund_type_setup.ss_creator,fund_type_setup.ss_created_on,fund_type_setup.ss_org_no from fund_type_setup,fund_member where fund_type='$fund_type'";
      $conn->query($insertData);
  } else {
  }


  header('refresh:1;bodri_fund_setup.php');
}

require "../source/top.php";
$pid = 1005000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Fund Type Setup</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>


    <!-- =================-- button define================= -->
    <div>
      <button id="memberAddBtn" class="btn btn-success col-md-6><i class=" fa fa-plus"></i>Fund Type</button>
      <button id="memberListBtn" class="btn btn-primary col-md-6><i class=" fa fa-eye"></i> Fund List </button>
    </div>
    <!-- ====================button Define closed=============== -->

    <div class="row">
      <div class="col-md-12">
        <div>
          <br>
          <div id="memberForm" class="collapse">
            <div style="padding:5px">
              <!-- form start  -->
              <form action="" method="post">
                <!-- =====Office Code ======-->
                <div class="form-row form-group">
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-header">
                        defination
                      </div>
                      <div class="card-body">
                        
                        <!---------================Fund Type=========------>
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Fund Type</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="fund_type">
                          </div>
                        </div>
                        <!---------======= Fund Type Description =====----->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Fund Type Name</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="fund_type_desc">
                          </div>
                        </div>
                        <!-----==== Effect Date =========----->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Effect Date.</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="date" class="form-control" id="" name="effect_date">
                          </div>
                        </div>
                        <!------------------------------------------->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Fund Pay Frequency</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <select name="fund_pay_frequeny" class="form-control select2">
                              <option value="Daily">Daily</option>
                              <option value="Weekly">Weekly</option>
                              <option value="Monthly">Monthly</option>
                              <option value="Quarterly">Quarterly</option>
                              <option value="halfYearly">Half Yearly</option>
                              <option value="Yearly">Yearly</option>
                              <option value="On Demand">On Demand</option>
                            </select>
                          </div>
                        </div>
                        <!--------------Fund pay Method ======----------------------------->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Fund Pay Method</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <select name="pay_method" class="form-control fundPayMethod">
                              <option value="percentage ">Percentage</option>
                              <option value="fixed">Fixed</option>
                              <option value="variable">Variable</option>
                            </select>
                          </div>
                        </div>

                        <!-- ===============Pay currency ========================== -->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Currency</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <select name="pay_curr" class="form-control select4">
                              <?php
                              $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "CURR" AND `softcode`>0';
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

                        <!-- ===============bill_fixed_amt==============================-->
                        <div class="form-group row" id="payAmount">
                          <label class="col-sm-5 col-form-label">Pay Amount.</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control pay_amt" name="pay_amt" require>
                          </div>
                        </div>
                        <div>
                          <input type="hidden" name="activation_key" value="0">
                          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                      </div>
                    </div>

                  </div>
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
    <!--============ member View List=========-->
    <div id="table">
      <div class="tile" id="memberListForm">
        <div class="tile-body">
          <h5 style="text-align: center">Fund List</h5>
          <!-- General Account View start -->
          <table class="table table-hover table-bordered" id="memberTable">
            <thead>
              <tr>
                <th>Sl.No.</th>
                <th>Office Code</th>
                <th>Fund Type</th>
                <th>Effect Date</th>
                <th> Fund Pay Freqency</th>
                <th> Pay Method</TH>
                <th>Currency.</th>
                <th>Pay Amt.</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT fund_type_setup.id,fund_type_setup.office_code,fund_type_setup.effect_date, fund_type_setup.`fund_type`,fund_type_setup.`fund_type_desc`,fund_type_setup.`fund_pay_frequency`,fund_type_setup.`pay_method`,fund_type_setup.`pay_curr`,fund_type_setup.pay_amt, code_master.hardcode, code_master.softcode,code_master.description FROM `fund_type_setup`, code_master where fund_type_setup.pay_curr=code_master.softcode and code_master.hardcode='CURR'";

              //use for MySQLi-OOP
              $query = $conn->query($sql);
              while ($row = $query->fetch_assoc()) {
                echo
                  "<tr>
                       <td>" . $row['id'] . "</td>
                       <td>" . $row['office_code'] . "</td>
                       <td>" . $row['fund_type_desc'] . "</td>
                       <td>" . $row['effect_date'] . "</td>
                       <td>" . $row['fund_pay_frequency'] . "</td>
                       <td>" . $row['pay_method'] . "</td>
                       <td>" . $row['description'] . "</td>
                       <td>" . $row['pay_amt'] . "</td>
                  <td><a target='_blank' href='bodri_fund_setup_edit.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                  </td>
								</tr>";
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
    $("#907000").addClass('active');
    $("#900000").addClass('active');
    $("#900000").addClass('is-expanded')
  });

  $('#memberListForm').hide();

  // memberAddBtn
  $('#memberAddBtn').on('click', function() {
    $('#memberForm').show();
    $('#memberListForm').hide();

  });
  // memberistBtn
  $('#memberListBtn').on('click', function() {
    $('#memberListForm').show();
    $('#memberForm').hide();
  });
  
</script>


<?php
$conn->close();

?>
</body>

</html>