<?php
require "../auth/auth.php";
require "../database.php";
// echo $seprt_cs_info;exit;
//update query
if (isset($_POST['subBtn'])) {
  $office_code = $_POST['office_code'];
  $office_name = $_POST['office_name'];
  $office_type = $_POST['office_type'];
  $office_address = $_POST['office_address'];
  $parent_code = $_POST['parent_code'];
  $level_no = $_POST['level_no'];
  $office_cont_person = $_POST['office_cont_person'];
  $office_con_mobile_no = $_POST['office_con_mobile_no'];
  $email_add = $_POST['email_add'];
  $ad_br_code = $_POST['ad_br_code'];
  $micr_code = $_POST['micr_code'];
  $parent_code = $_POST['parent_code'];

  $ss_creator = $_SESSION['username'];
  
  $ss_org_no = $_SESSION['org_no'];

  $insertQuery = "INSERT INTO `office_info` (`id`,`office_code`, `office_name`,`office_type` ,`office_address`,`parent_code`,`level_no`,`office_cont_person`,`office_con_mobile_no`,`email_add`,`ad_br_code`,`micr_code`,`ss_creator`,`ss_created_on`,`ss_org_no`) VALUES (NULL,'$office_code','$office_name','$office_type','$office_address','$parent_code','$level_no','$office_cont_person','$office_con_mobile_no','$email_add','$ad_br_code','$micr_code','$ss_creator',now(),'$ss_org_no')";
  $conn->query($insertQuery);
  // echo $insertQuery; exit;
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
  } else {
    $mess = "Failled!";
  }
}
//select query start
if (isset($_GET['id'])) {
  $idno = $_GET['id'];
  $selectQuery = "select * from office_info where id='" . $_GET['id'] . "'";
  $selectQueryReuslt = $conn->query($selectQuery);
  $row = $selectQueryReuslt->fetch_assoc();
}
?>
<?php
$query = "Select Max(office_code) From office_info where id= $_GET[id]";
$returnD = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($returnD);
$maxRows = $result['Max(office_code)'];
$selectQuery = "SELECT parent_code FROM `office_info`";
$selectQueryResult = $conn->query($selectQuery);
if ($selectQueryResult->num_rows) {
  while ($rowss = $selectQueryResult->fetch_array()) {
?>
    <?php
    if ($_GET['id'] != $rowss['parent_code']) {
      if ($row['level_no'] == 1) {
        if (empty($row['office_code'])) {
          $lastRow = $row['office_code'] + 1000000000;
        } else {
          $lastRow = $maxRows + 1000000000;
        }
      } elseif ($row['level_no'] == 2) {
        if (empty($row['office_code'])) {
          $lastRow = $row['office_code'] + 10000000;
        } else {
          $lastRow = $maxRows + 10000000;
        }
      } elseif ($row['level_no'] == 3) {
        if (empty($row['office_code'])) {
          $lastRow = $row['office_code'] + 100000;
        } else {
          $lastRow = $maxRows + 100000;
        }
      } elseif ($row['level_no'] == 4) {
        if (empty($row['office_code'])) {
          $lastRow = $row['office_code'] + 1000;
        } else {
          $lastRow = $maxRows + 1000;
        }
      } elseif ($row['level_no'] == 5) {
        if (empty($row['office_code'])) {
          $lastRow = $row['office_code'] + 10;
        } else {
          $lastRow = $maxRows + 10;
        }
      }
    } else {
      $query = "Select Max(office_code) From office_info where $_GET[id]=parent_code";
      $returnD = mysqli_query($conn, $query);
      $result = mysqli_fetch_assoc($returnD);
      $maxRows = $result['Max(office_code)'];
      if ($row['level_no'] == 1) {
        $lastRow = $maxRows + 1000000000;
      } elseif ($row['level_no'] == 2) {
        $lastRow = $maxRows + 10000000;
      } elseif ($row['level_no'] == 3) {
        $lastRow = $maxRows + 100000;
      } elseif ($row['level_no'] == 4) {
        $lastRow = $maxRows + 1000;
      } elseif ($row['level_no'] == 5) {
        $lastRow = $maxRows + 10;
      }
    }
    ?>
<?php
  }
}
?>
<?php
$maxRows1 = $row['level_no'];
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
      <h1><i class="fa fa-dashboard"></i>Office Information Maintenance</h1>
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
        <!-- uner account -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Sub Office Under</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" value="<?php echo $row['office_name'] ?>" readonly>
          </div>
        </div>
        <!-- acc conde  -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">office  Code</label>
          <div class="col-sm-6">
            <input type="text" name="office_code" class="form-control" autofocus value=<?php echo $lastRow; ?> readonly>
          </div>
        </div>
        <!-- account name  -->
        <script>
          function gl_account_check_availability() {
            var name = $("#office_name").val();
            $("#loaderIcon").show();
            jQuery.ajax({
              url: "gl_account_check_availability.php",
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
          <label class="col-sm-2 col-form-label">Office Name</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="office_name" name="office_name" onkeyup="gl_account_check_availability()" required>
            <tr>
              <th width="24%" scope="row"></th>
              <td><span id="name_availability_status"></span></td>
            </tr>
          </div>
        </div>

        <!-- ==============office Type=========== -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Office Type</label>
          <div class="col-sm-6">
          <select name="office_type" id="" class="form-control" required >
          <?php
          $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "OFFTP" AND `softcode`>0';
          $selectQueryResult =  $conn->query($selectQuery);
          if ($selectQueryResult->num_rows) {
            while ($rows = $selectQueryResult->fetch_assoc()) {
          ?>
              <option value="<?php echo $rows['softcode']; ?>" <?php if ($row['office_type'] == $rows['softcode']) {
                                                                  echo "selected";
                                                                } ?>><?php echo $rows['description']; ?></option>
          <?php
            }
          }
          ?>
        </select>
          </div>
        </div>
        <!-- =========office_address =============-->
        <div class="form-group row">
              <label class="col-sm-2 col-form-label">office_address</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="" name="office_address">
              </div>
            </div>
             <!-- office_cont_person -->
             <div class="form-group row">
              <label class="col-sm-2 col-form-label">Contract Officer</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="" name="office_cont_person">
              </div>
            </div>
            <!-- office_con_mobile_no -->
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Mobile Number</label>
              <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="office_con_mobile_no">
              </div>
            </div>
            <!-- email_add -->
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Email Address</label>
              <div class="col-sm-6">
              <input type="text" class="form-control" id="" name="email_add">
              </div>
            </div>
          <!-- AD Branch Code -->
        <div class="form-group row">
              <label class="col-sm-2 col-form-label">Authorized Dealer Code</label>
              <div class="col-sm-6">
              <input type="text" class="form-control" id="" name="ad_br_code">
              </div>
            </div>   
        <!-- MICR Code -->
        <div class="form-group row">
              <label class="col-sm-2 col-form-label">MICR Code</label>
              <div class="col-sm-6">
              <input type="text" class="form-control" id="" name="micr_code">
              </div>
            </div>
        <!-- reporting  Office Code -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reporting Office Code</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="" name="ad_br_code">
          </div>
        </div>
        
        
        <!-- hidden parant account code and account level set up-->
        <input type="number" class="form-control" name="parent_code" value="<?php echo $_GET['id']; ?>" hidden>
        <input type="text" name="level_no" class="form-control" required autofocus placeholder="ID" value=<?php if (!empty($lastRows)) {
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