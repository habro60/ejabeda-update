<?php
require "../auth/auth.php";
require "../database.php";
$disrate = 0;
$vatrate = 0;
$taxrate = 0;
if (isset($_POST["submit"])) {
   
    for ($count = 0; $count < count($_POST["particular"]); $count++) {
        
        
            $tran_date = $_POST['tran_date'][$count];
            $to_account = $_POST['to_account'][$count];
            
            $vaucher_type = "CR";
            $cr_tran_amt= $_POST['tran_amt'][$count];
            $dr_tran_amt= '0';
            $tran_mode = $tran_mode='CASR';;  
            $particular  = $_POST['particular'][$count];
            $office_code = $_SESSION['office_code'];
            $owner_rec_id = $_SESSION['link_id'];
            $ss_creator = $_SESSION['username'];
            $ss_org_no = $_SESSION['org_no'];
        
        $query = "INSERT INTO personal_ledger (office_code,owner_rec_id,`tran_date`,`gl_acc_code`,`tran_mode`,`vaucher_type`,`dr_amt_loc`,`cr_amt_loc`,`dr_amt_fc`,`cr_amt_fc`,description,`bank_name`,`branch_name`,`cheque_no`,`cheque_date`,curr_code,exch_rate,posted,verified_by_1,verified_date_1,ss_creator,ss_creator_on,ss_org_no) VALUES ('$office_code', '$owner_rec_id','$tran_date','$to_account','$tran_mode','$vaucher_type','$dr_tran_amt','$cr_tran_amt','0','0', '$particular','null','null','null','9999-09-09','BDT','0','1','1',now(),'$ss_creator',now(),'$ss_org_no')";
        // echo $query;
        // exit;
        $conn->query($query);
        if ($conn->affected_rows == 1) {
            $message = "Save owner Successfully!";
          } else {
            $mess = "Failled!";
          }
        
          $sql = "SELECT * FROM `personal_account` where `owner_rec_id`=$owner_rec_id and category_code='1' ORDER by id";
          $sqlresult = mysqli_query($conn, $sql);
          $rows = mysqli_fetch_assoc($sqlresult);
          $by_account=$rows['id'];
          $tran_mode='CASR';
          $vaucher_type = "DR";
          

        $conquery = "INSERT INTO personal_ledger (office_code,owner_rec_id,`tran_date`,`gl_acc_code`,`tran_mode`,`vaucher_type`,`dr_amt_loc`,`cr_amt_loc`,`dr_amt_fc`,`cr_amt_fc`,description,`bank_name`,`branch_name`,`cheque_no`,`cheque_date`,curr_code,exch_rate,posted,verified_by_1,verified_date_1,ss_creator,ss_creator_on,ss_org_no) VALUES ('$office_code', '$owner_rec_id','$tran_date','$by_account','$tran_mode','$vaucher_type','$cr_tran_amt','$dr_tran_amt','0','0', '$particular','null','null','null','9999-09-09','BDT','0','1','1',now(),'$ss_creator',now(),'$ss_org_no')";
        // echo $conquery;
        // exit;
        $conn->query($conquery);
       
        if ($conn->affected_rows == 1) {
            $message = "Save owner Successfully!";
          } else {
            $mess = "Failled!";
          }
        
    }
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=personal_cash_income.php\">";
}
require "../source/top.php";
$pid = 1502000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";

$querys = "insert into bach_no (username) values ('$_SESSION[username]')";
$returns = mysqli_query($conn, $querys);
$lastRows = $conn->insert_id;
?>

<main class="app-content">
    <form action="" method="post">
        <table class="table bg-light table-bordered table-sm">
            <thead>
                <td>
                    <th>Credit Voucher to Cash A/C</th>
                    <th style="text-align:right;"><a href="index.php" class="btn btn-info btn-sm">Back</a></th>
                </tr>
            </thead>
            
        </table>
        <table class="table bg-light table-bordered table-sm" id="multi_table">
            <thead>
                <tr class="table-active">
                    <th>SL#</th>
                    <th>Account</th>
                    <th>Date</th>
                    <th>Particulars</th>
                    <th>Amount.</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                    
                    <select name="to_account[]" class="form-control" required>
                      <option value="">-Select Account-</option>
                      <?php
                      $owner_rec_id = $_SESSION['link_id'];
                      $selectQuery = "SELECT * from personal_account where `owner_rec_id`='$owner_rec_id' and (category_code='2' or category_code='3') order by id";
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($rows = $selectQueryResult->fetch_assoc()) {
                      ?>
                      <?php
                          echo '<option value="' . $rows['id'] . '">' . $rows['acc_head'] . '</option>';
                        }
                      }
                      ?>
                    </select>
                        </td>
                    
                    <td><input type="date" name="tran_date[]" class="form-control" value="<?php echo date('Y-m-d'); ?>"/></td>
                    <td><input type="text" name="particular[]" class="form-control" /></td>
                    <td><input type="text" name="tran_amt[]" id="trn_amt" class="form-control" /></td>
                    
                   
                    
                    <!-- <td style="width: 200px"><input type="hidden" name="" id="acBalance" class="form-control" readonly></td>   -->
                    <td><button type="button" name="add_row" id="add_row" class="btn btn-success btn-xl">+</button></td>
                </tr>
            </tbody>
            <tr>
                <th colspan="4" style="text-align: right">Sub Total</th>
                <th><input type="text" class="sub_total form-control" id="sub_total" style="width:100%" readonly></th>
                <th></th>
            </tr>
        </table>
        <hr>

        
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
                "Cash Entry Successfully!!",
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
                html_code += `<td> <select class="form-control select2" name="to_account[]" onchange="to_account()" id="to_account"  required>
                                <option value="">---Select---</option>
                                <?php
                                $selectQuery = "SELECT * from personal_account where `owner_rec_id`='$owner_rec_id' and (category_code='2' or category_code='3') order by id";
                                $selectQueryResult =  $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                    while ($drrow = $selectQueryResult->fetch_assoc()) {
                                        echo '<option value="' . $drrow['id'] . '">'  . $drrow['acc_head'] . '</option>';
                                    }
                                }
                                ?>
                            </select></td>`;
                html_code += '<td><input type="date" name="tran_date[]" class="form-control" value="<?php echo date('Y-m-d'); ?>"/></td>';
            
                html_code += '<td><input type="text" name="particular[]" class="form-control" /></td>';
                html_code += '<td><input type="text" name="tran_amt[]" class="form-control" /></td>';                            
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
            
        });
       
       

        function ConAccBal() {
        var con_account = $('#con_account').val();
        var con_account = $('#tran_amt').val();
        $.ajax({
            url: 'getBalanceCheck.php',
            method: 'POST',
            dataType: 'text',
            data: {
                con_gl_acc_code: con_account
            },
            success: function(response) {
                $("#acBalance").val(response);
               
            }
        });
    }
       
    </script>
    </body>

    </html>