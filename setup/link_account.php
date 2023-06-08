<?php
require "../database.php";
?>
<?php
//insrt query
if (isset($_POST['subBtn'])) {
  $office_code = $_POST['office_code'];
  $voucher_type = $_POST['voucher_type'];
  $ladger_acc = $_POST['ladger_acc'];

  $insertQuery = "INSERT INTO `link_account` (`id`, `office_code`, `voucher_type`, `ladger_acc`,`ss_creator_on`) VALUES (NULL,'$office_code','$voucher_type','$ladger_acc',now())";

  $conn->query($insertQuery);
  // echo $insertQuery; exit;
  if ($conn->affected_rows == 1) {
    $message = "Save Successfully";
  }
  $updateQuery = "UPDATE `gl_acc_code` SET active=1 where acc_code='$ladger_acc'";
    $conn->query($updateQuery);
    if($conn->affected_rows ==1){
      $messages ="Updated successfully";  
  }  

  header("Location:link_account.php");
}
?>
<?php
require "../source/top.php";
?>
<?php
require "../source/header.php";
?>
<?php
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Link Account Setup</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
    <?php if(isset($message))echo $message; ?>
          <?php if(isset($messages))echo $messages; ?>
      <!-- ----------------code here---------------->
      <!-- top start  -->
      <div class="maingltable">
        <div class="maingl">
          <div class="leftgl">
            <p>Logo. Organigation Name</p>
            <p>System Name</p>
          </div>
          <div class="meddlegl">
            <h2>GL Account</h2>
          </div>
          <div class="rightgl">
            <p>Process Month And Year:..-07-2019</p>
            <p>User:xxxxxxxxxx</p>
          </div>
        </div>
        <hr>
        <div style="padding:20px;">
          <!-- form start  -->
          <form action="" method="post">
            <!-- office code  -->
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Office Code</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="" name="office_code">
              </div>
            </div>
            <!-- voucher type  -->
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Voucher Type</label>
              <div class="col-sm-6">
              <select name="voucher_type" id="" class="form-control">
                <?php
                  $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`= "VTYPE" AND `softcode`>0';
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
           <!-- Account Name  -->
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Account Name</label>
              <div class="col-sm-6">
                <select name="ladger_acc" id="" class="form-control" required>
                  <!-- ----------------------------------->
                  <?php
                  $selectQuery = 'SELECT acc_code, acc_head, active FROM gl_acc_code WHERE active=0';
                  $selectQueryResult =  $conn->query($selectQuery);
                  if ($selectQueryResult->num_rows) {
                    while ($row = $selectQueryResult->fetch_assoc()) {
                      echo '<option value="' . $row['acc_code'] . '">'  . $row['acc_head'] .' . '. $row['acc_code'].'</option>';
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            
            <!-- submit  -->
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" name="subBtn">Submit</button>
              </div>
            </div>
          </form>
        </div>
        <!-- form close  -->
        <!-- table view start  -->
        <div class="table-responsive border-dark border-top">
          <table class="table table-hover">
            <tr class="active">
              <th>ID</th>
              <th>Office Code</th>
              <th>Voucher Type</th>
              <th>Ladger Account</th>
              <th>Action</th>
            </tr>
            <?php
            $sql = "SELECT link_account.id, link_account.office_code,link_account.voucher_type,link_account.ladger_acc,code_master.softcode,code_master.description FROM link_account, code_master where link_account.voucher_type=code_master.softcode ORDER BY ladger_acc";
            $query = $conn->query($sql);
            while ($rows = $query->fetch_assoc()) {
              echo
                "<tr>
									<td>" . $rows['id'] . "</td>
									<td>" . $rows['office_code'] . "</td>
									<td>" . $rows['description'] . "</td>
									<td>" . $rows['ladger_acc'] . "</td>
                  <td><a target='_blank' href='gl_account_add.php?id=" . $rows['id'] . "' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span>Add Sub Account</a>
                  <a href='gl_account_edit.php?recortid=" . $rows['id'] . "' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span>Edit</a>
										<a href='#delete_" . $rows['id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
									</td>
								</tr>";
              include('edit_delete_modal.php');
            }
            ?>
          </table>
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
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#setup").addClass('active');
    $("#link").addClass('active');
    $("#setup").addClass('is-expanded');
  });
</script>
<?php
$conn->close();
?>
</body>

</html>