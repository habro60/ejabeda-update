<?php
require "../auth/auth.php";
require "../database.php";
$upload_dir = '../upload/';
if (isset($_POST['submit'])) {
    $office_code = $_SESSION['office_code'];
    $item_name = $conn->escape_string($_POST['name']);
    $parent_id = $conn->escape_string($_POST['parent_id']);
    $item_category = $conn->escape_string($_POST['item_category']);
    $item_code = $conn->escape_string($_POST['item_code']);
    $item_level = $conn->escape_string($_POST['item_level']);
    $ss_creator = $_SESSION['username'];
    $ss_org_no = $_SESSION['org_no'];

    $insertQuery = "INSERT INTO `item`(`id`,`office_code`,`item_code`,`item_name`, `parent_id`,`item_level`, `item_category`,`ss_creator`,`ss_created_on`,`ss_org_no`) values (NULL,'$office_code','$item_code','$item_name','$parent_id','$item_level','$item_category','$ss_creator',now(),'$ss_org_no')";
    $conn->query($insertQuery);
    if ($conn->affected_rows == 1) {
        $message = 'Main Item Data Saved !!';
        header('location: item.php');
    } else {
        $message = 'Main Item Data Failled !!';
    }
}
require '../source/top.php';
$pid = 204000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require '../source/header.php';
require '../source/sidebar.php';
$query = "Select Max(item_code) From item where item_level=1";
$returnDrow = mysqli_query($conn, $query);
$resultrow = mysqli_fetch_assoc($returnDrow);
$maxRowsrow = $resultrow['Max(item_code)'];
if (empty($maxRowsrow)) {
    $lastRowrow = 100000000000;
} else {
    $lastRowrow = $maxRowsrow + 100000000000;
}
$query = "Select Max(id) From item";
$return = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($return);
$maxRows = $result['Max(id)'];
if (empty($maxRows)) {
    $lastRow = 1;
} else {
    $lastRow = $maxRows + 1;
}
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Add Category Information </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- ----------------code here---------------->
            <form action="" method="post">
                <div class="form-row">
                    <div class="form-group col-sm-4">
                        <label for="inputEmail4">Category Code</label>
                        <input type="text" readonly name="item_code" class="form-control" autofocus value=<?php if (!empty($lastRowrow)) {
                                                                                                                echo $lastRowrow;
                                                                                                            } ?>>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="inputtext4">Category Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <!-- hidden account -->
                    <input type="hidden" name="parent_id" class="form-control" value="0">
                    <input type="hidden" name="item_category" class="form-control" autofocus value=<?php echo $lastRow; ?>>
                    <input type="hidden" name="item_level" class="form-control" value="1">
                    <div class="form-group col-sm-2">
                        <label style="margin-top: 15px"></label>
                        <input type="submit" name="submit" class="form-control btn btn-success" required>
                    </div>
                </div>
            </form>
            <!-- ----------------code here---------------->
        </div>
    </div>
    <div>
        <button class="btn btn-info btnAllItem">Both Item</button>
        <button class="btn btn-info btnSellAble">Sellable Item</button>
        <button class="btn btn-info btnPurchaseAble">Purchaseable Item</button>
    </div>
    <br>
    <!-- data table  -->
    <div class="tile">
        <div class="tile-body">
            <div class="allItem">
                <table class="table table-hover table-bordered" id="allItem">
                    <h4 style="text-align: center">List of All Item</h4>
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Parent ID</th>
                            <th>Item Code</th>
                            <th>Item Level</th>
                            <th>Item Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $sql = "SELECT * FROM item where sellable_option='B'";
                        //use for MySQLi-OOP
                        $query = $conn->query($sql);
                        $counter = 0;
                        while ($row = $query->fetch_assoc()) {

                            echo '<tr>';
                            echo '<td>' . ++$counter . '</td>';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['item_name'] . '</td>';
                            echo '<td>' . $row['parent_id'] . '</td>';
                            echo '<td>' . $row['item_code'] . '</td>';
                            echo '<td>' . $row['item_level'] . '</td>';
                            echo '<td>' . $row['item_category'] . '</td>';

                            echo '<td> <a  type="button" class="btn btn-info btn-sm" href="addsubitem.php?id=' . $row['id'] . '"><i class="fa fa-plus" aria-hidden="true"></i> Add Sub item </a>
            <a  type="button" class="btn btn-success btn-sm" title="Edit ' . $row['item_name'] . '" href="edit_item.php?id=' . $row['id'] . '"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>';
                            echo '<a href="deleteiIem.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" title="Delete ' . $row['item_name'] . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"> <i class="fa fa-trash" aria-hidden="true"></i> </a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="sellAble">
                <table class="table table-hover table-bordered" id="sellAble">
                    <h4 style="text-align: center">List of Sellable</h4>
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Parent ID</th>
                            <th>Item Code</th>
                            <th>Item Level</th>
                            <th>Item Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM item where sellable_option='Y'";

                        //use for MySQLi-OOP
                        $query = $conn->query($sql);
                        $counter = 0;
                        while ($row = $query->fetch_assoc()) {

                            echo '<tr>';
                            echo '<td>' . ++$counter . '</td>';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['item_name'] . '</td>';
                            echo '<td>' . $row['parent_id'] . '</td>';
                            echo '<td>' . $row['item_code'] . '</td>';
                            echo '<td>' . $row['item_level'] . '</td>';
                            echo '<td>' . $row['item_category'] . '</td>';

                            echo '<td> <a  type="button" class="btn btn-info btn-sm" href="addsubitem.php?id=' . $row['id'] . '"><i class="fa fa-plus" aria-hidden="true"></i> Add Sub item </a>
            <a  type="button" class="btn btn-success btn-sm" title="Edit ' . $row['item_name'] . '" href="edit_item.php?id=' . $row['id'] . '"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>';
                            echo '<a href="deleteiIem.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" title="Delete ' . $row['item_name'] . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"> <i class="fa fa-trash" aria-hidden="true"></i> </a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="purchaseAble">
                <table class="table table-hover table-bordered purchaseAble" id="purchaseAble">
                    <h4 style="text-align: center">List of Purchaseable</h4>
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Parent ID</th>
                            <th>Item Code</th>
                            <th>Item Level</th>
                            <th>Item Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM item where sellable_option='N'";

                        //use for MySQLi-OOP
                        $query = $conn->query($sql);
                        $counter = 0;
                        while ($row = $query->fetch_assoc()) {

                            echo '<tr>';
                            echo '<td>' . ++$counter . '</td>';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['item_name'] . '</td>';
                            echo '<td>' . $row['parent_id'] . '</td>';
                            echo '<td>' . $row['item_code'] . '</td>';
                            echo '<td>' . $row['item_level'] . '</td>';
                            echo '<td>' . $row['item_category'] . '</td>';

                            echo '<td> <a  type="button" class="btn btn-info btn-sm" href="addsubitem.php?id=' . $row['id'] . '"><i class="fa fa-plus" aria-hidden="true"></i> Add Sub item </a>
            <a  type="button" class="btn btn-success btn-sm" title="Edit ' . $row['item_name'] . '" href="edit_item.php?id=' . $row['id'] . '"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>';
                            echo '<a href="deleteiIem.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" title="Delete ' . $row['item_name'] . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"> <i class="fa fa-trash" aria-hidden="true"></i> </a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
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
<!-- Data table plugin-->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $('#allItem').DataTable();
    $('#purchaseAble').DataTable();
    $('#sellAble').DataTable();
</script>
<script src="../js/select2.full.min.js"></script>
<script src="../js/bootstrap.min"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })
    //====getAccountAddress====
    function showGrandRole(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "getAccountAddress.php?q=" + str, true);
            xmlhttp.send();
        }
    }
    $(document).ready(function() {
        $("#204000").addClass('active');
        $("#200000").addClass('active');
        $("#200000").addClass('is-expanded');
        // init
        $('.allItem').show();
        $('.purchaseAble').hide();
        $('.sellAble').hide();

        // btnAllItem
        $('.btnAllItem').on('click', function() {
            $('.allItem').show();
            $('.purchaseAble').hide();
            $('.sellAble').hide();
        });

        // btnSellAble
        $('.btnSellAble').on('click', function() {
            $('.sellAble').show();
            $('.allItem').hide();
            $('.purchaseAble').hide();
        });

        // btnPurchaseAble
        $('.btnPurchaseAble').on('click', function() {
            $('.purchaseAble').show();
            $('.allItem').hide();
            $('.sellAble').hide();
        });

    });
</script>
</body>

</html>