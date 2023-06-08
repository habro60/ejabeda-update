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
            <h1><i class="fa fa-dashboard"></i> Fund Report</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <form method="post">
        <table>
            <thead>
                <th> <a href="../bodri_report/print_chanda_paid_rept.php"><button type="button" class="btn btn-success" >Chanda Collected Report</button></a></th>
                <th> <a href="../bodri_report/print_chanda_due_rept.php"><button type="button" class="btn btn-primary" >Chanda Due Report</button></a></th>
                <th> <a href="../bodri_report/chanda_paid_list.php"><button type="button" class="btn btn-success">Paid list</button></a></th>
                <th> <a href="../bodri_report/chanda_due_list.php"><button type="button" class="btn btn-success">Due list</button></a></th>
                
            </thead>
        </table>
    </form>
        
<?php
$conn->close();
?>
</body>

</html>