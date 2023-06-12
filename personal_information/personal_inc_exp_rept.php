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
$org_fin_year_st =  $_SESSION["org_fin_year_st"];


?>
<style>
    .cols6 {
        -webkit-box-flex: 0;
        -ms-flex: 0;
        flex: 45%;
        max-width: 50%;
    }
</style>
<main class="app-content">
    <div class="app-title">
        <h1><i class="fa fa-dashboard"></i>Income & Expenses Report </h1>
        
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
                    
                    <td>
                        <input type="date" name="startdate" value=""<?php echo "startdate"; ?> class="form-control" required>
                    </td>
                    <td>
                        <input type="date" name="enddate" value=""<?php echo "enddate"; ?> class="form-control" required>
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
                $startdate = $_POST["startdate"];
                $enddate = $_POST["enddate"];
                $owner_rec_id = $_SESSION['link_id'];

            ?>
            <div id="organizationName">
                    <?php 
                       $sql="SELECT apart_owner_info.owner_name,apart_owner_info.mobile_no from apart_owner_info where apart_owner_info.owner_id='$owner_rec_id'";
                       $query2 = mysqli_query($conn, $sql);
                       $ownerRows = mysqli_fetch_assoc($query2);
                ?>
                
                
                 <h4 style="text-align:center; margin-top:60px;"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;margin-right:10px;"><?php echo $ownerRows['owner_name']; ?></h4>
                
                    </div>
               <div id="organizationAdd">
                    <p style="text-align:center"> <?php echo $org_addr1;echo ",<br> "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></p> 
             </div>
             
             
             <div>
                <div id="reporttitle">
                     <h6 style="text-align:center" id="reportTitle"><b>Clean Cash Report</h6> 
                </div>
                <div id="AsOnDate">
                    <p  style="text-align:center; font-weight:bold"><b>Date :  </b> <?php echo "From:"; echo date('d-m-Y ',strtotime($startdate)); ?> To <?php echo date('d-m-Y ',strtotime($enddate)); ?>
                    
                
                    
                    </p> 
                </div>
            </div>     
    
            </div>
             <div class="row" style="margin-bottom: 5px">
                <div class="col-12">
                    
                </div>
            </div> 
                </div>
                <br>
                <div id="mySelector">
                    <div class="row">
                        <div class="cols6">
                             <table style="width:480px;margin-top:20px;margin-left:70px;margin-right:40px;border-collapse: collapse;" id="sampleTable" class="table table-hover table-striped" id="sampleTable">
                                <thead class="reportHead" style="background-color: green;">
                                <tr style="text-align:center">
                                            <th colspan="5">Income</th>
                                        </tr>
                                    <tr>
                                        <th>SL NO</th>
                                        <th>Date</th>
                                        <th>A/C Code</th>
                                        <th>Title</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=1;
                                    $owner_id =$_SESSION['link_id'];
                                    if (!empty($owner_id)) {
                                        $sql = "SELECT personal_ledger.tran_no,personal_ledger.gl_acc_code,personal_ledger.tran_mode,personal_ledger.dr_amt_loc,personal_ledger.tran_date,personal_ledger.tran_mode,personal_ledger.description,personal_ledger.cr_amt_loc,personal_account.category_code, personal_account.acc_head,personal_account.id, SUM(personal_ledger.cr_amt_loc-personal_ledger.dr_amt_loc) as balance FROM personal_ledger JOIN personal_account WHERE personal_ledger.gl_acc_code=personal_account.id and personal_ledger.owner_rec_id = '$owner_rec_id' AND  personal_account.category_code='3' AND (personal_ledger.tran_date BETWEEN '$startdate' AND '$enddate') and (personal_ledger.dr_amt_loc is not NULL or personal_ledger.dr_amt_loc is NULL) and (personal_ledger.cr_amt_loc is not NULL or personal_ledger.cr_amt_loc is NULL) group by personal_ledger.gl_acc_code order by personal_ledger.gl_acc_code";
                                    } 
                                    $query = $conn->query($sql);
                                    $tot = 0;
                                    while ($row = $query->fetch_assoc()) {
                                        $tot = $tot + $row['balance'];
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo date('d-m-Y ',strtotime($row['tran_date'])); ?></td>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['acc_head']; ?></td>
                                            <td style="text-align: right"><?php echo $row['balance']; ?></td>
                                        </tr>
                                    <?php
                                    $i++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <?php
                                    $sql1="SELECT SUM(personal_ledger.dr_amt_loc - personal_ledger.cr_amt_loc) as opcash, personal_account.category_code  FROM personal_ledger, personal_account where personal_account.id=personal_ledger.gl_acc_code and  personal_ledger.tran_date < '$startdate' and personal_ledger.owner_rec_id = '$owner_rec_id'and personal_account.category_code='1'";
                                    $query1 = mysqli_query($conn, $sql1);
                                    $cashrows = mysqli_fetch_assoc($query1);

                                    $sql2="SELECT SUM(personal_ledger.dr_amt_loc - personal_ledger.cr_amt_loc) as opbank, personal_account.category_code  FROM personal_ledger, personal_account where personal_account.id=personal_ledger.gl_acc_code and personal_ledger.tran_date < '$startdate'and personal_ledger.owner_rec_id = '$owner_rec_id' and personal_account.category_code='2'";
                                    
                                    $query2 = mysqli_query($conn, $sql2);
                                    $bankrows = mysqli_fetch_assoc($query2);
                                    ?>
                                   <tr style="text-align: right; font-weight:bold">
                                        <td colspan="3">Opening Cash</td>
                                        <td><?php echo $cashrows['opcash']; ?></td>
                                    </tr>
                                    <tr style="text-align: right; font-weight:bold">
                                        <td colspan="3">Opening Bank Balance</td>
                                        <td><?php echo $bankrows['opbank']; ?></td>
                                    </tr>
                                    <tr style="text-align: right; font-weight:bold">
                                        <td colspan="3">Total</td>
                                        <td><?php echo ($tot + $cashrows['opcash'] + $bankrows['opbank']); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="cols6">
                            <!-- <div id="mySelector"> -->
                                <table style="width:510px;margin-top:20px;margin-left:20px;border-collapse: collapse;" id="sampleTable"  class="table table-hover table-striped" id="sampleTable">
                                    <thead class="reportHead" style="background-color: gray;">
                                        <tr style="text-align:center">
                                            <th colspan="5">Expenditure</th>
                                        </tr>
                                        <th>SL NO</th>
                                        <th>Date</th>
                                        <th>A/C Code</th>
                                        <th>Title</th>
                                        <th>Balance</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=1;
                                         $owner_id =$_SESSION['link_id'];
                                         if (!empty($owner_id)) {
                                            $sqls = "SELECT personal_ledger.tran_no,personal_ledger.gl_acc_code,personal_ledger.tran_mode,personal_ledger.dr_amt_loc,personal_ledger.tran_date,personal_ledger.tran_mode,personal_ledger.description,personal_ledger.cr_amt_loc,personal_account.category_code, personal_account.acc_head,personal_account.id, SUM(personal_ledger.dr_amt_loc-personal_ledger.cr_amt_loc) as balance FROM personal_ledger JOIN personal_account WHERE personal_ledger.gl_acc_code=personal_account.id AND  personal_account.category_code='4' and personal_ledger.owner_rec_id = '$owner_rec_id' AND (personal_ledger.tran_date BETWEEN '$startdate' AND '$enddate') and (personal_ledger.dr_amt_loc is not NULL or personal_ledger.dr_amt_loc is NULL) and (personal_ledger.cr_amt_loc is not NULL or personal_ledger.cr_amt_loc is NULL) group by personal_ledger.gl_acc_code order by personal_ledger.gl_acc_code";
                                        } 
                                        
                                        $querys = $conn->query($sqls);
                                        $tot_ex = 0;
                                        while ($rows = $querys->fetch_assoc()) {
                                            $tot_ex = $tot_ex + $rows['balance'];
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date('d-m-Y ',strtotime($rows['tran_date'])); ?></td>
                                                <td><?php echo $rows['id']; ?></td>
                                                <td><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $rows['balance']; ?></td>
                                            </tr>
                                        <?php
                                        $i++;
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <?php
                                    $sq3="SELECT SUM(personal_ledger.dr_amt_loc - personal_ledger.cr_amt_loc) as closecash,personal_account.category_code  FROM personal_ledger, personal_account where personal_account.id=personal_ledger.gl_acc_code and (personal_ledger.tran_date BETWEEN '$org_fin_year_st' AND '$enddate') and personal_ledger.owner_rec_id = '$owner_rec_id'and personal_account.category_code='1'";
                                    $query = mysqli_query($conn, $sq3);
                                    $cashrows = mysqli_fetch_assoc($query);

                                    $sql4="SELECT SUM(personal_ledger.dr_amt_loc - personal_ledger.cr_amt_loc) as closebank,personal_account.category_code  FROM personal_ledger, personal_account where personal_account.id=personal_ledger.gl_acc_code and (personal_ledger.tran_date BETWEEN '$org_fin_year_st' AND '$enddate') and personal_ledger.owner_rec_id = '$owner_rec_id'and personal_account.category_code='2'";
                                    $query = mysqli_query($conn, $sql4);
                                    $bankrows = mysqli_fetch_assoc($query);
                                    ?>
                                
                                      <tr style="text-align: right; font-weight:bold">
                                            <td colspan="3">Closing Cash</td>
                                            <td><?php echo $cashrows['closecash']; ?></td>
                                        </tr>
                                        <tr style="text-align: right; font-weight:bold">
                                            <td colspan="3">Closing bank Balance</td>
                                            <td><?php echo $bankrows['closebank']; ?></td>
                                        </tr>
                                        <tr style="text-align: right; font-weight:bold">
                                            <td colspan="3">Total</td>
                                            <td><?php echo ($tot_ex  + $cashrows['closecash'] +$bankrows['closebank']); ?></td>
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
// print js
$(document).on('click', '.print', function () {
 
    var organizationName = $('#organizationName').text();
    var organizationAdd = $('#organizationAdd').text(); 
    var ownername = $('#ownername').text();
    var reportTitle = $('#reportTitle').text();
    var AsOnDate = $('#AsOnDate').text();
    var header = `<div>
    	            <h3 style="text-align:center">${organizationName}</h3>
                    <h4 style="text-align:center">${organizationAdd}</h4>
                    </div>
                    <div>
                    <h5 style="text-align:center" id="reportTitle">${reportTitle}</h5>
                    </div>
                    
                    <div>
                    <p style="text-align:center;font-weight:bold">${AsOnDate}</p>
                    </div>
                   `;

                    
    $("#mySelector").printThis({
        debug: false,               // show the iframe for debugging
        importCSS: true,            // import parent page css
        importStyle: false,         // import style tags
        printContainer: true,       // print outer container/$.selector
        loadCSS: 'http://ejabeda.com/css/print.css', // path to additional css file - use an array [] for multiple
        pageTitle: null,              // add title to print page
        removeInline: false,        // remove inline styles from print elements
        removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
        printDelay: 333,            // variable print delay
        header: header,               // prefix to html
        // footer: '<h6 style="text-align:center">Design and Development by Habro System Ltd.</h6>',               // postfix to html
      
        base: false,                // preserve the BASE tag or accept a string for the URL
        formValues: false,           // preserve input/form values
        canvas: false,              // copy canvas content
        // doctypeString: '...',       // enter a different doctype for older markup
        removeScripts: false,       // remove script tags from print content
        copyTagClasses: false,      // copy classes from the html & body tag
        beforePrintEvent: null,     // function for printEvent in iframe
        beforePrint: null,          // function called before iframe is filled
        afterPrint: null            // function called before iframe is removed
    });
});
</script>

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