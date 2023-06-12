<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
require '../source/header.php';
require '../source/sidebar.php';

$office_code = $_SESSION['office_code'];
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_no      = $_SESSION['org_no'];
$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>
<main class="app-content">
    <div class="app-title">
        <div style="width: 100%;">
            <h1><i class="fa fa-dashboard"></i> General Account Statement</h1>
        </div>
        
        <div class="pull-right">
                <!--<a id="Print" class="btn btn-danger print"></i>Print</a>-->
                <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- search -->
            <div class="scroll">
                <form method="POST">
                    <table id="form_class_id" class="table-responsive">
                        <tbody>
                            <tr>
                                <?php
                                if ($role_no== '100' || '99') {
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
                                    <select class="select2 form-control" name="account" id="accou" style="width: 150px;" required>
                                        <option value="">---Select---</option>
                                        <?php
                                        $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc='Y'";
                                        $selectQueryResult = $conn->query($selectQuery);
                                        if ($selectQueryResult->num_rows) {
                                            while ($row = $selectQueryResult->fetch_assoc()) {
                                                echo '<option value="' . $row['acc_code'] . '">' . $row['acc_head'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td> <input type="date" id="date" class="startdate" name="startdate" value="<?php echo date('Y-m-d'); ?>"></td>
                                <td> <input type="date" id="date" class="enddate" name="enddate" value="<?php echo date('Y-m-d'); ?>"></td>
                                <td>
                                    <input type="submit" name="submit" id="submitBtn" class="btn btn-info" value="Report View">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <!-- search -->
            <div>
                <?php
                if (isset($_POST['submit'])) {

                    $org_name    = $_SESSION['org_name'];
                    $org_addr1 = $_SESSION['org_addr1'];
                    $org_email = $_SESSION['org_email'];
                    $org_tel = $_SESSION['org_tel'];
                     $org_logo    = $_SESSION['org_logo'];

                    $officeId = $_POST['officeId'];
                    $org_fin_year_st =  $_SESSION["org_fin_year_st"];
                    $account = $_POST['account'];
                    $startdate = $_POST['startdate'];
                    $enddate = $conn->escape_string($_POST['enddate']);
                    $open_bal = date('Y-m-d', strtotime($startdate . ' - 1 day'));
                 
                ?>
        <div>
    
        <h4 style="text-align:center; margin-top:60px;"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;margin-right:10px;"><?php echo $org_name; ?></h4>
    </div>
    <div id="organizationAdd">
                    <p style="text-align:center"> <?php echo $org_addr1;echo ",<br> "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></p> 
             </div>
             
             <div>
                <div id="reporttitle">
                     <h6 style="text-align:center" id="reportTitle"><b>Report Title :  </b>GL A/C Statement</h6> 
                </div>
                <div id="AsOnDate">
                    <p  style="text-align:center; font-weight:bold"><b>Date :  </b> <?php echo "From:"; echo date('d-m-Y ',strtotime($startdate)); ?> To <?php echo date('d-m-Y ',strtotime($enddate)); ?></p> 
                </div>
            </div>             
             
             
                         
  
            <div id="mySelector">
                <table style="width:800px;margin-top:50px;margin-left:120px;margin-right:40px;border: 1px solid black;border-collapse: collapse;" id="sampleTable">
                    <thead class="reportHead">
                        <th style="text-align:center">SL NO</th>
                        <th style="text-align:center">Date</th>
                        <th style="text-align:center">Trx. Mode</th>
                        <th style="text-align:center">Particular</th>
                        <th style="text-align:center">Debit In TK</th>
                        <th style="text-align:center">Credit In Tk</th>
                        <th style="text-align:center">Balance In TK</th>
                    </thead>
                    <tbody style="">
                        <?php
                        $sql_opbal = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE gl_acc_code='$account' AND (`tran_date` BETWEEN '$org_fin_year_st' AND '$open_bal') ORDER BY `tran_date`";
                        $return_opbal = mysqli_query($conn, $sql_opbal);
                        $result_opbal = mysqli_fetch_assoc($return_opbal);

                        $sql="SELECT gl_acc_code.id,gl_acc_code.acc_head, gl_acc_code.category_code from gl_acc_code where  gl_acc_code.acc_code='$account'";
                            $query2 = mysqli_query($conn, $sql);
                            $ownerRows = mysqli_fetch_assoc($query2);
                            $category_code= $ownerRows['category_code'];
                        ?>
                        <tr style="font-weight:bold;color: red;text-align: center;">
                            <td style="border: 1px solid black;" colspan="4">Opening Balance </td>
                            <td style="border: 1px solid black;text-align:right;"><?php echo $result_opbal['debit']; ?></td>
                            <td style="border: 1px solid black; text-align:right;"><?php echo $result_opbal['credit']; ?></td>
                            <td style="border: 1px solid black;text-align:right;">
                            <?php if (($category_code =='1')|| ($category_code =='4')){echo $result_opbal['debit'] - $result_opbal['credit'];} else {echo $result_opbal['credit'] - $result_opbal['debit']; } ?>   
                            </td>
                        </tr>
                        <?php

                        $total_dr = 0;
                        $total_cr = 0;
                        $category_code= $ownerRows['category_code'];
                        $category_code= $ownerRows['category_code'];
                        if (($category_code =='2') ||($category_code =='3')) {
                            $sql="SELECT tran_details.tran_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code,tran_details.cr_amt_loc-tran_details.dr_amt_loc as balance, @RunningBalance:= @RunningBalance + (tran_details.cr_amt_loc-tran_details.dr_amt_loc) as RunningBalance, gl_acc_code.category_code  FROM tran_details JOIN gl_acc_code JOIN (SELECT @RunningBalance:= 0) r WHERE tran_details.gl_acc_code='$account' and (gl_acc_code.category_code='2' or gl_acc_code.category_code='3') and (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')group by tran_details.tran_no order by tran_details.tran_date, tran_details.tran_no";
                        } 
                        $category_code= $ownerRows['category_code'];
                        if (($category_code =='1') ||($category_code =='4')) {
                            
                            $sql="SELECT tran_details.tran_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code,tran_details.dr_amt_loc-tran_details.cr_amt_loc as balance, @RunningBalance:= @RunningBalance + (tran_details.dr_amt_loc-tran_details.cr_amt_loc) as RunningBalance, gl_acc_code.category_code  FROM tran_details JOIN gl_acc_code JOIN (SELECT @RunningBalance:= 0) r WHERE tran_details.gl_acc_code='$account' and tran_details.gl_acc_code=gl_acc_code.acc_code and  (gl_acc_code.category_code='1' or gl_acc_code.category_code='4') and (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') group by tran_details.tran_no  order by tran_details.tran_date, tran_details.tran_no" 
                            ;         
                            }
                        $i=1;
                        $query = $conn->query($sql);
                        while ($rows = $query->fetch_assoc()) {
                            if ($rows['tran_date'] >= $startdate) {
                                $total_dr = $total_dr + $rows['dr_amt_loc'];
                                $total_cr = $total_cr + $rows['cr_amt_loc'];
                                echo
                                '<tr>
                                <td style="text-align:center;width:5%;border: 1px solid black;border-collapse: collapse;padding:10px;">' . $i . '</td>
                                <td style="text-align:center;width:30%;border: 1px solid black;border-collapse: collapse;padding:20px;">' . date('d-m-Y ',strtotime($rows['tran_date'])) . '</td>
                                <td style="text-align:center;width:5%;border: 1px solid black;border-collapse: collapse;padding:10px;">' . $rows['tran_mode'] . '</td>
                                <td style="text-align:center;width:30%;border: 1px solid black;border-collapse: collapse;padding:10px;">' . $rows['description'] . '</td>
                                <td style="text-align:right;width:10%;border: 1px solid black;border-collapse: collapse;padding:10px;">' . number_format($rows['dr_amt_loc'], 2, '.', ',') . '</td>
                                <td style="text-align:right;width:10%;border: 1px solid black;border-collapse: collapse;padding:10px;">' . number_format($rows['cr_amt_loc'], 2, '.', ',')  . '</td>
                                 <td style="text-align:right;width:10%;border: 1px solid black;border-collapse: collapse;padding:10px;"><strong>' . number_format($rows['RunningBalance'], 2, '.', ',') . '</strong></td>
                            </tr>';
                            $i++;
                            }
                            
                        } ?>
                        <tr style="font-weight:bold;border: 1px solid black;">
                            <td style="border: 1px solid black;padding:10px;" colspan="3"></td>
                            <td style="border: 1px solid black;padding:10px;" colspan="1">Sub Total In TK</td>
                            <td style="border: 1px solid black;padding:10px; text-align:right;"> <?php echo number_format($total_dr, 2, '.', ','); ?></td>
                            <td style="border: 1px solid black;padding:10px; text-align:right;"><?php echo number_format($total_cr, 2, '.', ','); ?></td>
                            <td style="border: 1px solid black;padding:10px; text-align:right;"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        
                        <?php
                        $sql2 = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE gl_acc_code='$account' AND (`tran_date` BETWEEN '$org_fin_year_st' AND '$enddate') ORDER BY `tran_date`";
                        $returnD = mysqli_query($conn, $sql2);
                        $result = mysqli_fetch_assoc($returnD); ?>
                        <tr class="text-center">
                            <td style="border: 1px solid black;" colspan="3"></td>
                            <td style="border: 1px solid black;" colspan="0"><strong>Total In TK</strong></td>
                            <td style="border: 1px solid black;padding:10px;" colspan="1" ><strong><?php echo number_format($result['debit'], 2, '.', ','); ?></strong>
                            </td>
                            <td style="border: 1px solid black;padding:10px;" colspan="1" ><strong><?php echo number_format($result['credit'], 2, '.', ','); ?></strong>
                            </td>
                           
                           <td style="border: 1px solid black;padding:10px;" colspan="4"><?php if (($category_code =='1') ||($category_code =='4')) {$val=$result['debit'] - $result['credit'];echo number_format($val, 2, '.', ','); 
                            } else {
                            $val=$result['credit'] - $result['debit'];echo number_format($val, 2, '.', ',');
                            }?></td>                             
                        </tr>
                    <?php
                } else {
                    echo "<h3 style='color:red;text-align:center;margin-top:150px'>Please Select Account and Date</h3>";
                }
                    ?>
                    </tfoot>
                </table>
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
        $("#703000").addClass('active');
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