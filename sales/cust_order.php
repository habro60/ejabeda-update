<?php
require "../auth/auth.php";
require "../database.php";
$sa_role_no = $_SESSION["sa_role_no"];
$seprt_cs_info = $_SESSION['seprt_cs_info'];

if (isset($_POST['submit'])) {
  $office_code = $conn->escape_string($_SESSION['office_code']);

  if ($_SESSION['sa_role_no'] == '200') {
        $order_from = $conn->escape_string($_SESSION['link_id']);
        $order_to =$conn->escape_string($_SESSION['office_code']);
  } else {
        $order_to = $conn->escape_string($_SESSION['office_code']);
        $order_from = $conn->escape_string($_POST['order_from']);
  }
  $cust_order_no = $conn->escape_string($_POST['cust_order_no']);
  $exp_delivery_date = $conn->escape_string($_POST['exp_delivery_date']);
  $exp_delivery_date = $conn->escape_string($_POST['exp_delivery_date']);
  $requirement_type = $conn->escape_string($_POST['requirement_type']);
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  for ($count = 0; $count < count($_POST['item_no']); ++$count) {
    
    $item_no = $conn->escape_string($_POST['item_no'][$count]);
    $item_unit = $conn->escape_string($_POST['item_unit'][$count]);
    $item_qty = $conn->escape_string($_POST['item_qty'][$count]);
    $unit_price = '0';
    $exp_tot_amt_loc = $conn->escape_string($_POST['total_price'][$count]);
    if ($item_no > 0) {
        $insertownerQuery = "insert into  cust_order_info (id, `office_code`, order_from, order_to,`cust_order_no`,cust_order_date ,`exp_delivery_date`,`requirement_type`,`item_no`,`item_unit`,`item_qty`,`unit_price`,`exp_tot_amt_loc`,`order_status`,`status_date`,`ss_creator`,`ss_created_on`,`ss_org_no`) values (null, '$office_code', '$order_from','$order_to', '$cust_order_no','$ss_created_on', '$exp_delivery_date','$requirement_type','$item_no','$item_unit','$item_qty','$unit_price','$exp_tot_amt_loc','0','$ss_created_on','$ss_creator','$ss_created_on','$ss_org_no')";
     
        $conn->query($insertownerQuery);

        // echo $insertownerQuery;
        // exit;

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
$pid = 1109000;
$role_no = $_SESSION['sa_role_no'];
$office_no = $_SESSION['office_code'];

auth_page($conn, $pid, $role_no);
$querys = "insert into bach_no (username) values ('$_SESSION[username]')";
$returns = mysqli_query($conn, $querys);
$lastRows = $conn->insert_id;


require "../source/header.php";
require "../source/sidebar.php";

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Order Detail</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>

    <!-- ====-- button define====== -->
    <button id="ScaleSetupBtn" class="btn btn-success"><a class="active"></i>Input Customer Order </button>
    <button id="ViewScaleBtn" class="btn btn-primary"><a class=""></i>Customer Order List</button>
    
    <!-- =======button Define closed===== -->
    <div class=" row">
      <div class="col-md-12">
        <div id="ScaleSetup" class="collapse">
          <div style="padding:5px">
            <form method="post">
                   <table class="table bg-light table-bordered table-sm">
                      <thead>
                          <tr>
                              <th>order Number</th>
                              <th style="text-align: center">Order Date</th>
                              <th style="text-align: center">Time</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td> <input type="text" name="cust_order_no" readonly class="org_form org_12" autofocus value="<?php echo $lastRows;  ?>"></td>
                              <td> <input type="date" id="date" class="org_form" name="indedent_date" value="<?php echo date('Y-m-d'); ?>"></td>
                              <td> <input type="text" id="date" class="org_form" id="clock" value="<?php date_default_timezone_set('Asia/Dhaka');
                                                                                                      echo date("h:i:sa"); ?>" readonly></td>
                          </tr>
                      </tbody>
                  </table>
             <!-- ================== -->
             
               <div class="form-group row" <?php if ($_SESSION['sa_role_no'] == '200') { echo "hidden"; } ?>>
                   <label class="col-sm-3 col-form-label"> order From</label>
                   <label class="col-form-label">:</label>
                   <div class="col-sm-6">
                    <select name="order_from" class="form-control">
                      <option value="">-Select Order By-</option>
                      <?php
                       

                        $selectQuery = "SELECT id, cust_name FROM cust_info";
                      
                      // $selectQuery = "SELECT office_code, office_name FROM office_info where office_code != '$office_no'";
                      
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row_off = $selectQueryResult->fetch_assoc()) {
                      ?>
                      <?php
                          echo '<option value="' . $row_off['id'] . '">' . $row_off['cust_name'] . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                 </div>
                
                <div class="form-group row">
                   <label class="col-sm-3 col-form-label">Expected Deliver Date</label>
                   <label class="col-form-label">:</label>
                   <div class="col">
                        <input type="date" class="form-control" id="" name="exp_delivery_date">
                   </div>
                </div>
               
               
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Requirement Type</label>  
                   <label class="col-form-label">:</label>
                   <div class="col">
                   <select name="requirement_type" class="form-control">
                          <option value="">----Select any----</option>
                          <option value="1">Services</option>
                          <option value="2">Goods</option>
                      </select>
                   </div>
                </div>
              <!-- =========  increment Input ======== -->
              <table class="table bg-light table-bordered table-sm" id="multi_table">
                <thead>
                  <tr class="table-active">
                    <th>Sl. No.</th>
                    <th>Item</th>
                    <th>Unit</th>
                    <th>Quentity</th>
                    <th>Unit Price</th>
                    <th>Expected Value</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td><select name="item_no[]" class="form-control item_no unitChange" required>
                            <option value="">-Select Item-</option>
                            <?php
                            $selectQuery = "SELECT id, item_name FROM `item` where sellable_option='N'";
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . $row['item_name'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                    <input name="item_unit[]" class="item_unit" hidden>
                    <td><input type="text" class="item_unit_name form-control" readonly></td>
                        <td><input type="text" name="item_qty[]" id="item_qty1" data-srno="1" class="item_qty form-control" /></td>
                    <td><input type="text" name="unit_price_loc[]" id="unit_price_loc1" data-srno="1" class="unit_price_loc form-control" /></td>
                    <td><input type="text" name="total_price[]" id="total_price1" data-srno="1" readonly class="total_price form-control" /></td>
                    <td><button type="button" name="add_row" id="add_row" class="btn btn-success btn-xl">+</button></td>
                  </tr>
                </tbody>
                <tr>
                     <th colspan="5" style="text-align: right">Sub Total</th>
                     <th><input type="text" class="sub_total form-control" id="sub_total" style="width:100%" readonly></th>
                    <th></th>
               </tr>
              </table>
              <hr>
             
              <!-- ===== Input Closed =====  -->
              <div>
                <input type="hidden" name="activation_key" value="0">
                <button type="submit" class="btn btn-primary" id="submit" name="submit">Submit</button>
              </div>
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
    <!--====== Notice View List ======-->
    <div class="tile" id="ViewScale">
      <div class="tile-body">
        <h5 style="text-align: center">View  order List</h5>
        <table class="table table-hover table-bordered" id="GLAddTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Order By</th>
              <th>Order No.</th>
              <th>Order Date</th>
              <th>Expected Delivery Date</th>
              <th>Item</th>
              <th>Quentity</th>
              <th >Expected Unit Price</th>
              <th>Expected order Value</th>
              <th>Order Qty.</th>
              <th>Due Qty.</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $cust_order_no='';
            $sql = "select cust_order_info.id, cust_order_info.order_from, cust_order_info.order_to, cust_order_info.cust_order_no, cust_order_info.cust_order_date, cust_order_info.exp_delivery_date, cust_order_info.requirement_type, cust_order_info.item_no, cust_order_info.item_unit, cust_order_info.item_qty, cust_order_info.unit_price, cust_order_info.exp_tot_amt_loc, cust_order_info.order_status,cust_order_info.delivery_qty, cust_order_info.due_qty, item.item_name, cust_info.cust_name, description from cust_order_info, cust_info, item, code_master where cust_order_info.order_from=cust_info.id and cust_order_info.item_no=item.id and code_master.hardcode ='UCODE' and cust_order_info.item_unit=code_master.softcode";
            //$query = $conn->query($sql);
             if($query = $conn->query($sql)){
            while ($row = $query->fetch_assoc()) {
            
              ?>
              
              <tr>
                      <td style="text-align: left"><?php if ($row['cust_order_no'] != $cust_order_no) {
                                                            echo $row['id']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                    
                      <td style="text-align: left"><?php if ($row['cust_order_no'] != $cust_order_no) {
                                                            echo $row['cust_name']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>
                      
                      <td style="text-align: left"><?php if ($row['cust_order_no'] != $cust_order_no) {
                                                            echo $row['cust_order_no']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>
                       <td style="text-align: left"><?php if ($row['cust_order_no'] != $cust_order_no) {
                                                            echo $row['cust_order_date']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>


                      <td style="text-align: left"><?php if ($row['cust_order_no'] != $cust_order_no) {
                                                            echo $row['exp_delivery_date']; 
                                                            $cust_order_no=$row['cust_order_no'];
                                                        } else {
                                                            echo "";
                                                        }?></td>

                     
                      
                     
                     <td style=" background-color:powderblue; text-align: left"><?php echo $row['item_name']; ?></td>
                       <td style=" background-color:powderblue; text-align: right"><?php echo $row['item_qty'];echo "  "; echo $row['description']; ?></td>
                       <td style=" background-color:powderblue; text-align: right" hidden><?php echo $row['unit_price']; ?></td>
                       <td style="background-color:powderblue; text-align: right"><?php echo $row['exp_tot_amt_loc']; ?></td>
                       <td style=" background-color:white; text-align: right"><?php echo $row['delivery_qty'];echo "  "; echo $row['description']; ?></td>
                       <td style=" background-color:white; text-align: right"><?php echo $row['due_qty'];echo "  "; echo $row['description']; ?></td>
                       
                       <td><a <?php if ($row['order_status'] != '0') {
                                echo "onclick='return false";
                              } ?> <?php echo "href='cust_order_edit.php?id=" . $row['cust_order_no'] . "'"  ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Edit</a>
                      </td>
                     
                       <!-- <td><a <?php  "href=order_detail_edit.php?id=" . $row['cust_order_no'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Edit</a>
                      </td> -->
              </tr>
          
          <?php }} ?>

            
        </tbody>
              
        </table>
      </div>
    </div>
      </div>
    </div>
  <?php
  } else {
    echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION</h6>";
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
<!-- toggle btn -->
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">
  // $(document).ready(function() {
  $("#907000").addClass('active');
  $("#900000").addClass('active');
  $("#900000").addClass('is-expanded')
  // });
  $(document).ready(function() {
    var count = 1;
      $(document).on('click', '#add_row', function() {
                count++;
                var html_code = '';
                html_code += '<tr id="row_id_' + count + '">';
                html_code += '<td><span id="sr_no">' + count + '</span></td>';
                html_code += '<td><select name="item_no[]" onchange="unitChangeRow(' + count + ')" id="item_no' + count + '" class="form-control item_no"><option value="">-Select Item-</option><?php $selectQuery = "SELECT id, item_name FROM `item` where sellable_option='N'";
                                                                                                                                                                                                    $selectQueryResult = $conn->query($selectQuery);
                                                                                                                                                                                                    if ($selectQueryResult->num_rows) {
                                                                                                                                                                                                        while ($row = $selectQueryResult->fetch_assoc()) {
                                                                                                                                                                                                            echo '<option value="' . $row['id'] . '">' . $row['item_name'] . '</option>';
                                                                                                                                                                                                        }
                                                                                                                                                                                                    } ?></select></td>';
                // unit code
                html_code += '<td hidden><input name="item_unit[]" id="item_unit' + count + '" data-srno="' + count + '" class="item_unit form-control"></td>';
                // unit name show
                html_code += '<td><input  id="item_code' + count + '" data-srno="' + count + '" class="item_unit form-control" readonly></td>';
                 html_code += '<td><input type="text" name="item_qty[]" id="item_qty' + count + '" data-srno="' + count + '" class="form-control item_qty"/></td>';
                html_code += '<td><input type="text" name="unit_price_loc[]" id="unit_price_loc' + count + '" data-srno="' + count + '" class="form-control unit_price_loc"/></td>';
                html_code += '<td><input type="text" name="total_price[]" id="total_price' + count + '" data-srno="' + count + '" readonly class="form-control total_price"/></td>';
                html_code += '<td><button type="button" name="remove_row" id="' + count + '" class="form-control btn btn-danger btn-xs remove_row">-</button></td>';
                html_code += '</tr>';
                $('#multi_table').append(html_code);
    });
    $(document).on('click', '.remove_row', function() {
                var row_id = $(this).attr("id");
                var total_item_amount = $('#total_price' + row_id).val();
                var final_amount = $('#total').text();
                var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
                $('#total').text(result_amount);
                $('#row_id_' + row_id).remove();
                count--;
            });

            function total(count) {
                // alert(count);
                var sub_total = 0;
                for (j = 1; j <= count; j++) {
                    var item_qty = 0;
                    var unit_price_loc = 0;
                    // var item_total = 0;
                    item_qty = $('#item_qty' + j).val();
                    if (item_qty > 0) {
                        unit_price_loc = $('#unit_price_loc' + j).val();
                        if (unit_price_loc > 0) {
                            item_total = parseFloat(item_qty) * parseFloat(unit_price_loc);
                            sub_total = parseFloat(sub_total) + parseFloat(item_total);
                            $('#total_price' + j).val(item_total.toFixed(2));
                        }
                    }
                }
                $('#sub_total').val(sub_total);
                $('#dr_amount').val(sub_total);
                discount11 = $('#discount_after_amount').val();
                if (discount11 > 0) {
                    $('#grand_total').val(discount11);
                    $('#cr_amount').val(discount11);
                } else {
                    $('#grand_total').val(sub_total);
                    $('#cr_amount').val(sub_total);
                }
            }
            $(document).on('keyup', '.unit_price_loc', function() {
                total(count);
            });

          });
  // table 
  $('#sampleTable').DataTable();
  $('#memberTable').DataTable();
  
  // Button 
  $('#ViewScale').hide();
  $('#ScaleSetup').hide();

  // ScaleSetup
  $('#ScaleSetupBtn').on('click', function() {
    $('#ScaleSetup').show();
    $('#ViewScale').hide();
    
  });
  // ViewScale
  $('#ViewScaleBtn').on('click', function() {
    $('#ScaleSetup').hide();
    $('#ViewScale').show();
    
  });
 

 
  function confirmDialog(message, onConfirm) {
    var fClose = function() {
      modal.modal("hide");
    };
    var modal = $("#exampleModalCenter");
    modal.modal("show");
    $("#confirmMessage").empty().append(message);
    $("#presentConfirm").bind().one('click', onConfirm).one('click', fClose);
    // $("#presentConfirm").one('click', onConfirm).one('click', fClose);
    $("#confirmCancel").unbind().one("click", fClose);
  }

  $('.unitChange').on('change', function(e) {
            e.preventDefault;
            var item_no = this.value;
            $.ajax({
                url: "getCustOrder.php",
                method: "get",
                data: {
                    item_no_soft: item_no
                },
                success: function(response) {
                    console.log(response);
                    $('.item_unit').val(response);
                }
            });
            $.ajax({
                url: "getCustOrder.php",
                method: "get",
                data: {
                    item_no_des: item_no
                },
                success: function(response) {
                    console.log(response);

                    $('.item_unit_name').val(response);
                }
            });
        })
        function unitChangeRow(count) {
            var item = $('#item_no' + count).val();
            var item_code = $('#item_no' + count).val();
            $.ajax({
                type: "get",
                url: "getCustOrder.php",
                data: {
                    item: item
                },
                dataType: "text",
                success: function(response) {
                    console.log(response);
                    $('#item_code' + count).val(response);
                    // $('#item_unit' + count).val(response);
                }
            });
            $.ajax({
                type: "get",
                url: "getCustOrder.php",
                data: {
                    item_code: item_code
                },
                dataType: "text",
                success: function(response) {
                    console.log(response);
                    $('#item_unit' + count).val(response);
                }
            });
        }
</script>
<?php
$conn->close();
?>
</body>

</html>