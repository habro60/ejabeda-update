<?php
require "source/top.php";
require "source/header.php";
require "source/sidebar.php";
?>    
<!-- write your contant start -->
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> All Fund Details</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item active"><a href="index.php">Home</a></li>
        </ul>
	  </div>
      <div class="row">
        <div class="col-md-12">		
          <div class="tile">
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th>Transaction ID</th>
                    <th>Member No</th>
                    <th>Payment Amount</th>
                    <th>Payment Date</th>
                    <th>Cheque No</th>
                    <th>Cheque Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
				  <?php
				  include_once('database.php');
							$sql = "SELECT * FROM `fund_recived`";

							//use for MySQLi-OOP
							$query = $conn->query($sql);
							while($row = $query->fetch_assoc()){
								echo 
								"<tr>
									<td>".$row['transaction_id']."</td>
									<td>".$row['membership_no']."</td>
									<td>".$row['payment_amount']."</td>
									<td>".$row['payment_date']."</td>
									<td>".$row['cheque_no']."</td>
									<td>".$row['cheque_date']."</td>
									<td>
										<a href='fund_received_edit.php?recortid=".$row['transaction_id']."' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span> Edit</a>
                    <a href='#delete_".$row['transaction_id']."' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
									</td>
								</tr>";
								include('fund_received/edit_delete_modal.php');
								
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
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="assets/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <script type="text/javascript" src="assets/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
   <!-- --------------------------------------- -->
   <script type="text/javascript">
    $(document).ready(function() {  
      $("#fund").addClass('is-expanded');  
      $("#funds").addClass('active');
      $("#fund_view").addClass('active');
    });
    </script>
  </body>
</html>