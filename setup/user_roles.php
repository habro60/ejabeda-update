<?php
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> User Role Table</h1>
    </div>
    <!-- <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Blank Page</a></li>
    </ul> -->
  </div>
  <!-- sample  -->
  <div class="row">
        <div class="col-md-12">		
          <div class="tile">
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Role No</th>
                    <th>Role Name</th>
                    <th>Active Status</th>
                    <th>Creator</th>
                    <th>Creatated Date</th>
                    <th>Modifier</th>
                    <th>Modifier Date Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
				  <?php
				  include_once('../database.php');
							$sql = "SELECT * FROM `sm_role`";

							//use for MySQLi-OOP
							$query = $conn->query($sql);
							while($row = $query->fetch_assoc()){
								echo 
								"<tr>
									<td>".$row['id']."</td>
									<td>".$row['role_no']."</td>
									<td>".$row['role_name']."</td>
									<td>".$row['active_stat']."</td>
									<td>".$row['ss_creator']."</td>
									<td>".$row['ss_created_on']."</td>
									<td>".$row['ss_modifier']."</td>
									<td>".$row['ss_modified_on']."</td>
									<td>
										<a href='user_roles_edit.php?recortid=".$row['id']."' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span> Edit</a>
                    <a href='#delete_".$row['id']."' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
									</td>
								</tr>";
								// include('ref_info/edit_delete_modal.php');
								
							}
						?>
            
                </tbody>
              </table>
			</div>
          </div>
        </div>
	  </div>	  
  <!-- sample  -->
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- table  -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">$('#sampleTable').DataTable();</script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#dashboard").addClass('active');
  });
</script>
</body>

</html>