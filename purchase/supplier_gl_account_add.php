<?php
require "../auth/auth.php";
require "../database.php";
//update query
if (isset($_POST['subBtn'])) {
  $office_code = $_SESSION['office_code'];
  $acc_code = $_POST['acc_code'];
  $acc_head = $_POST['acc_head'];
  $postable_acc = $_POST['postable_acc'];
  $address = $_POST['address'];
  $vat_no = $_POST['vat_no'];
  $tin_no = $_POST['tin_no'];
  $taxable_flag = $_POST['taxable_flag'];
  $buyer_saler_flag = $_POST['buyer_saler_flag'];
  $rep_glcode = $_POST['rep_glcode'];
  $category_code = $_POST['category_code'];
  $acc_level = $_POST['acc_level'];
  $acc_type = $_POST['acc_type'];
  $parent_acc_code = $_POST['parent_acc_code'];
  $is_ho_acc='1';
  $is_root='1';
  $exch_rate='1';
  $subsidiary_group_code=$_POST['subsidiary_group_code'];

  $ss_creator = $_SESSION['username'];
  $ss_creator_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_modifier = $_SESSION['username'];
  $ss_modifier_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  $insertQuery = "INSERT INTO `gl_acc_code` (`id`,`office_code`, `acc_code`, `acc_head`, `postable_acc`,`address`,`vat_no`,`tin_no`,`taxable_flag`,`buyer_saler_flag`,`rep_glcode`,is_ho_acc, is_root, exch_rate,`category_code`,`acc_level`,`acc_type`,`parent_acc_code`,subsidiary_group_code,`ss_creator`,`ss_creator_on`,ss_modifier, ss_modifier_on,`ss_org_no`) VALUES (NULL,'$office_code','$acc_code','$acc_head','$postable_acc','$address','$vat_no','$tin_no','$taxable_flag','$buyer_saler_flag','$rep_glcode','$is_ho_acc','$is_root','$exch_rate','$category_code','$acc_level','$acc_type','$parent_acc_code','$subsidiary_group_code','$ss_creator','$ss_creator_on','$ss_modifier','$ss_modifier_on','$ss_org_no')";
  
  $conn->query($insertQuery);
//   echo $insertQuery;
//   exit;
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
 
  } else {
    $mess = "Failled!";
    header("refresh:2;gl_account_add.php?id=$idno");
  }
  $conn->query("UPDATE `supp_info` SET `gl_acc_code`='$acc_code' WHERE supp_name='$acc_head'");
  header('refresh:1;supp_info.php');
}
//select query start
if (isset($_GET['id'])) {
  $idno = $_GET['id'];
  $selectQuery = "select * from gl_acc_code where id='" . $_GET['id'] . "'";
  $selectQueryReuslt = $conn->query($selectQuery);
  $row = $selectQueryReuslt->fetch_assoc();
}
?>
<?php
$query = "Select Max(acc_code) From gl_acc_code where id= $_GET[id]";
$returnD = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($returnD);
$maxRows = $result['Max(acc_code)'];
$selectQuery = "SELECT parent_acc_code FROM `gl_acc_code`";
$selectQueryResult = $conn->query($selectQuery);
if ($selectQueryResult->num_rows) {
  while ($rowss = $selectQueryResult->fetch_array()) {
?>
    <?php
    if ($_GET['id'] != $rowss['parent_acc_code']) {
      if ($row['acc_level'] == 1) {
        if (empty($row['acc_code'])) {
          $lastRow = $row['acc_code'] + 1000000000;
        } else {
          $lastRow = $maxRows + 1000000000;
        }
      } elseif ($row['acc_level'] == 2) {
        if (empty($row['acc_code'])) {
          $lastRow = $row['acc_code'] + 10000000;
        } else {
          $lastRow = $maxRows + 10000000;
        }
      } elseif ($row['acc_level'] == 3) {
        if (empty($row['acc_code'])) {
          $lastRow = $row['acc_code'] + 100000;
        } else {
          $lastRow = $maxRows + 100000;
        }
      } elseif ($row['acc_level'] == 4) {
        if (empty($row['acc_code'])) {
          $lastRow = $row['acc_code'] + 1000;
        } else {
          $lastRow = $maxRows + 1000;
        }
      } elseif ($row['acc_level'] == 5) {
        if (empty($row['acc_code'])) {
          $lastRow = $row['acc_code'] + 10;
        } else {
          $lastRow = $maxRows + 10;
        }
      }
    } else {
      $query = "Select Max(acc_code) From gl_acc_code where $_GET[id]=parent_acc_code";
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
    }
    ?>
<?php
  }
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
      <h1><i class="fa fa-dashboard"></i> Supplier GL A/C </h1>
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
            <input type="text" name="acc_code" class="form-control" autofocus value=<?php echo $lastRow; ?>>
          </div>
        </div>
        <!-- account name  -->
        <script>
          function gl_account_check_availability() {
            var name = $("#acc_head").val();
            $("#loaderIcon").show();
            jQuery.ajax({
              url: "gl_account_check_availability.php",
              data: 'acc_head=' + name,
              type: "POST",
              success: function(data) {
                $("#name_availability_status").html(data);
                $("#loaderIcon").hide();
              },
              error: function() {
                alert("failled");
              }
            });
          }
        </script>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Account Name</label>
          <div class="col-sm-6">
            <select name="acc_head" id="acc_head" class="form-control" onchange="gl_account_check_availability()" required>
              <option value="">-Select Account Name-</option>
              <?php
              $selectQuery = 'SELECT * FROM `supp_info`';
              $selectQueryResult =  $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($row2 = $selectQueryResult->fetch_assoc()) {
                  echo '<option value="' . $row2['supp_name'] . '">'  . $row2['supp_name'] . '</option>';
                }
              }
              ?>
            </select>
            <tr>
              <th width="24%" scope="row"></th>
              <td><span id="name_availability_status"></span></td>
            </tr>
          </div>
        </div>
        <input type="text" name="postable_acc" value="Y" onclick="Fun()" id="more" hidden>
        <!-- ====== more information start ====== -->
        <div id="more_show">
          <!-- address -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="" name="address">
            </div>
          </div>
          <!-- vat_no -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">VAT No</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="" name="vat_no">
            </div>
          </div>
          <!-- tin_no -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">TIN No</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="" name="tin_no">
            </div>
          </div>
          <!-- taxable_flag -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">TAX Status</label>
            <div class="col-sm-6">
              <select name="taxable_flag" id="" class="form-control">
                <option value="">---select---</option>
                <option value="1">TAX Able Status</option>
                <option value="2">None TAX Able</option>
              </select>
            </div>
          </div>
          <!-- buyer_saler_flag -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Buyer / Saler Status</label>
            <div class="col-sm-6">
              <select type="text" class="form-control" id="" name="buyer_saler_flag">
                <option value="">---select---</option>
                <option value="1">Buyer</option>
                <option value="2">Saler</option>
              </select>
            </div>
          </div>
        </div>
        <!-- ====== more information end ====== -->
        <!-- reporting  -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reporting GL Code</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="" name="rep_glcode">
          </div>
        </div>
        <!-- category  hidden but input value by catagory-->
        <input type="text" class="form-control" id="" value="<?php echo $row['subsidiary_group_code']; ?>" name="subsidiary_group_code" hidden>
        <input type="text" class="form-control" id="" value="<?php echo $row['category_code']; ?>" name="category_code" hidden>
        <input type="text" class="form-control" id="" value="6" name="acc_type" hidden>

        <!-- </div>
        </div> -->
        <!-- hidden parant account code and account level set up-->
        <input type="number" class="form-control" name="parent_acc_code" value="<?php echo $_GET['id']; ?>" hidden>
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