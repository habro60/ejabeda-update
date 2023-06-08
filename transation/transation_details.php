<?php
require "../auth/auth.php";
require "../database.php";
?>
<?php
$query = "Select Max(acc_code) From gl_acc_code where acc_level=1";
$returnDrow = mysqli_query($conn, $query);
$resultrow = mysqli_fetch_assoc($returnDrow);
$maxRowsrow = $resultrow['Max(acc_code)'];
if (empty($maxRowsrow)) {
    $lastRowrow = $maxRowsrow = 100000000000;
} else {
    $lastRowrow = $maxRowsrow + 100000000000;
} 

?>

<?php
require "../source/top.php";
?>
<style>
    .maingltable {
        border-style: solid;
        border-width: 5px;
    }

    .maingl {
        clear: both;
        height: 50px;
        width: 100%
    }

    .leftgl {
        float: left;
        width: 33%;
    }

    .meddlegl {
        float: left;
        width: 33%
    }

    .rightgl {
        float: right;
        width: 33%
    }

    @media screen and (max-width: 800px) {

        .leftgl,
        .meddlegl,
        .rightgl {
            width: 100%;
            text-align: center;
        }
    }

    @media screen and (max-width: 500px) {

        .leftgl,
        .meddlegl,
        .rightgl {
            width: 100%;
            text-align: center;

        }
    }
</style>
<?php
require "../source/header.php";
?>
<?php
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Journal</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <a id='print' title="Print" class="btn btn-danger pull-right" href="javascript:window.print()"><i class="fa fa-print"></i></a>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="POST">
                <div>
                    <label for="">To</label>
                    <input type="date" name="startdate" id="" value="2019-11-01">
                    <label for="">From</label>
                    <input type="date" name="enddate" id="" value="2019-11-13">
                    <input type="submit" name="submit" value="Submit">
                </div>
            </form>
          

          
            <table class="table table-hover">
                <tr class="active">

                    <th>Date</th>
                    <th>Transction type </th>
                    <th>Voucher No. </th>
                    <th>Account Number </th>
                    <th>Account Head </th>
                    <th>Particular </th>

                    <th>Debit </th>
                    <th>Crdit</th>
                    <th>Action</th>
                </tr>
                <?php

                if (isset($_POST['submit'])) {
                    $startdate = $_POST["startdate"];
                    // $date = format('Y-m-d');
                    $enddate = $conn->escape_string($_POST["enddate"]);
                    // echo "<script>alert( $startdate)</script>";
                    $sql = "SELECT tran_details.batch_no,tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code  AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')";

                    // $sql = "SELECT tran_details.batch_no,tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND DATE(tran_details.tran_date($startdate, $enddate))";
                   
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {

                        echo
                            "<tr>
                                    <td>" . $rows['tran_date'] . "</td>
									<td>" . $rows['tran_mode'] . "</td>
									<td>" . $rows['batch_no'] . "</td>
									<td>" . $rows['gl_acc_code'] . "</td>
                                    <td>" . $rows['acc_head'] . "</td>
                                    <td>" . $rows['description'] . "</td>
									<td>" . $rows['dr_amt_loc'] . "</td>
									<td>" . $rows['cr_amt_loc'] . "</td>
								    <td>
                                    <a href='voucher_view.php?recortid=" . $rows['batch_no'] . "' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span>Voucher</a>
									</td>
								</tr>";
                        // include('edit_delete_modal.php');
                    }
                }
                $conn->close();

                ?>
            </table>
          
            <strong>
                    <?php if (isset($startdate)) {
                       echo $startdate;
                     }
                     ?> 
                 To <?php if (isset($enddate)) {
                     echo $enddate;
                     } 
                   ?> 
                 </strong>
                 
            <!-- </div> -->
            <!-- table view end -->
            <!-- </div> -->
            <!-- ----------------code here---------------->
        </div>
    </div>
</main>
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
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#accinfo").addClass('active');
        $("#gl_acc").addClass('active');
        $("#accinfo").addClass('is-expanded');
    });
</script>

<!-- SELECT * FROM tran_details where (tran_date BETWEEN '2019-11-09' AND '2019-11-12'); -->


<!-- SELECT tran_details.batch_no,tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.tran_date,tran_details.tran_mode,tran_details.description,tran_details.cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code  AND (tran_details.tran_date BETWEEN '2019-11-09' AND '2019-11-09'); -->











</body>

</html>