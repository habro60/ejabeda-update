<?php
require "../auth/auth.php";
require '../database.php';
$output = '';
$bill_for_month = $_POST['bill_for_month'];
$bill_last_pay_date = $_POST['bill_last_pay_date'];
$bill_date = $_POST['bill_date'];
?>
<form method="POST">
    <table class="table bg-light table-bordered table-sm">
        <thead>
            <tr>
                <th>Bill for Month</th>
                <th>Charge Code</th>
                <th>Charge  Number</th>
                <th>Amount</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            $sql ="SELECT id,bill_pay_method,  pay_curr,`bill_charge_code`,`bill_for_month`, bill_charge_name,sum(bill_amount) as sum_amt FROM `monthly_bill_entry` WHERE  `bill_for_month`='$bill_for_month'";
            $query = mysqli_query($conn, $sql);
            if (!empty($query)) {
                if (is_array($query) || is_object($query)) {
                    while ($rows = $query->fetch_assoc()) {
            ?>
                         <tr>
                            <input type="hidden" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>

                            <input type="hidden" name="bill_for_month[]" class="form-control" value="<?php echo $bill_for_month; ?>" style="width: 100%" readonly>
                             <input type="hidden" name="bill_for_month1" class="form-control" value="<?php echo $bill_for_month ?>" style="width: 100%" readonly>
                             <!-- <input type ="hidden" name ="bill_pay_method" class="form-control" value="<?php echo $bill_pay_method ?>"" style="width: 100%" readonly> -->

                             <input type="hidden" name="bill_date[]" class="form-control" value="<?php echo $bill_date; ?>" style="width: 100%" readonly>
                             <input type="hidden" name="bill_date1" class="form-control" value="<?php echo $bill_date; ?>" style="width: 100%" readonly>
                            
                            <input type="hidden" name="bill_pay_method[]" class="form-control" value="<?php echo $rows['bill_pay_method']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="pay_curr[]" class="form-control" value="<?php echo $rows['pay_curr']; ?>" style="width: 100%" readonly>

                            <input type="hidden" name="bill_last_pay_date[]" class="form-control" value="<?php echo $bill_last_pay_date; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="bill_last_pay_date1" class="form-control" value="<?php echo $bill_last_pay_date; ?>" style="width: 100%" readonly>
                          
                           <td>
                            <input type="text" name="bill_for_month[]" class="form-control" value="<?php echo $bill_for_month; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                               <input type="text" name="bill_charge_code[]" class="form-control" value="<?php echo $rows['bill_charge_code']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="bill_charge_name[]" class="form-control" value="<?php echo $rows['bill_charge_name']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="sum_amt[]" class="form-control" value="<?php echo $rows['sum_amt']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                               <input type="text" name="bill_last_pay_date[]" class="form-control" value="<?php echo $bill_last_pay_date; ?>" style="width: 100%" readonly>
                            </td>
                            
                        </tr>
                <?php
                    }
                }
                ?>
        </tbody>
        <tfoot>
            <td colspan="5">
            </td>
            <td>
                <input name="submit" type="submit" id="submit" value="Submit Bill Process" class="btn btn-info pull-right submit" />
            </td>
        </tfoot>
    </table>
<?php
            }
?>
</form>