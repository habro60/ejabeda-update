<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['editSubmit'])) {
  $id = intval($_GET['id']);
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

    if ($notice_no > 0) {
      $updateQuery = "UPDATE `apart_meeting_notice` SET `notice_no`='$notice_no',`meeting_date`='$meeting_date', `meeting_time`='$meeting_time', agenda_desc='$agenda_desc',agenda_status='1', agenda_status_date=now(),`ss_modifier`='$ss_creator',`ss_modified_on`=now(),`ss_org_no`='$ss_org_no' where notice_no='$notice_no'";
      $conn->query($updateQuery);

      if ($conn->affected_rows >= 1) {
        $message = "Successfully";
      } else {
        $mess = "Failled";
      }
    } else {
      $message = "Successfully";
    }
  }

  $sqlinsert = "insert into apart_meeting_attendance (office_code, notice_no, notice_date,notice_time, owner_id, meeting_date, meeting_time) select apart_meeting_notice.office_code,apart_meeting_notice.notice_no, apart_meeting_notice.notice_date, apart_meeting_notice.notice_time, apart_owner_info.owner_id, apart_meeting_notice.meeting_date, apart_meeting_notice.meeting_time  from apart_meeting_notice, apart_owner_info where apart_meeting_notice.agenda_no='1' and apart_meeting_notice.notice_no='$notice_no' ";
  $conn->query($sqlinsert);

  if ($conn->affected_rows >= 1) {
    $message = "Successfully";
  } else {
    $mess = "Failled";
  }

  // header('refresh:2;notice_published.php');
  header('refresh:1;meeting_info.php');
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
      <h1><i class="fa fa-dashboard"></i> Notice Edit & Published </h1>
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
                <th>Notice No.</th>
                <th>Notice Date</th>
                <th>Meetin Date <span id="meeting_notice" style="color:red"></th>
                <th>Meeting Time</th>
                <th>Agenda No.</th>
                <th>Agenda</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              $selectQuery = "SELECT * FROM apart_meeting_notice where notice_no='$id'";
              $selectQueryResult = $conn->query($selectQuery);

              while ($rows = $selectQueryResult->fetch_assoc()) {
              ?>
                <?php $no++ ?>
                <tr>
                  <input type="hidden" name="office_code" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>
                  <td>
                    <input type="text" name="notice_no[]" class="form-control" value="<?php echo $rows['notice_no']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="text" name="notice_date[]" class="form-control" value="<?php echo $rows['notice_date']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="date" name="meeting_date[]" class="meeting_date form-control" value="<?php echo $rows['meeting_date']; ?>" id="meet_date" style="width: 100%" onchange="meetingDate()">
                  </td>
                  <td>
                    <input type="time" name="meeting_time[]" class="form-control" value="<?php echo $rows['meeting_time']; ?>" style="width: 100%">
                  </td>
                  <td>
                    <input type="text" name="agenda_no[]" class="form-control" value="<?php echo $rows['agenda_no']; ?>" style="width: 100%" readonly>
                  </td>
                  <td>
                    <input type="text" name="agenda_desc[]" class="form-control" value="<?php echo $rows['agenda_desc']; ?>" style="width: 100%">
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
          <div class="form-group row">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary" id="submit" name="editSubmit">Confirm & Published</button>
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