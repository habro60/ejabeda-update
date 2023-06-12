<?php

use Mpdf\Tag\Tr;

require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";
$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>


<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> All Bill Issue Report</h1>
        </div>
    </div>

    <div class="row">
    <div class="col-md-12">
        <form method="POST">
            
      <table id="submit">
            <form method="POST">
                <tr>
                    <td> For Month: <input type="month" name="enddate" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
                <div class="pull-right">
                    <a id="Print" class="btn btn-danger print" target="_blank"></i>Print</a>
                </div>
            </form>
           

                          
        </table>
    <div id="mySelector">
        
        <table class="table table-hover table-striped" width="100%">
           

             
            <?php
            if (isset($_POST['submit'])) {
                           $enddate = $conn->escape_string($_POST['enddate']);
                           $flat_no='0';
                           $flag='0';
                           $sub_tot_bill_amt='0';
                           $org_name    = $_SESSION['org_name'];
                           $org_addr1 = $_SESSION['org_addr1'];
                           $org_email = $_SESSION['org_email'];
                           $org_tel = $_SESSION['org_tel'];
                           $org_logo    = $_SESSION['org_logo'];

                           ?>
 <!-- report header -->
                <div id="organizationName">
                    <p style="text-align:center;margin:0"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></p> 
                </div>
                <div id="organizationAdd">
                    <p  style="text-align:center;margin:0"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></p> 
                </div>
                <p style="text-align:center;margin:0" id="reportTitle"><b>Bill Issue</b></p>
                <div id="AsOnDate">
                    
                </div>
               
               
                <!-- report view option -->
            

           

                           <?php

                           

                           

                           $sql = "SELECT org_info.org_name, org_info.org_addr1, org_info.org_tel, apart_owner_bill_detail.flat_no,
                           apart_owner_bill_detail.id,apart_owner_bill_detail.bill_charge_code, apart_owner_bill_detail.bill_charge_name,
                           apart_owner_bill_detail.bill_for_month,apart_owner_bill_detail.bill_last_pay_date,apart_owner_bill_detail.bill_amount,
                            apart_owner_info.owner_name, apart_owner_bill_detail.prev_unit,apart_owner_bill_detail.curr_unit,apart_owner_bill_detail.net_unit,apart_owner_bill_detail.per_unit_rate,apart_owner_bill_detail.fixed_rent,apart_owner_bill_detail.vat_rate
                            FROM org_info, `apart_owner_bill_detail`, apart_owner_info
                             where apart_owner_bill_detail.owner_id=apart_owner_info.owner_id and apart_owner_bill_detail.bill_for_month= '$enddate'
                              order by apart_owner_bill_detail.flat_no, apart_owner_bill_detail.bill_charge_code";
                            $query = $conn->query($sql);
                
                            
                             while ($rows = $query->fetch_assoc()) {
                                 
                             
                                $bill_demand_amt= (($rows['net_unit'] * $rows['per_unit_rate']) * $rows['fixed_rent'])/100; 


                                 if ($flat_no != $rows['flat_no'] && $flag !='0') {
                                     

                                     echo
                                    
                                     '
                                     
                                     <tr>
                                    
                                     
                                     <td style="text-align:left;font-weight:bold; width:80%" <strong> (Signature not requied due to computer Generated Bill) <strong></td>
                                     <td style="text-align:right"></td>
                                         <td style="text-align:right;font-weight:bold; width:20%" <strong> Total Bill Amount : ' . $sub_tot_bill_amt . ' <strong>
                                         
                                       

                        
        

                                         </td> 
                                      
                                   
                                      </tr>';


                                      ?>
                                      <tr>

                                 <td>

                              
               <br>
               <br>
               <br>
               <br>
               <br>
             
              
                                     <div id="header_report" style=" margin-right: -273px; " >

                                     <div id="organizationName">
                    <p style="text-align:center;margin:0"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></p> 
                </div>
                <div id="organizationAdd">
                    <p  style="text-align:center;margin:0"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></p> 
                </div>
                <p style="text-align:center;margin:0" id="reportTitle"><b>Bill Issue</b></p>
               
                <div id="AsOnDate">
                    
                </div>
               
                                 
                                                     
                                                      </td>

                                                    


                                   <?php
                                                                             
                                    


                                       
                                 }
                                 if ($flat_no != $rows['flat_no']) {
                                     $sub_tot_bill_amt='0';
                                     $sub_tot_bill_amt = $sub_tot_bill_amt + $rows['bill_amount'];
                                     $flat_no = $rows['flat_no'];
                                     $flag='1';
                                    
                                     echo
                                     
                                     '<tr style="text-align:right; ">
                                     <td style="text-align:left;"> <strong>Bill NO: ' . $rows['id'] .'<strong>
                                     
                                     <p>Bill TO: ' . $rows['flat_no'] . ' '. $rows['owner_name'].'<p>
                                     </td>
                                     <td style="text-align:center;"></td
                                           <td style="text-align:right"></td>
                                           <td class="fiz" style="text-align:right"><strong>Bill Month: '. date('F, y', strtotime($rows['bill_for_month'])) .'<strong></td>
                                     </tr>';
                                     if ($rows['bill_charge_code']=='6') { 

                                        
                                        echo
                                        '<tr style="text-align:left; " >
                                             <td style="text-align:100px;"> ' . $rows['bill_charge_name'] . '     </td>
                                              <td style="text-align:100px">

                                       
                                              
                                              
                                             Curr.Unit=' . $rows['curr_unit'] .  ' Prev.Unit=' . $rows['prev_unit'] . ' Net Unit=' . $rows['net_unit'] . ' 
                                             Bill amount=' . $rows['net_unit'] * $rows['per_unit_rate'] .  '  P.U.Rate=' . $rows['per_unit_rate'] . ' D.charge=' . $rows['fixed_rent'] .' %
                                            TK =' . $bill_demand_amt .  ' VAT=' . $rows['vat_rate'] . '%
                                             
                                     
                                              </td>
                                              <td style="text-align:100px">' . $rows['bill_amount'] . '</td>    
                                              
                                            </tr>';
                                           } else 
                                        
                                        { 
                                         echo
                                           '<tr style="text-align:left;" >
                                                   <td>' . $rows['bill_charge_name'] . '</td>
                                                   <td style="text-align:right"></td>
                                                    <td style="text-align:right" >' . $rows['bill_amount'] . '</td>  
                                                   </tr>';}
                                    
                                 } else {
                                 $sub_tot_bill_amt = $sub_tot_bill_amt + $rows['bill_amount'];
                                 if ($rows['bill_charge_code']=='6') { 
                                    echo
                                    '<tr style="text-align:left;" >
                                              
                                    
                                    <td style="text-align:left"> ' . $rows['bill_charge_name'] . '
                                              

                                   <div id="bb" style="display:contents;">

                                    Curr.Unit=' . $rows['curr_unit'] .  ',,, Prev.Unit=' . $rows['prev_unit'] . ',,, Net Unit=' . $rows['net_unit'] . ' ,,,
                                    Bill amount=' . $rows['net_unit'] * $rows['per_unit_rate'] .  ',,, U.Rate=' . $rows['per_unit_rate'] . ',,, charge=' . $rows['fixed_rent'] .' %,,,
                                   TK =' . (($rows['net_unit'] * $rows['per_unit_rate']) * $rows['fixed_rent'])/100 .  ',,, VAT=' . $rows['vat_rate'] . '%

                                   </div>

                                              </td>
                                              <td></td>
                                              
                                              <td style="text-align:right; margin-right:20px;"> ' . $rows['bill_amount'] . '</td>
                                        </tr>';
                                       } else 
                                    
                                    { 
                                     echo
                                       '<tr style="text-align:left;" >
                                               <td>' . $rows['bill_charge_name'] . '</td>
                                               <td style="text-align:right"></td>
                                                <td style="text-align:right">' . $rows['bill_amount'] . '</td>  

                                              
                                               </tr>';
                                            
                                            }
                                 }
                                 
                                 
                                 
                                 
                                 
                                 
                             } ?>
                             
        
                               </tbody> 
                    <?php     
                 
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