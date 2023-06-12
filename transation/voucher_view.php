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
} //

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
            <h1><i class="fa fa-dashboard"></i> Voucher </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <a id='print' title="Print" class="btn btn-danger pull-right" href="javascript:window.print()"><i class="fa fa-print"></i></a>
            <!-- <a href='javascript:window.print()' class='btn btn-danger btn-sm'><span class='glyphicon glyphicon-edit'></span>Print</a> -->
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <!-- ----------------code here---------------->
            <!-- top start  -->
            <!-- <div class="maingltable"> -->
            <br>
            <div class="maingl">
                <div class="leftgl">
                    <p>Voucher Date :</p>
                    <p>Voucher Type :</p>
                    <p>Narration :</p>
                </div> 

                <div class="rightgl">
                    <p>Batch Number :.. 07-2019</p>
                    <p>Voucher Number :xxxxxxxxxx</p>
                </div>
            </div>
            <hr>

            <table class="table table-hover" border="2">
                <tr class="active">
                    <th>Batch No </th>
                    <th>General Account Code </th>
                    <th>Account Head </th>
                    <th>Debit </th>
                    <th>Crdit</th>
                </tr>
                <tbody>
                    <?php
                    if (isset($_GET['recortid'])) {
                    // $batch =$_GET['batch_no'];
                    $sql = "SELECT tran_details.batch_no,tran_details.gl_acc_code,tran_details.dr_amt_loc,tran_details.cr_amt_loc,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.batch_no='" . $_GET['recortid'] . "'";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {               
                        ?>
                        <tr>
                            <td> <?php echo $rows['batch_no']; ?></td>
                            <td> <?php echo $rows['gl_acc_code']; ?></td>
                            <td> <?php echo $rows['acc_head']; ?></td>
                            <td> <?php echo $rows['dr_amt_loc']; ?></td>
                            <td> <?php echo $rows['cr_amt_loc']; ?></td>
                        </tr>
                    <?php
                    
                }
            }
           
                    // $conn->close();
                    ?>
                </tbody>
                <tfoot>
                    <?php
                     if (isset($_GET['recortid'])) {
                    $sqls = "SELECT SUM(dr_amt_loc), SUM(cr_amt_loc) FROM tran_details WHERE batch_no='" . $_GET['recortid'] . "'";
                    $returnD = mysqli_query($conn, $sqls);
                    $result = mysqli_fetch_assoc($returnD);
                    $dr = $result['SUM(dr_amt_loc)'];
                    $cr = $result['SUM(cr_amt_loc)'];

                     }
            
                    ?>
                    <tr class="text-right">
                        <td colspan="2"></td>
                        <td colspan="1">Grand Total</td>
                        <td align="left"><strong> TK. <?php echo $dr; ?></strong>
                        </td>
                        <td align="left"><strong> TK. <?php echo $cr; ?></strong>
                        </td>
                    </tr>

                </tfoot>

            </table>


            <tr class="text-right">
                <!-- <td colspan="1"></td> -->
                <!-- <td colspan="1">Profit</td> -->
                <!-- <td> $<?php //echo number_format(total_price($results)[1], 2);
                            ?></td> -->
            </tr>
            </tfoot>
            <!-- </div> -->
            <!-- table view end -->
        </div>
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
</body>

</html>