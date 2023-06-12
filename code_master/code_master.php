<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
$pid= 101000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<!-- write your contant start -->
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-th-list"></i>Main Code Master Table</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb side">
      #####
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <!-- buttion start  -->
          <a href="#addnew" data-toggle="modal" class="btn btn-primary"><span class="fa fa-plus"></span>Add New</a>
          <a href="#addnews" data-toggle="modal" class="btn btn-success"><span class="fa fa-plus"></span>Add Type</a>
          <a href="#viewhardcode" data-toggle="modal" class="btn btn-success"><span class="fa fa-print"></span>View HardCode</a>
          <div class="height10">
          </div>
          <!-- button end -->
          <table class="table table-hover table-bordered table-sm" id="sampleTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Hard Code</th>
                <th>Softcode</th>
                <th>Description</th>
                <th>Short Des</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM `code_master` WHERE `softcode`>0";

              //use for MySQLi-OOP
              $query = $conn->query($sql);
              while ($row = $query->fetch_assoc()) {
                echo
                  "<tr>
									<td>" . $row['id'] . "</td>
									<td>" . $row['hardcode'] . "</td>
									<td>" . $row['softcode'] . "</td>
									<td>" . $row['description'] . "</td>
									<td>" . $row['sort_des'] . "</td>
									<td>
										<a href='#edit_" . $row['id'] . "' class='btn btn-success btn-sm' data-toggle='modal'><span class='fa fa-edit'></span> Edit</a>
										<a href='#delete_" . $row['id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='fa fa-trash'></span> Delete</a>
									</td>
								</tr>";
                include('edit_delete_modal.php');
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include('add_modal.php') ?>
  <?php include('add_modal_hardcode.php') ?>
</main>
<!-- hardcode view  -->
<div class="modal fade" id="viewhardcode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center" id="myModalLabel">All Hard Code</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <table class="table table-hover table-bordered" id="sampleTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Hard Code</th>
                <th>Description</th>
                <th>Short Des</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM `code_master` WHERE `softcode`=0";
              //use for MySQLi-OOP
              $query = $conn->query($sql);
              while ($row = $query->fetch_assoc()) {
                echo
                  "<tr>
									<td>" . $row['id'] . "</td>
									<td>" . $row['hardcode'] . "</td>
									<td>" . $row['description'] . "</td>
									<td>" . $row['sort_des'] . "</td>
									<td>
										<a href='#edits_" . $row['id'] . "' class='btn btn-success btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-edit'></span> Edit</a>
									</td>
								</tr>";
                include('edit_delete_modal.php');
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- hardcode view end  -->
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
</script>
<!-- script  -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#101000").addClass('active');
    $("#100000").addClass('active');
    $("#100000").addClass('is-expanded');

  });
</script>
</body>

</html>