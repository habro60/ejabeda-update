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
            <h1><i class="fa fa-dashboard"></i>Account Statement</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- search -->
            <div class="scroll">
                <form method="POST">
                    <table class="table-responsive">
                        <thead>
                            <th>Account</th>
                            <th>From Date</th>
                            <th>To Date</th>
                        </thead>    
                        <tbody>
                            <tr>
                                <td>
                                    <select class="select2 form-control" name="account" id="accou" style="width: 150px;" >
                                        <option value="">---Select---</option>
                                        <?php
                                        $owner_id = $_SESSION['link_id'];
                                        $selectQuery = "SELECT * FROM `personal_account` where `owner_id`=$owner_id  ORDER by id";
                                        $selectQueryResult =  $conn->query($selectQuery);
                                        if ($selectQueryResult->num_rows) {
                                            while ($drrow = $selectQueryResult->fetch_assoc()) {
                                                echo '<option value="' . $drrow['id'] . '">'  . $drrow['acc_head'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
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

                    // $officeId = $_POST['officeId'];
                    $org_fin_year_st =  $_SESSION["org_fin_year_st"];
                    $account = $_POST['account'];
                    $startdate = $_POST['startdate'];
                    $enddate = $conn->escape_string($_POST['enddate']);
                    $open_bal_date = date('Y-m-d', strtotime($startdate . ' - 1 day'));
                 
                ?>
                    <div id="organizationName">
                    <?php 
                       $sql="SELECT apart_owner_info.owner_name,apart_owner_info.mobile_no, personal_account.owner_id from apart_owner_info, personal_account where personal_account.owner_id=apart_owner_info.owner_id";
                       $query2 = mysqli_query($conn, $sql);
                       $ownerRows = mysqli_fetch_assoc($query2);
                ?>
                <h3 style="text-align:center; padding-top:40px"><?php echo $ownerRows['owner_name']; ?></h3>
                    </div>
                   <div id="organizationAdd">
                    <h4 style="text-align:center"> <?php echo $org_addr1; ?></h4> 
                   </div>
                  <div id="reporttitle">
                     <h5 style="text-align:center" id="reportTitle">A/C Statement</h5> 
                </div>
                <div id="AsOnDate">
                    <p  style="text-align:center; font-weight:bold"> <?php echo "From:"; echo $startdate; ?> To <?php echo $enddate; ?></p> 
                </div>
                <div id="AccHead">
                    <h5 style="text-align:center" id="dateToDate"> Account :
                        <?php
                        if (!empty($account)) {
                            $selectAcc = "SELECT id,acc_head FROM personal_account WHERE id= $account";
                            $result = mysqli_query($conn, $selectAcc);
                            $data = mysqli_fetch_assoc($result);
                            echo $data['acc_head']; 
                        } else {
                             echo "all Account";

                         
                        }
                        ?>
                </div>
            <div class="pull-right">
                <a id="Print" class="btn btn-danger print"></i>Print</a>
            </div>
            <br> <br>
            <div id="mySelector">
                <table class="table table-hover table-striped" id="sampleTable">
                    <thead class="reportHead" style="background-color: green;">
                        <th>Date</th>
                        <th>Account</th>
                        <th>Particular</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </thead>
                    <tbody>
                        <?php
                        $sql_opbal = "SELECT SUM(`dr_amt_loc`) as `debit`, SUM(`cr_amt_loc`) AS `credit` FROM personal_ledger WHERE gl_acc_code='$account' AND (`tran_date` BETWEEN '$org_fin_year_st' AND '$open_bal_date') ORDER BY `tran_date`";
                        // echo $sql_opbal;
                        // exit;
                        $return_opbal = mysqli_query($conn, $sql_opbal);
                        $result_opbal = mysqli_fetch_assoc($return_opbal);
                        ?>
                        <tr style="font-weight:bold;color: red;text-align: right">
                            <td colspan="3">Opening Balance </td>
                            <td><?php echo $result_opbal['debit']; ?></td>
                            <td><?php echo $result_opbal['credit']; ?></td>
                            <td>
                                <?php echo $result_opbal['credit'] - $result_opbal['debit']; ?>
                            </td>
                        </tr>
                        <?php
                        $total_dr = 0;
                        $total_cr = 0;
                        if (!empty($account)) {
                            $sql = "SELECT personal_ledger.tran_no,personal_ledger.gl_acc_code,personal_ledger.tran_mode,personal_ledger.dr_amt_loc,personal_ledger.tran_date,personal_ledger.tran_mode,personal_ledger.description,personal_ledger.cr_amt_loc,personal_account.acc_head,personal_account.id,personal_ledger.cr_amt_loc-personal_ledger.dr_amt_loc as balance, @RunningBalance:= @RunningBalance + (personal_ledger.cr_amt_loc-personal_ledger.dr_amt_loc) as RunningBalance  FROM personal_ledger JOIN personal_account JOIN (SELECT @RunningBalance:= 0) r WHERE personal_ledger.gl_acc_code='$account' AND personal_ledger.owner_id='$owner_id' AND personal_ledger.gl_acc_code=personal_account.id AND (personal_ledger.tran_date BETWEEN '$org_fin_year_st' AND '$enddate') group by personal_ledger.tran_no order by personal_ledger.tran_date, personal_ledger.tran_no";
                        } else {
                            $sql = "SELECT personal_ledger.tran_no,personal_ledger.gl_acc_code,personal_ledger.tran_mode,personal_ledger.dr_amt_loc,personal_ledger.tran_date,personal_ledger.tran_mode,personal_ledger.description,personal_ledger.cr_amt_loc,personal_account.acc_head,personal_account.id,personal_ledger.cr_amt_loc-personal_ledger.dr_amt_loc as balance, @RunningBalance:= @RunningBalance + (personal_ledger.cr_amt_loc-personal_ledger.dr_amt_loc) as RunningBalance  FROM personal_ledger JOIN personal_account JOIN (SELECT @RunningBalance:= 0) r WHERE personal_ledger.gl_acc_code=personal_account.id AND (personal_ledger.tran_date BETWEEN '$org_fin_year_st' AND '$enddate') order by personal_ledger.tran_date, personal_ledger.tran_no";
                        }
                        $query = $conn->query($sql);
                        while ($rows = $query->fetch_assoc()) {
                            if ($rows['tran_date'] >= $startdate) {
                                $total_dr = $total_dr + $rows['dr_amt_loc'];
                                $total_cr = $total_cr + $rows['cr_amt_loc'];
                                echo
                                '<tr style="text-align:right">
                                <td>' . $rows['tran_date'] . '</td>
                                <td>' . $rows['acc_head'] . '</td>
                                <td>' . $rows['description'] . '</td>
                                <td>' . $rows['dr_amt_loc'] . '</td>
                                <td>' . $rows['cr_amt_loc'] . '</td>
                                 <td><strong>' . $rows['RunningBalance'] . '</strong></td>
                            </tr>';
                            }
                        } ?>
                        <tr style="font-weight:bold" class="text-right">
                            <td colspan="3">Sub Total</td>
                            <td>TK.<?php echo $total_dr; ?></td>
                            <td>TK.<?php echo $total_cr; ?></td>
                            <td><strong> TK. <?php echo ($total_cr - $total_dr); ?></strong>
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        
                    <?php
                } else {
                    echo "<h3 style='color:red;text-align:center;margin-top:150px'>Please Select Account and Date</h3>";
                }
                    ?>
                    </tfoot>
                </table>
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
        $("#703000").addClass('active');
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
    var AccHead = $('#AccHead').text();
    var header = `<div>
    	            <h3 style="text-align:center">${organizationName}</h3>
                    <h4 style="text-align:center">${organizationAdd}</h4>
                    </div>
                    <h5 style="text-align:center" id="reportTitle">${reportTitle}</h5>
                    </div>
                    
                    <div>
                    <p style="text-align:center; font-weight:bold">${AsOnDate}</p>
                    </div>
                    <div>
                    <p style="text-align:center; font-weight:bold">${AccHead}</p>
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