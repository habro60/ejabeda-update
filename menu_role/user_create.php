<?php

require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
$pid = 501000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require '../source/sidebar.php';
require '../source/header.php';
require '../source/footer.php';
?>


<?php

// update query

if (isset($_POST['update'])) {
  // $office_code = $_SESSION['office_code'];
  $office_code = $_POST['office_code'];
  $sa_role_no = $conn->escape_string($_POST['sa_role_no']);
  $user_group = $conn->escape_string($_POST['user_group']);
  $username = $conn->escape_string($_POST['username']);
  
  $password = $conn->escape_string($_POST['password']);
  $confirm_password = $conn->escape_string($_POST['confirm_password']);
  $hash = password_hash($password, PASSWORD_BCRYPT);
  $password_validity = $conn->escape_string($_POST['password_validity']);
  $user_status = '1';
  $employee_image = $conn->escape_string($_POST['employee_image']);
  $user_validity_date = date('Y-m-d ', strtotime("+ $password_validity days"));
  $link_id = $conn->escape_string($_POST['link_id']);
  $ss_creator = $_SESSION['username'];
  $ss_org_no = $_SESSION['org_no'];
  // echo $password . "<br>" . $confirm_password;
  // exit;
  if ($password == $confirm_password) {
    $updateQuery = "INSERT INTO  `user_info` (`id`,`office_code`,`username`,`password`,`sa_role_no`,  `user_create_date`, `user_validity_date`,`user_valid_days`,`user_status`,`user_group`,`link_id`,`employee_image`,`ss_creator`,`ss_created_on`,`ss_org_no`) VALUES(NULL,'$office_code','$username','$hash','$sa_role_no',now(),'$user_validity_date','$password_validity','$user_status','$user_group','$link_id','$employee_image','$ss_creator',now(),'$ss_org_no')";
    // echo $updateQuery;
    // exit;
    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {
      $user_create_success = "Successfully";
      header("refresh:2;user_create.php");
    } 
  }
}


?>

<script src="https://kit.fontawesome.com/f826455fa9.js" crossorigin="anonymous"></script>


<main class="app-content">
  <div class="app-title">
        

      <h5 class="card-title">User Access Permission</h5>
      <div class="container">
          <div style="text-align: right;">
              <a href="user_view.php" class="btn btn-outline-success btn-sm text-right">
                  <i class="fas fa-plus-circle fa-w-20"></i><span> User Control</span>
              </a>

              
          </div>
      </div>
     
  </div>
  <table>
    <form method="POST">
      <tr>
        <td>
          <select name="user_group" class="form-control select2" style="width: 200px" required>
            <option value="">-Select User Group-</option>
            <?php
            $selectQuery = 'SELECT * FROM `code_master` where hardcode="USERG" AND softcode>0';
            $selectQueryResult = $conn->query($selectQuery);
            if ($selectQueryResult->num_rows) {
              while ($row = $selectQueryResult->fetch_assoc()) {

            ?>
            <?php
                echo '<option value="' . $row['softcode'] . '">' . $row['description'] . '</option>';
              }
            }
            ?>
          </select>
        </td>
        <td><input type="submit" name="submit" value="submit" class="form-control btn-info"></td>
      </tr>
    </form>
  </table>
  <?php
  if (isset($_POST['submit'])) {
    $user_group = $_POST['user_group'];
   
    // echo $user_group;
    // exit;
    if ($user_group == '100') {
  ?>

      <table class="table table-hover table-bordered">
        <thead>
          <tr>
          <th>Office Code</th> 
          <th>Office Name</th> 
          <th>Employee No.</th>
            <th>First Name</th>
            <th>Last Name</th>
            
            <th>action</th>
            
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT  sm_hr_emp.emp_no, sm_hr_emp.office_code,sm_hr_emp.f_name, sm_hr_emp.l_name, employee_image,
           office_info.office_name FROM `sm_hr_emp`, office_info WHERE sm_hr_emp.office_code = office_info.office_code";
          $query = $conn->query($sql);
 
          while ($row = $query->fetch_assoc()) {
            $emp_no=$row['emp_no'];
            $sql = "SELECT id FROM `user_info` WHERE link_id='$emp_no' AND `user_group`='100'";
           $query2 = $conn->query($sql);
           $row2 = $query2->fetch_assoc();


            echo '<tr>';
            echo '<td>' . $row['office_code'] . '</td>';
            echo '<td>' . $row['office_name'] . '</td>';
            echo '<td>' . $row['emp_no'] . '</td>';
            echo '<td>' . $row['f_name'] . '</td>';
            echo '<td>' . $row['l_name'] . '</td>';
           
            
            
            if(isset($row2['id'])){
           ?>
           <td> <a  type="button" class="btn btn-xs btn-disable" data-toggle="modal">Given Access Role </a></td>
           <?php
            }else{
              ?>
            <td> <a  type="button" class="btn btn-xs btn-success editbtn" data-toggle="modal">Access Role </a></td>
              <?php

            }
          
            echo '</tr>';
         
            

          } 
      

        
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '200') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>Office Code</th>
            <th>Customer Id</th>
            <th>Customer Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT cust_info.`id`,cust_info.`office_code`,cust_info.`cust_name`,cust_info.`image`, office_info.office_name FROM `cust_info` , `office_info` WHERE cust_info.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {

            $cust_id=$row['id'];
            $sql = "SELECT id FROM `user_info` WHERE link_id='$cust_id' AND `user_group`='200'";
           $query2 = $conn->query($sql);
           $row2 = $query2->fetch_assoc();

            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['cust_name'] . '</td>';
            

                        if(isset($row2['id'])){
           ?>
           <td> <a  type="button" class="btn btn-xs btn-disable" data-toggle="modal">Given Access Role </a></td>
           <?php
            }else{
              ?>
            <td> <a  type="button" class="btn btn-xs btn-success" data-toggle="modal" href="#edit<?= $row['id'] ?>">Access Role </a></td>
              <?php

            }
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '300') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            
            <th>Supplier Name</th>
            <th>Supplier Image</th>
            <th>Office Code</th>
            <th>Supplier Id</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT supp_info.`id`, supp_info.`office_code`, supp_info.`supp_name`, supp_info.`image`, office_info.office_name FROM `supp_info`, `office_info` WHERE supp_info.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {

            $supp_id=$row['id'];
            $sql = "SELECT id FROM `user_info` WHERE link_id='$supp_id' AND `user_group`='300'";
           $query2 = $conn->query($sql);
           $row2 = $query2->fetch_assoc();

            echo '<tr>';
            echo '<td>' . $row['supp_name'] . '</td>';
            echo '<td>' . $row['image'] . '</td>';          
            echo '<td>' . $row['office_code'] . '</td>';          
            echo '<td>' . $row['id'] . '</td>';

                        if(isset($row2['id'])){
           ?>
           <td> <a  type="button" class="btn btn-xs btn-disable" data-toggle="modal">Given Access Role </a></td>
           <?php
            }else{
              ?>
            <td> <a  type="button" class="btn btn-xs btn-success editbtn" data-toggle="modal">Access Role </a></td>
              <?php

            }
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '0400') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
          <th>Office Code</th>
            
            <th>Full Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT fund_member.office_code, fund_member.`member_id`, fund_member.`full_name`,fund_member.`member_type`,fund_member.`mobile`, office_info.office_name FROM `fund_member`, `office_info` WHERE fund_member.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {

            $member_id=$row['member_id'];
            $sql = "SELECT id FROM `user_info` WHERE link_id='$member_id' AND `user_group`='400'";
           $query2 = $conn->query($sql);
           $row2 = $query2->fetch_assoc();

            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            
            echo '<td>' . $row['full_name'] . '</td>';
            echo '<td>' . $row['office_code'] . '</td>';  
            echo '<td>' . $row['member_id'] . '</td>';
            echo '<td>' . $row['full_name'] . '</td>';
            
            echo '<td>' . $row['member_type'] . '</td>';          
                   
            echo '<td>' . $row['mobile'] . '</td>';
            

                        if(isset($row2['id'])){
           ?>
           <td> <a  type="button" class="btn btn-xs btn-disable" data-toggle="modal">Given Access Role </a></td>
           <?php
            }else{
              ?>
            <td> <a  type="button" class="btn btn-xs btn-success editbtn" data-toggle="modal" href="#edit<?= $row['member_id'] ?>">Access Role </a></td>
              <?php

            }
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '500') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
          <th>Office Code</th>
           
             <th>Teacher Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT sm_hr_emp.emp_no, sm_hr_emp.office_code,sm_hr_emp.f_name, sm_hr_emp.l_name, employee_image, office_info.office_name FROM `sm_hr_emp`, office_info WHERE sm_hr_emp.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {

            $emp_no=$row['emp_no'];
            $sql = "SELECT id FROM `user_info` WHERE link_id='$emp_no' AND `user_group`='500'";
           $query2 = $conn->query($sql);
           $row2 = $query2->fetch_assoc();

            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            
            echo '<td>' . $row['f_name'] . '</td>';
            echo '<td>' . $row['l_name'] . '</td>';

                       if(isset($row2['id'])){
           ?>
           <td> <a  type="button" class="btn btn-xs btn-disable" data-toggle="modal">Given Access Role </a></td>
           <?php
            }else{
              ?>
            <td> <a  type="button" class="btn btn-xs btn-success" data-toggle="modal" href="#editEmp<?= $row['emp_no'] ?>">Access Role </a></td>
              <?php

            }
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '600') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
           <th>Office Code</th>
           
            <th>Student Name</th>
            <th>Student Last Name</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT sm_hr_emp.emp_no, sm_hr_emp.office_code,sm_hr_emp.f_name, sm_hr_emp.l_name, employee_image, office_info.office_name FROM `sm_hr_emp`, office_info WHERE sm_hr_emp.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {

            $emp_no=$row['emp_no'];
            $sql = "SELECT id FROM `user_info` WHERE link_id='$emp_no' AND `user_group`='600'";
           $query2 = $conn->query($sql);
           $row2 = $query2->fetch_assoc();

            echo '<tr>';
            echo '<td>' . $row['office_name'] . '</td>';
            
            echo '<td>' . $row['f_name'] . '</td>';
            echo '<td>' . $row['l_name'] . '</td>';

                        if(isset($row2['id'])){
           ?>
           <td> <a  type="button" class="btn btn-xs btn-disable" data-toggle="modal">Given Access Role </a></td>
           <?php
            }else{
              ?>
            <td> <a  type="button" class="btn btn-xs btn-success" data-toggle="modal" href="#editEmp<?= $row['emp_no'] ?>">Access Role </a></td>
              <?php

            }
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    <?php
    } elseif ($user_group == '800') {
    ?>
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
          <th>Flat No</th>
            
            <th>Owner Name</th>
           
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //  $q = intval($_GET['q']);
          $sql = "SELECT apart_owner_info.owner_id,apart_owner_info.flat_no, apart_owner_info.office_code, apart_owner_info.owner_name, apart_owner_info.owner_image,office_info.office_name FROM `apart_owner_info`, `office_info` WHERE apart_owner_info.office_code = office_info.office_code";
          $query = $conn->query($sql);
          while ($row = $query->fetch_assoc()) {
            

           $owner_id=$row['owner_id'];

            // echo $owner_id;
            // die;
            
            $sql = "SELECT id FROM `user_info` WHERE link_id='$owner_id' AND `user_group`='800' ";
            
           $query2 = $conn->query($sql);

          //  if($query2 = $conn->query($sql)){
          
           $row2 = $query2->fetch_assoc();

          //  }

          //  $sql = "SELECT id FROM `user_info` WHERE username='$owner_name'";
            
          //  $query2 = mysqli_query($conn,$sql);
          
          //  $row2 = mysqli_fetch_assoc($query2);
           

            echo '<tr>';
           
           
            echo '<td>' . $row['flat_no'] . '</td>';
            
            
            echo '<td>' . $row['owner_name'] . '</td>';
            echo '<td>' . $row['office_code'] . '</td>';
            echo '<td>' . $row['owner_id'] . '</td>';

           
            if(isset($row2['id'])){
              ?>
              <td> <a  type="button" class="btn btn-xs btn-disable" data-toggle="modal">Given Access Role </a></td>
              <?php
               }else{
                 ?>
               <td> <a  type="button" class="btn btn-xs btn-success editbtn" data-toggle="modal">Access Role </a></td>
                 <?php
   
               }
               echo '</tr>';
             }
             ?>
         
        </tbody>
      </table>
    <?php
    } else {
    ?>
      
      </table>
    <?php
    }
    ?>

  <?php
  } else {
  }
  ?>

</main>


<!-- modal start -->


<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Access User Role</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                      <form method="post">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Office Code</label>
                        <label>:</label>
                        <div class="col-sm-6">
                        <input type="text" value="<?php echo $office_code;  ?>" name="office_code" id="office_code" class="form-control">
                        </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Given Role </label>
                          <label>:</label>
                          <div class="col-sm-6">
                            <select name="sa_role_no" class="form-control" required>
                              <option value="">- Select Role -</option>
                              <?php
                              $selectQuery = "SELECT role_no , role_name FROM `sm_role` where user_group= '$user_group'";
                              $selectQueryResult = $conn->query($selectQuery);
                              if ($selectQueryResult->num_rows) {
                                while ($rows = $selectQueryResult->fetch_assoc()) {
                              ?>
                                  <option value="<?php echo $rows['role_no']; ?>" <?php if ($rows['role_no'] == $_POST['user_group']) {
                                                                    echo 'selected';
                                                                  } ?>><?php echo $rows['role_name']; ?></option>';
                              <?php
                                }
                              }
                              ?>
                            </select>
                          </div>
                      </div>

                      
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">User Name </label>
                        <label>:</label>
                        <div class="col-sm-6">
                          <input type="text" name="username" id="username" maxlength="15" class="form-control">
                            <tr>
                              <th width="24%" scope="row"></th>
                              <td><span id="name_availability_status"></span></td>
                            </tr>
        
                          <input type="hidden" name="link_id" id="owner_id" maxlength="55" class="form-control" readonly>

                          <input type="hidden" name="link_id" id="emp_no" maxlength="55" class="form-control" readonly>
                          <input type="hidden" name="link_id" id="id" maxlength="55" class="form-control" readonly>

                          
                          
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <label>:</label>
                        <div class="col-sm-6">
                          <input type="password" name="password" value="" id="password" class="form-control" placeholder="Password" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Confirm Password</label>
                        <label>:</label>
                        <div class="col-sm-6">
                          <input type="password" name="confirm_password" value="" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
                          <span id="conf"></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Password Validity</label>
                        <label>:</label>
                        <div class="col-sm-6">
                          <input type="text" name="password_validity" value="" class="form-control" placeholder="Validity Days" required>
                        </div>
                      </div>
                      <!--  -->
                      <div class="form-group row">

                        <div class="col-sm-6">
                          
                          <!-- <input type="hidden" name="office_code" id="office_code" class="form-control" value="<?php echo $office_code; ?>" placeholder="office_code"> -->
                          
                        </div>
                      </div>
                      <!--  -->
                     
                      <input type="hidden" name="user_group" id="user_group" value="<?php echo $user_group; ?>" class="form-control">
                      <!--  -->
                      <div class="form-group row">
                        <div class="col-sm-10">
                          <input type="submit" name="update" value="Confirm Access User" class="btn btn-info" />
                          
                        </div>
                      </div>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>


<!-- modal end -->






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
    $("#501000").addClass('active');
    $("#500000").addClass('active');
    $("#500000").addClass('is-expanded');
  });
</script>



<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', '.status', function() {
      // alert("run ajax");
      // exit;
      var status = ($(this).hasClass("btn-success")) ? '0' : '1';
       alert (status);
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


<script>
        $(document).ready(function () {

            $('.editbtn').on('click', function () {

                $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#emp_no').val(data[2]);
                $('#owner_id').val(data[1]);
                $('#office_code').val(data[0]);
                $('#id').val(data[3]);
                $('#member_id').val(data[4]);
                //$('#contact').val(data[4]);
            });
        });


       
    </script>

</body>

</html>