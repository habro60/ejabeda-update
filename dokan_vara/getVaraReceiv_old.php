<?php
require "../auth/auth.php";
require '../database.php';
$output = '';
?>
<table class="table bg-light table-bordered table-sm table" id="bill_table">
    <thead>
        <tr style="background-color: powderblue">
            <th>Last Payment Date</th>
            <th>Vara Name</th>
            <th>Currency</th>
            <th>Vara amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $to_account = $_POST['to_account'];
        $bill_date = $_POST['bill_date'];
        

        $flat_no = "SELECT * FROM `flat_info` WHERE `dokan_vara_gl` = '$to_account'";
        $query2 = mysqli_query($conn, $flat_no);
        $rows2 = mysqli_fetch_assoc($query2);
        $last_flat_no=$rows2['flat_no'];;
       
        $total_bill = 0;
        $total_b = 0;
        if ($bill_date <= '2022-03-31')  {
            $fundsql="SELECT
            dokan_vara_detail.office_code,
            dokan_vara_detail.flat_no,
            dokan_vara_detail.`fund_type`,
            dokan_vara_detail.`fund_type_desc`,
            dokan_vara_detail.donner_pay_amt,
            dokan_vara_detail.num_of_pay,
            dokan_vara_detail.num_of_paid,
            dokan_vara_detail.last_paid_date,
            dokan_vara_detail.pay_curr,
            dokan_vara_detail.fund_paid_flag,
            flat_info.flat_no,
            flat_info.flat_title,
            flat_info.dokan_vara_gl,
            code_master.description,
             
            DATEDIFF('$bill_date', dokan_vara_detail.last_paid_date)  * dokan_vara_detail.donner_pay_amt  as tran_amt,  date_format(dokan_vara_detail.last_paid_date, '%m/%d/%Y') as ldate
            FROM
            dokan_vara_detail,
            flat_info, code_master
            where dokan_vara_detail.flat_no=flat_info.flat_no and  code_master.hardcode='CURT' and dokan_vara_detail.pay_curr=code_master.softcode and flat_info.dokan_vara_gl='$to_account'";
             
            } else  {
                if ($last_flat_no <= '20210300'){

                    $fundsql="SELECT 
                    dokan_vara_detail.office_code,
                    dokan_vara_detail.flat_no,
                    dokan_vara_detail.`fund_type`,
                    dokan_vara_detail.`fund_type_desc`,
                    dokan_vara_detail.donner_pay_amt,
                    dokan_vara_detail.num_of_pay,
                    dokan_vara_detail.num_of_paid,
                    dokan_vara_detail.last_paid_date,
                    dokan_vara_detail.pay_curr,
                    dokan_vara_detail.fund_paid_flag,
                    flat_info.flat_no,
                    flat_info.flat_title,
                    flat_info.dokan_vara_gl,
                    code_master.description,
                    
                    DATEDIFF('$bill_date', dokan_vara_detail.last_paid_date)  * 300  as tran_amt,  date_format(dokan_vara_detail.last_paid_date, '%m/%d/%Y') as ldate
                    FROM
                    dokan_vara_detail,
                    flat_info, code_master
                    where dokan_vara_detail.flat_no=flat_info.flat_no and  code_master.hardcode='CURT' and dokan_vara_detail.pay_curr=code_master.softcode and flat_info.dokan_vara_gl='$to_account' ";


                } else {
                    $fundsql="SELECT
                    dokan_vara_detail.office_code,
                    dokan_vara_detail.flat_no,
                    dokan_vara_detail.`fund_type`,
                    dokan_vara_detail.`fund_type_desc`,
                    dokan_vara_detail.donner_pay_amt,
                    dokan_vara_detail.num_of_pay,
                    dokan_vara_detail.num_of_paid,
                    dokan_vara_detail.last_paid_date,
                    dokan_vara_detail.pay_curr,
                    dokan_vara_detail.fund_paid_flag,
                    flat_info.flat_no,
                    flat_info.flat_title,
                    flat_info.dokan_vara_gl,
                    code_master.description,
                     
                    DATEDIFF('$bill_date', dokan_vara_detail.last_paid_date)  * dokan_vara_detail.donner_pay_amt  as tran_amt,  date_format(dokan_vara_detail.last_paid_date, '%m/%d/%Y') as ldate
                    FROM
                    dokan_vara_detail,
                    flat_info, code_master
                    where dokan_vara_detail.flat_no=flat_info.flat_no and  code_master.hardcode='CURT' and dokan_vara_detail.pay_curr=code_master.softcode and flat_info.dokan_vara_gl='$to_account'";
                }

            }


// echo $fundsql;
// exit;
        $query = mysqli_query($conn, $fundsql);
        $rows_no = mysqli_num_rows($query);
        while ($rows = $query->fetch_assoc()) {
            $total_b =  $total_b + $rows['tran_amt'];
        ?>
            <tr>
                <td hidden>
                     
                    <input type="hidden" name="flat_no[]" class="form-control" value="<?php echo $rows['flat_no']; ?>" readonly>
                    <input type="hidden" name="from_date[]" class="form-control" value="<?php echo $rows['last_paid_date']; ?>" readonly>
                </td>
                <td hidden>
                    <input type="hidden" name="fund_type[]" class="form-control" value="<?php echo $rows['fund_type']; ?>" readonly>
                </td>
                <td hidden>
                    <input type="hidden" name="gl_acc_code[]" class="form-control" value="<?php echo $rows['dokan_vara_gl']; ?>" readonly>
                </td>
                <td>
                    <input type="text" name="from_date1[]" class="form-control" value="<?php echo $rows['ldate']; ?>" readonly>
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