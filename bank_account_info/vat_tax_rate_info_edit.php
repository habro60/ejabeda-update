<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
require "../source/sidebar.php";
//insrt query

if (isset($_POST['add'])) {
    $emp_n = $_SESSION['emp_no'];
    $office_code = $_SESSION['office_code'];
    $tax_type1 = $_POST['tax_type'];
    $item_code1 = $_POST['item_code'];
    $sl_no = $_POST['sl_no'];
    $from_amount = $_POST['from_amount'];
    $to_amount = $_POST['to_amount'];
    $tax_on_rate = $_POST['tax_on_rate'];

    $insertQuery_details = "INSERT INTO `tax_vat_rate_details` (`id`,`office_code`,`tax_type`,`item_code`,`sl_no`,`from_amount`,`to_amount`,`tax_on_rate`,`ss_creator`) VALUES (NULL,'$office_code','$tax_type1','$item_code1','$sl_no','$from_amount','$to_amount','$tax_on_rate','$emp_n')";
    // echo $insertQuery_details;
    // exit;
    $conn->query($insertQuery_details);
    if ($conn->affected_rows == 1) {
        echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    } else {
        echo '<script type="text/javascript">
            Swal.fire(
                "Failled!!",
                "Sorry ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
    }
    header("refresh:2;vat_tax_rate_info.php");
}
if (isset($_POST['subBtn'])) {
    $emp_n = $_SESSION['emp_no'];
    $org_budget_year = $_SESSION['org_budget_year']; // 2017
    $org_fin_year_st = $_SESSION['org_fin_year_st'];  // 2017-07-01
    $office_code = $_SESSION['office_code'];
    $tax_type = $_POST['tax_type'];
    $fin_year = $_POST['fin_year'];
    $active_form = $_POST['active_form'];
    $item_code = $_POST['item_code'];
    $is_current = $_POST['is_current'];

    if ($org_budget_year <= $fin_year && $org_fin_year_st <= $active_form) {
        $insertQuery_master = "INSERT INTO `tax_vat_rate_master` (`id`,`office_code`, `tax_type`, `fin_year`,`active_form`,`item_code`,`is_current`,`ss_creator`) VALUES (NULL,'$office_code','$tax_type','$fin_year','$active_form','$item_code','$is_current','$emp_n')"; // last id..
        $conn->query($insertQuery_master);
        if ($conn->affected_rows == 1) {
            $last_id = $conn->insert_id;
            echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '' . $last_id . '",
                "success"
              )
            </script>';
        } else {
            echo '<script type="text/javascript">
            Swal.fire(
                "Failled!!",
                "Sorry ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
        }
        $last_id = $conn->insert_id;
    } else {
        echo '<script type="text/javascript">
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Financial Year Less Than ' . $org_budget_year . ' And Active From Less Than Equal ' . $org_fin_year_st . ' ",
        })
        </script>';
    }
    header("refresh:2;vat_tax_rate_info.php");
}
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
                            require '../database.php';
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
                <!-- Bank Code  -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Financial Year</label>
                    <div class="col-sm-6">
                        <input type="text" name="fin_year" class="form-control" placeholder="Enter Financial Year" required>
                    </div>
                </div>
                <!-- Branch name  -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Activate from</label>
                    <div class="col-sm-6">
                        <input type="date" name="active_form" class="form-control" placeholder="Enter Activate from" required>
                    </div>
                </div>
                <!-- Bank Address  -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Item Code </label>
                    <div class="col-sm-6">
                        <select name="item_code" class="form-control select2" required>
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
    <div class="row">
        <div class="col-12">
            <div class="table-responsive border-dark border-top">
                <table class="table table-hover">
                    <tr class="active">
                        <th>No</th>
                        <th>Tax Type</th>
                        <th>Financial Year</th>
                        <th>Active From </th>
                        <th>Item Code</th>
                        <th>Is Current</th>
                        <th>SL No</th>
                        <th>From Amount</th>
                        <th>To Amount</th>
                        <th>Rate</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $no = 1;
                    // $sql = "SELECT tax_vat_rate_master.tax_type as type1 ,tax_vat_rate_master.fin_year,tax_vat_rate_master.active_form,tax_vat_rate_master.item_code as item, tax_vat_rate_master.is_current,tax_vat_rate_details.from_amount,tax_vat_rate_details.to_amount,tax_vat_rate_details.tax_on_rate,tax_vat_rate_details.tax_type,tax_vat_rate_details.sl_no,tax_vat_rate_details.item_code FROM tax_vat_rate_master LEFT outer JOIN tax_vat_rate_details ON tax_vat_rate_master.tax_type = tax_vat_rate_details.tax_type AND tax_vat_rate_master.item_code = tax_vat_rate_details.item_code order by tax_vat_rate_details.item_code";
                    $sql = "select tax_vat_rate_master.tax_type as type1, tax_vat_rate_master.item_code as item, item.item_name, tax_vat_rate_master.fin_year, tax_vat_rate_master.active_form, tax_vat_rate_master.is_current, tax_vat_rate_details.sl_no, tax_vat_rate_details.from_amount, tax_vat_rate_details.to_amount, tax_vat_rate_details.tax_on_rate from tax_vat_rate_master LEFT outer JOIN tax_vat_rate_details ON tax_vat_rate_master.tax_type=tax_vat_rate_details.tax_type and tax_vat_rate_master.item_code=tax_vat_rate_details.item_code left outer join item on tax_vat_rate_master.item_code=item.item_name order by tax_vat_rate_details.item_code, tax_vat_rate_details.sl_no";
                    // $sql = "SELECT * FROM tax_vat_rate_master";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                        echo
                            "<tr>
									<td>" . $no++ . "</td>
									<td>" . $rows['type1'] . "</td>
									<td>" . $rows['fin_year'] . "</td>
									<td>" . $rows['active_form'] . "</td>
                                    <td>" . $rows['item'] . "</td> 
									<td>" . $rows['is_current'] . "</td>
                                    <td>" . $rows['sl_no'] . "</td> 
									<td>" . $rows['from_amount'] . "</td> 
									<td>" . $rows['to_amount'] . "</td> 
									<td>" . $rows['tax_on_rate'] . "</td> 
                                    <td>
										<a href='#edit_" . $rows['item'] . "' class='btn btn-success btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-edit'></span> Details</a>
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
        $("#accinfo").addClass('active');
        $("#gl_acc").addClass('active');
        $("#accinfo").addClass('is-expanded');
    });
</script>
<?php
$conn->close();
?>
</body>

</html>