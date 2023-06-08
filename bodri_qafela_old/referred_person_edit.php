<?php
	require "database.php";
	//update query
	if(isset($_POST['submit'])){					
  $referred_type = $_POST['referred_type'];	
  $reffered_id = $_POST['reffered_id'];				
  $full_name = $_POST['fullname'];				
  $father_name = $_POST['f_name'];				
  $mother_name = $_POST['m_name'];				
  $husband_name = $_POST['h_name'];				
  $email = $_POST['email'];				
  $mobile = $_POST['mobile'];				
  $village = $_POST['village'];				
  $division = $_POST['division'];				
  $district = $_POST['district'];				
  $upazila = $_POST['upazila'];				
  $p_office = $_POST['p_office'];				
  $p_code = $_POST['p_code'];				
  $p_village = $_POST['p_village'];				
  $p_division = $_POST['p_division'];				
  $p_district = $_POST['p_district'];				
  $p_upazila = $_POST['p_upazila'];				
  $p_p_office = $_POST['p_p_office'];				
  $p_p_code = $_POST['p_p_code'];		
  $created_by = $_POST['created_by'];
  $created_date = date("Y-m-d H:i:s");
  $modify_by = $_POST['modify_by'];
  $modify_date = date("Y-m-d H:i:s");		
	$idno = $_GET['recortid'];		
	$updateQuery = "UPDATE `ref_info` SET referred_type='$referred_type', reffered_id='$reffered_id', full_name='$full_name', father_name='$father_name', mother_name='$mother_name', husband_name='$husband_name', email='$email', mobile='$mobile', village='$village', division='$division', district='$district', upazila='$upazila', p_office='$p_office', p_code='$p_code', p_village='$p_village', p_division='$p_division', p_district='$p_district', p_upazila='$p_upazila', p_p_office='$p_p_office', p_p_code='$p_p_code', created_by='$created_by',created_date='$created_date',modify_by='$modify_by', modify_date='$modify_date' WHERE id = '$idno'";
	// echo $updateQuery; 
	$conn->query($updateQuery);
	if($conn->affected_rows ==1){
		$message ="Updated successfully";
  }
  else{
			echo 'There were erros while saving the data.';
		}
}else{
	echo 'No data';
}
	//select query start
	if(isset($_GET['recortid'])){
		$idno = $_GET['recortid'];		
	$selectQuery = "SELECT * FROM `ref_info` WHERE id=$idno";
	// echo $selectQuery; exit;
	$selectQueryResult = $conn->query($selectQuery);	
	//if($selectQueryResult->num_rows){		
		$row = $selectQueryResult->fetch_array();		
		//}
	}
	$conn->close();
	?>
<?php
require "source/top.php";
require "source/header.php";
require "source/sidebar.php";
?>    
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Member Registration</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <!-- -------------------------------->         
          <input type="hidden" name="recid" value="<?php echo $row['id']; ?>"/>
          <form role="form" action="#" method="post">

           <!-- mamber part  -->
          <div class="form-row form-group">
             <label class="col-sm-2 col-form-label">Referred Type</label>
             <label for="" class="col-form-label">:</label>
           <div class="col">
             <input type="text" name="referred_type" class="form-control" value="<?php echo $row['referred_type']; ?>">
           </div>
           <label for="staticEmail" class="col-sm-2 col-form-label">Referred ID</label>
           <label for="" class="col-form-label">:</label>
           <div class="col">
             <select name="reffered_id" id="" class="form-control">
            <option value="<?php echo $row['reffered_id'];?>"><?php echo $row['reffered_id'];?></option>
        
             <!------------------------------------->
        </select>
             <!------------------------------------->
           </div>
         </div>   

     <!-- Name part -->
         <div class="form-row form-group">
             <label class="col-sm-2 col-form-label">Full Name</label>
             <label for="" class="col-form-label">:</label>
           <div class="col">
             <input type="text" name="fullname" class="form-control" placeholder="Full Name" value="<?php echo $row['full_name'];?>" readonly>
           </div>
           <label for="staticEmail" class="col-sm-2 col-form-label">Father Name</label>
           <label for="" class="col-form-label">:</label>
           <div class="col">
             <input type="text" name="f_name" class="form-control" placeholder="Father Name" value="<?php echo $row['father_name'];?>">
           </div>
         </div>   
         <div class="form-row form-group">
                 <label for="staticEmail" class="col-sm-2 col-form-label">Mother Name</label>
                 <label for="" class="col-form-label">:</label>
               <div class="col">
                 <input type="text" name="m_name" class="form-control" placeholder="Mother Name" value="<?php echo $row['mother_name'];?>">
               </div>
               <label class="col-sm-2 col-form-label">Husband Name(if applicable)</label>
               <label for="" class="col-form-label">:</label>
               <div class="col">
                 <input type="text" name="h_name" class="form-control" placeholder="Husband Name(if applicable)" value="<?php echo $row['husband_name'];?>">
               </div>
             </div>
             <!-- contract part -->
         <div class="form-row form-group">
             <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
             <label for="" class="col-form-label">:</label>
           <div class="col">
             <input type="email" name="email" class="form-control" placeholder="admin@domain.com" value="<?php echo $row['email'];?>">
           </div>
           <label for="staticEmail" class="col-sm-2 col-form-label">Mobile No</label>
           <label for="" class="col-form-label">:</label>
           <div class="col">
             <input type="tel" name="mobile" class="form-control" placeholder="Example:+8801234567890" value="<?php echo $row['mobile'];?>">
           </div>
         </div>
             <!-- address part -->
            <div class="form-row form-group">
                   <div class="col-sm-6">
                     <div class="card">
                           <div class="card-header">
                                   Present Address
                                 </div>
                       <div class="card-body">
               <!--------------------address script and php query---------------------------->
             <div class="form-row form-group">
                     <label for="inputPassword" class="col-sm-5 col-form-label">Village/Road/House/Flat</label>
                     <label for="" class="col-form-label">:</label>
                     <div class="col">
                       <input type="text" class="form-control" name="village" placeholder="Village/Road#/House#/Flat#" value="<?php echo $row['village'];?>">
                     </div>
                   </div>
           <!------------------------------------------->
           <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Division</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                      <select name="division" id="division-list" class="form-control" >
                          <option value="<?php echo $row['division'];?>" ><?php echo $row['division'];?></option>
                      </select>
                  </div>
                </div>
                 <!------------------------------------------->
           <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Dristrict</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                      <select name="district" id="district-list" class="form-control" onChange="getUpazilas(this.value);">
                          <option value="<?php echo $row['district'];?>"><?php echo $row['district'];?></option>
                      </select>
                  </div>
                </div>
                <!------------------------------------------->
           <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">P.S./Upazila</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                      <select name="upazila" id="upazilla-list" class="form-control">
                          <option value="<?php echo $row['upazila'];?>"><?php echo $row['upazila'];?></option>
                      </select>
                  </div>
                </div>
                <!------------------------------------------->
           <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Post Office</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                      <input type="text" name="p_office" class="form-control" value="<?php echo $row['p_office'];?>">
                  </div>
                </div>
                <!------------------------------------------->
           <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Post Code</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                      <input type="text" name="p_code" class="form-control" value="<?php echo $row['p_code'];?>">
                  </div>
                </div>
                <!--------------------------------------------->
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="card">
                      <div class="card-header">
                          Parmanant Address
                            </div>
                  <div class="card-body">
                     <!------------------------------------------------>
                     <div class="form-row form-group">
                          <label for="inputPassword" class="col-sm-5 col-form-label">Village/Road/House/Flat</label>
                          <label for="" class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" name="p_village" class="form-control" placeholder="Village/Road#/House#/Flat#" value="<?php echo $row['p_village'];?>">
                          </div>
                        </div>
   <!------------------------------------------->
   <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Division</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                      <select name="p_division" id="division-list1" class="form-control" onChange="getDistrict1(this.value);">
                          <option value="<?php echo $row['p_division'];?>"><?php echo $row['p_division'];?></option>
                      </select>
                  </div>
                </div>
         <!------------------------------------------->
          <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">Dristrict</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                      <select name="p_district" id="district-list1" class="form-control" onChange="getUpazilas1(this.value);">
                          <option value="<?php echo $row['p_district'];?>"><?php echo $row['p_district'];?></option>
                      </select>
                  </div>
                </div>
                <!------------------------------------------->
           <div class="form-row form-group">
                  <label for="inputPassword" class="col-sm-5 col-form-label">P.S./Upazila</label>
                  <label for="" class="col-form-label">:</label>
                  <div class="col">
                      <select name="p_upazila" id="upazilla-list1" class="form-control">
                          <option value="<?php echo $row['p_upazila'];?>"><?php echo $row['p_upazila'];?></option>
                      </select>
                  </div>
                </div>
        <!------------------------------------------->
      <div class="form-row form-group">
          <label for="inputPassword" class="col-sm-5 col-form-label">Post Office</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
              <input type="text" name="p_p_office" class="form-control" value="<?php echo $row['p_p_office'];?>">
          </div>
        </div>
        <!------------------------------------------->
      <div class="form-row form-group">
          <label for="inputPassword" class="col-sm-5 col-form-label">Post Code</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
              <input type="text" name="p_p_code" class="form-control" value="<?php echo $row['p_p_code'];?>">
          </div>
        </div>
        <!--------------------------------------------->
                  </div>
                </div>
              </div>
            </div>
            <!-- extra  -->
        <input type="hidden" name="created_by">
        <input type="hidden" name="modify_by">

        <!------------------------------------------------------------------>
        <input name="submit" type="submit" id="register" value="Update" class=" btn btn-primary form-control text-center" />
         </form>
          <!-- -------------------------------->
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
    $(function() {
      $('#register').click(function() {
        swal.fire({
  title: "Success!",
  text: "Update Successfull",
  icon: "success",
  button: "Aww yiss!",
})
      });
        
     
      
    });
    
    </script>
<!-- --------------------------------------- -->
    
    <script type="text/javascript">
    $(document).ready(function() {    
    $("#refs").addClass('active');
    $("#ref_view").addClass('active');
    $("#ref").addClass('is-expanded');

    });
    </script>
    
  </body>
</html>