<?php
require "../auth/auth.php";
require "../database.php";
//update query
if (isset($_POST['subBtn'])) {

  $office_code = $_SESSION['office_code'];
  $acc_code = $_POST['acc_code'];
  $acc_on = $_POST['acc_on'];
  
   
  if ($acc_on=='1') {
      $acc_head = $_POST['acc_head1'];
  } elseif ($acc_on=='2') {
      $acc_head = $_POST['acc_head2'];
    } elseif ($acc_on=='3') {
      $acc_head = $_POST['acc_head3'];
    }

  //  echo $acc_head;
  // exit;
  $postable_acc = $_POST['postable_acc'];

  $rep_glcode = $_POST['rep_glcode'];
  $category_code = $_POST['category_code'];
  $acc_level = $_POST['acc_level'];
  $acc_type = $_POST['acc_type'];
  $parent_acc_code = $_POST['parent_acc_code'];
  $subsidiary_group_code=$_POST['subsidiary_group_code'];
  $ss_creator = $_SESSION['username'];
  $ss_org_no = $_SESSION['org_no'];

 $insertQuery = "INSERT INTO `gl_acc_code` (`id`,`office_code`, `acc_code`, `acc_head`, `postable_acc`,`rep_glcode`,`is_ho_acc`,`category_code`,`acc_level`,`acc_type`,`parent_acc_code`,`is_root`,`exch_rate`,`subsidiary_group_code`,`ss_creator`,`ss_creator_on`,`ss_modifier_on`,`ss_org_no`) VALUES (NULL,'$office_code','$acc_code','$acc_head','$postable_acc','$rep_glcode','Y','$category_code','$acc_level','$acc_type','$parent_acc_code','1','0','$subsidiary_group_code','$ss_creator',now(),now(),'$ss_org_no')";
 
    // echo $insertQuery;
    // exit ;
  $conn->query($insertQuery);
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
    header('refresh:2;owner_info.php');
  } else {
    $mess = "Failled!";
    header("refresh:2;owner_gl_account_add.php?id=$idno");
  }
  $conn->query("UPDATE apart_owner_info SET gl_acc_code='$acc_code' WHERE owner_id='$owner_id'");
  header('refresh:1;owner_info.php');
}

if (isset($_GET['id'])) {
    $idno = $_GET['id'];
    $sql= "SELECT `id`, `flat_no`,`owner_id`, flat_title FROM `flat_info` WHERE `id`='$idno'";
    $sqlResult = $conn->query($sql);
    $rows = $sqlResult->fetch_assoc();
    $owner_id=$rows['owner_id'];
    $flat_no=$rows['flat_no'];
    $flat_title=$rows['flat_title'];

    $sql_owner= "SELECT id, owner_id, owner_name FROM apart_owner_info WHERE `owner_id`='$owner_id'";
    $sqlResult_owner = $conn->query($sql_owner);
    $rows_owner = $sqlResult_owner->fetch_assoc();
    $owner_name=$rows_owner['owner_name'];
     
    $sql_tenant= "SELECT `id`, `tenant_under_owner_id`, tenant_name FROM `apart_tenant_info` WHERE `flat_no`='$flat_no' limit 0,1";
    $sqlResult_tenant = $conn->query($sql_tenant);
    $rows_tenant = $sqlResult_tenant->fetch_assoc();
    $rowcount = mysqli_num_rows($rows_tenant);
    if ($rowcount == '0') {
          $tenant_name= "Not Avaiable";
    }else{
         $tenant_name= $rows_tenant['tenant_name'];  
    }


  $selectQuery = "select * from gl_acc_code where subsidiary_group_code='800' and `postable_acc`='N'";
  $selectQueryReuslt = $conn->query($selectQuery);
  $row = $selectQueryReuslt->fetch_assoc();
}
?>
<?php
$id=$row['id'];
$query = "Select Max(acc_code) FROM gl_acc_code where `parent_acc_code`='$id'";
$returnD = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($returnD);
$maxRows = $result['Max(acc_code)'];
  
    
      if ($row['acc_level'] == 1) {
        $lastRow = $maxRows + 1000000000;
      } elseif ($row['acc_level'] == 2) {
        $lastRow = $maxRows + 10000000;
      } elseif ($row['acc_level'] == 3) {
        $lastRow = $maxRows + 100000;
      } elseif ($row['acc_level'] == 4) {
        $lastRow = $maxRows + 1000;
      } elseif ($row['acc_level'] == 5) {
        $lastRow = $maxRows + 10;
      }
    
    ?>

<?php
$maxRows1 = $row['acc_level'];
if (empty($maxRows1)) {
  $lastRows = $maxRows1 = 1;
} else {
  $lastRows = $maxRows1 + 1;
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
      <h1><i class="fa fa-dashboard"></i> Owner GL A/C </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <!-- form start  -->
      <form action="" method="post">
        
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Billing Account for Flat/Shop Number</label>
          <div class="col-sm-6">
            <input type="text" name="flat_no" class="form-control"id="flat_id" autofocus value="<?php echo $flat_no; ?>"readonly>
          </div>
          <!-- uner account -->
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Sub Account Under</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" value="<?php echo $row['acc_head'] ?>" readonly>
          </div>
        </div>
        <!-- acc conde  -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Account Code</label>
          <div class="col-sm-6">
            <input type="text" name="acc_code" class="form-control" autofocus value=<?php echo $lastRow; ?>>
          </div>
        </div>
        
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Title Could Be</label>
          <div class="col-sm-6">
                
              <h5  style="text-align:left"> <?php echo "Shop Name:-"; echo "  "; echo $flat_title; ?></h5> 
              <h5  style="text-align:left"> <?php   echo "Owner Name:-";echo "  "; echo $owner_name;?></h5>
              <h5  style="text-align:left"> <?php    echo "Tenant Name:-";echo "  "; echo $tenant_name;  ?></h5> 
        
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Account On</label>
          <div class="col-sm-6">
                    <select name="acc_on" class="form-control select2">
                    <option value="1">Shop/Flat Name</option>
                    <option value="2">Owner Name</option>
                    <option value="3">Tenant Name</option>
                  </select>
          </div>
        </div>

        
        
        <input type="text" name="postable_acc" value="Y" onclick="Fun()" id="more" hidden>
          
       
        <!-- reporting  -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reporting GL Code</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="" name="rep_glcode" value=<?php echo $lastRow; ?>>
          </div>
        </div>
        <!-- category  hidden but input value by catagory-->
        
        <input type="text" class="form-control" id="" value="<?php echo $rows['flat_title']; ?>" name="acc_head1" hidden>
        <input type="text" class="form-control" id="" value="<?php echo $rows_owner['owner_name']; ?>" name="acc_head2" hidden>
        <input type="text" class="form-control" id="" value="<?php echo $tenant_name; ?>" name="acc_head3" hidden>
        <input type="text" class="form-control" id="" value="<?php echo $row['subsidiary_group_code']; ?>" name="subsidiary_group_code" hidden>
        <input type="text" class="form-control" id="" value="<?php echo $row['category_code']; ?>" name="category_code" hidden>
        <!-- Account Type  -->
        <input type="text" class="form-control" id="" value="7" name="acc_type" hidden>
        <!-- hidden parant account code and account level set up-->
        <input type="number" class="form-control" name="parent_acc_code" value="<?php echo $row['id']; ?>" hidden>
        <input type="text" name="acc_level" class="form-control" required autofocus placeholder="ID" value=<?php if (!empty($lastRows)) {
                                                                                                              echo $lastRows;
                                                                                                            } ?> hidden>
        <!-- submit  -->
        <div class="form-group row">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary" name="subBtn">Submit</button>
          </div>
        </div>
      </form>
    </div>
    <!-- form close  -->
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
  }
  if (!empty($mess)) {
    echo '<script type="text/javascript">
          Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
  }
  ?>
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#301000").addClass('active');
    $("#300000").addClass('active');
    $("#300000").addClass('is-expanded');
  });
  // more informatino script start....
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
</body>
</html>