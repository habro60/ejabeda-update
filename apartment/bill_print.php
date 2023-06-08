<?php
require "../auth/auth.php";
require '../database.php';
require '../source/top.php';

require '../source/header.php';
require '../source/sidebar.php';

// session //
$office_code = $_SESSION['office_code'];
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_no      = $_SESSION['org_no'];
?>



<main class="app-content">
    <div class="app-title">
        <div style="width: 100%;">
            <h1><i class="fa fa-dashboard"></i> Bill Recite </h1>
        </div>
    </div>
    <form method="POST">
        <table class="table-responsive table-striped">
            <thead>
                <th> For Month</th>
                <th></th>
            </thead>
            <tbody>
                <tr>

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
    <div id="mySelector">
        <?php
        if (isset($_POST['submit'])) {
            $enddate = $conn->escape_string($_POST['enddate']);
            $org_fin_month =  $_SESSION["org_fin_month"];
            $sql="select org_addr1, org_tel from org_info";
            $return = mysqli_query($conn, $sql);
            $org_row = mysqli_fetch_assoc($return); 
        ?>
                  
            <div class="row" style="margin-bottom: 5px">
                <div class="col-12">
                    <div class="pull-center">
                        <a id="Print" class="btn btn-danger print"></i>Print</a>
                        
                    </div>
                </div>
            </div>
            <div id="mySelector">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-hover table-striped">
                           
                            <tbody>
                                <?php
                                $no='0';
                                $owner_id='0';
                                $flat_no='0';
                                $tot_bill_amt='0';



                                $sql1 = "SELECT org_info.org_name, org_info.org_addr1, org_info.org_tel, apart_owner_bill_detail.flat_no,apart_owner_bill_detail.bill_charge_code, apart_owner_bill_detail.bill_charge_name,apart_owner_bill_detail.bill_last_pay_date,apart_owner_bill_detail.bill_amount, apart_owner_info.owner_name, monthly_bill_entry.prev_unit,monthly_bill_entry.prev_unit_dt,monthly_bill_entry.curr_unit,monthly_bill_entry.curr_unit_dt,monthly_bill_entry.net_unit  FROM org_info, `apart_owner_bill_detail`, apart_owner_info, monthly_bill_entry where apart_owner_bill_detail.owner_id=apart_owner_info.owner_id and monthly_bill_entry.owner_id=apart_owner_bill_detail.owner_id and monthly_bill_entry.flat_no=apart_owner_bill_detail.flat_no order by apart_owner_bill_detail.flat_no, apart_owner_bill_detail.bill_charge_code";


                                // $sql1 = "SELECT org_info.org_name, org_info.org_addr1, org_info.org_tel, apart_owner_bill_detail.flat_no, apart_owner_bill_detail.bill_charge_name,apart_owner_bill_detail.bill_last_pay_date,apart_owner_bill_detail.bill_amount, apart_owner_info.owner_name  FROM org_info, `apart_owner_bill_detail`, apart_owner_info where apart_owner_bill_detail.owner_id=apart_owner_info.owner_id order by apart_owner_bill_detail.flat_no, apart_owner_bill_detail.bill_charge_code";
                                $query = $conn->query($sql1);
                                while ($rows = $query->fetch_assoc()) {
                                ?>
                                   <tbody>
                                   <tr style="background-color:white;">
                                      <td style="text-align: center" colspan="6"><?php if ($flat_no != $rows['flat_no']) { echo  "TOTAL BILL AMOUNT in TK.";}else {echo "";}?></td>
                                       <td style="text-align: right" colspan="6"><?php if ($flat_no != $rows['flat_no']) { echo  $tot_bill_amt;  $tot_bill_amt=0;}else {echo "";}?></td>
                                   </tr>
                                    <tr style="background-color:white;">
                                       <td style="text-align: center" colspan="12"><?php if ($flat_no != $rows['flat_no']) {  echo  $rows['org_name']; 
                                         echo "<br>";
                                         echo $org_row['org_addr1']; echo "    Telephon :" ; echo $org_row['org_tel'];  
                                         echo "<br>";
                                         echo "   Shop No. :"; echo $rows['flat_no']; echo "    Shop Name:";echo " "; echo $rows['owner_name']; } else { echo"";}  ?></td>
                                     </tr> 
                                       
                                         <tr style="background-color:white;">
                                   
                                         <td style="text-align: left" colspan="3"><?php echo  $rows['bill_charge_name']; ?> </td>
                                         <td style="text-align: left" colspan="3"><?php if ($rows['bill_charge_code']=='6') { echo  "Previous Unit:"; echo $rows['prev_unit'];echo ",  "; echo "Current Uint:"; echo $rows['curr_unit']; echo ", "; echo "Net Unit:"; echo $rows['net_unit'];}?></td>
                                         <td style="text-align: left" colspan="3"><?php echo  " TK"; ?> </td>
                                         <td style="text-align: right" colspan="3"><?php  echo $rows['bill_amount']; 
                                         $tot_bill_amt= $tot_bill_amt + $rows['bill_amount'];
                                         $flat_no=$rows['flat_no'];?></td>
                                         
                                         </tr>
                                     </div>
                                  </tbody> 
                       <?php     
                    }
                }
                
                else {
                        echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select Date</h1>";
                    }
                     ?>
                    
                        </table>
                    </div>
                    </div>
            </div>
</main>
<?php

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

    //  print js
$(document).on('click', '.print', function () {
 
    var organizationName = $('#organizationName').text();
    var organizationAdd = $('#organizationAdd').text(); 
    var ownername = $('#ownername').text();
    var reportTitle = $('#reportTitle').text();
    var billno = $('#billno').text();
    var header = `<div>
    	            <h1 style="text-align:center">${organizationName}</h1>
                    <h3 style="text-align:center">${organizationAdd}</h3>
                    </div>
                    <h1 style="text-align:center" id="reportTitle">${reportTitle}</h1>
                    <div>
                    <h2 style="text-align:left">${ownername}</h2>
                    </div>
                    <div>
                    <h2 style="text-align:left">${billno}</h2>
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