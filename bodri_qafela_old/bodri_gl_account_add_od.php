<?php
require "../auth/auth.php";
require "../database.php";
//update query
if (isset($_POST['subBtn'])) {
  $office_code = $_SESSION['office_code'];
  $acc_code = $_POST['acc_code'];
  $acc_head = $_POST['full_name'];
  $member_no = $_POST['member_no'];
  $postable_acc = 'Y';
  $rep_glcode = $_POST['rep_glcode'];
  $category_code = $_POST['category_code'];
  $acc_level = $_POST['acc_level'];
  $acc_type = $_POST['acc_type'];
  $parent_acc_code = $_POST['parent_acc_code'];
  $subsidiary_group_code=$_POST['subsidiary_group_code'];

  $ss_creator = $_SESSION['username'];
  $ss_org_no = $_SESSION['org_no'];

  $insertQuery = "INSERT INTO `gl_acc_code` (`id`,`office_code`, `acc_code`, `acc_head`, `postable_acc`,`rep_glcode`,`category_code`,`acc_level`,`acc_type`,`parent_acc_code`,subsidiary_group_code,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$acc_code','$acc_head','$postable_acc','$rep_glcode','$category_code','$acc_level','$acc_type','$parent_acc_code','$subsidiary_group_code','$ss_creator',now(),'$ss_org_no')";
  $conn->query($insertQuery);
  // echo $insertQuery;
  // exit;
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
 
  } else {
    $mess = "Failled!";
    header("refresh:2;bodri_gl_account_add.php");
  }
  $conn->query("UPDATE `fund_member` SET `gl_acc_code`='$acc_code' WHERE  member_no='$member_no'");
  // echo $insertQuery;
  // exit;
  // header("refresh:2;bodri_gl_account_add.php");
   header('refresh:1;gl_fund_assigned.php');
}
//select query start

?>
<?php
$selectQuery = "select * from gl_acc_code where subsidiary_group_code='400' and `postable_acc`='N'";
$selectQueryReuslt = $conn->query($selectQuery);
$row = $selectQueryReuslt->fetch_assoc();

$id=$row['id'];
$query = "Select Max(acc_code) FROM gl_acc_code where `parent_acc_code`='$id'";
// $query = "Select Max(acc_code) FROM gl_acc_code where `id`='$id'";

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
if (isset($_GET['id'])) {
  $idno = $_GET['id'];
  $selectQuery = "SELECT full_name, member_no FROM `fund_member` WHERE `member_id`='$idno'";
  $selectQueryReuslt = $conn->query($selectQuery);
  $row_member = $selectQueryReuslt->fetch_assoc();

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
      <h1><i class="fa fa-dashboard"></i> Donner GL A/C </h1>
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
          <label class="col-sm-2 col-form-label">Sub Account Under</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" value="<?php echo $row['acc_head'] ?>" readonly>
          </div>
        </div>
        <!-- acc conde  -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Account Code</label>
          <div class="col-sm-6">
            <input type="text" name="acc_code" class="form-control"  value="<?php echo $lastRow; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Member No</label>
          <div class="col-sm-6">
                <input type="text" name="member_no" class="form-control" value="<?php echo $row_member['member_no']; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Account Name</label>
          <div class="col-sm-6">
                <input type="text" name="full_name" class="form-control" value="<?php echo $row_member['full_name']; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reporting GL Code</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="" name="rep_glcode">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary" name="subBtn">Submit</button>
          </div>
        </div>
        <div>
        <!-- category  hidden but input value by catagory-->
        <input type="text" class="form-control" id="" value="<?php echo $row['subsidiary_group_code']; ?>" name="subsidiary_group_code" hidden>
        <input type="text" class="form-control" id="" value="<?php echo $row['category_code']; ?>" name="category_code" hidden>
        <input type="text" class="form-control" id="" value="<?php echo $row['acc_type']; ?>" name="acc_type" hidden>

        
        <!-- hidden parant account code and account level set up-->
        <input type="number" class="form-control" name="parent_acc_code" value="<?php echo $row['id']; ?>" hidden>
        <input type="text" name="acc_level" class="form-control"  value="<?php echo $lastRows; ?>" hidden>
                                                                                                         </div>
        
      </form>
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