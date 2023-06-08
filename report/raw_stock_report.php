<?php
require "../auth/auth.php";
// $supplier = $_SESSION['gl_acc_code']='202011300000';
$supp_id = $_SESSION['link_id'];
require "../database.php";
require "../source/top.php";
// $pid= 1002000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
if (empty($supp_id)) {
    $sql2 = "SELECT  supp_info.id, supp_info.supp_name, supp_info.gl_acc_code, invoice_detail.gl_acc_code FROM  supp_info, invoice_detail where supp_info.gl_acc_code = invoice_detail.gl_acc_code ORDER BY supp_info.gl_acc_code, invoice_detail.order_date";
} else {
    $sql2 =  $sql2 = "SELECT  supp_info.id, supp_info.supp_name, supp_info.gl_acc_code, invoice_detail.gl_acc_code FROM  supp_info, invoice_detail where supp_info.gl_acc_code = $supp_id ORDER BY supp_info.gl_acc_code, invoice_detail.order_date";;
}
$query2 = $conn->query($sql2);
$row = $query2->fetch_assoc();
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Stock Report</h1>
        </div>
    </div>
    <!-- search option -->

    <?php if (empty($supp_id)) {
    ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td>Supplier : <select class="form-control grand" name="gl_acc_code">
                            <option value="">--- Select Account ---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where   acc_type='5' and postable_acc= 'Y' ORDER by acc_code";
                            $selectQueryResult =  $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($drrow = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $drrow['acc_code'] . '">'  . $drrow['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                    <td> As on date: <input type="date" name="startdate" id="" class="form-control" required></td>
                    <td> From: <input type="date" name="enddate" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    } elseif (!empty($supp_id)) { ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td> As on date: <input type="date" name="start" id="" class="form-control" required></td>
                    <td> From: <input type="date" name="end" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="induvidul" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    } ?>
    <!-- !search option -->
    <!-- report header start -->
    <?php
    $org_logo = $_SESSION['org_logo'];
    $org_name = $_SESSION['org_name'];
    ?>
    <div>
       <h2 style="text-align:center; padding-top:40px"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
        
        <h3 style="text-align:center"> <?Php                                                            echo 'Stock Report of Raw Material Purchase';
                                                         ?></h3>
        
    </div>
    <!-- report header end -->
    <!-- search option -->
    <div class="table-responsive-lg">
        <table border="1" style="width: 100%;margin-top:10px">
            <thead>
            <thead>
            <tr style="background-color:powderblue";>
            <th style="text-align:center" colspan="4">  </th>
                    <th style="text-align:center" colspan="5">  Stock In </th>
                
                    <th style="text-align:center" colspan="6"> Stock Out  </th>  
                </tr>
            </thead>
            <tr style="background-color:powderblue; text-align: center";>
                    <!-- <th style="width:2%">Sl.NO.</th> -->
                    <th >Sl.NO.</th>
                    <th>Delivery Date</th>
                    <th>Delivery Receipt No</th>
                    <th>Account Head</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Value </th>
                    <th>Value with dis. VAT TAX </th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Value </th>
                    <th>Value with dis. VAT TAX </th>
                    
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $d = 0;
                $no = 1;
                $batch_no = 0;
                $tot_in_amt =0.00;
                $tot_out_amt=0.00;
            
                 if (isset($_POST['submit'])) {
                   $startdate = $_POST['startdate'];
                   $enddate = $conn->escape_string($_POST['enddate']);
                   $gl_acc_code = $conn->escape_string($_POST['gl_acc_code']);

                   $sql=" select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, tran_details.vaucher_type, tran_details.dr_amt_loc, tran_details.cr_amt_loc, invoice_detail.order_no, invoice_detail.in_out_flag,invoice_detail.for_gl_acc_code,invoice_detail.item_no,invoice_detail.item_qty,invoice_detail.unit_price_loc,invoice_detail.total_price_loc, invoice_detail.item_unit, invoice_detail.include_discount_rate, invoice_detail.include_discount_amt, invoice_detail.include_vat_rate, invoice_detail.include_vat_amt, invoice_detail.include_tax_rate, invoice_detail.include_tax_amt, gl_acc_code.acc_head as supp_name,item.id,item_name from tran_details,invoice_detail,item, gl_acc_code where tran_details.batch_no=invoice_detail.order_no and tran_details.gl_acc_code='$gl_acc_code' and tran_details.tran_mode=invoice_detail.order_type and ( invoice_detail.order_type = 'PV' or invoice_detail.order_type = 'PVC' or  invoice_detail.order_type='DELIV' or invoice_detail.order_type='PVR' or invoice_detail.order_type='PVCHQ') and gl_acc_code.acc_code=tran_details.gl_acc_code and invoice_detail.item_no=item.id AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') order by tran_details.tran_date,tran_details.batch_no invoice_detail.item_no";
                 } else {   
                    $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, tran_details.vaucher_type, tran_details.dr_amt_loc, tran_details.cr_amt_loc, invoice_detail.order_no,invoice_detail.in_out_flag,invoice_detail.for_gl_acc_code,invoice_detail.item_no,invoice_detail.item_qty,invoice_detail.unit_price_loc,invoice_detail.total_price_loc, invoice_detail.item_unit, invoice_detail.include_discount_rate, invoice_detail.include_discount_amt, invoice_detail.include_vat_rate, invoice_detail.include_vat_amt, invoice_detail.include_tax_rate, invoice_detail.include_tax_amt, gl_acc_code.acc_head as supp_name,item.id,item_name from tran_details,invoice_detail,item, gl_acc_code where tran_details.batch_no=invoice_detail.order_no and tran_details.gl_acc_code=invoice_detail.for_gl_acc_code and tran_details.tran_mode=invoice_detail.order_type and ( invoice_detail.order_type = 'PV' or invoice_detail.order_type = 'PVC' or  invoice_detail.order_type='DELIV' or invoice_detail.order_type='PVR' or invoice_detail.order_type='PVCHQ')  and gl_acc_code.acc_code=tran_details.gl_acc_code and invoice_detail.item_no=item.id order by invoice_detail.item_no, tran_details.tran_date,tran_details.batch_no";
                 }   
                $query = $conn->query($sql);
                while ($rows = $query->fetch_assoc()) {
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
                                                            echo $rows['supp_name']; 
                                                            $batch_no=$rows['batch_no'];
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                                   
                      <td style="background-color:powderblue; text-align: left"><?php  if ($rows['in_out_flag'] == 1) { echo $rows['item_name'];  } else { echo ""; }?></td>
                      <td style=" background-color:powderblue; text-align: right"><?php if ($rows['in_out_flag'] == 1) {echo $rows['item_qty']; } else { echo "";}?></td>
                      <td style=" background-color:powderblue; text-align: right"><?php if ($rows['in_out_flag'] == 1) {echo $rows['unit_price_loc']; } else  { echo "";}?></td>
                      <td style="background-color:powderblue; text-align: right"><?php if ($rows['in_out_flag'] == 1) { echo $rows['total_price_loc']; $tot_in_amt = $tot_in_amt + $rows['total_price_loc']; } else { echo "";}?></td>
                      <td style="background-color:powderblue; text-align: right"><?php if ($rows['in_out_flag'] == 1) { echo ($rows['total_price_loc'] - $rows['include_discount_rate'] + $rows['include_vat_rate']  + $rows['include_tax_amt']); } else { echo "";}?></td>
                   
                   
                    <!-- ===================== stock out info==================== -->
                    <td style="background-color:white; text-align: left"><?php  if ($rows['in_out_flag'] == 2) { echo $rows['item_name'];  } else { echo ""; }?></td>
                      <td style=" background-color:white; text-align: right"><?php if ($rows['in_out_flag'] == 2) {echo $rows['item_qty']; } else { echo "";}?></td>
                      <td style=" background-color:white; text-align: right"><?php if ($rows['in_out_flag'] ==2) {echo $rows['unit_price_loc']; } else  { echo "";}?></td>
                      <td style="background-color:white; text-align: right"><?php if ($rows['in_out_flag'] == 2) { echo $rows['total_price_loc']; $tot_out_amt = $tot_out_amt + $rows['total_price_loc'];} else { echo "";}?></td>
                      <td style="background-color:white; text-align: right"><?php if ($rows['in_out_flag'] ==2) { echo ($rows['total_price_loc'] - $rows['include_discount_rate'] + $rows['include_vat_rate']  + $rows['include_tax_amt']); } else { echo "";}?></td>
                   

                      
                 </tr>
                 
                <?php } ?>
            <tfoot>
            <tr style="background-color:powderblue";>
                    <th style="text-align:right" colspan="8"> Total Stock (in)  Amount (TK.)</th>
                    
                    <th style="text-align:right" colspan="1"><?php echo $tot_in_amt?></th>  
                    <th style="text-align:right" colspan="4">Total Stock (out) Amount (TK.)</th>
                    
                    <th style="text-align:right" colspan="1"><?php echo $tot_out_amt; ?></th>


                </tr>
            </tfoot>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
    </div>
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
        $("#1007000").addClass('active');
        $("#1000000").addClass('active');
        $("#1000000").addClass('is-expanded');
    });
</script>
</body>

</html>