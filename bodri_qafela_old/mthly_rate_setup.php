<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['submit'])) {

  $office_code = $_SESSION['office_code'];
  $rate_date = $conn->escape_string($_POST['rate_date']);
  $month_name = $conn->escape_string($_POST['month_name']);
  $rate_amt = $conn->escape_string($_POST['rate_amt']);
  $pay_curr = $conn->escape_string($_POST['pay_curr']);
  $is_current = "1";
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertData = "INSERT INTO mthly_rate_setup (office_code, rate_date, month_name, rate_amt, pay_curr,is_current,ss_creator,ss_created_on,ss_modifier,ss_modified_on,ss_org_no) values ('$office_code','$rate_date','$month_name','$rate_amt','$pay_curr', '$is_current','$ss_creator','$ss_created_on','','$ss_created_on','$ss_org_no')";
//   echo $insertData;
//   exit;
  $conn->query($insertData);
  if ($conn->affected_rows == 1) {
    $message = "Save owner Successfully!";
  } else {
    $mess = "Failled!";
  }


  header('refresh:1;mthly_rate_setup.php');
}

require "../source/top.php";
$pid = 914000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Monthly Chanda Rate Setup</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>


    <!-- =================-- button define================= -->
    <div>
      <button id="memberAddBtn" class="btn btn-success col-md-6><i class=" fa fa-plus"></i>Chanda Rate</button>
      <button id="memberListBtn" class="btn btn-primary col-md-6><i class=" fa fa-eye"></i> Chanda Rate List </button>
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
                        
                        
                        <!-----==== Rate date =========----->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Date of Month.</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="date" class="form-control" id="" name="rate_date">
                          </div>
                        </div>
                        <!------------------------------------------->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Month Name</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <select name="month_name" class="form-control select2">
                              <option value="January">January</option>
                              <option value="February">February</option>
                              <option value="March">March</option>
                              <option value="April">April</option>
                              <option value="May">May</option>
                              <option value="June">June</option>
                              <option value="July">July</option>
                              <option value="August">August</option>
                              <option value="September">September</option>
                              <option value="October">October</option>
                              <option value="November">November</option>
                              <option value="December">December</option>
                            </select>
                          </div>
                        </div>
                        <!-- ===============Rate Amount==============================-->
                        <div class="form-group row" id="payAmount">
                          <label class="col-sm-5 col-form-label">Rate Amount.</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control rate_amt" name="rate_amt" require>
                          </div>
                        </div>

                        <!-- ===============currency ========================== -->
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
                <th>Date of Month</th>
                <th>month</th>
                <th>Currency.</th>
                <th>Rate Amt.</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT mthly_rate_setup.id,mthly_rate_setup.office_code,mthly_rate_setup.rate_date, mthly_rate_setup.month_name,mthly_rate_setup.rate_amt, code_master.hardcode, code_master.softcode,code_master.description FROM `mthly_rate_setup`, code_master where mthly_rate_setup.pay_curr=code_master.softcode and code_master.hardcode='CURR'";

              //use for MySQLi-OOP
              $query = $conn->query($sql);
              while ($row = $query->fetch_assoc()) {
                echo
                  "<tr>
                       <td>" . $row['id'] . "</td>
                       <td>" . $row['office_code'] . "</td>
                       <td>" . $row['rate_date'] . "</td>
                       <td>" . $row['month_name'] . "</td>
                       <td>" . $row['description'] . "</td>
                       <td>" . $row['rate_amt'] . "</td>
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