<?php
require "../auth/auth.php";
	require "../database.php";
	//update query
if (isset($_POST['submit'])) {

	$role_no = $_POST['role_no'];
	$role_name = $_POST['role_name'];
	$active_stat = $_POST['active_stat'];
	$ss_modifier = $_SESSION['username'];
    $ss_modified_on = date("Y-m-d H:i:s");
    $id=$_GET['id'];
	$sql = "UPDATE sm_role SET role_no = '$role_no', role_name = '$role_name', active_stat = '$active_stat', ss_modifier = '$ss_modifier',ss_modified_on='$ss_modified_on' WHERE id = '$id'";

	$conn->query($sql);
	if ($conn->affected_rows == 1) {
		$message = "Save Successfully!";
	} else {
		$mess = "Failled!";
	}
	 	header('refresh:1;user_roles.php');
}
	//select query start
 	if(isset($_GET['id'])){
 		$idno = $_GET['id'];
	$selectQuery = "SELECT * FROM `sm_role` WHERE id='$idno'";
	$selectQueryResult = $conn->query($selectQuery);	
		$row = $selectQueryResult->fetch_array();		
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
          <h1><i class="fa fa-dashboard"></i> Roll Info</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">        
          <form role="form" action="#" method="post">
           <!-- mamber part  -->
          <div class="form-row form-group">
             <label class="col-sm-2 col-form-label">Role_no</label>
             <label class="col-form-label">:</label>
           <div class="col">
             <input type="text" name="role_no" class="form-control" value="<?php echo $row['role_no']; ?>">
           </div>
           <label  class="col-sm-2 col-form-label">Member Type</label>
           <label class="col-form-label">:</label>
           <div class="col">
             <input type="text" name="role_name" id="" class="form-control" value="<?php echo $row['role_name'];?>">
             <!------------------------------------->
           </div>
         </div>   

     <!-- Name part -->
         <div class="form-row form-group">
              <label class="col-sm-2 col-form-label">Active Status</label>
             <label for="" class="col-form-label" style="margin-right: 40px">:</label>
           <div class="col">
           <label class="form-check-label " style="margin-right: 40px">
                <input type="radio" class="form-check-input" name="active_stat" value="1" <?php if($row['active_stat']==1){echo "checked";} ?> >
                Active
              </label>
              
              <label class="form-check-label">
                <input type="radio" class="form-check-input" name="active_stat" value="0" <?php if($row['active_stat']==0){echo "checked";} ?>>
                In-Active
              </label>

        <!------------------------------------------------------------------>
        <input name="submit" type="submit" value="Update" class=" btn btn-primary form-control text-center" />
         </form>
          <!-- -------------------------------->
        </div>
      </div>
    </main>
    <?php 
    	$conn->close();
    ?>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>    
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>    
    </script>
    <!-- registration_division_district_upazila_jqu_script -->
    <script type="text/javascript">
    $(document).ready(function() {   
    $("#common").addClass('active');
    $("#regform").addClass('active');
    });
    </script>
    
  </body>
</html>