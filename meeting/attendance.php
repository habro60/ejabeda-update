<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['editSubmit'])) {
  $id = intval($_GET['notice_no']);
  $office_code = $conn->escape_string($_POST['office_code']);
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  for ($count = 0; $count < count($_POST['agenda_no']); ++$count) {
    $notice_no = $_POST['notice_no'][$count];
    $meeting_date = $_POST['meeting_date'][$count];
    $meeting_time = $_POST['meeting_time'][$count];
    $agenda_no = $conn->escape_string($_POST['agenda_no'][$count]);
    $agenda_desc = $conn->escape_string($_POST['agenda_desc'][$count]);
    $updateQuery = "UPDATE `apart_meeting_notice` SET `notice_no`='$notice_no',`meeting_date`='$meeting_date', `meeting_time`='$meeting_time', agenda_desc='$agenda_desc',agenda_status='1', agenda_status_date=now(),`ss_modifier`='$ss_creator',`ss_modified_on`=now(),`ss_org_no`='$ss_org_no' where notice_no='$notice_no'";
    $conn->query($updateQuery);



    if ($conn->affected_rows == 1) {
      $message = "Update Successfully!";
    } else {
      $mess = "Failled!";
    }
  }
  header('refresh:2;notice_published.php');
}
?>
<?php
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Attendance in the Meeting </h1>
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
              <table class="bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>Notice No.</th>
                    <th>Notice Date</th>
                    <th>Meetin Date</th>
                    <th>Meeting Time</th>
                    <th>Owner Name</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // $selectQuery = "SELECT * FROM apart_meeting_notice.notice_no WHERE notice_no='$id'";
                  $selectQuery = "SELECT * FROM apart_meeting_notice";
                  $selectQueryResult = $conn->query($selectQuery);
                  while ($rows = $selectQueryResult->fetch_assoc()) {
                  ?>
                    <tr>
                      <input type="hidden" name="office_code" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>

                      <td>
                        <input type="text" name="notice_no[]" class="form-control" value="<?php echo $rows['notice_no']; ?>" style="width: 100%" readonly>
                      </td>
                      <td>
                        <input type="text" name="notice_date[]" class="form-control" value="<?php echo $rows['notice_date']; ?>" style="width: 100%" readonly>
                      </td>
                      <td>
                        <input type="date" name="meeting_date[]" class="form-control" value="<?php echo $rows['meeting_date']; ?>" style="width: 100%">
                      </td>
                      <td>
                        <input type="time" name="meeting_time[]" class="form-control" value="<?php echo $rows['meeting_time']; ?>" style="width: 100%">
                      </td>

                      <td>
                        <input type="text" name="owner_name[]" class="form-control" value="<?php echo $rows['owner_name']; ?>" style="width: 100%">
                      </td>
                    </tr>

                  <?php
                  }
                  ?>
                </tbody>
              </table>
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="Submit">Present Confirm</button>
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