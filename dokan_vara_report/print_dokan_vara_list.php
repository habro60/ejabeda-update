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

?>

<main class="app-content">
    <!-- page title -->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dokan Vara List</h1>
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
                $q      = $_SESSION['org_rep_footer1'];
                $b      = $_SESSION['org_rep_footer2'];
            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h3 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h3> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo " ,"; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <h5 style="text-align:center" id="reportTitle">Dokan Vara List</h5>
               
                <div class="pull-right">
                    <a id="Print" class="btn btn-danger print" target="_blank"></i>Print</a>
                </div>
                <!-- report view option -->
                <br><br>
                <?php
                if (!empty($officeId)) {
                    $officeId = $_POST['officeId'];
                    $sql = "SELECT flat_info.flat_no,flat_info.flat_title, dokan_vara_detail.donner_pay_amt, dokan_vara_detail.effect_date, dokan_vara_detail.allow_flag FROM flat_info, dokan_vara_detail where flat_info.flat_no=dokan_vara_detail.flat_no order by flat_info.flat_no";
                } else {
                    $sql = "SELECT flat_info.flat_no,flat_info.flat_title, dokan_vara_detail.donner_pay_amt, dokan_vara_detail.effect_date, dokan_vara_detail.allow_flag FROM flat_info, dokan_vara_detail where flat_info.flat_no=dokan_vara_detail.flat_no order by flat_info.flat_no";
                }
                $query = $conn->query($sql);
                ?>
                <div id="mySelector">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">
                             <th>Sl.NO.</th>
                            <th>Dokan No.</th>
                            <th>Dokan Name</th>
                            <th>Vara in TK.</th>
                            <th>Start/Close Date</th>
                            <th></th>
                            <th>Start/Close Status</th>


                        </thead>

                        <body>
                        
                            <?php
                            $no='1';
                            $close_no='0';
                            $runing_no='0';
                            $close_tot_amt='0';
                            $runing_tot_amt='0';
                            while ($rows = $query->fetch_assoc()) {
                             ?> 
                             <tr> 
                                  <?php
                                    if ($rows['allow_flag'] == 0)  {
                                        ?>
                                        <td style="background-color:lightgray; text-align: right"><?php echo $no; $no++; $close_no++?></td>
                                        <td style="background-color:lightgray; text-align: right"><?php echo $rows['flat_no']; ?></td>
                                        <td style="background-color:lightgray; text-align: right"><?php echo $rows['flat_title']; ?></td>
                                        <td style="background-color:lightgray; text-align: right"><?php echo $rows['donner_pay_amt']; $close_tot_amt = $close_tot_amt + $rows['donner_pay_amt'];?></td>

                                        <td style="background-color:lightgray; text-align: right"><?php echo $rows['effect_date']; ?></td>
                                        <td style="background-color:lightgray; text-align: right"><?php echo ""; ?></td>

                                        <td style="background-color:lightgray; text-align: right"><?php if ($rows['allow_flag'] == '1') {
                                    echo "Running"; 
                                } else {
                                    echo "Stop";
                                }?></td>   
                                        <?php
                                    }
                                elseif  ($rows['allow_flag'] == 1) {
                                    ?>
                                <td style="background-color:white; text-align: right"><?php echo $no; $no++; $runing_no++?></td>
                                <td style="background-color:white; text-align: right"><?php echo $rows['flat_no']; ?></td>
                                <td style="background-color:white; text-align: right"><?php echo $rows['flat_title']; ?></td>
                                <td style="background-color:white; text-align: right"><?php echo $rows['donner_pay_amt']; $runing_tot_amt = $runing_tot_amt + $rows['donner_pay_amt'];?></td>

                                <td style="background-color:white; text-align: right"><?php echo $rows['effect_date']; ?></td>   
                                <td style="background-color:white; text-align: right"> 
                                <td style="background-color:white; text-align: right"><?php echo ""; ?></td>
                                 <td style="background-color:white; text-align: right"><?php if ($rows['allow_flag'] == '1') {
                                    echo "Running"; 
                                } else {
                                    echo "Stop";
                                }?></td>
                                <?php  
                                        
                                        }
                                            ?>
                            <?php
                                        }
                                    ?>
                                    </tr>

                            <tfoot>
                            <tr style="background-color:powderblue";>
                                <th style="text-align:left" colspan="1"> Total Close Dokan</th>
                                <th style="text-align:left" colspan="1"><?php echo $close_no; ?></th>  
                                <th style="text-align:left" colspan="1">Colse Vara Amt.</th>
                                <th style="text-align:left" colspan="1"><?php echo $close_tot_amt; ?></th>

                                <th style="text-align:left" colspan="1"> Total Running Dokan</th>
                                <th style="text-align:left" colspan="1"><?php echo $runing_no; ?></th>  
                                <th style="text-align:left" colspan="1">Running Vara Amt.</th>
                                <th style="text-align:left" colspan="1"><?php echo $runing_tot_amt; ?></th>

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
    	            <h3 style="text-align:center">${organizationName}</h1>
                    <h4 style="text-align:center">${organizationAdd}</h3>
                 </div>
                    <h5 style="text-align:center" id="reportTitle">${reportTitle}</h1>`;
                    
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