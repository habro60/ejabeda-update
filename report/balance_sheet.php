<?php
require "../auth/auth.php";
require '../database.php';
require '../source/top.php';
// $pid= 706000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require '../source/header.php';
require '../source/sidebar.php';

// session //
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
            <h1><i class="fa fa-dashboard"></i> Balance Sheet </h1>
        </div>
        
         <div class="pull-right">
                <!--<a id="Print" class="btn btn-danger print"></i>Print</a>-->
                <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
        </div>
    </div>
    <form method="POST">
        <table id="form_class_id" class="table-responsive table-striped">
            <thead>
                <th>Office</th>
                <th> As on Date </th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <?php
                    // if () {   
                    // }
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
                    ?>
                    <td> <input type="date" id="date" class="enddate" name="enddate" value="<?php echo date('Y-m-d'); ?>"></td>
                    <td>
                        <input type="submit" name="submit" id="submitBtn" class="btn btn-info" value="Report View">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <div>
        <?php
        if (isset($_POST['submit'])) {
            $enddate = $conn->escape_string($_POST['enddate']);

            //    Income & expanse ====================
               
            $query1 = "SELECT tran_details.tran_date, tran_details.gl_acc_code, sum(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as dr_balance, gl_acc_code.category_code FROM `tran_details`,gl_acc_code  WHERE tran_details.tran_date <= '$enddate'and gl_acc_code.category_code='4' and gl_acc_code.acc_code=tran_details.gl_acc_code";
            $returnD = mysqli_query($conn, $query1);
            $expense = mysqli_fetch_assoc($returnD);

            $query2 = "SELECT tran_details.tran_date, tran_details.gl_acc_code,sum(tran_details.cr_amt_loc - tran_details.dr_amt_loc) as cr_balance,  gl_acc_code.category_code FROM `tran_details`,gl_acc_code  WHERE tran_details.tran_date <= '$enddate'and gl_acc_code.category_code='3' and gl_acc_code.acc_code=tran_details.gl_acc_code";
            $returnIncome = mysqli_query($conn, $query2);
            $income = mysqli_fetch_assoc($returnIncome);

               
              

            //   end income and expanse  ==============

                $org_name    = $_SESSION['org_name'];
                $org_addr1 = $_SESSION['org_addr1'];
                $org_email = $_SESSION['org_email'];
                $org_tel = $_SESSION['org_tel'];
                $org_logo    = $_SESSION['org_logo'];

            $org_fin_month =  $_SESSION["org_fin_month"];
            $total_libility = $total_asset = 0;
            $sqlview="CREATE or REPLACE VIEW view_balance_sheet AS SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, gl_acc_code.parent_acc_code, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as Cr_amt, sum(tran_details.dr_amt_loc) as dr_amt, tran_details.tran_date, SUM(tran_details.cr_amt_loc - tran_details.dr_amt_loc) as liab_balance, SUM(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as asst_balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date<= '$enddate'  group by gl_acc_code.parent_acc_code order by gl_acc_code.acc_code";
            $query = $conn->query($sqlview);
        ?>
          <div>
    
        <h4 style="text-align:center; margin-top:60px;"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;margin-right:10px;"><?php echo $org_name; ?></h4>
    </div>
    <div id="organizationAdd">
                    <p style="text-align:center"> <?php echo $org_addr1;echo ",<br> "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></p> 
             </div>
             
             
             
             <div>
                 
                 
                 
                 <div>
                <div id="reporttitle">
                     <h6 style="text-align:center" id="reportTitle"><b>Report Title :  </b>Balance Sheet</h6> 
                </div>
                <div id="AsOnDate">
                    <p  style="text-align:center; font-weight:bold"><b>As on Date :-</b><?php echo date('d-m-Y ',strtotime($enddate)); ?>
                    
                
                    
                    </p> 
                </div>
            </div>           

                
             
            <div id="mySelector">
                <div class="row">
                    <div class="col-6">
                        <table style="width:420px;margin-top:60px;margin-left:100px;margin-right:40px;border-collapse: collapse;" class="table table-hover table-striped">
                            <thead class="reportHead" style="background-color: #138496;">
                                <tr style="text-align:center">
                                    <th colspan="4">Liabilities</th>
                                </tr>
                            </thead>
                            <tr>
                                <th>A/C HEAD</th>
                                <th>BALANCE IN (TK)</th>
                            </tr>
                            <tbody>
                                <?php
                                $sql1 = "SELECT view_balance_sheet.category_code,view_balance_sheet.acc_level,view_balance_sheet.parent_acc_code, view_balance_sheet.Cr_amt,view_balance_sheet.dr_amt,view_balance_sheet.liab_balance, gl_acc_code.acc_head FROM `view_balance_sheet`, gl_acc_code where view_balance_sheet.parent_acc_code=gl_acc_code.id order  by view_balance_sheet.category_code,view_balance_sheet.acc_level,view_balance_sheet.parent_acc_code";
                                $query = $conn->query($sql1);
                                while ($rows = $query->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <?php
                                        if (($rows['category_code'] == 2) or ($rows['category_code'] == 5)) {
                                            $total_libility = ($total_libility + $rows['liab_balance']);
                                            if ($rows['acc_level'] == 1) {
                                        ?>
                                                <td style="text-align:right" ></td>
                                                <td style="color:gray; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $rows['liab_balance']; ?></td>
                                            <?php
                                            } elseif ($rows['acc_level'] == 2) {
                                            ?>
                                                <td style="text-indent: 20px;color:blue; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $rows['liab_balance']; ?></td>
                                            <?php
                                            } elseif ($rows['acc_level'] == 3) {
                                            ?>
                                                <td style="text-indent: 30px;color:red;   font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right"> <?php echo $rows['liab_balance']; ?></td>
                                            <?php
                                            } elseif ($rows['acc_level'] == 4) {
                                            ?>
                                                <td style="text-indent:  40px;color:green; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $rows['liab_balance']; ?></td>
                                            <?php
                                            } else {
                                            ?>
                                                <td style="text-indent:  right 20px"><?php echo $rows['acc_head'];?></td>
                                                <td style="text-align: right"><?php echo $rows['liab_balance']; ?></td>
                                            <?php
                                            }
                                            ?>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total Income In TK</th>
                                    <th style="text-align: right"><strong><?php echo number_format($income['cr_balance'], 2, '.', ','); ?></strong></th>
                                </tr>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total In TK</th>
                                    <th style="text-align: right"><strong><?php echo number_format(($total_libility + $income['cr_balance']), 2, '.', ',');  ?></strong></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-6">
                        <table style="width:420px;margin-top:60px;margin-left:50px;margin-right:60px;border-collapse: collapse;" class="table table-hover table-striped">
                            <thead class="reportHead" style="background-color: #138496;">
                                <tr style="text-align:center">
                                    <th colspan="4">Assets</th>
                                </tr>
                            </thead>
                            <tr>
                                <th>A/C HEAD</th>
                                <th>BALANCE IN (TK)</th>
                            </tr>
                            <tbody>
                                <?php
                                $sql1 = "SELECT view_balance_sheet.category_code,view_balance_sheet.acc_level,view_balance_sheet.parent_acc_code, view_balance_sheet.Cr_amt,view_balance_sheet.dr_amt,view_balance_sheet.asst_balance, gl_acc_code.acc_head FROM `view_balance_sheet`, gl_acc_code where view_balance_sheet.parent_acc_code=gl_acc_code.id order  by view_balance_sheet.category_code,view_balance_sheet.acc_level,view_balance_sheet.parent_acc_code";
                                $query1 = $conn->query($sql1);
                                while ($row = $query1->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <?php
                                        if ($row['category_code'] == 1) {
                                            $total_asset = ($total_asset + $row['asst_balance']);

                                            if ($row['acc_level'] == 1) {
                                        ?>
                                                 <td style="text-align:right" ></td>
                                                <td style="color:gray; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $row['asst_balance']; ?></td>
                                            <?php
                                            } elseif ($row['acc_level'] == 2) {
                                            ?>
                                                <td style="text-indent:20px;color:blue; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $row['asst_balance']; ?></td>
                                            <?php
                                            } elseif ($row['acc_level'] == 3) {
                                            ?>
                                                <td style="text-indent:30px;color:red; right font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $row['asst_balance']; ?></td>
                                            <?php
                                            } elseif ($row['acc_level'] == 4) {
                                            ?>
                                                <td style="text-indent:40px;color:green; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $row['asst_balance']; ?></td>
                                            <?php
                                            } else {
                                            ?>
                                                <td style="text-indent:20px"><?php echo $row['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $row['asst_balance']; ?></td>
                                            <?php
                                            }
                                            ?>
                                    <?php
                                        }
                                    }

                                    ?>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total Expances In TK</th>
                                    <th style="text-align: right"><strong><?php echo number_format($expense['dr_balance'], 2, '.', ','); ?></strong></th>
                                </tr>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total In TK</th>
                                    <th style="text-align: right"><strong><?php echo number_format(($total_asset + $expense['dr_balance']), 2, '.', ','); ?></strong></th>
                                </tr>
                            </tfoot>
                        <?php
                    } else {
                        echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select Date</h1>";
                    }
                        ?>
                        </table>   
                <?php        
                require "report_footer.php";
                ?>
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
require "report_footer.php";
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