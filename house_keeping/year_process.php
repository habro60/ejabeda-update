<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['subBtn'])) {
    // $acc_code = $_POST['acc_code'];
    $year = $_SESSION['org_fin_year_st'];


    $creat = "CREATE TABLE tran_details_$year LIKE tran_details";
    $conn->query($creat);
    $insert = "INSERT INTO tran_details_$year SELECT * FROM tran_details";
    $conn->query($insert);
    if ($conn->affected_rows == 1) {
        $message = "Save Successfully!";
    } else {
        $mess = "Failled!";
    }
    $delete = "DELETE FROM tran_details";
    $conn->query($delete);
    header('refresh:1;../house_keeping/year_process.php');
}
require "../source/top.php";
$pid= 105000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Year Process</h1>
            <p>Create Your History Table</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index/index.php">Home Page</a></li>
        </ul>
    </div>
    <!-- sample  -->

    <form action="" method="post">
        <h1>BackUp Your History Transation Table All Data </h1>
        <table class="table table-hover table-bordered table-responsive">
    <tr>
      <th>ID</th>
      <th>menu_no</th>
      <th>menu_name</th>
      <th>menu_obj_name</th>
      <th>Menu Type</th>
      <th>P_Menu_ID</th>
      <th>lavel</th>
      <th>active_stat</th>
    </tr>
    <?php
    $selectQuery = "SELECT * FROM `sm_menu` ORDER by menu_no";
    $selectQueryResult = $conn->query($selectQuery);
    //echo "$selectQueryResult->num_rows";	
    if ($selectQueryResult->num_rows) {

      while ($rows = $selectQueryResult->fetch_array()) {
        echo "<tr>";
        echo "<td>" . $rows['id'] . "</td>";
        echo "<td>" . $rows['menu_no'] . "</td>";
        echo "<td>" . $rows['menu_name'] . "</td>";
        echo "<td>" . $rows['menu_obj_name'] . "</td>";
        echo "<td>" . $rows['menu_type'] . "</td>";
        echo "<td>" . $rows['p_menu_no'] . "</td>";
        echo "<td>" . $rows['lavel_no'] . "</td>";
        echo "<td>" . $rows['active_stat'] . "</td>";
       
      }
    }

    ?>
  </table>
            <input type="submit" value="Backup" class="btn btn-danger" name="subBtn">
    </form>
    <!-- sample  -->
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java script plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#105000").addClass('active');
        $("#100000").addClass('active');
        $("#100000").addClass('is-expanded');
    });
</script>
</body>

</html>