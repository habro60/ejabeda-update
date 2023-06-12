<?php
require "../auth/auth.php";
require "../database.php";
?>
<?php

if (isset($_POST['submit'])) {
$id = $_GET['id'];
  $office_code = $_SESSION['office_code'];
  $item_code = $_POST['item_code'];
  $item_name = $_POST['item_name'];
  $parent_id = $_POST['parent_id'];
  $item_level = $_POST['item_level'];
  $item_category = $_POST['item_category'];
  $unit_code = $_POST['$unit_code'];
  $sellable_option = $_POST['sellable_option'];
  $texable_option = $_POST['texable_option'];
  $upload_dir = '../upload/';
  // ==image name from form -name="image"==
  $imgName = $_FILES['image']['name'];
  $imgTmp = $_FILES['image']['tmp_name'];
  // ==How much image size from form $imgName == 
  $imgSize = $_FILES['image']['size'];
  // ==which EXTENSION in this image 
  $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
  $userPic = time() . '_' . rand(1000, 9999) . '.' . $imgExt;
  move_uploaded_file($imgTmp, $upload_dir . $userPic);
  $ss_creator = $_SESSION['username'];
  $ss_org_no = $_SESSION['org_no'];
  $insertQuery = "INSERT INTO `item`(`id`,`office_code`,`item_code`,`item_name`, `parent_id`, `item_level`,`item_category`,`unit`,`sellable_option`,`texable_option`, `image`, `ss_creator`,`ss_created_on`,`ss_org_no`) values (NULL,'$office_code','$item_code','$item_name','$parent_id','$item_level','$item_category','$unit_code','$sellable_option','$texable_option','$userPic','$ss_creator',now(),'$ss_org_no')";

  $conn->query($insertQuery);
  if ($conn->affected_rows == 1) {
    $message = 'Main Item Data Saved !!';
    header('refresh:2: ../item/item.php');
  } else {
    $message = 'Main Item Data Failled !!';
  }
 echo "<meta http-equiv=\"refresh\" content=\"0;URL=addsubitem.php?id=$id\">";
}
// ======GET ITEM FROM ITEM TABLE

if (isset($_GET['id'])) {
  $selectQuery = "select * from `item` where id='" . $_GET['id'] . "'";
  //echo "$selectQuery";
  //exit;
  $selectQueryReuslt = $conn->query($selectQuery);
  $row = $selectQueryReuslt->fetch_assoc();
  // var_dump($row);
}


?>
<?php
$query = "Select Max(item_code) From `item` where id= $_GET[id]";
$returnD = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($returnD);
$maxRows = $result['Max(item_code)'];
$selectQuery = "SELECT parent_id FROM `item`";
$selectQueryResult = $conn->query($selectQuery);
if ($selectQueryResult->num_rows) {
  while ($rowss = $selectQueryResult->fetch_array()) {
?>
    <?php

    if ($_GET['id'] != $rowss['parent_id']) {
      if ($row['item_level'] == 1) {
        if (empty($row['item_code'])) {
          $lastRow = $row['item_code'] + 1000000000;
        } else {
          $lastRow = $maxRows + 1000000000;
        }
      } elseif ($row['item_level'] == 2) {
        if (empty($row['item_code'])) {
          $lastRow = $row['item_code'] + 10000000;
        } else {
          $lastRow = $maxRows + 10000000;
        }
      } elseif ($row['item_level'] == 3) {
        if (empty($row['item_code'])) {
          $lastRow = $row['item_code'] + 100000;
        } else {
          $lastRow = $maxRows + 100000;
        }
      } elseif ($row['item_level'] == 4) {
        if (empty($row['item_code'])) {
          $lastRow = $row['item_code'] + 1000;
        } else {
          $lastRow = $maxRows + 1000;
        }
      } elseif ($row['item_level'] == 5) {
        if (empty($row['item_code'])) {
          $lastRow = $row['item_code'] + 10;
        } else {
          $lastRow = $maxRows + 10;
        }
      } elseif ($row['item_level'] == 6) {
        if (empty($row['item_code'])) {
          $lastRow = $row['item_code'] + 1;
        } else {
          $lastRow = $maxRows + 1;
        }
      }
    } else {
      $query = "Select Max(item_code) From item where $_GET[id]=parent_id";
      $returnD = mysqli_query($conn, $query);
      $result = mysqli_fetch_assoc($returnD);
      $maxRows = $result['Max(item_code)'];
      if ($row['item_level'] == 1) {
        $lastRow = $maxRows + 1000000000;
      } elseif ($row['item_level'] == 2) {
        $lastRow = $maxRows + 10000000;
      } elseif ($row['item_level'] == 3) {
        $lastRow = $maxRows + 100000;
      } elseif ($row['item_level'] == 4) {
        $lastRow = $maxRows + 1000;
      } elseif ($row['item_level'] == 5) {
        $lastRow = $maxRows + 10;
      } elseif ($row['item_level'] == 6) {
        $lastRow = $maxRows + 1;
      }
    }
    ?>
<?php
  }
}
?>
<?php
$maxRows1 = $row['item_level'];
if (empty($maxRows1)) {
  $lastRows = $maxRows1 = 1;
} else {
  $lastRows = $maxRows1 + 1;
}
?>
<?php
require '../source/top.php';
require '../source/header.php';
require '../source/sidebar.php';
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Add Sub Item For <b><?php echo $row['item_name']; ?></b> </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <!-- ----------------code here---------------->
      <form method="post" enctype="multipart/form-data">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Item Code</label>
            <input type="text" name="item_code" class="form-control" autofocus value=<?php echo $lastRow; ?> readonly>
          </div>
          <div class="form-group col-md-6">
            <label>Item Name</label>
            <input type="text" class="form-control" name="item_name" required>
          </div>
        </div>
        <!-- ----- unit -- -->
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Unit </label>
            <select name="$unit_code" class="form-control" id="$unit_code" required>
              <?php
              $selectQuery = 'SELECT * FROM `code_master` WHERE `hardcode`="UCODE" AND `softcode`>0';
              $selectQueryResult = $conn->query($selectQuery);
              if ($selectQueryResult->num_rows) {
                while ($ucode = $selectQueryResult->fetch_assoc()) {
                  echo '<option value="' . $ucode['softcode'] . '">' . $ucode['description'] . '</option>';
                }
              }
              ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>Sellable Option</label>
            <select name="sellable_option" id="" class="form-control">
              <option value="">---select---</option>
              <option value="Y">Sellable</option>
              <option value="N">Purchaseable </option>
              <option value="B">Both</option>
            </select>
          </div>
        </div>
        <!-- -----------------3-------------------------- -->
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Taxable Option</label>
            <select name="texable_option" id="" class="form-control">
              <option value="">---select---</option>
              <option value="Y">Yes</option>
              <option value="N">No</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>Image</label>
            <input type="file" name="image" id="" class="form-control">
          </div>
        </div>
        <!-- hidden -->
        <input type="hidden" name="item_level" class="form-control" value="<?php echo $lastRows ?>">
        <input type="hidden" name="parent_id" class="form-control" value="<?php echo $row['id']; ?>">
        <input type="hidden" name="item_category" class="form-control" value="<?php echo $row['item_category']; ?>">
        <input type="submit" name="submit" class="btn btn-primary col-md-6" class="fa fa-plus" value="Add Item">
      </form>
      <!-- ----------------code here---------------->
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
    if (!empty($message_failled)) {
      echo '<script type="text/javascript">
          Swal.fire(
              "Failled !!",
              "Welcome ' . $_SESSION['username'] . '",
              "success"
            )
          </script>';
  } else {
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
<script src="../js/select2.full.min.js"></script>
<script src="../js/bootstrap.min"></script>


<script type="text/javascript">
   $(document).ready(function() {
        $("#204000").addClass('active');
        $("#200000").addClass('active');
        $("#200000").addClass('is-expanded');
    });
    $('#unit').change(function (e) { 
      e.preventDefault();
      $('#$unit_code').val($('#unit').val());
    });
</script>
<?php
//$conn->close();
?>
</body>

</html>