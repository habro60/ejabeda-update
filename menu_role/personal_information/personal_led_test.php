<?php
require "../auth/auth.php";
require "../database.php";
$disrate = 0;
$vatrate = 0;
$taxrate = 0;
if (isset($_POST["submit"])) {
        
    for ($count = 0; $count < count($_POST["particular"]); $count++) {
        if (empty($_POST["craccount"][$count])) {
            $vaucher_type = "DR";
            $draccount= $_POST['draccount'][$count];
            $craccount='0';
        } else {
            $vaucher_type = "CR";
            $craccount = $_POST['craccount'][$count];
            $draccount='0';
        }
        
            $tran_date = $_POST['tran_date'][$count];
            $gl_acc_code = $_POST['gl_acc_code'][$count];
            $tran_mode = $_POST['tran_mode'][$count];  
            $particular  = $_POST['particular'][$count];
            $office_code = $_SESSION['office_code'];
            $owner_id = $_SESSION['link_id'];
            $ss_creator = $_SESSION['username'];
            $ss_org_no = $_SESSION['org_no'];
        
        $query = "INSERT INTO personal_ledger (office_code,owner_id,`tran_date`,`gl_acc_code`,`tran_mode`,`vaucher_type`,`dr_amt_loc`,`cr_amt_loc`,`dr_amt_fc`,`cr_amt_fc`,description,`bank_name`,`branch_name`,`cheque_no`,`cheque_date`,curr_code,exch_rate,ss_creator,ss_creator_on,ss_org_no) VALUES ('$office_code', '$owner_id','$tran_date','$gl_acc_code','$tran_mode','$vaucher_type','$draccount','$craccount','0','0', '$particular','null','null','null','9999-09-09','BDT','0','$ss_creator',now(),'$ss_org_no')";
        // echo $query;
        // exit;

        $statement = $connect->prepare($query);
        if ($statement->execute($data)) {
            $message = "Save Successfully!";
        } else {
            $mess = "Failled!";
        }
    }
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=personal_led.php\">";
}
require "../source/top.php";
$pid = 1318000;
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
                    <th>Voucher Entry</th>
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
                    <th>Debit Amt.</th>
                    <th>Credit Amt.</th>
                    <th>Tran.Mode</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><select class="form-control select2" name="gl_acc_code[]">
                                <option value="">---Select---</option>
                                
                                <?php
                                $owner_id = $_SESSION['link_id'];
                                $selectQuery = "SELECT * FROM `personal_account` where `owner_id`=$owner_id ORDER by id";
                                $selectQueryResult =  $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                    while ($drrow = $selectQueryResult->fetch_assoc()) {
                                        echo '<option value="' . $drrow['id'] . '">'  . $drrow['acc_head'] . '</option>';
                                    }
                                }
                                ?>
                            </select></td>
                    <td><input type="date" name="tran_date[]" class="form-control" value="<?php echo date('Y-m-d'); ?>"/></td>
                    <td><input type="text" name="particular[]" class="form-control" /></td>
                    <td><input type="text" name="draccount[]" class="form-control" /></td>
                    <td><input type="text" name="craccount[]" class="form-control"  /></td>
                    <td><select class="form-control select2" name="con_gl_acc_code[]">
                                <option value="">---Select---</option>
                                
                                <?php
                                $owner_id = $_SESSION['link_id'];
                                $selectQuery = "SELECT * FROM `personal_account` where `owner_id`=$owner_id and (category_code='1' orcategory_code='2')  ORDER by id";
                                $selectQueryResult =  $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                    while ($drrow = $selectQueryResult->fetch_assoc()) {
                                        echo '<option value="' . $drrow['id'] . '">'  . $drrow['acc_head'] . '</option>';
                                    }
                                }
                                ?>
                            </select></td>
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
                "Purchase Successfully!!",
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
                html_code += `<td> <select class="form-control select2" name="gl_acc_code[]">
                                <option value="">---Select---</option>
                                <?php
                                $selectQuery = "SELECT * FROM `personal_account`  ORDER by id";
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
                html_code += '<td><input type="text" name="draccount[]" class="form-control" /></td>';
                html_code += '<td><input type="text" name="craccount[]" class="form-control"  /></td>';
                html_code += `<td><select class="form-control select2" name="con_gl_acc_code[]">
                                <option value="">---Select---</option>
                                
                                <?php
                                $owner_id = $_SESSION['link_id'];
                                $selectQuery = "SELECT * FROM `personal_account` where `owner_id`=$owner_id and (category_code='1' orcategory_code='2')  ORDER by id";
                                $selectQueryResult =  $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                    while ($drrow = $selectQueryResult->fetch_assoc()) {
                                        echo '<option value="' . $drrow['id'] . '">'  . $drrow['acc_head'] . '</option>';
                                    }
                                }
                                ?>
                            </select></td>`;
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
       
        
       
    </script>
    </body>

    </html>