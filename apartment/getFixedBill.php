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
                <th>Bill Month</th>
                <th>Owner name</th>
                <th>Flat Number</th>
                <th>Services Name</th>
                <th>Bill Amount</th>
                <th>Last Payment Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $flat_no = 0;
            $bill_date = $_POST['bill_date'];
            $bill_for_month = $_POST['bill_for_month'];
           
              $sql="CREATE or replace view mth_view as select flat_no, bill_for_month, bill_amount, bill_paid_flag from apart_owner_bill_detail where bill_for_month >= '$bill_for_month' and bill_paid_flag='1'";
              $sqlReturn = mysqli_query($conn, $sql);
              

              $sqlView ="select flat_no from mth_view";
             
              $sqlViewReturn = mysqli_query($conn, $sqlView);
              $rowcount = mysqli_num_rows($sqlViewReturn);
            
              if ($rowcount == '0') {
                $sql="SELECT apart_owner_sevice_facility.id,apart_owner_sevice_facility.office_code,apart_owner_sevice_facility.owner_id,apart_owner_info.owner_name,apart_owner_sevice_facility.bill_charge_code,apart_owner_sevice_facility.bill_charge_name,apart_owner_sevice_facility.effect_date,apart_bill_charge_setup.bill_pay_method,apart_bill_charge_setup.pay_curr,apart_owner_sevice_facility.bill_fixed_amt,apart_bill_charge_setup.link_gl_acc_code, apart_owner_sevice_facility.allow_flag,apart_bill_charge_setup.bill_charge_code,apart_owner_info.owner_id, apart_owner_sevice_facility.flat_no, apart_owner_info.gl_acc_code from apart_owner_sevice_facility, apart_bill_charge_setup, apart_owner_info where apart_owner_sevice_facility.bill_charge_code=apart_bill_charge_setup.bill_charge_code and apart_owner_sevice_facility.allow_flag=1 and apart_owner_sevice_facility.owner_id=apart_owner_info.owner_id  and apart_bill_charge_setup.bill_pay_method ='fixed'";
                       
                 }
               else {
                $sql="SELECT apart_owner_sevice_facility.id,apart_owner_sevice_facility.office_code,apart_owner_sevice_facility.owner_id, apart_owner_sevice_facility.flat_no, apart_owner_sevice_facility.bill_charge_code,apart_owner_sevice_facility.bill_charge_name,apart_owner_sevice_facility.effect_date, apart_owner_sevice_facility.allow_flag, apart_owner_sevice_facility.bill_fixed_amt, apart_owner_info.gl_acc_code, apart_bill_charge_setup.link_gl_acc_code, mth_view.bill_paid_flag, apart_owner_info.owner_name , apart_bill_charge_setup.bill_pay_method, apart_bill_charge_setup.pay_curr from apart_owner_sevice_facility left join mth_view on apart_owner_sevice_facility.flat_no = mth_view.flat_no left join apart_owner_info on apart_owner_sevice_facility.owner_id=apart_owner_info.owner_id  left join apart_bill_charge_setup on apart_bill_charge_setup.bill_charge_code=apart_owner_sevice_facility.bill_charge_code where mth_view.flat_no is null group by apart_owner_sevice_facility.flat_no";
               
            // $sql = "CREATE or replace view bill_detail_view  as SELECT apart_owner_sevice_facility.id,apart_owner_sevice_facility.office_code,apart_owner_info.owner_name,apart_owner_sevice_facility.bill_charge_name,apart_owner_sevice_facility.effect_date,apart_bill_charge_setup.bill_pay_method,apart_bill_charge_setup.pay_curr,apart_owner_sevice_facility.bill_fixed_amt,apart_bill_charge_setup.link_gl_acc_code, apart_owner_sevice_facility.allow_flag,apart_bill_charge_setup.bill_charge_code,apart_owner_info.owner_id, apart_owner_sevice_facility.flat_no, apart_owner_info.gl_acc_code from apart_owner_sevice_facility, apart_bill_charge_setup, apart_owner_info where apart_owner_sevice_facility.bill_charge_code=apart_bill_charge_setup.bill_charge_code and apart_owner_sevice_facility.allow_flag=1 and apart_owner_sevice_facility.owner_id=apart_owner_info.owner_id  and apart_bill_charge_setup.bill_pay_method ='fixed'";


            


               }          

            
            
            $query = mysqli_query($conn, $sql);
            if (!empty($query)) {
                if (is_array($query) || is_object($query)) {
                    while ($rows = $query->fetch_assoc()) {
                    ?>
                        <tr>
                            <input type="hidden" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="owner_id[]" class="form-control" value="<?php echo $rows['owner_id']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="bill_charge_code[]" class="form-control" value="<?php echo $rows['bill_charge_code']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="link_gl_acc_code[]" class="form-control" value="<?php echo $rows['link_gl_acc_code']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="bill_date[]" class="form-control" value="<?php echo $bill_date; ?>" style="width: 100%" readonly>
                             <input type="hidden" name="bill_date1" class="form-control" value="<?php echo $bill_date; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="bill_pay_method[]" class="form-control" value="<?php echo $rows['bill_pay_method']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="pay_curr[]" class="form-control" value="<?php echo $rows['pay_curr']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>
                            <td>
                                <input type="text" name="bill_for_month[]" class="form-control" value="<?php echo $bill_for_month; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="owner_name[]" class="form-control" value="<?php echo $rows['owner_name']; ?>" style="width: 100%" readonly>
                            <td>
                                <input type="text" name="flat_no[]" class="form-control" value="<?php echo $rows['flat_no']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="bill_charge_name[]" class="form-control" value="<?php echo $rows['bill_charge_name']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="bill_fixed_amt[]" class="form-control" value="<?php echo $rows['bill_fixed_amt']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="bill_last_pay_date[]" class="form-control" value="<?php echo $bill_last_pay_date; ?>" style="width: 100%" readonly>
                            </td>
                            <td hidden>
                                <input type="text" name="gl_acc_code[]" class="form-control" value="<?php echo $rows['gl_acc_code']; ?>" style="width: 100%" readonly>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
        <tfoot>
            <td colspan="5"></td>
            <td>
                <input name="submit" type="submit" id="submit" value="Submit Bill Process" class="btn btn-info" />
            </td>
        </tfoot>
        </tbody>
    </table>
<?php
            }
?>
</form>