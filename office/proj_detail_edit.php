<?php
require "../auth/auth.php";
require "../database.php";

$id = intval($_GET['id']);
if (isset($_POST['submit'])) {

    $ss_modifier = $_SESSION['username'];
    $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    for ($count = 0; $count < count($_POST['id']); ++$count) {
        $id =  $conn->escape_string($_POST['id'][$count]);
        $item_no = $conn->escape_string($_POST['item_no'][$count]);
        $item_unit = $conn->escape_string($_POST['item_unit'][$count]);
        $item_qty = $conn->escape_string($_POST['item_qty'][$count]);
        $unit_price = $conn->escape_string($_POST['unit_price'][$count]);
        $tot_amt_loc = $conn->escape_string($_POST['tot_amt_loc'][$count]);
        if ($id > 0) {
            $insertQuery = "UPDATE `project_detail` SET `id`='$id', `item_no`='$item_no', `item_unit`='$item_unit', `item_qty`='$item_qty', `unit_price`='$unit_price',`tot_amt_loc`='$tot_amt_loc', `ss_modifire`='$ss_modifier', `ss_modified_on`='$ss_modified_on',`ss_org_no`='$ss_org_no' where `id`='$id'";
            $conn->query($insertQuery);
            if ($conn->affected_rows == TRUE) {
                $message = "Successfully";
            } else {
                $mess = "Failled";
            }
        }
    }
    header('refresh:1;proj_detail.php');
}
require "../source/top.php";
require "../source/sidebar.php";
require "../source/header.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}

?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Edit Project Detail Information </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fome fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- form start  -->
            <form method="post">
                <?php if (isset($_GET['id'])) {
                    $id = ($_GET['id']);
                }   ?>
                <table class="table bg-light table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Project Name</th>
                            <th>Start Date</th>
                            <th>Completion Date</th>
                            <th hidden>Phase Value</th>
                            <th>Item</th>
                            <th>Unit</th>
                            <th>quantity</th>
                            <th>Unit Price</th>
                            <th>Expected Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $disflag = '0';
                        $sql = "select project_detail.id, project_detail.office_code, project_detail.proj_phase_date, project_detail.phase_complete_date, project_detail.proj_phase_value, project_detail.sl_no, project_detail.item_no, project_detail.item_unit, project_detail.item_qty, project_detail.unit_price, project_detail.tot_amt_loc, office_info.office_name, item.item_name from project_detail, office_info, item where  project_detail.item_no=item.id and project_detail.id= '$id' and project_detail.office_code=office_info.office_code";
                        $query = mysqli_query($conn, $sql);
                        // $data = $query->fetch_assoc();
                        
                        while ($rows = $query->fetch_assoc()) {
                        ?>
                            <tr>
                                <td style="width: 70px;">
                                    <input type="text" name="id[]" class="form-control" value="<?php echo $rows['id']; ?>" style="width: 100%" readonly>
                                </td>

                                <td style="width: 70px;">
                                    <input type="text" name="Office_name[]" class="form-control" value="<?php echo $rows['office_name']; ?>" style="width: 100%" readonly>
                                </td>
                                <td style="width: 80px">
                                    <input type="text" name="proj_phase_date[]" class="form-control" value="<?php echo $rows['proj_phase_date']; ?>" title="<?php echo $rows['proj_phase_date']; ?>" readonly>
                                </td>
                                <td style="width: 80px">
                                    <input type="text" name="phase_complete_date[]" class="form-control" value="<?php echo $rows['phase_complete_date']; ?>" title="<?php echo $rows['phase_complete_date']; ?>" readonly>
                                </td>
                                <td hidden>
                                    <input type="text" name="proj_phase_value[]" class="form-control" value="<?php echo $rows['proj_phase_value']; ?>" style="width: 100%" readonly>


                                </td>
                                <td style="width: 480px">
                                    <select name="item_no[]" class="form-control">

                                        <option value="">- Select item -</option>
                                        <?php
                                        $selectQuery = 'SELECT id, item_name FROM `item`';
                                        $selectQueryResult = $conn->query($selectQuery);
                                        if ($selectQueryResult->num_rows) {
                                            while ($row_item = $selectQueryResult->fetch_assoc()) {
                                        ?>
                                                <option value="<?php echo $row_item['id']; ?>" <?php if ($row_item['id'] == $rows['item_no']) { ?> selected="selected" <?php } ?>><?php echo $row_item['item_name']; ?></option>

                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td style="width: 80px">
                                    <select name="item_unit[]" class="form-control">

                                        <option value="">- Select unit -</option>
                                        <?php
                                        $selectQuery = "SELECT softcode, hardcode,description  FROM `code_master` where hardcode='UCODE' and softcode !='0'";
                                        $selectQueryResult = $conn->query($selectQuery);
                                        if ($selectQueryResult->num_rows) {
                                            while ($row_unit = $selectQueryResult->fetch_assoc()) {
                                        ?>
                                                <option value="<?php echo $row_unit['softcode']; ?>" <?php if ($row_unit['softcode'] == $rows['item_unit']) { ?> selected="selected" <?php } ?>><?php echo $row_unit['description']; ?></option>

                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td style="width: 70px">
                                    <input type="text" name="item_qty[]" class="form-control" value="<?php echo $rows['item_qty']; ?>">
                                </td>
                                <td style="width: 95px">
                                    <input type="text" name="unit_price[]" class="form-control" value="<?php echo $rows['unit_price']; ?>">
                                </td>
                                <td style="width: 120px">
                                    <input type="text" name="tot_amt_loc[]" class="form-control" value="<?php echo $rows['tot_amt_loc']; ?>">
                                </td>

                            </tr>
                        <?php

                        }
                        ?>
                    </tbody>
                </table>
                <input name="submit" type="submit" id="submit" value="submit" class="btn btn-info pull-right submit" />
            </form>
        </div>
        <?php
        if (!empty($message)) {
            echo '<script type="text/javascript">
            Swal.fire(
                "Update Successfully!!",
                "Welcome ' . $_SESSION['username'] . '' . $last_id . '",
                "success"
              )
            </script>';
        } else {
        }
        if (!empty($mess)) {
            echo '<script type="text/javascript">
                Swal.fire(
                    "Failled!!",
                    "Sorry ' . $_SESSION['username'] . '",
                    "success"
                  )
                </script>';
        } else {
        }
        if (!empty($massage_failled_date)) {
            echo '<script type="text/javascript">
            Swal.fire(
                "Failled Date!!",
                "Sorry ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
        } else {
        }
        ?>
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
        $('.select2').select2()
    })
    $(document).ready(function() {
        $("#107000").addClass('active');
        $("#100000").addClass('active');
        $("#100000").addClass('is-expanded');

    });
</script>
</body>

</html>