<!-- ==================================
File Name: balance_sheet.php
Description: Create balance_sheet.
Featheure: 
Create Date: 30-11-2019
Create by: Mohammad Ali Abdullah.
phone : 01849378511.
Protect by: Habro Systems Limited..
======================================== -->
<?php
require "../auth/auth.php";
?>
<?php
require '../database.php';
?>
<?php
require '../source/top.php';
?>
<?php
require '../source/header.php';
?>
<?php
require '../source/sidebar.php';
?>
<main class="app-content">
    <div class="app-title">
        <div style="width: 100%;">
            <h1><i class="fa fa-dashboard"></i> Balance Sheet </h1>
            <hr>
            <form method="POST">
                <div>
                    <input type="date" name="enddate" id="" value="" required>
                    <input type="submit" name="submit" id="submitBtn" class="btn-info" value="Report View">
                    <a id='print' title="Print" style="color:red" class="pull-right" href="javascript:window.print()"><i class="fa fa-print"></i></a>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_POST['submit'])) {
                // $startdate = $_POST['startdate'];
                $enddate = $conn->escape_string($_POST['enddate']);
                $org_fin_month =  $_SESSION["org_fin_month"];
            }
            ?>
            <?php
            $sql2 = "SELECT `org_logo`, `org_name` FROM `org_info`";
            $returnD = mysqli_query($conn, $sql2);
            $result = mysqli_fetch_assoc($returnD);

            ?>
            <div>
                <!-- <img src="../upload/logo.png" alt="logo" style="width:100px;higher:100px;text-align:center">  -->
                <h2 style="text-align:center"><img src="../upload/<?php echo $result['org_logo']; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $result['org_name']; ?></h2>
            </div>
            <h3 style="text-align:center">Balance Sheet</h3>
            <h5 style="text-align:center">As On Date
                <?php if (isset($enddate)) {
                    echo $enddate;
                }
                ?>
            </h5>
            <!-- <table class="table" border="1" width="100%"> -->
            <div style="display:relative" class="row">
                <div class="col-6">
                    <table border="1" width="100%">
                        <thead>
                            <tr style="text-align:center">
                                <th colspan="4">Libilities</th>
                            </tr>
                            <tr>
                                <th>A/HEAD</th>
                                <th>Dr</th>
                                <th>Cr</th>
                                <th>BALANCE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_POST['submit'])) {
                                // $startdate = $_POST['startdate'];
                                // $date = format('Y-m-d');
                                $enddate1 = $conn->escape_string($_POST['enddate']);
                                // echo "<script>alert( $startdate)</script>";
                                $sql1 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as Cr_amt, sum(tran_details.dr_amt_loc) as dr_amt, tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddate1' AND gl_acc_code.category_code = '2' group by gl_acc_code.acc_code";
                                $query1 = $conn->query($sql1);
                                while ($rows = $query1->fetch_assoc()) {
                                    ?>

                                    <tr>
                                        <?php
                                                if ($rows['acc_level'] == 1 || $rows['category_code'] == 2) {

                                                    ?>
                                            <td style="color:red; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                            <td><?php echo $rows['Cr_amt']; ?></td>
                                            <td><?php echo $rows['dr_amt']; ?></td>
                                            <td><?php echo $rows['balance']; ?></td>
                                        <?php
                                                } elseif ($rows['acc_level'] == 2 || $rows['category_code'] == 2) {
                                                    ?>
                                            <td style="text-indent:20px;color:gray; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                            <td><?php echo $rows['Cr_amt']; ?></td>
                                            <td><?php echo $rows['dr_amt']; ?></td>
                                            <td><?php echo $rows['balance']; ?></td>

                                        <?php
                                                } elseif ($rows['acc_level'] == 3 || $rows['category_code'] == 2) {
                                                    ?>
                                            <td style="text-indent:30px;color:blue; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                            <td><?php echo $rows['Cr_amt']; ?></td>
                                            <td><?php echo $rows['dr_amt']; ?></td>
                                            <td><?php echo $rows['balance']; ?></td>

                                        <?php
                                                } elseif ($rows['acc_level'] == 4 || $rows['category_code'] == 2) {
                                                    ?>
                                            <td style="text-indent:40px;color:green; font-weight:bold"><?php echo $rows['acc_head']; ?></td>
                                            <td><?php echo $rows['Cr_amt']; ?></td>
                                            <td><?php echo $rows['dr_amt']; ?></td>
                                            <td><?php echo $rows['balance']; ?></td>

                                        <?php
                                                } else {
                                                    ?>
                                            <td colspan="4"> <?php echo " No Data"; ?> </td>

                                        <?php
                                                }
                                                ?>

                                    <?php
                                        }
                                        ?>

                        </tbody>
                    </table>
                </div>
                <div class="col-6">
                    <table border="1" width="100%">
                        <thead>
                            <tr style="text-align:center">
                                <th colspan="4">Assets</th>
                            </tr>
                            <tr>
                                <th>A/HEAD</th>
                                <th>Dr</th>
                                <th>Cr</th>
                                <th>BALANCE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql2 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as Cr_amt, sum(tran_details.dr_amt_loc) as dr_amt, tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as balance FROM gl_acc_code LEFT outer JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< '$enddate1' AND gl_acc_code.category_code = '1' group by gl_acc_code.acc_code";
                                $query2 = $conn->query($sql2);
                                while ($row = $query2->fetch_assoc()) {
                                    ?>
                                <tr>
                                    <?php
                                            if ($row['acc_level'] == 1 || $rows['category_code'] == 1) {

                                                ?>
                                        <td style="color:red; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                        <td><?php echo $row['Cr_amt']; ?></td>
                                        <td><?php echo $row['dr_amt']; ?></td>
                                        <td><?php echo $row['balance']; ?></td>

                                    <?php
                                            } elseif ($row['acc_level'] == 2 || $rows['category_code'] == 1) {
                                                ?>
                                        <td style="text-indent:20px;color:gray; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                        <td><?php echo $row['Cr_amt']; ?></td>
                                        <td><?php echo $row['dr_amt']; ?></td>
                                        <td><?php echo $row['balance']; ?></td>

                                    <?php
                                            } elseif ($row['acc_level'] == 3 || $rows['category_code'] == 1) {
                                                ?>
                                        <td style="text-indent:30px;color:blue; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                        <td><?php echo $row['Cr_amt']; ?></td>
                                        <td><?php echo $row['dr_amt']; ?></td>
                                        <td><?php echo $row['balance']; ?></td>

                                    <?php
                                            } elseif ($row['acc_level'] == 4 || $rows['category_code'] == 1) {
                                                ?>
                                        <td style="text-indent:40px;color:green; font-weight:bold"><?php echo $row['acc_head']; ?></td>
                                        <td><?php echo $row['Cr_amt']; ?></td>
                                        <td><?php echo $row['dr_amt']; ?></td>
                                        <td><?php echo $row['balance']; ?></td>

                                    <?php
                                            } else {
                                                ?>

                                        <td style="text-indent:20px"><?php echo $row['acc_head']; ?></td>
                                        <td><?php echo $row['Cr_amt']; ?></td>
                                        <td><?php echo $row['dr_amt']; ?></td>
                                        <td><?php echo $row['balance']; ?></td>

                                    <?php
                                            }
                                            ?>

                                <?php
                                    }
                                    ?>

                        </tbody>
                    </table>
                <?php
                }
                ?>
                </div>
            </div>
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
<script>
    //===== seach box in select option start ========
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
    //===== seach box in select option end ========
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#accinfo").addClass('active');
        $("#gl_acc").addClass('active');
        $("#accinfo").addClass('is-expanded');
    });
</script>
</body>

</html>