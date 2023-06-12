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
    $sql2 = "SELECT  fund_member.member_id, fund_member.full_name,fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.gl_acc_code = gl_acc_code.acc_code ORDER BY fund_member.member_id";
} else {
    $sql2 = "SELECT  fund_member.member_id, fund_member.full_name,fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.member_id = '$member_id' ORDER BY fund_member.member_id ";
}
$query2 = $conn->query($sql2);
$row = $query2->fetch_assoc();
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Fund Due List</h1>
        </div>
    </div>
    <!-- search option -->

    <?php if (empty($member_id)) {
    ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td>Member  : <select class="form-control grand" name="gl_acc_code">
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
                    <td> date From: <input type="date" name="startdate" id="" class="form-control" required></td>
                    <td> TO: <input type="date" name="enddate" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php  
    
    } elseif (!empty($member_id)) { ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td> Date From: <input type="date" name="start" id="" class="form-control" required></td>
                    <td> To: <input type="date" name="end" id="" class="form-control" required></td>
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
                
                    <th >Sl.NO.</th>
                    <th>Donner Name</th>
                    <th>Fund Name</th>
                    <th>Per Donation Amt.</th>
                    <th>No. of Paid</th>
                    <th>Paid Amount</th>
                    <th>No. of Pay Due</th>
                    <th>Due Amount</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $d = 0;
                $no = 1;
                $mem_id = 0;
                $tot_pay_amt =0.00;
                $tot_paid_amt=0.00;
                $tot_due_amt=0.00;
            
                 if (isset($_POST['submit'])) {
                   $startdate = $_POST['startdate'];
                   $enddate = $conn->escape_string($_POST['enddate']);
                   $gl_acc_code = $conn->escape_string($_POST['gl_acc_code']);


                   $sql="SELECT  donner_fund_detail.fund_type, donner_fund_detail.member_id,donner_fund_detail.fund_type_desc,donner_fund_detail.num_of_pay,donner_fund_detail.donner_pay_amt,donner_fund_detail.num_of_paid,donner_fund_detail.donner_paid_amt, fund_member.member_id,fund_member.gl_acc_code, fund_member.full_name FROM  `donner_fund_detail`,fund_member where fund_member.member_id = donner_fund_detail.member_id and fund_member.gl_acc_code='$gl_acc_code'  and (donner_fund_detail.effect_date between '$startdate' and '$enddate')";

                } elseif (!empty($member_id)) {
                 if (isset($_POST['induvidul'])) {

                           $start = $_POST['start'];
                           $end = $conn->escape_string($_POST['end']);

                          
                           $sql="SELECT  donner_fund_detail.fund_type, donner_fund_detail.member_id,donner_fund_detail.fund_type_desc,donner_fund_detail.num_of_pay,donner_fund_detail.donner_pay_amt,donner_fund_detail.num_of_paid,donner_fund_detail.donner_paid_amt, fund_member.member_id,fund_member.gl_acc_code, fund_member.full_name FROM  `donner_fund_detail`,fund_member where fund_member.member_id = donner_fund_detail.member_id and fud_member.gl_acc_code='$gl_acc_code' and (donner_fund_detail.effect_date between '$start' and '$end')";   
                        
               } else {
                   
                   $sql="SELECT  donner_fund_detail.fund_type, donner_fund_detail.member_id,donner_fund_detail.fund_type_desc,donner_fund_detail.num_of_pay,donner_fund_detail.donner_pay_amt,donner_fund_detail.num_of_paid,donner_fund_detail.donner_paid_amt, fund_member.member_id,fund_member.gl_acc_code, fund_member.full_name FROM  `donner_fund_detail`,fund_member where fund_member.member_id = donner_fund_detail.member_id and donner_fund_detail.member_id='$member_id'";

                  
                 }
                } else {   
                    
                   $sql="SELECT  donner_fund_detail.fund_type, donner_fund_detail.member_id,donner_fund_detail.fund_type_desc,donner_fund_detail.num_of_pay,donner_fund_detail.donner_pay_amt,donner_fund_detail.num_of_paid,donner_fund_detail.donner_paid_amt, fund_member.member_id,fund_member.gl_acc_code, fund_member.full_name FROM  `donner_fund_detail`,fund_member where fund_member.member_id=donner_fund_detail.member_id order by donner_fund_detail.member_id,donner_fund_detail.fund_type;";

                }

               $query = $conn->query($sql);
               while ($rows = $query->fetch_assoc()) {
               ?>
                <tr>
                     <td style="text-align: right"><?php if ($rows['member_id'] != $mem_id) {
                                                           echo $no++; 
                                                       } else {
                                                           echo "";
                                                       }?></td>  

                     
                   
                    <td style="text-align: center"><?php if ($rows['member_id'] != $mem_id) {
                                                           echo $rows['full_name']; 
                                                           $mem_id = $rows['member_id'];
                                                       } else {
                                                           echo "";
                                                       }?></td>  
                   
                        <td style="background-color:powderblue; text-align: right"><?php echo $rows['fund_type_desc']; ?></td>       
                        <td style="background-color:powderblue; text-align: right"><?php $tot_pay_amt = $tot_pay_amt + $rows['donner_pay_amt']; echo $rows['donner_pay_amt'];?></td>                                                                 
                        <td style="background-color:lightgray; text-align: right"><?php echo $rows['num_of_paid']; ?></td>  
                        <td style="background-color:lightgray; text-align: right"><?php $tot_paid_amt = $tot_paid_amt + $rows['donner_paid_amt']; echo $rows['donner_paid_amt']; ?></td>   
                        <td style="background-color:white; text-align: right"><?php $due_num_of_pay = $rows['num_of_pay'] - $rows['num_of_paid'];echo $due_num_of_pay; ?></td>  
                        <td style="background-color:white; text-align: right"><?php $due_amt = ($rows['donner_pay_amt'] * $due_num_of_pay); $tot_due_amt = $tot_due_amt + $due_amt; echo $due_amt; ?></td>                                                                        
                         
                             
                </tr>
                
               <?php } ?>
            <tfoot>
            <tr style="background-color:powderblue";>
                    <th style="text-align:right" colspan="5"> Total Amount in TK.</th>
                    <!-- <th style="text-align:right" colspan="1"><?php echo $tot_pay_amt; ?></th> -->
                    <th style="text-align:right" colspan="1"><?php echo $tot_paid_amt; ?></th>
                    <th style="text-align:right" colspan="2"><?php echo $tot_due_amt; ?></th>  
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
        $("#905000").addClass('active');
        $("#900000").addClass('active');
        $("#900000").addClass('is-expanded');
    });
</script>
</body>

</html>