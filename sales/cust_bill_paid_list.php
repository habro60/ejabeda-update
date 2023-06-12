<?php
require "../auth/auth.php";
// $supplier = $_SESSION['gl_acc_code']='202011300000';
$cust_id = $_SESSION['link_id'];
require "../database.php";
require "../source/top.php";
// $pid= 1002000; $role_no = $_SESSION['sa_role_no'];
// auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
if (empty($cust_id)) {
    $sql2 = "SELECT  cust_info.id, cust_info.cust_name, cust_info.gl_acc_code, invoice_detail.gl_acc_code FROM  cust_info, invoice_detail where cust_info.gl_acc_code = invoice_detail.gl_acc_code ORDER BY cust_info.gl_acc_code, invoice_detail.order_date";
} else {
    $sql2 =  $sql2 = "SELECT  cust_info.id, cust_info.cust_name, cust_info.gl_acc_code, invoice_detail.gl_acc_code FROM  cust_info, invoice_detail where cust_info.gl_acc_code = $cust_id ORDER BY cust_info.gl_acc_code, invoice_detail.order_date";;
}
$query2 = $conn->query($sql2);
$row = $query2->fetch_assoc();
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Bill  Paid List </h1>
        </div>
    </div>
    <!-- search option -->

    <?php if (empty($cust_id)) {
    ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td>Supplier : <select class="form-control grand" name="gl_acc_code">
                            <option value="">--- Select Customer ---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where  postable_acc= 'Y' and subsidiary_group_code='200' ORDER by acc_code";
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
    } elseif (!empty($cust_id)) { ?>
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
        <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
        <h3 style="text-align:center">Supplier Name : <?php
                                                        if (empty($cust_id)) {
                                                            echo "All Supplier";
                                                        } else {
                                                            echo $row['cust_name'];
                                                        } ?></h3>
    </div>
    <!-- report header end -->
    <!-- search option -->
    <div class="table-responsive-lg">
        <table border="1" style="width: 100%;margin-top:10px">
            <thead>
            <tr style="background-color:powderblue; text-align: center";>
                    <!-- <th style="width:2%">Sl.NO.</th> -->
                    <th >Sl.NO.</th>
                    <th>Bill Date</th>
                    <th>Voucher No</th>
                    <th>Customer Name</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Value </th>
                    <th>Discount Amt.</th>
                    <th>VAT+TAX Amt.</th>
                    <th>Net value.</th>
                    <th>Bill amount</th>
                    <th>Paid Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $d = 0;
                $no = 1;
                $batch_no = 0;
                $tot_discount=0;
                $tot_vat_tax=0;
                $tot_net_amt=0;
                $tot_dr_amt =0.00;
                $tot_cr_amt =0.00;
                $tot_dr_amt=0.00;
            

                if (isset($_POST['submit'])) {
                    $startdate = $_POST['startdate'];
                    $enddate = $conn->escape_string($_POST['enddate']);
                    $gl_acc_code = $conn->escape_string($_POST['gl_acc_code']);

                        $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, tran_details.vaucher_type, tran_details.cr_amt_loc,tran_details.dr_amt_loc, tran_details.pay_on_vouch_no, invoice_detail.order_no,cust_info.gl_acc_code,cust_info.cust_name,invoice_detail.gl_acc_code,invoice_detail.item_no,invoice_detail.item_qty,invoice_detail.unit_price_loc,invoice_detail.total_price_loc, invoice_detail.include_discount_amt,invoice_detail.include_vat_amt,invoice_detail.include_tax_amt, invoice_detail.item_unit,item.id,item_name,code_master.description from tran_details,cust_info,invoice_detail,item,code_master where tran_details.gl_acc_code='$gl_acc_code' and tran_details.gl_acc_code=cust_info.gl_acc_code and tran_details.batch_no=invoice_detail.order_no and tran_details.tran_mode =invoice_detail.order_type  and tran_details.tran_mode!='SV' AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate')and invoice_detail.item_no=item.id and item.id=invoice_detail.item_no and code_master.hardcode='UCODE' and invoice_detail.item_unit=code_master.softcode";

                } elseif (!empty($cust_id)) {
                    if (isset($_POST['induvidul'])) {

                        $start = $_POST['start'];
                        $end = $conn->escape_string($_POST['end']);


                        $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, tran_details.vaucher_type, tran_details.cr_amt_loc,tran_details.dr_amt_loc, tran_details.pay_on_vouch_no, invoice_detail.order_no,cust_info.gl_acc_code,cust_info.cust_name,invoice_detail.gl_acc_code,invoice_detail.item_no,invoice_detail.item_qty,invoice_detail.unit_price_loc,invoice_detail.total_price_loc, invoice_detail.include_discount_amt,invoice_detail.include_vat_amt,invoice_detail.include_tax_amt,invoice_detail.item_unit,item.id,item_name,code_master.description from tran_details,cust_info,invoice_detail,item, code_master where tran_details.gl_acc_code=cust_info.gl_acc_code and  cust_info.id='$cust_id' and tran_details.batch_no=invoice_detail.order_no and tran_details.tran_mode =invoice_detail.order_type  and tran_details.tran_mode!='SV' AND (tran_details.tran_date BETWEEN '$start' AND '$end')and invoice_detail.item_no=item.id and item.id=invoice_detail.item_no and code_master.hardcode='UCODE' and invoice_detail.item_unit=code_master.softcode";
                        } else {

                            $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, tran_details.vaucher_type, tran_details.cr_amt_loc,tran_details.dr_amt_loc, tran_details.pay_on_vouch_no, invoice_detail.order_no,cust_info.gl_acc_code,cust_info.cust_name,invoice_detail.gl_acc_code,invoice_detail.item_no,invoice_detail.item_qty,invoice_detail.unit_price_loc,invoice_detail.total_price_loc, invoice_detail.include_discount_amt,invoice_detail.include_vat_amt,invoice_detail.include_tax_amt,invoice_detail.item_unit,item.id,item_name,code_master.description from tran_details,cust_info,invoice_detail,item,code_master where tran_details.gl_acc_code=cust_info.gl_acc_code and  cust_info.id='$cust_id' and tran_details.batch_no=invoice_detail.order_no and tran_details.tran_mode =invoice_detail.order_type  and tran_details.tran_mode!='SV' and invoice_detail.item_no=item.id and item.id=invoice_detail.item_no and code_master.hardcode='UCODE' and invoice_detail.item_unit=code_master.softcode ";

                 }
                } else {               
                    
                    $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, tran_details.vaucher_type,  tran_details.tran_mode,tran_details.cr_amt_loc, tran_details.dr_amt_loc, tran_details.pay_on_vouch_no, invoice_detail.order_no,cust_info.gl_acc_code,cust_info.cust_name,invoice_detail.gl_acc_code,invoice_detail.item_no,invoice_detail.item_qty,invoice_detail.unit_price_loc,invoice_detail.total_price_loc,invoice_detail.include_discount_amt,invoice_detail.include_vat_amt,invoice_detail.include_tax_amt, invoice_detail.item_unit,item.id,item_name,code_master.description from tran_details,cust_info,invoice_detail,item,code_master where   tran_details.gl_acc_code=cust_info.gl_acc_code and tran_details.batch_no=invoice_detail.order_no and tran_details.tran_mode =invoice_detail.order_type and tran_details.tran_mode !='SV' and invoice_detail.item_no=item.id and item.id=invoice_detail.item_no and code_master.hardcode='UCODE' and invoice_detail.item_unit=code_master.softcode";

                }  
                $query = $conn->query($sql);
                while ($rows = $query->fetch_assoc()) {
                ?>
                 <tr>
                      <td style="text-align: right"><?php if ($rows['batch_no'] > $batch_no) {
                                                            echo $no++; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                     <td style="text-align: center"><?php if ($rows['batch_no'] > $batch_no) {
                                                            echo $rows['tran_date']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                     <td style="text-align: center"><?php if ($rows['batch_no'] > $batch_no) {
                                                            echo $rows['batch_no']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                     <td style="text-align: center"><?php if ($rows['batch_no'] > $batch_no) {
                                                            echo $rows['cust_name']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                                   
                      <td style="background-color:powderblue; text-align: left"><?php echo $rows['item_name'];?></td>
                     <td style=" background-color:powderblue; text-align: right"><?php echo $rows['item_qty'];echo "  "; echo $rows['description']; ?></td>
                     <td style=" background-color:powderblue; text-align: right"><?php echo $rows['unit_price_loc']; ?></td>
                     <td style="background-color:powderblue; text-align: right"><?php echo $rows['total_price_loc']; ?></td>

                     <td style="background-color:powderblue; text-align: right"><?php echo $rows['include_discount_amt']; $tot_discount = $tot_discount + $rows['include_discount_amt'];?></td>
                     <td style="background-color:powderblue; text-align: right"><?php echo ( $rows['include_vat_amt'] + $rows['include_tax_amt'] ); $tot_vat_tax = ($tot_vat_tax + ( $rows['include_vat_amt'] + $rows['include_tax_amt'] )); ?></td>
                     <td style="background-color:lightgray; text-align: right"><?php echo ( $rows['include_vat_amt'] + $rows['include_tax_amt']  + $rows['total_price_loc'] - $rows['include_discount_amt']);$tot_net_amt = ($tot_net_amt + ( $rows['include_vat_amt'] + $rows['include_tax_amt']  + $rows['total_price_loc'] - $rows['include_discount_amt']) ); ?></td>

                     <td style="text-align: right"><?php if ($rows['batch_no'] > $batch_no){
                                                             echo $rows['dr_amt_loc']; 
                                                               
                                                            }else {echo "";
                                                        }?></td>
                
                    <td style="text-align: right"><?php if ($rows['batch_no'] > $batch_no) {
                                                            echo  $rows['cr_amt_loc']; 
                                                            $tot_cr_amt = $tot_cr_amt + $rows['cr_amt_loc'];
                                                            $batch_no=$rows['batch_no'];
                                                            
                                                        } else { 
                                                            echo "";
                                                        }?></td>
                    
                     
                     
                                                                  
                 </tr>
                 
                <?php } ?>
                <tfoot>
               <tr style="background-color:powderblue";>
                    <th style="text-align:right" colspan="11"> Total Amount in TK.</th>
                    <th style="text-align:right" colspan="1"><?php echo $tot_dr_amt; ?></th>
                    <th style="text-align:right" colspan="1"><?php echo $tot_cr_amt; ?></th>  
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
        $("#1108000").addClass('active');
        $("#1100000").addClass('active');
        $("#1100000").addClass('is-expanded');
    });
</script>
</body>

</html>