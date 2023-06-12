<?php
require "../auth/auth.php";
require '../database.php';
$output = '';
?>
<table class="table bg-light table-bordered table-sm table" id="bill_table">
    <thead>
        <tr style="background-color: powderblue">
            <th>Fund Name</th>
            <th>Fund amount</th>
            <th>Due amount</th>
            <th>Waiver amount</th>
            <th>To be Paid</th>
            <th>Action</th>
        </tr>


    </thead>
    <tbody>
        <?php
        $to_account = $_POST['to_account'];
        $total_bill = 0;
        $total_b = 0;
        $fundsql = "SELECT donner_fund_detail.office_code, donner_fund_detail.member_id,donner_fund_detail.`fund_type`, donner_fund_detail.`fund_type_desc`,donner_fund_detail.donner_pay_amt,donner_fund_detail.num_of_pay,donner_fund_detail.due_amt,donner_fund_detail.num_of_paid,donner_fund_detail.donner_paid_amt
        ,sum((donner_fund_detail.donner_pay_amt + donner_fund_detail.due_amt)) as
         to_be_paid,donner_fund_detail.waiver_amt, donner_fund_detail.pay_curr, donner_fund_detail.fund_paid_flag,
          fund_member.member_id,fund_member.full_name, fund_member.gl_acc_code, code_master.softcode,code_master.hardcode,
           code_master.description FROM donner_fund_detail, fund_member, code_master where code_master.hardcode='CURR' and
            code_master.softcode=donner_fund_detail.pay_curr and donner_fund_detail.member_id=fund_member.member_id and
             donner_fund_detail.num_of_pay > donner_fund_detail.num_of_paid and fund_member.gl_acc_code='$to_account' 
             group by donner_fund_detail.fund_type";

        $query = mysqli_query($conn, $fundsql);
        $rows_no = mysqli_num_rows($query);
        $index=1;
        while ($rows = $query->fetch_assoc()) {
            $total_b =  $total_b + $rows['to_be_paid'];
        ?>
            <tr>
                <td hidden>
                    <input type="hidden" name="member_id[]" class="form-control" value="<?php echo $rows['member_id']; ?>" readonly>
                </td>
                <td hidden>
                    <input type="hidden" name="fund_type[]" class="form-control" value="<?php echo $rows['fund_type']; ?>" readonly>
                </td>
                <td hidden>
                    <input type="hidden" name="gl_acc_code[]" class="form-control" value="<?php echo $rows['gl_acc_code']; ?>" readonly>
                </td>
                <td>
                    <input type="text" name="fund_type_desc[]" class="form-control" value="<?php echo $rows['fund_type_desc']; ?>" id="fund_type_desc<?php echo $index; ?>" readonly>
                </td>

                <td>
                    <input type="text" name="donner_pay_amt[]" class="form-control" value="<?php echo $rows['donner_pay_amt']; ?>" readonly>
                </td>
                <td>
                    <input type="text" name="due_amt[]" class="form-control" value="<?php echo round($rows['due_amt']); ?>" id="due_amt<?php echo $index; ?>" readonly>
                </td>


                <td>
                    <input type="text" name="waiver_amt[]" class="form-control" value="0" id="waiver_amt<?php echo $index; ?>" >
                </td>
                <td>
                    <input type="text" name="to_be_paid[]" class="form-control" value="<?php echo round($rows['to_be_paid']); ?>" id="to_be_paid<?php echo $index; ?>" >
                    <input type="text" hidden name="to_be_paid_old[]" class="form-control" value="<?php echo round($rows['to_be_paid']); ?>" id="to_be_paid_old<?php echo $index; ?>" >
                </td>
               
                <td hidden>
                    <input type="hidden" name="flag[]" class="form-control" value="" id="flag<?php echo $index; ?>" readonly>
                </td>
                <td style="text-align:center">
                    <button type="button" onclick="returnPost('#to_be_paid<?php echo $index; ?>','<?php echo round($rows['to_be_paid']); ?>','<?php echo $index; ?>')" id="fund_paid_flag<?php echo round($index); ?>" class="btn btn-info">Post</button>
                    <button type="button" onclick="returnSkip('#to_be_paid<?php echo $index; ?>','<?php echo round($rows['to_be_paid']); ?>','<?php echo $index; ?>')" id="fund_paid_flag_skip<?php echo round($index); ?>" class="btn btn-danger" disabled>Skip</button>
                </td>
            </tr>
        <?php
        $index++;
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