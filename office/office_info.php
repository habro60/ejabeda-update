<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
?>
<?php
if (isset($_POST['subBtn'])) {
  $office_code = $_POST['office_code'];
  $office_name = $_POST['office_name'];
  
  $office_address= $_SESSION["org_addr1"];
  $email_add= $_SESSION["org_email"];
          
  $level_no = $_POST['level_no'];
  $office_type = $_POST['office_type'];
  $parent_code = $_POST['parent_code'];
  
  $ss_creator = $_SESSION['username'];
  $ss_org_no =  $_SESSION['org_no'];

  $insertQuery = "INSERT INTO `office_info` (`id`, `office_code`, `office_name`, email_add, office_address,`level_no`,`office_type`,`parent_code`,`ss_creator`,`ss_created_on`,`ss_org_no`) VALUES (NULL,'$office_code','$office_name','$email_add','$office_address','$level_no','$office_type','$parent_code','$ss_creator',now(),'$ss_org_no')";
  
  echo $insertQuery;
  exit;
  $conn->query($insertQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully!";
  } else {
    $mess = "Failled!";
  }
  header('refresh:1;office_info.php');
}
?>
<?php
// $query = "Select Max(office_code) From office_info where level_no=1";
// $returnDrow = mysqli_query($conn, $query);
// $resultrow = mysqli_fetch_assoc($returnDrow);
// $maxRowsrow = $resultrow['Max(office_code)'];
// if (empty($maxRowsrow)) {
//   $lastRowrow = $maxRowsrow = 1000000000;
// } else {
//   $lastRowrow = $maxRowsrow + 1000000000;
// }
$lastRowrow =  $_SESSION['org_no'];
require "../source/top.php";
$pid= 205000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-plus"></i> Office Information maintenance </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div>
        <!-- collapse -->
        <button data-toggle="collapse" data-target="#demo" class="btn btn-success float-right"><i class="fa fa-plus" aria-hidden="true"></i>Add New Office</button>
        <br>
        <hr>
        <div id="demo" class="collapse">
          <div style="padding:5px;">
            <!-- form start  -->
            <form action="" method="post">
              <!-- acc conde  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Office Code</label>
                <div class="col-sm-6">
                  <input type="text" readonly name="office_code" class="form-control" autofocus value=<?php if (!empty($lastRowrow)) {
                                                                                                      echo $lastRowrow;
                                                                                                    } ?>>
                </div>
              </div>
              
              <script>
                function office_check_availability() {
                  var name = $("#office_name").val();
                  $("#loaderIcon").show();
                  jQuery.ajax({
                    url: "office_check_availability.php",
                    data: 'office_name=' + name,
                    type: "POST",
                    success: function(data) {
                      $("#name_availability_status").html(data);
                      $("#loaderIcon").hide();
                    },
                    error: function() {}
                  });
                }
              </script>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Office  Name</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="office_name" name="office_name" onkeyup="office_check_availability()" value=<?php echo $_SESSION["org_name"] ?>required>
                  <tr>
                    <th width="24%" scope="row"></th>
                    <td><span id="name_availability_status"></span></td>
                  </tr>
                </div>
              </div>
          </div>
                   
                  
          <!-- Office Type  -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">office_type</label>
            <div class="col-sm-6">
              <select name="office_type" class="form-control" required>
                <?php
                $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "OFFTP" AND `softcode`>0';
                $selectQueryResult =  $conn->query($selectQuery);
                if ($selectQueryResult->num_rows) {
                  while ($row = $selectQueryResult->fetch_assoc()) {
                    echo '<option value="' . $row['softcode'] . '">'  . $row['description'] . '</option>';
                  }
                }
                ?>
              </select>
            </div>
          </div>
           
          <!-- lavel  -->
          <input type="number" name="level_no" class="form-control" value="2" hidden>
          <input type="number" class="form-control" name="parent_code" value="0" hidden>
          <!-- submit  -->
          <div class="form-group row">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary" name="subBtn" <?php if($lastRowrow>=6000000000){echo "disabled";} ?>>Submit</button>
            </div>
          </div>
          </form>
        </div>
      </div>
      <hr>
      <!-- form close  -->
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
      <!-- table view start  -->
      <div class="tile">
        <div class="tile-body">
          <table class="table table-hover table-bordered table-sm" id="sampleTable">
            <thead>
              <tr>
                <th >Office_type </th>
                <th>Office Name</th>
                <th>Office Address</th>
                <th> Email</th>
                <th>Contract Person</th>
                <th>contract Mobile No.</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $output = '';
              $level_code=0;
              $sql = "SELECT office_info.id, office_info.office_code,office_info.office_name,office_info.parent_code,office_info.level_no,office_info.office_type, office_info.ad_br_code, office_info.office_cont_person, office_info.office_con_mobile_no, office_info.office_address, office_info.email_add, office_info.ad_br_code,  office_info.micr_code, code_master.description FROM office_info,code_master where office_info.office_type=code_master.softcode AND code_master.hardcode='OFFTP' order by office_info.office_code";
              $query = $conn->query($sql);
              while ($rows = $query->fetch_assoc()) {
                
                  if ($rows['level_no'] == 2) {
                    $output .=  "<tr>
                      <td>". $rows['description']."</td>
                      <td style='color:red; font-weight:bold'>". $rows['office_name']."</td>
                      <td>" . $rows['office_address'] . "</td>
                      <td>" . $rows['email_add'] . "</td>
                      <td>" . $rows['office_cont_person'] . "</td>
                      <td>" . $rows['office_con_mobile_no'] . "</td>
                      
                      <td><a href='office_info_add.php?id=" . $rows['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Sub Office</a>
                      <a href='office_info_edit.php?recordid=" . $rows['id'] . "' class='btn btn-success btn-sm'><i class='fa fa-pencil-square-o' aria-hidden='true'></i>Edit</a>
                      <a href='#delete_" . $rows['id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='fa fa-trash'></span>Delete</a>
                      </td>
                      </tr>";
                  } elseif ($rows['level_no'] == 3) {
                    $output .=  "<tr><td>". $rows['description']."</td>
                      <td style='text-indent:20px;color:gray; font-weight:bold'>". $rows['office_name']."</td>
                      <td>" . $rows['office_address'] . "</td>
                      <td>" . $rows['email_add'] . "</td>
                      <td>" . $rows['office_cont_person'] . "</td>
                      <td>" . $rows['office_con_mobile_no'] . "</td>
                     
                      <td><a href='office_info_add.php?id=" . $rows['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Sub Office</a>
                      <a href='office_info_edit.php?recordid=" . $rows['id'] . "' class='btn btn-success btn-sm'><i class='fa fa-pencil-square-o' aria-hidden='true'></i>Edit</a>
                      <a href='#delete_" . $rows['id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='fa fa-trash'></span>Delete</a>
                      </td>
                      </tr>";
                    } elseif ($rows['level_no'] == 4) {
                      $output .=  "<tr><td>". $rows['description']."</td>
                        <td style='text-indent:50px;color:gray; font-weight:bold'>". $rows['office_name']."</td>
                        <td>" . $rows['office_address'] . "</td>
                        <td>" . $rows['email_add'] . "</td>
                        <td>" . $rows['office_cont_person'] . "</td>
                        <td>" . $rows['office_con_mobile_no'] . "</td>
                        
                        <td><a href='office_info_add.php?id=" . $rows['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Sub Office</a>
                        <a href='office_info_edit.php?recordid=" . $rows['id'] . "' class='btn btn-success btn-sm'><i class='fa fa-pencil-square-o' aria-hidden='true'></i>Edit</a>
                        <a href='#delete_" . $rows['id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='fa fa-trash'></span>Delete</a>
                        </td>
                        </tr>";
                  "<tr>
				          
								</tr>";
                include('delete.php');
              }
            }
            echo $output;
              ?>
               
            </tbody>
          </table>
        </div>
      </div>

      <!-- table view end -->
    </div>
    <!-- ----------------code here---------------->
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
<!-- Data table plugin-->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#sampleTable').DataTable();
</script>
<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#301000").addClass('active');
    $("#300000").addClass('active');
    $("#300000").addClass('is-expanded');
  });
  // more informatino script start
  $('#more_show').hide();
  var id = this.value;
  $('#more').on('click', function() {
    $('#more_show').show(1000);
  });
  //=========
  $('.group').on('click', function() {
    $('#more_show').hide();
  });
  //=========
  $('#aaa').on('change', function() {
    //  alert(this.value);
    var id = this.value;
    if (id == Y) {
      // alert('ok');
      $.ajax({
        type: "post",
        url: "get_more_info.php",
        data: "id=" + id,
        dataType: "JOSN",
        success: function(response) {}
      });
    }

  });
</script>
<?php
$conn->close();
?>
</body>

</html>