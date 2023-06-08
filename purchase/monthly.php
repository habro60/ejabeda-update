<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
$pid = 1003000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
require "../setting/setting.php";
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> <?php echo $lang['Monthly Purchase Report'] ?> </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <div class="pull-right">
                <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i><?php echo $lang['Print'] ?></a>
                <a id='print' title="Print" class="btn btn-danger" target="_blank" href="voucher_view_pdf.php?recortid=<?php echo $_GET['recortid']; ?>"></i><?php echo $lang['PDF'] ?></a>
                <a id='print' title="Print" class="btn btn-danger" href="voucher_view_pdf.php?recortid=<?php echo $_GET['recortid']; ?>"></i><?php echo $lang['Excel'] ?></a>
                <a id='print' title="Print" class="btn btn-danger" href="voucher_view_word.php?recortid=<?php echo $_GET['recortid']; ?>"></i><?php echo $lang['Docx'] ?></a>
                <a id='print' title="Print" class="btn btn-danger" href="voucher_view_pdf.php?recortid=<?php echo $_GET['recortid']; ?>"></i><?php echo $lang['csv'] ?></a>
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
        <h4 style="text-align:center"><?php echo $lang['Monthly Purchase Report'] ?></h4>
    </div>
    <!-- report header end -->
    <!-- search option -->
    <table>
        <form method="POST">
            <tr>
                <td>
                    <?php echo $lang['From Month']; ?>:
                    <select type="date" name="frommonth" id="frommonth" class="form-control" required>
                        <option value="">-<?php echo $lang['select']; ?>-</option>
                        <option value="1"><?php echo $lang['January']; ?></option>
                        <option value="2"><?php echo $lang['February']; ?></option>
                        <option value="3"><?php echo $lang['March']; ?></option>
                        <option value="4"><?php echo $lang['April']; ?></option>
                        <option value="5"><?php echo $lang['May']; ?></option>
                        <option value="6"><?php echo $lang['June']; ?></option>
                        <option value="7"><?php echo $lang['July']; ?></option>
                        <option value="8"><?php echo $lang['August']; ?></option>
                        <option value="9"><?php echo $lang['September']; ?></option>
                        <option value="10"><?php echo $lang['October']; ?></option>
                        <option value="11"><?php echo $lang['November']; ?></option>
                        <option value="12"><?php echo $lang['December']; ?></option>
                    </select>
                </td>
                <td>
                    <?php echo $lang['To Month']; ?>:
                    <select type="date" name="tomonth" id="tomonth" class="form-control" required>
                        <option value="">-<?php echo $lang['select']; ?>-</option>
                        <option value="1"><?php echo $lang['January']; ?></option>
                        <option value="2"><?php echo $lang['February']; ?></option>
                        <option value="3"><?php echo $lang['March']; ?></option>
                        <option value="4"><?php echo $lang['April']; ?></option>
                        <option value="5"><?php echo $lang['May']; ?></option>
                        <option value="6"><?php echo $lang['June']; ?></option>
                        <option value="7"><?php echo $lang['July']; ?></option>
                        <option value="8"><?php echo $lang['August']; ?></option>
                        <option value="9"><?php echo $lang['September']; ?></option>
                        <option value="10"><?php echo $lang['October']; ?></option>
                        <option value="11"><?php echo $lang['November']; ?></option>
                        <option value="12"><?php echo $lang['December']; ?></option>
                    </select>
                </td>
                <td>
                    <?php echo $lang['Year']; ?>:
                    <select type="date" name="year" id="year" class="form-control" required>
                        <option value="">-<?php echo $lang['select']; ?>-</option>
                        <option value="2015"><?php echo $lang['2015'];?></option>
                        <option value="2016"><?php echo $lang['2016'];?></option>
                        <option value="2017"><?php echo $lang['2017'];?></option>
                        <option value="2018"><?php echo $lang['2018'];?></option>
                        <option value="2019"><?php echo $lang['2019'];?></option>
                        <option value="2020"><?php echo $lang['2020'];?></option>
                        <option value="2021"><?php echo $lang['2021'];?></option>
                        <option value="2022"><?php echo $lang['2022'];?></option>
                        <option value="2022"><?php echo $lang['2023'];?></option>
                    </select>
                </td>
                <td><?php echo $lang['submit']; ?>:<input type="submit" name="submit" id="submit" value="<?php echo $lang['submit']; ?>" class="form-control"></td>
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
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"><?php echo $lang['January']; ?></th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['February']; ?></th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['March']; ?></th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['April']; ?></th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['May']; ?></th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['June']; ?></th>
                        <?php } elseif ($tomonth <= 12) { ?>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['July']; ?></th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['August']; ?></th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"><?php echo $lang['September']; ?></th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['October']; ?></th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['November']; ?></th>
                            <th colspan="3" style="text-align: center;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['December']; ?></th>
                        <?php } else {
                        } ?>
                    </tr>
                    <tr>
                        <th><?php echo $lang['Year']; ?></th>
                        <th><?php echo $lang['Goods No']; ?></th>
                        <?php if ($tomonth <= 6) { ?>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                        <?php } elseif ($tomonth <= 12) { ?>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                            <th><?php echo $lang['Unit Price']; ?></th>
                            <th><?php echo $lang['Quantity']; ?></th>
                            <th style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black"> <?php echo $lang['Total']; ?></th>
                        <?php } else {
                        } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $jan_total = $feb_total = $mar_total = $apr_total = $may_total = $jun_total = $jul_total = $aug_total = $sep_total = $oct_total = $nov_total = $dec_total = 0;
                    $no = 1;
                    $sql = "SELECT year(invoice_detail.order_date) as year, invoice_detail.item_no, invoice_detail.order_no, item.item_name, code_master.description
, avg(case when month = 1 THEN invoice_detail.unit_price_loc END) P1
, sum(case when month = 1 THEN invoice_detail.item_qty END) Qty_1
,    (case when month = 1 THEN code_master.description END) Unit_1
, SUM(CASE WHEN month = 1 THEN invoice_detail.total_price_loc END) January

, avg(case when month = 2 THEN invoice_detail.unit_price_loc END) P2
, sum(case when month = 2 THEN invoice_detail.item_qty END) Qty_2
,    (case when month = 2 THEN code_master.description END) Unit_2
, SUM(CASE WHEN month = 2 THEN invoice_detail.total_price_loc END) February

, avg(case when month = 3 THEN invoice_detail.unit_price_loc END) P3
, sum(case when month = 3 THEN invoice_detail.item_qty END) Qty_3
,    (case when month = 3 THEN code_master.description END) Unit_3
, SUM(CASE WHEN month = 3 THEN invoice_detail.total_price_loc END) March

, avg(case when month = 4 THEN invoice_detail.unit_price_loc END) P4
, sum(case when month = 4 THEN invoice_detail.item_qty END) Qty_4
,    (case when month = 4 THEN code_master.description END) Unit_4
, SUM(CASE WHEN month = 4 THEN invoice_detail.total_price_loc END) April

, avg(case when month = 5 THEN invoice_detail.unit_price_loc END) P5
, sum(case when month = 5 THEN invoice_detail.item_qty END) Qty_5
,    (case when month = 5 THEN code_master.description END) Unit_5
, SUM(CASE WHEN month = 5 THEN invoice_detail.total_price_loc END) May

, avg(case when month = 6 THEN invoice_detail.unit_price_loc END) P6
, sum(case when month = 6 THEN invoice_detail.item_qty END) Qty_6
,    (case when month = 6 THEN code_master.description END) Unit_6
, SUM(CASE WHEN month = 6 THEN invoice_detail.total_price_loc END) June

, avg(case when month = 7 THEN invoice_detail.unit_price_loc END) P7
, sum(case when month = 7 THEN invoice_detail.item_qty END) Qty_7
,    (case when month = 7 THEN code_master.description END) Desc_7
, SUM(CASE WHEN month = 7 THEN invoice_detail.total_price_loc END) July

, avg(case when month = 8 THEN invoice_detail.unit_price_loc END) P8
, sum(case when month = 8 THEN invoice_detail.item_qty END) Qty_8
,    (case when month = 8 THEN code_master.description END) Unit_8
, SUM(CASE WHEN month = 8 THEN invoice_detail.total_price_loc END) August

, avg(case when month = 9 THEN invoice_detail.unit_price_loc END) P9
, sum(case when month = 9 THEN invoice_detail.item_qty END) Qty_9
,    (case when month = 9 THEN code_master.description END) Unit_9
, SUM(CASE WHEN month = 9 THEN invoice_detail.total_price_loc END) September
, avg(case when month = 10 THEN invoice_detail.unit_price_loc END) P10
, sum(case when month = 10 THEN invoice_detail.item_qty END) Qty_10
,    (case when month = 10 THEN code_master.description END) Unit_10
, SUM(CASE WHEN month = 10 THEN invoice_detail.total_price_loc END) October
, avg(case when month = 11 THEN invoice_detail.unit_price_loc END) P11
, sum(case when month = 11 THEN invoice_detail.item_qty END) Qty_11
,    (case when month = 11 THEN code_master.description END) Unit_11
, SUM(CASE WHEN month = 11 THEN invoice_detail.total_price_loc END) November
, avg(case when month = 12 THEN invoice_detail.unit_price_loc END) P12
, sum(case when month = 12 THEN invoice_detail.item_qty END) Qty_12
,    (case when month = 12 THEN code_master.description END) Unit_12
, SUM(CASE WHEN month = 12 THEN invoice_detail.total_price_loc END) December

FROM (SELECT invoice_detail.*
                 , EXTRACT(YEAR  FROM invoice_detail.order_date) year
                 , EXTRACT(MONTH FROM invoice_detail.order_date) month
              FROM invoice_detail) invoice_detail join item, code_master  WHERE invoice_detail.item_no = item.id and invoice_detail.item_unit=code_master.softcode AND code_master.hardcode='UCODE' and YEAR(invoice_detail.order_date)='$year' AND (MONTH(invoice_detail.order_date) BETWEEN '$frommonth' AND '$tomonth')
           GROUP BY invoice_detail.item_no ORDER BY  invoice_detail.order_date       
";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                        // echo $no ++;
                    ?>
                        <tr>
                            <div>
                                <td style="text-align: center;border: 1px solid black"> <?php echo $rows['year']; ?></td>
                                <td style="text-align: left;text-indent:7px;border-right: 2px solid black;border-bottom: 1px solid black;"><?php echo $rows['item_name']; ?></td>
                            </div>
                            <?php $jan_total = $jan_total + $rows['January']; ?>
                            <?php if ($tomonth <= 6) { ?>
                                <div>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P1']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_1']; ?> <?php echo $rows['Unit_1']; ?></td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"> <strong><?php echo $rows['January']; ?></strong></td>

                                </div>
                                <?php $feb_total = $feb_total + $rows['February']; // } elseif ($frommonth == 2) { 
                                ?>
                                <div>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P2']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_2']; ?> <?php echo $rows['Unit_2']; ?></td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"><strong><?php echo $rows['February']; ?></strong></td>
                                </div>
                                <?php $mar_total = $mar_total + $rows['March']; // } elseif ($frommonth == 3) { 
                                ?>
                                <div class="p3" style="background-color: red">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P3']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_3']; ?> <?php echo $rows['Unit_3']; ?></td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"><strong><?php echo $rows['March']; ?></strong></td>
                                </div>
                                <?php $apr_total = $apr_total + $rows['April']; // } elseif ($frommonth == 4) { 
                                ?>
                                <div class="p4">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P4']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_4']; ?> <?php echo $rows['Unit_4']; ?></td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"><strong><?php echo $rows['April']; ?></strong></td>
                                </div>
                                <?php $may_total = $may_total + $rows['May']; // } elseif ($frommonth == 4) { 
                                ?>
                                <div class="p5">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P5']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_5']; ?> <?php echo $rows['Unit_5']; ?></td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"><strong><?php echo $rows['May']; ?></strong></td>
                                </div>
                                <?php $jun_total = $jun_total + $rows['June']; // } elseif ($frommonth == 4) { 
                                ?>
                                <div class="p6">
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['P6']; ?></td>
                                    <td style="text-align: right;border: 1px solid black"> <?php echo $rows['Qty_6']; ?> <?php echo $rows['Unit_6']; ?> </td>
                                    <td style="text-align: right;border-right: 2px solid black;border-bottom: 1px solid black;"><strong><?php echo $rows['June']; ?></strong></td>
                                </div>
                            <?php } elseif ($tomonth <= 12) { ?>
                                <?php $jul_total = $jul_total + $rows['July']; ?>
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
                        <?php if ($tomonth <= 6) { ?>
                            <th style="text-align:right" colspan="2">Total</th>
                            <th style="text-align:right" colspan="3"><?php echo $jan_total; ?></th>
                            <th style="text-align:right" colspan="3"><?php echo $feb_total; ?></th>
                            <th style="text-align:right" colspan="3"><?php echo $mar_total; ?></th>
                            <th style="text-align:right" colspan="3"><?php echo $apr_total; ?></th>
                            <th style="text-align:right" colspan="3"><?php echo $may_total; ?></th>
                            <th style="text-align:right" colspan="3"><?php echo $jun_total; ?></th>

                        <?php  } elseif ($tomonth <= 12) { ?>
                            <th style="text-align:right" colspan="2">Total</th>
                            <th style="text-align:right" colspan="3"><?php echo $jul_total; ?></th>
                            <th style="text-align:right" colspan="3"><?php echo $aug_total; ?></th>
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
        echo "<h3 style='color:red;text-align:center'>" . $lang['Please Select Account and Date'] . "</h3>";
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
                // $("#submit").attr("disabled", true);
                // $("#year").attr("disabled", true);
                // alert('To Month Is Not Less Than From Month');
            } else {
                $("#submit").attr("disabled", false);
                $("#year").attr("disabled", false);
            }
        });
    });
</script>
</body>

</html>