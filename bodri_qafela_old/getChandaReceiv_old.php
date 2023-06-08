<?php
require "../auth/auth.php";
require '../database.php';
$output = '';
?>
<table class="table bg-light table-bordered table-sm table" id="bill_table">
    <thead>
        <tr style="background-color: powderblue">
            <th>Fund Name</th>
            <th>Currency</th>
            <th>Fund amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $to_account = $_POST['to_account'];
        $bill_date = $_POST['bill_date'];
        //  $toDate='2021-07-01';
        $total_bill = 0;
        $total_b = 0;
        

    $fundsql="SELECT
    donner_fund_detail.office_code,
    donner_fund_detail.member_id,
    donner_fund_detail.`fund_type`,
    donner_fund_detail.`fund_type_desc`,
    donner_fund_detail.donner_pay_amt,
    donner_fund_detail.num_of_pay,
    donner_fund_detail.num_of_paid,
    donner_fund_detail.last_paid_date,
    donner_fund_detail.pay_curr,
    donner_fund_detail.fund_paid_flag,
    fund_member.member_id,
    fund_member.full_name,
    fund_member.gl_acc_code,
    code_master.softcode,
    code_master.hardcode,
    code_master.description,
    sum(mthly_rate_setup.rate_amt) as tran_amt
    
    -- (12 * (YEAR('$bill_date') 
    --           - YEAR(last_paid_date)) 
    --    + (MONTH('$bill_date') 
    --        - MONTH(last_paid_date))) * donner_fund_detail.donner_pay_amt  as tran_amt 
FROM
    donner_fund_detail,
    mthly_rate_setup,
    fund_member,
    code_master
WHERE
code_master.hardcode='CURR' and code_master.softcode=donner_fund_detail.pay_curr and donner_fund_detail.member_id=fund_member.member_id and fund_member.gl_acc_code='$to_account' and (mthly_rate_setup.rate_date > donner_fund_detail.last_paid_date and mthly_rate_setup.rate_date  <= '$bill_date')";

        $query = mysqli_query($conn, $fundsql);
        $rows_no = mysqli_num_rows($query);
        while ($rows = $query->fetch_assoc()) {
            $total_b =  $total_b + $rows['tran_amt'];
        ?>
            <tr>
                <td hidden>
                    <input type="hidden" name="fro_date[]" class="form-control" value="<?php echo $rows['last_paid_date']; ?>" readonly>
                    <input type="hidden" name="member_id[]" class="form-control" value="<?php echo $rows['member_id']; ?>" readonly>
                </td>
                <td hidden>
                    <input type="hidden" name="fund_type[]" class="form-control" value="<?php echo $rows['fund_type']; ?>" readonly>
                </td>
                <td hidden>
                    <input type="hidden" name="gl_acc_code[]" class="form-control" value="<?php echo $rows['gl_acc_code']; ?>" readonly>
                </td>
                <td>
                    <input type="text" name="fund_type_desc[]" class="form-control" value="<?php echo $rows['fund_type_desc']; ?>" id="fund_type_desc<?php echo round($rows['tran_amt']); ?>" readonly>
                </td>
                <td>
                    <input type="text" name="pay_curr[]" class="form-control" value="<?php echo $rows['description']; ?>" readonly>
                </td>
                <td>
                    <input type="text" name="donner_pay_amt[]" class="form-control" value="<?php echo round($rows['tran_amt']); ?>" id="donner_paid_amt<?php echo round($rows['tran_amt']); ?>" readonly>
                </td>
                <td hidden>
                    <input type="hidden" name="flag[]" class="form-control" value="" id="flag<?php echo round($rows['tran_amt']); ?>" readonly>
                </td>
               
                <td style="text-align:center">
                    <button type="button" onclick="returnPost('<?php echo $rows['fund_type_desc']; ?>','<?php echo round($rows['tran_amt']); ?>')" id="fund_paid_flag<?php echo round($rows['tran_amt']); ?>" class="btn btn-info">Post</button>
                    <button type="button" onclick="returnSkip('<?php echo $rows['fund_type_desc']; ?>','<?php echo round($rows['tran_amt']); ?>')" id="fund_paid_flag_skip<?php echo round($rows['tran_amt']); ?>" class="btn btn-danger" disabled>Skip</button>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr style="background-color:powderblue" ;>
            <th hidden><input type="text" name="" id="total_balance" value="<?php echo $total_b; ?>"></th>
            <th style="text-align:right" colspan="2"> Total Amount in TK.</th>
            <th style="text-align:left" colspan="1"><input type="text" name="craccount" id="crAccount" class="form-control total" value="<?php echo $total_bill; ?>" style="text-align:right" colspan="1" readonly></th>
        </tr>
    </tfoot>
</table>