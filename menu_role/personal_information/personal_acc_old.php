<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['submit'])) {

  $office_code = $conn->escape_string($_SESSION['office_code']);
  $owner_id = $_SESSION['link_id'];
  $acc_head = $conn->escape_string($_POST['acc_head']);
  $category_code = $conn->escape_string($_POST['category_code']);

  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertData = "INSERT INTO personal_account (office_code, owner_id, acc_head,curr_code,category_code,rec_status,active,ss_creator, ss_created_on,ss_modifier,ss_modified_on,ss_org_no) values('$office_code','$owner_id', '$acc_head', 'BDT','$category_code','1','1','$ss_creator','$ss_created_on','$ss_creator','$ss_created_on',
    '$ss_org_no')";

    // echo $insertData;
    // exit;

  //      
  $conn->query($insertData);

  if ($conn->affected_rows == 1) {
    $message = "Save owner Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:1;personal_acc.php');
}

require "../source/top.php";
$pid = 1319000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> A/C Create</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>


    <!-- ===== button define ====== -->
    <div>
      <button id="accAddBtn" class="btn btn-success"><i class="fa fa-plus"></i>A/C Create</button>
      <button id="accListBtn" class="btn btn-primary"><i class="fa fa-eye"></i>View A/C List</button>
    </div>
    <!-- ====== button Define closed ====== -->
    <div class="row">
      <div class="col-md-12">
        <div>
          <div id="accAdd" class="collapse">
            <div style="padding:5px">
              <!-- form start  -->
              <form method="post">
                <!-- ======= Office Code ======-->
                <div class="form-row form-group">
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-header">
                        Setup A/C
                      </div>
                      <div class="card-body">
                        
                        <!---======Acc Code=======-->
                        <!-- <div class="form-group row">
                          <label class="col-sm-5 col-form-label">A/C Code</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="acc_code">
                          </div>
                        </div> -->
                        <!---======Acc Description=====--->
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Name</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="acc_head">
                          </div>
                        </div>
                          <!-- -======Acc Category=======--> 
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">A/C Category</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                          <select name="category_code" class="form-control select2">
                                    <option value="1">Cash</option>
                                    <option value="2">Bank</option>
                                    <option value="3">Income</option>
                                     <option value="4">Expenses</option>
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
    <!-- ====== Acc View List ====== -->
    <div class="tile" id="accList">
      <div class="tile-body">
        <h5 style="text-align: center">Account List </h5>
        <!-- General Account View start -->
        <table class="table table-hover table-bordered" id="memberTable">
          <thead>
            <tr>
              <th>Account Code</th>
              <th>Accout Name</th>
              <th>Accout Category</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 0;
            $owner_id = $_SESSION['link_id'];
            $sql = "SELECT id, office_code, owner_id, acc_head,category_code  from personal_account where owner_id= $owner_id";
             //use for MySQLi-OOP
            $query = $conn->query($sql);
            while ($row = $query->fetch_assoc()) {
              $no++;
              echo
                "<tr>
                       <td>" . $row['id'] . "</td>
                       <td>" . $row['acc_head'] . "</td>
                       <td>" . $row['category_code'] . "</td>
                       
                       <td><a target='_blank' href='personal_acc_edit.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
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
    $("#1310000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded')
  });

  $('#accList').hide();

  // accAddBtn
  $('#accAddBtn').on('click', function() {
    $('#accAdd').show();
    $('#accList').hide();

  });
  // memberistBtn
  $('#accListBtn').on('click', function() {
    $('#accList').show();
    $('#accAdd').hide();
  });
</script>
<?php
$conn->close();

?>
</body>

</html>