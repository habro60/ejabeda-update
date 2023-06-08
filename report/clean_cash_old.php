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
        <h1><i class="fa fa-dashboard"></i> Clean Cash Report </h1>
    </div>
    <!--  filter option -->
    <form method="POST">
        <table class="table-responsive">
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
            <div id="organizationName">
                <h3 style="text-align:center; padding-top:40px"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:20px;height:20px;"> <?php echo $org_name; ?></h3>
            </div>
            <div id="organizationAdd">
                    <h4 style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
             </div>
                <div id="reporttitle">
                     <h5 style="text-align:center" id="reportTitle">Clean Cash Report</h5> 
                </div>
                <div id="AsOnDate">
                    <p  style="text-align:center; font-weight:bold"> <?php echo "From:"; echo $startdate; ?> To <?php echo $enddate; ?></p> 
                </div>
            </div>
             <div class="row" style="margin-bottom: 5px">
                <div class="col-12">
                    <div class="pull-right">
                        <a id="Print" class="btn btn-danger print"></i>Print</a> 
                    </div>
                </div>
            </div> 
                </div>
                <br>
                <div id="mySelector">
                    <div class="row">
                        <div class="cols6">
                            <table class="table table-hover table-striped" id="sampleTable">
                                <thead class="reportHead" style="background-color: green;">
                                <tr style="text-align:center">
                                            <th colspan="4">Income</th>
                                        </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>A/C Code</th>
                                        <th>Title</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($officeId)) {
                                        $sql = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.cr_amt_loc-tran_details.dr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.office_code='$officeId' AND (gl_acc_code.category_code='3' or gl_acc_code.category_code='1') AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and (tran_details.dr_amt_loc is not NULL or tran_details.dr_amt_loc is NULL) and (tran_details.cr_amt_loc is not NULL or tran_details.cr_amt_loc is NULL) group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
                                    } else {
                                        $sql = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.cr_amt_loc-tran_details.dr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND (gl_acc_code.category_code='3' or gl_acc_code.category_code='1') AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and (tran_details.dr_amt_loc is not NULL or tran_details.dr_amt_loc is NULL) and (tran_details.cr_amt_loc is not NULL or tran_details.cr_amt_loc is NULL) group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
                                    }
                                    $query = $conn->query($sql);
                                    $tot = 0;
                                    while ($row = $query->fetch_assoc()) {
                                        $tot = $tot + $row['balance'];
                                    ?>
                                        <tr>
                                            <td><?php echo $row['tran_date']; ?></td>
                                            <td><?php echo $row['acc_code']; ?></td>
                                            <td><?php echo $row['acc_head']; ?></td>
                                            <td style="text-align: right"><?php echo $row['balance']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <?php
                                    $sql1="SELECT SUM(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as opcash,gl_acc_code.acc_type  FROM tran_details, gl_acc_code where gl_acc_code.acc_code=tran_details.gl_acc_code and (tran_details.tran_date BETWEEN '$org_fin_year_st' AND '$startdate') and gl_acc_code.acc_type='1'";
                                    $query1 = mysqli_query($conn, $sql1);
                                    $cashrows = mysqli_fetch_assoc($query1);

                                    $sql2="SELECT SUM(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as opbank,gl_acc_code.acc_type  FROM tran_details, gl_acc_code where gl_acc_code.acc_code=tran_details.gl_acc_code and (tran_details.tran_date BETWEEN '$org_fin_year_st' AND '$startdate') and gl_acc_code.acc_type='2'";
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
                            <div id="mySelector">
                                <table class="table table-hover table-striped" id="sampleTable">
                                    <thead class="reportHead" style="background-color: gray;">
                                        <tr style="text-align:center">
                                            <th colspan="4">Expenditure</th>
                                        </tr>
                                        <th>Date</th>
                                        <th>A/C Code</th>
                                        <th>Title</th>
                                        <th>Balance</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($officeId)) {
                                            $sqls = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.dr_amt_loc-tran_details.cr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.office_code='$officeId' AND (gl_acc_code.category_code='4' or gl_acc_code.category_code='2') AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
                                        } else {
                                            $sqls = "SELECT tran_details.tran_no,tran_details.batch_no,tran_details.gl_acc_code,tran_details.tran_mode,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.category_code, gl_acc_code.acc_head,gl_acc_code.acc_code, SUM(tran_details.dr_amt_loc-tran_details.cr_amt_loc) as balance FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND (gl_acc_code.category_code='4' or gl_acc_code.category_code='2') AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') group by tran_details.gl_acc_code order by tran_details.gl_acc_code";
                                        }
                                        $querys = $conn->query($sqls);
                                        $tot_ex = 0;
                                        while ($rows = $querys->fetch_assoc()) {
                                            $tot_ex = $tot_ex + $rows['balance'];
                                        ?>
                                            <tr>
                                                <td><?php echo $rows['tran_date']; ?></td>
                                                <td><?php echo $rows['acc_code']; ?></td>
                                                <td><?php echo $rows['acc_head']; ?></td>
                                                <td style="text-align: right"><?php echo $rows['balance']; ?></td>
                                            </tr>
                                        <?php
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <?php
                                    $sq3="SELECT SUM(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as closecash,gl_acc_code.acc_type  FROM tran_details, gl_acc_code where gl_acc_code.acc_code=tran_details.gl_acc_code and (tran_details.tran_date BETWEEN '$org_fin_year_st' AND '$enddate') and gl_acc_code.acc_type='1'";
                                    $query = mysqli_query($conn, $sq3);
                                    $cashrows = mysqli_fetch_assoc($query);

                                    $sql4="SELECT SUM(tran_details.dr_amt_loc - tran_details.cr_amt_loc) as closebank,gl_acc_code.acc_type  FROM tran_details, gl_acc_code where gl_acc_code.acc_code=tran_details.gl_acc_code and (tran_details.tran_date BETWEEN '$org_fin_year_st' AND '$enddate') and gl_acc_code.acc_type='2'";
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
                    <div style=
                'padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $q; ?></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $b;?></div></div>
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

</body>

</html>