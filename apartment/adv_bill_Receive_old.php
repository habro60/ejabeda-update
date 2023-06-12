<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST["submit"])) {

// =================================== insert in to bill detail================
     $by_account = $_POST['by_account'];

     $sql="select owner_id, owner_name, gl_acc_code from apart_owner_info where gl_acc_code='$by_account'";
     $sqlreturn = mysqli_query($conn, $sql);
     $rows = mysqli_fetch_assoc($sqlreturn);
     $owner_id = $rows['owner_id']; 
     $regular_pay_flag='1';
     
     $bill_date = $_POST['tran_date'];
     $batch_no = $_POST['batch_no'];
    
    // payment date .. 
    $bill_last_pay_date = $_POST['tran_date'];
    // process date ..
    $bill_process_date =  $_POST['tran_date'];
    $bill_paid_date =  $_POST['tran_date'];
    $office_code = $_SESSION['office_code'];
    // --------------------------
    $ss_creator = $_SESSION['username'];
    $ss_created_on = $_POST['tran_date'];;
    $ss_org_no = $_SESSION['org_no'];
     $mth=0;
    for ($count = 0; $count < count($_POST['bill_charge_code']); ++$count) {
    
            $flat_no = $_POST['flat_no'][$count];
            $bill_for_month =  $_POST['bill_for_month'][$count];
            $bill_charge_code = $_POST['bill_charge_code'][$count];
            $bill_charge_name = $_POST['bill_charge_name'][$count];
            $bill_pay_method = 'Fixed';
            $pay_curr = 'BDT';
            $unit_price_loc=$_POST['unit_price_loc'][$count];
            $bill_amt = $_POST['total_price'][$count];
            $flat_no = $_POST['flat_no'][$count];
            // $owner_id = $_POST['owner_id'][$count];
            $link_gl_acc_code = $_POST['link_gl_acc_code'][$count];
            $item_qty =$_POST['item_qty'][$count];

            
         if ($bill_charge_code > 0) {
             
              for ($mth = 0; $mth <  $item_qty ; ++$mth) {

                 $query = "INSERT INTO `apart_owner_bill_detail` (`id`,`office_code`,`owner_id`,`bill_date`,`bill_for_month`,`bill_charge_code`,bill_charge_name,`bill_last_pay_date`,`bill_paid_flag`,`bill_paid_date`,pay_method, pay_curr, bill_process_date,`bill_amount`,`owner_gl_code`, flat_no,`link_gl_acc_code`,batch_no, regular_pay_flag,`ss_creator`,`ss_created_on`,`ss_org_no`) values (NULL, '$office_code','$owner_id',DATE_ADD('$bill_for_month', INTERVAL $mth Month),DATE_FORMAT(DATE_ADD('$bill_for_month', INTERVAL $mth Month),'%Y-%m'), '$bill_charge_code','$bill_charge_name','$bill_last_pay_date','1','$bill_paid_date', '$bill_pay_method', '$pay_curr','$bill_process_date','$unit_price_loc','$by_account','$flat_no','$link_gl_acc_code','$batch_no','$regular_pay_flag','$ss_creator','$ss_created_on','$ss_org_no' )";
                //  echo $query;
                //  exit;
                $conn->query($query);
                if ($conn->affected_rows == TRUE) {
                  $assign_menu = "Successfully";
                  } else {
                    }
                }

    } else {
      $assign_menu_failled = "Failled";
    }
  }

//   =====================insert Charge Link Account  (crdit TRN)=========================
  $by_account = $_POST['by_account'];
  $batch_no = $_POST['batch_no'];
//   $link_gl_acc_code =$_POST['link_gl_acc_code'];
  $bill_process_date1 =  $_POST['tran_date'];

  $insertBill = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `cr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) select null,apart_owner_bill_detail.office_code, year(apart_owner_bill_detail.ss_created_on), '$batch_no','$bill_process_date1', apart_owner_bill_detail.link_gl_acc_code, 'Bill','CR', concat(',', apart_owner_bill_detail.bill_charge_name,'  for  ', date_format(apart_owner_bill_detail.bill_date, '%M %Y')), sum(apart_owner_bill_detail.bill_amount), apart_owner_bill_detail.ss_creator, apart_owner_bill_detail.ss_created_on, apart_owner_bill_detail.ss_org_no from apart_owner_bill_detail where  apart_owner_bill_detail.batch_no ='$batch_no' group by apart_owner_bill_detail.bill_charge_code order by apart_owner_bill_detail.bill_charge_code";

  $conn->query($insertBill);
  if ($conn->affected_rows == 1) {
    $massage_cr = "cr Save Successfully!!";
  }

//   ==================================== insert in Owner Account  (Debit TRN)============================

  $insertOwner = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `dr_amt_loc`,`ss_creator`,`ss_creator_on`,`ss_org_no`) select null,apart_owner_bill_detail.office_code, year(apart_owner_bill_detail.ss_created_on), '$batch_no', '$bill_process_date1', '$by_account', 'Bill','DR', concat(',', 'Bill and Charge','  for  ',date_format(apart_owner_bill_detail.bill_date,'%M %Y')), sum(apart_owner_bill_detail.bill_amount), apart_owner_bill_detail.ss_creator, apart_owner_bill_detail.ss_created_on, apart_owner_bill_detail.ss_org_no from apart_owner_bill_detail where  apart_owner_bill_detail.batch_no='$batch_no' group by apart_owner_bill_detail.owner_gl_code order by apart_owner_bill_detail.owner_gl_code";
  
  $conn->query($insertOwner);
  if ($conn->affected_rows == 1) {
    $massage_dr = "DR Save Successfully!!";
  }
// ================================== close bill detail===================
    $office_code = $_SESSION['office_code'];
    $in_out_flag = "1";
    $year_code = $_SESSION['org_fin_year_st'];
    $batch_no = $_POST['batch_no'];
    $tran_date = $_POST['tran_date'];
    // 
    
    
    $vaucher_typedr = "DR";
    $vaucher_typecr = "CR";
    $by_account = $_POST['by_account'];
    $to_account = $_POST['to_account'];
    $particulardr = 'Advance Bill Receive';
    $particularcr = 'Advance Bill Received';
    $draccount = $_POST['draccount'];
    $craccount = $_POST['craccount'];
    $ss_creator = $_SESSION['username'];
    $ss_org_no = $_SESSION['org_no'];
    $pay_on_vouch_no =  $_POST['batch_no'];
    $bill_paid_flag = '2';
    //
    $acc_type = $_POST['acc_type'];
    if ($acc_type == '1') {
        $tran_mode = "CASBR";
    } elseif ($acc_type == '2') {
        $tran_mode = "CHQBR";
    }
    
    //==================inser Cash Account (dr. TRN) =================================
    $insertQuerydr = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `dr_amt_loc`,`pay_on_vouch_no`,`bill_paid_flag`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$to_account', '$tran_mode','$vaucher_typedr','$particulardr','$draccount','$pay_on_vouch_no','$bill_paid_flag','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuerydr);
    if ($conn->affected_rows == 1) {
        $massage_dr = "dr Save Successfully!!";
    }
     
    // ==================insert Owner Account (crdit TRN)=================================================
    $insertQuerycr = "INSERT INTO `tran_details` (`tran_no`,`office_code`,`year_code`,`batch_no`, `tran_date`, `gl_acc_code`,`tran_mode`,`vaucher_type`, `description`, `cr_amt_loc`,`pay_on_vouch_no`,`bill_paid_flag`,`ss_creator`,`ss_creator_on`,`ss_org_no`) VALUES (NULL,'$office_code','$year_code','$batch_no','$tran_date','$by_account','$tran_mode','$vaucher_typecr','$particularcr','$craccount','$pay_on_vouch_no','$bill_paid_flag','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuerycr);
     if ($conn->affected_rows == 1) {
         $messagescr = "Insert successfully";
            }
    
    
        header('refresh:1;../apartment/Adv_bill_Receive.php');
    }

require "../source/top.php";
$pid = 1001000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>

<main class="app-content">
         <div>
            <h1><i class="fa fa-dashboard"></i> Advance Bill Received by Cash or Cheque</h1>
        </div>
    <form action="" method="post">
        <table class="table bg-light table-bordered table-sm">
            <thead>
                <tr>
                    <th>Bill  No</th>
                    <th style="text-align: center">Transaction Date</th>
                    <th style="text-align: center">Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $querys = "insert into bach_no (username) values ('$_SESSION[username]')";
                $returns = mysqli_query($conn, $querys);
                $lastRows = $conn->insert_id;
                ?>
                <tr>
                    <td> <input type="text" name="batch_no" readonly class="org_form org_12" autofocus value="<?php echo $lastRows; ?>"></td>
                    <td> <input type="date" id="date" class="org_form" name="tran_date" value="<?php echo date('Y-m-d'); ?>"></td>
                    <td> <input type="text" id="date" class="org_form" id="clock" value="<?php date_default_timezone_set('Asia/Dhaka');
                                                                                            echo date("h:i:sa"); ?>" readonly></td>
                </tr>
            </tbody>
        </table>
         <table>
           <thead>
           <tr>
           <td></td>
           <div class="form-group row">
            
            <td><select name="by_account" class="form-control by_account" onchange="getFlatNo(this.value)" required>
                    <option value="">-Select Project-</option>
                    <?php
                    // $selectQuery = "SELECT DISTINCT acc_code, acc_head  FROM gl_acc_code where postable_acc= 'Y' AND subsidiary_group_code= '800' ORDER by acc_code";
                    $selectQuery="SELECT DISTINCT gl_acc_code.acc_code, gl_acc_code.acc_head, apart_owner_info.owner_id, flat_info.flat_no, flat_info.owner_id FROM gl_acc_code, apart_owner_info, flat_info where postable_acc= 'Y' AND subsidiary_group_code= '800' and apart_owner_info.gl_acc_code=gl_acc_code.acc_code  and flat_info.owner_id=apart_owner_info.owner_id ORDER by acc_code";
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                        while ($row_off = $selectQueryResult->fetch_assoc()) {
                    ?>
                    <?php
                            echo '<option value="' . $row_off['acc_code'] . '">'  . $row_off['flat_no'] . '</option>';
                        }
                    }
                    ?>
                </select></td>
                <td><input type="text" class="dr_amount form-control" id="dr_amount" name="draccount" placeholder="Dr.Amount" readonly></td>
                    <td style="width: 20px"> <strong>Dr</strong></td>
            </div>
        </div>

        <table class="table bg-light table-bordered table-sm" id="multi_table">
            <thead>
                <tr class="table-active">
                    <th>No</th>
                    <th> Flat No.</th>
                    <th>Charge Name</th>
                    <th>Charge GL A/C</th>
                    <th><label > from Month </label> <span id="checkmth_status"> </span></th></th>
                    <th> To Month</th>
                    <th>Total Month</th>
                    <th>Charge per Month</th>
                    <th>Charge Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    
                    <td><select name="flat_no[]"   class="form-control flat_no" onchange="getOwnerID(this.value)"><option value=>-Select Flat No-</option> </select></td>
                    <input  name="owner_id[]" class="owner_id" hidden>
                    <td><select name="bill_charge_code[]" class="form-control bill_charge_code unitChange" required>
                            <option value="">-Select Item-</option>
                            <?php
                            $selectQuery = "SELECT bill_charge_code, bill_charge_name FROM apart_bill_charge_setup";
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['bill_charge_code'] . '">' . $row['bill_charge_name'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                    <input  name="link_gl_acc_code[]" class="link_gl_acc_code" hidden>
                    <input  name="bill_charge_name[]" class="bill_charge_name" hidden>
                    <td><input type="text" class="link_gl_acc_name form-control" readonly></td>

                    <td><input type="date" name="bill_for_month[]" class="form-control" id="Fmth" onBlur="FmonthCheck()" placeholder="mm/yyyy" reruired></td>
                    <td><input type="date" name="bill_upto_month[]" class="form-control" id="upto_mth" onBlur="uptomthCheck()" placeholder="mm/yyyy" reruired></td>   
                    <!-- <td><input name="link_gl_acc_code[]" class="link_gl_acc_code form-control" required></td> -->
                    <td><input type="text" name="item_qty[]" id="item_qty1" data-srno="1" class="item_qty form-control" /></td>
                    <td><input type="text" name="unit_price_loc[]" id="unit_price_loc1" data-srno="1" class="unit_price_loc form-control" /></td>
                    <td><input type="text" name="total_price[]" id="total_price1" data-srno="1" readonly class="total_price form-control" /></td>
                    
                    <td><button type="button" name="add_row" id="add_row" class="btn btn-success btn-xl">+</button></td>
                </tr>
            </tbody>
            <tr>
                <th colspan="5" style="text-align: right">Sub Total</th>
                <th><input type="text" class="sub_total form-control" id="sub_total" style="width:100%" readonly></th>
                <th></th>
            </tr>
        </table>
        <hr>

        <table class="table bg-light table-bordered table-hover table-sm">
            <tfoot>
                <tr>
                    <th colspan="4" style="text-align:right">Net Total</th>
                    <td style="width: 250px"><input type="text" id="grand_total" class="grand_total form-control" style="width:100%" readonly></td>
                </tr>
                <tr>
                    <td></td>
                    <td><select class="form-control grand" name="to_account" onchange="toAccount()" id="to_account" required>
                            <option value="">---Select To Account ---</option>
                            <?php
                             $selectQuery = "SELECT * FROM `gl_acc_code` where category_code = 1 and postable_acc= 'Y' AND (acc_type= '1'  or acc_type='2') ORDER by acc_code";
                             $selectQueryResult =  $conn->query($selectQuery);
                             if ($selectQueryResult->num_rows) {
                                 while ($drrow = $selectQueryResult->fetch_assoc()) {
                                     echo '<option value="' . $drrow['acc_code'] . '">'  . $drrow['acc_head'] . '</option>';
                                 }
                             }
                             ?>
                        </select></td>
                    <td colspan="2"> <input type="text" class="form-control" name="particularcr" placeholder="Particular" id="particularcr"></td>
                    <td style="width: 250px"> <input type="text" id="cr_amount" class="cr_amount form-control" name="craccount" placeholder="Cr. Amount" readonly></td>
                    <td style="width: 20px"> <strong>Cr</strong></td>
                </tr>
            </tfoot>
        </table>
        <div class="col-12">
            <!-- <h3 style="color:red" id="showalert"></h3> -->
            <div style="text-align:right">
                <input type="hidden" name="acc_type" id="acc_type" value="">
                <input name="submit" type="submit" id="sub" value="Submit" class="btn btn-info" style="width:250px" />
            </div>


        </div>
    </form>
    <!-- ! alert -->
    <?php
    if (!empty($message)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Bill Receive Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    }
    if (!empty($massage_dr)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    }
    if (!empty($massage_cr)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    }
    ?>
    <!-- alert -->
    </div>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/plugins/pace.min.js"></script>
    <script src="../js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#1001000").addClass('active');
            $("#1000000").addClass('active');
            $("#1000000").addClass('is-expanded');
        });
       
    </script>
    <script>
        $(document).ready(function() {
            var count = 1;
            $(document).on('click', '#add_row', function() {
                count++;
                var html_code = '';
                html_code += '<tr id="row_id_' + count + '">';
                html_code += '<td><span id="sr_no">' + count + '</span></td>';

                html_code += '<td><select name="flat_no[]"  id="flat_no' + count + '" class="form-control flat_no"><option value="">-Select Flat No-</option><?php  $selectQuery = "SELECT * FROM `flat_info`";$selectQueryResult = $conn->query($selectQuery);if ($selectQueryResult->num_rows) { while ($row = $selectQueryResult->fetch_assoc()) { echo '<option value="' . $row['flat_no'] . '">' . $row['flat_no'] . '</option>';}} ?></select></td>';
            //   ===========================================================
                html_code += '<td><select name="bill_charge_code[]" onchange="unitChangeRow(' + count + ')" id="bill_charge_code' + count + '" class="form-control bill_charge_code"><option value="">-Select Item-</option><?php $selectQuery = "SELECT id, item_name FROM `item` where sellable_option='N'";
                                                                                                                                                                                                    $selectQueryResult = $conn->query($selectQuery);
                                                                                                                                                                                                    if ($selectQueryResult->num_rows) {
                                                                                                                                                                                                        while ($row = $selectQueryResult->fetch_assoc()) {
                                                                                                                                                                                                            echo '<option value="' . $row['id'] . '">' . $row['item_name'] . '</option>';
                                                                                                                                                                                                        }
                                                                                                                                                                                                    } ?></select></td>';
                // unit code
                html_code += '<td hidden><input name="link_gl_acc_code[]" id="link_gl_acc_code' + count + '" data-srno="' + count + '" class="link_gl_acc_code form-control"></td>';
                // unit name show
                html_code += '<td><input  id="item_code' + count + '" data-srno="' + count + '" class="item_unit form-control" readonly></td>';
                // ========================================================
                html_code += '<td><input type="month" name="bill_for_month[]" id="From_mth' + count + '" data-srno="' + count + '" class="form-control bill_for_month"/></td>';
                html_code += '<td><input type="month" name="bill_upto_month[]" id="upto_mth' + count + '" data-srno="' + count + '" class="form-control bill_upto_month"/></td>';
            
                html_code += '<td><input type="text" name="item_qty[]" id="item_qty' + count + '" data-srno="' + count + '" class="form-control item_qty"/></td>';
                html_code += '<td><input type="text" name="unit_price_loc[]" id="unit_price_loc' + count + '" data-srno="' + count + '" class="form-control unit_price_loc"/></td>';
                html_code += '<td><input type="text" name="total_price[]" id="total_price' + count + '" data-srno="' + count + '" readonly class="form-control total_price"/></td>';
                
                html_code += '<td><input type="hidden" name="link_gl_acc_code[]" id="link_gl_acc_code' + count + '" data-srno="' + count + '" readonly class="form-control link_gl_acc_code"/></td>';
                html_code += '<td><button type="button" name="remove_row" id="' + count + '" class="form-control btn btn-danger btn-xs remove_row">-</button></td>';
                html_code += '</tr>';
                $('#multi_table').append(html_code);
            });
            $(document).on('click', '.remove_row', function() {
                var row_id = $(this).attr("id");
                var total_item_amount = $('#total_price' + row_id).val();
                var final_amount = $('#total').text();
                var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
                $('#total').text(result_amount);
                $('#row_id_' + row_id).remove();
                count--;
            });

            function total(count) {
                var sub_total = 0;
                for (j = 1; j <= count; j++) {
                    var item_qty = 0;
                    var unit_price_loc = 0;
                    // var item_total = 0;
                    item_qty = $('#item_qty' + j).val();
                    if (item_qty > 0) {
                        unit_price_loc = $('#unit_price_loc' + j).val();
                        if (unit_price_loc > 0) {
                            item_total = parseFloat(item_qty) * parseFloat(unit_price_loc);
                            sub_total = parseFloat(sub_total) + parseFloat(item_total);
                            $('#total_price' + j).val(item_total.toFixed(2));
                        }
                    }
                }
                $('#sub_total').val(sub_total);
                $('#dr_amount').val(sub_total);
                discount11 = $('#discount_after_amount').val();
                if (discount11 > 0) {
                    $('#grand_total').val(discount11);
                    $('#cr_amount').val(discount11);
                } else {
                    $('#grand_total').val(sub_total);
                    $('#cr_amount').val(sub_total);
                }
            }
            $(document).on('keyup', '.unit_price_loc', function() {
                total(count);
            });            
        });

        function getFlatNo(val) {
            $.ajax({
                type: "POST",
                url: "getAdvBillReceive.php",
                data: 'by_account=' + val,
                beforeSend: function() {
                    $(".flat_no").addClass("loader");
                },
                success: function(data) {
                    $(".flat_no").html(data);
                    // $('.owner_id').find('option[value]').remove();
                    // $(".flat_no").removeClass("loader");
                    // getOwnerID();
                }
            });
        }

        function getOwnerID(val) {
            var flat_no = $('.flat_no').val();
            $.ajax({
                type: "POST",
                url: "getAdvBillReceive.php",
                data: {
                    flat_number: flat_no
                },
                dataType:"text",
                success: function(respose) {
                    $('.owner_id').val(response);
                }
            });
        }


        function toAccount() {
            var account_no = $('#to_account').val();
            $.ajax({
                type: "POST",
                url: "getAdvBillReceive.php",
                data: {
                    to_account: account_no
                },
                dataType: "text",
                success: function(response) {

                    $('#acc_type').val(response);
                    $('#showalert').text();
                    if (response == 1) {
                        $("#showalert").text('Cash PAID');
                        $("#particularcr").val('Received by Cash');
                    } else {
                        $('#showalert').text('CHQ Paid');
                        $("#particularcr").val('Receive By Cheque');
                    }

                    
                }
            });
        }


        $('.unitChange').on('change', function(e) {
            e.preventDefault;
            var bill_charge_code = this.value;
            $.ajax({
                url: "getAdvBillReceive.php",
                method: "get",
                data: {
                    bill_charge_code_soft: bill_charge_code
                },
                success: function(response) {
                    console.log(response);
                    $('.link_gl_acc_code').val(response);
                }
            });
            $.ajax({
                url: "getAdvBillReceive.php",
                method: "get",
                data: {
                    bill_charge_code_des: bill_charge_code
                },
                success: function(response) {
                    console.log(response);

                    $('.link_gl_acc_name').val(response);
                }
            });
            $.ajax({
                url: "getAdvBillReceive.php",
                method: "get",
                data: {
                    bill_charge_code_name: bill_charge_code
                },
                success: function(response) {
                    console.log(response);

                    $('.bill_charge_name').val(response);
                }
            });
        })

        function unitChangeRow(count) {
            var item = $('#bill_charge_code' + count).val();
            var item_code = $('#bill_charge_code' + count).val();
            $.ajax({
                type: "get",
                url: "getCashPurchase.php",
                data: {
                    item: item
                },
                dataType: "text",
                success: function(response) {
                    console.log(response);
                    $('#item_code' + count).val(response);
                    // $('#item_unit' + count).val(response);
                }
            });
            $.ajax({
                type: "get",
                url: "getCashPurchase.php",
                data: {
                    item_code: item_code
                },
                dataType: "text",
                success: function(response) {
                    console.log(response);
                    $('#item_unit' + count).val(response);
                }
            });
        }
        function FmonthCheck() {

        $("#loaderIcon").show();
        var Fmth = $("#Fmth").val();
        var flat_no= $(".flat_no").val();
        jQuery.ajax({
        url: "getAdvBillReceive.php",
        data :{ Fmth : Fmth,
               flatno: flat_no
        },
        
        type: "POST",
        success: function(data) {
            if (data == 5) {
            $("#checkmth_status").html("<span style='color:red'>(This month bill  Already process)</span>");
            $("#upto_mth").attr("disabled", true);
            $("#sub").attr("disabled", true);
            } else {
            $("#checkmth_status").html(data);
            $("#upto_mth").attr("disabled", false);
            $("#sub").attr("disabled", false);
            }
            $("#loaderIcon").hide();
        },
        error: function() {}
        });
        }
    </script>
    </body>

    </html>