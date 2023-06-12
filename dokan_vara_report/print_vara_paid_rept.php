<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";

require "../source/header.php";
require "../source/sidebar.php";
if (empty($owner_id)) {
    $sql2 = "SELECT  apart_owner_info.id, apart_owner_info.owner_name, apart_owner_info.gl_acc_code, gl_acc_code.acc_code FROM  apart_owner_info, gl_acc_code where apart_owner_info.gl_acc_code = gl_acc_code.acc_code ORDER BY apart_owner_info.gl_acc_code";
} else {
    $sql2 = "SELECT  apart_owner_info.id, apart_owner_info.owner_name, apart_owner_info.gl_acc_code, gl_acc_code.acc_code FROM  apart_owner_info, gl_acc_code where apart_owner_info.owner_id = '$owner_id' and apart_owner_info.gl_acc_code=gl_acc_code.acc_code  ORDER BY apart_owner_info.gl_acc_code";
}

$role_no     = 99; // admin 99 superadmin 100
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100

$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Vara Received Report</h1>
        </div>
    </div>
    <div class="row">
    <div class="col-md-12">
        <form method="POST">
            <?php if (empty($owner_id)) {
            ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td>Owner : <select class="form-control grand" name="gl_acc_code">
                            <option value="">--- Select Owner ---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where  subsidiary_group_code='500' and postable_acc= 'Y' ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($drrow = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $drrow['acc_code'] . '">'  . $drrow['acc_head'] . '</option>';
                                }
                            }
                            ?>
                          </select></td>
                    <td> From: <input type="date" name="startdate" id="" class="form-control" required></td>
                    <td> To: <input type="date" name="enddate" id="" class="form-control" required></td>
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
                               <td> <input type="text" name="owner_name" id="" class="form-control" value="<?php echo $row['owner_name']; ?>" readonly></td>
                                <td> From: <input type="date" name="startdate" id="" class="form-control" required></td>
                                <td> To: <input type="date" name="enddate" id="" class="form-control" required></td>
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
                $startdate = $_POST["startdate"];
                $enddate = $conn->escape_string($_POST["enddate"]);

            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h3 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h3> 
                </div>
                <div id="organizationAdd">
                    <h4  style="text-align:center"> <?php echo $org_addr1;echo ", "; echo  "E-Mail:"; echo $org_email; echo ", "; echo "Tele:"; echo $org_tel; ?></h4> 
                </div>
                <h5 style="text-align:center" id="reportTitle">Vara Paid Report</h5>
                <div id="AsOnDate">
                    <p  style="text-align:center; font-weight:bold"> <?php echo "From "; echo $startdate; ?> To <?php echo $enddate; ?></p> 
                </div>
               
                <div class="pull-right">
                    <a id="Print" class="btn btn-danger print" target="_blank"></i>Print</a>
                </div>
                <!-- report view option -->
                <br><br>
                <?php
                        $d = 0;
                        $no = 1;
                        $owner_id = 0;
                        $batch_no = 0;
                        $tot_cr_amt =0.00;
                        $tot_dr_amt=0.00;
            
                if (isset($_POST['submit'])) {
                    
                    $startdate = $_POST['startdate'];
                    $enddate = $conn->escape_string($_POST['enddate']);
                    $gl_acc_code = $conn->escape_string($_POST['gl_acc_code']);
                    if (empty($gl_acc_code)) {
                            $sql="SELECT  vara_receive_detail.office_code,vara_receive_detail.flat_no,vara_receive_detail.batch_no,vara_receive_detail.paid_date,vara_receive_detail.fund_type, vara_receive_detail.paid_amount, flat_info.flat_no, flat_info.flat_title, dokan_vara_detail.fund_type_desc,  vara_receive_detail.from_date,vara_receive_detail.paid_upto,dokan_vara_detail.num_of_pay,dokan_vara_detail.donner_pay_amt,
                            DATEDIFF(vara_receive_detail.paid_upto,vara_receive_detail.from_date) AS no_of_days
                            
                             from vara_receive_detail, flat_info, dokan_vara_detail where vara_receive_detail.flat_no=flat_info.flat_no and dokan_vara_detail.flat_no=vara_receive_detail.flat_no and dokan_vara_detail.fund_type=vara_receive_detail.fund_type and (vara_receive_detail.paid_date between '$startdate' and '$enddate')";


                        }else {

                            $sql="SELECT  vara_receive_detail.office_code,vara_receive_detail.flat_no,vara_receive_detail.batch_no,vara_receive_detail.paid_date,vara_receive_detail.fund_type, vara_receive_detail.paid_amount, flat_info.flat_no, flat_info.flat_title, dokan_vara_detail.fund_type_desc, vara_receive_detail.from_date,vara_receive_detail.paid_upto ,dokan_vara_detail.num_of_pay,dokan_vara_detail.donner_pay_amt, DATEDIFF( vara_receive_detail.paid_upto,vara_receive_detail.from_date) AS no_of_days
                             from vara_receive_detail, flat_info, dokan_vara_detail
                            
                             where vara_receive_detail.flat_no=flat_info.flat_no and dokan_vara_detail.flat_no=vara_receive_detail.flat_no and dokan_vara_detail.fund_type=vara_receive_detail.fund_type and vara_receive_detail.dokan_vara_gl = '$gl_acc_code'and (vara_receive_detail.paid_date between '$startdate' and '$enddate')";

                        }
                        
                       // echo $sql;
                        $query = mysqli_query($conn, $sql);
                // $query = $conn->query($sql);
                ?>
                <div id="mySelector">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">

                        <th >Sl.NO.</th>
                    <th>Tran Date</th>
                    <th>Voucher No.</th>
                    <th>Dokan No.</th>
                    <th>Dokan Name</th>
                    <th>From Date</th>
                    <th>Paid Upto </th>
                    <th>total Days</th>
                    <th>Paid Amount</th>

                        </thead>

                        <body>
                            
                            <?php
                            while ($rows = mysqli_fetch_assoc($query)) {
                            ?>
                                <tr>
                                <td style="text-align: right"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $no++; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                       <td style="text-align: center"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $rows['tran_date']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                     
                     
                        <td style="text-align: center"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $rows['batch_no']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>
                      <td style="text-align: center"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $rows['flat_no']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                                  
                    
                     <td style="text-align: center"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $rows['flat_title']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                          <!-- <td style="background-color:powderblue; text-align: right"><?php echo $rows['fund_type_desc']; ?></td> -->
                          <td style="background-color:powderblue; text-align: right"><?php echo $rows['from_date']; ?></td>    
                         <td style="background-color:powderblue; text-align: right"><?php echo $rows['paid_upto']; ?></td>                                        
                               
                         <td style="background-color:powderblue; text-align: right"><?php echo $rows['no_of_days']; ?></td>
                         <td style="text-align: right"><?php if ($rows['batch_no'] != $batch_no) {
                                                            echo $rows['paid_amount']; 
                                                            $tot_cr_amt = $tot_cr_amt + $rows['paid_amount'];
                                                            $batch_no = $rows['batch_no'];
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                       
                                        
                            </tr>
                        <?php
                            }
                        }
                            ?>

                      <tfoot>
                        <tr style="background-color:powderblue";>
                                <th style="text-align:right" colspan="8"> Total Amount in TK.</th>
                                <th style="text-align:right" colspan="1"><?php echo $tot_cr_amt; ?></th> 
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
    var AsOnDate = $('#AsOnDate').text();
    var header = `<div>
    	            <h3 style="text-align:center">${organizationName}</h3>
                    <h4 style="text-align:center">${organizationAdd}</h4>
                 </div>
                    <h5 style="text-align:center" id="reportTitle">${reportTitle}</h5>;
                    <div>
                    <p style="text-align:center;font-weight:bold">${AsOnDate}</p>
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