<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
// $pid= 701000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";

// session //
// $role_no     = 99; // admin 99 superadmin 100
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
$office_code = $_SESSION['office_code'];
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_no      = $_SESSION['org_no'];
$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>
<?php
  $sql = "select  sum(bill_amount) as total_bill from monthly_bill_entry";
  $return = mysqli_query($conn, $sql);
  $billSum = mysqli_fetch_assoc($return);
  ?>
<main class="app-content">
    <!-- page title -->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Monthly Electric Bill List</h1>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-12">
            <!-- filter option -->
            <form method="POST">
                <table class="table-responsive">
                    <thead>
                        <?php
                        if ($role_no== '100' || '99') {
                        ?>
                        <th>Office</th>
                        <?php 
                        }
                        ?>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            if ($role_no== '100' || '99') {   
                            $option = "SELECT office_code,office_name from office_info";
                            $query = $conn->query($option);
                            ?>
                            <td>
                                <select name="officeId" class="form-control select2" id="" style="width: 180px;">
                                    <option value="">-Select Office-</option>
                                    <?php
                                    while ($rows = $query->fetch_assoc()) {
                                        echo '<option value=' . $rows['office_code'] . '>' . $rows['office_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <?php
                               }
                            ?>
                            
                            <td>
                                <input type="submit" name="submit" id="submitBtn" class="btn btn-info" value="Report View">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <!-- end filter option -->
            <?php
            if (isset($_POST['submit'])) {
                
                $officeId = $_POST['officeId'];
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
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo " ,"; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <h5 style="text-align:center" id="reportTitle">Monthly Electric Bill</h5>
               
                <div class="pull-right">
                    <a id="Print" class="btn btn-danger print" target="_blank"></i>Print</a>
                </div>
                <!-- report view option -->
                <br><br>
                <?php
                if (!empty($officeId)) {
                    $officeId = $_POST['officeId'];
                    $sql = "SELECT monthly_bill_entry.office_code,monthly_bill_entry.bill_for_month,monthly_bill_entry.flat_no,monthly_bill_entry.bill_charge_code,monthly_bill_entry.bill_charge_name,monthly_bill_entry.prev_unit,monthly_bill_entry.prev_unit_dt,monthly_bill_entry.curr_unit,monthly_bill_entry.curr_unit_dt,monthly_bill_entry.net_unit,unit_rate.per_unit_rate,unit_rate.fixed_rent,unit_rate.vat_rate, monthly_bill_entry.bill_amount, apart_owner_info.owner_name, monthly_bill_entry.owner_id, monthly_bill_entry.owner_gl_code, gl_acc_code.acc_head FROM `monthly_bill_entry`,unit_rate, apart_owner_info, gl_acc_code WHERE monthly_bill_entry.office_code=$officeId and monthly_bill_entry.owner_id=apart_owner_info.owner_id and monthly_bill_entry.owner_gl_code=gl_acc_code.acc_code";
                } else {
                    $sql = "SELECT monthly_bill_entry.office_code,monthly_bill_entry.bill_for_month,monthly_bill_entry.flat_no,monthly_bill_entry.bill_charge_code,monthly_bill_entry.bill_charge_name FROM `monthly_bill_entry` WHERE monthly_bill_entry.office_code=$officeId";
                }
                $query = $conn->query($sql);
                ?>
                <div id="mySelector">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">
                            <th>Bill For Month</th>
                            <th>Shop/Flat No.</th>
                            <th>Shop/Merchant Name</th>
                            <th>Previous Unit</th>
                            <th>Prev. Date</th>
                            <th>Current Unit</th>
                            <th>Curr. Date</th>
                            <th>Net Unit</th>
                            <th>Per Unit Rate</th>
                            <th>Demand Charge</th>
                            <th>Vat</th>
                            <th> Bill Amount</th>                           
                            
                        </thead>

                        <body>
                        
                            <?php
                            while ($rows = $query->fetch_assoc()) {
                                echo
                                "<tr>
                            <td>" . $rows['bill_for_month'] . "</td>
                            <td>" . $rows['flat_no'] . "</td>
                            <td>" . $rows['owner_name'] . "</td> 
                            <td>" . $rows['prev_unit'] . "</td>
                            <td>" . $rows['prev_unit_dt'] . "</td>
                            <td>" . $rows['curr_unit'] . "</td>
                            <td>" . $rows['curr_unit_dt'] . "</td>
                            <td>" . $rows['net_unit'] . "</td>
                            <td>" . $rows['per_unit_rate'] . "</td>
                            <td>" . $rows['fixed_rent'] . "</td>
                            <td>" . $rows['vat_rate'] . "</td>
                            <td>" . $rows['bill_amount'] . "</td>
                           
                        </tr>";
                            }
                           
                            ?>
                        </body>
                        
                    </table>
                    <div class="row">
                              <h4 style="color:black;font-weight:bold"><?php echo "Total Bill in TK.:"; echo $billSum['total_bill']; ?></h4>
                        </div>
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
    	            <h3 style="text-align:center">${organizationName}</h3>
                    <h4 style="text-align:center">${organizationAdd}</h4>
                 </div>
                    <h5 style="text-align:center" id="reportTitle">${reportTitle}</h5>`;
                    
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