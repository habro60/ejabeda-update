<?php
require "../auth/auth.php";
require '../database.php';
$output = '';
?>
<form method="POST">
    <table class="table bg-light table-bordered table-sm">
        <thead>
            <tr>
                <th>Flat Number</th>
                <th>Bill Charge Code</th>
                <th>Charge Name</th>
                <th>Voucher No.</th>
                <th>Bill Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $disflag = '0';
            $bill_for_month = $_POST['bill_for_month'];
            $flat_no = $_POST['flat_no'];
            
            $sql = "SELECT id,`flat_no`,office_code,`owner_id`,`bill_for_month`,`bill_charge_code`,`bill_charge_name`,`bill_paid_flag`,`bill_paid_date`,`bill_process_date`,`bill_amount`, `owner_gl_code`,`link_gl_acc_code`, batch_no FROM `apart_owner_bill_detail` where `bill_for_month`='$bill_for_month' and `flat_no`='$flat_no' and bill_paid_flag='0'";
            $query = mysqli_query($conn, $sql);
            if (!empty($query)) {
                if (is_array($query) || is_object($query)) {
                    while ($rows = $query->fetch_assoc()) {
            ?>
            <input type="hidden" name="flat_no_for_tran" value="<?php echo  $flat_no; ?>">
            <input type="hidden" name="bill_for_month_tran" value="<?php echo   $bill_for_month; ?>">
                        <tr>
                            <input type="hidden" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>
                            <td>
                                <input type="text" name="flat_no[]" class="form-control" value="<?php echo $rows['flat_no']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="bill_charge_code[]" class="form-control" value="<?php echo $rows['bill_charge_code']; ?>" style="width: 100%" readonly>
                             </td>
                            <td>
                                <input type="text" name="bill_charge_name[]" class="form-control" value="<?php echo $rows['bill_charge_name']; ?>" style="width: 200px" readonly>
                            </td><td>
                                <input type="text" name="batch_no[]" class="form-control" value="<?php echo $rows['batch_no']; ?>" style="width: 200px" readonly>
                            </td>

                            <td>
                                <input type="text" name="bill_amount[]" class="form-control" value="<?php echo $rows['bill_amount']; ?>" style="width: 100px" required>
                            </td>


                        </tr>
                <?php
                    }
                }
                ?>
        </tbody>
    </table>
    <input name="assignServices" type="submit" id="submit" value="submit" class="btn btn-info pull-right submit" />
<?php
            }
?>
</form>