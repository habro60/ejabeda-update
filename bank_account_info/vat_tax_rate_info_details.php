<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
require "../source/sidebar.php";
//insrt query
if (isset($_POST['subBtn'])) {
    $emp_n = $_SESSION['emp_no'];
    $org_budget_year = $_SESSION['org_budget_year']; // 2017
    $org_fin_year_st = $_SESSION['org_fin_year_st'];  // 2017-07-01
    $office_code = $_SESSION['office_code'];
    $tax_type = $_POST['tax_type'];
    $from_amount = $_POST['from_amount'];
    $to_amount = $_POST['to_amount'];
    $tax_on_rate = $_POST['tax_on_rate'];

    // if ($org_budget_year <= $fin_year && $org_fin_year_st <= $active_form) {
    $insertQuery = "INSERT INTO `tax_vat_rate_details` ( `id`,`office_code`, `tax_type`,`from_amount`,`to_amount`,`tax_on_rate`,`ss_creator`) VALUES (NULL,'$office_code','$tax_type','$from_amount','$to_amount','$tax_on_rate','$emp_n')";
    $conn->query($insertQuery);
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
    // } else {
    //     echo '<script type="text/javascript">
    //     Swal.fire({
    //         icon: "error",
    //         title: "Oops...",
    //         text: "Financial Year Less Than ' . $org_budget_year . ' And Active From Less Than Equal ' . $org_fin_year_st . ' ",
    //     })
    //     </script>';
    // }
    header("refresh:2;vat_tax_rate_info_details.php");
}
require "../source/header.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Vat Tax rate Information Details</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <a class="btn btn-info pull-right" href="../transation/vat_tax_rate_info.php">Vat Tax information</a>
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
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Item Code </label>
                    <div class="col-sm-6">
                        <select name="item_code" class="form-control select2" required>
                            <option value="">-Select Item Name -</option>
                            <?php
                            require '../database.php';
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
                <!-- from amount/ to amount -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tax on Amount</label>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" name="from_amount" class="form-control" id="" placeholder="From Amount" required>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="to_amount" class="form-control" id="" placeholder="To Amount" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tax Vat Rate </label>
                    <div class="col-sm-6">
                        <input type="number" name="tax_on_rate" class="form-control" id="" placeholder="Enter Tax Vat Rate Percent" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-primary" name="subBtn" value="submit">
                        <input type="reset" class="btn btn-danger" value="cancel">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- <?php
            if (!empty($message)) {
                echo '<script type="text/javascript">
                swal("Save Vat Tax rate Information Successfully", "Welcome ' . $_SESSION['username'] . '", "success");
                </script>';
            } else {
                echo '<script type="text/javascript">
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: "<a href>Why do I have this issue?</a>"
                  });
                </script>';
            }
            if (!empty($error)) {
                echo '<script type="text/javascript">
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            footer: "<a href>Why do I have this issue?</a>"
                          });
                </script>';
            }
            ?> -->
    <div class="row">
        <div class="col-12">
            <div class="table-responsive border-dark border-top">
                <table class="table table-hover">
                    <tr class="active">
                        <th>No</th>
                        <th>Tax Type</th>
                        <th>From Amount</th>
                        <th>To Amount</th>
                        <th>Tax Rate </th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $no = 1;
                    $sql = "SELECT * FROM tax_vat_rate_details";
                    $query = $conn->query($sql);
                    while ($rows = $query->fetch_assoc()) {
                        echo
                            "<tr>
									<td>" . $no++ . "</td>
									<td>" . $rows['tax_type'] . "</td>
									<td>" . $rows['from_amount'] . "</td>
									<td>" . $rows['to_amount'] . "</td>
									<td>" . $rows['tax_on_rate'] . "</td>
                                    <td>
                                    <a href='bank_acc_info_edit.php?recortid=" . $rows['tax_type'] . "' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span>Edit</a>
									<a href='#delete_" . $rows['tax_type'] . "' class='btn btn-danger btn-sm' data-toggle='modal'><span class='glyphicon glyphicon-trash'></span> Delete</a>
									</td>
								</tr>";
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