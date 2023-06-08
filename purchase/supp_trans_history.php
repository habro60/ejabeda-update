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
    $sql2 = "SELECT invoice_detail.gl_acc_code,  invoice_detail.item_no, item.id, supp_info.id, supp_info.supp_name, supp_info.gl_acc_code FROM invoice_detail JOIN item JOIN supp_info WHERE item.id= invoice_detail.item_no AND supp_info.gl_acc_code = invoice_detail.gl_acc_code";
} else {
    // $sql2 = "SELECT invoice_detail.gl_acc_code,  invoice_detail.item_no, item.id, supp_info.id, supp_info.supp_name, supp_info.gl_acc_code FROM invoice_detail JOIN item JOIN supp_info WHERE item.id= invoice_detail.item_no AND supp_info.gl_acc_code = invoice_detail.gl_acc_code";
    $sql2 = "SELECT invoice_detail.order_no, invoice_detail.gl_acc_code, invoice_detail.order_date, invoice_detail.item_no, invoice_detail.item_qty, invoice_detail.item_unit, invoice_detail.unit_price_loc, invoice_detail.total_price_loc, item.item_name,item.id, supp_info.id, supp_info.supp_name, supp_info.gl_acc_code FROM invoice_detail JOIN item JOIN supp_info WHERE item.id= invoice_detail.item_no AND supp_info.gl_acc_code = invoice_detail.gl_acc_code AND supp_info.id='$supp_id' ORDER BY invoice_detail.order_date";
    // $sql2 = "SELECT invoice_detail.order_no, invoice_detail.gl_acc_code, invoice_detail.order_date, invoice_detail.item_no, invoice_detail.item_qty, invoice_detail.item_unit, invoice_detail.unit_price_loc, invoice_detail.total_price_loc, item.item_name,item.id, supp_info.id, supp_info.supp_name, supp_info.gl_acc_code FROM invoice_detail JOIN item JOIN supp_info WHERE item.id= invoice_detail.item_no AND supp_info.gl_acc_code = invoice_detail.gl_acc_code AND supp_info.id='$supp_id' ORDER BY invoice_detail.order_date";
}
$query2 = $conn->query($sql2);
$row = $query2->fetch_assoc();
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Supplied Transcation History </h1>
        </div>
    </div>
    <!-- search option -->

    <?php if (empty($supp_id)) {
    ?>
        <table id="submit">
            <form method="POST">
                <tr>
                    <td>Supplier : <select class="form-control grand" name="gl_acc_code">
                            <option value="">--- Select Supplier ---</option>
                            <?php
                            $selectQuery = "SELECT * FROM `gl_acc_code` where acc_type=6 and postable_acc= 'Y' ORDER by acc_code";
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
    } elseif (!empty($supp_id)) { ?>
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
                                                        if (empty($supp_id)) {
                                                            echo "All Supplier";
                                                        } else {
                                                            echo $row['supp_name'];
                                                        } ?></h3>
    </div>
    <!-- report header end -->
    <!-- search option -->
    <div class="table-responsive-lg">
        <table border="1" style="width: 100%;margin-top:10px">
            <thead>
                <tr style="text-align: center">
                    <th style="width:2%">ক্রমঃ নং</th>
                    <th>অর্ডার তারিখ</th>
                    <th>অর্ডার নং</th>
                    <th>হিসাবের নাম </th>
                    <th>পণ্যের নাম </th>
                    <th>পরিমাণ </th>
                    <th>একক দর</th>
                    <th>মূল্য</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $d = 0;
                $no = 1;

                if (isset($_POST['submit'])) {
                    $startdate = $_POST['startdate'];
                    $enddate = $conn->escape_string($_POST['enddate']);
                    $gl_acc_code = $conn->escape_string($_POST['gl_acc_code']);
                    $sql = "SELECT invoice_detail.order_no, invoice_detail.gl_acc_code, invoice_detail.order_date, invoice_detail.item_no, invoice_detail.item_qty, invoice_detail.item_unit, invoice_detail.unit_price_loc, invoice_detail.total_price_loc, item.item_name,item.id, supp_info.id, supp_info.supp_name, supp_info.gl_acc_code FROM invoice_detail JOIN item JOIN supp_info WHERE item.id= invoice_detail.item_no AND supp_info.gl_acc_code = invoice_detail.gl_acc_code  AND invoice_detail.gl_acc_code='$gl_acc_code'  AND (invoice_detail.order_date BETWEEN '$startdate' AND '$enddate') ORDER BY invoice_detail.order_date";
                } elseif (!empty($supp_id)) {
                    if (isset($_POST['induvidul'])) {

                        $start = $_POST['start'];
                        $end = $conn->escape_string($_POST['end']);
                        $sql = "SELECT invoice_detail.order_no, invoice_detail.gl_acc_code, invoice_detail.order_date, invoice_detail.item_no, invoice_detail.item_qty, invoice_detail.item_unit, invoice_detail.unit_price_loc, invoice_detail.total_price_loc, item.item_name,item.id, supp_info.id, supp_info.supp_name, supp_info.gl_acc_code FROM invoice_detail JOIN item JOIN supp_info WHERE item.id= invoice_detail.item_no AND supp_info.gl_acc_code = invoice_detail.gl_acc_code AND supp_info.id='$supp_id' AND (invoice_detail.order_date BETWEEN '$start' AND '$end') ORDER BY invoice_detail.order_date";
                    } else {
                        $sql = "SELECT invoice_detail.order_no, invoice_detail.gl_acc_code, invoice_detail.order_date, invoice_detail.item_no, invoice_detail.item_qty, invoice_detail.item_unit, invoice_detail.unit_price_loc, invoice_detail.total_price_loc, item.item_name,item.id, supp_info.id, supp_info.supp_name, supp_info.gl_acc_code FROM invoice_detail JOIN item JOIN supp_info WHERE item.id= invoice_detail.item_no AND supp_info.gl_acc_code = invoice_detail.gl_acc_code AND supp_info.id='$supp_id' ORDER BY invoice_detail.order_date";
                    }
                } else {
                    $sql = "SELECT invoice_detail.order_no, invoice_detail.gl_acc_code, invoice_detail.order_date, invoice_detail.item_no, invoice_detail.item_qty, invoice_detail.item_unit, invoice_detail.unit_price_loc, invoice_detail.total_price_loc, item.item_name,item.id, supp_info.id, supp_info.supp_name, supp_info.gl_acc_code FROM invoice_detail JOIN item JOIN supp_info WHERE item.id= invoice_detail.item_no AND supp_info.gl_acc_code = invoice_detail.gl_acc_code  ORDER BY invoice_detail.order_date";
                }


                $query = $conn->query($sql);
                while ($rows = $query->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <?php
                        $d = ($d + $rows['total_price_loc']);
                        ?>
                        <td style="text-align: center"><?php echo $rows['order_date']; ?> </td>
                        <td style="text-align: right"><?php echo $rows['order_no']; ?></td>
                        <td style="text-align: center"><?php echo $rows['supp_name']; ?></td>
                        <td style="text-align: left"><?php echo $rows['item_name']; ?></td>
                        <td style="text-align: center"><?php echo $rows['item_qty']; ?> <?php echo $rows['item_unit']; ?></td>
                        <td style="text-align: right"><?php echo $rows['unit_price_loc']; ?></td>
                        <td style="text-align: right;text-indent:5px"><?php echo $rows['total_price_loc']; ?></td>
                    </tr>
                <?php } ?>
            <tfoot>
                <tr>
                    <th style="text-align:right" colspan="7">Total</th>
                    <th style="text-align:right"><?php echo $d; ?></th>
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
        $("#1002000").addClass('active');
        $("#1000000").addClass('active');
        $("#1000000").addClass('is-expanded');
    });
</script>
</body>

</html>