<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['add'])) {
    $emp_n = $_SESSION['emp_no'];
    $office_code = $_SESSION['office_code'];
    $tax_type1 = $_POST['tax_type'];
    $item_code1 = $_POST['item_code'];
    $sl_no = $_POST['sl_no'];
    $from_amount = $_POST['from_amount'];
    $to_amount = $_POST['to_amount'];
    $tax_on_rate = $_POST['tax_on_rate'];
    $ss_creator = $_SESSION['username'];
    $ss_org_no = $_SESSION['org_no'];

    $insertQuery_details = "INSERT INTO `tax_vat_rate_details` (`id`,`office_code`,`tax_type`,`item_code`,`sl_no`,`from_amount`,`to_amount`,`tax_on_rate`,`ss_creator`,`ss_org_no`) VALUES (NULL,'$office_code','$tax_type1','$item_code1','$sl_no','$from_amount','$to_amount','$tax_on_rate','$ss_creator','$ss_org_no')";
    // echo $insertQuery_details;
    // exit;
    $conn->query($insertQuery_details);
    if ($conn->affected_rows == 1) {
        $message = "Successfully";
    } else {
        $mess = "Failled";
    }
    header("refresh:1;vat_tax_rate_info.php");
}
if (isset($_POST['subBtn'])) {
    $org_budget_year = $_SESSION['org_budget_year']; // 2017
    $org_fin_year_st = $_SESSION['org_fin_year_st'];  // 2017-07-01
    $office_code = $_SESSION['office_code'];
    $tax_type = $_POST['tax_type'];
    $fin_year = $_POST['fin_year'];
    $active_form = $_POST['active_form'];
    $all_item = $_POST['all_item'];
    $item_code = $_POST['item_code'];
    $gl_acc_against_sale = $_POST['gl_acc_against_sale'];
    $gl_acc_against_pur = $_POST['gl_acc_against_pur'];
    $is_current = $_POST['is_current'];
    $ss_creator = $_SESSION['username'];
    $ss_org_no = $_SESSION['org_no'];

    if ($org_budget_year <= $fin_year && $org_fin_year_st <= $active_form) {
        $insertQuery_master = "INSERT INTO `tax_vat_rate_master` (`id`,`office_code`, `tax_type`, `fin_year`,`active_form`,`all_item`,`item_code`,gl_acc_against_sale, gl_acc_against_pur,`is_current`,`ss_creator`,`ss_org_no`) VALUES (NULL,'$office_code','$tax_type','$fin_year','$active_form','$all_item','$item_code','$gl_acc_against_sale', '$gl_acc_against_pur','$is_current','$ss_creator','$ss_org_no')"; // last id..
        // echo $insertQuery_master;
        // exit;
        $conn->query($insertQuery_master);
        if ($conn->affected_rows == 1) {
            // $last_id = $conn->insert_id;
            $message = "Successfully";
        } else {
            $mess = "Failled";
        }
        // $last_id = $conn->insert_id;
    } else {
        $mess_date = "Failled";
    }
    header("refresh:1;vat_tax_rate_info.php");
}
require "../source/top.php";
$pid= 804000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/sidebar.php";
require "../source/header.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Vat Tax rate Information </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($netAmount)) {
                echo $netAmount;
            }
            ?>
            <!-- form start  -->
            <form method="post">
                <!-- Bank Account No. -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tax and VAT Type</label>
                    <div class="col-sm-6">
                        <select name="tax_type" class="form-control select2" required>
                            <option value="">-Select Tax and VAT Type-</option>
                            <?php
                            $selectQuery = 'SELECT * FROM `code_master` where hardcode="TTYPE" AND softcode>0';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                            ?>
                            <?php
                                    echo '<option value="' . $row['softcode'] . '">' . $row['description'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- Financial  -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Financial Year</label>
                    <div class="col-sm-6">
                        <input type="text" name="fin_year" class="form-control" placeholder="Enter Financial Year" required>
                    </div>
                </div>
                <!-- Activate  -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Activate from</label>
                    <div class="col-sm-6">
                        <input type="date" name="active_form" class="form-control" placeholder="Enter Activate from" required>
                    </div>
                </div>
                <!-- all item -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">All Item</label>
                    <div class="col-sm-6">
                        <input type="radio" class="from-control" value="1" name="all_item" id="all_item"> All Item
                        <input type="radio" class="from-control" value="2" name="all_item" id="individual_item"> Individual Item
                    </div>
                </div>
                <!-- Item Code  -->
                <div id="item_code">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Item Code </label>
                        <div class="col-sm-6">
                            <select name="item_code" class="form-control select2">
                                <option value="">-Select Item Name -</option>
                                <?php
                                $selectQuery = 'SELECT * FROM `item`';
                                $selectQueryResult = $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                    while ($row = $selectQueryResult->fetch_assoc()) {
                                ?>
                                <?php
                                        echo '<option value="' . $row['id'] . '">' . $row['item_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">GL A/C against Sale</label>
                    <div class="col-sm-6">
                        <select name="gl_acc_against_sale" class="form-control select2">
                            <option value="">-GL A/C against Sale -</option>
                            <?php
                            $selectQuery = 'SELECT * FROM `gl_acc_code`';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                            ?>
                            <?php
                                    echo '<option value="' . $row['acc_code'] . '">' . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">GL A/C against Purchase</label>
                    <div class="col-sm-6">
                        <select name="gl_acc_against_pur" class="form-control select2">
                            <option value="">-GL A/C against Purchase -</option>
                            <?php
                            $selectQuery = 'SELECT * FROM `gl_acc_code`';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                            ?>
                            <?php
                                    echo '<option value="' . $row['acc_code'] . '">' . $row['acc_head'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="is_current" value="1">
                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-primary" name="subBtn" value="submit">
                        <input type="reset" class="btn btn-danger" value="cancel">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    if (!empty($message)) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    } else {
    }
    if (!empty($mess)) {
        echo '<script type="text/javascript">
          Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
    } else {
    }
    if (!empty($mess_date)) {
        echo '<script type="text/javascript">
          Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
    } else {
    }
    ?>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive border-dark border-top">
                <table class="table table-hover">
                    <tr class="active">
                        <th>Tax Type</th>
                        <th>Name </th>
                        <th>Active From </th>
                        <th>All Item </th>
                        <th>Is Current</th>
                        <th>GL A/C against Sale</th>
                        <th>GL A/C against Purchase</th>
                        <th>SL No</th>
                        <th>From Amount</th>
                        <th>To Amount</th>
                        <th>Rate</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $no = 1;
                    $sql = "select tax_vat_rate_master.tax_type as type1, tax_vat_rate_master.item_code as item, item.item_name, tax_vat_rate_master.fin_year, tax_vat_rate_master.active_form, tax_vat_rate_master.is_current, tax_vat_rate_master.gl_acc_against_sale, tax_vat_rate_master.gl_acc_against_pur, tax_vat_rate_details.sl_no, tax_vat_rate_details.from_amount, tax_vat_rate_details.to_amount, tax_vat_rate_details.tax_on_rate, code_master.description from tax_vat_rate_master LEFT outer JOIN tax_vat_rate_details ON tax_vat_rate_master.tax_type=tax_vat_rate_details.tax_type and tax_vat_rate_master.item_code=tax_vat_rate_details.item_code left outer join item on tax_vat_rate_master.item_code=item.item_name left outer join code_master on tax_vat_rate_master.tax_type=code_master.softcode and code_master.hardcode='TTYPE' order by tax_vat_rate_details.item_code, tax_vat_rate_details.sl_no";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                        echo
                            "<tr>
                                    <td>" . $rows['type1'] . "</td>
                                    <td>" . $rows['description'] . "</td>
									<td>" . $rows['active_form'] . "</td>
                                    <td>" . $rows['item'] . "</td> 
                                    <td>" . $rows['is_current'] . "</td>
                                    <td>" . $rows['gl_acc_against_sale'] . "</td>
                                    <td>" . $rows['gl_acc_against_pur'] . "</td>
                                    <td>" . $rows['sl_no'] . "</td> 
									<td>" . $rows['from_amount'] . "</td> 
									<td>" . $rows['to_amount'] . "</td> 
									<td>" . $rows['tax_on_rate'] . "</td> 
                                    <td>
										<a href='#edit_" . $rows['item'] . "' class='btn btn-success btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-edit'></span> RateSet</a>
										<a href='#delete_" . $row['id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
									</td>
                                </tr>";
                        include('vat_tax_rate_info_details_modal.php');
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<script src="../js/plugins/pace.min.js"></script>
<script src="../js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
    $(document).ready(function() {
        $("#804000").addClass('active');
        $("#800000").addClass('active');
        $("#800000").addClass('is-expanded');
    });
    $('#item_code').hide();
    $('#individual_item').click(function() {
        $('#item_code').show();
    });
    $('#all_item').click(function() {
        $('#item_code').hide();
    })
</script>
</body>

</html>