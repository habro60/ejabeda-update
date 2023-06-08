<?php
require "../auth/auth.php";
require "../database.php";
$disrate = 0;
$vatrate = 0;
$taxrate = 0;
if (isset($_POST["submit"])) {
    $office_code = $_SESSION['office_code'];
    $in_out_flag = "1";
    $year_code = $_SESSION['org_fin_year_st'];
    $batch_no = $_POST['batch_no'];
    $tran_date = $_POST['tran_date'];
    // 
    $tran_mode_discount = "DIS";
    $discount_id = $_POST['discount_id'];
    $disrate = $_POST['discount'];
    $discount = "$_POST[discount]" . "%";
    $discount_amount = $_POST['discount_amount'];
    $tran_mode_vat = "VAT";
    $vat_id = $_POST['vat_id'];
    $vatrate = $_POST['vat'];
    $vat = "$_POST[vat]" . "%";
    $vat_amount = $_POST['vat_amount'];
    $tran_mode_tax = "TAX";
    $tax_id = $_POST['tax_id'];
    $taxrate = $_POST['tax'];
    $tax = "$_POST[tax]" . "%";
    $tax_amount = $_POST['tax_amount'];
    $vaucher_typedr = "DR";
    $vaucher_typecr = "CR";
    $by_account = $_POST['by_account'];
    $to_account = $_POST['to_account'];
    $particulardr = $_POST['particulardr'];
    $particularcr = $_POST['particularcr'];
    $draccount = $_POST['draccount'];
    $craccount = $_POST['craccount'];
    $bill_status = "PRODR";
    $item_status = "1";
    //
    $include = '0';
    //
    $ss_creator = $_SESSION['username'];
    $ss_org_no = $_SESSION['org_no'];
    //
    $acc_type = $_POST['acc_type'];
    if ($acc_type == 1) {
        $tran_mode = "PRODR";
        $order_type = "PRODR";
        $pay_on_vouch_no =  $_POST['batch_no'];
        $purchase_date =  $_POST['tran_date'];
        $bill_paid_flag = '2';
        $cheque_no = '';
        $cheque_date = '';
    } elseif ($acc_type == 2) {
        $tran_mode = "PRODR";
        $order_type = "PRODR";
        $pay_on_vouch_no =  $_POST['batch_no'];
        $purchase_date =  $_POST['tran_date'];
        $bill_paid_flag = '2';
        // 
        $cheque_no = $_POST['cheque_no'];
        $cheque_date = $_POST['cheque_date'];
    } else {
        $tran_mode = "PRODR";
        $order_type = "PRODR";
        $pay_on_vouch_no = '';
        $purchase_date = $_POST['tran_date'];
        $bill_paid_flag = '';
        $cheque_no = '';
        $cheque_date = '';
    }

    // dr
    $insertQuerydr = "INSERT INTO `tran_details` (`tran_no`, `auto_tran_no`, `office_code`, `year_code`, `batch_no`, `tran_date`, `back_value_date`, `gl_acc_code`, `tran_mode`, `vaucher_type`, `dr_amt_loc`, `cr_amt_loc`, `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `pay_on_vouch_no`, `purchase_date`, `bill_paid_flag`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no`) VALUES (NULL, '0', '$office_code', '$year_code', '$batch_no', '$tran_date', '9999-09-09 18:50:44', '$by_account', '$tran_mode', '$vaucher_typedr', '$draccount', '0.00', '0.00', '0.00', '', '', '', '9999-09-09', '', '0.0000', '$particulardr', '', '', '', '', '', '9999-09-09 00:00:00', '0', '$tran_date', '1', '$ss_creator', now(), 'N/A', now(), '$ss_org_no')";
    //  echo $insertQuerydr;
    // exit;  
    $conn->query($insertQuerydr);
    if ($conn->affected_rows == 1) {
        $massage_dr = "dr Save Successfully!!";
    }
    // cr
    $insertQuerycr = "INSERT INTO `tran_details` (`tran_no`, `auto_tran_no`, `office_code`, `year_code`, `batch_no`, `tran_date`, `back_value_date`, `gl_acc_code`, `tran_mode`, `vaucher_type`, `dr_amt_loc`, `cr_amt_loc`, `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `pay_on_vouch_no`, `purchase_date`, `bill_paid_flag`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no`) VALUES (NULL, '0', '$office_code', '$year_code', '$batch_no', '$tran_date', '9999-09-09 18:50:44', '$to_account', '$tran_mode', '$vaucher_typecr', '0.00', '$craccount', '0.00', '0.00', '', '', '', '9999-09-09', '', '0.0000', '$particularcr', '', '', '', '', '', '9999-09-09 00:00:00', '0', '$tran_date', '1', '$ss_creator', now(), 'N/A', now(), '$ss_org_no')";
    // echo $insertQuerycr;
    // exit;
    $conn->query($insertQuerycr);
    if ($conn->affected_rows == 1) {
        $massage_cr = "cr Save Successfully!!";
    }
    $updateChq = "update bank_chq_leaf_info set leaf_status=1, status_date= '$purchase_date' where chq_leaf_no='$cheque_no'";
    if ($acc_type==2) {
        $conn->query($updateChq);
    } else {
        echo  $conn->error;
    }

    $insertQuerydis = "INSERT INTO `tran_details` (`tran_no`, `auto_tran_no`, `office_code`, `year_code`, `batch_no`, `tran_date`, `back_value_date`, `gl_acc_code`, `tran_mode`, `vaucher_type`, `dr_amt_loc`, `cr_amt_loc`, `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `pay_on_vouch_no`, `purchase_date`, `bill_paid_flag`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no`) VALUES (NULL, '0', '$office_code', '$year_code', '$batch_no', '$tran_date', '9999-09-09 18:50:44', '$discount_id', '$tran_mode_discount', '$vaucher_typecr', '0.00', '$discount_amount', '0.00', '0.00', '', '', '', '9999-09-09', '', '0.0000', '$discount', '', '', '', '', '', '9999-09-09 00:00:00', '0', '$tran_date', '1', '$ss_creator', now(), 'N/A', now(), '$ss_org_no')";
    if ($discount_amount != 0) {
        $conn->query($insertQuerydis);
    } else {
        echo  $conn->error;
    }
    
    $insertQueryvat = "INSERT INTO `tran_details` (`tran_no`, `auto_tran_no`, `office_code`, `year_code`, `batch_no`, `tran_date`, `back_value_date`, `gl_acc_code`, `tran_mode`, `vaucher_type`, `dr_amt_loc`, `cr_amt_loc`, `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `pay_on_vouch_no`, `purchase_date`, `bill_paid_flag`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no`) VALUES (NULL, '0', '$office_code', '$year_code', '$batch_no', '$tran_date', '9999-09-09 18:50:44', '$vat_id', '$tran_mode_vat', '$vaucher_typedr', '$vat_amount', '0.00', '0.00', '0.00', '', '', '', '9999-09-09', '', '0.0000', '$vat', '', '', '', '', '', '9999-09-09 00:00:00', '0', '$tran_date', '1', '$ss_creator', now(), 'N/A', now(), '$ss_org_no')";


    if ($vat_amount != 0) {
        $conn->query($insertQueryvat);
    } else {
        echo  $conn->error;
    }
    
    $insertQuerytax = "INSERT INTO `tran_details` (`tran_no`, `auto_tran_no`, `office_code`, `year_code`, `batch_no`, `tran_date`, `back_value_date`, `gl_acc_code`, `tran_mode`, `vaucher_type`, `dr_amt_loc`, `cr_amt_loc`, `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `pay_on_vouch_no`, `purchase_date`, `bill_paid_flag`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no`) VALUES (NULL, '0', '$office_code', '$year_code', '$batch_no', '$tran_date', '9999-09-09 18:50:44', '$tax_id', '$tran_mode_tax', '$vaucher_typedr', '$tax_amount', '0.00', '0.00', '0.00', '', '', '', '9999-09-09', '', '0.0000', '$tax', '', '', '', '', '', '9999-09-09 00:00:00', '0', '$tran_date', '1', '$ss_creator', now(), 'N/A', now(), '$ss_org_no')";
    if ($tax_amount != 0) {
        $conn->query($insertQuerytax);
    } else {
        echo  $conn->error;
    }
    for ($count = 0; $count < count($_POST["item_no"]); $count++) {

        $office_code  = $office_code;
        $order_type  = $order_type;
        $in_out_flag  = $in_out_flag;
        $batch_no  = $batch_no;
        $gl_acc_code   = $_POST["to_account"];
        $for_gl_acc_code   = $_POST["by_account"];
        
        $tran_date  = $tran_date;
        $item_no   = $_POST["item_no"][$count];
        $item_qty = $_POST["item_qty"][$count];
        $item_unit = $_POST["item_unit"][$count];
        $unit_price_loc  = $_POST["unit_price_loc"][$count];
        $total_price_loc = $_POST["total_price"][$count];
        $include = $include;
        $include_discount_rate = (float)$disrate;
        $include_discount_amt = (((float)$disrate * (float)$_POST["total_price"][$count]) / 100);
        $include_vat_rate = (float)$vatrate;
        $include_vat_amt = ((((float)$_POST["total_price"][$count] - (((float)$disrate * (float)$_POST["total_price"][$count]) / 100)) * (float)$vatrate) / 100);
        $include_tax_rate = (float)$taxrate;
        $include_tax_amt = ((((float)$_POST["total_price"][$count] - (((float)$disrate * $_POST["total_price"][$count]) / 100)) * (float)$taxrate) / 100);
        $bill_status = $bill_status;
        $item_status = $item_status;
        $status_date = $tran_date;
        $ss_creator  = $ss_creator;
        $ss_modofier_on  = $tran_date;
        $ss_org_no  = $ss_org_no;
        if (empty($include_discount_rate)) {
            $include_discount_rate = '0';
        }
        if (empty($include_vat_rate)) {
            $include_vat_rate = '0';
        }
        if (empty($include_tax_rate)) {
            $include_tax_rate = '0';
        }
        $query = "INSERT INTO sales_detail (office_code,order_type,in_out_flag, order_no, gl_acc_code, order_date, item_no, item_qty, item_unit, unit_price_loc,total_price_loc, include, include_discount_rate, include_discount_amt, include_vat_rate, include_vat_amt, include_tax_rate, include_tax_amt, bill_status, item_status,status_date, for_gl_acc_code, ss_creator,ss_created_on,ss_modofier_on,ss_org_no) VALUES ('$office_code','$order_type','$in_out_flag','$batch_no','$gl_acc_code','$tran_date','$item_no','$item_qty','$item_unit', '$unit_price_loc','$total_price_loc','$include','$include_discount_rate', '$include_discount_amt','$include_vat_rate','$include_vat_amt','$include_tax_rate', '$include_tax_amt','$bill_status','$item_status','$status_date','$for_gl_acc_code','$ss_creator',now(),now(),'$ss_org_no')";

        $conn->query($query);
        if ($conn->affected_rows == 1) {
            $massage = "Purchase Successfully!!";
        }
    }
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=product_receive_voucher.php\">";
}
require "../source/top.php";
$pid = 1001000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";

$querys = "insert into bach_no (username) values ('$_SESSION[username]')";
$returns = mysqli_query($conn, $querys);
$lastRows = $conn->insert_id;
?>

<main class="app-content">
    <form action="" method="post">
        <table class="table bg-light table-bordered table-sm">
            <thead>
                <tr>
                    <th>Purchase Voucher No</th>
                    <th style="text-align: center">Received Date</th>
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
        <table class="table bg-light table-bordered table-sm" id="multi_table">
            <thead>
                <tr class="table-active">
                    <th>No</th>
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><select name="item_no[]" class="form-control item_no unitChange" required>
                            <option value="">-Select Item-</option>
                            <?php
                            $selectQuery = "SELECT id, item_name FROM `item` where  (sellable_option='Y' or sellable_option='B')";
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

        <table class="table bg-light table-bordered table-hover table-sm">
            <tfoot>
                <tr>
                    <td></td>
                    <td><select class="form-control select2" name="by_account" style="width:250px" required>
                            <option value="">---Product Receive A/C---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where  category_code = '1' and acc_type = '20' and postable_acc= 'Y' ORDER by acc_code";
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
                    <td><select name="discount_id" class="form-control">
                            <option value="">-Select Discount Account-</option>
                            <?php
                            $selectQuery = 'SELECT gl_acc_code.acc_code,gl_acc_code.acc_head,gl_acc_code.postable_acc, tax_vat_rate_master.gl_acc_against_pur,tax_vat_rate_details.from_amount, tax_vat_rate_details.to_amount, tax_vat_rate_details.tax_on_rate, tax_vat_rate_details.tax_type  FROM `gl_acc_code`, `tax_vat_rate_master`, tax_vat_rate_details WHERE gl_acc_code.acc_code=tax_vat_rate_master.gl_acc_against_pur and tax_vat_rate_master.tax_type=tax_vat_rate_details.tax_type GROUP by gl_acc_code.acc_code';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['acc_code'] . '">' . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                    <td style="width: 5px"><strong>@</strong></td>
                    <td><input type="text" name="discount" class="discount form-control" id="discount" value=""></td>
                    <td><input type="text" name="discount_amount" value="0" class="discount_amount form-control" id="discount_amount"></td>
                    <input type="hidden" name="discount_before_amount" class="discount_before_amount form-control" id="discount_before_amount" readonly>
                    <input type="hidden" name="discount_after_amount" class="discount_after_amount form-control" id="discount_after_amount" readonly>
                    <td style="width: 20px"> <strong>Cr</strong></td>

                </tr>
                <!-- vat -->
                <tr>
                    <td></td>
                    <td style="width: 250px"><select name="vat_id" class="form-control">
                            <option value="">-Select VAT Account-</option>
                            <?php
                            $selectQuery = 'SELECT gl_acc_code.acc_code,gl_acc_code.acc_head,gl_acc_code.postable_acc, tax_vat_rate_master.gl_acc_against_pur,tax_vat_rate_details.from_amount, tax_vat_rate_details.to_amount, tax_vat_rate_details.tax_on_rate, tax_vat_rate_details.tax_type  FROM `gl_acc_code`, `tax_vat_rate_master`, tax_vat_rate_details WHERE gl_acc_code.acc_code=tax_vat_rate_master.gl_acc_against_pur and tax_vat_rate_master.tax_type=tax_vat_rate_details.tax_type GROUP by gl_acc_code.acc_code';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['acc_code'] . '">' . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                    <td style="width: 5px"><strong>@</strong></td>
                    <td style="width: 250px"><input type="text" name="vat" class="vat form-control" id="vat"></td>
                    <td style="width: 250px"><input type="text" name="vat_amount" value="0" class="vat_amount form-control" id="vat_amount" readonly></td>
                    <input type="hidden" name="vat_before_amount" class="vat_before_amount form-control" id="vat_before_amount" readonly>
                    <input type="hidden" name="vat_after_amount" class="vat_after_amount form-control" id="vat_after_amount" readonly>
                    <td style="width: 20px"> <strong>Dr</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width: 250px"><select name="tax_id" class="form-control">
                            <option value="">-Select Tax Account-</option>
                            <?php
                            $selectQuery = 'SELECT  gl_acc_code.acc_code,gl_acc_code.acc_head,gl_acc_code.postable_acc, tax_vat_rate_master.gl_acc_against_pur,tax_vat_rate_details.from_amount, tax_vat_rate_details.to_amount, tax_vat_rate_details.tax_on_rate, tax_vat_rate_details.tax_type  FROM `gl_acc_code`, `tax_vat_rate_master`, tax_vat_rate_details WHERE gl_acc_code.acc_code=tax_vat_rate_master.gl_acc_against_pur and tax_vat_rate_master.tax_type=tax_vat_rate_details.tax_type GROUP by gl_acc_code.acc_code';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['acc_code'] . '">' . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                    <td style="width: 5px"><strong>@</strong></td>
                    <td style="width: 250px"><input type="text" name="tax" class="tax form-control" id="tax"></td>
                    <td style="width: 250px"><input type="text" name="tax_amount" value="0" class="tax_amount form-control" id="tax_amount" readonly></td>
                    <input type="hidden" name="tax_before_amount" class="tax_before_amount form-control" id="tax_before_amount" readonly>
                    <input type="hidden" name="tax_after_amount" class="tax_after_amount form-control" id="tax_after_amount" placeholder="Net Amount" readonly>
                    <td style="width: 20px"> <strong>Dr</strong></td>
                </tr>
                <tr>
                    <th colspan="4" style="text-align:right">Net Total</th>
                    <td style="width: 250px"><input type="text" id="grand_total" class="grand_total form-control" style="width:100%" readonly></td>
                </tr>
                <tr>
                    <td></td>
                    <td><select class="form-control grand" name="to_account" onchange="toAccount()" id="to_account" required>
                            <option value="">---Select Revenue A/C ---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where  category_code='3' and acc_type='20' and postable_acc= 'Y' ORDER BY acc_code";
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
                <tr id="cheque_no_td" hidden>
                    <td></td>
                    <td>
                        <select class="form-control" name="cheque_no" id="cheque_no">
                        </select>
                    </td>
                    <td colspan="2"> <input type="date" class="form-control" name="cheque_date" id="cheque_date"></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <div class="col-12">
            <!-- <h3 style="color:red" id="showalert"></h3> -->
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
    <script>
        $(document).ready(function() {
            $("#1001000").addClass('active');
            $("#1000000").addClass('active');
            $("#1000000").addClass('is-expanded');
        });
    </script>
    <script>
        $(document).ready(function() {
            var count = 1;
            $(document).on('click', '#add_row', function() {
                count++;
                var html_code = '';
                html_code += '<tr id="row_id_' + count + '">';
                html_code += '<td><span id="sr_no">' + count + '</span></td>';
                html_code += '<td><select name="item_no[]" onchange="unitChangeRow(' + count + ')" id="item_no' + count + '" class="form-control item_no"><option value="">-Select Item-</option><?php $selectQuery = "SELECT id, item_name FROM `item` where (sellable_option='N' or sellable_option='B')";
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

            function discount(count) {
                var discount = 0;
                discount = $('#discount').val();
                if (discount > 0) {
                    discount_before_amount = $('#sub_total').val();
                    discount_amount = (parseFloat(discount_before_amount) / 100) * parseFloat(discount);
                    $('#discount_amount').val(discount_amount);
                    $('#discount_before_amount').val(discount_before_amount);
                    discount_after_amount = discount_before_amount - discount_amount;
                    $('#discount_after_amount').val(discount_after_amount);
                    if (discount > 0) {
                        $('#grand_total').val(discount_after_amount);
                        $('#cr_amount').val(discount_after_amount);
                    } else {
                        $('#grand_total').val(sub_total);
                        $('#cr_amount').val(sub_total);
                    }
                } else {}
            }
            $(document).on('keyup', '.discount', function() {
                discount(count);
            });

            function vat(count) {
                var vat = 0;
                vat = $('#vat').val();
                discount_vat = $('#discount').val();
                if (vat > 0) {
                    if (discount_vat > 0) {
                        vat_before_amount = $('#discount_after_amount').val();
                    } else {
                        vat_before_amount = $('#sub_total').val();
                    }
                    vat_amount = (parseFloat(vat_before_amount) / 100) * parseFloat(vat);
                    $('#vat_amount').val(vat_amount);
                    $('#vat_before_amount').val(vat_before_amount);
                    vat_after_amount = (vat_before_amount - (-vat_amount));
                    $('#vat_after_amount').val(vat_after_amount);
                    if (vat_after_amount > 0) {
                        $('#grand_total').val(vat_after_amount);
                        $('#cr_amount').val(vat_after_amount);
                    } else {
                        vat_before_amount = $('#sub_total').val();
                        $('#grand_total').val(vat_before_amount);
                        $('#cr_amount').val(vat_before_amount);
                    }
                } else {}
            }
            $(document).on('keyup', '.vat', function() {
                vat(count);
            });

            function tax(count) {
                var tax = 0;
                var vat_after_amount = 0;
                tax = $('#tax').val();
                discount_tax = $('#discount').val();
                if (tax > 0) {
                    if (discount_tax > 0) {
                        tax_before_amount = $('#discount_after_amount').val();
                    } else {
                        tax_before_amount = $('#sub_total').val();
                    }
                    tax_amount = (parseFloat(tax_before_amount) / 100) * parseFloat(tax);
                    $('#tax_amount').val(tax_amount);
                    // tax_before_amount = $('#discount_after_amount').val();
                    $('#tax_before_amount').val(tax_before_amount);
                    if (vat_after_amount == 0) {
                        ttt = $('#sub_total').val();
                        discountamount = $('#discount_amount').val();
                        discounvat = $('#vat_amount').val();
                        total = (ttt - discountamount - (-discounvat) - (-tax_amount));
                        $('#tax_after_amount').val(total);
                    } else {
                        tax_after_amount = (vat_after_amount - (-tax_amount));
                        $('#tax_after_amount').val(tax_after_amount);
                    }

                    if (tax_after_amount > 0) {
                        $('#grand_total').val(tax_after_amount);
                        $('#cr_amount').val(tax_after_amount);
                    } else {
                        ttt = $('#sub_total').val();
                        discountamount = $('#discount_amount').val();
                        discounvat = $('#vat_amount').val();
                        total = (ttt - discountamount - (-discounvat) - (-tax_amount));
                        $('#grand_total').val(total);
                        $('#cr_amount').val(total);
                    }
                } else {

                }
            }
            $(document).on('keyup', '.tax', function() {
                tax(count);
            });
        });
        $('#discount_amount').blur(function() {
            var net_total = $('#grand_total').val() - $(this).val();;
            var to_account = $('#cr_amount').val() - $(this).val();;
            $('#grand_total').val(net_total);
            $('#cr_amount').val(to_account);
        });

        function toAccount() {
            var account_no = $('#to_account').val();
            $.ajax({
                type: "POST",
                url: "getRecivProd.php",
                data: {
                    to_account: account_no
                },
                dataType: "text",
                success: function(response) {

                    $('#acc_type').val(response);
                    $('#showalert').text();
                    $('#cheque_no_td').attr('hidden', true);
                    if (response == 1) {
                        $("#showalert").text('PAID');
                        $("#particularcr").val('Cash in Hand');
                    } else {
                        $('#showalert').text('DUE');
                        $("#particularcr").val('');
                    }

                    if (response == 2) {
                        $('#cheque_no_td').attr('hidden', false);
                        $.ajax({
                            type: "POST",
                            url: "getRecivProd.php",
                            data: {
                                to_account_chq: account_no
                            },
                            dataType: "text",
                            success: function(data) {
                                $('#cheque_no').html(data);
                            }
                        });
                    }
                }
            });
        }

        $('.unitChange').on('change', function(e) {
            e.preventDefault;
            var item_no = this.value;
            $.ajax({
                url: "getRecivProd.php",
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
                url: "getRecivProd.php",
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
                url: "getRecivProd.php",
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
                url: "getRecivProd.php",
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
    </body>

    </html>