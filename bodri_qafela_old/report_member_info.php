<?php
require "source/top.php";
require "source/header.php";
require "source/sidebar.php";
?>    
    <main class="app-content">
    <div class="border border-success">
    <a href="generate-user-pdf.php" class="btn btn-success">Download PDF</a>
    <h1 class="text-center">Kazi Abdul Hamid College</h1>
    <h2 class="text-center">Memebr Informtion List</h2>
    <h2 class="text-center">as on date: <?php echo date("d-m-Y");; ?></h2>
    <hr>
    <table class="table table-striped">
  <thead>
    <tr>
      
      <th scope="col">Member ID</th>
      <th scope="col">Name</th>
      <th scope="col">Address</th>
      <th scope="col">Annual Amount</th>
      <th scope="col">Donation Type</th>
    </tr>
  </thead>
  <tbody>
    <?php
    require "database.php";
	$selectQuery = "SELECT member.member_id, member.full_name,member.village,member.annul_c_tk,member.donation_type,code_master.softcode,code_master.hardcode,code_master.description FROM `member` JOIN `code_master` WHERE member.donation_type=code_master.softcode AND code_master.hardcode='DOTY'";
	$selectQueryResult = $conn->query($selectQuery);	
	//echo "$selectQueryResult->num_rows";	
	if($selectQueryResult->num_rows){
		
		while($row = $selectQueryResult->fetch_array()){
      ?>

			<?php echo"<tr>"; ?>
			<?php echo "<th scope='row'>".$row['member_id']."</th>"; ?>
			<?php echo "<td>".$row['full_name']."</td>"; ?>
			<?php echo "<td>".$row['village']."</td>"; ?>
			<?php echo "<td>".$row['annul_c_tk']."</td>"; ?>
      <?php echo "<td>".$row['description']."</td>"; ?>
      <?php echo"</tr>"; ?>

      <?php
		}
	}
	
	?>
  </tbody>
</table>
</div>

    </main>
    <!-- Essential javascripts for application to work-->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="assets/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- script  -->
      <script type="text/javascript">
    $(document).ready(function() {    
    $("#reports").addClass('active');
    $("#report_member").addClass('active');
    $("#report").addClass('is-expanded');

    });
    </script>
  </body>
</html>