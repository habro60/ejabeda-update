<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
$pid= 704000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require '../source/header.php';
require '../source/sidebar.php';
?>
<style>
    .cols6 {
        -webkit-box-flex: 0;
        -ms-flex: 0;
        flex: 45%;
        max-width: 50%;
    }
    .bor,
    thead,
    tr,
    th,
    td {
        border-style: solid;
        border-color: black;
        border-width: 1px;
    }
</style>
<main class="app-content">
    <div class="app-title">
        <h1><i class="fa fa-dashboard"></i> Item wise Stock Report </h1>

    </div>
    <form method="POST">
        <div>
            <label for="">As on Date </label>
            <input type="date" name="enddate" id="" required>
            <input type="submit" name="submit" id="submitBtn" class="btn-info" value="Report View">
        </div>
    </form>
    <div class="row">
        <div class="col-12">
            <?php
            require '../report/report_header.php';
            ?>
            <h3 style="text-align:center">Item Wise Stock Report </h3>
            <?php
            if (isset($_POST['submit'])) {
                $enddate = $conn->escape_string($_POST["enddate"]);
                
                              $sql= "CREATE or REPLACE  VIEW view_delivery_item AS
                              SELECT `office_code`, `order_type`, `in_out_flag`,`order_no`,`order_date`,`item_no`,`item_qty`,`item_unit`,`total_price_loc`
                              FROM invoice_detail
                              WHERE  `in_out_flag`='2' and order_type= 'DELIV'";
                               $query = $conn->query($sql);

                               
                               $sql = "CREATE or REPLACE VIEW view_pur_item AS
                               SELECT `office_code`, `order_type`, `in_out_flag`,`order_no`,`order_date`,`item_no`,`item_qty`,`item_unit`,`total_price_loc`
                               FROM invoice_detail
                               WHERE  `in_out_flag`='1' and (`order_type`='PV' or `order_type`='PVCHQ' or `order_type`='PVC')";
                               $query = $conn->query($sql);   
            ?>
            
                <h5 style="text-align: center">As on Date <?php  echo $enddate; ?></h5>
                <div class="row" style="margin-bottom: 5px">
                    <div class="col-12">
                        <div class="pull-right">
                            <a id='print' title="Print" class="btn btn-danger" target="_blank" href="inc_exp_print.php?from=<?php echo $startdate; ?>&to=<?php echo $enddate; ?>"></i>Print</a>
                            <a id='print' title="Print" class="btn btn-danger" href="inc_exp_pdf.php?from=<?php echo $enddate; ?>"></i>PDF</a>
                            <a id='print' title="Print" class="btn btn-danger" href="inc_exp_word.php?from=<?php echo $enddate; ?>"></i>docx</a>
                            <a id='print' title="Print" class="btn btn-danger" href="inc_exp_excel.php?from=<?php echo $enddate; ?>"></i>Excel</a>
                            <a id='print' title="Print" class="btn btn-danger" href="inc_exp_word.php?from=<?php echo $enddate; ?>"></i>csv</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <table style="width:100%" class="bor">
                            <thead>
                                  <tr style="text-align: center; font-weight:bold">
                                    <td colspan="5"> purchase Item</td>
                                </tr>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Item No.</th>
                                    <th>Item Name</th>
                                    <th>Pur. Qty.</th>
                                    <th>Pur. Amo.</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                $no='1';
                                $total_pur_amt='0';
                                $enddate = $conn->escape_string($_POST['enddate']);
                                $sql = "SELECT view_pur_item.item_no, item.item_name, sum(view_pur_item.item_qty) as sum_pur_qty, view_pur_item.item_unit, sum(view_pur_item.total_price_loc) as sum_pur_value, code_master.description FROM `view_pur_item`, item, code_master where view_pur_item.item_no=item.id  and code_master.hardcode='UCODE' and code_master.softcode=item.unit and view_pur_item.order_date < '$enddate' group by view_pur_item.item_no

                                ";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) {
                                 ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $row['item_no']; ?></td>
                                        <td><?php echo $row['item_name']; ?></td>
                                        <td style="text-align: right"><?php echo $row['sum_pur_qty'] ; echo "  ";  echo $row['description']; ?></td>
                                        <td style="text-align: right"><?php echo $row['sum_pur_value']; $total_pur_amt = $total_pur_amt + $row['sum_pur_value'] ?></td>
                                       
                                        
                                    <?php
                                }
                                    ?>
                            </tbody>
                            <tfoot>
                                <tr style="text-align: right; font-weight:bold">
                                    <td colspan="4">Total purchase</td>
                                    <td><?php echo $total_pur_amt; ?></td>
                                </tr> 
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-5">
                        <table style="width:100%" class="bor">
                            <thead>
                                 <tr style="text-align: center; font-weight:bold">
                                    <td colspan="4"> Delivery Item</td>
                                </tr>
                                <tr>
                                    <th>Item Number</th>
                                    <th>Item Name</th>
                                    <th>Delivery  Qty.</th>
                                    <th>Delivery Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                $total_deliv_amt='0';
                                $enddate = $conn->escape_string($_POST['enddate']);
                                $sql = "SELECT view_delivery_item.item_no, item.item_name, sum(view_delivery_item.item_qty) as sum_deliv_qty, view_delivery_item.item_unit, sum(view_delivery_item.total_price_loc) as sum_deliv_value,  code_master.description FROM view_delivery_item, item, code_master where view_delivery_item.item_no=item.id  and code_master.hardcode='UCODE' and code_master.softcode=item.unit and view_delivery_item.order_date < '$enddate' group by view_delivery_item.item_no

                                ";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) {
                                 ?>
                                    <tr>
                                        <td><?php echo $row['item_no']; ?></td>
                                        <td><?php echo $row['item_name']; ?></td>
                                        <td style="text-align: right"><?php echo $row['sum_deliv_qty'] ; echo "  "; echo $row['description'];?></td>
                                        <td style="text-align: right"><?php echo $row['sum_deliv_value']; $total_deliv_amt = $total_deliv_amt + $row['sum_deliv_value'] ?></td>
                                    <?php
                                }
                                    ?>
                            </tbody>
                            <tfoot>
                              
                                <tr style="text-align: right; font-weight:bold">
                                    <td colspan="3">Total Delivery </td>
                                    <td><?php echo $total_deliv_amt; ?></td>
                                </tr> 
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-2">
                        <table style="width:100%" class="bor">
                            <thead>
                                 <tr style="text-align: center; font-weight:bold">
                                    <td colspan="2"> Stock Item</td>
                                </tr>
                                <tr>
                                    <th>Stock Qty</th>
                                    <th>Stock Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                $tot_stock_amt='0';
                                $enddate = $conn->escape_string($_POST['enddate']);
                                $sql = "SELECT view_pur_item.item_no, sum(view_pur_item.item_qty) as sum_pur_qty, view_pur_item.item_unit, sum(view_pur_item.total_price_loc) as sum_pur_value, sum(view_delivery_item.item_qty) as sum_deliv_qty, view_delivery_item.item_unit, sum(view_delivery_item.total_price_loc) as sum_deliv_value, code_master.description FROM `view_pur_item`,view_delivery_item, item, code_master where view_pur_item.item_no=item.id and view_delivery_item.item_no=item.id and view_pur_item.item_no=view_delivery_item.item_no and code_master.hardcode='UCODE' and code_master.softcode=item.unit and view_pur_item.order_date < '$enddate' group by view_pur_item.item_no

                                ";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) {
                                 ?>
                                    <tr>
                                        <td style="text-align: right"><?php echo $tot_stock_amt= ($row['sum_pur_qty'] -$row['sum_deliv_qty']);  ?></td>
                                        <td style="text-align: right"><?php echo $tot_stock_amt= ($row['sum_pur_value'] -$row['sum_deliv_value']);  ?></td>
                                    <?php
                                }
                                    ?>
                            </tbody>
                            <tfoot>
                                <tr style="text-align: right; font-weight:bold">
                                    <td colspan="1">Total Stock </td>
                                    <td><?php echo $tot_stock_amt; ?></td>
                                </tr> 
                                
                                
                            </tfoot>
                        </table>
                    </div>


                <div>
                   
                        <?php
                    } else {
                        echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select From Date and To Date</h1>";
                    }
                        ?>
                 </table>
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
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#704000").addClass('active');
        $("#700000").addClass('active');
        $("#700000").addClass('is-expanded');
    });
</script>

</body>

</html>