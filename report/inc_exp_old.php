<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';

require '../source/header.php';
require '../source/sidebar.php';


$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
$office_code = $_SESSION['office_code'];
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_addr1 = $_SESSION['org_addr1'];
$org_email = $_SESSION['org_email'];
$org_tel = $_SESSION['org_tel'];  
$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];


?>
<style>
    .cols6 {
        -webkit-box-flex: 0;
        -ms-flex: 0;
        flex: 45%;
        max-width: 50%;
    }
     .table td, .table th {
        font-size: 12px;
    }
</style>
<main class="app-content">
    <div class="app-title">
        <h1><i class="fa fa-dashboard"></i> Income and Expenditure Statement </h1>
         <div class="pull-right">
                <!--<a id="Print" class="btn btn-danger print"></i>Print</a>-->
                <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
        </div>
    </div>
    <!--  filter option -->
    <form method="POST">
        <table id="form_class_id" class="table-responsive">
            <tbody>
                <tr>
                    <?php
                    if ($role_no == '99') {
                        $option = "SELECT office_code,office_name from office_info";
                        $query = $conn->query($option);
                    ?>
                        <td>
                            <select name="officeId" class="form-control select2" id="" style="width: 180px;">
                                <option value="">-Select Office-</option>
                                <?php
                                while ($rows = $query->fetch_assoc()) {
                                    echo '<option value=' . $rows['office_code'] . '>' . $rows['office_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    <?php
                    }
                    ?>
                    <td>
                        <input type="date" name="startdate" value="<?php echo $startdate; ?>" class="form-control" required>
                    </td>
                    <td>
                        <input type="date" name="enddate" value="<?php echo $enddate; ?>" class="form-control" required>
                    </td>
                    <td>
                        <input type="submit" name="submit" id="submitBtn" class="btn btn-info" value="Report View">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <!-- end filter option -->
    <div class="row">
        <div class="col-md-12">
            <h3 style="text-align:center"> </h3>
            <?php
            if (isset($_POST['submit'])) {
                $officeId = $_POST['officeId'];
                $startdate = $_POST["startdate"];
                $enddate = $conn->escape_string($_POST["enddate"]);

            ?>
           <div>
    
        <h4 style="text-align:center; margin-top:60px;"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;margin-right:10px;"><?php echo $org_name; ?></h4>
    </div>
    <div id="organizationAdd">
                    <p style="text-align:center"> <?php echo $org_addr1;echo ",<br> "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></p> 
             </div>
             
             
             
             <div>
                <div id="reporttitle">
                     <h6 style="text-align:center" id="reportTitle"><b>Report Title :  </b>Income and Expenditure Statement</h6> 
                </div>
                <div id="AsOnDate">
                    <p  style="text-align:center; font-weight:bold"><b>Date :  </b> <?php echo "From:"; echo date('d-m-Y ',strtotime($startdate)); ?> To <?php echo date('d-m-Y ',strtotime($enddate)); ?>
                    
                
                    
                    </p> 
                </div>
            </div>           

                <div class="row" style="margin-bottom: 5px">
             
            </div> 
                </div>
            </div>
             
                <br>
                <div id="mySelector">
                    <div class="row">
                        <div class="cols6">
                                <table style="width:440px;margin-top:20px;margin-left:80px;margin-right:40px;border-collapse: collapse;" id="sampleTable" class="table table-hover table-striped" id="sampleTable">
                                <thead class="reportHead" style="background-color: green;">
                                    <tr style="text-align:center">
                                        <th colspan="6">Income </th>
                                    </tr>
                                    <tr>
                                        <th style="width: 2%;">SL</th>
                                        <th style="width: 20%;">Date</th>
                                        <th style="width: 2%;">A/C Code</th>
                                        <th style="width: 2%;">Title</th>
                                        <th class="bala" style="width: 4%;">Balance In TK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($officeId)) {
                                        $sql = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.cr_amt_loc-tran_details.dr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.office_code='$officeId' AND gl_acc_code.category_code='3' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and (tran_details.dr_amt_loc is not NULL or tran_details.dr_amt_loc is NULL) and (tran_details.cr_amt_loc is not NULL or tran_details.cr_amt_loc is NULL) group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
                                    } else {
                                        $sql = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.cr_amt_loc-tran_details.dr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND gl_acc_code.category_code='3' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and (tran_details.dr_amt_loc is not NULL or tran_details.dr_amt_loc is NULL) and (tran_details.cr_amt_loc is not NULL or tran_details.cr_amt_loc is NULL) group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
                                    }
                                    $query = $conn->query($sql);
                                    $tot = 0;
                                    $sl=1;
                                    while ($row = $query->fetch_assoc()) {
                                        $tot = $tot + $row['balance'];
                                    ?>
                                        <tr>
                                            <td style="width: 2%;"><?php echo $sl; ?></td>   
                                            <td style="width: 20%;"><?php echo date('d-m-Y ',strtotime($row['tran_date'])); ?></td>
                                            <td style="width: 2%;"><?php echo $row['acc_code']; ?></td>
                                            <td style="width: 2%;"><?php echo $row['acc_head']; ?></td>
                                            <td style="text-align: right; width: 9%;"><?php echo number_format($row['balance'], 2, '.', ','); ?></td>
                                        </tr>
                                    <?php
                                    $sl++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr style="text-align: right; font-weight:bold">
                                        <td colspan="3">Total In TK</td>
                                        <td><?php echo number_format($tot, 2, '.', ','); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div style="width:300px;" class="cols6">
                            <div id="mySelector">
   <table style="width:500px;margin-top:20px;margin-right:60px;border-collapse: collapse;" id="sampleTable"  class="table table-hover table-striped" id="sampleTable">
                                    <thead class="reportHead" style="background-color: gray;">
                                        <tr style="text-align:center">
                                            <th colspan="6">Expenditure</th>
                                        </tr>

                                        <th style="width: 1%; text-align:center;">SL</th>
                                        <th style="width: 33%;text-align:center;">Date</th>
                                        <th style="width: 2%;text-align:center;">A/C Code</th>
                                        <th style="width: 2%;text-align:center;">Title</th>
                                        <th style="width: 2%;text-align:center;">Balance In Tk</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($officeId)) {
                                            $sqls = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.dr_amt_loc-tran_details.cr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.office_code='$officeId' AND gl_acc_code.category_code='4' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
                                        } else {
                                            $sqls = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.dr_amt_loc-tran_details.cr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND gl_acc_code.category_code='4' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
                                        }
                                        $querys = $conn->query($sqls);
                                        $tot_ex = 0;
                                        $sl=1;
                                        while ($rows = $querys->fetch_assoc()) {
                                            $tot_ex = $tot_ex + $rows['balance'];
                                        ?>
                                            <tr>
                                                <td style="width: 1%;text-align:center;"><?php echo $sl; ?></td>
                                                <td style="width: 33%;text-align:center;"><?php echo date('d-m-Y ',strtotime($rows['tran_date'])); ?></td>
                                                <td style="width: 2%;text-align:center;"><?php echo $rows['acc_code']; ?></td>
                                                <td style="width: 2%;text-align:center;"><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right;text-align:center; width:2%"><?php echo number_format($rows['balance'], 2, '.', ',');  ?></td>
                                            </tr>
                                        <?php
                                        $sl++;
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="text-align: centr; font-weight:bold">
                                            <td colspan="3">Total In TK</td>
                                            <td><?php echo number_format($tot_ex, 2, '.', ',');  ?></td>
                                        </tr>
                                    </tfoot>
                                <?php
                            } else {
                                echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select From Date and To Date</h1>";
                            }
                                ?>
                                </table>
                            </div>
                        </div>
                    </div>
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
        </div>
    </div>
</main>
<?php
//require "report_footer.php";
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
<!--  -->
<script src="../js/custom.js"></script>
<!-- data table -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<!-- print this js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })
    $(document).ready(function() {
        $("#704000").addClass('active');
        $("#700000").addClass('active');
        $("#700000").addClass('is-expanded');
    });
</script>



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