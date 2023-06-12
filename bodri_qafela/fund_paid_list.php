<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";
if (empty($member_id)) {
    $sql2 = "SELECT  fund_member.member_id, fund_member.full_name,fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.gl_acc_code = gl_acc_code.acc_code ORDER BY fund_member.member_id ";
} else {
    $sql2 =  "SELECT  fund_member.member_id, fund_member.full_name,fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.member_id = '$member_id' ORDER BY fund_member.member_id ";
}
$role_no     = 99; // admin 99 superadmin 100
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100

$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Fund Paid List</h1>
        </div>
        <div class="pull-right">
                <!--<a id="Print" class="btn btn-danger print"></i>Print</a>-->
                <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
         </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="POST">
                <?php if (empty($member_id)) {
                ?>
                    <table class="form_class_id" id="submit">
                        <form method="POST">
                            <tr>
                                <td>member : <select class="form-control grand" name="gl_acc_code">
                                        <option value="">--- Select Member GL ---</option>
                                        <?php
                                        $selectQuery = "SELECT * FROM `gl_acc_code` where  subsidiary_group_code='400' and postable_acc= 'Y' ORDER by acc_code";
                                        $selectQueryResult =  $conn->query($selectQuery);
                                        if ($selectQueryResult->num_rows) {
                                            while ($drrow = $selectQueryResult->fetch_assoc()) {
                                                echo '<option value="' . $drrow['acc_code'] . '">'  . $drrow['acc_head'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select></td>
                                <td> From: <input type="date" name="startdate" id="" class="form-control" required></td>
                                <td> To: <input type="date" name="enddate" id="" class="form-control" required></td>
                                <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                            </tr>
                        </form>
                    </table>
                <?php
                } elseif (!empty($member_id)) { ?>
                    <table id="submit">
            <form method="POST">
                            <tr>
                                <td>
                                <td> <input type="text" name="full_name" id="" class="form-control" value="<?php echo $row['full_name']; ?>" readonly></td>
                                <td> From: <input type="date" name="startdate" id="" class="form-control" required></td>
                                <td> To: <input type="date" name="enddate" id="" class="form-control" required></td>
                                <td>
                                    <input type="submit" name="submit" id="submitBtn" class="btn btn-info" value="Report View">
                                </td>
                            </tr>
                            </tbody>
                    </table>
            </form>
            <!-- end filter option -->
        <?php
                } ?>
        <?php
        if (isset($_POST['submit'])) {

            // $officeId = $_SESSION['officeId'];
            $org_name    = $_SESSION['org_name'];
            $org_addr1 = $_SESSION['org_addr1'];
            $org_email = $_SESSION['org_email'];
            $org_tel = $_SESSION['org_tel'];
            $org_logo    = $_SESSION['org_logo'];
            $startdate = $_POST["startdate"];
            $enddate = $conn->escape_string($_POST["enddate"]);

        ?>
            <!-- report header -->
            <div>
    
    <h4 style="text-align:center; margin-top:60px;"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;margin-right:10px;"><?php echo $org_name; ?></h4>
</div>
<div id="organizationAdd">
                <p style="text-align:center"> <?php echo $org_addr1;echo ",<br> "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></p> 
         </div>
<div>
            <div id="reporttitle">
                 <h6 style="text-align:center" id="reportTitle"><b>Report Title :  </b>Fund paid Report</h6> 
            </div>
            <div id="AsOnDate">
                <p  style="text-align:center; font-weight:bold"><b>Date :  </b> <?php echo "From:"; echo date('d-m-Y ',strtotime($startdate)); ?> To <?php echo date('d-m-Y ',strtotime($enddate)); ?>
                
            
                
                </p> 
            </div>
        </div>                                                     
       
        <br>
            <?php
            $d = 0;
            $no = 1;
            $owner_id = 0;
            $batch_no = 0;
            $tot_cr_amt = 0.00;
            $tot_dr_amt = 0.00;

            if (isset($_POST['submit'])) {

                $startdate = $_POST['startdate'];
                $enddate = $conn->escape_string($_POST['enddate']);
                $gl_acc_code = $conn->escape_string($_POST['gl_acc_code']);
                if (empty($gl_acc_code)) {
                    $sql = "SELECT  fund_receive_detail.office_code,fund_receive_detail.member_id,fund_receive_detail.batch_no,fund_receive_detail.paid_date,fund_receive_detail.fund_type, fund_receive_detail.paid_amount,fund_receive_detail.due_amount,fund_receive_detail.waiver_amount, tran_details.batch_no,tran_details.tran_date,tran_details.gl_acc_code, tran_details.cr_amt_loc,  fund_member.full_name, donner_fund_detail.fund_type_desc, donner_fund_detail.num_of_pay,donner_fund_detail.donner_pay_amt,donner_fund_detail.num_of_paid from fund_receive_detail, tran_details, fund_member, donner_fund_detail where tran_details.batch_no=fund_receive_detail.batch_no and tran_details.gl_acc_code=fund_receive_detail.gl_acc_code and fund_receive_detail.member_id=fund_member.member_id and donner_fund_detail.member_id=fund_receive_detail.member_id and donner_fund_detail.fund_type=fund_receive_detail.fund_type ";

                    
                    $all_total_amount_sql = "SELECT SUM(donner_pay_amt) AS total_donner_pay_amt,SUM(donner_paid_amt) AS total_donner_paid_amt,SUM(due_amt) AS total_due_amount,Sum(waiver_amt) AS total_waiver_amt FROM `donner_fund_detail` WHERE allow_flag=1";
                } else {

                    $sql = "SELECT  fund_receive_detail.office_code,fund_receive_detail.member_id,fund_receive_detail.batch_no,fund_receive_detail.paid_date,fund_receive_detail.fund_type, fund_receive_detail.paid_amount,fund_receive_detail.due_amount,fund_receive_detail.waiver_amount, tran_details.batch_no,tran_details.tran_date,tran_details.gl_acc_code, tran_details.cr_amt_loc,  fund_member.full_name, donner_fund_detail.fund_type_desc, donner_fund_detail.num_of_pay,donner_fund_detail.donner_pay_amt,donner_fund_detail.num_of_paid from fund_receive_detail, tran_details, fund_member, donner_fund_detail where tran_details.batch_no=fund_receive_detail.batch_no and tran_details.gl_acc_code=fund_receive_detail.gl_acc_code and fund_receive_detail.member_id=fund_member.member_id and donner_fund_detail.member_id=fund_receive_detail.member_id and donner_fund_detail.fund_type=fund_receive_detail.fund_type and fund_receive_detail.gl_acc_code = '$gl_acc_code'and (fund_receive_detail.paid_date between '$startdate' and '$enddate')";

                    $all_total_amount_sql = "SELECT SUM(donner_pay_amt) AS total_donner_pay_amt,SUM(donner_paid_amt) AS total_donner_paid_amt,SUM(due_amt) AS total_due_amount,Sum(waiver_amt) AS total_waiver_amt FROM `donner_fund_detail` WHERE gl_acc_code='$gl_acc_code' AND allow_flag=1";
                }
                $query = $conn->query($sql);
                $query_all_total_amount_sql = $conn->query($all_total_amount_sql);

            ?>
                <div id="mySelector">
                <table class="table" style=" margin-right:30px; border-collapse: collapse;" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">

                            <th style="text-align:center;border: 1px solid black;">Sl.NO.</th>
                            <th style="text-align:center;border: 1px solid black;">Tran Date</th>
                            <th style="text-align:center;border: 1px solid black;">Voucher No.</th>
                            <th style="text-align:center;border: 1px solid black;">Donner Name</th>
                            <th style="text-align:center;border: 1px solid black;">Fund Name</th>
                            <th style="text-align:center;border: 1px solid black;">To be Pay</th>
                            <th style="text-align:center;border: 1px solid black;">Paid Amount</th>
                            <th style="text-align:center;border: 1px solid black;">Due Amount</th>
                            <th style="text-align:center;border: 1px solid black;">Waiver Amount</th>
                           
                        </thead>

                        <body>

                            <?php
                            $due_amount=0.0;
                            $waiver_amount=0.0;
                            $total_to_be_pay=0.0;
                            $total_paid_amt=0.0;
                            while ($rows = $query->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td style="text-align:center;border: 1px solid black;"><?php if ($rows['batch_no'] > $batch_no) {
                                                                        echo $no++;
                                                                    } else {
                                                                        echo "";
                                                                    } ?></td>

                                    <td style="text-align:left;border: 1px solid black;"><?php if ($rows['batch_no'] > $batch_no) {
                                                                        echo $rows['tran_date'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?></td>


                                    <td style="text-align:left;border: 1px solid black;"><?php if ($rows['batch_no'] > $batch_no) {
                                                                        echo $rows['batch_no'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?></td>

                                    <td style="text-align:left;border: 1px solid black;"><?php if ($rows['batch_no'] > $batch_no) {
                                                                        echo $rows['full_name'];
                                                                    } else {
                                                                        echo "";
                                                                    } ?></td>

                                    <td style="text-align:left;border: 1px solid black;"><?php echo $rows['fund_type_desc']; ?></td>

                                    <td style="text-align:right;border: 1px solid black;"><?php $total_to_be_pay=$total_to_be_pay+$rows['donner_pay_amt']; echo $rows['donner_pay_amt']; ?></td>

                                    <td style="text-align:right;border: 1px solid black;"><?php $total_paid_amt=$total_paid_amt+$rows['paid_amount']; echo $rows['paid_amount']; ?></td>

                                    <td style="text-align:right;border: 1px solid black;"><?php $due_amount=$due_amount+ $rows['due_amount']; echo $rows['due_amount']; ?></td>

                                    <td style="text-align:right;border: 1px solid black;"><?php $waiver_amount=$waiver_amount + $rows['waiver_amount']; echo $rows['waiver_amount']; ?></td>

                               

                                </tr>
                        <?php
                            }
                        }

                        $all_total = $query_all_total_amount_sql->fetch_array();
                        ?>

                        <tfoot>
                            <tr style="text-align:center; color:blue; font-weight: bold; font-size: 16px;border: 1px solid black;border-collapse: collapse;">
                                <th style="text-align:center;border: 1px solid black;" colspan="5"> Total   Amount in TK.</th>
                                <th style="text-align:center;border: 1px solid black;" colspan="1"><?php echo $total_to_be_pay ?></th>
                                <th style="text-align:center;border: 1px solid black;" colspan="1"><?php echo $total_paid_amt; ?></th>
                                <th style="text-align:center;border: 1px solid black;" colspan="1"><?php echo $due_amount; ?></th>
                                <th style="text-align:center;border: 1px solid black;" colspan="1"><?php echo $waiver_amount; ?></th>
                               
                               
                            </tr>
                           
                        </tfoot>
                        </body>

                    </table>

                    <div style='padding:80px'>
        <div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $q; ?></div>
    
        
        <div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $b;?></div></div>
                </div>
    </div>
    
    <?php $today = date('d-m-Y'); ?>
    
    <div style='padding:40px;'>
        <span><b>Prepared By:</b> <?php echo $_SESSION['username']; ?> </span>
        <span><b>Date:</b> <?php echo $today; ?> </span>
    </div>
                <?php
            } else {
                echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select From Date and To Date</h1>";
            }
                ?>

                </div>
        </div>
</main>
<?php
// require "report_footer.php";
?>
<!-- Essential javascripts for application to work-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.5.0/print.js"></script>
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<script src="../js/select2.full.min.js"></script>
<!--  -->
<script src="../js/custom.js"></script>
<!-- data table -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<!-- print this js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>
<!--  -->
<script>
    $(document).ready(function() {
       
        $("#print").click(function() {
            
           // alert('sdsd');
             $(".form_class_id").hide();
        });
    });
</script>
</body>

</html>