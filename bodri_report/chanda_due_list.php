<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";
if (empty($member_id)) {
    $sql2 = "SELECT  fund_member.member_id, fund_member.full_name, fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.gl_acc_code = gl_acc_code.acc_code ORDER BY fund_member.gl_acc_code";
} else {
    $sql2 = "SELECT  fund_member.member_id, fund_member.full_name, fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.member_no = '$member_no' and fund_member.gl_acc_code=gl_acc_code.acc_code  ORDER BY fund_member.gl_acc_code";
}
// $query = $conn->query($sq2);
// $row = $query->fetch_assoc();

// $role_no     = 99; // admin 99 superadmin 100
$role_no     = $_SESSION['sa_role_no']; 

$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>

<main class="app-content">
    <!-- page title -->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Chanda Due List</h1>
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
                    <td> As on Date: <input type="date" name="enddatee" id="" class="form-control" required></td>
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
                               <td> <input type="text" name="full_name" id="" class="form-control" value="<?php echo $row['full_name']; ?>" readonly></td>
                                
                                <td> As On Date: <input type="date" name="enddate" id="" class="form-control" required></td>
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
                $q      = $_SESSION['org_rep_footer1'];
                $b      = $_SESSION['org_rep_footer2'];
            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h3 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h3> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <h4 style="text-align:center" id="reportTitle"> Due List</h4>
               
                <!-- report view option -->
                <br><br>
                <?php
                        $d = 0;
                        $no = 1;
                        $owner_id = 0;
                        $tot_cr_amt =0.00;
                        $tot_dr_amt=0.00;
            
                if (isset($_POST['submit'])) {
                    
                    $enddate = $conn->escape_string($_POST['enddatee']);
                    if (empty($gl_acc_code)) {

                            $sql="SELECT donner_fund_detail.member_id, donner_fund_detail.fund_type_desc, donner_fund_detail.num_of_paid, fund_member.member_no,fund_member.full_name, donner_fund_detail.donner_paid_amt, (12 * (YEAR('$enddate') - YEAR(donner_fund_detail.last_paid_date)) + (MONTH('$enddate') - MONTH(donner_fund_detail.last_paid_date)))  as due_month,donner_fund_detail.last_paid_date, donner_fund_detail.donner_pay_amt from donner_fund_detail,fund_member where donner_fund_detail.member_id=fund_member.member_id and allow_flag >'0' and donner_fund_detail.last_paid_date <= '$enddate' order by fund_member.member_no";


                        }else {

                            $sql="SELECT donner_fund_detail.member_id, donner_fund_detail.fund_type_desc, donner_fund_detail.num_of_paid, fund_member.member_no,fund_member.full_name, donner_fund_detail.donner_paid_amt, (12 * (YEAR('$enddate') - YEAR(donner_fund_detail.last_paid_date)) + (MONTH('$enddate') - MONTH(donner_fund_detail.last_paid_date)))  as due_month,donner_fund_detail.last_paid_date, donner_fund_detail.donner_pay_amt from donner_fund_detail,fund_member where donner_fund_detail.member_id=fund_member.member_id and allow_flag >'0' and donner_fund_detail.last_paid_date <= '$enddate' order by fund_member.member_no";

                        }
                $query = $conn->query($sql);
                ?> 
                  <div id="">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">

                                
                                <th>Member No.</th>
                                <th>Name</th>
                                <th>Due Month</th>
                                <th>action</th>

                        </thead>

                        <body>
                            
                            <?php
                            
                            while ($row = $query->fetch_assoc()) {
                                            
                      echo "<tr>";
                      echo "<td>" . $row['member_no'] . "</td>";
                      echo "<td>" . $row['full_name'] . "</td>";
                      echo "<td>" . $row['due_month'] . "</td>";
                    ?>  
                
                      <td> <a id='print' title="Print Slip" class="btn btn-success" href="chanda_due_slip.php?member_id=<?php echo  $row['member_id']; ?>&last_paid_date=<?php echo  $enddate; ?>"></i>Print Slip</a></td>

                               
                            </tr>
                        <?php
                            }
                        }
                            ?>

                      <!-- <tfoot>
                        <tr style="background-color:powderblue";>
                                <th style="text-align:right" colspan="5"> Total Amount in TK.</th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_cr_amt; ?></th>
                            </tr>
                        </tfoot> -->
                        </body>
                        
                    </table>
                   
              <!-- <div 
              style=
                'padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $q; ?></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $b;?></div></div> -->
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