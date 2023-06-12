<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
// $pid= 701000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";


$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
$office_code = $_SESSION['office_code'];
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_no      = $_SESSION['org_no'];
$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>

<style>
   @page {
       @bottom-left {
            content: counter(page) "/" counter(pages);
        }
     }
</style>

<main class="app-content">
    <div id="content">
    <div id="pageFooter">
    <!-- page title -->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Journal</h1>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-12">
            <!-- filter option -->
            <form method="POST">
                <table class="table-responsive">
                    <thead>
                        <?php
                        if ($role_no== '100' || '99') {
                        ?>
                        <th>Office</th>
                        <?php 
                        }
                        ?>
                        <th>From Date </th>
                        <th>To Date</th>
                    </thead>
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
            <?php
            if (isset($_POST['submit'])) {
                $officeId = $_POST['officeId'];
                $startdate = $_POST['startdate'];
                $enddate = $conn->escape_string($_POST['enddate']);
                $org_fin_month =  $_SESSION["org_fin_month"];
                $sql2 = "SELECT `org_logo`, `org_name` FROM `org_info`";
                $returnD = mysqli_query($conn, $sql2);
                $result = mysqli_fetch_assoc($returnD);
            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h2 style="text-align:center"><img src="../upload/<?php echo $result['org_logo']; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $result['org_name']; ?></h2>
                </div>
                <h4 style="text-align:center" id="reportTitle">Journal Statement</h4>
                <h5 style="text-align: center" id="dateToDate">From <?php echo $startdate; ?> To <?php echo $enddate; ?></h5>
                <!-- end report header -->
                <!-- report view option -->
                <div class="pull-right">
                    <a id="Print" class="btn btn-danger print" target="_blank"></i>Print</a>
                </div>
                <!-- report view option -->
                <br><br>
                <?php
                
                if (!empty($officeId)) {
                    $sql = "SELECT tran_details.batch_no,tran_details.tran_no,tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,tran_details.ss_creator,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.office_code='$officeId' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') ORDER BY tran_details.tran_date,tran_details.tran_no";
                } else {
                    $sql = "SELECT tran_details.batch_no,tran_details.tran_no,tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,tran_details.ss_creator,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code  AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') ORDER BY tran_details.tran_date,tran_details.tran_no";
                }
                $query = $conn->query($sql);
                ?>
                <div id="mySelector">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">
                            <th>Date</th>
                            <th>Entry By</th>
                            <th> type </th>
                            <th>Trans. No </th>
                            <th>Voucher No. </th>
                            <th>A/C </th>
                            <th>A/Head </th>
                            <th>Particular </th>
                            <th>Debit </th>
                            <th>Credit</th>
                            <th class='action'>Action</th>
                        </thead>

                        <body>
                            <?php
                            $dr_tot = 0;
                            $cr_tot = 0;
                            while ($rows = $query->fetch_assoc()) {
                                echo
                                "<tr>
                            <td>" . $rows['tran_date'] . "</td>
                            <td>" . $rows['ss_creator'] . "</td>
                            <td>" . $rows['tran_mode'] . "</td>
                            <td>" . $rows['tran_no'] . "</td>
                            <td>" . $rows['batch_no'] . "</td> 
                            <td>" . $rows['gl_acc_code'] . "</td>
                            <td>" . $rows['acc_head'] . "</td>
                            <td>" . $rows['description'] . "</td>"
                             ?>

                            <td> <?php echo $rows['dr_amt_loc']; $dr_tot = $dr_tot + $rows['dr_amt_loc'];?></td>
                            <td> <?php  echo $rows['cr_amt_loc']; $cr_tot = $cr_tot + $rows['cr_amt_loc'];?></td>

                            <td> <a id='print' title="Print Voucher" class="btn btn-success" href="voucher_view.php?recortid=<?php echo  $rows['batch_no']; ?>"></i>Print voucher</a></td>

                            <!-- <td class='action'>
                            <a href='voucher_view.php?recortid=" . $rows['batch_no'] . "' target='blank' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span>Voucher</a>
                            </td> -->
                        </tr>
                           <?php
                            }
                            ?>
                        </body>
                        <tfoot>
                           <tr style="text-align: right; font-weight:bold">
                                        <td colspan="7">Total</td>
                                        <td><?php echo $dr_tot; ?></td>
                                        <td><?php echo $cr_tot; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php
            } else {
                echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select From Date and To Date</h1>";
            }
            ?>
        </div>
    </div>
    <div style=
                'padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $q; ?></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $b;?></div></div>
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
<script type="text/javascript">

// print js
$(document).on('click', '.print', function () {
 
    var organizationName = $('#organizationName').text();
    var reportTitle = $('#reportTitle').text();
    var dateToDate = $('#dateToDate').text();
    var header = `<div>
    	<h2 style="text-align:center">
		${organizationName}
        </h2>
    </div>
<h4 style="text-align:center" id="reportTitle">${reportTitle}</h4>
<h5 style="text-align: center">${dateToDate}</h5>`;

    $("#mySelector").printThis({
        debug: false,               // show the iframe for debugging
        importCSS: true,            // import parent page css
        importStyle: false,         // import style tags
        printContainer: true,       // print outer container/$.selector
        loadCSS: 'http://ejabeda.com/css/print.css', // path to additional css file - use an array [] for multiple
        pageTitle: 'null',              // add title to print page
        removeInline: false,        // remove inline styles from print elements
        removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
        printDelay: 333,            // variable print delay
        header: header,               // prefix to html
        footer: '<h6 style="text-align:center">Design and Development by Habro System Ltd.</h6>',               // postfix to html
        base: false,                // preserve the BASE tag or accept a string for the URL
        formValues: true,           // preserve input/form values
        canvas: false,              // copy canvas content
        doctypeString: '...',       // enter a different doctype for older markup
        removeScripts: false,       // remove script tags from print content
        copyTagClasses: false,      // copy classes from the html & body tag
        beforePrintEvent: null,     // function for printEvent in iframe
        beforePrint: null,          // function called before iframe is filled
        afterPrint: null            // function called before iframe is removed
    });
});
// 

    // $('#sampleTable').DataTable();
    $(document).ready(function() {
        $("#701000").addClass('active');
        $("#700000").addClass('active');
        $("#700000").addClass('is-expanded');
    });
</script>




</body>

</html>