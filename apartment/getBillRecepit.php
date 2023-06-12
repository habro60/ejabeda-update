<?php
require "../auth/auth.php";
require '../database.php';
$output = '';
?>
<table class="table bg-light table-bordered table-sm table">
    <thead>
        <tr style="background-color: powderblue">
            <th>Bill for Month</th>
            <th>Flat No</th>
            <th>Bill Name</th>
            <th>Bill amount</th>
            <th>POST</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $to_account = $_POST['to_account'];
        $total_bill = 0;
        $total_b = 0;
        $no = 0;
        $billsql = "SELECT apart_owner_bill_detail.flat_no,apart_owner_bill_detail.bill_charge_code, apart_owner_bill_detail.owner_gl_code,  apart_owner_bill_detail.bill_for_month, apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.pay_curr, apart_owner_bill_detail.bill_amount,apart_owner_bill_detail.bill_paid_flag FROM apart_owner_bill_detail WHERE apart_owner_bill_detail.owner_gl_code='$to_account' AND apart_owner_bill_detail.bill_paid_flag=0 order by apart_owner_bill_detail.flat_no, apart_owner_bill_detail.bill_charge_code";
        $query = mysqli_query($conn, $billsql);
        $rows_no = mysqli_num_rows($query);
        while ($rows = $query->fetch_assoc()) {
            $total_b =  $total_b + $rows['bill_amount'];
            $no ++;
        ?>
            <tr>
                <td hidden>
                    <input type="hidden" name="bill_charge_code[]" class="form-control" value="<?php echo $rows['bill_charge_code']; ?>" style="width: 100%" readonly>
                </td>
                <td hidden>
                    <input type="hidden" name="owner_gl_code[]" class="form-control" value="<?php echo $rows['owner_gl_code']; ?>" style="width: 100%" readonly>
                </td>
                <td>
                    <input type="text" name="bill_for_month[]" class="form-control" value="<?php echo $rows['bill_for_month']; ?>" style="width: 100%" readonly>
                </td>
                <td>
                    <input type="text" name="flat_no[]" class="form-control" value="<?php echo $rows['flat_no']; ?>" readonly>
                </td>
                <td>
                    <input type="text" name="bill_charge_name[]" class="form-control" value="<?php echo $rows['bill_charge_name']; ?>" id="bill_charge_name<?php echo round($no); ?>" style="width: 100%" readonly>
                </td>
                <input type="hidden" name="pay_curr[]" class="form-control" value="<?php echo $rows['pay_curr']; ?>" style="width: 100%" readonly>
                <td>
                    <input type="text" name="bill_amount[]" class=" form-control" value="<?php echo $rows['bill_amount']; ?>" id="bill_amount<?php echo round($no); ?>" style="width: 100%" readonly>
                </td>
                <td hidden>
                    <input type="hidden" name="bill_paid_flag[]" class="form-control" value="" id="flag<?php echo round($no); ?>" readonly>
                </td>
                <td style="text-align: center">
                    <button type="button" onclick="returnPost('<?php echo $rows['bill_charge_name']; ?>','<?php echo $rows['bill_amount']; ?>','<?php echo $no; ?>')" id="bill_paid_flag<?php echo round($no); ?>" class="btn btn-info"> POST </button>
                    <button type="button" onclick="returnSkip('<?php echo $rows['bill_charge_name']; ?>','<?php echo $rows['bill_amount']; ?>','<?php echo $no; ?>')" id="bill_paid_flag_skip<?php echo round($no); ?>" class="btn btn-danger" disabled> SKIP </button>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr style="background-color:powderblue" ;>
            <th hidden><input type="text" name="" id="total_balance" value="<?php echo $total_b; ?>"></th>
            <th style="text-align:right" colspan="3"> Total Amount in TK.</th>
            <th style="text-align:left" colspan="1"><input type="text" name="craccount" id="crAccount" class="form-control total" value="<?php echo $total_bill; ?>" style="text-align:right" colspan="1" readonly></th>
        </tr>
    </tfoot>
</table>