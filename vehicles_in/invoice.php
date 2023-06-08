<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Voucher </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <!-- <form><input type="button" value="GO BACK " onclick="history.go(-1);return true;" /></form> -->
            <div class="pull-right">
               
                <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
               
            </div>
        </ul>
    </div>
    <?php
    $sql2 = "SELECT `org_logo`, `org_name` FROM `org_info`";
    $returnD = mysqli_query($conn, $sql2);
    $result = mysqli_fetch_assoc($returnD);
    ?>
    <div>
        <!-- <img src="../upload/logo.png" alt="logo" style="width:100px;higher:100px;text-align:center">  -->
        <h2 style="text-align:center"><img src="../upload/<?php echo $result['org_logo']; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $result['org_name']; ?></h2>
    </div>
    <div>
        <h4 style="text-align:center">ENTRY SLIP </h4>
        <?php
        if (isset($_GET['recortid'])) {

           // echo $_GET['recortid'];
            $id = $_GET['recortid'];
            // $batch =$_GET['batch_no'];
            $sql = "SELECT * FROM `car_mov_reg` WHERE `id`='$id'";
            $query = $conn->query($sql);
            $row = $query->fetch_assoc();
        ?>
            <div class="row">
                <div class="col-md-12">
                    <br>
                    
                    <table  align="center" cellpadding="0" cellspacing="0" style="width: 35%;border:1px solid black;margin-bottom: 10px; padding-right:0px;">
                        <tr class="active">
                            <th style="padding: 15px; text-align:center;">IN TIME</th>
                            <th style="padding-right: 35px; text-align:center;">TOKEN NO</th>
                           
                        </tr>
                        <tbody>
                            <?php

                            $id = $_GET['recortid'];

                            $sql2 = "SELECT * FROM `car_mov_reg` WHERE `id`='$id'";
                            $query2 = $conn->query($sql2);
                            while ($rows = $query2->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td style="padding: 15px; text-align:center;"> <?php echo $rows['in_time']; ?></td>
                                    <td style="padding-right: 35px; text-align:center;"> <?php echo $rows['id']; ?></td>
                                   
                                </tr>
                        <?php
                            }
                        }
                        // $conn->close();
                        ?>
                        </tbody>
                       
                           
                    </table>
                </div>
                <!-- ----------------code here---------------->
            </div>
    </div>
</main>
<?php
require "report_footer.php";
?>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
    </script>


    <script>
    $(document).ready(function() {
        $('#studentTable').DataTable();
    });
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