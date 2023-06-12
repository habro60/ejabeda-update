<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
$pid= 1004000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> On Demand Purchase Report </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <div class="pull-right">
                <a id='print' title="Print" class="btn btn-danger" href="javascript:window.print()"><i class="fa fa-print"></i>Print</a>
                <a id='print' title="Print" class="btn btn-danger" target="_blank" href="voucher_view_pdf.php?recortid=<?php echo $_GET['recortid']; ?>"></i>PDF</a>
                <a id='print' title="Print" class="btn btn-danger" href="voucher_view_pdf.php?recortid=<?php echo $_GET['recortid']; ?>"></i>Excel</a>
                <a id='print' title="Print" class="btn btn-danger" href="voucher_view_word.php?recortid=<?php echo $_GET['recortid']; ?>"></i>docx</a>
                <a id='print' title="Print" class="btn btn-danger" href="voucher_view_pdf.php?recortid=<?php echo $_GET['recortid']; ?>"></i>csv</a>
            </div>
        </ul>
    </div>
    <div>
        <button class="btn btn bg-info" id="option">Option</button>
    </div>
    <!-- search option -->
    <table id="submit">
        <form method="POST">
            <tr>
                <td> As on date: <input type="date" name="startdate" id="" class="form-control" required></td>
                <td> From: <input type="date" name="enddate" id="" class="form-control" required></td>
                <td>submit:<input type="submit" name="submit" value="Submit" class="form-control btn btn-dark" id="dateSubmit"></td>
            </tr>
        </form>
    </table>
    <!-- !search option -->
    <!-- report header start -->
    <?php
    $org_logo = $_SESSION['org_logo'];
    $org_name = $_SESSION['org_name'];
    $startdate = $_SESSION['org_eod_bod_proceorg_date']; // session date
    $enddate = date('Y-m-d'); // current date
    ?>
    <div>
        <h2 style="text-align:center"><img src="../upload/<?php echo $org_logo; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $org_name; ?></h2>
    </div>
    <div>
        <h4 style="text-align:center">বোর্ডিং বাজার রিপোর্ট </h4>
        <h5 style="text-align:center">
            <?php
            if (isset($_POST['submit'])) {
                $startdate = $_POST["startdate"];
                $enddate = $conn->escape_string($_POST["enddate"]);
                echo "From Date:" . $startdate . " " . "To Date:" . $enddate;
            } else {
                echo "From Date:" . $startdate . " " . "To Date:" . $enddate;
            }
            ?>
        </h5>
    </div>

    <!-- report header end -->
    <!-- table -->
    <div class="table-responsive-lg">
        <table border="1" style="width: 100%;margin-top:10px">
            <thead>
                <tr style="text-align: center">
                    <th style="width:2%">ক্রমঃ নং</th>
                    <th style="border-right: 2px solid black">পণ্যের নাম </th>
                    <!-- </div> -->
                    <th>গড় দর (টাকা)</th>
                    <th>পরিমাণ </th>
                    <th style="border-right: 2px solid black">মূল্য</th>
                    <!-- <th>পরিমাণ </th>
                    <th>মূল্য</th> -->

                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $no = 1;
                if (isset($_POST['submit'])) {
                    $startdate = $_POST["startdate"];
                    $enddate = $conn->escape_string($_POST["enddate"]);
                    $sql = "SELECT invoice_detail.item_no, invoice_detail.order_date, invoice_detail.item_unit, SUM(invoice_detail.total_price_loc)/SUM(invoice_detail.item_qty) AS unit_price_loc, SUM(invoice_detail.item_qty) AS item_qty, SUM(invoice_detail.total_price_loc) as total_price_loc, item.item_name as item_name, item.id FROM invoice_detail JOIN item WHERE invoice_detail.item_no= item.id AND (invoice_detail.order_date BETWEEN '$startdate' AND '$enddate') GROUP BY invoice_detail.item_no ORDER BY invoice_detail.order_date, invoice_detail.item_no";
                } else {

                    $sql = "SELECT invoice_detail.item_no, invoice_detail.order_date, invoice_detail.item_unit, SUM(invoice_detail.total_price_loc)/SUM(invoice_detail.item_qty) AS unit_price_loc, SUM(invoice_detail.item_qty) AS item_qty, SUM(invoice_detail.total_price_loc) as total_price_loc, item.item_name as item_name, item.id FROM invoice_detail JOIN item WHERE invoice_detail.item_no= item.id AND (invoice_detail.order_date BETWEEN '$startdate' AND '$enddate') GROUP BY invoice_detail.item_no ORDER BY invoice_detail.order_date, invoice_detail.item_no";
                }
                $query = $conn->query($sql);
                while ($rows = $query->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $no++;
                        $total = ($total+ $rows['total_price_loc']);
                        ?></td>
                        <td style="border-right: 2px solid black;text-align: left;text-indent:5px"><?php echo $rows['item_name']; ?></td>
                        <td style="text-align: right"><?php echo $rows['unit_price_loc']; ?></td>
                        <td style="text-align: right"><?php echo $rows['item_qty']; ?> <?php echo $rows['item_unit']; ?></td>
                        <td style="text-align: right;border-right: 2px solid black"><?php echo $rows['total_price_loc']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>             
                <!-- !total -->
                <tr style="text-align: center;border-top: 2px solid black">
                    <th colspan="4" style="text-align: right">মোট টাকা</th>
                    <th style="text-align: right"><?php echo $total; ?></th>
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
        $("#1004000").addClass('active');
        $("#1000000").addClass('active');
        $("#1000000").addClass('is-expanded')
        $("#submit").hide();
        $("#option").click(function() {
            $("#submit").show();
            $("#option").hide();
        });
    });
</script>
</body>

</html>