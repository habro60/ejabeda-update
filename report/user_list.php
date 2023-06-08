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
<main class="app-content">
    <!-- page title -->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> User List</h1>
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
                $org_logo    = $_SESSION['org_logo'];
            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2> 
                </div>
                <h4 style="text-align:center" id="reportTitle">User List</h4>
               
                <div class="pull-right">
                    <a id="Print" class="btn btn-danger print" target="_blank"></i>Print</a>
                </div>
                <!-- report view option -->
                <br><br>
                <?php
                if (!empty($officeId)) {
                    $officeId = $_POST['officeId'];
                    $sql = "SELECT  office_info.office_name, user_info.office_code, user_info.username, user_info.sa_role_no,user_info.user_create_date, user_info.user_status, sm_role.role_name from user_info, sm_role, office_info where user_info.sa_role_no=sm_role.role_no and user_info.office_code='$officeId'";
                } else {
                    $sql = "SELECT  office_info.office_name, user_info.office_code, user_info.username, user_info.sa_role_no,user_info.user_create_date, user_info.user_status, sm_role.role_name from user_info, sm_role, office_info where user_info.sa_role_no=sm_role.role_no and user_info.office_code=office_info.office_code";
                }
                $query = $conn->query($sql);
                ?>
                <div id="mySelector">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">
                            <th>Office </th>
                            <th> User Name </th>
                            <th>Role </th>
                            <th>Creat Date </th>
                            <th>Status </th>
                        </thead>

                        <body>
                        
                            <?php
                            while ($rows = $query->fetch_assoc()) {
                                echo
                                "<tr>
                            <td>" . $rows['office_name'] . "</td>
                            <td>" . $rows['username'] . "</td>
                            <td>" . $rows['role_name'] . "</td>
                            <td>" . $rows['user_create_date'] . "</td> 
                            <td>" . $rows['user_status'] . "</td>
                           
                        </tr>";
                            }
                           
                            ?>
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
    var reportTitle = $('#reportTitle').text();
    var header = `<div>
    	            <h1 style="text-align:center">${organizationName}</h1>
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