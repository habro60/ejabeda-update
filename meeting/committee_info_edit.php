<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['editSubmit'])) {
  $id = intval($_GET['id']);
  $office_code = $conn->escape_string($_SESSION['office_code']);

  
  $member_id = $conn->escape_string($_POST['member_id']);
  $member_name = $conn->escape_string($_POST['member_name']);
  $member_position = $conn->escape_string($_POST['member_position']);
  $flat_no = $conn->escape_string($_POST['flat_no']);
  $mobile_no = $conn->escape_string($_POST['mobile_no']);
  $formation_date = $conn->escape_string($_POST['formation_date']);
  // $committee_status = $conn->escape_string($_POST['committee_status']);
  // $status_date = $conn->escape_string($_POST['status_date']);
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $updateQuery = "UPDATE `committee_info` SET `id`='$id',`office_code`='$office_code',`flat_no`='$flat_no',`member_id`='$member_id',`member_name`='$member_name', `member_position`='$member_position', `mobile_no`='$mobile_no',formation_date='$formation_date',`ss_modifier`='$ss_modifier',`ss_modified_on`=now(),`ss_org_no`='$ss_org_no' where id='$id'";


  $conn->query($updateQuery);
  if ($conn->affected_rows == 1) {
    $message = "Update Successfully!";
    header('refresh:1;committee_info.php');
  } else {
    $mess = "Failled!";
  }
  
}
?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $selectQueryEdit = "SELECT * FROM committee_info where id='$id'";
  $selectQueryEditResult = $conn->query($selectQueryEdit);
  $rows = $selectQueryEditResult->fetch_assoc();
}
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Edit Committee Information </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div>
        <!--  Flat Information -->
        <div id="">
          <div style="padding:5px">
            <!-- form start  -->
            <form action="" method="post">
              <input type="text" class="form-control" id="" value="<?php echo $rows['id']; ?>" name="id" hidden>

              <!-- Flat No  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Member ID</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="member_id" value="<?php echo $rows['member_id']; ?>">
                </div>
              </div>
              <!-- Flat Area  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Member Name</label>
                <div class="col-sm-6">

                <select name="member_name" class="form-control" required>
                    <option value="">-Select member -</option>
                    <?php
                    $selectQuery = "SELECT * from apart_owner_info ";
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row_off = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php                 
                    echo '<option value="' . $row_off['owner_name'] . '"=="' . $rows['member_name'] . '" selected="selected">' . $row_off['owner_name'] . '</option>';
                      }
                    }
                    ?>
                  </select>

                </div>
              </div>
              <!-- Side Location of Flat  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Member Position</label>
                <div class="col-sm-6">

                
                    <select name="member_position" id="" class="form-control" required>
          
                      <option value="">----Select position---</option>
                      <?php
                      $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "comtp" AND `softcode`>0';
                      $selectQueryResult =  $conn->query($selectQuery);
                  if ($selectQueryResult->num_rows) {
                      while ($row = $selectQueryResult->fetch_assoc()) {
                      ?>
                      <option value="<?php echo $row['softcode']; ?>" <?php if ($rows['member_position'] == $row['softcode']) {
                                                                echo "selected";
                                                              } ?>><?php echo $row['description']; ?></option>

                      <?php
                        }
                      }
                    ?>
                    </select>
                </div>
              </div>
              <!-- Building of Flat -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Flat Number</label>
                <div class="col-sm-6">

                <select name="flat_no" class="form-control" required>
                    <option value="">-Select flat No -</option>
                    <?php
                    $selectQuery = "SELECT * from flat_info";
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row_off = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php                 
                    echo '<option value="' . $row_off['flat_no'] . '"=="' . $rows['flat_no'] . '" selected="selected">' . $row_off['flat_no'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                
                </div>
              </div>
               <!-- block_no of Flat   -->
               <div class="form-group row">
                <label class="col-sm-2 col-form-label">Mobile Number </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="mobile_no" value="<?php echo $rows['mobile_no']; ?>">
                </div>
              </div>
              <!-- block_no of Flat   -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Formation Date </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="formation_date" value="<?php echo $rows['formation_date']; ?>">
                </div>
              </div>


              <!-- submit  -->
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="editSubmit">Submit</button>
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
              title: "Oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
        } else {
        }
        ?>
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
<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#301000").addClass('active');
    $("#300000").addClass('active');
    $("#300000").addClass('is-expanded');
  });
</script>
<?php
$conn->close();
?>
</body>

</html>