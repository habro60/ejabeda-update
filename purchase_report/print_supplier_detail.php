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
            <h1><i class="fa fa-dashboard"></i>Detail Supply Info</h1>
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

            if (isset($_GET['gl_acc_code'])) {
            $gl_acc_code = $_GET['gl_acc_code'];
            $startdate = $_GET['tran_st_date'];
            $enddate = $_GET['tran_end_date'];
            
            $sql= "SELECT acc_code, acc_head FROM `gl_acc_code` WHERE acc_code='$gl_acc_code'";
            $Query = $conn->query($sql);
            $rows = $Query->fetch_assoc();

            // $sql= "SELECT apart_owner_bill_detail.id, apart_owner_bill_detail.flat_no, apart_owner_bill_detail.batch_no, apart_owner_bill_detail.bill_for_month, apart_owner_info.owner_name FROM `apart_owner_bill_detail`, apart_owner_info WHERE apart_owner_bill_detail.flat_no='$flat_no' and  apart_owner_bill_detail.bill_for_month='$bill_for_month' and apart_owner_bill_detail.owner_id=apart_owner_info.owner_id group by apart_owner_bill_detail.flat_no";
            // $Query = $conn->query($sql);
            // $billrows = $Query->fetch_assoc();
            }
        ?>
                <div id="organizationName">
                    <h3 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h3> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <div id="reporttitle">
                     <h5 style="text-align:center" id="reportTitle">Purchase Details</h5> 
                </div>
                <div id="acc_head">
                    <h5 style="text-align:center"> <?php echo "Supplier :"; echo $rows['acc_head']; ?></h5> 
                </div>
                
                <div id="startdate"> 
                    <h4  style="text-align:center"> <?php echo "From Date:"; echo $startdate; echo "  "; echo "To Date:"; echo $enddate; ?></h4> 
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
                    <th >Sl.</th>
                    <th>Purchased Date</th>
                    <th>Voucher No</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Value </th>
                    <th>Purchased amount</th>
                    <th>Paid amount</th>
                    <th>Due amount</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              
                              $batch_no = 0;
                              $tot_pur_amt =0.00;
                              $tot_paid_amt=0.00;
                              $tot_due_amt =0.00;
                              $tot_cr_amt =0.00;
                              $tot_pur_item_amt=0.00;
                               $no='1';
                                
                               $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, tran_details.vaucher_type, tran_details.dr_amt_loc, tran_details.cr_amt_loc,(tran_details.cr_amt_loc - tran_details.dr_amt_loc) as due_amt, invoice_detail.order_no,invoice_detail.gl_acc_code,invoice_detail.item_no,invoice_detail.item_qty,invoice_detail.unit_price_loc,invoice_detail.total_price_loc, invoice_detail.item_unit, invoice_detail.include_discount_rate, invoice_detail.include_discount_amt, invoice_detail.include_vat_rate, invoice_detail.include_vat_amt, invoice_detail.include_tax_rate, invoice_detail.include_tax_amt, gl_acc_code.acc_head as supp_name,item.id,item_name, code_master.description from tran_details,invoice_detail,item, gl_acc_code, code_master where tran_details.batch_no=invoice_detail.order_no and tran_details.gl_acc_code=invoice_detail.gl_acc_code and tran_details.tran_mode=invoice_detail.order_type and (invoice_detail.order_type='PV' or invoice_detail.order_type='CP' or invoice_detail.order_type='CHQP')  and gl_acc_code.acc_code=tran_details.gl_acc_code and invoice_detail.item_no=item.id AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and tran_details.gl_acc_code ='$gl_acc_code' and code_master.hardcode='UCODE' and invoice_detail.item_unit=code_master.softcode order by tran_details.tran_date, tran_details.batch_no";
                                // echo $sql;
                                // exit;
                                $query = $conn->query($sql);
                                while ($rows = $query->fetch_assoc()) {
                                ?>
                     
                               <tr>
                               <tr>
                                <td style="text-align: center"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $no++; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                     <td style="text-align: left"><?php if ($rows['batch_no'] != $batch_no) {
                            echo $rows['tran_date']; 
                                } else {
                                     echo "";
                                                        }?></td>  
                     <td style="text-align: center"><?php if ($rows['batch_no'] != $batch_no) {
                            echo $rows['batch_no']; 
                               } else {
                                    echo "";
                                                        }?></td>  
                       
                                   
                      <td style="background-color:powderblue; text-align: left"><?php echo $rows['item_name'];?></td>
                     <td style=" background-color:powderblue; text-align: right"><?php echo $rows['item_qty'];echo "  "; echo $rows['description']; ?></td>
                     <td style=" background-color:powderblue; text-align: right"><?php echo $rows['unit_price_loc']; ?></td>
                     <td style="background-color:powderblue;width:300px ;text-align: left"><?php echo $rows['total_price_loc']; echo " - Discount @ " ; echo $rows['include_discount_rate']; echo "% TK "; echo $rows['include_discount_amt']; echo "+  VAT @ " ; echo $rows['include_vat_rate']; echo "% TK "; echo $rows['include_vat_amt']; echo "+  Tax @ " ; echo $rows['include_tax_rate']; echo "% TK "; echo $rows['include_tax_amt'];$tot_pur_item_amt = $tot_pur_item_amt + $rows['total_price_loc'];?></td>
                    
                     <td style="text-align: right"><?php
                         echo $rows['total_price_loc'];?></td>  

                    <td style="text-align: right"><?php if ($rows['batch_no'] != $batch_no) {
                                 echo $rows['dr_amt_loc']; 
                        $tot_paid_amt = $tot_paid_amt + $rows['dr_amt_loc'];
                                                        
                                } else {
                                        echo "";
                                        }?></td>
                        <td style="text-align: right"><?php if ($rows['batch_no'] != $batch_no) {
                                 echo $rows['due_amt']; 
                        $tot_due_amt = $tot_due_amt + $rows['due_amt'];
                        $batch_no=$rows['batch_no'];
                                                        
                                } else {
                                        echo "";
                                        }?></td>                  
                    
                               </tr>
                               
                                <?php
                                }
                              ?>           
                        </tbody>
                        <tfoot>
                        <tr style="background-color:powderblue";>
                                <th style="text-align:right" colspan="7"> Total Amount in TK.</th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_pur_item_amt; ?></th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_paid_amt; ?></th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_due_amt; ?></th>
                                  
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
    var acc_head = $('#acc_head').text();
    var reportTitle = $('#reportTitle').text();
    var billno = $('#billno').text();
    var header = `<div>
    	            <h3 style="text-align:center">${organizationName}</h3>
                    <h4 style="text-align:center">${organizationAdd}</h4>
                    </div>
                    <h5 style="text-align:center" id="reportTitle">${reportTitle}</h5>
                    <div>
                    <h5 style="text-align:left" >${acc_head}</h5>
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