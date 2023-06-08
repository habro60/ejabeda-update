<?php
require "../auth/auth.php";
require '../database.php';
$output = '';
?>
<form method="POST">
    <table class="table bg-light table-bordered table-sm">
        <thead>
            <tr>
                <th>Transaction No.</th>
                <th>Batch No.</th>
                <th>Transaction Date</th>
                <th>Transaction Mode</th>
                <th>Debit Amount</th>
                <th>Credit Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $disflag = '0';
            $bill_for_month = $_POST['bill_for_month'];
            $flat_no = $_POST['flat_no'];
            // SELECT * FROM `tran_details` WHERE `gl_acc_code`=103060102000 and (tran_date BETWEEN '2020-08-01' and '2020-08-31')
            
            $sql = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.tran_date,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.cr_amt_loc, apart_owner_bill_detail.bill_process_date,apart_owner_bill_detail.owner_gl_code,apart_owner_bill_detail.link_gl_acc_code FROM `apart_owner_bill_detail`,tran_details where tran_details.tran_date=apart_owner_bill_detail.bill_process_date and apart_owner_bill_detail.flat_no='$flat_no' and bill_for_month='$bill_for_month' and apart_owner_bill_detail.owner_gl_code=tran_details.gl_acc_code group by tran_details.batch_no order by tran_details.tran_no";
            $query = mysqli_query($conn, $sql);
            if (!empty($query)) {
                if (is_array($query) || is_object($query)) {
                    while ($rows = $query->fetch_assoc()) {
            ?>
                        <tr>
                            
                            <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>
                            
                            <input type="hidden" name="owner_gl_code[]" class="form-control" value="<?php echo $rows['owner_gl_code']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="link_gl_acc_code[]" class="form-control" value="<?php echo $rows['link_gl_acc_code']; ?>" style="width: 100%" readonly>
                            
                            <td>
                                <input type="text" name="tran_no[]" class="form-control" value="<?php echo $rows['tran_no']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="batch_no[]" class="form-control" value="<?php echo $rows['batch_no']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="tran_date[]" class="form-control" value="<?php echo $rows['tran_date']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="tran_mode[]" class="form-control" value="<?php echo $rows['tran_mode']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="dr_amt_loc[]" class="form-control" value="<?php echo $rows['dr_amt_loc']; ?>" style="width: 100%" >
                             </td>
                            <td>
                                <input type="text" name="cr_amt_loc[]" class="form-control" value="<?php echo $rows['cr_amt_loc']; ?>" style="width: 200px" >
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