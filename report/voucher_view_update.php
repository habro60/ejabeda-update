<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";

$q      = $_SESSION['org_rep_footer1'];
$b      = $_SESSION['org_rep_footer2'];
$role_no     = $_SESSION['sa_role_no']; // admin 99 superadmin 100
$office_code = $_SESSION['office_code'];
$org_name    = $_SESSION['org_name'];
$org_logo    = $_SESSION['org_logo'];
$org_addr1 = $_SESSION['org_addr1'];
$org_email = $_SESSION['org_email'];
$org_tel = $_SESSION['org_tel'];

?>

<style>
    /*  #pageFooter:after {*/
    /*  counter-increment: page;*/
    /*  content:"Page " counter(page);*/
    /*  left: 0; */
    /*  top: 100%;*/
    /*  white-space: nowrap; */
    /*  z-index: 20;*/
    /*  -moz-border-radius: 5px; */
    /*  -moz-box-shadow: 0px 0px 4px #222;  */
    /*  background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);  */
    /*}*/
</style>

<main class="app-content">
    <div id="pageFooter"></div>
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

    <?php
    $org_name    = $_SESSION['org_name'];
    $org_addr1 = $_SESSION['org_addr1'];
    $org_email = $_SESSION['org_email'];
    $org_tel = $_SESSION['org_tel'];
    $org_logo    = $_SESSION['org_logo'];

    $org_fin_month =  $_SESSION["org_fin_month"];
    $total_libility = $total_asset = 0;

    ?>
    <div>

        <h4 style="text-align:center; margin-top:60px;"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;margin-right:10px;"><?php echo $result['org_name']; ?></h4>
    </div>
    <div id="organizationAdd">
        <p style="text-align:center"> <?php echo $org_addr1;
                                        echo ",<br> ";
                                        echo  "E-Mail:";
                                        echo $org_email;
                                        echo ", ";
                                        echo "Tele:";
                                        echo $org_tel; ?></p>
    </div>
    <div>

        <?php
        if (isset($_GET['recortid'])) {
            // $batch =$_GET['batch_no'];
            $sql = "SELECT tran_details.batch_no, tran_details.tran_no,tran_details.tran_mode, tran_details.tran_date,tran_details.gl_acc_code,gl_acc_code.acc_type,tran_details.dr_amt_loc,tran_details.cr_amt_loc,tran_details.description,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.batch_no='" . $_GET['recortid'] . "'";
            $query = $conn->query($sql);
            $row = $query->fetch_assoc();

            $tran_code = $row['tran_mode'];

            $sql = "SELECT * FROM tran_mode  WHERE tran_code='$tran_code'";
            $query = $conn->query($sql);
            $row_tran = $query->fetch_assoc();
        ?>
            <h6 style="text-align:center"> <b>Report Title : </b><?php echo $row_tran['tran_title']; ?> Voucher </h6>

            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="maingl">
                        <div class="leftgl" style="margin-left:77px;margin-bottom:40px;">
                            <p><strong>Voucher Date : </strong> <?php echo date('d-m-Y ', strtotime($row['tran_date']));  ?></p>
                            <p><strong>Voucher Type :</strong> <?php echo $row_tran['tran_code']; ?></p>
                            <p> <strong>Details Of Type :</strong> <?php echo $row_tran['tran_title']; ?></p>
                        </div>

                        <div class="rightgl">


                            <p><strong>Voucher Number :</strong><?php echo $row['batch_no']; ?></p>

                        </div>
                    </div>
                    <hr>
                    <table style="width:850px;margin-left:80px;margin-top:40px;   border: 1px solid black;" class="table table-hover" border="2">
                        <tr class="active">
                            <th style='text-align:center'>SL No </th>
                            <th style='text-align:center'>Trx. No </th>
                            <th style='text-align:center'>GL A/C Code </th>
                            <th style='text-align:center'>A/C Head </th>
                            <th style='text-align:center'>Debit (TK) </th>
                            <th style='text-align:center'>Credit (TK)</th>
                        </tr>
                        <tbody>
                            <?php
                            $i = 1;
                            $sql2 = "SELECT tran_details.batch_no, tran_details.tran_no, tran_details.tran_date,tran_details.gl_acc_code,gl_acc_code.acc_type,tran_details.dr_amt_loc,tran_details.cr_amt_loc,tran_details.description,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.batch_no='" . $_GET['recortid'] . "' ORDER BY tran_details.tran_no";
                            $query2 = $conn->query($sql2);
                            while ($rows = $query2->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td style='text-align:center'> <?php echo $i; ?></td>
                                    <td style='text-align:center'> <?php echo $rows['tran_no']; ?></td>
                                    <td style='text-align:center'> <?php echo $rows['gl_acc_code']; ?></td>
                                    <td style='text-align:left'> <?php echo $rows['acc_head']; ?></td>
                                    <td style='text-align:right'> <?php $val = number_format($rows['dr_amt_loc'], 2, '.', ',');
                                                                    echo $val; ?></td>
                                    <td style='text-align:right'> <?php $val2 = number_format($rows['cr_amt_loc'], 2, '.', ',');
                                                                    echo $val2; ?></td>
                                </tr>
                        <?php
                                $i++;
                            }
                        }
                        // $conn->close();
                        ?>



                </div>
                </tbody>
                <tfoot>
                    <?php
                    if (isset($_GET['recortid'])) {
                        $sqls = "SELECT SUM(dr_amt_loc), SUM(cr_amt_loc) FROM tran_details WHERE batch_no='" . $_GET['recortid'] . "'";
                        $returnD = mysqli_query($conn, $sqls);
                        $result = mysqli_fetch_assoc($returnD);

                        $dr_amount=floatval($result['SUM(dr_amt_loc)']);


                        $dr = number_format($result['SUM(dr_amt_loc)'], 2, '.', ',');
                        $cr = number_format($result['SUM(cr_amt_loc)'], 2, '.', ',');
                    }
                    ?>
                    <tr class="text-right">
                        <td colspan="3"></td>
                        <td style="text-align:center" colspan="1"><strong>Grand Total In TK</strong></td>
                        <td style="text-align:center"><strong><?php echo $dr; ?></strong>
                        </td>
                        <td style="text-align:center"><strong><?php echo $cr; ?></strong>
                        </td>
                    </tr>



                    </table>

                    <div class="leftgl" style="margin-left:77px;margin-bottom:40px;">
                        <p><strong>Amount In Word : </strong> <?php 
                                                                $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                                                echo $f->format($dr_amount) ?></p>
                        <p><strong>Narration :</strong> <?php echo  $row['description']; ?></p>
                    </div>
            </div>
            <!-- ----------------code here---------------->
    </div>
    </div>

    <div style='padding:80px'>
        <div style='float:left;text-align:left;line-height:100%'><label>--------------------</label><br><?php echo $q; ?></div>


        <div style='float:right;text-align:right;line-height:100%'><label>--------------------------</label><br><?php echo $b; ?></div>
    </div>
    </div>
    </div>

    <?php $today = date('d-m-Y'); ?>

    <div style='padding:40px;'>
        <span><b>Prepared By:</b> <?php echo $_SESSION['username']; ?> </span>
        <span><b>Date:</b> <?php echo $today; ?> </span>
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

<script type="text/javascript">
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })
    $(document).ready(function() {
        $("#701000").addClass('active');
        $("#700000").addClass('active');
        $("#700000").addClass('is-expanded');
    });
</script>
</body>

</html>