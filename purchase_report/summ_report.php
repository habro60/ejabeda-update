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
            <h1><i class="fa fa-dashboard"></i>Summary Report</h1>
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
                          <td><select class="form-control grand" name="gl_acc_code">
                <option value="">--- Select Supplier---</option>
                    <?php
                $selectQuery = "SELECT supp_info.id, supp_info.supp_name, supp_info.gl_acc_code FROM `supp_info`";
                    $selectQueryResult =  $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                        while ($glrow = $selectQueryResult->fetch_assoc()) {
                            echo '<option value="' . $glrow['gl_acc_code'] . '">'  . $glrow['supp_name'] . '</option>';
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
                          <td><select class="form-control grand" name="gl_acc_code">
                <option value="">--- Select Supplier---</option>
                    <?php
                $selectQuery = "SELECT supp_info.id, supp_info.supp_name, supp_info.gl_acc_code FROM `supp_info`";
                    $selectQueryResult =  $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                        while ($glrow = $selectQueryResult->fetch_assoc()) {
                            echo '<option value="' . $glrow['gl_acc_code'] . '">'  . $glrow['supp_name'] . '</option>';
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
            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <h4 style="text-align:center" id="reportTitle">Summary Report</h4>
               
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
                        $tot_due_amt =0.00;
                if (isset($_POST['submit'])) {
                    
                    $startdate = $_POST['startdate'];
                    $enddate = $conn->escape_string($_POST['enddate']);
                    $office_code = $conn->escape_string($_POST['office_code']);
                    if (empty($office_code)) {
                        $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, gl_acc_code.acc_head, sum(tran_details.cr_amt_loc) as purchase_amt, sum(tran_details.dr_amt_loc) as paid_amt, sum(tran_details.cr_amt_loc) -  sum(tran_details.dr_amt_loc) as due_amt, gl_acc_code.acc_code from tran_details, gl_acc_code where tran_details.gl_acc_code=gl_acc_code.acc_code  and gl_acc_code.subsidiary_group_code='300' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')group by tran_details.gl_acc_code order by tran_details.tran_date, tran_details.batch_no";
                    } else {   
                        $office_code = $conn->escape_string($_POST['office_code']);
                       $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, gl_acc_code.acc_head, sum(tran_details.cr_amt_loc) as purchase_amt, sum(tran_details.dr_amt_loc) as paid_amt, sum(tran_details.cr_amt_loc) -  sum(tran_details.dr_amt_loc) as due_amt, gl_acc_code.acc_code from tran_details, gl_acc_code where tran_details.gl_acc_code=gl_acc_code.acc_code  and gl_acc_code.subsidiary_group_code='300' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and and tran_details.office_code='$office_code' group by tran_details.gl_acc_code order by tran_details.tran_date, tran_details.batch_no ";
                    }
                $query = $conn->query($sql);
                ?>
                <div id="mySelector">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">

                        <th >Sl.</th>
                    <th>Purchased Date</th>
                    <th>Suppler Name</th>
                    <th>Purchase Amount</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Detail</th>

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
                       
                     <td style="text-align: left"><?php if ($rows['batch_no'] != $batch_no) {
                                echo $rows['acc_head']; 
                            } else {
                                    echo "";
                                                        }?></td>  
                                   
                     <td style="text-align: right"><?php echo $rows['purchase_amt']; $tot_pur_amt = $tot_pur_amt + $rows['purchase_amt']; ?></td>
                     <td style="text-align: right"><?php echo $rows['paid_amt']; $tot_paid_amt = $tot_paid_amt + $rows['paid_amt'];?></td>
                     <td style="text-align: right"><?php if ($rows['batch_no'] != $batch_no) {
                                 echo $rows['due_amt']; 
                        $tot_due_amt = $tot_due_amt + $rows['due_amt'];
                        $batch_no=$rows['batch_no'];
                                                        
                                } else {
                                        echo "";
                                        }?></td>  

                                <td> <a id='print' title="Supplier Detail" class="btn btn-success" href="print_supplier_detail.php?gl_acc_code=<?php echo  $rows['gl_acc_code']; ?>&tran_st_date=<?php echo  $startdate; ?>&tran_end_date=<?php echo  $enddate; ?>"></i>Supplier Detail</a></td>
                              
                            </tr>
                        <?php
                            }
                        }
                            ?>

                      <tfoot>
                        <tr style="background-color:powderblue";>
                                <th style="text-align:right" colspan="3"> Total Amount in TK.</th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_pur_amt; ?></th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_paid_amt; ?></th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_due_amt; ?></th>
                                  
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
    var header = `<div>
    	            <h1 style="text-align:center">${organizationName}</h1>
                    <h3 style="text-align:center">${organizationAdd}</h3>
                 </div>
                    <h1 style="text-align:center" id="reportTitle">${reportTitle}</h1>`;
                    
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