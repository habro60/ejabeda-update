<?php

require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
$pid = 1003000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
require "../setting/setting.php";

// session //
$office_code = $_SESSION['office_code'];
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_addr1 = $_SESSION['org_addr1'];
$org_email = $_SESSION['org_email'];
$org_tel = $_SESSION['org_tel'];  
$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];

function timeago($datetime, $full = false) {
    date_default_timezone_set('Asia/Dhaka');
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
    'y' => 'yr',
    'm' => 'mon',
    'w' => 'week',
    'd' => 'day',
    'h' => 'hr',
    'i' => 'min',
    's' => 'sec',
    );
    foreach ($string as $k => &$v) {
    if ($diff->$k) {
        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } 
    else {
        unset($string[$k]);
    }
    }
    if (!$full) {
    $string = array_slice($string, 0, 1);
    }
    
    return $string ? implode(', ', $string) . '' : 'just now';
}


?>

<style>
    .cols6 {
        -webkit-box-flex: 0;
        -ms-flex: 0;
        flex: 45%;
        max-width: 50%;
    }
</style>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    
    <script src="https://kit.fontawesome.com/f826455fa9.js" crossorigin="anonymous"></script>

    <title>Parking Bill Report</title>
  </head>
  <body>


  <main class="app-content">
  <div class="app-title">
        <h1><i class="fa fa-dashboard"></i> Parking Bill Report </h1>
    </div>

    <?php
            if (isset($_POST['submit'])) {
                $startdate = $_POST["startdate"];
                $enddate = $conn->escape_string($_POST["enddate"]);
            }
            ?>
        <div class="card">
            <div class="card-header">

                <!-- <h3 class="card-title">Parking Bill Report</h3> -->

                <div class="container">
                    <div style="text-align: right;">
                       
                        <a id='print' title="Print" class="btn btn-outline-success btn-sm" href="javascript:window.print()"><i class="fa fa-print"></i>PRINT</a>
                    </div>
                </div>

            </div>

            <div id="organizationName">
                <h3 style="text-align:center; padding-top:40px"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:20px;height:20px;"> <?php echo $org_name; ?></h3>
            </div>
            <div id="organizationAdd">
                    <h4 style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
             </div>
                <div id="reporttitle">
                     <h5 style="text-align:center" id="reportTitle">Parking Bill Report</h5> 
                </div>
                <div id="AsOnDate">
                    <p  style="text-align:center; font-weight:bold"> <?php echo "From:"; echo $startdate; ?> To <?php echo $enddate; ?></p> 
                </div>

        <div class="card-body">
        <br>
        <div id="mySelector">
               
            <table class="table table-hover table-bordered table-sm" id="studentTable" class="display" style="width:100%">

                    <thead>
                        <tr>
                        <th>SL NO</th>
                        <th>IN Time</th>
                        <th>Out Time</th>
                        <th>Token No</th>
                        <th>Parking Charge</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php

                        $counter = 0;

                        // $hour_diff=mysqli_query($conn,"SELECT CONCAT(MOD(HOUR(TIMEDIFF(`in_time`,`out_time`)), 24)) AS difference from car_mov_reg");


                        // $cid=$_GET['viewid'];
                        
                        $ret=mysqli_query($conn,"SELECT id,in_time,out_time,total_parking_cost, CONCAT( FLOOR(HOUR(TIMEDIFF(`in_time`,`out_time`)) / 24), ' DAYS ',MOD(HOUR(TIMEDIFF(`in_time`,`out_time`)), 24), ' HOURS ',
                        MINUTE(TIMEDIFF(`in_time`,`out_time`)), ' MINUTES ') AS difference from car_mov_reg where date(in_time) between '$startdate' and '$enddate' and status='Out'");
                    
                        while ($row=mysqli_fetch_array($ret)) {

                            $date= $row['in_time'];
                            $date2= $row['out_time'];
                            $time_diff= $row['difference'];

                    ?>

                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo date('d-M-y g:i a', strtotime($row['in_time'])) ?></td>
                    <td><?php echo date('d-M-y g:i a', strtotime($row['out_time'])) ?></td>
                    <td><?php echo $row['id'] ?></td>
                    <!-- <td><?php echo (strtotime($date2)-strtotime($date))/3600 ?></td> -->

                    <td><?php echo $row['total_parking_cost'];echo' TK'; ?></td>
                    
                     
                        </tr>

                        

                    <?php
                
                } ?>  

                    
                    </tbody>
                    <tfoot>
                        <tr>
                        <th>SL NO</th>
                        <th>IN Time</th>
                        <th>Out Time</th>
                        <th>Token No</th>
                        <th>Parking Charge</th>
                        
                        </tr>
                    </tfoot>
                   
                </table>

            </div>

            <div style=
                'padding:80px'><div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $q; ?></div><div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $b;?></div></div>
                </div>
            
            </div>
        </div>
</main>

<?php
require "report_footer.php";
?>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<!-- Data table plugin-->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#studentTable').DataTable();
 
</script>

<script type="text/javascript">

//  print js
$(document).on('click', '.print', function () {

var organizationName = $('#organizationName').text();
var organizationAdd = $('#organizationAdd').text(); 
var ownername = $('#ownername').text();
var reportTitle = $('#reportTitle').text();
var billno = $('#billno').text();
var header = `<div>
                <h1 style="text-align:center">${organizationName}</h1>
                <h3 style="text-align:center">${organizationAdd}</h3>
                </div>
                <h1 style="text-align:center" id="reportTitle">${reportTitle}</h1>
                <div>
                <h2 style="text-align:left">${ownername}</h2>
                </div>
                <div>
                <h2 style="text-align:left">${billno}</h2>
                </div>
               <div>
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