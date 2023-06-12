<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";
if (empty($member_id)) {
    $sql2 = "SELECT  flat_info.flat_no, flat_info.flat_title, flat_info.dokan_vara_gl, gl_acc_code.acc_code FROM  flat_info, gl_acc_code where flat_info.dokan_vara_gl = gl_acc_code.acc_code ORDER BY flat_info.dokan_vara_gl";
} else {
    $sql2 = "SELECT  flat_info.flat_no, flat_info.flat_title, flat_info.dokan_vara_gl, gl_acc_code.acc_code FROM  flat_info, gl_acc_code where flat_info.flat_no=$flat_no and  flat_info.dokan_vara_gl = gl_acc_code.acc_code ORDER BY flat_info.dokan_vara_gl";
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
            <h1><i class="fa fa-dashboard"></i>Paid List</h1>
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
                    <td> As on Date: <input type="date" name="last_paid_date" id="" class="form-control" required></td>
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
                                
                                <td> As On Date: <input type="date" name="last_paid_dat" id="" class="form-control" required></td>
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
                $last_paid_date = $_POST['last_paid_date'];
            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h3 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h3> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <h4 style="text-align:center" id="reportTitle"> Paid Slip</h4>
                <div id="AsOnDate">
                    <h4  style="text-align:center"> <?php echo "As on Date:"; echo  $last_paid_date; ?></h4> 
                </div>
               
                <!-- report view option -->
                <br><br>
                <?php
                        $d = 0;
                        $no = 1;
                        $owner_id = 0;
                        $tot_cr_amt =0.00;
                        $tot_dr_amt=0.00;
            
                if (isset($_POST['submit'])) {
                    
                    $last_paid_date = $conn->escape_string($_POST['last_paid_date']);
                    if (empty($gl_acc_code)) {

                            $sql="SELECT  vara_receive_detail.flat_no, vara_receive_detail.paid_date, vara_receive_detail.paid_upto,dokan_vara_detail.flat_no,dokan_vara_detail.last_paid_date, flat_info.flat_no,flat_info.flat_title FROM `dokan_vara_detail`,flat_info,vara_receive_detail WHERE flat_info.dokan_vara_gl=vara_receive_detail.dokan_vara_gl and flat_info.flat_no=dokan_vara_detail.flat_no and dokan_vara_detail.last_paid_date <='$last_paid_date' group by vara_receive_detail.flat_no order by flat_info.flat_no";
                        }else {

                            $sql="SELECT  vara_receive_detail.flat_no, vara_receive_detail.paid_date, vara_receive_detail.paid_upto,dokan_vara_detail.flat_no,dokan_vara_detail.last_paid_date, flat_info.flat_no,flat_info.flat_title FROM `dokan_vara_detail`,flat_info,vara_receive_detail WHERE flat_info.dokan_vara_gl=vara_receive_detail.dokan_vara_gl and flat_info.flat_no=dokan_vara_detail.flat_no and dokan_vara_detail.last_paid_date <='$last_paid_date' group by vara_receive_detail.flat_no order by flat_info.flat_no";

                        }
                $query = $conn->query($sql);
                ?> 
                  <div id="">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">
                                <th>Member No.</th>
                                <th>Name</th>
                                <th>Last Paid Date</th>
                                <th>action</th>
                        </thead>

                        <body>
                            
                            <?php
                            
                            while ($row = $query->fetch_assoc()) {
                                            
                      echo "<tr>";
                      echo "<td>" . $row['flat_no'] . "</td>";
                      echo "<td>" . $row['flat_title'] . "</td>";
                      echo "<td>" . $row['last_paid_date'] . "</td>";
                    ?>  
                
                      <td> <a id='print' title="Print Slip" class="btn btn-success" href="vara_paid_slip.php?flat_no=<?php echo  $row['flat_no']; ?>&last_paid_date=<?php echo  $row['last_paid_date']; ?>"></i>Print Slip</a></td>

                               
                            </tr>
                        <?php
                            }
                        }
                            ?>

                      <tfoot>
                        <tr style="background-color:powderblue";>
                                <!-- <th style="text-align:right" colspan="5"> Total Amount in TK.</th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_dr_amt; ?></th>
                                <th style="text-align:right" colspan="1"><?php echo ($tot_dr_amt - $tot_cr_amt); ?></th>   -->
                            </tr>
                        </tfoot>
                        </body>
                        
                    </table>
                   
              <!-- <div style=
                'padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $q; ?></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $b;?></div></div> -->
                <?php
                // require "report_footer.php";
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