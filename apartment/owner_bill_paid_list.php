<?php
require "../auth/auth.php";
// $owner = $_SESSION['gl_acc_code']='202011300000';
$owner_id = $_SESSION['link_id'];
require "../database.php";
require "../source/top.php";
// $pid= 1002000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
if (empty($owner_id)) {
    $sql2 = "SELECT  apart_owner_info.id, apart_owner_info.owner_name, apart_owner_info.gl_acc_code, tran_details.gl_acc_code FROM  apart_owner_info, tran_details where apart_owner_info.gl_acc_code = tran_details.gl_acc_code ORDER BY apart_owner_info.gl_acc_code";
} else {
    $sql2 = "SELECT  apart_owner_info.id, apart_owner_info.owner_name, apart_owner_info.gl_acc_code, tran_details.gl_acc_code FROM  apart_owner_info, Tran_details where apart_owner_info.gl_acc_code = '$owner_id' ORDER BY apart_owner_info.gl_acc_code";
}
$query2 = $conn->query($sql2);
$row = $query2->fetch_assoc();
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Owner Bill Paid List</h1>
        </div>
    </div>
    <!-- search option -->

    <?php if (empty($owner_id)) {
    ?>
        <table id="submit">
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
                    <td> As on date: <input type="date" name="startdate" id="" class="form-control" required></td>
                    <td> From: <input type="date" name="enddate" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    } elseif (!empty($owner_id)) { ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td> As on date: <input type="date" name="start" id="" class="form-control" required></td>
                    <td> From: <input type="date" name="end" id="" class="form-control" required></td>
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
                                                        if (empty($owner_id)) {
                                                            echo "All Owner";
                                                        } else {
                                                            echo $row['owner_name'];
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
                    <th>Bill Paid Date</th>
                    <th>Bill for Month</th>
                    <th>Voucher No</th>
                    <th>Owner Name</th>
                    <th>Flat Number</th>
                    <th>Service Name</th>
                    <th>Bill amount</th>
                    <th>Bill Paid Amount</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $d = 0;
                $no = 1;
                $owner_id = 0;
                $tot_cr_amt =0.00;
                $tot_dr_amt=0.00;
            
                 if (isset($_POST['submit'])) {
                   $startdate = $_POST['startdate'];
                   $enddate = $conn->escape_string($_POST['enddate']);
                   $gl_acc_code = $conn->escape_string($_POST['gl_acc_code']);

                   $sql="SELECT tran_details.batch_no,tran_details.tran_date, date_format(apart_owner_bill_detail.bill_date, '%M %Y') as month, tran_details.gl_acc_code, tran_details.cr_amt_loc,tran_details.cr_amt_loc, apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_paid_flag,  apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.bill_amount, apart_owner_bill_detail.flat_no, apart_owner_info.gl_acc_code, apart_owner_info.owner_name from apart_owner_bill_detail, tran_details,apart_owner_info where tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and apart_owner_bill_detail.owner_gl_code='$gl_acc_code'and  tran_details.vaucher_type='CR' and apart_owner_info.gl_acc_code=tran_details.gl_acc_code and tran_details.tran_date=apart_owner_bill_detail.bill_paid_date and apart_owner_bill_detail.bill_paid_flag='1' and tran_details.batch_no=apart_owner_bill_detail.batch_no  AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')";

                 } elseif (!empty($owner_id)) {
                  if (isset($_POST['induvidul'])) {

                            $start = $_POST['start'];
                            $end = $conn->escape_string($_POST['end']);
                           
                            $sql="SELECT tran_details.batch_no,tran_details.tran_date, date_format(apart_owner_bill_detail.bill_date, '%M %Y') as month, tran_details.gl_acc_code, tran_details.cr_amt_loc,tran_details.cr_amt_loc,  apart_owner_bill_detail.flat_no, apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_paid_flag,  apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.bill_amount, apart_owner_info.gl_acc_code, apart_owner_info.owner_name from apart_owner_bill_detail, tran_details,apart_owner_info where tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and apart_owner_bill_detail.owner_id='$owner_id' and  tran_details.vaucher_type='CR' and tran_details.tran_date=apart_owner_bill_detail.bill_paid_date and apart_owner_info.gl_acc_code=tran_details.gl_acc_code and apart_owner_bill_detail.bill_paid_flag='1' and tran_details.batch_no=apart_owner_bill_detail.batch_no AND (tran_details.tran_date BETWEEN '$start' AND '$end') ";   
                         
                } else {

                    $sql="SELECT tran_details.batch_no,tran_details.tran_date, date_format(apart_owner_bill_detail.bill_date, '%M %Y') as month, tran_details.gl_acc_code, tran_details.cr_amt_loc,tran_details.cr_amt_loc, apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_paid_flag,  apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.bill_amount, apart_owner_bill_detail.flat_no, apart_owner_info.gl_acc_code, apart_owner_info.owner_name from apart_owner_bill_detail, tran_details,apart_owner_info where tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and apart_owner_bill_detail.owner_id='$owner_id'and  tran_details.vaucher_type='CR' and apart_owner_info.gl_acc_code=tran_details.gl_acc_code and tran_details.tran_date=apart_owner_bill_detail.bill_paid_date and apart_owner_bill_detail.bill_paid_flag='1' and tran_details.batch_no=apart_owner_bill_detail.batch_no
                    ";

                   
                  }
                 } else {   
                     
                    $sql="SELECT tran_details.batch_no,tran_details.tran_date, date_format(apart_owner_bill_detail.bill_date, '%M %Y') as month, tran_details.gl_acc_code, tran_details.cr_amt_loc,tran_details.cr_amt_loc, apart_owner_bill_detail.flat_no, apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_paid_flag,  apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.bill_amount, apart_owner_info.gl_acc_code, apart_owner_info.owner_name from apart_owner_bill_detail, tran_details,apart_owner_info where tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and tran_details.vaucher_type='CR' and apart_owner_info.gl_acc_code=tran_details.gl_acc_code and tran_details.tran_date=apart_owner_bill_detail.bill_paid_date and apart_owner_bill_detail.bill_paid_flag='1' and tran_details.batch_no=apart_owner_bill_detail.batch_no";

                 }

                $query = $conn->query($sql);
                while ($rows = $query->fetch_assoc()) {
                ?>
                 <tr>
                      <td style="text-align: right"><?php if ($rows['owner_id'] != $owner_id) {
                                                            echo $no++; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                       <td style="text-align: center"><?php if ($rows['owner_id'] != $owner_id) {
                                                            echo $rows['tran_date']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                     
                     <td style="text-align: center"><?php if ($rows['owner_id'] != $owner_id) {
                                                            echo $rows['month']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>
                        <td style="text-align: center"><?php if ($rows['owner_id'] != $owner_id) {
                                                            echo $rows['batch_no']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>
                    
                     <td style="text-align: center"><?php if ($rows['owner_id'] != $owner_id) {
                                                            echo $rows['owner_name']; 
                                                        } else {
                                                            echo "";
                                                        }?></td> 
                                                        
                      <td style="text-align: center"><?php echo $rows['flat_no']; ?></td>   
                                                        
                     
                                                     
                      <td style="background-color:powderblue; text-align: left"><?php if  ($rows['bill_paid_flag'] =='1') {
                                                                  echo $rows['bill_charge_name']; echo "  (Bill paid)";
                                                             } else {
                                                               echo $rows['bill_charge_name']; 
                                                        }?></td>
                                                        
                                                                    
                     
                     <td style="background-color:powderblue; text-align: right"><?php echo $rows['bill_amount']; ?></td>
                     
                     <td style="text-align: right"><?php if ($rows['owner_id'] != $owner_id) {
                                                            echo $rows['cr_amt_loc']; 
                                                            $tot_cr_amt = $tot_cr_amt + $rows['cr_amt_loc'];
                                                            $owner_id = $rows['owner_id'];
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                              
                 </tr>
                 
                <?php } ?>
            <tfoot>
            <tr style="background-color:powderblue";>
                    <th style="text-align:right" colspan="7"> Total Amount in TK.</th>
                    <th style="text-align:right" colspan="1"><?php echo $tot_cr_amt; ?></th>
                    <th style="text-align:right" colspan="1"><?php echo ($tot_cr_amt - $tot_dr_amt); ?></th>  
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
        $("#1309000").addClass('active');
        $("#1300000").addClass('active');
        $("#1300000").addClass('is-expanded');
    });
</script>
</body>

</html>