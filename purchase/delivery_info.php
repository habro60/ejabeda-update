<?php
require "../auth/auth.php";
require "../database.php";
$disrate = 0;
$vatrate = 0;
$taxrate = 0;
if (isset($_POST["submit"])) {
    $office_code = $_SESSION['office_code'];
    $in_out_flag = "2";
    $year_code = $_SESSION['org_fin_year_st'];
    $batch_no = $_POST['batch_no'];
    $tran_date = $_POST['tran_date'];
    $vaucher_typedr = "DR";
    $vaucher_typecr = "CR";
    $by_account = $_POST['by_account'];
    $to_account = $_POST['to_account'];
    $particulardr = $_POST['particulardr'];
    $particularcr = $_POST['particularcr'];
    $draccount = $_POST['draccount'];
    $craccount = $_POST['craccount'];
    $bill_status = "DELIV";
    $item_status = "1";
    $ss_creator = $_SESSION['username'];
    $ss_org_no = $_SESSION['org_no'];
    $tran_mode = "DELIV";
    $order_type = "DELIV";
    $pay_on_vouch_no =  $_POST['batch_no'];
    $purchase_date =  $_POST['tran_date'];
    $bill_paid_flag = '2';
    //
    $acc_type = $_POST['acc_type'];
    if ($acc_type > 1) {
        $tran_mode = "DELIV";
        $order_type = "DELIV";
        $pay_on_vouch_no =  $_POST['batch_no'];
        $purchase_date =  $_POST['tran_date'];
        $bill_paid_flag = '2';
    }

    // dr
    
    
    $insertQuerydr = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `dr_amt_loc`,`pay_on_vouch_no`,`purchase_date`,`bill_paid_flag`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$by_account','$tran_mode','$vaucher_typedr','$particulardr','$draccount','$pay_on_vouch_no','$purchase_date','$bill_paid_flag','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuerydr);
    if ($conn->affected_rows == 1) {
        $massage_dr = "dr Save Successfully!!";
    }

    // cr
    $insertQuerycr = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `cr_amt_loc`,`pay_on_vouch_no`,`purchase_date`,`bill_paid_flag`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$to_account','$tran_mode','$vaucher_typecr','$particularcr','$craccount','$pay_on_vouch_no','$purchase_date','$bill_paid_flag','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuerycr);
    if ($conn->affected_rows == 1) {
        $massage_cr = "cr Save Successfully!!";
    } else {
        echo  $conn->error;
    }
    for ($count = 0; $count < count($_POST["item_no"]); $count++) {

if(isset($_POST["item_qty"][$count]) && $_POST["item_qty"][$count] != 0) {
        $office_code  = $office_code;
        $order_type  = $order_type;
        $in_out_flag  = $in_out_flag;
        $batch_no  = $batch_no;
        $gl_acc_code   = $_POST["by_account"];
        $for_gl_acc_code   = $_POST["by_account"];
        $tran_date  = $tran_date;
        $item_no   = $_POST["item_no"][$count];
        $item_qty = $_POST["item_qty"][$count];
        $item_unit = $_POST["item_unit"][$count];
        $unit_price_loc  = $_POST["unit_price_loc"][$count];
        $total_price_loc = $_POST["total_price"][$count];
        $bill_status = $bill_status;
        $item_status = $item_status;
        $status_date = $tran_date;
        $ss_creator  = $ss_creator;
        $ss_org_no  = $ss_org_no;
        $query = "INSERT INTO invoice_detail (office_code,order_type,in_out_flag, order_no, gl_acc_code, order_date, item_no, item_qty, item_unit, unit_price_loc,total_price_loc,  bill_status, item_status,status_date, for_gl_acc_code, ss_creator,ss_created_on,ss_org_no) VALUES ('$office_code','$order_type','$in_out_flag','$batch_no','$gl_acc_code','$tran_date','$item_no','$item_qty','$item_unit', '$unit_price_loc','$total_price_loc','$bill_status','$item_status','$status_date','$for_gl_acc_code','$ss_creator',now(),'$ss_org_no')";

        $conn->query($query);
        if ($conn->affected_rows == true) {
            $massage = "Delivered Successfully!!";
        }
}
    }
   $ss_modifier = $_SESSION['username'];
$indent_no = $_POST['indent_no'];
for ($count = 0; $count < count($_POST['item_no']); ++$count) {
    if(isset($_POST["item_qty"][$count]) && $_POST["item_qty"][$count] != 0) {
        $item_no = $_POST['item_no'][$count];
        $due_qty = $_POST['item_qty2'][$count];
        $deli_qty = $_POST['item_qty'][$count];
        $delivery_qty = $_POST['delivery_qty'][$count];
        if ($item_no > 0) {
            $updateQuery = "UPDATE `indent_info`
                SET `delivery_qty` = `delivery_qty` + ?,
                    `due_qty` = `due_qty` - ?,
                    `ss_modifier` = ?,
                    `ss_modified_on` = NOW(),
                    `ss_org_no` = ?,
                    `indent_status` = '1'
                WHERE `indent_no` = ? AND `item_no` = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param('iissii', $deli_qty, $deli_qty, $ss_modifier, $ss_org_no, $indent_no, $item_no);
            $stmt->execute();
            if ($stmt->affected_rows == TRUE) {
                $message = "Successfully";
            } else {
                $mess = "Failed";
            }
            $stmt->close();
        }
    }

  }
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=delivery_info.php\">";
}

require "../source/top.php";
$pid = 1014000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";

$querys = "insert into bach_no (username) values ('$_SESSION[username]')";
$returns = mysqli_query($conn, $querys);
$lastRows = $conn->insert_id;
?>


<style>
 
#click_here {
  animation-duration: 2s;
  animation-name: button-animation;
  animation-iteration-count: infinite;
}

@keyframes button-animation {
  0% {
    transform: scale(1);
    background-color: #17a2b8;
  }
  50% {
    transform: scale(1.1);
    background-color: #007bff;
  }
  100% {
    transform: scale(1);
    background-color: #17a2b8;
  }
}

</style>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Delivery Entry</h1>
        </div>
    </div>
    <form action="" method="post">
        <table class="table bg-light table-bordered table-sm">
            <thead>
                <tr>
                    <th>Delivery Voucher No</th>
                    <th style="text-align: center">Delivery Date</th>
                    <th style="text-align: center">Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> <input type="text" name="batch_no" readonly class="org_form org_12" autofocus value="<?php echo $lastRows; ?>"></td>
                    <td> <input type="date" id="date" class="org_form" name="tran_date" value="<?php echo date('Y-m-d'); ?>"></td>
                    <td> <input type="text" id="date" class="org_form" id="clock" value="<?php date_default_timezone_set('Asia/Dhaka');
                                                                                            echo date("h:i:sa"); ?>" readonly></td>
                </tr>
            </tbody>
        </table>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">To Project</label>
            <label class="col-form-label">:</label>
            <div class="col-sm-6">
                <select name="indent_from" class="form-control indent_from" onchange="getIndent(this.value)" required>
                    <option value="">-Select Project-</option>
                    <?php
                    $selectQuery = "SELECT DISTINCT indent_info.indent_from, office_info.office_name, office_info.office_code FROM indent_info, office_info where   `due_qty`>0 AND  indent_info.indent_from=office_info.office_code";
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                        while ($row_off = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php
                            echo '<option value="' . $row_off['indent_from'] . '">' . $row_off['office_name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label"> Against Indent Number </label>
            <label class="col-form-label">:</label>
            <div class="col-sm-6">
                <select name="indent_no" class="form-control indent_no" onchange="getItem(this.value)">
                    <option>-Select Indent Number-</option>
                </select>
            </div>
        </div>

        <!--  -->
        <table class="table bg-light table-bordered table-sm">
            <tr class="table-active" align="center">
                <th>Item Name</th>
                <th>Unit</th>
                <th>Indent Qty.</th>
                <th>Due Qty.</th>
                <th>Delivery Qty.</th>
                <th>Unit Price</th>
                <th>Amount</th>
            </tr>
        </table>
        <!--  -->
        <div id="indent_list">
            <table class="table bg-light table-bordered table-sm" id="multi_table">
                <tbody id="item">

                </tbody>

            </table>
        </div>
        <div id="indent_list_total" hidden>
            <table class="table bg-light table-bordered table-sm">

            </table>
        </div>
   <input type="button" class="btn btn-info pull-right m-5" id="click_here" onclick="calculate()" value="Click Here">
   <hr>

        <table class="table bg-light table-bordered table-hover table-sm">
            <tfoot>
                <tr>
                    <td></td>
                    <td><select class="form-control select2" name="by_account"  required>
                            <option value="">---Delevery To Account---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where   category_code = 4 and postable_acc= 'Y' and acc_type='10' ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($drrow = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $drrow['acc_code'] . '">'  . $drrow['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                    <td colspan="2"><input type="text" class="form-control" name="particulardr" placeholder="Particular"></td>
                    <td><input type="text" class="dr_amount form-control" id="dr_amount" name="draccount" placeholder="Dr.Amount" readonly></td>
                    <td style="width: 20px"> <strong>Dr</strong></td>
                </tr>

                <tr>
                    <td></td>
                    <td><select class="form-control grand" name="to_account" onchange="toAccount()" id="to_account" required>
                            <option value="">---Delevery From Account ---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where   category_code = '1' and acc_type='10'  and postable_acc= 'Y' ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($drrow = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $drrow['acc_code'] . '">'  . $drrow['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                    <td colspan="2"> <input type="text" class="form-control" name="particularcr" placeholder="Particular" id="particularcr"></td>
                    <td style="width: 250px"> <input type="text" id="cr_amount" class="cr_amount form-control" name="craccount" placeholder="Cr. Amount" readonly></td>
                    <td style="width: 20px"> <strong>Cr</strong></td>
                </tr>
            </tfoot>
        </table>
        <div class="col-12">
            <div style="text-align:right">
                <input type="hidden" name="acc_type" id="acc_type" value="">
                <input name="submit" type="submit" id="sub" value="Submit" class="btn btn-info" style="width:250px" />
            </div>
        </div>
    </form>
    <!-- ! alert -->
    <?php
    if (!empty($message)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Purchase Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    }
    if (!empty($massage_dr)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    }
    if (!empty($massage_cr)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    }
    ?>
    <!-- alert -->
    </div>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/plugins/pace.min.js"></script>
    <script src="../js/select2.full.min.js"></script>
    <script src="../js/custom.js"></script>
    <script>
        $(document).ready(function() {
            $("#1001000").addClass('active');
            $("#1000000").addClass('active');
            $("#1000000").addClass('is-expanded');
            $('#sub').hide(); // hide the submit button on page load
        });

        function calculate() {
            var totalRow = '',
                columnNo = $('#indent_list table tr:first td').length;
            for (var index = 0; index < columnNo; index++) {
                var total = 0;
                $('#indent_list table tr').each(function() {
                    total += +$('td .total_price', this).eq(index).val(); //+ will convert string to number
                });

                totalRow += '<td>' + total + '</td>';
            }
            $('#indent_list_total table').html('<tr>' + totalRow + '</tr>');
            var totalval = $('#indent_list_total table td:first').text();
            
            $('#dr_amount').val(totalval);
            $('#cr_amount').val(totalval);
            
            var totalval = $('#indent_list_total table td:first').text();

            if (totalval == null || totalval == 0) {
                
                              Swal.fire({
                icon: 'warning',
                title: 'Empty List!',
                text: 'You cannot submit an empty list!',
              }).then((result) => {
                if (result.isConfirmed) {
                  // Do something if the user clicks the "OK" button
                }
              });
              $('#sub').hide(); // hide the submit button
            } else {
              $('#sub').show(); // show the submit button
            }

        }

        function unitPrice(val) {
            var inQ = $("#item_qty2" + val).val(); // Indent Quantity 
            var deQ = $("#item_qty1" + val).val(); // delivery Quantity
            var uprice = $("#unit_price_loc1" + val).val(); // unit_price_loc1 Quantity
            $.ajax({
                type: "POST",
                url: "getCashPurchase.php",
                data: 'item_no_deli=' + val,
                beforeSend: function() {
                    $(".item_qty22").addClass("loader");
                },
                success: function(response) {
                       response = JSON.parse(response); // Parse the JSON response
                        console.log(response.unit_price_loc);
                        console.log(response.current_stock);
                        var stock_balence=response.current_stock - deQ;
                        console.log(stock_balence);
                        console.log(deQ);
            
                        // Check if current_stock is negative
                        if (response.current_stock < 0) {
                           
                              Swal.fire({
                                icon: 'warning',
                                title: 'Stock is Negative!',
                                text: 'You cannot submit Negative Stock!',
                              }).then((result) => {
                                if (result.isConfirmed) {
                                  // Do something if the user clicks the "OK" button
                                }
                              });
                        }
                        if (stock_balence < 0) {
                            
                        
                                  Swal.fire({
                                icon: 'warning',
                                title: 'Stock is Negative!',
                                text: 'You cannot submit Negative Stock!',
                              }).then((result) => {
                                if (result.isConfirmed) {
                                  // Do something if the user clicks the "OK" button
                                }
                              });
                        }

                        $("#unit_price_loc1" + val).val(response.unit_price_loc);

                    if ((inQ - 0) >= (deQ - 0)) {
                        $("#item_qty1" + val).css({
                            "color": "black",
                            "border": "2px solid #8a9290"
                        });
                        $("#item_qty2" + val).css({
                            "color": "black",
                            "border": "2px solid #8a9290"
                        });

                        var sub_total = 0;
                        for (j = 1; j <= val; j++) {
                            var item_qty = 0;
                            var unit_price_loc = 0;
                            // var item_total = 0;
                            var sub_val = $('#sub_total').val();
                            item_qty = $('#item_qty1' + j).val();
                            if (item_qty > 0) {
                                unit_price_loc = $('#unit_price_loc1' + j).val();
                                if (unit_price_loc > 0) {
                                    item_total = parseFloat(item_qty) * parseFloat(unit_price_loc);
                                    $('#total_price1' + j).val(item_total.toFixed(2));
                                    // sub_total_val = parseFloat(item_total);
                                    sub_total = parseFloat(sub_total) + parseFloat(item_total);
                                }
                            }
                        }

                    } else if ((inQ - 0) < (deQ - 0)) {
                        $("#item_qty1" + val).css({
                            "color": "red",
                            "border": "2px solid red"
                        });
                        $("#item_qty2" + val).css({
                            "color": "blue",
                            "border": "2px solid blue"
                        });
                            //   Swal.fire({
                            //     icon: 'warning',
                            //     title: 'Something Wrong!',
                            //     text: 'You cannot submit !',
                            //   }).then((result) => {
                            //     if (result.isConfirmed) {
                            //       // Do something if the user clicks the "OK" button
                            //     }
                            //   });
                    }
                }
            });

        }

        function getIndent(val) {
            $.ajax({
                type: "POST",
                url: "getCashPurchase.php",
                data: 'proj_phase_no=' + val,
                beforeSend: function() {
                    $(".indent_no").addClass("loader");
                },
                success: function(data) {
                    $(".indent_no").html(data);
                    $('.item_no').find('option[value]').remove();
                    $(".indent_no").removeClass("loader");
                    getItem();
                }
            });
        }

        function getItem(val) {
            $.ajax({
                type: "POST",
                url: "getCashPurchase.php",
                data: 'indent_no=' + val,
                beforeSend: function() {
                    $(".item_no").addClass("loader");
                },
                success: function(data) {
                    $("#item").html(data);
                }
            });
        }
    </script>
    </body>

    </html>