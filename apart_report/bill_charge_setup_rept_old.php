<?php
require "../auth/auth.php";
require '../database.php';
require '../source/top.php';
// $pid= 706000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require '../source/header.php';
require '../source/sidebar.php';

// session //
$office_code = $_SESSION['office_code'];
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_no      = $_SESSION['org_no'];
$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>


<main class="app-content">
    <div class="app-title">
        <div style="width: 100%;">
            <h1><i class="fa fa-dashboard"></i> Balance Sheet </h1>
        </div>
    </div>
    <form method="POST">
        <table class="table-responsive table-striped">
            <thead>
                <th>Office</th>
                <th> As on Date </th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <?php
                    // if () {   
                    // }
                    $option = "SELECT office_code,office_name from office_info";
                    $query = $conn->query($option);
                    ?>
                    <td>
                        <select name="officeId" class="form-control select2" id="" style="width: 180px;">
                        <option value="">- Select -</option>
                            <?php
                            while ($rows = $query->fetch_assoc()) {
                                echo '<option value=' . $rows['office_code'] . '>' . $rows['office_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <?php
                    ?>
                    <td>
                        <input type="submit" name="submit" id="submitBtn" class="btn btn-info" value="Report View">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <div>
        <?php
        if (isset($_POST['submit'])) {
            $enddate = $conn->escape_string($_POST['enddate']);

                $org_name    = $_SESSION['org_name'];
                $org_addr1 = $_SESSION['org_addr1'];
                $org_email = $_SESSION['org_email'];
                $org_tel = $_SESSION['org_tel'];
                $org_logo    = $_SESSION['org_logo'];
            

        ?>
            <div id="organizationName">
                <h3 style="text-align:center; padding-top:40px"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:20px;height:20px;"> <?php echo $org_name; ?></h3>
            </div>
            <div id="organizationAdd">
                    <h4 style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
             </div>
                <div id="reporttitle">
                     <h5 style="text-align:center" id="reportTitle">Balance Sheet</h5> 
                </div>
                <div id="AsOnDate">
                    <p  style="text-align:center; font-weight:bold"> <?php echo "As on Date :-  $enddate";  ?></p> 
                </div>
                <div class="row" style="margin-bottom: 5px">
                    <div class="pull-right">
                        <a id="Print" class="btn btn-success print" target="_blank"></i>Print Report</a>
                    </div>
                </div>
            <div id="mySelector">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-hover table-striped">
                            <thead class="reportHead" style="background-color: #138496;">
                                <tr style="text-align:center">
                                    <th colspan="4">Services</th>
                                </tr>
                            </thead>
                            <tr>
                                <th>Flat No.</th>
                                <th>Charge Name</th>
                                <th>Charge Amount</th>
                            </tr>
                            <tbody>
                                <?php
                                $sql1 = "SELECT apart_owner_sevice_facility.flat_no,apart_owner_sevice_facility.bill_charge_code,apart_owner_sevice_facility.bill_charge_name,apart_owner_sevice_facility.bill_fixed_amt FROM `apart_owner_sevice_facility` order by apart_owner_sevice_facility.flat_no";
                                $query = $conn->query($sql1);
                                while ($rows = $query->fetch_assoc()) {
                                ?>
                                    <tr> <?php
                                        if ($rows['bill_charge_code'] == '1')  { ?>
                                                <td style="text-indent:  right 20px"><?php echo $rows['flat_no'];?></td>
                                                <td style="text-align: right"><?php echo $rows['bill_charge_name']; ?></td>
                                                <td style="text-align: right"><?php echo $rows['bill_fixed_amt'];
                                                 $total_services=$total_services = $rows[''] ?></td>
                                           
                                            }
                                    <?php
                                    }
                                    ?>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total Services</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table table-hover table-striped">
                            <thead class="reportHead" style="background-color: #138496;">
                                <tr style="text-align:center">
                                    <th colspan="4">Generator</th>
                                </tr>
                            </thead>
                            <tr>
                                <th>Flat No.</th>
                                <th>Charge Name</th>
                                <th>Charge Amount</th>
                            </tr>
                            <tbody>
                                <?php
                                $sql1 = "SELECT apart_owner_sevice_facility.flat_no,apart_owner_sevice_facility.bill_charge_code,apart_owner_sevice_facility.bill_charge_name,apart_owner_sevice_facility.bill_fixed_amt FROM `apart_owner_sevice_facility` order by apart_owner_sevice_facility.flat_no";
                                $query1 = $conn->query($sql1);
                                while ($row = $query1->fetch_assoc()) {
                                ?>
                                    <tr>
                                    <tr> <?php
                                        if ($rows['bill_charge_code'] == '3')  { ?>
                                                 $tot_services = ($tot_services + $rows['liab_balance']);
                                                <td style="text-indent:  right 20px"><?php echo $rows['flat_no'];?></td>
                                                <td style="text-align: right"><?php echo $rows['bill_charge_name']; ?></td>
                                                <td style="text-align: right"><?php echo $rows['bill_fixed_amt']; ?></td>
                                           
                                            }
                                    <?php
                                    }
                                    ?>
                                    </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total Services</th>
                                    <th style="text-align: right"><strong><?php echo $expense['dr_balance']; ?></strong></th>
                                </tr>
                                <tr>
                                    <th colspan="1" style="text-align: right"> Total</th>
                                    <th style="text-align: right"><strong><?php echo ($total_asset + $expense['dr_balance']); ?></strong></th>
                                </tr>
                            </tfoot>
                        <?php
                    } else {
                        echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select Date</h1>";
                    }
                        ?>
                        </table>   
                <?php        
                require "report_footer.php";
                ?>
            </div>
         </div>
         <div style='padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $q; ?></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $b;?></div></div>
    </div>
</div>
</main>
<?php
require "report_footer.php";
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
    var AsOnDate = $('#AsOnDate').text();
    var header = `<div>
    	            <h3 style="text-align:center">${organizationName}</h3>
                    <h4 style="text-align:center">${organizationAdd}</h4>
                    </div>
                    <h5 style="text-align:center" id="reportTitle">${reportTitle}</h5>
                    </div>
                    
                    <div>
                    <p style="text-align:center; font-weight:bold">${AsOnDate}</p>
                    </div>
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