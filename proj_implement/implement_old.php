<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['submit'])) {
  
  
  
  $office_code = $_POST['office_code'];
  $ss_creator = $_POST['ss_creator'];
  $ss_created_on = $_POST['ss_created_on']; 

  $ss_org_no = $_POST['ss_org_no'];


// =======clean Data from  supply table =====

$updateQuery = "TRUNCATE TABLE bach_no";
$conn->query($updateQuery);

// ==========update Code Master=============
$updateQuery = "update code_master set office_code='$office_code', created_by='$ss_creator', created_date='$ss_created_on', modify_by='', modify_date='', ss_org_no='$ss_org_no'";
$conn->query($updateQuery);

// ==========update SM Role=============
$updateQuery = "update sm_role set office_code='$office_code', ss_creator='$ss_creator', ss_created_on='$ss_created_on', ss_modifier='', ss_modified_on='',ss_org_no='$ss_org_no'";
$conn->query($updateQuery);

// ==========update SM menu=============
$updateQuery = "update sm_menu set office_code='$office_code', ss_creator='$ss_creator', ss_created_on='$ss_created_on', ss_modifier='', ss_modified_on='',ss_org_no='$ss_org_no'";
$conn->query($updateQuery);

// ==========update SM Role Dtl=============
$updateQuery = "update sm_role_dtl set office_code='$office_code', ss_creator='$ss_creator', ss_created_on='$ss_created_on', ss_modifier	='', ss_modified_on	='',ss_org_no='$ss_org_no'";
$conn->query($updateQuery);




  if ($conn->affected_rows == 1) {
    $message = "Failled!";
  } else {
    $mess = "Save owner Successfully!";
  }
  header('refresh:1;implement.php');
}


require "../source/top.php";
$pid= 1005000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Project Implementation Software </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>



  
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
}
</style>
</head>
<body>



  <?php if ($seprt_cs_info == 'Y') { ?>


  <!-- =================-- button define================= -->
  <div class="topnav">
       <button id="updateFileBtn" class="btn btn-success col-md-6><a class="active"></i>Update File</button>
      <button id="flatListBtn" class="btn btn-primary col-md-6><a class=""></i>Insert Data </button>
      <button id="flatListBtn" class="btn btn-primary col-md-6><a class=""></i>Delete Data </button>
      <button id="flatListBtn" class="btn btn-primary col-md-6><a class=""></i>Transfer Data </button>
</div>

    <!-- ====================button Define closed=============== -->
   
    <div class="row">
      <div class="col-md-12">
        <div>
            <br>
               <div id="updateFile" class="collapse">
                   <div style="padding:5px">
                        <!-- form start  -->
                    <form action="" method="post">     
                   <!-- =======================Office Code ==================================-->
                    <div class="form-row form-group">
                        <div class="col-sm-6">
                             <div class="card">
                                  <div class="card-header">
                                      Update Data
                                   </div>
                                   <div class="card-body">
                                      <div class="form-row form-group">
                                          <label class="col-sm-5 col-form-label">Office Code </label>
                                          <label class="col-form-label">:</label>
                                          <div class="col">
                                              <input type="text" class="form-control" id="" name="office_code">
                                         </div> 
                                    </div>
                   <!---------================Data Creator.===================---------------------------------->
                                 <div class="form-group row">
                                         <label class="col-sm-5 col-form-label"> Data Creator </label>
                                         <label class="col-form-label">:</label>
                                      <div class="col">
                                          <input type="text" class="form-control" id="" name="ss_creator">
                                      </div>
                                 </div>
                    <!---------================Data Created Date .===================---------------------------------->
                                 <div class="form-group row">
                                         <label class="col-sm-5 col-form-label">Data Created Date</label>
                                         <label class="col-form-label">:</label>
                                      <div class="col">
                                          <input type="date" class="form-control" id="" name="ss_created_on">
                                      </div>
                                 </div>              
                  <!------------============== Data Modified By ===================---------------------->
                                  <div class="form-group row">
                                         <label class="col-sm-5 col-form-label">Data Modified By </label>
                                         <label class="col-form-label">:</label>
                                      <div class="col">
                                          <input type="date" class="form-control" id="" name="ss_modifier">
                                      </div>
                                 </div>              
                   <!------------============== Data Modified By ===================---------------------->
                                  <div class="form-group row">
                                         <label class="col-sm-5 col-form-label">Data Modified By</label>
                                         <label class="col-form-label">:</label>
                                      <div class="col">
                                          <input type="date" class="form-control" id="" name="ss_modified_on">
                                      </div>
                                 </div>
                     
                 <!-- ===============Organization Code==============================-->
                                 <div class="form-group row">
                                        <label class="col-sm-5 col-form-label">Organization Code</label>
                                        <label class="col-form-label">:</label>
                                   <div class="col">
                                         <input type="text" class="form-control" id="" name="ss_org_no" required>
                                   </div>
                                  </div>           
                        <div >
                            <input type="hidden" name="activation_key" value="0">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                     </div>
                   </div>
                 </div>

            </div>
          </div>
        </div>
  
       
      </form> 
     </div>
   </div>
   </div>
   </div>

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


          <!--================================= fund View List===================================================-->
          <div id="table">
            <div class="tile" id="flatList">
              <div class="tile-body">
                <h5 style="text-align: center">Data Delete from Table</h5>
                <!-- General Account View start -->
                
             </div>
           </div>
        <?php
      } else {
        echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
      } ?>
        <!-- Supplier Account View start -->
        </div>
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
  $('#memberTable').DataTable();
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#907000").addClass('active');
    $("#900000").addClass('active');
    $("#900000").addClass('is-expanded')
  });

  $('#flatList').hide();

  // updateFile
  $('#updateFileBtn').on('click', function() {
    $('#updateFile').show();
    $('#flatList').hide();
    
  });
  // memberistBtn
  $('#flatListBtn').on('click', function() {
    $('#flatList').show();
    $('#updateFile').hide();
  });
  
  </script>
 

<?php
$conn->close();

?>
</body>

</html>




