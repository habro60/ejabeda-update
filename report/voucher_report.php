<?php
require "../auth/auth.php";
require '../database.php';
require '../source/top.php';
// $pid= 706000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require '../source/header.php';
require '../source/sidebar.php';

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
            <h1><i class="fa fa-dashboard"></i> Voucher Report </h1>
        </div>

        <div class="pull-right">
            <!--<a id="Print" class="btn btn-danger print"></i>Print</a>-->
            <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- search -->
            <div class="scroll">
                <form method="POST">
                    <table id="form_class_id" class="table-responsive">
                        <tbody>
                            <tr>
                                <?php
                                if ($role_no == '99') {
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

                                    <?php

                                    $option = "SELECT * from tran_mode";
                                    $query = $conn->query($option);
                                    ?>
                                    <select class="select2 form-control" name="voucher_report" id="voucher_report" style="width: 150px;" required>
                                        <option value="">--Select One--</option>
                                        <?php
                                        while ($rows = $query->fetch_assoc()) {
                                            echo '<option value=' . $rows['tran_mode_short_title'] . '>' . $rows['tran_title'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="date" name="startdate" value="<?php echo $startdate; ?>" class="form-control" required>
                                </td>
                                <td>
                                    <input type="date" name="enddate" value="<?php echo $enddate; ?>" class="form-control" required>
                                </td>
                                <td>
                                    <input type="submit" name="submit" id="submitBtn" class="btn btn-info" value="Report View">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <!-- end filter option -->
            <?php
            if (isset($_POST['submit'])) {
                $officeId = $_POST['officeId'];
                $startdate = $_POST['startdate'];
                $voucher_report = $_POST['voucher_report'];
                // echo $voucher_report;
                // die;
                $enddate = $conn->escape_string($_POST['enddate']);
                $org_fin_month =  $_SESSION["org_fin_month"];
                $sql2 = "SELECT `org_logo`, `org_name` FROM `org_info`";
                $returnD = mysqli_query($conn, $sql2);
                $result = mysqli_fetch_assoc($returnD);
            ?>
                <!-- report header -->
                <div id="organizationName">
                    <h2 style="text-align:center"><img src="../upload/<?php echo $result['org_logo']; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $result['org_name']; ?></h2>
                </div>

                <h5 style="text-align: center" id="dateToDate">From <?php echo $startdate; ?> To <?php echo $enddate; ?></h5>
                <!-- end report header -->
                <!-- report view option -->
                <div class="pull-right">
                    <!--<a id="Print" class="btn btn-danger print" target="_blank"></i>Print</a>-->
                </div>
                <!-- report view option -->
                <br><br>
                <?php

                if (!empty($officeId)) {
                    $sql = "SELECT tran_details.batch_no,tran_details.tran_no,tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,tran_details.ss_creator,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.tran_mode='$voucher_report' AND tran_details.office_code='$officeId' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') ORDER BY tran_details.tran_date,tran_details.tran_no";
                } else {
                    $sql = "SELECT tran_details.batch_no,tran_details.tran_no,tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,tran_details.ss_creator,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code  AND tran_details.tran_mode='$voucher_report'  AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') ORDER BY tran_details.tran_date,tran_details.tran_no";
                }
                $query = $conn->query($sql);
                ?>
                <div id="mySelector">
                    <table class="table table-hover table-striped" id="sampleTable">
                        <thead class="reportHead" style="background-color: green;">
                            <th>Date</th>
                            <th>Entry By</th>
                            <th> type </th>
                            <th>Trans. No </th>
                            <th>Voucher No. </th>
                            <th>A/C </th>
                            <th>A/Head </th>
                            <th>Particular </th>
                            <th>Debit </th>
                            <th>Credit</th>
                            <th class='action'>Action</th>
                        </thead>

                        <body>
                            <?php
                            $dr_tot = 0;
                            $cr_tot = 0;
                            while ($rows = $query->fetch_assoc()) {
                                echo
                                "<tr>
                            <td>" . $rows['tran_date'] . "</td>
                            <td>" . $rows['ss_creator'] . "</td>
                            <td>" . $rows['tran_mode'] . "</td>
                            <td>" . $rows['tran_no'] . "</td>
                            <td>" . $rows['batch_no'] . "</td> 
                            <td>" . $rows['gl_acc_code'] . "</td>
                            <td>" . $rows['acc_head'] . "</td>
                            <td>" . $rows['description'] . "</td>"
                            ?>

                                <td> <?php echo $rows['dr_amt_loc'];
                                        $dr_tot = $dr_tot + $rows['dr_amt_loc']; ?></td>
                                <td> <?php echo $rows['cr_amt_loc'];
                                        $cr_tot = $cr_tot + $rows['cr_amt_loc']; ?></td>

                                <td> <a id='print' title="Print Voucher" class="btn btn-success" target="_blank" href="voucher_view.php?recortid=<?php echo  $rows['batch_no']; ?>"></i>Print voucher</a></td>

                                <!-- <td class='action'>
                            <a href='voucher_view.php?recortid=" . $rows['batch_no'] . "' target='blank' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span>Voucher</a>
                            </td> -->
                                </tr>
                            <?php
                            }
                            ?>
                        </body>
                        <tfoot>
                            <tr style="text-align: right; font-weight:bold">
                                <td colspan="7">Total</td>
                                <td><?php echo $dr_tot; ?></td>
                                <td><?php echo $cr_tot; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php
            } else {
                echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select From Date and To Date</h1>";
            }
            ?>
        </div>
    </div>
</main>
<?php
//require "report_footer.php";
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
<!--  -->
<script src="../js/custom.js"></script>
<!-- data table -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<!-- print this js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })

    $(document).ready(function() {
        $("#703000").addClass('active');
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