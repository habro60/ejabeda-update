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
    </div>
    <!-- filter option -->
    <form method="POST">
        <table class="table-responsive table-striped">
            <thead>
                <?php
                if ($role_no== '100' || '99') {
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
                   if ($role_no == '100') {
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
                    <td> <input type="date" id="date" class="startdate" name="startdate" value="<?php echo date('Y-m-d'); ?>"></td>
                            <td> <input type="date" id="date" class="enddate" name="enddate" value="<?php echo date('Y-m-d'); ?>"></td>
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
            <div id="organizationName">
                <h3 style="text-align:center; padding-top:40px"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h3>
            </div>
            <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
             </div>
                <div id="reporttitle">
                     <h5 style="text-align:center" id="reportTitle">Trial Balance </h5> 
                </div>
                
                <div id="AsOnDate">
                <p  style="text-align:center; font-weight:bold"> <?php echo "From  "; echo $startdate; ?> To <?php echo $enddate; ?></p> 
                </div>                                                            
            <div class="pull-right">
                <a id="Print" class="btn btn-danger print"></i>Print</a>
            </div>
            <br><br>
            <div id="mySelector">
                <table class="table table-hover table-striped" id="sampleTable">
                    <thead class="reportHead" style="background-color: green; width:'100%'">
                        <th>A/C Number </th>
                        <th>A/C Head </th>
                        <th>Debit Transction </th>
                        <th>Credit Transction</th>
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
                        while ($rows = $query->fetch_assoc()) {
                            $balance_dr = $balance_dr + $rows['dr_amt_loc'];
                            $balance_cr = $balance_cr + $rows['cr_amt_loc'];
                            echo
                            '<tr>
                                
                                <td style="text-align:left; width:10%">' . $rows['gl_acc_code'] . '</td>
                                <td style="text-align:left; width:50%">' . $rows['acc_head'] . '</td>
                                <td style="text-align:right; width:20%"">' . $rows['dr_amt_loc'] . '</td>
                                <td style="text-align:right; width:20%"">' . $rows['cr_amt_loc'] . '</td>
							</tr>';
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <?php
                        $sql2 = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM tran_details WHERE  (`tran_date` BETWEEN '$startdate' AND '$enddate') ORDER BY `tran_date`";
                        $returnD = mysqli_query($conn, $sql2);
                        $result = mysqli_fetch_assoc($returnD);
                        echo '<tr style="text-align:right; color:green; font-weight: bold; font-size: 16px">
                        <td></td>
                        <td>Current Total</td>
                        <td>TK ' . $balance_dr . '</td>
                        <td>TK ' . $balance_cr . '</td>  
                </tr>';
                        ?>
                        <tr style="text-align:right; color:blue; font-weight: bold; font-size: 16px">
                            <td colspan="1"></td>
                            <td colspan="1">Grand Total</td>
                            <td><strong> TK. <?php echo $result['debit']; ?></strong>
                            </td>
                            <td><strong> TK. <?php echo $result['credit']; ?></strong>
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
    <div style='padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $q; ?></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $b;?></div></div>
                </div>
    </div>
</main>
<?php
require "report_footer.php";
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
    // $(document).ready(function() {
    //     $('#sampleTable').DataTable();
    //     $(function() {
    //         //Initialize Select2 Elements
    //         $('.select2').select2()
    //     })
    //     // 
    //     $("#702000").addClass('active');
    //     $("#700000").addClass('active');
    //     $("#700000").addClass('is-expanded');
    //     // 
    //     $("#showDate").hide();
    //     $("#dateSubmit").click(function() {
    //         $("#showDate").show(1000);
    //     });
    // });
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
                   <div>
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
</body>

</html>