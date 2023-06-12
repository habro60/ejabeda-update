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
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Trail Balance</h1>
        </div>
         <div class="pull-right">
                <!--<a id="Print" class="btn btn-danger print"></i>Print</a>-->
                <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
            </div>
    </div>
    <!-- filter option -->
    <form method="POST">
        <table id="form_class_id" class="table-responsive table-striped">
            <thead>
                <?php
                if ($role_no == '99') {
                ?>
                    <th>Office</th>
                <?php
                }
                ?>
                <th> From Date </th>
                <th>To Date</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <?php
                   if ($role_no == '99') {
                    $option = "SELECT office_code,office_name from office_info";
                    $query = $conn->query($option);
                    ?>
                    <td>
                        <select name="officeId" class="form-control select2" id="" style="width: 180px;">
                            <option value="">- Select -</option>
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
    <div>
        <?php
        if (isset($_POST['submit'])) {
            $officeId = $_POST['officeId'];
            $startdate = $_POST['startdate'];
            $enddate = $conn->escape_string($_POST['enddate']);
        ?>
                       
     <?php
                $org_name    = $_SESSION['org_name'];
                $org_addr1 = $_SESSION['org_addr1'];
                $org_email = $_SESSION['org_email'];
                $org_tel = $_SESSION['org_tel'];
                $org_logo    = $_SESSION['org_logo'];

            $org_fin_month =  $_SESSION["org_fin_month"];
            $total_libility = $total_asset = 0;
            
        ?>
    
              <div>
    
        <h4 style="text-align:center; margin-top:60px;"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;margin-right:10px;"><?php echo $org_name; ?></h4>
    </div>
    <div id="organizationAdd">
                    <p style="text-align:center"> <?php echo $org_addr1;echo ",<br> "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></p> 
             </div>
    <div>
                <div id="reporttitle">
                     <h6 style="text-align:center" id="reportTitle"><b>Report Type :  </b>Trial Balance</h6> 
                </div>
                <div id="AsOnDate">
                    <p  style="text-align:center; font-weight:bold"><b>Date :  </b> <?php echo "From:"; echo date('d-m-Y ',strtotime($startdate)); ?> To <?php echo date('d-m-Y ',strtotime($enddate)); ?>
                    
                
                    
                    </p> 
                </div>
            </div>                                                     
           
            <br><br>
            <div id="mySelector">
                <table style="width:800px;margin-top:20px;margin-left:120px;margin-right:40px;border-collapse: collapse;" id="sampleTable">
                    <thead class="reportHead" style="background-color: green;">
                        <th style="text-align:center;width:10%;border: 1px solid black;border-collapse: collapse;padding:5px;">SL NO </th>
                        <th style="text-align:center;width:20%;border: 1px solid black;border-collapse: collapse;padding:5px;">A/C Number </th>
                        <th style="text-align:center;width:20%;border: 1px solid black;border-collapse: collapse;padding:5px;">A/C Head </th>
                        <th style="text-align:center;width:25%;border: 1px solid black;border-collapse: collapse;padding:5px;">Debit Transction (TK) </th>
                        <th style="text-align:center;width:25%;border: 1px solid black;border-collapse: collapse;padding:5px;">Credit Transction (TK)</th>
                    </thead>
                    <tbody>
                        <?php
                        $balance_dr = 0;
                        $balance_cr = 0;
                        if (!empty($officeId)) {
                            $sql = "SELECT tran_details.batch_no,tran_details.gl_acc_code,SUM(tran_details.dr_amt_loc) as dr_amt_loc ,tran_details.tran_date,tran_details.tran_mode,tran_details.description,SUM(tran_details.cr_amt_loc) as cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.office_code='$officeId' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') GROUP BY tran_details.gl_acc_code ORDER BY tran_details.gl_acc_code";
                            // echo $sql; exit;
                        } else {
                            $sql = "SELECT tran_details.batch_no,tran_details.gl_acc_code,SUM(tran_details.dr_amt_loc) as dr_amt_loc ,tran_details.tran_date,tran_details.tran_mode,tran_details.description,SUM(tran_details.cr_amt_loc) as cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code  AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') GROUP BY tran_details.gl_acc_code ORDER BY tran_details.gl_acc_code";
                        }
                        $query = $conn->query($sql);
                        $i=1;
                        while ($rows = $query->fetch_assoc()) {
                            $balance_dr = $balance_dr + $rows['dr_amt_loc'];
                            $balance_cr = $balance_cr + $rows['cr_amt_loc'];
                            echo
                            '<tr>
                                
                                <td style="text-align:center;border: 1px solid black;border-collapse: collapse;padding:5px;">' . $i . '</td>
                                <td style="text-align:center;border: 1px solid black;border-collapse: collapse;padding:5px;">' . $rows['gl_acc_code'] . '</td>
                                <td style="text-align:center;border: 1px solid black;border-collapse: collapse;padding:5px;">' . $rows['acc_head'] . '</td>
                                <td style="text-align:center;border: 1px solid black;border-collapse: collapse;padding:5px;">' . number_format($rows['dr_amt_loc'], 2, '.', ',') . '</td>
                                <td style="text-align:center;border: 1px solid black;border-collapse: collapse;padding:5px;">' . number_format($rows['cr_amt_loc'], 2, '.', ',') . '</td>
							</tr>';
							
							$i++;
							
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <?php
                        $sql2 = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE  (`tran_date` BETWEEN '$startdate' AND '$enddate') ORDER BY `tran_date`";
                        $returnD = mysqli_query($conn, $sql2);
                        $result = mysqli_fetch_assoc($returnD);
                        echo '<tr style="text-align:center; color:green; font-weight: bold; font-size: 16px;border: 1px solid black;border-collapse: collapse;">
                        <td style="border-collapse: collapse;" colspan="2"></td>
                        <td style="text-align:center;width:25%;border: 1px solid black;border-collapse: collapse;padding:5px;" >Current Total In TK</td>
                        <td style="text-align:center;width:25%;border: 1px solid black;border-collapse: collapse;padding:5px;" colspan="1">' . number_format($balance_dr, 2, '.', ',')  . '</td>
                        <td style="text-align:center;width:25%;border: 1px solid black;border-collapse: collapse;padding:5px;" colspan="1">' . number_format($balance_cr, 2, '.', ',') . '</td>  
                </tr>';
                        ?>
                        <tr style="text-align:center; color:blue; font-weight: bold; font-size: 16px;border: 1px solid black;border-collapse: collapse;">
                            <td style="border-collapse: collapse;"  colspan="2"></td>
                            <td style="text-align:center;width:25%;border: 1px solid black;border-collapse: collapse;padding:5px;" colspan="1">Grand Total In TK</td>
                            <td style="text-align:center;width:25%;border: 1px solid black;border-collapse: collapse;padding:5px;"><strong><?php echo number_format($result['debit'], 2, '.', ','); ?></strong>
                            </td>
                            <td style="text-align:center;width:25%;border: 1px solid black;border-collapse: collapse;padding:5px;"><strong> <?php echo number_format($result['credit'], 2, '.', ','); ?></strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php
        } else {
            echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select From Date and To Date</h1>";
        }
        ?>
        <?php
        $conn->close();
        ?>
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
</main>
<?php
//require "report_footer.php";
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
             $("#form_class_id").hide();
        });
    });
</script>

</body>

</html>