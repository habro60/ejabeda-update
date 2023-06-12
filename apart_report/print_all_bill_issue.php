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
<style>
    
    div.page_break + div.page_break{
    page-break-after: always;
}
</style>

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
              
               
               
                <!-- report view option -->
            

           
    <div id="mySelector">
        
        
           

             
      

                           <?php

                     
                           
                          $a;
                           $bill =[];
                           $bill_name=[];
                           $variable_bill=[];
                           $i=1;

                           $sql = "SELECT id,bill_for_month,flat_no FROM `apart_owner_bill_detail` WHERE bill_for_month='$enddate' GROUP BY flat_no ORDER BY `apart_owner_bill_detail`.`flat_no` DESC";
                            $query = $conn->query($sql);
                
                      
                             while ($row=$query->fetch_assoc()) {
                                 
                                 echo'<table class="table table-hover table-striped" width="100%" style=" page-break-after: always;">';
                                
                                 
                                  echo' 
                                 
                                     <tr style="text-align:right; ">
                                     <td style="text-align:left;">
                                    
                                  
                                  
                                  <div id="header_report" style=" margin-right: -273px; " >

                                  <div id="organizationName">
                    <p style="text-align:center;margin:0"><img src="../upload/' . $org_logo . ' " alt="logo" style="width:40px;height:40px;"> '. $org_name .'</p> 
                </div>
                <div id="organizationAdd">
                    <p  style="text-align:center;margin:0"> '.$org_addr1.'',' E-Mail:'. $org_email.'</p> 
                </div>
                <p style="text-align:center;margin:0" id="reportTitle"><b>Bill Issue</b></p>
                <div id="AsOnDate">
                    
                </div> </div>
                </td>
                
                   </tr>';
                                 
                                 
                                 
                        //   echo
                                     
                        //              '<tr style="text-align:right; ">
                        //              <td style="text-align:left;"> <strong>Bill NO: amr sonar bangla<strong>
                                    
                        //              </tr>';
                         $sub_tot_bill_amt=0;
                                 
                                 $flat_no=$row['flat_no'];
                                 
                        
                        
                        $owner_info="SELECT owner_name FROM `apart_owner_info` WHERE flat_no='$flat_no'";
                         $owner_query = $conn->query($owner_info);
                         $owner_name=$owner_query->fetch_assoc();
                           echo
                           
                                     
                                     '
                                     <tr style="text-align:right; ">
                                     <td style="text-align:left;"> <strong>Bill NO: ' . $row['id'] .'<strong>
                                     
                                     <p>Bill TO:'.$flat_no.' ' .  $owner_name['owner_name'] . '<p>
                                     </td>
                                     <td style="text-align:center;"></td
                                           <td style="text-align:right"></td>
                                           <td class="fiz" style="text-align:right"><strong>Bill Month: '. date('F, y', strtotime($row['bill_for_month'])) .'<strong></td>
                                     </tr>';
                                 
                                
                                         $sql2="SELECT org_info.org_name, org_info.org_addr1, org_info.org_tel, apart_owner_bill_detail.flat_no,
                           apart_owner_bill_detail.id,apart_owner_bill_detail.bill_charge_code, apart_owner_bill_detail.bill_charge_name,
                           apart_owner_bill_detail.bill_for_month,apart_owner_bill_detail.bill_last_pay_date,apart_owner_bill_detail.bill_amount,
                            apart_owner_info.owner_name, apart_owner_bill_detail.prev_unit,apart_owner_bill_detail.curr_unit,apart_owner_bill_detail.net_unit,apart_owner_bill_detail.per_unit_rate,apart_owner_bill_detail.fixed_rent,apart_owner_bill_detail.vat_rate
                            FROM org_info, `apart_owner_bill_detail`, apart_owner_info
                             where apart_owner_bill_detail.owner_id=apart_owner_info.owner_id and apart_owner_bill_detail.bill_for_month= '$enddate'
        AND apart_owner_bill_detail.flat_no='$flat_no'
                              order by apart_owner_bill_detail.flat_no, apart_owner_bill_detail.bill_charge_code";
                              
                                 $query2 = $conn->query($sql2);
                
                          
                                while($ab=$query2->fetch_assoc()){
                                      $bill_demand_amt= (($ab['net_unit'] * $ab['per_unit_rate']) * $ab['fixed_rent'])/100; 
                                    
                                    if($ab['bill_charge_code']=='6'){
                                       $a='<tr style="text-align:left;" >
                                      
                                      
                                              <td>' . $ab['bill_charge_name'] . '<br>
                                              
                                              
                                                
                                                Curr.Unit=' . $ab['curr_unit'] .  ' Prev.Unit=' . $ab['prev_unit'] . ' Net Unit=' . $ab['net_unit'] . ' 
                                             Bill amount=' . $ab['net_unit'] * $ab['per_unit_rate'] .  '  P.U.Rate=' . $ab['per_unit_rate'] . ' D.charge=' . $ab['fixed_rent'] .' %
                                            TK =' . $bill_demand_amt .  ' VAT=' . $ab['vat_rate'] . '%
                                              
                                              </td>
                                             
                                              
                                              <td style="text-align:right"></td>
                                                <td style="text-align:right">' . $ab['bill_amount'] . '</td>  

                                              
                                              </tr>';
                                              
                                             echo $a;
                                            
                                              
                                            //   $variable_value= implode(',', $ab['curr_unit'],',',$ab['prev_unit'],',',$ab['net_unit']);
                                            //     array_push($variable_bill,$variable_value);
                                                
                                            //     print_r($variable_value);
                                            //     die;
                                       
                                    }else{
                                         echo
                                      '<tr style="text-align:left;" >
                                              <td>' . $ab['bill_charge_name'] . '
                                              
                                              
                                              
                                              </td>
                                             
                                              
                                              <td style="text-align:right"></td>
                                                <td style="text-align:right">' . $ab['bill_amount'] . '</td>  

                                              
                                              </tr>';
                                    }
                                 
                                     
                                    
                                     
                                     array_push($bill,$ab['bill_amount']);
                                     array_push($bill_name,$ab['bill_charge_name']);
                                     
                                     $sub_tot_bill_amt=$sub_tot_bill_amt+$ab['bill_amount'];
                                     
                                     
                                     
                                 }
                                 
                                 
                                 
                                 
                             
                                 
                                  echo
                                    
                                     '
                                     
                                     <tr>
                                    
                                     
                                     <td style="text-align:left;font-weight:bold; width:80%" <strong> (Signature not requied due to computer Generated Bill) <strong></td>
                                     <td style="text-align:right"></td>
                                     <td style="text-align:right;font-weight:bold; width:20%" <strong> Total Bill Amount : ' . $sub_tot_bill_amt . ' <strong>
                                         </td> 
                                 
                                   
                                      </tr>';
                                      
                                      
                                      
                                   echo "
                                       <tr style= 'margin-left: 500px;'>
                                       
                                       <td>
                                       
                             <div style= 'padding:80px;'>
                <div style='float:left;text-align:left;line-height:100%'>
                <label>--------------------</label>
                <br>$q
                </div>
                <div style='float:right;text-align:right;line-height:100%;'>
                <label>--------------------------</label>
             <br>$b 
             </div>
             </div></td> </tr>";
                                      
                                      
                                      echo '<tr><td><div style="margin-top:100px; margin-bottom:100px;">  ..................................................................................................................................... </div></td></tr>';
                                      
                                    
                                    echo' 
                                   
                                 
                                     <tr style="text-align:right; ">
                                     <td style="text-align:left;">
                                    
                                  
                                  
                                
 <div id="header_report" style=" margin-right: -273px; " >
                                  <div id="organizationName">
                    <p style="text-align:center;margin:0"><img src="../upload/' . $org_logo . ' " alt="logo" style="width:40px;height:40px;"> '. $org_name .'</p> 
                </div>
                <div id="organizationAdd">
                    <p  style="text-align:center;margin:0"> '.$org_addr1.'',' E-Mail:'. $org_email.'</p> 
                </div>
                <p style="text-align:center;margin:0" id="reportTitle"><b>Bill Issue</b></p>
                <div id="AsOnDate">
                    
                </div>          </div> 
                </td>
                
                   </tr>';
                                      
                                      
                                      
                                      ///////////////////////////////
                                      $length=intval(count($bill));
                                      
                                               
                           echo
                                     
                                     '<tr style="text-align:right; ">
                                     <td style="text-align:left;"> <strong>Bill NO: ' . $row['id'] .'<strong>
                                     
                                    <p>Bill TO:'.$flat_no.' ' .  $owner_name['owner_name'] . '<p>
                                     </td>
                                     <td style="text-align:center;"></td
                                           <td style="text-align:right"></td>
                                           <td class="fiz" style="text-align:right"><strong>Bill Month: '. date('F, y', strtotime($row['bill_for_month'])) .'<strong></td>
                                     </tr>';
                                      
                                      while($length!=0){
                                          $name=array_shift($bill_name);
                                          $value=array_shift($bill);
                                 
                                 
                                 if($name=='Electric Bill'){
                                    //   echo
                                    //   '<tr style="text-align:left;" >
                                      
                                      
                                    //           <td>'. $name .'</td>
                                              
                                    //           <td style="text-align:right"></td>
                                    //             <td style="text-align:right">' . $value . '</td>  

                                              
                                    //           </tr>';
                                    
                                    echo $a;
                                              
                                              $length--;
                                 }else{
                                      echo
                                      '<tr style="text-align:left;" >
                                      
                                      
                                              <td>'. $name .'</td>
                                              
                                              <td style="text-align:right"></td>
                                                <td style="text-align:right">' . $value . '</td>  

                                              
                                              </tr>';
                                              
                                              $length--;
                                              
                                 }
                                 
                                 
                                      }
                                  
                                  
                                 
                                 
                                  echo
                                    
                                     '
                                     
                                     <tr>
                                    
                                     
                                     <td style="text-align:left;font-weight:bold; width:80%" <strong> (Signature not requied due to computer Generated Bill) <strong></td>
                                     <td style="text-align:right"></td>
                                     <td style="text-align:right;font-weight:bold; width:20%" <strong> Total Bill Amount : ' . $sub_tot_bill_amt . ' <strong>
                                         </td> 
                                      
                                   
                                      </tr>
                                      
                                      
                                      ';
                                      
                                       echo "
                                       <tr>
                                       
                                       <td>
                                       
                             <div style= 'padding:80px;'>
                <div style='float:left;text-align:left;line-height:100%'>
                <label>--------------------</label>
                <br>$q 
                </div>
                <div style='float:right;text-align:right;line-height:100%'>
                <label>--------------------------</label>
             <br>$b 
             </div>
             </div></td> </tr>";
                                      
                                      
                                 
                                 echo '</table>';
                           
                                 
                               
                             }
                             
                             
                            
                             
        //   die;


            }              
                   
                  ?>
                 
             
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