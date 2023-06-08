<?php
require "../auth/auth.php";
require "../database.php";

$id = intval($_GET['id']);
if (isset($_POST['submit'])) {
   
  
  $ss_modifier = $_SESSION['username'];
  $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  for ($count = 0; $count < count($_POST['cust_order_ino']); ++$count) {
    $id =  $conn->escape_string($_POST['id'][$count]);
    $cust_order_ino = $conn->escape_string($_POST['cust_order_ino'][$count]);
    $item_no = $conn->escape_string($_POST['item_no'][$count]);
    $item_unit = $conn->escape_string($_POST['item_unit'][$count]);
    $item_qty = $conn->escape_string($_POST['item_qty'][$count]);
    $exp_tot_amt_loc = $conn->escape_string($_POST['exp_tot_amt_loc'][$count]);
    if ($id > 0) {
        $insertQuery = "UPDATE `cust_order_info` SET `id`='$id', `item_no`='$item_no', `item_unit`='$item_unit', `item_qty`='$item_qty', `exp_tot_amt_loc`='$exp_tot_amt_loc', ss_modifier='$ss_modifier', `ss_modified_on`='$ss_modified_on',`ss_org_no`='$ss_org_no' where `id`='$id'";
         $conn->query($insertQuery);
       
       
         if ($conn->affected_rows == TRUE) {
            $message = "Successfully";
          } else {
            $mess = "Failled";
          }
        }
      }
      header('refresh:1;cust_order.php');
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
            <h1><i class="fa fa-dashboard"></i> Edit Order Information </h1>
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
                                    <th>Order By</th>
                                    <th>order Number</th>
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
                                
                                // $sql= "select * from order_info where cust_order_ino='$id'";
                                $sql="select cust_order_info.id, cust_order_info.order_from, cust_order_info.order_to, cust_order_info.cust_order_no, cust_order_info.cust_order_date, cust_order_info.exp_delivery_date, cust_order_info.requirement_type, cust_order_info.item_no, cust_order_info.item_unit, cust_order_info.item_qty, cust_order_info.unit_price, cust_order_info.exp_tot_amt_loc, cust_order_info.order_status,cust_order_info.delivery_qty, cust_order_info.due_qty, item.item_name, cust_info.cust_name from cust_order_info, cust_info, item where cust_order_info.order_from=cust_info.id and cust_order_info.item_no=item.id and cust_order_info.cust_order_no='$id'";
                                $query = mysqli_query($conn, $sql);
                                while ($rows = $query->fetch_assoc()) {
                                ?>
                                            <tr>
                                                <td>
                                                    <input type="text" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                                                </td>
                                                
                                                <td style="background-color:powderblue; text-align: left; width:220px; font-weight:bold"><?php if ($rows['id'] > $disflag) {
                                                                                                                echo $rows['cust_name'];
                                                                                                                $disflag = $rows['id'];
                                                                                                            } else {
                                                                                                                echo "";
                                                                                                            } ?></td>
                                               
                                                <td>
                                                    <input type="text" name="cust_order_ino[]" class="form-control" value="<?php echo $rows['cust_order_no']; ?>" style="width: 180px" readonly>
                                                </td>
                                                <td>
                                                
                                                    <input type="text" name="exp_delivery_date[]" class="form-control" value="<?php echo $rows['exp_delivery_date']; ?>" style="width: 100%" readonly>
                                                </td>
                                                <td>
                                                <select name="item_no[]" class="form-control select2" required>
                                                      <option value="">-Select Item-</option>
                                                      <?php
                           
                                                        $selectQuery ="SELECT * FROM item where sellable_option = 'Y'";
                                                        $selectQueryResult = $conn->query($selectQuery);
                                                        if ($selectQueryResult->num_rows) {
                                                            while ($row = $selectQueryResult->fetch_assoc()) {
                                                        ?>
                                                                <option value="<?php echo $row['id']; ?>" <?php if ($rows['item_no'] == $row['id']) { ?> selected="selected" <?php } ?>><?php echo $row['item_name']; ?></option>

                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    
                                                </td>
                                               
                                                <td>
                                                    <input type="text" name="item_qty[]" class="form-control" value="<?php echo $rows['item_qty']; ?>" style="width: 100%">
                                                </td>
                                                <td>
                                                <select name="item_unit[]" class="form-control select2" required>
                                                      <option value="">-Select Unit -</option>
                                                      <?php
                           
                                                        $selectQuery = "SELECT code_master.softcode, code_master.description FROM code_master WHERE softcode > '0' and code_master.hardcode='UCODE'";
                                                        $selectQueryResult = $conn->query($selectQuery);
                                                        if ($selectQueryResult->num_rows) {
                                                            while ($row = $selectQueryResult->fetch_assoc()) {
                                                        ?>
                                                                <option value="<?php echo $row['softcode']; ?>" <?php if ($rows['item_unit'] == $row['softcode']) { ?> selected="selected" <?php } ?>><?php echo $row['description']; ?></option>

                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                   
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