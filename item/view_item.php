<!-- 
==================================
File Name: view_item.php
Description: Create Item.
Featheure: 
Create Date: 28-11-2019
Create by: Mohammad Ali Abdullah.
Protect by: Habro Systems Limited..
========================================
 -->

<?php
require "../auth/auth.php";
require '../database.php';
?>

<?php
require '../source/top.php';
?>
<?php
require '../source/header.php';
?>
<?php
require '../source/sidebar.php';
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> View Item Information </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="container">

                <!-- <h4 style="text-align:center">View Item</h4> -->

                <!-- form close  -->
                <!-- table view start  -->
                <!-- <div class="table-responsive border-dark border-top"> -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th> Item</th>
                                <th>Parent Item</th>
                                <th> Unit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require '../database.php';
                            $selectQuery = 'select * from `item` where 1';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    //echo $row['id']." ".$row['Name']. "</br>";
                                    echo '<tr>';
                                    echo '<td>' . $row['id'] . '</td>';
                                    echo '<td>' . $row['item'] . '</td>';
                                    echo '<td>' . $row['parent_id'] . '</td>';
                                    echo '<td>' . $row['unit'] . '</td>';
                                    echo '<td> <a  type="button" class="btn btn-info" href="addsubitem.php?id=' . $row['id'] . '"> Add Sub item </a>
            <a  type="button" class="btn btn-xs btn-warning" href="edit_item.php?id=' . $row['id'] . '"> EDIT </a> ';
                                    echo '<a href="deleteiIem.php?id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</a></td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo 'No records to show';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- table view end -->
            </div>
            <!-- ----------------code here---------------->
            <!-- </div> -->
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
<script src="../js/bootstrap.min"></script>
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