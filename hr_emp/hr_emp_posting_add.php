<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['editSubmit'])) {
  $id = intval($_GET['id']);
      $updateQuery = "UPDATE `hr_posting_transfer` SET `is_current`='0' where is_current='1' and emp_no='$id'";
      $conn->query($updateQuery);

      if ($conn->affected_rows >= 1) {
        $message = "Successfully";
      } else {
        $mess = "Failled";
      }
  
  $emp_no = $id;
  $posting_date = $conn->escape_string($_POST['posting_date']);
  $posting_place = $conn->escape_string($_POST['posting_place']);
  $tranf_date = $conn->escape_string($_POST['posting_date']);
  $tranf_from_place = $conn->escape_string($_POST['tranf_from_place']);
  
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_modifier = 'N/A';
  $ss_modified_on = '9999-09-09';    
  $ss_org_no = $_SESSION['org_no'];

  $sqlinsert = "insert into hr_posting_transfer (id, `emp_no`,`posting_date`,`posting_place`,`tranf_date`,`tranf_from_place`,`is_current`,`ss_creator`,`ss_created_on`,`ss_modifier`,`ss_modified_on`,`ss_org_no` ) values (null, '$emp_no', '$posting_date', '$posting_place', '$tranf_date', '$tranf_from_place', '1', '$ss_creator', '$ss_created_on','$ss_modifier','$ss_modified_on','$ss_org_no') ";
  $conn->query($sqlinsert);

  if ($conn->affected_rows >= 1) {
    $message = "Successfully";
  } else {
    $mess = "Failled";
  }

   $updateQuery = "UPDATE `sm_hr_emp` SET `office_code`='$posting_place',  where emp_no='$id'";
  //  echo $updateQuery;
  //  exit;
      $conn->query($updateQuery);

      if ($conn->affected_rows >= 1) {
        $message = "Successfully";
      } else {
        $mess = "Failled";
      }
  header('refresh:1;hr_emp_posting_add.php');
  header('refresh:1;hr_emp_posting.php');
}
?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

}
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Posting and Transfer </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12" id="">
      <div style="padding:5px">
        <!-- form start  -->
        <form action="" method="post">
          <table class="table bg-light table-bordered table-sm">
            <thead>
              <tr>
                <th>Employee No.</th>
                <th>Name</th>
                <th>Job Title</th>
                <th>Posting Date</th>
                <th>Posting Place</th>
                <th>Transfer Date</th>
                <th>Transfer From Place</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              if (!empty($_GET['id'])) {
              $selectQuery = "SELECT hr_posting_transfer.id, sm_hr_emp.emp_no, sm_hr_emp.f_name, sm_hr_emp.l_name, sm_hr_emp.desig_code, hr_posting_transfer.posting_date, hr_posting_transfer.posting_place, hr_posting_transfer.tranf_date,hr_posting_transfer.tranf_from_place, office_info.office_name, hr_desig.desig_desc FROM `hr_posting_transfer` , sm_hr_emp, office_info, hr_desig WHERE sm_hr_emp.emp_no =hr_posting_transfer.emp_no and office_info.office_code= hr_posting_transfer.posting_place and hr_desig.desig_code=sm_hr_emp.desig_code and hr_posting_transfer.emp_no='$id'";
              $selectQueryResult = $conn->query($selectQuery);

              while ($rows = $selectQueryResult->fetch_assoc()) {
              ?>
                <?php $no++ ?>
                <tr>
                  <input type="hidden" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                  <input type="hidden" name="desig_code[]" class="form-control" value="<?php echo $rows['desig_code']; ?>" style="width: 100%" readonly>
                  <td>
                    <input type="text" name="emp_no[]" class="form-control" value="<?php echo $rows['emp_no']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="text" name="f_name[]" class="form-control" value="<?php echo $rows['f_name']; echo "  "; echo $rows['l_name'];?>" style="width: 100%" readonly>
                  </td>
                 
                  <td>
                    <input type="text" name="desig_desc[]" class="form-control" value="<?php echo $rows['desig_desc']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="date" name="posting_date[]" class="form-control" value="<?php echo $rows['posting_date']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="text" name="office_name[]" class="form-control" value="<?php echo $rows['office_name']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="date" name="tranf_date[]" class="form-control" value="<?php echo $rows['tranf_date']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="text" name="tranf_from_place[]" class="form-control" value="<?php echo $rows['tranf_from_place']; ?>" style="width: 100%" readonly>
                  </td>
                  
                </tr>
              <?php
              }
            }
              ?>
            </tbody>
          </table>
             <div class="card-header" style="background-color:#85C1E9">
              <h4 style="text-align:center">New Posting of The employee</h4>
            </div>
            <hr>
    
         <?php
         if (!empty($_GET['id'])) {
                 $emp_no = $_GET['id'];
                  $sql = "SELECT hr_posting_transfer.id, sm_hr_emp.emp_no, sm_hr_emp.f_name, sm_hr_emp.l_name, sm_hr_emp.desig_code, hr_posting_transfer.posting_date, hr_posting_transfer.posting_place, office_info.office_name, office_info.office_code FROM `hr_posting_transfer` , sm_hr_emp, office_info WHERE sm_hr_emp.emp_no =hr_posting_transfer.emp_no and office_info.office_code= hr_posting_transfer.posting_place and hr_posting_transfer.emp_no='$id' order by hr_posting_transfer.id DESC LIMIT 1";
                  $query = $conn->query($sql);
                  $data = $query->fetch_assoc();


         }

        ?>
        
         
         <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Employee Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="f_name" value="<?php echo $data['f_name'];echo " "; echo $data['l_name'] ; ?>" class="form-control" readonly>
          </div>
         </div>
         <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Present Posting Place</label>
          <label class="col-form-label">:</label>
          <div class="col">
          <select name="tranf_from_place" class="form-control" readonly disable>
                    <option value="">-Select office Code -</option>
                    <?php
                    require '../database.php';
                    $selectQuery = "SELECT office_code, office_name from office_info ";
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row_off = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php                 
                    echo '<option value="' . $data['office_code'] . '"=="' . $data['office_code'] . '" selected="selected">' . $data['office_name'] . '</option>';
                      }
                    }
                  
                    ?>
                  </select>
            <!-- <input type="text" name="tranf_from_place" value="<?php echo $data['posting_place']; ?>" class="form-control"  readonly> -->
          </div>
         </div>
         <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">New Postting Place</label>
          <label class="col-form-label">:</label>
          <div class="col">
          <select name="posting_place" class="form-control" required>
                    <option value="">-Select office Code -</option>
                    <?php
                    require '../database.php';
                    $selectQuery = "SELECT office_code, office_name from office_info ";
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row_off = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php                 
                    echo '<option value="' . $row_off['office_code'] . '"=="' . $row_off['office_code'] . '" selected="selected">' .$row_off['office_name'] . '</option>';
                      }
                    }
                  
                    ?>
                  </select>
          </div>
         </div>
         <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Posting Date</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="date" name="posting_date" value="<?php echo $data['posting_date']; ?>" class="form-control" >
          </div>
         </div>
         
         
          <div class="form-group row">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary" id="submit" name="editSubmit">Confirm Posting</button>
            </div>
          </div>
        </form>
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
  // meeting_date
  function meetingDate() {
    var meet_date = $("#meet_date").val();
    var to_date = '<?php echo date('Y-m-d'); ?>';

    if (meet_date >= to_date) {
      $("#submit").attr("disabled", false);
      $("#meet_date").css({
        "color": "black",
        "border": "2px solid gray"
      });
      // meeting_notice
      $("#meeting_notice").text("");
    } else {
      alert("System Error!! Input Right Date");
      $("#meet_date").css({
        "color": "red",
        "border": "2px solid red"
      });
      $("#submit").attr("disabled", true);
      $("#meeting_notice").text("System Error!! Input Right Date");
    }
    Y = $("#meet_date").val();
    x = document.getElementsByClassName("meeting_date");
    for (i = 0; i < x.length; i++) {
      x[i].value = Y;
    }
  }
</script>
<?php
$conn->close();
?>
</body>

</html>