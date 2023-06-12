<?php
require "../auth/auth.php";
$owner_id = $_SESSION['link_id'];
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
$office_code = $_SESSION['office_code'];
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_no      = $_SESSION['org_no'];
require "../database.php";
require "../source/top.php";
// $pid= 1002000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
if (empty($owner_id)) {
    $sql2 = "SELECT  apart_owner_info.id, apart_owner_info.owner_name, apart_owner_info.gl_acc_code, gl_acc_code.acc_code FROM  apart_owner_info, gl_acc_code where apart_owner_info.gl_acc_code = gl_acc_code.acc_code ORDER BY apart_owner_info.gl_acc_code";
} else {
    $sql2 = "SELECT  apart_owner_info.id, apart_owner_info.owner_name, apart_owner_info.gl_acc_code, gl_acc_code.acc_code FROM  apart_owner_info, gl_acc_code where apart_owner_info.owner_id = '$owner_id' and apart_owner_info.gl_acc_code=gl_acc_code.acc_code  ORDER BY apart_owner_info.gl_acc_code";
}
$query2 = $conn->query($sql2);
$row = $query2->fetch_assoc();
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Owner Bill Due List</h1>
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
                    <td> <input type="text" name="owner_name" id="" class="form-control" value="<?php echo $row['owner_name']; ?>" readonly></td>
                    <td> From: <input type="date" name="startdate" id="" class="form-control" required></td>
                    <td> To: <input type="date" name="enddate" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="induvidul" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    } ?>
    
    <div class="row">
        <div class="col-md-12">
            <h3 style="text-align:center"> </h3>
            
            
            <?php
            if (isset($_POST['submit']) || isset($_POST['induvidul'])) {
                $startdate = $conn->escape_string($_POST["startdate"]);
                $enddate = $conn->escape_string($_POST["enddate"]);
                if (empty($owner_id)) {
                $gl_acc_code = $conn->escape_string($_POST['gl_acc_code']);
                }

                ?>
                
                <div class="row" style="margin-bottom: 5px">
                     <div class="col-12">
                        <div class="pull-right">
                            <a id='print' title="Print" class="btn btn-danger" target="_blank" href="owner_bill_due_list_print.php?edate=<?php echo $enddate;?>&sdate=<?php echo $startdate;?>&gl_acc_code=<?php echo $gl_acc_code; ?> "><i class="fa fa-print"></i>Print</a>
                        </div>
                     </div>
                </div>
                <div>
                
                    <h3 style="text-align:center">Owner Name : <?php
                                                                    if (empty($owner_id)) {
                                                                        echo "$gl_acc_code";
                                                                    } else { echo $row['owner_name'];} ?></h3>
                 <div>                                                   
                    <h4 style="text-align:center">From Date :<?php  echo "$startdate";  echo "  To Date :"; echo "$enddate"; ?></h4>
                 </div>
                </div>
                
                <div class="table-responsive-lg" >
                    <table border="1" style="width: 100%;margin-top:10px">
                        <thead>
                        <tr style="background-color:powderblue; text-align: center";>
                                <!-- <th style="width:2%">Sl.NO.</th> -->
                                <th >Sl.NO.</th>
                                <th>Owner Name</th>
                                <th>Service Bill Date</th>
                                <th>Bill for Month</th>
                                <th>Voucher No</th>
                                
                                <th>Flat Number</th>
                                <th>Service Name</th>
                                <th>Bill amount</th>
                                <th>Bill Due Amount</th>
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
                                if (empty($gl_acc_code)) { 

                                    $sql="SELECT apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_charge_code,apart_owner_bill_detail.bill_charge_name,date_format(apart_owner_bill_detail.bill_date, '%M %Y') as month,apart_owner_bill_detail.bill_amount, apart_owner_bill_detail.flat_no,apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.bill_paid_flag, tran_details.tran_date, tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.batch_no, apart_owner_info.owner_id,apart_owner_info.owner_name from apart_owner_bill_detail, tran_details, apart_owner_info where tran_details.vaucher_type='DR' and tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and apart_owner_info.owner_id=apart_owner_bill_detail.owner_id and tran_details.tran_date=apart_owner_bill_detail.bill_process_date and apart_owner_bill_detail.batch_no=tran_details.batch_no and apart_owner_bill_detail.bill_paid_flag='0' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')";


                                }else {

                                    $sql="SELECT tran_details.batch_no,tran_details.tran_date, date_format(apart_owner_bill_detail.bill_date, '%M %Y') as month, tran_details.gl_acc_code, tran_details.dr_amt_loc,tran_details.cr_amt_loc, apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_paid_flag,  apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.bill_amount,apart_owner_bill_detail.flat_no, apart_owner_info.gl_acc_code, apart_owner_info.owner_name from apart_owner_bill_detail, tran_details,apart_owner_info where tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and apart_owner_bill_detail.owner_gl_code='$gl_acc_code'and  tran_details.vaucher_type='DR' and apart_owner_info.gl_acc_code=tran_details.gl_acc_code and tran_details.tran_date=apart_owner_bill_detail.bill_process_date and apart_owner_bill_detail.batch_no=tran_details.batch_no and apart_owner_bill_detail.bill_paid_flag=0  AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')";

                                }

                                
                                } 
                            
                            if (isset($_POST['induvidul'])) {
                                $owner_id = $_SESSION['link_id'];
                                $startdate = $_POST['startdate'];
                                $enddate = $conn->escape_string($_POST['enddate']);

                                    $sql="SELECT tran_details.batch_no,tran_details.tran_date, date_format(apart_owner_bill_detail.bill_date, '%M %Y') as month, tran_details.gl_acc_code, tran_details.dr_amt_loc,tran_details.cr_amt_loc, apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_paid_flag,  apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.bill_amount, apart_owner_bill_detail.flat_no,apart_owner_info.gl_acc_code, apart_owner_info.owner_name from apart_owner_bill_detail, tran_details,apart_owner_info where tran_details.gl_acc_code=apart_owner_bill_detail.owner_gl_code and apart_owner_bill_detail.owner_id='$owner_id'and  tran_details.vaucher_type='DR' and apart_owner_info.gl_acc_code=tran_details.gl_acc_code and tran_details.tran_date=apart_owner_bill_detail.bill_process_date and apart_owner_bill_detail.batch_no=tran_details.batch_no and apart_owner_bill_detail.bill_paid_flag=0 AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')";
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
                                                                        echo $rows['owner_name']; 
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
                                
                                 
                                <td style="text-align: center"><?php echo $rows['flat_no']; 
                                                                    ?></td>
                                            
                                <td style="background-color:powderblue; text-align: left"><?php if  ($rows['bill_paid_flag'] =='0') {
                                                                            echo $rows['bill_charge_name']; echo "  (Due Bill)";
                                                                        } else {
                                                                        echo $rows['bill_charge_name']; 
                                                                    }?></td>
                                                                    
                                                                                
                                
                                <td style="background-color:powderblue; text-align: right"><?php echo $rows['bill_amount']; ?></td>
                                
                                
                                
                                <td style="text-align: right"><?php                                    echo $rows['bill_amount']; 
                                                    $tot_dr_amt = $tot_dr_amt + $rows['bill_amount'];
                                                    $owner_id = $rows['owner_id'];
                                                                    ?></td>  
                                        
                            </tr>
                            
                            <?php } ?>
                        <tfoot>
                        <tr style="background-color:powderblue";>
                                <th style="text-align:right" colspan="7"> Total Amount in TK.</th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_dr_amt; ?></th>
                                <th style="text-align:right" colspan="1"><?php echo ($tot_dr_amt - $tot_cr_amt); ?></th>  
                            </tr>
                        </tfoot>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    
                                        
                    </table>
                    <?php     
                } else {
                       echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select From Date and To Date</h1>";
                }
                ?>
         </div>
    </div>
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
        $("#1308000").addClass('active');
        $("#1300000").addClass('active');
        $("#1300000").addClass('is-expanded');
    });
</script>
</body>

</html>