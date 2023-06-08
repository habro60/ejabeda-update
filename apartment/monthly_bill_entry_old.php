<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['submit'])) {

  // $office_code = $conn->escape_string($_SESSION['office_code']);
  // $flat_no = $conn->escape_string($_POST['flat_no']);
  // $flat_area = $conn->escape_string($_POST['flat_area']);
  // $side_of_flat = $conn->escape_string($_POST['side_of_flat']);
  // $building = $conn->escape_string($_POST['building']);
  // $block_no = $conn->escape_string($_POST['block_no']);
  // // $flat_status = $conn->escape_string($_POST['flat_status']);
  // // $status_date = $conn->escape_string($_POST['status_date']);
  // $ss_creator = $_SESSION['username'];
  // $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  // $ss_org_no = $_SESSION['org_no'];

  // $insertData = "INSERT INTO flat_info (office_code, flat_no, flat_area,side_of_flat, building, `block_no`,flat_status, status_date,ss_creator,ss_created_on,ss_modifier,ss_modified_on,ss_org_no) values ('$office_code','$flat_no','$flat_area','$side_of_flat','$building','$block_no','0',now(), '$ss_creator','$ss_created_on','$ss_creator','$ss_created_on','$ss_org_no')";
  // $conn->query($insertData);

  // if ($conn->affected_rows == 1) {
  //   $message = "Save owner Successfully!";
  // } else {
  //   $mess = "Failled!";
  // }
  header('refresh:1;monthly_bill_entry.php');
}

require "../source/top.php";
$pid = 1310000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Monthly Bill Entry </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>


    <!-- ===== button define ====== -->
    <div>
      <button id="flatAddBtn" class="btn btn-success"><i class="fa fa-plus"></i>Input Monthly Bill </button>
      <button id="flatListBtn" class="btn btn-primary"><i class="fa fa-eye"></i>View summ Info. </button>

    </div>
    <!-- ====== button Define closed ====== -->
    <div class="row">
      <div class="col-md-12">
        <div>
          <div id="flatAdd" class="collapse">
            <div style="padding:5px">
        
              <form method="POST">
                   <table class="table bg-light table-bordered table-sm">
                       <thead>
                          <tr>
                              <th>sl. No.</th>
                              <th>Bill For Month</th>
                              <th>Flat Number</th>
                              <th>Charge Name</th>
                              <th>Privious Reading</th>
                              <th>Privious Reading Date</th>
                              <th>Current Reading</th>
                              <th>Current Reading Date</th>
                              <th>Net Unit</th>
                              <th>bill Amount</th>
                              <th>Last Payment Date</th>

                          </tr>
                      </thead>
                   <tbody>
                        <?php
                          $query ="select * from monthly_bill_entry";
                          $return = mysqli_query($conn, $query);
                          $rowcount = mysqli_num_rows($return);
                          
                          if ($rowcount == '0') {

                               $sql="insert into `monthly_bill_entry` (`id`,`office_code`,`owner_id`,`flat_no`,`owner_gl_code`,`bill_charge_code`,`bill_charge_name`, bill_pay_method, link_gl_acc_code, per_unit_rate, fixed_rent,vat_rate) select null,apart_owner_sevice_facility.office_code, apart_owner_sevice_facility.owner_id, apart_owner_sevice_facility.flat_no,apart_owner_info.gl_acc_code,apart_owner_sevice_facility.bill_charge_code, apart_owner_sevice_facility.bill_charge_name, apart_owner_sevice_facility.bill_pay_method, apart_bill_charge_setup.link_gl_acc_code,apart_bill_charge_setup.per_unit_rate,apart_bill_charge_setup.fixed_rent,apart_bill_charge_setup.vat_rate from apart_owner_sevice_facility, apart_bill_charge_setup, apart_owner_info where apart_owner_sevice_facility.bill_charge_code=apart_bill_charge_setup.bill_charge_code and apart_owner_sevice_facility.bill_pay_method='variable' and apart_owner_sevice_facility.owner_id=apart_owner_info.owner_id";
                                $query = mysqli_query($conn, $sql);
                               
                                $viewsql ="select * from monthly_bill_entry";
                        } else

                              {   

                $viewsql ="select * from monthly_bill_entry";
              }
              $no='0';
              $query = $conn->query($viewsql);
              while ($row = $query->fetch_assoc()) {
                $no++;
                echo
                  "<tr>
                         <td>" . $no . "</td>
                         <td>" . $row['bill_for_month'] . "</td>
                         <td>" . $row['flat_no'] . "</td>
                         <td>" . $row['bill_charge_name'] . "</td>
                         <td>" . $row['prev_unit'] . "</td>
                         <td>" . $row['prev_unit_dt'] . "</td>
                         <td>" . $row['curr_unit'] . "</td>
                         <td>" . $row['curr_unit_dt'] . "</td>
                         <td>" . $row['net_unit'] . "</td>
                         <td>" . $row['bill_amount'] . "</td>
                         <td><a target='_blank' href='monthly_bill_edit.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                    </td>
                  </tr>";
              }
              ?>

                <?php 
              
                ?>
       
                 </tbody>
               </table>

                      
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
    <!-- ====== flat View List ====== -->
    <div class="tile" id="flatList">
      <div class="tile-body">
        <h5 style="text-align: center">Summary Info</h5>
        <!-- General Account View start -->
        <table class="table table-hover table-bordered" id="memberTable">
          <thead>
            <tr>
            <th>Bill Month</th>
            <th>Bill Name</th>
              <th>Total Shop/Flat</th>
              <th>Total Bill Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $sql = "SELECT  bill_for_month, bill_charge_name, count(id) as sum_flat, sum(bill_amount) as sum_amt FROM monthly_bill_entry where bill_pay_method='variable' group by bill_charge_code";
            //use for MySQLi-OOP
            $query = $conn->query($sql);
            while ($row = $query->fetch_assoc()) {
              $no++;
              echo
                "<tr>
                       <td>" . $row['bill_for_month'] . "</td>
                       <td>" . $row['bill_charge_name'] . "</td>
                       <td>" . $row['sum_flat'] . "</td>
                       <td>" . $row['sum_amt'] . "</td>
                 
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
    $("#1310000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded')
  });

  $('#flatList').hide();

  // flatAddBtn
  $('#flatAddBtn').on('click', function() {
    $('#flatAdd').show();
    $('#flatList').hide();

  });
  // memberistBtn
  $('#flatListBtn').on('click', function() {
    $('#flatList').show();
    $('#flatAdd').hide();
  });
</script>
<?php
$conn->close();

?>
</body>

</html>