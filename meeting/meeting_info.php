<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];

if (isset($_POST['submit'])) {

  $office_code = $conn->escape_string($_SESSION['office_code']);
  $notice_no = $conn->escape_string($_POST['notice_no']);
  $notice_date = $conn->escape_string($_POST['notice_date']);
  $notice_time = $_POST['notice_time'];
  $meeting_date = $conn->escape_string($_POST['meeting_date']);
  $meeting_time = $conn->escape_string($_POST['meeting_time']);
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  for ($count = 0; $count < count($_POST['agenda_no']); ++$count) {
    $agenda_no = $conn->escape_string($_POST['agenda_no'][$count]);
    $agenda_desc = $conn->escape_string($_POST['agenda_desc'][$count]);
    if ($agenda_no > 0) {
      $insertownerQuery = "INSERT INTO `apart_meeting_notice`(`id`,`office_code`,`notice_no`,`notice_date`, `notice_time`, `agenda_no`,`agenda_desc`,agenda_status,`agenda_status_date`,`meeting_date`, meeting_time, meeting_status,  ss_creator,ss_created_on,ss_org_no) values (NULL,'$office_code','$notice_no','$notice_date','$notice_time','$agenda_no','$agenda_desc','0', now(),'$meeting_date','$meeting_time','0','$ss_creator','$ss_created_on','$ss_org_no')";
      // echo $insertownerQuery;
      // exit;
      $conn->query($insertownerQuery);

      if ($conn->affected_rows == TRUE) {
        $message = "Successfully";
      } else {
        $mess = "Failled";
      }
    }
  }
  header('refresh:1;meeting_info.php');
}
if (!empty($_POST['draf_submit'])) {

  $office_code =$_SESSION['office_code'];
  $ss_creator = $_SESSION['username'];
  $ss_org_no = $_SESSION['org_no'];
  $meeting_no = $_POST['meeting_no'];
  $docx = $_FILES['file']['name'];
  $docxTmp = $_FILES['file']['tmp_name'];
  $docxSize = $_FILES['file']['size'];
  $type = $_FILES["file"]["type"];
  $error = $_FILES["file"]["error"];
  if ($docx) {
    $file_dir = '../upload/';
    $extension = strtolower(pathinfo($docx, PATHINFO_EXTENSION)); // exten
    // $extens= end(explode(".", $docx)); 
    $stem = substr($docx, 0, strpos($docx, '.')); // firstname
    $exten = substr($docx, strpos($docx, '.'), strlen($docx) - 1); // .exten
    $filename = $docx . rand(1000, 9999) . '.' . $extension;
    $allowedExts = array("doc", "docx");
    if (($type == "application/msword" || $type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") && in_array($extension, $allowedExts)) {
      if ($error > 0) {
        $err = "Return Code: " . $error . "<br>";
      } else {
        if (file_exists($file_dir . $docx)) {
          $exists ="$docx . ' already exists. '";
        } else {
          move_uploaded_file($docxTmp, $file_dir . $docx);
          $sql = "INSERT INTO apart_meeting_decision (`id`,`office_code`,`meeting_no`,`decision_no`,`decision_desc`,`ss_creator`,`ss_created_on`,`ss_org_no`)VALUES (NULL,'$office_code','$meeting_no','$meeting_no','$docx','$ss_creator',now(),'$ss_org_no')";
          $query = $conn->query($sql);
          if ($conn->affected_rows) {
            $insertSuccess = "Successfully";
          }
        }
      }
    } else {
      $invalid = "File Invalid";
    }
  }
  header('refresh:1;meeting_info.php');
}
require "../source/top.php";
$pid = 1005000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
$querys = "insert into bach_no (username) values ('$_SESSION[username]')";
$returns = mysqli_query($conn, $querys);
$lastRows = $conn->insert_id;
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Meeting Information Management</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>

    <!-- ====-- button define====== -->
    <button id="noticeFileBtn" class="btn btn-success"><a class="active"></i>Notice Create</button>
    <button id="publishedBtn" class="btn btn-primary"><a class=""></i>Notice Published</button>
    <button id="attenFileBtn" class="btn btn-primary"><a class=""></i>Attendance</button>
    <button id="draftMeeting" class="btn btn-primary"><a class=""></i>Draft Meeting Minutes</button>
    <button id="flatListBtn" class="btn btn-primary"><a class=""></i>Confirm Minutes</button>
    <!-- =======button Define closed===== -->
    <div class=" row">
      <div class="col-md-12">
        <div id="noticeFile" class="collapse">
          <div style="padding:5px">
            <form method="post">
              <table class="table bg-light table-bordered table-sm">
                <thead>
                  <tr>
                    <th>Notice Number</th>
                    <th style="text-align: center">Notice Date </th>
                    <th style="text-align: center">Time</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> <input type="text" name="notice_no" readonly class="org_form org_12 " autofocus value="<?php echo $lastRows; ?>"></td>

                    <td> <input type="date" id="date" class="org_form" name="notice_date" value="<?php echo date('Y-m-d'); ?>"></td>

                    <td> <input type="text" name="notice_time"  class="org_form" id="clock" value="<?php date_default_timezone_set('Asia/Dhaka');
                         echo date("h:i:sa"); ?>" readonly></td>
                  </tr>
                </tbody>
              </table>
              <!-- =========  Agenda input ======== -->
              <table class="table bg-light table-bordered table-sm" id="multi_table">
                <thead>
                  <tr class="table-active">
                    <th>Serial No.</th>
                    <th>Agenda </th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="width: 20px"><input type="text" name="agenda_no[]" id="agenda_no" data-srno="1" value="1" class="agenda_no form-control" /></td>
                    <td><input type="text" name="agenda_desc[]" id="agenda_desc" data-srno="1" class="agenda_desc form-control" /></td>
                    <td style="width: 20px"><button type="button" name="add_row" id="add_row" class="btn btn-success btn-xl">+</button></td>
                  </tr>
                </tbody>
              </table>
              <hr>
              <!-- ======Meeting Time ====== -->
              <table class="table bg-light table-bordered table-sm">
                <thead>
                  <tr class="table-active">
                    <th>Meeting date. <span id="meeting_notice" style="color:red"></span></th>
                    <th>Meeting Time </th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input type="date" name="meeting_date" id="meeting_date" data-srno="1" class="meeting_date form-control" onchange="meetingDate()" required /></td>
                    <td><input type="text" name="meeting_time" id="meeting_time" data-srno="1" class="meeting_time form-control" /></td>
                  </tr>
                </tbody>
              </table>
              <!-- ===== Input Closed =====  -->
              <div>
                <input type="hidden" name="activation_key" value="0">
                <button type="submit" class="btn btn-primary" id="submit" name="submit">Submit</button>
              </div>
          </div>
          </form>
        </div>
      </div>
    </div>
    <?php
    if (!empty($message)) {
      echo '<script type="text/javascript"> Swal.fire("Save Successfully!!", "Welcome ' . $_SESSION['username'] . '", "success") </script>';
    } else {
    }
    if (!empty($mess)) {
      echo '<script type="text/javascript"> Swal.fire({ icon: "error", title: "Oops...", text: "Sorry ' . $_SESSION['username'] . '"}); </script>';
    } 
    if (!empty($err)) {
      echo '<script type="text/javascript"> Swal.fire({ icon: "error", title: "Oops...", text: "Sorry ' . $error . '"}); </script>';
    } 
    if (!empty($exists)) {
      echo '<script type="text/javascript"> Swal.fire({ icon: "error", title: "Oops...", text: "Sorry ' . $exists . '"}); </script>';
    } 
    if (!empty($insertSuccess)) {
      echo '<script type="text/javascript"> Swal.fire("Save Successfully!!", "Welcome ' . $insertSuccess . '", "success") </script>';
    } 
    if (!empty($invalid)) {
      echo '<script type="text/javascript"> Swal.fire({ icon: "error", title: "Oops...", text: "Sorry ' .$invalid . '"}); </script>';
    } 
    ?>
    <!--====== Notice View List ======-->
    <div class="tile" id="pubNotice">
      <div class="tile-body">
        <h5 style="text-align: center">Published Notice</h5>
        <table class="table table-hover table-bordered" id="GLAddTable">
          <thead>
            <tr>
              <th>Notice No.</th>
              <th>Notice Date</th>
              <th>Meeting Date</th>
              <th>Meeting Time</th>
              <th>Total Agenda</th>
              <th>Confimrmed & published</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT notice_no, notice_date, meeting_date, meeting_time, max(agenda_no)as total_agenda, agenda_desc, agenda_status  FROM apart_meeting_notice group by notice_no";
            $query = $conn->query($sql);
            while ($row = $query->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['notice_no'] . "</td>";
              echo "<td>" . $row['notice_date'] . "</td>";
              echo "<td>" . $row['meeting_date'] . "</td>";
              echo "<td>" . $row['meeting_time'] . "</td>";
              echo "<td>" . $row['total_agenda'] . "</td>";
            ?>
              <td><a <?php if ($row['agenda_status'] != '0') {
                        echo "onclick='return false";
                      } ?> <?php echo "href='notice_published.php?id=" . $row['notice_no'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Add</a>
              </td>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <!--========= Attendance ======-->
    <div class="tile" id="attenFile">
      <h5 style="text-align: center">Attendance </h5>
      <form action="" method="POST">
        <table>
          <td> <select name="notice" id="notice_no" class="form-control" style="width: 120px" required>
              <option value="">- Notice No -</option>
              <?php
              require '../database.php';
              $selectQuery = 'SELECT notice_no from apart_meeting_attendance GROUP BY notice_no DESC';
              $selectQueryResult = $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($notice = $selectQueryResult->fetch_assoc()) {
              ?>
              <?php
                  echo '<option value="' . $notice['notice_no'] . '" >' . $notice['notice_no'] . '</option>';
                }
              }
              ?>
            </select></td>
          <td><input name="search_notice" id="search_notice" class="btn btn-info" value="Serach" onclick="searchNotice()" readonly></td>
        </table>
      </form>
      <div class="tile-body">
        <div id="attendance_result">

        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Attendance</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="confirmId" hidden></div>
              <div id="confirmNotice" hidden></div>
              <h4 id="confirmMessage" style="color:red"></h4>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" id="confirmCancel">Cancel</button>
              <button type="button" id="presentConfirm" class="btn btn-primary">Confirm Attendance</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <div class="tile" id="ShowDraftMeeting">
      <div class="tile-body">
        <h5 style="text-align: center"> Draft Minutes</h5>
        <div class="row">
          <div class="col-8">
            <form method="POST" enctype="multipart/form-data">
              <label for=""><strong>Meeting No</strong></label>
              <input type="number" name="meeting_no" class="form-control" id="meeting_no">
              <label for="">
                <strong>Click on Choose File for Upload Meeting Minutes</strong>
              </label>
              <input type="file" name="file" accept="doc/docx" class="form-control" id="meeting_draft">
              <br>
              <input type="submit" class="btn btn-info" name="draf_submit" value="Save Draft">
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php
  } else {
    echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION</h6>";
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
  // $(document).ready(function() {
  $("#907000").addClass('active');
  $("#900000").addClass('active');
  $("#900000").addClass('is-expanded')
  // });
  $(document).ready(function() {
    var count = 1;
    $(document).on('click', '#add_row', function() {
      count++;
      var html_code = '';
      html_code += '<tr id="row_id_' + count + '">';
      html_code += '<td><input type="text" name="agenda_no[]" id="agenda_no' + count + '" data-srno="' + count + '" value="' + count + '" class="form-control agenda_no"/></td>';
      html_code += '<td><input type="text" name="agenda_desc[]" id="agenda_desc' + count + '" data-srno="' + count + '" class="form-control agenda_desc"/></td>';
      html_code += '<td><button type="button" name="remove_row" id="' + count + '" class="form-control btn btn-danger btn-xl remove_row">-</button></td>';
      html_code += '</tr>';
      $('#multi_table').append(html_code);
    });
    $(document).on('click', '.remove_row', function() {
      var row_id = $(this).attr("id");
      $('#row_id_' + row_id).remove();
      count--;
    });
  });
  // table 
  $('#sampleTable').DataTable();
  $('#memberTable').DataTable();
  // meeting_date
  function meetingDate() {
    var meeting_date = $("#meeting_date").val();
    var to_date = '<?php echo date('Y-m-d'); ?>';

    if (meeting_date >= to_date) {
      $("#submit").attr("disabled", false);
      $("#meeting_date").css({
        "color": "black",
        "border": "2px solid gray"
      });
      // meeting_notice
      $("#meeting_notice").text("");
    } else {
      alert("System Error!! Input Right Date");
      $("#meeting_date").css({
        "color": "red",
        "border": "2px solid red"
      });
      $("#submit").attr("disabled", true);
      $("#meeting_notice").text("System Error!! Input Right Date");
    }
  }
  // Button 
  $('#pubNotice').hide();
  $('#attenFile').hide();
  $('#ShowDraftMeeting').hide();
  $('#noticeFile').show();
  // noticeFile
  $('#noticeFileBtn').on('click', function() {
    $('#noticeFile').show();
    $('#pubNotice').hide();
    $('#ShowDraftMeeting').hide();
    $('#attenFile').hide();
  });
  // publishedBtn
  $('#publishedBtn').on('click', function() {
    $('#noticeFile').hide();
    $('#ShowDraftMeeting').hide();
    $('#pubNotice').show();
    $('#attenFile').hide();
  });
  // attenFileBtn
  $('#attenFileBtn').on('click', function() {
    draftMeeting
    $('#noticeFile').hide();
    $('#pubNotice').hide();
    $('#ShowDraftMeeting').hide();
    $('#attenFile').show();
  });
  $('#draftMeeting').on('click', function() {
    $('#noticeFile').hide();
    $('#pubNotice').hide();
    $('#attenFile').hide();
    $('#ShowDraftMeeting').show();
  });
  // -----------------search notice --------
  function searchNotice() {
    var notice_no = $("#notice_no").val();
    //  alert(notice_no);
    $.ajax({
      type: "POST",
      url: "getMeeting.php",
      data: {
        notice_no: notice_no
      },
      dataType: "text",
      success: function(response) {
        $("#attendance_result").html(response);
        // alert(response);
      }
    });
  }
  // -------------- present confirm ----------
  function presentDialog(id, notice) {
    $("#confirmId").text(id);
    $("#confirmNotice").text(notice);
  }
  var YOUR_MESSAGE_STRING_CONST = "Confirm Your Attendance?";
  $('#presentConfirm').on('click', function(e) {
    confirmDialog(YOUR_MESSAGE_STRING_CONST, function() {
      // My code to confirm
      var id = $("#confirmId").text();
      var notice = $("#confirmNotice").text();
      $.ajax({
        type: "POST",
        url: "getMeeting.php",
        data: {
          id: id,
          notice: notice
        },
        dataType: "text",
        success: function(response) {
          $("#present" + id).attr("disabled", true);
          $("#present" + id).text("Present");
          // $("#present"+id).addClass("btn btn-primary"); // wrong 
          $("#present" + id).attr('class', 'btn btn-primary');
          $("#attend_time" + id).val(response);
          // alert(response);
        }
      });
      console.log(id);
    });
  });

  function confirmDialog(message, onConfirm) {
    var fClose = function() {
      modal.modal("hide");
    };
    var modal = $("#exampleModalCenter");
    modal.modal("show");
    $("#confirmMessage").empty().append(message);
    $("#presentConfirm").bind().one('click', onConfirm).one('click', fClose);
    // $("#presentConfirm").one('click', onConfirm).one('click', fClose);
    $("#confirmCancel").unbind().one("click", fClose);
  }
</script>
<?php
$conn->close();
?>
</body>

</html>