<?php
require "../auth/auth.php";
require '../database.php';
$querys = "insert into bach_no (username) values ('$_SESSION[username]')";
$returns = mysqli_query($conn, $querys);
$lastRows = $conn->insert_id;

$id=$_POST['id'];
$order_no=$_POST['order_no'];
$total=$_POST['total'];
$date = date('Y-m-d');
$sql_selcet = "INSERT INTO invoice_detail(`office_code`, `order_type`, `in_out_flag`, `order_no`,`gl_acc_code`, `order_date`, `item_no`, `item_qty`, `item_unit`, `unit_price_loc`, `unit_price_fc`, `curr_code`, `exch_rate`, `total_price_loc`, `total_price_fc`, `include`, `include_vat_rate`, `bar_code`, `item_origin`, `item_waranty`, `warranty_type`, `agaunest_indent_no`,`bill_status`, `item_status`, `status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no`) SELECT `office_code`,'SVR','2', '$lastRows',`gl_acc_code`, '$date', `item_no`, `item_qty`, `item_unit`, `unit_price_loc`, `unit_price_fc`, `curr_code`, `exch_rate`, `total_price_loc`, `total_price_fc`, `include`, `include_vat_rate`, `bar_code`, `item_origin`, `item_waranty`, `warranty_type`, `agaunest_indent_no`, 'SVR', '2',`status_date`, `status_ref`, `ss_creator`, `ss_created_on`, `ss_modifier`, `ss_modofier_on`, `ss_org_no` FROM invoice_detail WHERE id=$id";
$query=$conn->query($sql_selcet);
$sql_update = "UPDATE invoice_detail SET item_status='2', bill_status='SVR' WHERE id=$id AND order_type='SV' AND item_status='1'";
$query=$conn->query($sql_update);
// 
$sql_tran_dr = "INSERT INTO `tran_details`(`auto_tran_no`, `office_code`, `year_code`, `batch_no`, `tran_date`, `back_value_date`, `gl_acc_code`, `tran_mode`, `vaucher_type`, `dr_amt_loc`, `cr_amt_loc`, `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no`) SELECT `auto_tran_no`, `office_code`, `year_code`, '$lastRows', '$date', `back_value_date`, `gl_acc_code`, 'SVR', 'CR', '', '$total', `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no` FROM tran_details WHERE batch_no=$order_no AND vaucher_type='DR'";
$query=$conn->query($sql_tran_dr);
$sql_tran_cr = "INSERT INTO `tran_details`(`auto_tran_no`, `office_code`, `year_code`, `batch_no`, `tran_date`, `back_value_date`, `gl_acc_code`, `tran_mode`, `vaucher_type`, `dr_amt_loc`, `cr_amt_loc`, `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no`) SELECT `auto_tran_no`, `office_code`, `year_code`, '$lastRows', '$date', `back_value_date`, `gl_acc_code`, 'SVR', 'DR', '$total', '', `dr_amt_fc`, `cr_amt_fc`, `bank_name`, `branch_name`, `cheque_no`, `cheque_date`, `curr_code`, `exch_rate`, `description`, `reversaled`, `rev_tran_no`, `auto_tran`, `posted`, `verified_by_1`, `verified_date_1`, `ss_creator`, `ss_creator_on`, `ss_modified`, `ss_modified_on`, `ss_org_no` FROM tran_details WHERE batch_no=$order_no AND vaucher_type='CR' AND tran_mode='SV' limit 1";
$query=$conn->query($sql_tran_cr);
echo "Successfully";

?>