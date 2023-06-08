<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Apartment Bill and Charge Setup</h1>
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
                    <th>Office Code</th>
                    <th>Bill & Charge Code</th>
                    <th> Bill & charge Name</th>
                    <th> Bill Pay Freqency</th>
                    <th>Bill Pay By </th>
                    <th> Bill amt. Method</TH>
                    <th>BILL amt. (in %<)/th>
                    <th>Fixed Bill Amt.</th>
                    <th>Variable Bill Amt.</th>
                    <th> Bill Pay Freqency</th>
                    <th>Bill Pay By </th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
				  <?php
				  include_once('../database.php');
							$sql = "SELECT * FROM `apart_bill_charge_setup`";

							//use for MySQLi-OOP
							$query = $conn->query($sql);
							while($row = $query->fetch_assoc()){
								echo 
								"<tr>
									<td>".$row['id']."</td>
                  <td>".$row['office_code']."</td>
                  <td>".$row['effect_date']."</td>
                  <td>".$row['bill_charge_code']."</td>
                  <td>".$row['bill_charge_name']."</td>
                  <td>".$row['bill_pay_frequency']."</td>
                  <td>".$row['bill_paid_by']."</td>
                  <td>".$row['bill_pay_method']."</td>
                  <td>".$row['bill_percentage']."</td>
                  <td>".$row['bill_fixed_amt']."</td>
                  <td>".$row['bill_variable_amt']."</td>
                  <td>".$row['link_gl_acc_code']."</td>
									<td>
										<a href='apart_bill_setup_edit.php?recortid=".$row['id']."' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span> Edit</a>
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