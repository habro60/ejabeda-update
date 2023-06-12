<?php
require "../auth/auth.php";
require "../database.php";
//  echo "<meta http-equiv=\"refresh\" content=\"0;URL=apart_report.php\">";
    

require "../source/top.php";
// $pid = 401000;
// $role_no = $_SESSION['sa_role_no'];
// auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dokan Vara Report</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <form method="post">
        <table>
            <thead>
                <th> <a href="../dokan_vara_report/print_vara_paid_rept.php"><button type="button" class="btn btn-success" >Vara Received Report</button></a></th>
                <th> <a href="../dokan_vara_report/print_vara_due_rept.php"><button type="button" class="btn btn-primary" >Vara Due Report</button></a></th>
                <th> <a href="../dokan_vara_report/vara_paid_list.php"><button type="button" class="btn btn-success">Received Slip</button></a></th>
                <th> <a href="../dokan_vara_report/vara_due_list.php"><button type="button" class="btn btn-success">Due Slip</button></a></th>
                <th> <a href="../dokan_vara_report/print_dokan_vara_list.php"><button type="button" class="btn btn-success">Dokan Vara List</button></a></th>
                <th> <a href="../dokan_vara_report/print_dokan_close_list.php"><button type="button" class="btn btn-success">Dokan Close List</button></a></th>
                
            </thead>
        </table>
    </form>
        
<?php
$conn->close();
?>
</body>

</html>