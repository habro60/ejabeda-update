<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";
if (empty($member_id)) {
    $sql2 = "SELECT  fund_member.member_id, fund_member.full_name,fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.gl_acc_code = gl_acc_code.acc_code ORDER BY fund_member.member_id";
} else {
    $sql2 = "SELECT  fund_member.member_id, fund_member.full_name,fund_member.gl_acc_code, gl_acc_code.acc_code FROM  fund_member, gl_acc_code where fund_member.member_id = '$member_id' and gl_acc_code.acc_code=fund_member.gl_acc_code ORDER BY fund_member.member_id; ";
}

$role_no     = 99; // admin 99 superadmin 100
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100

$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>

<main class="app-content">
    <!-- page title -->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Notice To All Member</h1>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-12">
            <!-- filter option -->
            <form method="POST">
                <?php if (empty($member_id)) {
                ?>
                    <table id="submit">
                        <form method="POST">
                            <div class="form-group">
                                <h4 class="text-center">Notice Message</h4>
                                <textarea class="form-control" name="text_message" id="text_message" rows="7"></textarea>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit">
                            </div>
                        </form>
                    </table>

                    <?php
                    if (isset($_POST['submit'])) {

                        $text_notice = $_POST['text_message'];
                        $org_name    = $_SESSION['org_name'];
                        $org_addr1 = $_SESSION['org_addr1'];
                        $org_email = $_SESSION['org_email'];
                        $org_tel = $_SESSION['org_tel'];
                        $org_logo    = $_SESSION['org_logo'];
                        $_SESSION['smsDate'] = date('Y-m-d');

                        //echo $text_notice;
                        // die;
                    ?>
                        <!-- report header -->
                        <div id="organizationName">
                            <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
                        </div>
                        <div id="organizationAdd">
                            <h4 style="text-align:center"> <?php echo $org_addr1;
                                                            echo ", ";
                                                            echo  "E-Mail:";
                                                            echo $org_email;
                                                            echo ", ";
                                                            echo "Tele:";
                                                            echo $org_tel; ?></h4>
                        </div>
                        <h4 style="text-align:center" id="reportTitle">Member List</h4>
                        <div class="pull-right">
                            <a id='SMS' title="Send SMS" class="btn btn-success" href="SMS_notice.php?message=<?php echo $text_notice; ?>"></i>SMS Notice</a>
                        </div>
                        <br><br>

                        <div id="mySelector">
                            <table class="table table-hover table-striped" id="sampleTable">
                                <thead class="reportHead" style="background-color: green;">

                                    <tr style="background-color:powderblue; text-align: left" ;>
                                        <th>Member No.</th>
                                        <th>Member Name</th>
                                    </tr>
                                </thead>

                                <body>
                                    <?php
                                    $sql = "SELECT member_no, full_name FROM `fund_member`";
                                    $query = $conn->query($sql);
                                    while ($rows = $query->fetch_assoc()) {
                                    ?>
                                        <tr>

                                            <td style="background-color:powderblue; text-align: left"><?php echo $rows['member_no']; ?></td>
                                            <td style="background-color:powderblue; text-align: left"><?php echo $rows['full_name']; ?></td>


                                        </tr>
                                <?php
                                    }
                                }
                                ?>

                                <tfoot>

                                </tfoot>
                                </body>

                            </table>


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
    $(document).on('click', '.print', function() {

        var organizationName = $('#organizationName').text();
        var organizationAdd = $('#organizationAdd').text();
        var reportTitle = $('#reportTitle').text();
        var AsOnDate = $('#AsOnDate').text();
        var header = `<div>
    	            <h1 style="text-align:center">${organizationName}</h1>
                    <h3 style="text-align:center">${organizationAdd}</h3>
                 </div>
                    <h1 style="text-align:center" id="reportTitle">${reportTitle}</h1>;
                    <h1 style="text-align:center" id="reportTitle">${AsOnDate}</h1>`;

        $("#mySelector").printThis({
            debug: false, // show the iframe for debugging
            importCSS: true, // import parent page css
            importStyle: false, // import style tags
            printContainer: true, // print outer container/$.selector
            loadCSS: 'http://ejabeda.com/css/print.css', // path to additional css file - use an array [] for multiple
            pageTitle: null, // add title to print page
            removeInline: false, // remove inline styles from print elements
            removeInlineSelector: "*", // custom selectors to filter inline styles. removeInline must be true
            printDelay: 333, // variable print delay
            header: header, // prefix to html
            // footer: '<h6 style="text-align:center">Design and Development by Habro System Ltd.</h6>',               // postfix to html

            base: false, // preserve the BASE tag or accept a string for the URL
            formValues: false, // preserve input/form values
            canvas: false, // copy canvas content
            // doctypeString: '...',       // enter a different doctype for older markup
            removeScripts: false, // remove script tags from print content
            copyTagClasses: false, // copy classes from the html & body tag
            beforePrintEvent: null, // function for printEvent in iframe
            beforePrint: null, // function called before iframe is filled
            afterPrint: null // function called before iframe is removed
        });
    });
</script>
</body>

</html>