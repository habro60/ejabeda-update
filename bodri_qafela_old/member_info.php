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
            <h1><i class="fa fa-dashboard"></i> Fund Member Information</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <form method="post">
        <table>
            <thead>
            <th> <a href="../bodri_qafela/bodri_mem_reg.php"><button type="button" class="btn btn-success"> Member Information</button></a></th>   
            <th> <a href="../bodri_qafela/gl_fund_assigned.php"><button type="button" class="btn btn-success"> GL A/C & Fund Assigned</button></a></th>
            </thead>
        </table>
    </form>
        
<?php
$conn->close();
?>
</body>

</html>