<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";
if (empty($supp_id)) {
    $sql2 = "SELECT  supp_info.id, supp_info.supp_name, supp_info.gl_acc_code, invoice_detail.gl_acc_code FROM  supp_info, invoice_detail where supp_info.gl_acc_code = invoice_detail.gl_acc_code ORDER BY supp_info.gl_acc_code, invoice_detail.order_date";
} else {
    $sql2 =  "SELECT  supp_info.id, supp_info.supp_name, supp_info.gl_acc_code, invoice_detail.gl_acc_code FROM  supp_info, invoice_detail where supp_info.gl_acc_code = $supp_id ORDER BY supp_info.gl_acc_code, invoice_detail.order_date";
}

$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100

$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
$office_code    = $_SESSION['office_code'];
?>

<main class="app-content">
    <!-- page title -->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Cash & Cheque Purchase Report</h1>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-12">
            
            <form method="POST">
            <?php if ($role_no =='99' || $role_no =='100') {
    ?>
        <table id="submit">
            <form method="POST">
                <tr> 
                    <td><select class="form-control grand" name="office_code">
                            <option value="">--- Select Office---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `office_info`";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($drrow = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $drrow['office_code'] . '">'  . $drrow['office_name'] . '</option>';
                                }
                            }
                            ?>
                          </select></td>
                          <td><select class="form-control" name="item_id">
                            <option value="">--- Select Item---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `item` where sellable_option='N'";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($drrow = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $drrow['id'] . '">'  . $drrow['item_name'] . '</option>';
                                }
                            }
                            ?>
                          </select></td>
                          <td>From Date<input type="date" id="date" class="startdate" name="startdate" value="<?php echo date('Y-m-d'); ?>"></td>
                            <td>To Date<input type="date" id="date" class="enddate" name="enddate" value="<?php echo date('Y-m-d'); ?>"></td>
                    <td><input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    } elseif ($role_no < '99' ){ ?>
        <table id="submit">
            <form method="POST">
                      <tr>
                      <td><select class="form-control" name="office_code">
                            <option value="">--- Select Office---</option>
                            <?php
                            $office_code= $_SESSION['office_code'];
                            $selectQuery = "SELECT * FROM `office_info` where office_code = $office_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($drrow = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $drrow['office_code'] . '">'  . $drrow['office_name'] . '</option>';
                                }
                            }
                            ?>
                          </select></td>
                          <td><select class="form-control" name="item_id">
                            <option value="">--- Select Item---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `item` where sellable_option='N'";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($drrow = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $drrow['id'] . '">'  . $drrow['item_name'] . '</option>';
                                }
                            }
                            ?>
                          </select></td>
                          <td>From Date<input type="date" id="date" class="startdate" name="startdate" value="<?php echo date('Y-m-d'); ?>"></td>
                            <td>To Date<input type="date" id="date" class="enddate" name="enddate" value="<?php echo date('Y-m-d'); ?>"></td>

                            <td><input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
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
                $startdate= $_POST['startdate'];
                $enddate = $_POST['enddate'];
                $item_code = $_POST['item_id'];
            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <h4 style="text-align:center" id="reportTitle">Cash Purchase</h4>
                <h3 style="text-align:center" id="AsDate"><?php echo 'From Date:'; echo $startdate; echo '  To Date: '; echo $enddate; ?> </h3>
                <div class="pull-right">
                    <a id="Print" class="btn btn-danger print" target="_blank"></i>Print</a>
                </div>
                <!-- report view option -->
                <br><br>
                <?php
                        $d = 0;
                        $no = 1;
                        $batch_no = 0;
                        $tot_pur_amt =0.00;
                        $tot_paid_amt=0.00;
                        $tot_dr_amt =0.00;
                        $tot_cr_amt =0.00;
            
                if (isset($_POST['submit'])) {
                    
                    $startdate = $_POST['startdate'];
                    $enddate = $conn->escape_string($_POST['enddate']);
                    $office_code = $conn->escape_string($_POST['office_code']);
                    $item_id = $conn->escape_string($_POST['item_id']);
                    if (empty($office_code)) {
                        if (empty($item_id)){
                            $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, tran_details.vaucher_type, tran_details.dr_amt_loc, tran_details.cr_amt_loc, invoice_detail.order_no,invoice_detail.gl_acc_code,invoice_detail.item_no,invoice_detail.item_qty,invoice_detail.unit_price_loc,invoice_detail.total_price_loc, invoice_detail.item_unit, invoice_detail.include_discount_rate, invoice_detail.include_discount_amt, invoice_detail.include_vat_rate, invoice_detail.include_vat_amt, invoice_detail.include_tax_rate, invoice_detail.include_tax_amt, gl_acc_code.acc_head as supp_name,item.id,item_name, code_master.description from tran_details,invoice_detail,item, gl_acc_code, code_master where tran_details.batch_no=invoice_detail.order_no and tran_details.gl_acc_code=invoice_detail.gl_acc_code and tran_details.tran_mode=invoice_detail.order_type and (invoice_detail.order_type='PVC' or invoice_detail.order_type='PVCHQ') and gl_acc_code.acc_code=tran_details.gl_acc_code and invoice_detail.item_no=item.id AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and code_master.hardcode='UCODE' and invoice_detail.item_unit=code_master.softcode order by tran_details.tran_date, tran_details.batch_no";

                            // echo $sql;
                            // die;

                        } else {
                            $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, tran_details.vaucher_type, tran_details.dr_amt_loc, tran_details.cr_amt_loc, invoice_detail.order_no,invoice_detail.gl_acc_code,invoice_detail.item_no,invoice_detail.item_qty,invoice_detail.unit_price_loc,invoice_detail.total_price_loc, invoice_detail.item_unit, invoice_detail.include_discount_rate, invoice_detail.include_discount_amt, invoice_detail.include_vat_rate, invoice_detail.include_vat_amt, invoice_detail.include_tax_rate, invoice_detail.include_tax_amt, gl_acc_code.acc_head as supp_name,item.id,item_name, code_master.description from tran_details,invoice_detail,item, gl_acc_code, code_master where tran_details.batch_no=invoice_detail.order_no and tran_details.gl_acc_code=invoice_detail.gl_acc_code and tran_details.tran_mode=invoice_detail.order_type and (invoice_detail.order_type='PVC' or invoice_detail.order_type='PVCHQ') and gl_acc_code.acc_code=tran_details.gl_acc_code and invoice_detail.item_no=item.id and item.id='$item_id' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and code_master.hardcode='UCODE' and invoice_detail.item_unit=code_master.softcode order by tran_details.tran_date, tran_details.batch_no";

                            

                        }
                    }
                       
                $query = $conn->query($sql);
                ?>
                <div id="mySelector">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">

                    <th >Sl.</th>
                    <th>Purchased Date</th>
                    <th>Voucher No</th>
                    <th>Account Head</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Value </th>
                    <th>Purchased amount</th>

                        </thead>

                        <body>
                            
                            <?php
                            while ($rows = $query->fetch_assoc()) {
                            ?>
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
                     <td style="text-align: left"><?php if ($rows['batch_no'] != $batch_no) {
                                echo $rows['supp_name']; 
                            } else {
                                    echo "";
                                                        }?></td>  
                                   
                      <td style="background-color:powderblue; text-align: left"><?php echo $rows['item_name'];?></td>
                     <td style=" background-color:powderblue; text-align: right"><?php echo $rows['item_qty'];echo "  "; echo $rows['description']; ?></td>
                     <td style=" background-color:powderblue; text-align: right"><?php echo $rows['unit_price_loc']; ?></td>
                     <td style="background-color:powderblue;width:300px ;text-align: left"><?php echo $rows['total_price_loc']; echo " - Discount @ " ; echo $rows['include_discount_rate']; echo "% TK "; echo $rows['include_discount_amt']; echo "+  VAT @ " ; echo $rows['include_vat_rate']; echo "% TK "; echo $rows['include_vat_amt']; echo "+  Tax @ " ; echo $rows['include_tax_rate']; echo "% TK "; echo $rows['include_tax_amt']?></td>
                    
                     
                     <td style="text-align: right"><?php if ($rows['batch_no'] != $batch_no) {
                                 echo $rows['cr_amt_loc']; 
                        $tot_pur_amt = $tot_pur_amt + $rows['cr_amt_loc'];
                        $batch_no=$rows['batch_no'];
                                                        
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
                                <th style="text-align:right" colspan="8"> Total Amount in TK.</th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_pur_amt; ?></th>
                                  
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
    var AsDate = $('#AsDate').text();
    var header = `<div>
    	            <h1 style="text-align:center">${organizationName}</h1>
                    <h3 style="text-align:center">${organizationAdd}</h3>
                 </div>
                    <h1 style="text-align:center" id="reportTitle">${reportTitle}</h1>
                    <h3 style="text-align:center">${AsDate}</h3>`;
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