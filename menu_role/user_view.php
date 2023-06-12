<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
$pid = 502000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require '../source/sidebar.php';
require '../source/header.php';
?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> User List</h1>
    </div>
  </div>
  <table class="table bg-light table-bordered table-sm table" id="sampleTable">
    <thead>
      <tr>
        <th>No</th>
        <th>Office Code</th>
        <th>Image</th>
        <th>User Name</th>
        <th>Role</th>
        <th>Date</th>
        <th>action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $sql = "SELECT user_info.id, user_info.office_code,user_info.username,user_info.sa_role_no,user_info.user_group, user_info.user_validity_date, user_info.employee_image, user_info.user_status, sm_role.role_no,sm_role.role_name, office_info.office_name FROM `user_info`,sm_role,office_info WHERE user_info.sa_role_no=sm_role.role_no AND user_info.office_code=office_info.office_code";
      $query = $conn->query($sql);
      while ($row = $query->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $no++ . '</td>';
        echo '<td>' . $row['office_name'] . '</td>';
        echo '<td><img src="../upload/' . $row['employee_image'] . '" style="width:50px;height:50px"></td>';
        echo '<td>' . $row['username'] . '</td>';
        echo '<td>' . $row['role_name'] . '</td>';
        echo '<td>' . $row['user_validity_date'] . '</td>';
      ?>
        <td><a data="<?php echo $row['id']; ?>" style="width:80px" class="status btn
                    <?php echo ($row['user_status']) ? 'btn-success' : 'btn-danger'; ?>"><?php echo ($row['user_status']) ? 'Active' : 'Inactive'; ?>
          </a> <button class="btn btn-info" title="Edit User <?php echo $row['username']; ?>"><i class="fa fa-edit"></i></button></td>
        <!-- <td>
          <input data-id="<?php echo $row['id']; ?>" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" <?php echo ($row['user_status']) ? 'checked' : ''; ?>>
        </td> -->
      <?php
      }
      ?>
    </tbody>
  </table>
</main>
<!-- <script>
  $(function() {
    $('.toggle-class').change(function() {
      var status = $(this).prop('checked') == true ? 1 : 0; // ternary operator
      var id = $(this).data('id');

      $.ajax({
        type: "post",
        dataType: "json",
        url: 'getChangeUserStatus.php',
        data: {
          'status': status,
          'id': id
        },
        success: function(data) {
          console.log(data.success)
        }
      });
    })
  })
</script> -->
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- table  -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#sampleTable').DataTable();
</script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#dashboard").addClass('active');
  });
  $(document).ready(function() {
    $("#502000").addClass('active');
    $("#500000").addClass('active');
    $("#500000").addClass('is-expanded');
  });
</script>
<!-- Change User Status -->
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', '.status', function() {
      // alert("run ajax");
      // exit;
      var status = ($(this).hasClass("btn-success")) ? '0' : '1';
      // alert (status);
      var msg = (status == '0') ? 'Deactivate' : 'Activate';
      if (confirm("Are you sure to " + msg)) {
        var current_element = $(this);
        //  alert (current_element);   
        url = "getChangeUserStatus.php";
        // alert (url);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            id: $(current_element).attr('data'),
            status: status
          },
          success: function(data) {
            location.reload();
          }
          //  alert (data); 
        });
      }
    });
  });
</script>
<!-- alternative ways -->
<script>
  // $(function() {
  //   $('.toggle-class').change(function() {
  //     var status = $(this).prop('checked') == true ? 1 : 0; // ternary operator
  //     var id = $(this).data('id');
  //     $.ajax({
  //       type: "post",
  //       dataType: "json",
  //       url: 'getChangeUserStatus.php',
  //       data: {
  //         'status': status,
  //         'id': id
  //       },
  //       success: function(data) {
  //         console.log(data.success)
  //       }
  //     });
  //   })
  // })
</script>
</body>

</html>