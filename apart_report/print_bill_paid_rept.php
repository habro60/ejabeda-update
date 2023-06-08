<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";
if (empty($owner_id)) {
    $sql2 = "SELECT  apart_owner_info.id, apart_owner_info.owner_name, apart_owner_info.gl_acc_code, gl_acc_code.acc_code FROM  apart_owner_info, gl_acc_code where apart_owner_info.gl_acc_code = gl_acc_code.acc_code ORDER BY apart_owner_info.gl_acc_code";
} else {
    $sql2 = "SELECT  apart_owner_info.id, apart_owner_info.owner_name, apart_owner_info.gl_acc_code, gl_acc_code.acc_code FROM  apart_owner_info, gl_acc_code where apart_owner_info.owner_id = '$owner_id' and apart_owner_info.gl_acc_code=gl_acc_code.acc_code  ORDER BY apart_owner_info.gl_acc_code";
}

$role_no     = 99; // admin 99 superadmin 100
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100

$org_rep_footer1      = $_SESSION['org_rep_footer1'];
$org_rep_footer2      = $_SESSION['org_rep_footer2'];
$org_rep_footer3      = $_SESSION['org_rep_footer3'];
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Bill Paid Report</h1>


        </div>
        <div class="pull-right">
            <!--<a id="Print" class="btn btn-danger print"></i>Print</a>-->
            <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="POST">
                <?php if (empty($owner_id)) {
                ?>
                    <table id="form_class_id" id="submit">
                        <form method="POST">
                            <tr>
                                <td>Owner : <select class="form-control grand" name="gl_acc_code">
                                        <option value="">--- Select Owner ---</option>
                                        <?php
                                        $selectQuery = "SELECT * FROM `gl_acc_code` where  subsidiary_group_code='800' and postable_acc= 'Y' ORDER by acc_code";
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
                } elseif (!empty($owner_id)) { ?>
                    <table id="submit">
                        <form method="POST">
                            <tr>
                                <td>
                                <td> <input type="text" name="owner_name" id="" class="form-control" value="<?php echo $row['owner_name']; ?>" readonly></td>
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
                <p style="text-align:center"> <?php echo $org_addr1;
                                                echo ",<br> ";
                                                echo  "E-Mail:";
                                                echo $org_email;
                                                echo ", ";
                                                echo "Tele:";
                                                echo $org_tel; ?></p>
            </div>

            <div id="reporttitle">
                <h6 style="text-align:center" id="reportTitle">Bill Paid Report</h6>
            </div>


            <div id="AsOnDate">
                <p style="text-align:center; font-weight:bold"><?php echo "From:";
                                                                echo date('d-m-Y ', strtotime($startdate)); ?> To <?php echo date('d-m-Y ', strtotime($enddate)); ?>



                </p>
            </div>




            <!-- report view option -->
           
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
                    $sql = "SELECT apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_charge_code,apart_owner_bill_detail.bill_charge_name,apart_owner_bill_detail.bill_for_month, apart_owner_bill_detail.bill_amount, apart_owner_bill_detail.flat_no,apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.bill_paid_flag, tran_details.tran_date, tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.batch_no, apart_owner_info.owner_id,apart_owner_info.owner_name from apart_owner_bill_detail, tran_details, apart_owner_info where tran_details.vaucher_type='CR' and tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and apart_owner_info.owner_id=apart_owner_bill_detail.owner_id  and apart_owner_bill_detail.batch_no=tran_details.batch_no and apart_owner_bill_detail.bill_paid_flag='1' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')and apart_owner_bill_detail.bill_amount > '0' order by apart_owner_bill_detail.flat_no,apart_owner_bill_detail.bill_for_month,apart_owner_bill_detail.bill_charge_code";
                } else {

                    $sql = "SELECT tran_details.batch_no,tran_details.tran_date,apart_owner_bill_detail.bill_for_month, tran_details.gl_acc_code, tran_details.dr_amt_loc,tran_details.cr_amt_loc, apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_paid_flag, apart_owner_bill_detail.bill_charge_code, apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.bill_amount,apart_owner_bill_detail.flat_no, apart_owner_info.gl_acc_code, apart_owner_info.owner_name from apart_owner_bill_detail, tran_details,apart_owner_info where tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and apart_owner_bill_detail.owner_gl_code='$gl_acc_code'and  tran_details.vaucher_type='CR' and apart_owner_info.gl_acc_code=tran_details.gl_acc_code and tran_details.tran_date=apart_owner_bill_detail.bill_paid_date and apart_owner_bill_detail.batch_no=tran_details.batch_no and apart_owner_bill_detail.bill_paid_flag='1'  AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and apart_owner_bill_detail.bill_amount > '0' order by apart_owner_bill_detail.flat_no,apart_owner_bill_detail.bill_for_month, apart_owner_bill_detail.bill_charge_code";
                }
                $query = $conn->query($sql);
            ?>
                <div id="mySelector">
                    <table style="margin:20px;border: 1px solid #808080;border-collapse: collapse;margin-top:30px; text-align:center;" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">

                            <th style="text-align:center;width:5%;border: 1px solid #808080;border-collapse: collapse;padding:2px;">Sl.NO.</th>
                            <th style="text-align:center;width:10%;border: 1px solid #808080;border-collapse: collapse;padding:2px;">Shop/Flat No.</th>
                            <th style="text-align:center;width:20%;border: 1px solid #808080;border-collapse: collapse;padding:2px;">Shop/Owner Name</th>
                            <th style="text-align:center;width:20%;border: 1px solid #808080;border-collapse: collapse;padding:2px;">Bill Received Date</th>
                            <th style="text-align:center;width:5%;border: 1px solid #808080;border-collapse: collapse;padding:2px;">Voucher No</th>
                            <th style="text-align:center;width:10%;border: 1px solid #808080;border-collapse: collapse;padding:2px;">Bill for Month</th>
                            <th style="text-align:center;width:25%;border: 1px solid #808080;border-collapse: collapse;padding:2px;">Service Name</th>
                            <th style="text-align:center;width:15%;border: 1px solid #808080;border-collapse: collapse;padding:5px;">Bill amount</th>
                            <th style="text-align:center;width:20%;border: 1px solid #808080;border-collapse: collapse;padding:5px;">Bill Paid Amount</th>

                        </thead>

                        <body>

                            <?php
                            while ($rows = $query->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td style="text-align:center;width:5%;border: 1px solid #808080;border-collapse: collapse;padding:5px;"><?php if ($rows['batch_no'] != $batch_no) {
                                                                                                                                                echo $no++;
                                                                                                                                            } else {
                                                                                                                                                echo "";
                                                                                                                                            } ?></td>
                                    <td style="text-align:center;width:5%;border: 1px solid #808080;border-collapse: collapse;padding:5px;"><?php if ($rows['batch_no'] != $batch_no) {
                                                                                                                                                echo $rows['flat_no'];
                                                                                                                                            } else {
                                                                                                                                                echo "";
                                                                                                                                            } ?></td>
                                    <td style="text-align:center;width:5%;border: 1px solid #808080;border-collapse: collapse;padding:5px;"><?php if ($rows['batch_no'] != $batch_no) {
                                                                                                                                                echo $rows['owner_name'];
                                                                                                                                            } else {
                                                                                                                                                echo "";
                                                                                                                                            } ?></td>
                                    <td style="text-align:center;width:5%;border: 1px solid #808080;border-collapse: collapse;padding:5px;"><?php if ($rows['batch_no'] != $batch_no) {
                                                                                                                                                echo date('d-m-Y ', strtotime($rows['tran_date']));
                                                                                                                                            } else {
                                                                                                                                                echo "";
                                                                                                                                            } ?></td>


                                    <td style="text-align:center;width:5%;border: 1px solid #808080;border-collapse: collapse;padding:5px;"><?php if ($rows['batch_no'] != $batch_no) {
                                                                                                                                                echo $rows['batch_no'];
                                                                                                                                            } else {
                                                                                                                                                echo "";
                                                                                                                                            } ?></td>



                                    <td style="text-align:center;width:5%;border: 1px solid #808080;border-collapse: collapse;padding:5px;"><?php echo
                                                                                                                                            date('M Y ', strtotime($rows['bill_for_month']));
                                                                                                                                            ?></td>
                                    <td style="text-align:center;width:5%;border: 1px solid #808080;border-collapse: collapse;padding:5px;"><?php if ($rows['bill_paid_flag'] == '0') {
                                                                                                                                                echo $rows['bill_charge_name'];
                                                                                                                                                echo "  (Due Bill)";
                                                                                                                                            } else {
                                                                                                                                                echo $rows['bill_charge_name'];
                                                                                                                                            } ?></td>



                                    <td style="text-align:right;width:5%;border: 1px solid #808080;border-collapse: collapse;padding:5px;"><?php echo number_format($rows['bill_amount'], 2, '.', ','); ?></td>



                                    <td style="text-align:right;width:5%;border: 1px solid #808080;border-collapse: collapse;padding:5px;"><?php echo number_format($rows['bill_amount'], 2, '.', ',');
                                                                                                                                            $tot_dr_amt = $tot_dr_amt + $rows['bill_amount'];
                                                                                                                                            $batch_no = $rows['batch_no'];
                                                                                                                                            ?></td>

                                </tr>
                        <?php
                            }
                        }
                        ?>
                        </body>
                        <tfoot>
                            <tr style="background-color:powderblue" ;>
                                <th style="text-align:right;border: 1px solid #808080;" colspan="7"> Total Amount In TK.=</th>
                                <th style="text-align:right;border: 1px solid #808080;" colspan="1"><?php echo number_format($tot_dr_amt, 2, '.', ','); ?></th>
                                <th style="text-align:right;border: 1px solid #808080;" colspan="1"><?php echo  number_format(($tot_dr_amt - $tot_cr_amt), 2, '.', ','); ?></th>
                            </tr>
                        </tfoot>

                    </table>
                    <table style="margin-top: 20px;">
                        <tr>
                            <th style="text-align:center;width:25%;padding: 100px;;" colspan="2"><label>--------------------</label> <?php echo "Checked By"; ?></th>
                            <th style="text-align:center;width:25%;padding: 100px;" colspan="2"><label>--------------------</label><?php echo "Authorized By"; ?></th>
                            <th style="text-align:center;width:25%;padding:100px;" colspan="4"><label>--------------------</label></br><?php  echo "Verified By"; ?></th>
                        </tr>
                    </table>






                    <!-- <div style='padding:80px'>
                        <div style='float:left;text-align:left;'><label>--------------------</label><br><?php echo "Checked By"; ?></div>

                        <div style='float:center;text-align:center;'><label>--------------------</label><br><?php echo "Authorized By"; ?></div>

                        <div style='float:right;text-align:right;'><label>--------------------------</label><br><?php echo "Verified By"; ?></div>
                    </div>
                </div> -->
                </div>

                <?php $today = date('d-m-Y'); ?>

                <div style='padding:40px;'>
                    <span><b>Prepared By:</b> <?php echo $_SESSION['username']; ?> </span>
                    <span><b>Date:</b> <?php echo $today; ?> </span>
                </div>
        </div>
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
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>
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
            $("#form_class_id").hide();
        });
    });
</script>

</body>

</html>