<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];

if (isset($_POST['inSubmit'])) {
  $office_code = $_SESSION['office_code'];
  $visit_date = $conn->escape_string($_POST['visit_date']);
  $visitor_name = $conn->escape_string($_POST['visitor_name']);
  $address = $conn->escape_string($_POST['address']);
  $visitor_mobil_no = $conn->escape_string($_POST['visitor_mobil_no']);
  $visit_to_owner = $conn->escape_string($_POST['visit_to_owner']);
  $visit_to_tenant = $conn->escape_string($_POST['visit_to_tenant']);
  $visit_flat_no = $conn->escape_string($_POST['visit_flat_no']);
  $visit_purpose = $conn->escape_string($_POST['visit_purpose']);
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertownerQuery = "INSERT INTO `apart_visitor_info`(`id`,`office_code`,`visit_date`, `visitor_name`, `address`,`visitor_mobil_no`,`visit_to_owner`, visit_to_tenant, `visit_flat_no`,`visit_purpose`,`status`, ss_creator,ss_created_on,ss_org_no) values (NULL,'$office_code','$visit_date','$visitor_name','$address','$visitor_mobil_no','$visit_to_owner','$visit_to_tenant','$visit_flat_no','$visit_purpose','1','$ss_creator','$ss_created_on','$ss_org_no')";

  $conn->query($insertownerQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save owner Successfully!";
  } else {
    $mess = "Failled!";
  }
//   header('refresh:1;visitor_info.php');
 header('location:1;visitor_info.php');

}
?>

<?php
require "../source/top.php";
$pid = 1301000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Visitor (In and Out) Information</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php

  if ($seprt_cs_info == 'Y') { ?>

    <!-- =================-- button define================= -->
    <div>
      <button id="inBtn" class="btn btn-success col-md-3"><i class="fa fa-plus"></i>Entry </button>
      <button id="outBtn" class="btn btn-info col-md-3"><i class="fa fa-plus"></i>Exit</button>
    </div>
    <!-- ====================button Define closed=============== -->
    <div class="row">
      <div class="col-md-12">
        <div>
          <br>
          <!-- In entry -->
          <div id="inForm" class="collapse">
            <div style="padding:5px">
              <!-- form start  -->
              <form action="" method="post">
                <!-- visit date   -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Date and time</label>
                  <div class="col-sm-6">
                    <input type="datetime" class="form-control" id="" name="visit_date" value="<?php date_default_timezone_set("Asia/Dhaka");
                                                                                                echo date("Y-m-d"); ?>" readonly>
                  </div>
                </div>
                <!-- visitor name  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Visitor Name</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="visitor_name" required>
                    <tr>
                      <th width="24%" scope="row"></th>
                      <td><span id="name_availability_status"></span></td>
                    </tr>
                  </div>
                </div>
                <!-- Visitor address  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Address</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="address" required>
                  </div>
                </div>
                <!-- Mobile No.  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Mobile No.</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="visitor_mobil_no" required>
                  </div>
                </div>

                <!-- visit to -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Visit To</label>
                  <div class="col-sm-3">
                    <select name="visit_to_owner" class="form-control" id="visit_to_owner" onchange="vistWithOwner()">
                      <option value="">-owner list-</option>
                      <?php

                      $selectQuery = 'SELECT  owner_id, owner_name FROM apart_owner_info';

                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row_owner = $selectQueryResult->fetch_assoc()) {
                          echo '<option value="' . $row_owner['owner_id'] . '">' . $row_owner['owner_name'] . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <select name="visit_to_tenant" id="visit_to_tenant" class="form-control" onchange="vistWithTenant()">
                      <option value="">-Tenant list-</option>
                      <?php

                      $selectQuery = "SELECT * FROM apart_tenant_info";

                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row_tenant = $selectQueryResult->fetch_assoc()) {
                          echo '<option value="' . $row_tenant['tenant_id'] . '">' . $row_tenant['tenant_name'] . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <!-- Flat No. -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Flat No.</label>
                  <div class="col-sm-6">
                    <input name="visit_flat_no" class="form-control" id="visit_flat_no" required />
                  </div>
                </div>


                <!-- Purpose  -->
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Visit Purpose</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="" name="visit_purpose" required>
                  </div>
                </div>

                <!-- submit  -->
                <div class="form-group row">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" name="inSubmit">Submit</button>
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
              title: "oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
          } else {
          }
          ?>
          <!-- =========Exit Entry======================= -->
          <div class="tile" id="outForm">
            <div class="tile-body">
              <form method="post" name="sarch">
                <h5 style="text-align: center">Exit Entry</h5>
                <table class="table bg-light table-bordered table-sm" id="outListTable">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Visitor Name</th>
                      <th>Address</th>
                      <th>Mobile No.</th>
                      <th>Ref. Owner</th>
                      <th>Visit Purpose.</th>
                      <th>Entry time</th>
                      <th>Exit time</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT apart_visitor_info.id,apart_visitor_info.office_code,apart_visitor_info.visit_date,apart_visitor_info.visitor_name,apart_visitor_info.address, apart_visitor_info.visitor_mobil_no,apart_visitor_info.visit_to_owner,apart_visitor_info.visit_to_tenant, apart_visitor_info.status, apart_owner_info.owner_name, apart_tenant_info.tenant_name,apart_visitor_info.visit_flat_no,apart_visitor_info.visit_purpose,apart_visitor_info.visitor_exit_dtime from apart_visitor_info left outer join apart_owner_info on apart_visitor_info.visit_to_owner=apart_owner_info.owner_id left outer join apart_tenant_info on apart_visitor_info.visit_to_tenant=apart_tenant_info.tenant_id order by apart_visitor_info.status";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?php echo $rows['id']; ?></td>
                        <td><?php echo $rows['visitor_name']; ?></td>
                        <td><?php echo $rows['address']; ?></td>
                        <td><?php echo $rows['visitor_mobil_no']; ?></td>

                        <?php if ($rows['visit_to_tenant'] == 0) {
                        ?>
                          <td>
                            <?php echo $rows['owner_name'] . '<strong>[' . $rows['visit_flat_no'] . ']</strong>' . "<strong> (Owner)</strong>"; ?>
                          </td>
                        <?php
                        } ?>
                        <?php if ($rows['visit_to_owner'] == 0) {
                        ?>
                          <td>
                            <?php echo $rows['tenant_name'] . '<strong>[' . $rows['visit_flat_no'] . ']</strong>' . "<strong> (Tenant)</strong>"; ?>
                          </td>
                        <?php
                        } ?>
                        <td><?php echo $rows['visit_purpose']; ?></td>
                        <td <?php if ($rows['status'] == '0') {
                              echo "style='background-color:red'";
                            } ?>><?php echo $rows['visit_date']; ?></td>
                        <td <?php if ($rows['status'] == '0') {
                              echo "style='background-color:red'";
                            } ?>><?php echo $rows['visitor_exit_dtime']; ?></td>
                        <!-- status -->
                        <td>
                          <?php if ($rows['status'] == '0') {
                          ?>
                            <button class='btn btn-danger btn-lg' style="width: 100px" onclick="exitVisitor('<?php echo $rows['id']; ?>')"><span class='fa fa-arrow-circle-right fa-lg'></span>Enter</button></td>
                      <?php
                          } else {
                      ?>
                        <button class='btn btn-success btn-lg' style="width: 100px" disabled><span class='fa fa-arrow-circle-left fa-lg'></span>Exit</button></td>
                      <?php
                          } ?>

                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </form>
            </div>
            <div>
            </div>
          <?php
        } else {
          echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
        } ?>
          <!-- end of service facility -->
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
  $('#inListTable').DataTable();
  $('#inoutListTable').DataTable();
  $('#outListTable').DataTable();
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#1307000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded');
  });

  $('#inForm').hide();
  $('#outForm').hide();
  $('#inoutListForm').hide();

  // inBtn
  $('#inBtn').on('click', function() {
    $('#inForm').toggle();
    $('#table').toggle();
    $('#inoutListForm').hide();
    $('#outForm').hide();
  });
  // outBtn
  $("#outBtn").click(function() {
    $("#outForm").show();
    $("#inForm").hide();
    $('#inoutListForm').hide();
  });
  // inoutlistBtn
  $('#outForm').show();
  $('#inoutlistBtn').on('click', function() {
    $('#inoutListForm').show();
    $('#inForm').hide();
    $('#outForm').hide();
  });

  // vistWithOwner()
  function vistWithOwner() {
    var owner_id = $('#visit_to_owner').val();
    // alert(owner_id);
    $.ajax({
      type: "POST",
      url: "getOwnerId.php",
      data: {
        owner_id: owner_id
      },
      dataType: "text",
      success: function(response) {
        $('#visit_flat_no').val(response);
        $('#visit_to_tenant').attr('hidden', true);
        // alert(response);
      },
      error: function(response) {
        $('#visit_to_tenant').attr('hidden', false);
      }
    });
  }

  // vistWithTenant()
  function vistWithTenant() {
    var tenant_id = $('#visit_to_tenant').val();
    $.ajax({
      type: "POST",
      url: "getTenantId.php",
      data: {
        tenant_id: tenant_id
      },
      dataType: "text",
      success: function(response) {
        $('#visit_flat_no').val(response);
        $('#visit_to_owner').attr('hidden', true);
        // alert(response);
      },
      error: function(response) {
        $('#visit_to_owner').attr('hidden', false);
      }
    });
  }
  // exit Visitor

  // function exitVisitor(id) {
  //   const url = $(this).attr('href');
  //   alert(url);
  //   swal({
  //     title: 'Are you sure?',
  //     text: 'This record and it`s details will be permanantly deleted!',
  //     icon: 'warning',
  //     buttons: ["Cancel", "Yes!"],
  //   }).then(function(value) {
  //     if (value) {
  //       window.location.href = url;
  //     }
  //   });
  // }

  function exitVisitor(id) {
    if (confirm('Are You Sure Visitor Want to Exit ?')) {
      var visitor_id = id;
      $.ajax({
        type: "POST",
        url: "getExitVisitor.php",
        data: {
          id: visitor_id
        },
        dataType: "text",
        success: function(response) {
          alert('Visitor Exiting Successfully !!');
        },
        error: function(response) {
          alert('ERROR');
        }
      });
    }
  }
</script>
<?php
$conn->close();
?>
</body>

</html>