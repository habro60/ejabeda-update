<?php
require "../auth/auth.php";
require '../database.php';
$output = '';
?>
<form method="POST">
    <table class="table bg-light table-bordered table-sm">
        <thead>
            <tr>
                <th>Owner Name</th>
                <th>Flat Number</th>
                <th>Services Name</th>
                <th>Pay Method</th>
                <th>Bill Amount</th>
                <th>Effect Date</th>
                <th>Terminat Name</th>
                <th>Active Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $disflag = '0';
            $id = $_POST['owner_id'];
            $flat_no = $_POST['flat_no'];
            $sqlowner ="SELECT owner_id, Flat_no FROM apart_owner_sevice_facility where owner_id='$id' AND flat_no='$flat_no'";
            $queryowner = mysqli_query($conn, $sqlowner);
            $rowcount = mysqli_num_rows($queryowner);
            echo "$rowcount";
            if ($rowcount == '0') {
                $Sqlinsert = "INSERT INTO `apart_owner_sevice_facility` (`office_code`,`owner_id`,`flat_no`,`bill_charge_code`,`bill_charge_name`, `bill_pay_frequency`, bill_pay_method,pay_curr,bill_fixed_amt, ss_creator, ss_creator_on, ss_org_no) SELECT flat_info.office_code,flat_info.owner_id, flat_info.flat_no, apart_bill_charge_setup.bill_charge_code,apart_bill_charge_setup.bill_charge_name, apart_bill_charge_setup.bill_pay_frequency,apart_bill_charge_setup.bill_pay_method,apart_bill_charge_setup.pay_curr,apart_bill_charge_setup.bill_fixed_amt, apart_bill_charge_setup.ss_creator, apart_bill_charge_setup.ss_created_on, apart_bill_charge_setup.ss_org_no FROM flat_info, apart_bill_charge_setup  WHERE flat_info.owner_id ='$id' AND flat_info.flat_no='$flat_no'";
                $query = mysqli_query($conn, $Sqlinsert);
            }
            $sql = "SELECT apart_owner_sevice_facility.id,apart_owner_sevice_facility.office_code,apart_owner_sevice_facility.owner_id,apart_owner_sevice_facility.flat_no, apart_owner_sevice_facility.bill_charge_code, apart_owner_sevice_facility.bill_charge_name,apart_owner_sevice_facility.bill_pay_frequency,apart_owner_sevice_facility.bill_pay_method,apart_owner_sevice_facility.pay_curr,apart_owner_sevice_facility.bill_fixed_amt, apart_owner_sevice_facility.effect_date,apart_owner_sevice_facility.terminate_date, apart_owner_sevice_facility.allow_flag,apart_owner_info.owner_name FROM apart_owner_sevice_facility, apart_owner_info WHERE apart_owner_sevice_facility.owner_id=apart_owner_info.owner_id AND apart_owner_sevice_facility.owner_id='$id' AND apart_owner_sevice_facility.flat_no='$flat_no' order by apart_owner_sevice_facility.id ,apart_owner_sevice_facility.bill_charge_code";
            $query = mysqli_query($conn, $sql);
            if (!empty($query)) {
                if (is_array($query) || is_object($query)) {
                    while ($rows = $query->fetch_assoc()) {
            ?>
                        <tr>
                            <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $rows['office_code']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="bill_charge_code[]" class="form-control" value="<?php echo $rows['bill_charge_code']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="bill_pay_frequency[]" class="form-control" value="<?php echo $rows['bill_pay_frequency']; ?>" style="width: 100%" readonly>
                            <input type="hidden" name="bill_pay_method[]" class="form-control" value="<?php echo $rows['bill_pay_method']; ?>" style="width: 100%" readonly>
                        
                            <td style="background-color:powderblue; text-align: left; width:220px; font-weight:bold"><?php if ($rows['flat_no'] > $disflag) {
                                                                                            echo $rows['owner_name'];
                                                                                            $disflag = $rows['flat_no'];
                                                                                        } else {
                                                                                            echo "";
                                                                                        } ?></td>
                            <td>
                                <input type="text" name="flat_no[]" class="form-control" value="<?php echo $rows['flat_no']; ?>" style="width: 100%" readonly>
                            </td>
                            <td hidden>
                                <input type="text" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                            </td>
                            <td>
                                <input type="text" name="bill_charge_name[]" class="form-control" value="<?php echo $rows['bill_charge_name']; ?>" style="width: 180px" readonly>
                            </td>
                            <td>
                                <input type="text" name="bill_pay_method[]" class="form-control" value="<?php echo $rows['bill_pay_method']; ?>" style="width: 100%" readonly>
                            </td>
                            <td hidden>
                                <input type="text" name="pay_curr[]" class="form-control" value="<?php echo $rows['pay_curr']; ?>" style="width: 100%" readonly>
                            </td>
                            <td >
                                <input type="text" name="bill_fixed_amt[]" class="form-control" value="<?php echo $rows['bill_fixed_amt']; ?>" style="width: 100px" required>
                            </td>
                            <td>
                                <input type="date" name="effect_date[]" class="form-control" value="<?php echo $rows['effect_date']; ?>" style="width: 170px">
                            </td>
                            <td>
                                <input type="date" name="terminate_date[]" class="form-control" value="<?php echo $rows['terminate_date']; ?>" style="width: 170px">
                            </td>
                            <td>
                                <select name="allow_flag[]" class="form-control" style="width: 100px">
                                    <option value="1" <?php if ($rows['allow_flag'] == 1) { ?> selected="selected" <?php } ?>>Active</option>
                                    <option value="0" <?php if ($rows['allow_flag'] == 0) { ?> selected="selected" <?php } ?>>Inactive</option>
                                </select>
                            </td>
                            <input type="hidden" name="owner_id[]" value="<?php echo $rows['owner_id']; ?>" class="owner">
                        </tr>
                        <input type="hidden" name="owner" value="<?php echo $rows['owner_id']; ?>">
                <?php
                    }
                }
                ?>
        </tbody>
    </table>
    <input name="assignServices" type="submit" id="submit" value="Assigned Services" class="btn btn-info pull-right submit" />
<?php
            }
?>
</form>