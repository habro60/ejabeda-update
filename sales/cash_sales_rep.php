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
            <h1><i class="fa fa-dashboard"></i> Cash Sale Report</h1>
        </div>
    </div>

    <!-- report header start -->
    <?php
    $org_logo = $_SESSION['org_logo'];
    $org_name = $_SESSION['org_name'];
    ?>
    <div>
        <h2 style="text-align:center; padding-top:40px"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:80px;height:40px;"> <?php echo $org_name; ?></h2>
    </div>
     <div>
        <h4 style="text-align:center">Cash Sale Report </h4>
    </div>

    <?php if (empty($supp_id)) {
    ?>
        <table id="submit">
            <form method="POST">
                <tr>
                   
                    <td> From date: <input type="date" name="startdate" id="" class="form-control" required></td>
                    <td> To Date: <input type="date" name="enddate" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    } elseif (!empty($supp_id)) { ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td> From Date: <input type="date" name="start" id="" class="form-control" required></td>
                    <td> To Date: <input type="date" name="end" id="" class="form-control" required></td>
                    <td>submit:<input type="submit" name="submit" value="submit" class="form-control btn btn-dark" id="dateSubmit"></td>
                </tr>
            </form>
        </table>
    <?php
    } ?>
    <!--  -->
    <div class="table-responsive-lg">
               <table border="1" style="width: 100%;margin-top:10px">
            <thead>
            <tr style="background-color:powderblue; text-align: center";>
                    <!-- <th style="width:2%">Sl.NO.</th> -->
                    <th >Sl.NO.</th>
                    <th>Sales Date</th>
                    <th>Voucher No</th>
                    <th>Account Head</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Value </th>
                    <th>Sales amount</th>
                    <th>Return Amount</th>
                    <th>Net Receive Amt</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $d = 0;
                $no = 1;
                $batch_no = 0;
                $tot_cr_amt =0.00;
                $tot_dr_amt=0.00;
            
                 if (isset($_POST['submit'])) {
                     
                   $startdate = $_POST['startdate'];
                   
                   echo $startdate;
                   $enddate = $_POST['enddate'];
                   
                $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, tran_details.vaucher_type, tran_details.dr_amt_loc, tran_details.cr_amt_loc, sales_detail.order_no,sales_detail.gl_acc_code,sales_detail.item_no,sales_detail.item_qty,sales_detail.unit_price_loc,sales_detail.total_price_loc, sales_detail.item_unit, sales_detail.include_discount_rate, sales_detail.include_discount_amt, sales_detail.include_vat_rate, sales_detail.include_vat_amt, sales_detail.include_tax_rate, sales_detail.include_tax_amt, gl_acc_code.acc_head as supp_name,item.id,item_name, code_master.description from tran_details,sales_detail,item, gl_acc_code, code_master where tran_details.batch_no=sales_detail.order_no and tran_details.gl_acc_code=sales_detail.gl_acc_code and tran_details.tran_mode=sales_detail.order_type and (sales_detail.order_type='PVC' or sales_detail.order_type='PVCHQ'  or sales_detail.order_type='SVC') and gl_acc_code.acc_code=tran_details.gl_acc_code and sales_detail.item_no=item.id AND (tran_details.tran_date BETWEEN '$startdate' AND '$enddate') and code_master.hardcode='UCODE' and sales_detail.item_unit=code_master.softcode order by tran_details.tran_date, tran_details.batch_no";
                    
                  
                 } else {   
                     
                    
                     $sql="select tran_details.tran_date,tran_details.batch_no, tran_details.gl_acc_code, tran_details.vaucher_type, tran_details.dr_amt_loc, tran_details.cr_amt_loc, sales_detail.order_no,sales_detail.gl_acc_code,sales_detail.item_no,sales_detail.item_qty,sales_detail.unit_price_loc,sales_detail.total_price_loc, sales_detail.item_unit, sales_detail.include_discount_rate, sales_detail.include_discount_amt, sales_detail.include_vat_rate, sales_detail.include_vat_amt, sales_detail.include_tax_rate, sales_detail.include_tax_amt, gl_acc_code.acc_head as supp_name,item.id,item_name from tran_details,sales_detail,item, gl_acc_code where tran_details.batch_no=sales_detail.order_no and tran_details.gl_acc_code=sales_detail.gl_acc_code and tran_details.tran_mode=sales_detail.order_type and (sales_detail.order_type='SVC' or sales_detail.order_type='SVCHQ') and gl_acc_code.acc_code=tran_details.gl_acc_code and sales_detail.item_no=item.id order by tran_details.tran_date";
                 }
                // 
                
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
                                                            echo $rows['supp_name']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  
                                   
                      <td style="background-color:powderblue; text-align: left"><?php echo $rows['item_name'];?></td>
                     <td style=" background-color:powderblue; text-align: right"><?php echo $rows['item_qty'];echo "  "; echo $rows['item_unit']; ?></td>
                     <td style=" background-color:powderblue; text-align: right"><?php echo $rows['unit_price_loc']; ?></td>
                     <td style="background-color:powderblue; text-align: right"><?php echo $rows['total_price_loc']; echo " - Discount @ " ; echo $rows['include_discount_rate']; echo "% TK "; echo $rows['include_discount_amt']; echo "+  VAT @ " ; echo $rows['include_vat_rate']; echo "% TK "; echo $rows['include_vat_amt']; echo "+  Tax @ " ; echo $rows['include_tax_rate']; echo "% TK "; echo $rows['include_tax_amt']?></td>
                    
                     
                     <td style="text-align: right"><?php if ($rows['batch_no'] > $batch_no) {
                                                            echo $rows['dr_amt_loc']; 
                                                            $tot_dr_amt = $tot_cr_amt + $rows['dr_amt_loc'];
                                                            $batch_no=$rows['batch_no'];
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                     
                   
                    <td style="text-align: right"><?php if ($rows['cr_amt_loc'] ==0) {
                                                            echo ""; 
                                                            
                                                        } else { 
                                                            echo  $rows['cr_amt_loc'];
                                                            $tot_cr_amt = $tot_cr_amt + $rows['cr_amt_loc'];
                                                        }?></td>
                    
                     
                     <td style="text-align: right"><?php  if ($rows['dr_amt_loc'] ==0)  {
                                                            echo ""; 
                                                            
                                                        } else {
                                                            echo ($tot_dr_amt -$tot_cr_amt);
                                                            
                                                        }?></td>
                                                                    
                 </tr>
                 
                <?php } ?>
 </tbody>
            <tfoot>
            <tr style="background-color:powderblue";>
                    <th style="text-align:right" colspan="8"> Total Amount in TK.</th>
                    <th style="text-align:right" colspan="1"><?php echo $tot_dr_amt; ?></th>
                    <th style="text-align:right" colspan="1"><?php echo $tot_cr_amt; ?></th>
                    <th style="text-align:right" colspan="1"><?php echo ($tot_dr_amt - $tot_cr_amt); ?></th>  
                </tr>
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