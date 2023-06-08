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
            <h1><i class="fa fa-dashboard"></i>Money Received Bill Issue</h1>
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
            $flat_no = $_GET['flat_no'];
            $bill_for_month = $_GET['bill_for_month'];
            
            $sql= "SELECT apart_owner_info.owner_name, flat_info.flat_no FROM `apart_owner_info`,flat_info
             WHERE apart_owner_info.owner_id=flat_info.owner_id and flat_info.flat_no='$flat_no'";
            $Query = $conn->query($sql);
            $rows = $Query->fetch_assoc();

            $sql= "SELECT apart_owner_bill_detail.id, apart_owner_bill_detail.flat_no, apart_owner_bill_detail.batch_no, 
            apart_owner_bill_detail.bill_for_month, apart_owner_info.owner_name 
            FROM `apart_owner_bill_detail`, apart_owner_info 
            WHERE apart_owner_bill_detail.flat_no='$flat_no' and  apart_owner_bill_detail.bill_for_month='$bill_for_month' 
            and apart_owner_bill_detail.owner_id=apart_owner_info.owner_id group by apart_owner_bill_detail.flat_no";
            $Query = $conn->query($sql);
            $billrows = $Query->fetch_assoc();
            }
        ?>
                <div id="organizationName">
                    <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h3> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <div id="reporttitle">
                     <h5 style="text-align:center" id="reportTitle"> Money Recite</h5> 
                </div>
                <div id="ownername">
                    <h5 style="text-align:center"> <?php echo "Bill To :"; echo $billrows['owner_name']; ?></h5> 
                </div>
                
                <div id="billno">
                    <h4  style="text-align:center"> <?php echo "Bill No.:"; echo $billrows['batch_no']; echo "  "; echo "For Month:"; echo date('F, Y', strtotime($billrows['bill_for_month'])); ?></h4> 
                </div>
                <div class="pull-right">
                    <a id="Print" class="btn btn-success print" target="_blank"></i>Print bill</a>
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
                                <th>Sl No. </th>
                                <th>Service Name</th>
                                <th>Bill Status</th>
                                <th>Elec.Bill Details</th>
                                <th>Bill amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              
                               $total_bill='0';
                               $no='1';
                                // $sql = "SELECT * from apart_owner_bill_detail where flat_no='$flat_no'  and bill_for_month='$bill_for_month'";

                                $sql="SELECT apart_owner_bill_detail.bill_charge_code,
                                apart_owner_bill_detail.bill_charge_name,apart_owner_bill_detail.bill_amount,apart_owner_bill_detail.bill_paid_date,
                                apart_owner_bill_detail.prev_unit,apart_owner_bill_detail.curr_unit, apart_owner_bill_detail.net_unit,apart_owner_bill_detail.bill_paid_flag,apart_owner_bill_detail.per_unit_rate,apart_owner_bill_detail.vat_rate,apart_owner_bill_detail.fixed_rent
                                 
                                 from apart_owner_bill_detail where flat_no='$flat_no'  and bill_for_month='$bill_for_month'";
                                // echo $sql;
                                // exit;
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) {
                                ?>
                     
                               <tr>
                                <td style="text-align: center" width="5%"><?php  echo $no++?></td> 
                                <td style="text-align: center" width="25%"><?php  echo $row['bill_charge_name'];  ?></td>
                                
                                <td style="text-align: center" width="25%"><?php if ($row['bill_paid_flag']=='1') {
                                    
                                    // $paid_date=$row['bill_paid_date'];
                                    // $middle = strtotime($paid_date);
                                    // $today = date($middle,"F j, Y");
                                     echo 'Bill paid on '; echo date('F j, Y', strtotime($row['bill_paid_date']));
                                }else {
                                    echo 'Unpaid Bill'; 
                                }  ?></td>
                                <td style="text-align: left" width="25%"><?php if ($row['bill_charge_code']=='6') {
                                     echo 'Curr. Unit :'; echo $row['curr_unit'];
                                      echo '</br>';
                                      echo 'PreV.Unit :'; echo $row['prev_unit'];
                                      echo '</br>';
                                       echo 'Net Unit :'; echo $row['net_unit'];
                                       echo '</br>';
                                       echo ' Per Unit Rate :'; 
                                       echo $row['per_unit_rate'];
                                       echo '</br>';
                                     $bill_amt= $row['net_unit'] * $row['per_unit_rate'];
                                     echo "Bill amount:";

                                     echo $bill_amt;
                                     echo '</br>';
                                     echo ' Demand charge:'; echo $row['fixed_rent'];echo '%';
                                     echo '</br>';
                                     $bill_demand_amt= ($bill_amt * $row['fixed_rent'])/100; echo " TK.:"; echo $bill_demand_amt;

                                     echo ' VAT:'; echo $row['vat_rate']; echo '%';
                                     echo '</br>';

                                     $vat_amt = ((($bill_demand_amt + $bill_amt) * $row['vat_rate'])/100); echo " TK.:"; echo $vat_amt; echo " </br> (if net unit < 35 bill amount TK.:500)";
                                     //  $bill_amount = $bill_demand_amt + $vat_amt;
                                    
                                }else {
                                    echo ''; 
                                }  ?></td>
                                <td style="text-align: center" width="30%"><?php  echo $row['bill_amount']; $total_bill= $total_bill + $row['bill_amount'];?></td>
                               </tr>
                               
                                <?php
                                }
                              ?>           
                        </tbody>
                        <tfoot>
                            <tr style="background-color:powderblue";>
                                <th style="text-align:right" colspan="4"> Total Amount in TK.</th>
                                <th style="text-align:center" colspan="1"><?php echo $total_bill; ?></th>
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
    var ownername = $('#ownername').text();
    var reportTitle = $('#reportTitle').text();
    var billno = $('#billno').text();
    var header = `<div>
    	            <h2 style="text-align:center">${organizationName}</h2>
                    <h4 style="text-align:center">${organizationAdd}</h4>
                    </div>
                    <h5 style="text-align:center" id="reportTitle">${reportTitle}</h5>
                    <div>
                    <h5 style="text-align:left" >${ownername}</h5>
                    <h5 style="text-align:right;
                    margin-top:-40px;">${billno}</h5>
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