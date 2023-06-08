<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Due Slip</h1>
        </div>
    </div>
    <div class="row">
       <div class="col-md-12">
            <?php 
                // $officeId = $_SESSION['officeId'];
                $footer1=        $_SESSION['org_rep_footer1'];
                $footer2=        $_SESSION['org_rep_footer2'];
                $org_name    = $_SESSION['org_name'];
                $org_addr1 = $_SESSION['org_addr1'];
                $org_email = $_SESSION['org_email'];
                $org_tel = $_SESSION['org_tel'];
                $org_logo    = $_SESSION['org_logo'];
            ?>
            <?php

            if (isset($_GET['flat_no'])) {
            $flat_no = intval($_GET['flat_no']);
            $enddate = $_GET['last_paid_date'];
            $submitDate= date('d-m-y');
            
            $sql= "SELECT dokan_vara_detail.flat_no, dokan_vara_detail.fund_type_desc, dokan_vara_detail.num_of_paid, flat_info.flat_no,flat_info.flat_title, dokan_vara_detail.donner_paid_amt, DATEDIFF('$enddate', dokan_vara_detail.last_paid_date) AS due_days,dokan_vara_detail.last_paid_date, dokan_vara_detail.donner_pay_amt from dokan_vara_detail,flat_info where dokan_vara_detail.flat_no=flat_info.flat_no and dokan_vara_detail.flat_no=flat_info.flat_no and dokan_vara_detail.last_paid_date <= '$enddate' order by flat_info.flat_no";
            $Query = $conn->query($sql);
            $rows = $Query->fetch_assoc();

            }
        ?>
                <div id="organizationName">
                    <h3 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h3> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <div id="reporttitle">
                     <h5 style="text-align:center" id="reportTitle">Due Slip</h5> 
                </div>
                <div id="memberName">
                    <h5 style="text-align:center"> <?php echo "Dokan Name:"; echo $rows['flat_no']; echo "  "; echo $rows['flat_title']; ?></h5> 
                </div>
                
                <div id="billno">
                    <h4  style="text-align:center"> <?php echo "As on Date:"; echo $submitDate; ?></h4> 
                </div>
                <div class="pull-right">
                    <a id="Print" class="btn btn-success print" target="_blank"></i>Print Due Slip</a>
                </div>
                <!-- report view option -->
                <br><br>
                <?php
                        $owner_id = 0;
                        $tot_cr_amt =0.00;
                        $tot_dr_amt=0.00;
                 ?>
                <div id="mySelector">
                    
                <table  class="table table-hover table-bordered" width="100%" id="memberTable">
                      <thead class="reportHead" style="background-color: lightgray; width:100%">
                            <tr>
                                <th>Partculars</th>
                                <th>From date </th>
                                <th>To Date</th>
                                <th>Due Daya & Rate</th>
                                <th>Total Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              
                               $total_bill='0';
                               $no='1';
                               $sql= "SELECT
                               dokan_vara_detail.office_code,
                               dokan_vara_detail.flat_no,
                               dokan_vara_detail.`fund_type`,
                               dokan_vara_detail.`fund_type_desc`,
                               dokan_vara_detail.donner_pay_amt,
                               dokan_vara_detail.num_of_pay,
                               dokan_vara_detail.last_paid_date,
                               dokan_vara_detail.num_of_paid,
                               dokan_vara_detail.pay_curr,
                               dokan_vara_detail.fund_paid_flag,
                               flat_info.flat_no,
                               flat_info.flat_title,
                               code_master.softcode,
                               code_master.hardcode,
                               code_master.description,
                               DATEDIFF('$enddate', dokan_vara_detail.last_paid_date) AS due_days
                           FROM
                               dokan_vara_detail,
                               flat_info,
                               code_master
                           WHERE
                           code_master.hardcode='CURT' and code_master.softcode=dokan_vara_detail.pay_curr and dokan_vara_detail.flat_no=flat_info.flat_no and  dokan_vara_detail.last_paid_date <= '$enddate'and flat_info.flat_no='$flat_no'";
                           
                                 $Query = $conn->query($sql);
                                //  bill_for_month='$bill_for_month'";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) {
                                ?>
                     
                               <tr>
                                <td style="text-align: left" width="20%"><?php  echo $row['fund_type_desc'];  ?></td>
                                <td style="text-align: left" width="20%"><?php echo $row['last_paid_date'];  ?></td>
                                <td style="text-align: left" width="20%"><?php  echo $enddate;  ?></td>
                                <td style="text-align: left" width="20%"><?php echo $row['due_days']; echo "  Days @ TK." ; echo $row['donner_pay_amt']; $tran_amt= $row['due_days'] * $row['donner_pay_amt']; ?></td>
                                <td style="text-align: right" width="20%"><?php  echo $tran_amt; $total_bill= $total_bill + $tran_amt;?></td>
                               </tr>
                               
                                <?php
                                }
                              ?>           
                        </tbody>
                        <tfoot>
                            <tr style="background-color:powderblue";>
                                <th style="text-align:right" colspan="4"> Total Amount in TK.</th>
                                <th style="text-align:right" colspan="1"><?php echo $total_bill; ?></th>
                            </tr>
                        </tfoot>
                        </table>
                                
              <div style=
                'padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $footer1; ?></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $footer2;?></div></div>
                <?php        
                require "report_footer.php";
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
    var memberName = $('#memberName').text();
    var reportTitle = $('#reportTitle').text();
    var billno = $('#billno').text();
    var header = `<div>
    	            <h3 style="text-align:center">${organizationName}</h3>
                    <h4 style="text-align:center">${organizationAdd}</h4>
                    </div>
                    <h5 style="text-align:center" id="reportTitle">${reportTitle}</h5>
                    <div>
                    <h5 style="text-align:left">${memberName}</h5>
                    </div>
                    <div>
                    <h5 style="text-align:left">${billno}</h5>
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