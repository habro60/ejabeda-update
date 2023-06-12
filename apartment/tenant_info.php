<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['SubBtn'])) {
  // $emp_id = ($_POST['emp_id']);
   $office_code = $_SESSION['office_code'];
  $tenant_id = $conn->real_escape_string($_POST['tenant_id']);
  $tenant_name = $conn->real_escape_string($_POST['tenant_name']);
  $flat_no = $conn->real_escape_string($_POST['flat_no']);
  $tenant_under_owner_id = $conn->real_escape_string($_POST['owner_id']);
  $father_hus_name = $conn->real_escape_string($_POST['father_hus_name']);
  $mother_name = $conn->real_escape_string($_POST['mother_name']);
  // $husband_name = $conn->real_escape_string($_POST['husband_name']);
  $nid = $conn->real_escape_string($_POST['nid']);
  // $passport_no = $conn->real_escape_string($_POST['passport_no']);
  $date_of_birth = $conn->real_escape_string($_POST['date_of_birth']);
  $mobile_no = $conn->real_escape_string($_POST['mobile_no']);
  $permanent_add = $conn->real_escape_string($_POST['permanent_add']);
  $profession = $conn->real_escape_string($_POST['profession']);
  $contract_date = $conn->real_escape_string($_POST['contract_date']);
  $contract_period = $conn->real_escape_string($_POST['contract_period']);
  $contract_expiry_date= $conn->real_escape_string($_POST['contract_expiry_date']);
  $tenant_image = $conn->real_escape_string($_POST['tenant_image']);
  $ss_creator = $_SESSION['username'];
  $ss_org_no = $_SESSION['org_no'];
  $insertQuery = "INSERT INTO `apart_tenant_info` (`id`,`office_code`,`tenant_id`,`tenant_name`,`flat_no`,`tenant_under_owner_id`,`father_hus_name`,`mother_name`,`nid`,`passport_no`,`date_of_birth`,`mobile_no`,`permanent_add`,`profession`,`contract_date`,`contract_period`,`contract_expiry_date`,`tenant_image`,`ss_creator`,`ss_created_on`,`ss_org_no`) VALUES (NULL,'$office_code','$tenant_id','$tenant_name','$flat_no','$tenant_under_owner_id','$father_hus_name','$mother_name','$nid','','$date_of_birth','$mobile_no','$permanent_add','$profession','$contract_date','$contract_period','$contract_expiry_date','$tenant_image','$ss_creator',now(),'$ss_org_no')";
  // echo $insertQuery;
  // exit;
  $conn->query($insertQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
    
  }  else {
    $mess = "Failled!";
  }
  require "../apartment/SMS_API.php";
  // require "../apartment/SMS1.php";
  header('refresh:1;tenant_info.php');
}
require "../source/top.php";
// $pid= 1302000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Tenant Information</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index/index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-10 mx-auto">
      <!-- -------------------------------->
      <?php if (isset($message)) echo $message; ?>
      <form method="post"  enctype="multipart/form-data">
        <!-- emp_id user name part -->
        <!-- Tenant ID & Name  -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Tenant Id</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="tenant_id" class="form-control" required placeholder="Tenant Id">
          </div>
          <label class="col-sm-2 col-form-label">Tenant Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="tenant_name" class="form-control" required placeholder="Tenant Name">
            <!------------------------------------->
          </div>
        </div>
        <!-- Father and Mother Name -->
       <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Father Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="father_hus_name" class="form-control" required placeholder="Father/husband Name">
          </div>
          <label class="col-sm-2 col-form-label">Mother Name</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="mother_name" class="form-control" required placeholder="Mother Name">
          </div>
        </div>

        <!-- Flat No, & taneant Under Flat -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">Tenant under Owner</label>
          <label class="col-form-label">:</label>
          <div class="col">
          <select name="owner_id" class="form-control select2">
                            <option value="">Tenant under Owner</option>
                            <?php
                            $selectQuery = 'SELECT owner_id, owner_name, flat_no FROM `apart_owner_info`';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                            ?>
                            <?php
                            echo '<option value="' . $row['owner_id'] . '"=="' . $row['owner_id'] . '" selected="selected">' . $row['owner_name'] . '</option>';
                                }
                            }
                            ?>
              </select>

          </div>
          <label class="col-sm-2 col-form-label">Flat No.</label>
          <label class="col-form-label">:</label>
          <div class="col">
               <input type="text" name="flat_no" class="form-control" required placeholder="flat_no">
          </div>
        </div>
           <!-- NID and Passport No. -->
        <div class="form-row form-group">
          <label class="col-sm-2 col-form-label">NID</label>
          <label class="col-form-label">:</label>
          <div class="col">
            <input type="text" name="nid" class="form-control" placeholder="nid">
          </div>
          <label class="col-sm-2 col-form-label">Passport No.</label>
          <label for="" class="col-form-label">:</label>
          <div class="col">
                <input type="text" name="nid" class="form-control" placeholder="nid">
          </div>
        </div>

        <!-- date of Birth and Mobile No.. -->
         <div class="form-row form-group">
             <label class="col-sm-2 col-form-label"> Date of birth</label>
             <label class="col-froml-label">:</label>
             <div class="col">
                  <input type ="date" name="date_of_birth" class="form-control" required>
              </div>
              <label class="col-sm-2 col-form-label">Mobile No.</label>
              <label class="col-form-label">:</label>
              <div class="col">
                  <input type ="text" name="mobile_no" class="form-control" placeholder="mobile_no">
              </div>
         </div>

         <!-- Address and Profession.. -->
         <div class="form-row form-group">
             <label class="col-sm-2 col-form-label"> Parmenent Address</label>
             <label class="col-froml-label">:</label>
             <div class="col">
                  <input type ="text" name="permanent_add" class="form-control" placeholder="permanent_add">
              </div>
              <label class="col-sm-2 col-form-label">Profession</label>
              <label class="col-form-label">:</label>
              <div class="col">
                  <input type ="text" name="profession" class="form-control" placeholder="profession">
              </div>
         </div>
       
        <!-- Contract date and Period.. -->
        <div class="form-row form-group">
             <label class="col-sm-2 col-form-label"> Contract Date</label>
             <label class="col-froml-label">:</label>
             <div class="col">
                  <input type ="date" name="contract_date" class="form-control" required>
              </div>
              <label class="col-sm-2 col-form-label">Contract Period</label>
              <label class="col-form-label">:</label>
              <div class="col">
                  <input type ="text" name="contract_period" class="form-control" placeholder="contract_period">
              </div>
         </div>
       
        <!-- Contract Exp. date and Tenant Emage.. -->
        <div class="form-row form-group">
             <label class="col-sm-2 col-form-label"> Contract Exp. Date</label>
             <label class="col-froml-label">:</label>
             <div class="col">
                  <input type ="date" name="contract_expiry_date" class="form-control" required>
              </div>
              <label class="col-sm-2 col-form-label">Tenant Image</label>
              <label class="col-form-label">:</label>
              <div class="col">
                  <input type ="text" name="tenant_image" class="form-control" placeholder="Tenant Image">
              </div>
         </div>     
        </div>
        <input type="submit" value="Submit" id="register" class=" btn btn-primary form-control text-center" name="SubBtn">
      </form>
      <!-- -------------------------------->
      <?php
      if (!empty($message)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
      } else {
      }
      if (!empty($mess)) {
        echo '<script type="text/javascript">
          Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
      } else {
      }
      ?>

<div class="tile" id="tenantViewList">
              <div class="tile-body">
                <h5 style="text-align: center">Tenant List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="tenantListTable">
                  <thead>
                    <tr>
                      
                      <th>ID</th>
                      <th>Under Project</th>
                      <th>Tenant Id</th>
                      <th>Tenant  Name</th>
                      <th>Tenant under Owner</th>
                      <th>Flat No.</th>
                      <th>Father Name</th>
                      <th>NID</th>
                      <th>Mobile No.</th>
                      <th>Profession</th>
                      <th>contract Date</th>
                      <th>contract Period</th>
                      <th>Expiry Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT * FROM `apart_tenant_info`";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                      echo
                        "<tr>
                  <td>" . $rows['id'] . "</td>
                  <td>" . $rows['office_code'] . "</td>
                  <td>" . $rows['tenant_id'] . "</td>
                  <td>" . $rows['tenant_name'] . "</td>
                  <td>" . $rows['tenant_under_owner_id'] . "</td>
                  <td>" . $rows['flat_no'] . "</td>
                  <td>" . $rows['father_hus_name'] . "</td>
          
									<td>" . $rows['nid'] . "</td>
							
									
									<td>" . $rows['mobile_no'] . "</td>
									
									<td>" . $rows['profession'] . "</td>
                  <td>" . $rows['contract_date'] . "</td>
                  <td>" . $rows['contract_period'] . "</td>
                  <td>" . $rows['contract_expiry_date'] . "</td>
                  <td><a target='_blank' href='tenant_edit_info.php?id=" . $rows['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                  </td>
								</tr>";
                      // include('edit_delete_modal.php');
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>



<!-- <===== -->

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

<script type="text/javascript">
  $(document).ready(function() {
    $("#1302000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded');
  });
</script>

</body>

</html>