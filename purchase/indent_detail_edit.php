<?php
require "../auth/auth.php";
require "../database.php";

$id = intval($_GET['id']);
if (isset($_POST['submit'])) {
   
  
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  for ($count = 0; $count < count($_POST['indent_no']); ++$count) {
    $id =  $conn->escape_string($_POST['id'][$count]);
    $indent_no = $conn->escape_string($_POST['indent_no'][$count]);
    $item_no = $conn->escape_string($_POST['item_no'][$count]);
    $item_unit = $conn->escape_string($_POST['item_unit'][$count]);
    $item_qty = $conn->escape_string($_POST['item_qty'][$count]);
    $exp_tot_amt_loc = $conn->escape_string($_POST['exp_tot_amt_loc'][$count]);
    if ($id > 0) {
        $insertQuery = "UPDATE `indent_info` SET `id`='$id', `item_no`='$item_no', `item_unit`='$item_unit', `item_qty`='$item_qty', `exp_tot_amt_loc`='$exp_tot_amt_loc', ss_modifier='$ss_modifier', `ss_modified_on`='$ss_modified_on',`ss_org_no`='$ss_org_no' where `id`='$id'";
         $conn->query($insertQuery);
       
       
         if ($conn->affected_rows == TRUE) {
            $message = "Successfully";
          } else {
            $mess = "Failled";
          }
        }
      }
      header('refresh:1;indent_detail.php');
    }
require "../source/top.php";
require "../source/sidebar.php";
require "../source/header.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // $selectQuery= "SELECT * from office_info where id='$id'";
    // $selectQueryEditResult = $conn->query($selectQuery);
    // $rows = $selectQueryEditResult->fetch_assoc();
}

?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Edit Indent Information </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- form start  -->
            <form method="post">
                 <table class="table bg-light table-bordered table-sm">
                            <thead>
                                <tr>
                                     <th>id</th>
                                    <th>Project Name</th>
                                    <th>Indent Number</th>
                                    <th>Expected Delivery Date</th>
                                    <th>Item</th>
                                    <th>quentity</th>
                                    <th>Unit</th>
                                    <th>Expected Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $disflag = '0';
                                
                                // $sql= "select * from indent_info where indent_no='$id'";
                                $sql="select indent_info.id, indent_info.office_code, indent_info.indent_no, indent_info.indent_date, indent_info.exp_delivery_date, indent_info.requirement_type, indent_info.item_no, indent_info.item_unit, indent_info.item_qty, indent_info.unit_price, indent_info.exp_tot_amt_loc, indent_info.indent_status, office_info.office_name, item.item_name from indent_info, office_info, item where indent_info.office_code=office_info.office_code and indent_info.item_no=item.id and indent_info.indent_no='$id'";
                                $query = mysqli_query($conn, $sql);
                                while ($rows = $query->fetch_assoc()) {
                                ?>
                                            <tr>
                                                <td>
                                                    <input type="text" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                                                </td>
                                                
                                                <td style="background-color:powderblue; text-align: left; width:220px; font-weight:bold"><?php if ($rows['office_code'] > $disflag) {
                                                                                                                echo $rows['office_name'];
                                                                                                                $disflag = $rows['office_code'];
                                                                                                            } else {
                                                                                                                echo "";
                                                                                                            } ?></td>
                                               
                                                <td>
                                                    <input type="text" name="indent_no[]" class="form-control" value="<?php echo $rows['indent_no']; ?>" style="width: 180px" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="exp_delivery_date[]" class="form-control" value="<?php echo $rows['exp_delivery_date']; ?>" style="width: 100%" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="item_no[]" class="form-control" value="<?php echo $rows['item_no'];echo ' '; echo $rows['item_name']; ?>" style="width: 100%" >
                                                </td>
                                               
                                                <td>
                                                    <input type="text" name="item_qty[]" class="form-control" value="<?php echo $rows['item_qty']; ?>" style="width: 100%">
                                                </td>
                                                <td>
                                                    <input type="text" name="item_unit[]" class="form-control" value="<?php echo $rows['item_unit']; ?>" style="width: 100%" >
                                                </td>
                                                <td>
                                                    <input type="text" name="exp_tot_amt_loc[]" class="form-control" value="<?php echo $rows['exp_tot_amt_loc']; ?>" style="width: 100%" >
                                                </td>
                                               
                                            </tr>
                                    <?php
                                        
                                    }
                                    ?>
                            </tbody>
                        </table>
                        <input name="submit" type="submit" id="submit" value="submit" class="btn btn-info pull-right submit" />
            </form>
        </div>
        <?php
        if (!empty($message)) {
            echo '<script type="text/javascript">
            Swal.fire(
                "Update Successfully!!",
                "Welcome ' . $_SESSION['username'] . '' . $last_id . '",
                "success"
              )
            </script>';
        } else {
        }
        if (!empty($mess)) {
            echo '<script type="text/javascript">
                Swal.fire(
                    "Failled!!",
                    "Sorry ' . $_SESSION['username'] . '",
                    "success"
                  )
                </script>';
        } else {
        }
        if (!empty($massage_failled_date)) {
            echo '<script type="text/javascript">
            Swal.fire(
                "Failled Date!!",
                "Sorry ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
        } else {
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
<script src="../js/select2.full.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.select2').select2()
    })
    $(document).ready(function() {
        $("#107000").addClass('active');
        $("#100000").addClass('active');
        $("#100000").addClass('is-expanded');

    });
</script>
</body>

</html>