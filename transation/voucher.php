<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
$pid= 1001000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
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
                <tr>
                    <th>Purchase Voucher No</th>
                    <th style="text-align: center">Transaction Date</th>
                    <th style="text-align: center">Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> <input type="text" name="batch_no" readonly class="org_form org_12" autofocus value="<?php echo $lastRows;?>"></td>
                    <td> <input type="date" id="date" class="org_form" name="tran_date" value="<?php echo date('Y-m-d'); ?>"></td>
                    <td> <input type="text" id="date" class="org_form" id="clock" value="<?php date_default_timezone_set('Asia/Dhaka');
                                                                                            echo date("h:i:sa"); ?>" readonly></td>
                </tr>
            </tbody>
        </table>
        <table class="table bg-light table-bordered table-sm" id="multi_table">
            <thead>
                <tr class="table-active">
                    <th>No</th>
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><select name="item_no[]" class="form-control item_no" required>
                            <option value="">-Select Item-</option>
                            <?php
                            $selectQuery = 'SELECT * FROM `item`';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . $row['item_name'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                    <td><select name="item_unit[]" class="item_unit form-control" required>
                            <option value="">-Select Item-</option>
                            <?php
                            $selectQuery = 'SELECT * FROM `code_master` where hardcode="UCODE" and softcode>0';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['description'] . '">' . $row['description'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
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


        <div class="col-12">
            <div align="right">
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
        $(document).on('change', '.grand', function() {
            $('.role').val($(this).val());
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
                html_code += `<td><select name="item_no[]" class="form-control item_no" >
                                <option value="">-Select Item-</option>
                                <?php
                                $selectQuery = 'SELECT * FROM `item`';
                                $selectQueryResult = $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                    while ($row = $selectQueryResult->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['item_name'] . '</option>';
                                    }
                                }
                                ?>
                                </select></td>`;
                html_code += `<td><select name="item_unit[]" id="item_unit' + count + '" data-srno="' + count + '" class="item_unit form-control" >
                            <option value="">-Select Item-</option>
                        <?php
                        $selectQuery = 'SELECT * FROM `code_master` where hardcode="UCODE" and softcode>0';
                        $selectQueryResult = $conn->query($selectQuery);
                        if ($selectQueryResult->num_rows) {
                            while ($row = $selectQueryResult->fetch_assoc()) {
                                echo '<option value="' . $row['description'] . '">' . $row['description'] . '</option>';
                            }
                        }
                        ?>
                            </select></td>`;
                html_code += '<td><input type="text" name="item_qty[]" id="item_qty' + count + '" data-srno="' + count + '" class="form-control item_qty"/></td>';
                html_code += '<td><input type="text" name="unit_price_loc[]" id="unit_price_loc' + count + '" data-srno="' + count + '" class="form-control unit_price_loc"/></td>';
                html_code += '<td><input type="text" name="total_price[]" id="total_price' + count + '" data-srno="' + count + '" readonly class="form-control total_price"/></td>';
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

            function discount(count) {
                var discount = 0;
                discount = $('#discount').val();
                if (discount > 0) {
                    discount_before_amount = $('#sub_total').val();
                    discount_amount = (parseFloat(discount_before_amount) / 100) * parseFloat(discount);
                    $('#discount_amount').val(discount_amount);
                    $('#discount_before_amount').val(discount_before_amount);
                    discount_after_amount = discount_before_amount - discount_amount;
                    $('#discount_after_amount').val(discount_after_amount);
                    if (discount > 0) {
                        $('#grand_total').val(discount_after_amount);
                        $('#cr_amount').val(discount_after_amount);
                    } else {
                        $('#grand_total').val(sub_total);
                        $('#cr_amount').val(sub_total);
                    }
                } else {}
            }
            $(document).on('keyup', '.discount', function() {
                discount(count);
            });

            function vat(count) {
                var vat = 0;
                vat = $('#vat').val();
                discount_vat = $('#discount').val();
                if (vat > 0) {
                    if (discount_vat > 0) {
                        vat_before_amount = $('#discount_after_amount').val();
                    } else {
                        vat_before_amount = $('#sub_total').val();
                    }
                    vat_amount = (parseInt(vat_before_amount) / 100) * parseInt(vat);
                    $('#vat_amount').val(vat_amount);
                    $('#vat_before_amount').val(vat_before_amount);
                    vat_after_amount = (vat_before_amount - (-vat_amount));
                    $('#vat_after_amount').val(vat_after_amount);
                    if (vat_after_amount > 0) {
                        $('#grand_total').val(vat_after_amount);
                        $('#cr_amount').val(vat_after_amount);
                    } else {
                        vat_before_amount = $('#sub_total').val();
                        $('#grand_total').val(vat_before_amount);
                        $('#cr_amount').val(vat_before_amount);
                    }
                } else {}
            }
            $(document).on('keyup', '.vat', function() {
                vat(count);
            });

            function tax(count) {
                var tax = 0;
                var vat_after_amount = 0;
                tax = $('#tax').val();
                discount_tax = $('#discount').val();
                if (tax > 0) {
                    if (discount_tax > 0) {
                        tax_before_amount = $('#discount_after_amount').val();
                    } else {
                        tax_before_amount = $('#sub_total').val();
                    }
                    tax_amount = (parseFloat(tax_before_amount) / 100) * parseFloat(tax);
                    $('#tax_amount').val(tax_amount);
                    // tax_before_amount = $('#discount_after_amount').val();
                    $('#tax_before_amount').val(tax_before_amount);
                    if (vat_after_amount == 0) {
                        ttt = $('#sub_total').val();
                        discountamount = $('#discount_amount').val();
                        discounvat = $('#vat_amount').val();
                        total = (ttt - discountamount - (-discounvat) - (-tax_amount));
                        $('#tax_after_amount').val(total);
                    } else {
                        tax_after_amount = (vat_after_amount - (-tax_amount));
                        $('#tax_after_amount').val(tax_after_amount);
                    }

                    if (tax_after_amount > 0) {
                        $('#grand_total').val(tax_after_amount);
                        $('#cr_amount').val(tax_after_amount);
                    } else {
                        ttt = $('#sub_total').val();
                        discountamount = $('#discount_amount').val();
                        discounvat = $('#vat_amount').val();
                        total = (ttt - discountamount - (-discounvat) - (-tax_amount));
                        $('#grand_total').val(total);
                        $('#cr_amount').val(total);
                    }
                } else {

                }
            }
            $(document).on('keyup', '.tax', function() {
                tax(count);
            });
        });
    </script>
    </body>

    </html>