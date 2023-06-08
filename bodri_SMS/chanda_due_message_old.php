<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";
if (empty($member_id)) {
    $sql2 = "SELECT  fund_member.member_id, fund_member.full_name,fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.gl_acc_code = gl_acc_code.acc_code ORDER BY fund_member.member_id";
} else {
    $sql2 = "SELECT  fund_member.member_id, fund_member.full_name,fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.member_id = '$member_id' and gl_acc_code.acc_code=fund_member.gl_acc_code ORDER BY fund_member.member_id; ";
}

$role_no     = 99; // admin 99 superadmin 100
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100

$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>

<main class="app-content">
    <!-- page title -->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Chanda Due Message</h1>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-12">
            <!-- filter option -->
            <form method="POST">
            <?php if (empty($member_id)) {
    ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td>Owner : <select class="form-control grand" name="member_id">
                            <option value="">--- Select Owner ---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `fund_member`";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($drrow = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $drrow['member_id'] . '">'  . $drrow['full_name'] . '</option>';
                                }
                            }
                            ?>
                          </select></td>
                    <td> As on Date: <input type="date" name="enddate" id="" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
                    <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    } elseif (!empty($member_id)) { ?>
        <table id="submit">
            <form method="POST">
                      <tr>
                            <td>
                               <td> <input type="text" name="owner_name" id="" class="form-control" value="<?php echo $row['full_name']; ?>" readonly></td>
                                <td>As on Date: <input type="date" name="enddate" id="" class="form-control" value="<?php echo date('Y-m-d'); ?>"readonly>
                            <td>
                                <input type="submit" name="submit" id="submitBtn" class="btn btn-info" value="Report View">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <!-- end filter option -->
            <?php
            } ?>
            <?php
            if (isset($_POST['submit'])) {
                
                // $officeId = $_SESSION['officeId'];
                $org_name    = $_SESSION['org_name'];
                $org_addr1 = $_SESSION['org_addr1'];
                $org_email = $_SESSION['org_email'];
                $org_tel = $_SESSION['org_tel'];
                $org_logo    = $_SESSION['org_logo'];
                $enddate = $conn->escape_string($_POST['enddate']);
            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <h4 style="text-align:center" id="reportTitle">Chanda Due Report</h4>
                <div id="AsOnDate">
                    <h4  style="text-align:center"> <?php echo 'AS On Date';echo  ":"; echo date('Y-m-d'); ?></h4> 
                </div>
                <div class="pull-right">
                <a id='SMS' title="Send SMS" class="btn btn-success" href="SMS_fund_due.php"></i>Due SMS</a>
                    <!-- <a id="Print" class="btn btn-danger print" target="_blank"></i>Print</a> -->
                </div>


                <!-- report view option -->
                <br><br>
                <?php
                        $d = 0;
                        $no = 1;
                        $mem_id = 0;
                        $tot_due_amt =0.00;
                        $tot_paid_amt=0.00;
            
                if (isset($_POST['submit'])) {
                    $enddate = 'curdate()';
                    // $enddate = $conn->escape_string($_POST['enddate']);
                    $member_id = $conn->escape_string($_POST['member_id']);
                    if (empty($member_id)) {
                            $sql="SELECT donner_fund_detail.member_id, donner_fund_detail.fund_type_desc, donner_fund_detail.num_of_paid, fund_member.member_no, fund_member.full_name, donner_fund_detail.donner_paid_amt, (12 * (YEAR('$enddate') 
                            - YEAR(last_paid_date)) 
                     + (MONTH('$enddate') 
                         - MONTH(last_paid_date)))  as due_month, sum(mthly_rate_setup.rate_amt) as pay_amt from donner_fund_detail,fund_member, mthly_rate_setup where (mthly_rate_setup.rate_date > donner_fund_detail.last_paid_date and mthly_rate_setup.rate_date  <= '$enddate') and donner_fund_detail.member_id=fund_member.member_id and allow_flag >'0' and donner_fund_detail.last_paid_date <= '$enddate' group by fund_member.member_no order by fund_member.member_no"; 

                        }else {

                            $sql="SELECT donner_fund_detail.member_id, donner_fund_detail.fund_type_desc, donner_fund_detail.num_of_paid, fund_member.member_no,fund_member.full_name, donner_fund_detail.donner_paid_amt, (12 * (YEAR('$enddate') 
                            - YEAR(last_paid_date)) 
                     + (MONTH('$enddate') 
                         - MONTH(last_paid_date)))  as due_month, sum(mthly_rate_setup.rate_amt) as pay_amt from donner_fund_detail,fund_member where (mthly_rate_setup.rate_date > donner_fund_detail.last_paid_date and mthly_rate_setup.rate_date  <= '$enddate') and donner_fund_detail.member_id=fund_member.member_id and allow_flag >'0' and donner_fund_detail.member_id='$member_id' and donner_fund_detail.last_paid_date <= '$enddate' group by fund_member.member_no order by fund_member.member_no";

                        }
                $query = $conn->query($sql);
                ?>
                <div id="mySelector">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">

                    <tr style="background-color:powderblue; text-align: center";>           
                    <th >Sl.NO.</th>
                    <th>Member No.</th>
                    <th>Member Name</th>
                    <th>Paid Amount</th>
                    <th>Due No. of Month</th>
                    <th>Due Amount</th>
                  </tr>
                </thead>

                        <body>
                            
                            <?php
                            while ($rows = $query->fetch_assoc()) {
                            ?>
                                <tr>
                     <td style="text-align: right"><?php if ($rows['member_id'] !=$mem_id) {
                                                           echo $no++; 
                                                       } else {
                                                           echo "";
                                                       }?></td>  
                    <td style="background-color:powderblue; text-align: right"><?php echo $rows['member_no']; ?></td>
                    <td style="text-align: center"><?php if ($rows['member_id'] != $mem_id) {
                                                           echo $rows['full_name']; 
                                                           $mem_id=$rows['member_id'];
                                                       } else {
                                                           echo "";
                                                       }?></td>  
                   
                                  
                                                                                         
                        <!-- <td style="background-color:lightgray; text-align: right"><?php echo $rows['num_of_paid']; ?></td>   -->
                        <td style="background-color:lightgray; text-align: right"><?php $tot_paid_amt = $tot_paid_amt + $rows['donner_paid_amt']; echo $rows['donner_paid_amt']; ?></td>   
                        <td style="background-color:white; text-align: center"><?php echo $rows['due_month']; ?></td>  
                        <td style="background-color:white; text-align: right"><?php $due_amt = $rows['pay_amt'] ; $tot_due_amt = $tot_due_amt + $due_amt; echo $due_amt;  ?></td>                                                                        
                         
                             
                </tr>
                        <?php
                            }
                        }
                            ?>

                      <tfoot>
                        <tr style="background-color:powderblue";>
                                <th style="text-align:right" colspan="3"> Total Amount in TK.</th>
                                <th style="text-align:right" colspan="2"><?php echo $tot_paid_amt; ?></th>
                                <th style="text-align:right" colspan="2"><?php echo $tot_due_amt; ?></th>  
                            </tr>
                        </tfoot>
                        </body>
                        
                    </table>
                   
              <div style=
                'padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $q; ?></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $b;?></div></div>
                <?php
                require "report_footer.php";
                ?>
            <?php
            } else {
                echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select From Date and To Date</h1>";
            }
            ?>
            
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
    var organizationAdd = $('#organizationAdd').text();
    var reportTitle = $('#reportTitle').text();
    var AsOnDate = $('#AsOnDate').text();
    var header = `<div>
    	            <h1 style="text-align:center">${organizationName}</h1>
                    <h3 style="text-align:center">${organizationAdd}</h3>
                 </div>
                    <h1 style="text-align:center" id="reportTitle">${reportTitle}</h1>;
                    <h1 style="text-align:center" id="reportTitle">${AsOnDate}</h1>`;
                    
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