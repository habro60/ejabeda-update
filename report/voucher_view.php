<?php

ini_set('intl', '1');

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
@media print 
{
  @page {
    size: A2;
    margin: 0;
}

@media print {
    html, body {
        margin:0 !important;
        padding:0 !important;
        height:100% !important;
    }
}

}
</style>

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

            $tran_mode_short_title = $row['tran_mode'];

            $sql = "SELECT * FROM tran_mode  WHERE tran_mode_short_title='$tran_mode_short_title'";
            $query = $conn->query($sql);
            $row_tran = $query->fetch_assoc();
        ?>
            <h6 style="text-align:center"><?php echo $row_tran['tran_title']; ?> Voucher </h6>

            <div class="row">
                <div class="col-md-12">
                    <table style="margin:20px;">
                        <tr>
                            <th style="width:25%;">
                                <p><strong>Voucher Date : </strong> <?php echo date('d-m-Y ', strtotime($row['tran_date']));  ?></p>
                            </th>
                            <th style="width:25%; text-align:right">
                                <p><strong>Voucher Number :</strong><?php echo $row['batch_no']; ?></p>
                            </th>
                        </tr>

                        <tr>
                            <th style="width:25%;">
                                <p><strong>Voucher Type :</strong> <?php echo $row_tran['tran_title']; ?></p>

                            </th>
                        </tr>

                        <tr>
                            <th style="width:25%;">
                                <p> <strong>Details Of Type :</strong> 

                                <?php
                                $i = 1;
                                $sql2 = "SELECT tran_details.batch_no, tran_details.tran_no, tran_details.tran_date,tran_details.gl_acc_code,gl_acc_code.acc_type,tran_details.dr_amt_loc,tran_details.cr_amt_loc,tran_details.description,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.batch_no='" . $_GET['recortid'] . "' ORDER BY tran_details.tran_no";
                                $query2 = $conn->query($sql2);
                                while ($rows = $query2->fetch_assoc()) {
                                    if ($rows['dr_amt_loc']==0) {

                                         echo $rows['acc_head'];

                                        //  break;
                                   
                                ?>
                                
                                
                                <?php }}} ?>
                            
                            
                            
                            </p>

                            </th>
                        </tr>
                    </table>



                    <div id="mySelector">
                        <table style="margin:20px;border: 1px solid #808080;margin-top:30px; text-align:center;" id="sampleTable">
                            <thead class="reportHead" style="background-color: green;">
                                <th style="text-align:center;width:5%;border: 1px solid #808080;padding:2px;">SL No </th>
                                <th style="text-align:center;width:5%;border: 1px solid #808080;padding:2px;">Trx. No </th>
                                <th style="text-align:center;width:20%;border: 1px solid #808080;padding:2px;">GL A/C Code </th>
                                <th style="text-align:center;width:25%;border: 1px solid #808080;padding:2px;">A/C Head </th>
                                <th style="text-align:center;width:25%;border: 1px solid #808080;padding:2px;">Debit</th>
                            </thead>

                            <body>
                                <?php
                                $i = 1;
                                $sql2 = "SELECT tran_details.batch_no, tran_details.tran_no, tran_details.tran_date,tran_details.gl_acc_code,gl_acc_code.acc_type,tran_details.dr_amt_loc,tran_details.cr_amt_loc,tran_details.description,gl_acc_code.acc_head,gl_acc_code.acc_code FROM tran_details JOIN gl_acc_code WHERE tran_details.gl_acc_code=gl_acc_code.acc_code AND tran_details.batch_no='" . $_GET['recortid'] . "' ORDER BY tran_details.tran_no";
                                $query2 = $conn->query($sql2);
                                while ($rows = $query2->fetch_assoc()) {
                                    if ($rows['dr_amt_loc']>0) {
                                        # code...
                                   
                                ?>
                                    <tr>
                                        <td style="text-align:center;width:5%;border: 1px solid #808080;padding:5px;"> <?php echo $i; ?></td>
                                        <td style="text-align:center;width:5%;border: 1px solid #808080;padding:5px;"> <?php echo $rows['tran_no']; ?></td>
                                        <td style="text-align:center;width:5%;border: 1px solid #808080;padding:5px;"> <?php echo $rows['gl_acc_code']; ?></td>
                                        <td style="text-align:center;width:5%;border: 1px solid #808080;padding:5px;"> <?php echo $rows['acc_head']; ?></td>
                                        <td style="text-align:right;width:5%;border: 1px solid #808080;padding:5px;"> <?php $val = number_format($rows['dr_amt_loc'], 2, '.', ',');
                                                                                                                        echo $val; ?></td>
                                       
                                    </tr>
                            <?php
                                    $i++;
                                    }
                                }
                            // }
                            // $conn->close();
                            ?>
                            </body>
                            <?php
                            if (isset($_GET['recortid'])) {
                                $sqls = "SELECT SUM(dr_amt_loc), SUM(cr_amt_loc) FROM tran_details WHERE batch_no='" . $_GET['recortid'] . "'";
                                $returnD = mysqli_query($conn, $sqls);
                                $result = mysqli_fetch_assoc($returnD);


                                $dr = number_format($result['SUM(dr_amt_loc)'], 2, '.', ',');
                                $cr = number_format($result['SUM(cr_amt_loc)'], 2, '.', ',');
                            }
                            ?>


                            <tfoot>
                                <tr style="background-color:powderblue" ;>
                                    <th style="text-align:right;border: 1px solid #808080;" colspan="4"> Grand Total In TK.=</th>
                                    <th style="text-align:right;border: 1px solid #808080;" colspan="2"><?php echo $dr; ?></th>
                                </tr>
                            </tfoot>

                        </table>
                        
                        
                        <!-- number format in word calculation start -->
                        
                        <?php 
                        
                        class numbertowordconvertsconver {
    function convert_number($number) 
    {
        if (($number < 0) || ($number > 999999999)) 
        {
            throw new Exception("Number is out of range");
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga) 
        {
            $result .= $this->convert_number($giga) .  "Million";
        }
        if ($kilo) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($kilo) . " Thousand";
        }
        if ($hecto) 
        {
            $result .= (empty($result) ? "" : " ") .$this->convert_number($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result)) 
            {
                $result .= " and ";
            }
            if ($deca < 2) 
            {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n) 
                {
                    $result .= "-" . $ones[$n];
                }
            }
        }
        if (empty($result)) 
        {
            $result = "zero";
        }
        return $result;
    }
}



                        
                        
                        ?>
                        
                        <!-- number format in word calculation end -->
                        

                        <?php
                        if (isset($_GET['recortid'])) {
                            $sqls = "SELECT SUM(dr_amt_loc), SUM(cr_amt_loc) FROM tran_details WHERE batch_no='" . $_GET['recortid'] . "'";
                            $returnD = mysqli_query($conn, $sqls);
                            $result = mysqli_fetch_assoc($returnD);

                            $dr_amount = floatval($result['SUM(dr_amt_loc)']);


                            $dr = number_format($result['SUM(dr_amt_loc)'], 2, '.', ',');
                            $cr = number_format($result['SUM(cr_amt_loc)'], 2, '.', ',');
                        }
                        ?>

  
                        <table style="margin-left:20px;">
                            <tr>
                                <th style="text-align:center;"><p><strong>Amount In Word : </strong>
                                
                                <?php
                                
                                $class_obj = new numbertowordconvertsconver();

echo $class_obj->convert_number($dr_amount);
                                
                                
                                                               
                                                                    ?>
                                                </p></th>
                            </tr>
                        </table>
                        <table style="margin-left:20px;">
                            <tr>
                                <th style="text-align:center;" > <p><strong>Narration :</strong> <?php echo  $row['description']; ?></p></th>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <th style="text-align:center;width:25%;"><label>--------------------</label> <br><?php echo 'Receivers Signature'; ?></th>
                                <th style="text-align:center;width:25%;padding:80px;" colspan="6"><label>--------------------</label><br><?php echo 'Authorized By'; ?></th>
                            </tr>
                        </table>

                    </div>
                </div>
                <!-- ----------------code here---------------->
            </div>
    </div>
    </div>
    </div>

    <?php $today = date('d-m-Y'); ?>

    <div style='padding-left:20px;'>
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
<script src="../js/custom.js"></script>
<!-- data table -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<!-- print this js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>
<!--  -->


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