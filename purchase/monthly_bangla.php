<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
$pid= 1003000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Monthly Purchase Report </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <div class="pull-right">
                <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
                <a id='print' title="Print" class="btn btn-danger" target="_blank" href="voucher_view_pdf.php?recortid=<?php echo $_GET['recortid']; ?>"></i>PDF</a>
                <a id='print' title="Print" class="btn btn-danger" href="voucher_view_pdf.php?recortid=<?php echo $_GET['recortid']; ?>"></i>Excel</a>
                <a id='print' title="Print" class="btn btn-danger" href="voucher_view_word.php?recortid=<?php echo $_GET['recortid']; ?>"></i>docx</a>
                <a id='print' title="Print" class="btn btn-danger" href="voucher_view_pdf.php?recortid=<?php echo $_GET['recortid']; ?>"></i>csv</a>
            </div>
        </ul>
    </div>
    <!-- report header start -->
    <?php
    $org_logo = $_SESSION['org_logo'];
    $org_name = $_SESSION['org_name'];;
    ?>
    <div>
        <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
    </div>
    <div>
        <h4 style="text-align:center">Monthly Purchase Report </h4>
    </div>
    <!-- report header end -->
    <!-- search option -->
    <table>
        <form method="POST">
            <tr>
                <td>
                    From Month:
                    <select type="date" name="frommonth" id="frommonth" class="form-control" required>
                        <option value="">-select-</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </td>
                <td>
                    To Month:
                    <select type="date" name="tomonth" id="tomonth" class="form-control" required>
                        <option value="">-select-</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </td>
                <td>
                    Year:
                    <select type="date" name="year" id="year" class="form-control" required>
                        <option value="">-select-</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2018">2023</option>
                        <option value="2019">2024</option>
                        <option value="2020">2025</option>
                        <option value="2021">2027</option>
                        <option value="2022">2028</option>
                    </select>
                </td>
                <td>submit:<input type="submit" name="submit" id="submit" value="Submit" class="form-control"></td>
        </form>
    </table>
    <?php
    if (isset($_POST['submit'])) {
        $frommonth = $_POST['frommonth']; // less than or equl < or <= ...
        $tomonth = $_POST['tomonth']; // grater than or equl > or >= .....
        $year = $_POST['year'];

        if ($tomonth > $frommonth || $tomonth == $frommonth) {
    ?>
            <table border="1">
                <thead>
                    <tr>
                        <th colspan="2"></th>
                        <?php if ($tomonth <= 6) { ?>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black">January</th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> February</th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> March</th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> April</th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> May</th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> June</th>
                        <?php } elseif ($tomonth <= 12) { ?>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> July</th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> August</th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> September</th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> October</th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> November</th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> December</th>
                        <?php } else {
                        } ?>
                    </tr>
                    <tr>
                        <th>বছর</th>
                        <th>পণ্যের নং</th>
                        <?php if ($tomonth <= 6) { ?>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                        <?php } elseif ($tomonth <= 12) { ?>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                            <th>একক দর</th>
                            <th>পরিমাণ</th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black">মোট </th>
                        <?php } else {
                        } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $jan_total=$feb_total=$mar_total=$apr_total=$may_total=$jun_total=$jul_total=$aug_total=$sep_total=$oct_total=$nov_total=$dec_total=0;
                    $no = 1;
                    $sql = "SELECT invoice_detail.order_date, invoice_detail.item_no, invoice_detail.order_no, item.item_name
, avg(case when month = 1 THEN invoice_detail.unit_price_loc END) P1
, sum(case when month = 1 THEN invoice_detail.item_qty END) Qty_1
,    (case when month = 1 THEN invoice_detail.item_unit END) Unit_1
, SUM(CASE WHEN month = 1 THEN invoice_detail.total_price_loc END) January

, avg(case when month = 2 THEN invoice_detail.unit_price_loc END) P2
, sum(case when month = 2 THEN invoice_detail.item_qty END) Qty_2
,    (case when month = 2 THEN invoice_detail.item_unit END) Unit_2
, SUM(CASE WHEN month = 2 THEN invoice_detail.total_price_loc END) February

, avg(case when month = 3 THEN invoice_detail.unit_price_loc END) P3
, sum(case when month = 3 THEN invoice_detail.item_qty END) Qty_3
,    (case when month = 3 THEN invoice_detail.item_unit END) Unit_3
, SUM(CASE WHEN month = 3 THEN invoice_detail.total_price_loc END) March

, avg(case when month = 4 THEN invoice_detail.unit_price_loc END) P4
, sum(case when month = 4 THEN invoice_detail.item_qty END) Qty_4
,    (case when month = 4 THEN invoice_detail.item_unit END) Unit_4
, SUM(CASE WHEN month = 4 THEN invoice_detail.total_price_loc END) April

, avg(case when month = 5 THEN invoice_detail.unit_price_loc END) P5
, sum(case when month = 5 THEN invoice_detail.item_qty END) Qty_5
,    (case when month = 5 THEN invoice_detail.item_unit END) Unit_5
, SUM(CASE WHEN month = 5 THEN invoice_detail.total_price_loc END) May

, avg(case when month = 6 THEN invoice_detail.unit_price_loc END) P6
, sum(case when month = 6 THEN invoice_detail.item_qty END) Qty_6
,    (case when month = 6 THEN invoice_detail.item_unit END) Unit_6
, SUM(CASE WHEN month = 6 THEN invoice_detail.total_price_loc END) June

, avg(case when month = 7 THEN invoice_detail.unit_price_loc END) P7
, sum(case when month = 7 THEN invoice_detail.item_qty END) Qty_7
,    (case when month = 7 THEN code_master.description END) Desc_7
, SUM(CASE WHEN month = 7 THEN invoice_detail.total_price_loc END) July

, avg(case when month = 8 THEN invoice_detail.unit_price_loc END) P8
, sum(case when month = 8 THEN invoice_detail.item_qty END) Qty_8
,    (case when month = 8 THEN invoice_detail.item_unit END) Unit_8
, SUM(CASE WHEN month = 8 THEN invoice_detail.total_price_loc END) August

, avg(case when month = 9 THEN invoice_detail.unit_price_loc END) P9
, sum(case when month = 9 THEN invoice_detail.item_qty END) Qty_9
,    (case when month = 9 THEN invoice_detail.item_unit END) Unit_9
, SUM(CASE WHEN month = 9 THEN invoice_detail.total_price_loc END) September

, avg(case when month = 10 THEN invoice_detail.unit_price_loc END) P10
, sum(case when month = 10 THEN invoice_detail.item_qty END) Qty_10
,    (case when month = 10 THEN invoice_detail.item_unit END) Unit_10
, SUM(CASE WHEN month = 10 THEN invoice_detail.total_price_loc END) October

, avg(case when month = 11 THEN invoice_detail.unit_price_loc END) P11
, sum(case when month = 11 THEN invoice_detail.item_qty END) Qty_11
,    (case when month = 11 THEN invoice_detail.item_unit END) Unit_11
, SUM(CASE WHEN month = 11 THEN invoice_detail.total_price_loc END) November

, avg(case when month = 12 THEN invoice_detail.unit_price_loc END) P12
, sum(case when month = 12 THEN invoice_detail.item_qty END) Qty_12
,    (case when month = 12 THEN invoice_detail.item_unit END) Unit_12
, SUM(CASE WHEN month = 12 THEN invoice_detail.total_price_loc END) December

FROM (SELECT invoice_detail.*
                 , EXTRACT(YEAR  FROM invoice_detail.order_date) year
                 , EXTRACT(MONTH FROM invoice_detail.order_date) month
              FROM invoice_detail) invoice_detail join item, code_master  WHERE invoice_detail.item_no = item.id and invoice_detail.item_unit=code_master.softcode AND code_master.hardcode='UCODE' and YEAR(invoice_detail.order_date)='2020' AND (MONTH(invoice_detail.order_date) BETWEEN '06' AND '06')
           GROUP BY invoice_detail.item_no ORDER BY  invoice_detail.order_date       
";
                   
                   
        //  ====================          
                   
        //  SELECT invoice_detail.order_date, invoice_detail.item_no, invoice_detail.order_no, item.item_name, code_master.description
        //  , avg(case when month = 7 THEN invoice_detail.unit_price_loc END) P7
        //  , sum(case when month = 7 THEN invoice_detail.item_qty END) Qty_7
        //  ,    (case when month = 7 THEN code_master.description END) Desc_7
        //  , SUM(CASE WHEN month = 7 THEN invoice_detail.total_price_loc END) July
        //  FROM (SELECT invoice_detail.*
        //          , EXTRACT(YEAR  FROM invoice_detail.order_date) year
        //          , EXTRACT(MONTH FROM invoice_detail.order_date) month
        //       FROM invoice_detail) invoice_detail join item, code_master  WHERE invoice_detail.item_no = item.id and invoice_detail.item_unit=code_master.softcode AND code_master.hardcode='UCODE' and YEAR(invoice_detail.order_date)='2020' AND (MONTH(invoice_detail.order_date) BETWEEN '07' AND '07')
        //    GROUP BY invoice_detail.item_no ORDER BY  invoice_detail.order_date       
                   
                   
                   
        //    ========================        
                   
                   
                   $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                        // echo $no ++;
                    ?>
                        <tr>
                            <div>
                                <td style="text-align: center;border: 1px solid black"> <?php echo $rows['year']; ?></td>
                                <td style="text-align: left;text-indent:7px;border-right: 2px solid black;border-bottom: 1px solid black;"><?php echo $rows['item_name']; ?></td>
                            </div>
                            <?php  $jan_total = $jan_total + $rows['January'];?> 
                            <?php if ($tomonth <= 6) { ?>
                                <div>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P1']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_1']; ?> <?php echo $rows['Unit_1']; ?></td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"> <strong><?php echo $rows['January']; ?></strong></td>
                                    
                                    </div>
                                <?php  $feb_total = $feb_total + $rows['February']; // } elseif ($frommonth == 2) { 
                                ?>
                                <div>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P2']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_2']; ?> <?php echo $rows['Unit_2']; ?></td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"><strong><?php echo $rows['February']; ?></strong></td>
                                </div>
                                <?php  $mar_total = $mar_total + $rows['March']; // } elseif ($frommonth == 3) { 
                                ?>
                                <div class="p3" style="background-color: red">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P3']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_3']; ?> <?php echo $rows['Unit_3']; ?></td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"><strong><?php echo $rows['March']; ?></strong></td>
                                </div>
                                <?php  $apr_total = $apr_total + $rows['April']; // } elseif ($frommonth == 4) { 
                                ?>
                                <div class="p4">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P4']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_4']; ?> <?php echo $rows['Unit_4']; ?></td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"><strong><?php echo $rows['April']; ?></strong></td>
                                </div>
                                <?php  $may_total = $may_total + $rows['May']; // } elseif ($frommonth == 4) { 
                                ?>
                                <div class="p5">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P5']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_5']; ?> <?php echo $rows['Unit_5']; ?></td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"><strong><?php echo $rows['May']; ?></strong></td>
                                </div>
                                <?php  $jun_total = $jun_total + $rows['June']; // } elseif ($frommonth == 4) { 
                                ?>
                                <div class="p6">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P6']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_6']; ?> <?php echo $rows['Desc_7']; ?> </td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"><strong><?php echo $rows['June']; ?></strong></td>
                                </div>
                            <?php } elseif ($tomonth <= 12) { ?>
                                <?php  $jul_total = $jul_total + $rows['July'];?> 
                                <div class="p7">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P7']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_7']; ?> <?php echo $rows['Desc_7']; ?> </td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"><strong><?php echo $rows['July']; ?></strong></td>
                                </div>
                                <?php // } elseif ($frommonth == 8) { 
                                ?>
                                <div class="p8">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P8']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_8']; ?> <?php echo $rows['Unit_8']; ?></td>
                                    <td style="text-align: center;border: 1px solid black"><strong><?php echo $rows['August']; ?></strong></td>
                                </div>
                                <?php // } elseif ($frommonth == 9) { 
                                ?>
                                <div class="p9">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P9']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_9']; ?> <?php echo $rows['Unit_8']; ?></td>
                                    <td style="text-align: center;border: 1px solid black"><strong><?php echo $rows['September']; ?></strong></td>
                                </div>
                                <?php // } elseif ($frommonth == 10) { 
                                ?>
                                <div class="p10">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P10']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_10']; ?> <?php echo $rows['Unit_9']; ?></td>
                                    <td style="text-align: center;border: 1px solid black"><strong><?php echo $rows['October']; ?></strong></td>
                                </div>
                                <?php // } elseif ($frommonth == 11) { 
                                ?>
                                <div class="p11">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P11']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_11']; ?> <?php echo $rows['Unit_11']; ?></td>
                                    <td style="text-align: center;border: 1px solid black"><strong><?php echo $rows['November']; ?></strong></td>
                                </div>
                                <?php // } elseif ($frommonth == 12) { 
                                ?>
                                <div class="p12">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P12']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_12']; ?> <?php echo $rows['Unit_12']; ?></td>
                                    <td style="text-align: center;border: 1px solid black"><strong><?php echo $rows['December']; ?></strong></td>
                                </div>
                            <?php  } else { 
                            } ?>
                        </tr>
                    <?php
                    }
                    ?>
                    <tfoot>
                     <tr>
                       <?php if ($tomonth<=6) { ?>
                            <th style="text-align:right" colspan="2">Total</th>
                            <th style="text-align:right" colspan="3"><?php echo $jan_total; ?></th>
                            <th style="text-align:right"colspan="3"><?php echo $feb_total; ?></th>
                            <th style="text-align:right" colspan="3"><?php echo $mar_total; ?></th>
                            <th style="text-align:right" colspan="3"><?php echo $apr_total; ?></th>
                             <th style="text-align:right" colspan="3"><?php echo $may_total; ?></th>
                             <th style="text-align:right" colspan="3"><?php echo $jun_total; ?></th> 
                            
                       <?php  } elseif ($tomonth <= 12){ ?>
                              <th style="text-align:right" colspan="2">Total</th>
                              <th style="text-align:right" colspan="3"><?php echo $jul_total; ?></th>
                              <th style="text-align:right"colspan="3"><?php echo $aug_total; ?></th>
                              <th style="text-align:right" colspan="3"><?php echo $sep_total; ?></th>
                              <th style="text-align:right" colspan="3"><?php echo $oct_total; ?></th>
                              <th style="text-align:right" colspan="3"><?php echo $nov_total; ?></th>
                              <th style="text-align:right" colspan="3"><?php echo $dec_total; ?></th> 
                           <?php } ?> 
                
                </tr>  
            </tfoot>
                </tbody>
            </table>
    <?php
        } else {
            echo "<script>alert('Sorry Select Corrected Month')</script>";
        }
    } else {
        echo "<h3 style='color:red;text-align:center'>Please Select Account and Date</h3>";
    }
    ?>
    <!-- table -->

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

<script type="text/javascript">
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
    $(document).ready(function() {
        $("#1003000").addClass('active');
        $("#1000000").addClass('active');
        $("#1000000").addClass('is-expanded');
        $(".p8").hide();
        // disable submit button 
        $('#tomonth').change(function() {
            var frommonth = $("#frommonth").val();
            var tomonth = $("#tomonth").val();
            if (tomonth < frommonth) {
                $("#submit").attr("disabled", true);
                $("#year").attr("disabled", true);
                alert('To Month Is Not Less Than From Month');
            } else {
                $("#submit").attr("disabled", false);
                $("#year").attr("disabled", false);
            }
        });
    });
</script>
</body>

</html>