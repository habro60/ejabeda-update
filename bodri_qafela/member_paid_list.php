<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";

ini_set('display_errors', 0);


$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
$member_id= $_SESSION['link_id'];

$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Fund Paid List</h1>
        </div>
    </div>
    <div class="row">
    <div class="col-md-12">
        <form method="POST">
            
        <table id="submit">
            <form method="POST">
                    <td> From: <input type="date" name="startdate" id="" class="form-control" required></td>
                    <td> To: <input type="date" name="enddate" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    
            if (isset($_POST['submit'])) {
                
                // $officeId = $_SESSION['officeId'];
                $org_name    = $_SESSION['org_name'];
                $org_addr1 = $_SESSION['org_addr1'];
                $org_email = $_SESSION['org_email'];
                $org_tel = $_SESSION['org_tel'];
                $org_logo    = $_SESSION['org_logo'];
                $startdate = $_POST["startdate"];
                $enddate = $conn->escape_string($_POST["enddate"]);

            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h3 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h3> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <h5 style="text-align:center" id="reportTitle">Fund Paid Report</h5>
                <div id="AsOnDate">
                    <p  style="text-align:center; font-weight:bold"> <?php echo "From "; echo $startdate; ?> To <?php echo $enddate; ?></p> 
                </div>
               
                <div class="pull-right">
                    <a id="Print" class="btn btn-danger print" target="_blank"></i>Print</a>
                </div>
                <!-- report view option -->
                <br><br>
                <?php
                        $d = 0;
                        $no = 1;
                        $owner_id = 0;
                        $batch_no = 0;
                        $tot_cr_amt =0.00;
                        $tot_dr_amt=0.00;
            
                if (isset($_POST['submit'])) {
                    
                    $startdate = $_POST['startdate'];
                    $enddate = $conn->escape_string($_POST['enddate']);
                    $query = "SELECT  fund_member.member_id, fund_member.full_name,fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.member_id = '$member_id' and gl_acc_code.acc_code=fund_member.gl_acc_code";
                    $rows = mysqli_query($conn, $query);
                    $result = mysqli_fetch_assoc($rows);
                    $gl_acc_code =$result['acc_code'];
                    
                    

                            $sql="SELECT  fund_receive_detail.office_code,fund_receive_detail.member_id,fund_receive_detail.batch_no,fund_receive_detail.paid_date,fund_receive_detail.fund_type, fund_receive_detail.paid_amount,fund_receive_detail.due_amount,fund_receive_detail.waiver_amount, tran_details.batch_no,tran_details.tran_date,tran_details.gl_acc_code, tran_details.cr_amt_loc,  fund_member.full_name, donner_fund_detail.fund_type_desc, donner_fund_detail.num_of_pay,donner_fund_detail.donner_pay_amt,donner_fund_detail.num_of_paid from fund_receive_detail, tran_details, fund_member, donner_fund_detail where tran_details.batch_no=fund_receive_detail.batch_no and tran_details.gl_acc_code=fund_receive_detail.gl_acc_code and fund_receive_detail.member_id=fund_member.member_id and donner_fund_detail.member_id=fund_receive_detail.member_id and donner_fund_detail.fund_type=fund_receive_detail.fund_type and fund_receive_detail.gl_acc_code = '$gl_acc_code'and (fund_receive_detail.paid_date between '$startdate' and '$enddate')";

                    $all_total_amount_sql = "SELECT SUM(donner_pay_amt) AS total_donner_pay_amt,SUM(donner_paid_amt) AS total_donner_paid_amt,SUM(due_amt) AS total_due_amount,Sum(waiver_amt) AS total_waiver_amt FROM `donner_fund_detail` WHERE gl_acc_code='$gl_acc_code' AND allow_flag=1";

                        
                $query = $conn->query($sql);
                ?>
                <div id="mySelector">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">

                        <th >Sl.NO.</th>
                    <th>Tran Date</th>
                    <th>Voucher No.</th>
                    <th>Donner Name</th>
                    <th>Fund Name</th>
                    <th>To be Pay</th>
                    <th>Paid Amount</th>
                    <th>Total Paid Amount</th>

                        </thead>

                        <body>
                            
                            <?php
                            while ($rows = $query->fetch_assoc()) {
                            ?>
                               <tr>
                      <td style="text-align: right"><?php if ($rows['batch_no'] > $batch_no) {
                                                            echo $no++; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                       <td style="text-align: center"><?php if ($rows['batch_no'] > $batch_no) {
                                                            echo $rows['tran_date']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                     
                     
                        <td style="text-align: center"><?php if ($rows['batch_no'] > $batch_no) {
                                                            echo $rows['batch_no']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>
                    
                     <td style="text-align: center"><?php if ($rows['batch_no'] > $batch_no) {
                                                            echo $rows['full_name']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                    
                         <td style="background-color:powderblue; text-align: right"><?php echo $rows['fund_type_desc']; ?></td>
                                   
                         <td style="background-color:powderblue; text-align: right"><?php echo $rows['donner_pay_amt']; ?></td> 
                         
                         <td style="background-color:lightgray; text-align: right"><?php echo $rows['paid_amount']; ?></td>                                        
                                                                                                    
                         <td style="text-align: right"><?php if ($rows['batch_no'] > $batch_no) {
                                                            echo $rows['cr_amt_loc']; 
                                                            $tot_cr_amt = $tot_cr_amt + $rows['cr_amt_loc'];
                                                            $batch_no = $rows['batch_no'];
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                              
                 </tr>
                        <?php
                            }
                        }
                            ?>

                      <tfoot>
                        <tr style="background-color:powderblue";>
                                <th style="text-align:right" colspan="7"> Total Amount in TK.</th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_cr_amt; ?></th> 
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
    	            <h3 style="text-align:center">${organizationName}</h3>
                    <h4 style="text-align:center">${organizationAdd}</h4>
                 </div>
                    <h5 style="text-align:center" id="reportTitle">${reportTitle}</h5>;
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