<?php
require "../auth/auth.php";
// $owner = $_SESSION['gl_acc_code']='202011300000';
$member_id = $_SESSION['link_id'];
require "../database.php";
require "../source/top.php";
// $pid= 1002000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
if (empty($member_id)) {
    $sql2 = "SELECT  fund_member.member_id, fund_member.full_name,fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.gl_acc_code = gl_acc_code.acc_code ORDER BY fund_member.member_id ";
} else {
    $sql2 =  "SELECT  fund_member.member_id, fund_member.full_name,fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.member_id = '$member_id' ORDER BY fund_member.member_id ";
}
$query2 = $conn->query($sql2);
$row = $query2->fetch_assoc();
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Fund Paid List</h1>
        </div>
    </div>
    <!-- search option -->

    <?php if (empty($member_id)) {
    ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td>Owner : <select class="form-control grand" name="gl_acc_code">
                            <option value="">--- Select Donner ---</option>
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
                    <td> As on date: <input type="date" name="enddate" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    } elseif (!empty($member_id)) { ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td> As on date: <input type="date" name="start" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="induvidul" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    } ?>
    <!-- !search option -->
    <!-- report header start -->
    <?php
    $org_logo = $_SESSION['org_logo'];
    $org_name = $_SESSION['org_name'];
    ?>
    <div>
        <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
        <h3 style="text-align:center">Owner Name : <?php
                                                        if (empty($member_id)) {
                                                            echo "All Member";
                                                        } else {
                                                            echo $row['full_name'];
                                                        } ?></h3>
    </div>
    <!-- report header end -->
    <!-- search option -->
    <div class="table-responsive-lg">
        <table border="1" style="width: 100%;margin-top:10px">
            <thead>
            <tr style="background-color:powderblue; text-align: center";>
                    <!-- <th style="width:2%">Sl.NO.</th> -->
                    <th >Sl.NO.</th>
                    <th>Tran Date</th>
                    <th>Voucher No.</th>
                    <th>Member Number</th>
                    <th>Member Name</th>
                    <th>Fund Name</th>
                    <th>Strat From</th>
                    <th>Paid Upto </th>
                    <th>Paid Amount</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $d = 0;
                $no = 1;
                $batch_no = 0;
                $tot_cr_amt =0.00;
                $tot_dr_amt=0.00;
            
                 if (isset($_POST['submit'])) {
                   $enddate = $conn->escape_string($_POST['enddate']);
                   $gl_acc_code = $conn->escape_string($_POST['gl_acc_code']);

                   $sql="SELECT  fund_receive_detail.office_code,fund_receive_detail.member_id,fund_receive_detail.batch_no,fund_receive_detail.paid_date,fund_receive_detail.fund_type, fund_receive_detail.paid_amount, tran_details.batch_no,tran_details.tran_date,tran_details.gl_acc_code, tran_details.cr_amt_loc, fund_member.member_no, fund_member.full_name, donner_fund_detail.fund_type_desc,  donner_fund_detail.effect_date,donner_fund_detail.last_paid_date,donner_fund_detail.num_of_pay,donner_fund_detail.donner_pay_amt from fund_receive_detail, tran_details, fund_member, donner_fund_detail where tran_details.batch_no=fund_receive_detail.batch_no and tran_details.gl_acc_code=fund_receive_detail.gl_acc_code and fund_receive_detail.member_id=fund_member.member_id and donner_fund_detail.member_id=fund_receive_detail.member_id and donner_fund_detail.fund_type=fund_receive_detail.fund_type and fund_receive_detail.gl_acc_code = '$gl_acc_code'and (fund_receive_detail.paid_date between '$enddate' and '$enddate')";

                 } elseif (!empty($member_id)) {
                  if (isset($_POST['induvidul'])) {

                            $start = $_POST['start'];
                            $end = $conn->escape_string($_POST['end']);
                           
                            $sql="SELECT  fund_receive_detail.office_code,fund_receive_detail.member_id,fund_receive_detail.batch_no,fund_receive_detail.paid_date,fund_receive_detail.fund_type, fund_receive_detail.paid_amount, tran_details.batch_no,tran_details.tran_date,tran_details.gl_acc_code, tran_details.cr_amt_loc,  fund_member.member_no, fund_member.full_name, donner_fund_detail.fund_type_desc,  donner_fund_detail.effect_date,donner_fund_detail.last_paid_date,donner_fund_detail.donner_pay_amt from fund_receive_detail, tran_details, fund_member, donner_fund_detail where tran_details.batch_no=fund_receive_detail.batch_no and tran_details.gl_acc_code=fund_receive_detail.gl_acc_code and fund_receive_detail.member_id=fund_member.member_id and donner_fund_detail.member_id=fund_receive_detail.member_id and donner_fund_detail.fund_type=fund_receive_detail.fund_type and fund_receive_detail.member_id = '$member_id'and (fund_receive_detail.paid_date between '$start' and '$end')";  
                         
                } else {

                    $sql="SELECT  fund_receive_detail.office_code,fund_receive_detail.member_id,fund_receive_detail.batch_no,fund_receive_detail.paid_date,fund_receive_detail.fund_type, fund_receive_detail.paid_amount, tran_details.batch_no,tran_details.tran_date,tran_details.gl_acc_code, tran_details.cr_amt_loc,  fund_member.member_no, fund_member.full_name, donner_fund_detail.fund_type_desc, donner_fund_detail.effect_date,donner_fund_detail.last_paid_date, donner_fund_detail.last_paid_date,donner_fund_detail.donner_pay_amt from fund_receive_detail, tran_details, fund_member, donner_fund_detail where tran_details.batch_no=fund_receive_detail.batch_no and tran_details.gl_acc_code=fund_receive_detail.gl_acc_code and fund_receive_detail.member_id=fund_member.member_id and donner_fund_detail.member_id=fund_receive_detail.member_id and donner_fund_detail.fund_type=fund_receive_detail.fund_type and fund_receive_detail.member_id = '$member_id'";

                   
                  }
                 } else {   
                     
                    $sql="SELECT  fund_receive_detail.office_code,fund_receive_detail.member_id,fund_receive_detail.batch_no,fund_receive_detail.paid_date,fund_receive_detail.fund_type, fund_receive_detail.paid_amount, tran_details.batch_no,tran_details.tran_date,tran_details.gl_acc_code, tran_details.cr_amt_loc,  fund_member.member_no, fund_member.full_name, donner_fund_detail.fund_type_desc, donner_fund_detail.effect_date,donner_fund_detail.last_paid_date,donner_fund_detail.donner_pay_amt from fund_receive_detail, tran_details, fund_member, donner_fund_detail where tran_details.batch_no=fund_receive_detail.batch_no and tran_details.gl_acc_code=fund_receive_detail.gl_acc_code and fund_receive_detail.member_id=fund_member.member_id and donner_fund_detail.member_id=fund_receive_detail.member_id and donner_fund_detail.fund_type=fund_receive_detail.fund_type ";

                 }

                $query = $conn->query($sql);
                while ($rows = $query->fetch_assoc()) {
                ?>
                 <tr>
                      <td style="text-align: right"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $no++; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                       <td style="text-align: center"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $rows['tran_date']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                     
                     
                        <td style="text-align: center"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $rows['batch_no']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>
                      <td style="text-align: center"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $rows['member_no']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                                  
                    
                     <td style="text-align: center"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $rows['full_name']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                          <td style="background-color:powderblue; text-align: right"><?php echo $rows['fund_type_desc']; ?></td>
                          <td style="background-color:powderblue; text-align: right"><?php echo $rows['effect_date']; ?></td>    
                         <td style="background-color:powderblue; text-align: right"><?php echo $rows['last_paid_date']; ?></td>                                        
                                                                                                    
                         <td style="text-align: right"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $rows['paid_amount']; 
                                                            $tot_cr_amt = $tot_cr_amt + $rows['cr_amt_loc'];
                                                            $batch_no = $rows['batch_no'];
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                              
                 </tr>
                 
                <?php } ?>
            <tfoot>
            <tr style="background-color:powderblue";>
                    <th style="text-align:right" colspan="8"> Total Amount in TK.</th>
                    <th style="text-align:right" colspan="1"><?php echo $tot_cr_amt; ?></th>
                </tr>
            </tfoot>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
    <!-- table -->
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>

<script type="text/javascript">
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
    $(document).ready(function() {
        $("#904000").addClass('active');
        $("#900000").addClass('active');
        $("#900000").addClass('is-expanded');
    });
</script>
</body>

</html>