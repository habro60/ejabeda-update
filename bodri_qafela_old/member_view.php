<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
$pid= 901000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<!-- write your contant start -->
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-th-list"></i>All Member</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb side">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item active"><a href="index.php">Home</a></li>
    </ul>
  </div>
  <a href="../bodri_qafela/member_registration.php" class="btn btn-success">Add Member</a>

  <br><br>
  <div class="row">

    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <table class="table table-hover table-bordered table-sm" id="sampleTable">
            <thead>
              <tr>
                <th>Member ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Referrd Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $sql = "SELECT member_id,full_name,email,mobile,referred_person FROM `fund_member`";

              //use for MySQLi-OOP
              $query = $conn->query($sql);
              while ($row = $query->fetch_assoc()) {
                echo
                  "<tr>
									<td>" . $row['member_id'] . "</td>
									<td>" . $row['full_name'] . "</td>
									<td>" . $row['email'] . "</td>
									<td>" . $row['mobile'] . "</td>
									<td>" . $row['referred_person'] . "</td>
									<td>
										<a href='member_edit.php?recortid=" . $row['member_id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span> Edit</a>
                    <a href='#delete_" . $row['member_id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='fa fa-trash'></span> Delete</a>
									</td>
								</tr>";
                include('registration/edit_delete_modal.php');
              }
              ?>

            </tbody>
          </table>
        </div>
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
<!-- Data table plugin-->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#sampleTable').DataTable();
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#901000").addClass('active');
    $("#900000").addClass('active');
    $("#900000").addClass('is-expanded');

  });
</script>
</body>

</html>