<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
//update query
if (isset($_POST['submit'])) {
  $acc_code = $_POST['acc_code'];
  $acc_head = $_POST['acc_head'];
  $postable_acc = $_POST['postable_acc'];
  $rep_glcode = $_POST['rep_glcode'];
  $category_code = $_POST['category_code'];
  $acc_type = $_POST['acc_type'];
  $subsidiary_group_code = $_POST['subsidiary_group_code'];
  $ss_modifier = $_SESSION['username'];
  $ss_modifier_on = date("Y-m-d H:i:s");
  $idno = $_GET['recortid'];
  if (!empty($postable_acc)) {
    $updateQuery = "UPDATE `gl_acc_code` SET acc_code='$acc_code', acc_head='$acc_head', postable_acc='$postable_acc', rep_glcode='$rep_glcode',category_code='$category_code',acc_type='$acc_type', subsidiary_group_code='$subsidiary_group_code', ss_modifier='$ss_modifier', ss_modifier_on='$ss_modifier_on' WHERE id =$idno";
// echo $updateQuery; exit;
    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {
      $message = "Update Successfully";
    } else {
      $mess = "Failled!";
    //   header("refresh:1;gl_account_edit.php?recortid=$idno");
       echo "<meta http-equiv=\"refresh\" content=\"0;URL=gl_account_edit.php?recortid=$idno\">";
    }
  } else {
    $empty = "Ledger/Group Account is Empty";
    // header("refresh:1;gl_account_edit.php?recortid=$idno");
      echo "<meta http-equiv=\"refresh\" content=\"0;URL=gl_account_edit.php?recortid=$idno\">";
  }
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=gl_account.php\">";
}
//select query start
if (isset($_GET['recortid'])) {
  $idno = $_GET['recortid'];
  $selectQuery = "SELECT * FROM `gl_acc_code` WHERE id=$idno";
  // echo $selectQuery; exit;
  $selectQueryResult = $conn->query($selectQuery);
  //if($selectQueryResult->num_rows){		
  $row = $selectQueryResult->fetch_array();
  //}
}
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Edit GL Account</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <!-- top start  -->
      <div style="padding:20px;">
        <!-- form start  -->
        <form action="" method="post">
          <input type="hidden" name="recid" value="<?php echo $row['id']; ?>" />
          <!-- acc conde  -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Account Code</label>
            <div class="col-sm-6">
              <input type="text" name="acc_code" class="form-control" autofocus value="<?php echo $row['acc_code']; ?>" readonly>
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
                error: function() {}
              });
            }
          </script>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Account Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="acc_head" name="acc_head" value="<?php echo $row['acc_head']; ?>" onkeyup="gl_account_check_availability()" required>
              <tr>
                <th width="24%" scope="row"></th>
                <td><span id="name_availability_status"></span></td>
              </tr>
            </div>
          </div>
      </div>
      <!-- post able account  -->
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Ledger/Group Account</label>
        <div class="col-sm-6">
          <input type="radio" name="postable_acc" value="Y" <?php if ($row['postable_acc'] == "Y") {
                                                              echo 'selected="selected"';
                                                            } ?> onclick="Fun()" id="more"><label class="col-sm-3 col-form-label">Ledger Account</label>
          <input type="radio" name="postable_acc" value="N" <?php if ($row['postable_acc'] == "N") {
                                                              echo 'selected="selected"';
                                                            } ?> id="" class="group"><label class="col-sm-3 col-form-label">Group Account</label>
        </div>
      </div>
      <!-- ====== more information start ====== -->
      <div <?php if ($_SESSION['seprt_cs_info'] !== 'Y') {
              echo 'id="more_show"';
            } else {
              echo 'id="not"' .  'style="display: none"';
            } ?>>
        <!-- address -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="" name="address" value="<?php echo $row['address']; ?>">
          </div>
        </div>
        <!-- vat_no -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">VAT No</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="" name="vat_no" value="<?php echo $row['vat_no']; ?>">
          </div>
        </div>
        <!-- tin_no -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">TIN No</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="" name="tin_no" value="<?php echo $row['tin_no']; ?>">
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
          <input type="text" class="form-control" id="" name="rep_glcode" value="<?php echo $row['rep_glcode']; ?>">
        </div>
      </div>
      <!-- category  -->
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Category</label>
        <div class="col-sm-6">
          <select name="category_code" id="" class="form-control" required>
            <!-- ----------------------------------->
            <option value="">----Select---</option>
            <?php
            $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "acat" AND `softcode`>0';
            $selectQueryResult =  $conn->query($selectQuery);
            if ($selectQueryResult->num_rows) {
              while ($rows = $selectQueryResult->fetch_assoc()) {
            ?>
                <option value="<?php echo $rows['softcode']; ?>" <?php if ($row['category_code'] == $rows['softcode']) {
                                                                    echo "selected";
                                                                  } ?>><?php echo $rows['description']; ?></option>

            <?php
              }
            }
            ?>
          </select>
        </div>
      </div>
      <!-- Account Type  -->
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Account Type</label>
        <div class="col-sm-6">
          <select name="acc_type" id="" class="form-control" required>
            <option value="">-----select----</option>
            <!-- ----------------------------------->
            <?php
            $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "acc_t" AND `softcode`>0';
            $selectQueryResult =  $conn->query($selectQuery);
            if ($selectQueryResult->num_rows) {
              while ($rows = $selectQueryResult->fetch_assoc()) {
            ?>
                <option value="<?php echo $rows['softcode']; ?>" <?php if ($row['acc_type'] == $rows['softcode']) {
                                                                    echo "selected";
                                                                  } ?>><?php echo $rows['description']; ?></option>

            <?php
              }
            }
            ?>
          </select>
          </select>
        </div>
      </div>
      <!-- subsidiary group code  -->
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Subsidiary Group Name</label>
        <div class="col-sm-6">
          <select name="subsidiary_group_code" id="" class="form-control" required>
            <option value="">-----select----</option>
            <!-- ----------------------------------->
            <?php
            $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "subco" AND `softcode`>0';
            $selectQueryResult =  $conn->query($selectQuery);
            if ($selectQueryResult->num_rows) {
              while ($rows = $selectQueryResult->fetch_assoc()) {
            ?>
                <option value="<?php echo $rows['softcode']; ?>" <?php if ($row['subsidiary_group_code'] == $rows['softcode']) {
                                                                    echo "selected";
                                                                  } ?>><?php echo $rows['description']; ?></option>

            <?php
              }
            }
            ?>
          </select>
          </select>
        </div>
      </div>
      <!-- submit  -->
      <div class="form-group row">
        <div class="col-sm-10">
          <input name="submit" type="submit" value="Update" class="btn btn-primary" />
        </div>
      </div>
      </form>
    </div>
    <?php
    if (!empty($message)) {
      echo '<script type="text/javascript">
            Swal.fire(
                "Update Successfully!!",
                "Welcome ' . $message . '",
                "success"
              )
            </script>';
    } 
    if (!empty($mess)) {
      echo '<script type="text/javascript">
          Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Sorry ' . $mess . '",
            });
          </script>';
    }
    if (!empty($empty)) {
      echo '<script type="text/javascript">
          Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Sorry ' . $empty . '",
            });
          </script>';
    }
    ?>
  </div>
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