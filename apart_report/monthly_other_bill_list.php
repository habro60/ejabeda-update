<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
// $pid= 701000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";

// session //
$role_no     = 99; // admin 99 superadmin 100
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
// $office_code = $_SESSION['office_code'];
// $org_name    = $_SESSION['org_name'];
// $org_logo    = $_SESSION['org_logo'];
// $org_no      = $_SESSION['org_no'];
$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>

<main class="app-content">
    <!-- page title -->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Monthly Maintenance Bill List</h1>
            
            
        </div>
        <div class="pull-right">
               
                <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
                
            </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-12">
            <!-- filter option -->
            <form method="POST">
                <table id="form_class_id" class="table-responsive">
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
                                <input type="month" name="bill_for_month" class="form-control" id="Fmth" onBlur="FmonthCheck()" placeholder="mm/yyyy" reruired>
                                 </td>
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
                $bill_for_month = $_POST['bill_for_month'];
                $org_name    = $_SESSION['org_name'];
                $org_addr1 = $_SESSION['org_addr1'];
                $org_email = $_SESSION['org_email'];
                $org_tel = $_SESSION['org_tel'];
                $org_logo    = $_SESSION['org_logo'];
            ?>
            <?php
               $sql = "select  sum(bill_amount) as total_bill from apart_owner_bill_detail where pay_method='fixed' and bill_for_month='$bill_for_month'";
               $return = mysqli_query($conn, $sql);
               $billSum = mysqli_fetch_assoc($return);
              ?>
                <!-- report header -->
                <div>
    
        <h4 style="text-align:center; margin-top:60px;"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;margin-right:10px;"><?php echo $org_name; ?></h4>
    </div>
    <div id="organizationAdd">
                    <p style="text-align:center"> <?php echo $org_addr1;echo ",<br> "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></p> 
             </div>
             
             <div id="reporttitle">
                     <h6 style="text-align:center" id="reportTitle"><b>Report Title :  </b>Monthly Maintainence bill</h6> 
                </div>
               
                
                <!-- report view option -->
                <br><br>
                <?php
                if (!empty($officeId)) {
                    $officeId = $_POST['officeId'];
                    $bill_for_month = $_POST['bill_for_month'];
                    
                    
                            $no='1';
                            $owner_id = 0;
                            // $dr_amt_loc =0.00;
                            $totSum=0.00;
                    $sql = "SELECT apart_owner_bill_detail.owner_id,apart_owner_bill_detail.flat_no,apart_owner_bill_detail.bill_for_month,apart_owner_bill_detail.bill_charge_name,apart_owner_bill_detail.bill_amount,apart_owner_info.owner_name,tran_details.dr_amt_loc from apart_owner_bill_detail,tran_details, apart_owner_info where apart_owner_bill_detail.owner_id=apart_owner_info.owner_id and apart_owner_bill_detail.pay_method='fixed' and apart_owner_bill_detail.owner_gl_code=tran_details.gl_acc_code and tran_details.batch_no=apart_owner_bill_detail.batch_no and apart_owner_bill_detail.bill_for_month='$bill_for_month' and apart_owner_bill_detail.bill_amount >'0' order by apart_owner_bill_detail.flat_no";
                    
                  
                } else {
                    echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select for Month</h1>";
                    exit;
                }
                $query = $conn->query($sql);
                ?>
                <div id="mySelector">
                    <table style="width:850px;margin-left:100px;margin-top:1px;border-collapse: collapse;" class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">

                            <th style="border: 1px solid black;">Sl. No.</th>
                            <th style="border: 1px solid black;">Shop/Merchant Name</th>
                            <th style="border: 1px solid black;">Shop/Flat No.</th>
                            <th style="border: 1px solid black;">Services Name</th>
                            <th style="border: 1px solid black;">Charge Amount.</th>
                            <th style="border: 1px solid black;">Merchant Bill Amt.</th>

                        </thead>

                        <body>
                            
                            <?php
                            while ($rows = $query->fetch_assoc()) {
                            ?>
                                <tr>
                                <td style="text-align: left;border: 1px solid black;"><?php if ($rows['owner_id'] != $owner_id) {
                                    echo $no++;
                                    

                                } else {
                                    echo "";
                                }?></td>  

                             <td style="text-align: left;border: 1px solid black;"><?php if ($rows['owner_id'] != $owner_id) {
                                    echo $rows['owner_name']; 
                                } else {
                                    echo "";
                                }?></td>  

                              <td style="text-align: center;border: 1px solid black;"><?php echo $rows['flat_no'];?></td>
        
                              <td style="background-color:powderblue; text-align: left;border: 1px solid black;"><?php 
                                        echo $rows['bill_charge_name'];?></td>        

                              <td style="background-color:powderblue; text-align: right;border: 1px solid black;"><?php echo $rows['bill_amount']; 
                                    $totSum = $totSum + $rows['bill_amount']; ?></td>

                                <td style="text-align: right;border: 1px solid black;"><?php if ($rows['owner_id'] != $owner_id) {
                                    echo $rows['dr_amt_loc']; 
                                    $owner_id = $rows['owner_id'];
                                } else {
                                    echo "";
                                }?></td>
                           
                        </tr>
                        <?php
                            }
                           
                            ?>
                        </body>
                        
                    </table>
                    <div style="margin-left:700px;" class="row">
                              <h4 style="color:black;font-weight:bold;"><?php echo "Total Bill in TK.:"; echo $billSum['total_bill']; ?></h4>
                        </div>
              <div style=
                'padding:80px'><div style='float:left;text-align:left;line-height:100%;margin-top:130px;'><label>--------------------</label><br><?php echo $q; ?> Created by</div><div style='float:right;text-align:right;line-height:100%;margin-top:130px;'><label>--------------------------</label><br><?php echo $b;?> Authorized by</div></div>
                <?php
                require "report_footer.php";
                ?>
            <?php
            } else {
                echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select for Month</h1>";
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

<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>

<script type="text/javascript">
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })
    $(document).ready(function() {
        $("#701000").addClass('active');
        $("#700000").addClass('active');
        $("#700000").addClass('is-expanded');
    });
</script>

<script>
    $(document).ready(function() {
       
        $("#print").click(function() {
            
           // alert('sdsd');
             $("#form_class_id").hide();
        });
    });
</script>
</body>

</html>