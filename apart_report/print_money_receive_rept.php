<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";
if (empty($owner_id)) {
    $sql2 = "SELECT  apart_owner_info.id, apart_owner_info.owner_name, apart_owner_info.gl_acc_code, gl_acc_code.acc_code FROM  apart_owner_info, gl_acc_code where apart_owner_info.gl_acc_code = gl_acc_code.acc_code ORDER BY apart_owner_info.gl_acc_code";
} else {
    $sql2 = "SELECT  apart_owner_info.id, apart_owner_info.owner_name, apart_owner_info.gl_acc_code, gl_acc_code.acc_code FROM  apart_owner_info, gl_acc_code where apart_owner_info.owner_id = '$owner_id' and apart_owner_info.gl_acc_code=gl_acc_code.acc_code  ORDER BY apart_owner_info.gl_acc_code";
}

// $role_no     = 99; // admin 99 superadmin 100
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100

$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>

<main class="app-content">
    <!-- page title -->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Print Money Bill Recite</h1>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-12">
            <!-- filter option -->
            <form method="POST">
            <?php if (empty($owner_id)) {
    ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td> Bill for Month: <input type="month" name="bill_for_month" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    } elseif (!empty($owner_id)) { ?>
        <table id="submit">
            <form method="POST">
                      <tr>
                            <td>
                               <td> <input type="text" name="owner_name" id="" class="form-control" value="<?php echo $row['owner_name']; ?>" readonly></td>
                                
                                <td> For Month: <input type="month" name="bill_for_month" id="" class="form-control" required></td>
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
            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h3 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h3> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <h4 style="text-align:center" id="reportTitle">Money Received Report</h4>
               
                <!-- report view option -->
                <br><br>
                <?php
                        $d = 0;
                        $no = 1;
                        $owner_id = 0;
                        $tot_cr_amt =0.00;
                        $tot_dr_amt=0.00;
            
                if (isset($_POST['submit'])) {
                    
                    $bill_for_month = $conn->escape_string($_POST['bill_for_month']);
                    if (empty($gl_acc_code)) {

                            $sql="SELECT apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_charge_code,
                            apart_owner_bill_detail.bill_for_month,sum(apart_owner_bill_detail.bill_amount) 
                            as bill_amount, apart_owner_bill_detail.flat_no,apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.bill_paid_flag,
                              apart_owner_info.owner_id,apart_owner_info.owner_name from apart_owner_bill_detail,  apart_owner_info where
                                apart_owner_info.owner_id=apart_owner_bill_detail.owner_id and apart_owner_bill_detail.bill_for_month= '$bill_for_month' AND apart_owner_bill_detail.bill_paid_flag=1
                                 group by apart_owner_bill_detail.flat_no";


                        }else {

                            $sql="SELECT apart_owner_bill_detail.owner_id, apart_owner_bill_detail.bill_charge_code,apart_owner_bill_detail.bill_for_month,sum(apart_owner_bill_detail.bill_amount) as bill_amount, apart_owner_bill_detail.flat_no,apart_owner_bill_detail.owner_gl_code, apart_owner_bill_detail.bill_paid_flag,  apart_owner_info.owner_id,apart_owner_info.owner_name from apart_owner_bill_detail,  apart_owner_info where  apart_owner_info.owner_id=apart_owner_bill_detail.owner_id and apart_owner_bill_detail.bill_for_month= '$bill_for_month' group by apart_owner_bill_detail.flat_no";

                        }
                $query = $conn->query($sql);
                ?> 
                  <div id="">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">

                                
                                <th>Bill for Month</th>
                                <th>Shop/Merchant Name</th>
                                <th>Shop/Flat Number</th>
                                <th>Bill Amount</th>
                                <th>Bill Paid Status</th>
                                <th>action</th>

                        </thead>

                        <body>
                            
                            <?php
                            
                            while ($row = $query->fetch_assoc()) {
                                            
                      echo "<tr>";
                      echo "<td>" . $row['bill_for_month'] . "</td>";
                      echo "<td>" . $row['owner_name'] . "</td>";
                      echo "<td>" . $row['flat_no'] . "</td>";
                      
                      echo "<td>" . $row['bill_amount'] . "</td>";
                      echo "<td>" . $row['bill_paid_flag'] . "</td>";
                 
                 if($_SESSION["org_no"]=="1300000000"){
                         
                    ?>  
                
                      <td> <a id='print' title="Print bill" class="btn btn-success" href="print_bill_issue_half_page.php?flat_no=<?php echo  $row['flat_no']; ?>&bill_for_month=<?php echo  $row['bill_for_month']; ?>"></i>Print Bill</a></td>
      <?php
      } else{
          ?>
          
               <td> <a id='print' title="Print bill" class="btn btn-success" href="print_bill_issue.php?flat_no=<?php echo  $row['flat_no']; ?>&bill_for_month=<?php echo  $row['bill_for_month']; ?>"></i>Print Bill</a></td>
                                  
          
          
                <?php
      }   
                   ?>

                               
                            </tr>
                        <?php
                            }
                        }
                            ?>

                      <tfoot>
                        <tr style="background-color:powderblue";>
                                <th style="text-align:right" colspan="5"> Total Amount in TK.</th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_dr_amt; ?></th>
                                <!-- <th style="text-align:right" colspan="1"><?php echo ($tot_dr_amt - $tot_cr_amt); ?></th>   -->
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
// $(document).on('click', '.print', function () {
 
//     var organizationName = $('#organizationName').text();
//     var organizationAdd = $('#organizationAdd').text();
//     var reportTitle = $('#reportTitle').text();
//     var header = `<div>
//     	            <h1 style="text-align:center">${organizationName}</h1>
//                     <h3 style="text-align:center">${organizationAdd}</h3>
//                  </div>
//                     <h1 style="text-align:center" id="reportTitle">${reportTitle}</h1>`;
                    
//     $("#mySelector").printThis({
//         debug: false,               // show the iframe for debugging
//         importCSS: true,            // import parent page css
//         importStyle: false,         // import style tags
//         printContainer: true,       // print outer container/$.selector
//         loadCSS: 'http://ejabeda.com/css/print.css', // path to additional css file - use an array [] for multiple
//         pageTitle: null,              // add title to print page
//         removeInline: false,        // remove inline styles from print elements
//         removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
//         printDelay: 333,            // variable print delay
//         header: header,               // prefix to html
//         // footer: '<h6 style="text-align:center">Design and Development by Habro System Ltd.</h6>',               // postfix to html
      
//         base: false,                // preserve the BASE tag or accept a string for the URL
//         formValues: false,           // preserve input/form values
//         canvas: false,              // copy canvas content
//         // doctypeString: '...',       // enter a different doctype for older markup
//         removeScripts: false,       // remove script tags from print content
//         copyTagClasses: false,      // copy classes from the html & body tag
//         beforePrintEvent: null,     // function for printEvent in iframe
//         beforePrint: null,          // function called before iframe is filled
//         afterPrint: null            // function called before iframe is removed
//     });
// });

</script>
</body>

</html>