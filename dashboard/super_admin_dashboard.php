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
            <h1><i class="fa fa-dashboard"></i> Dash Board</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <?php
            $deshbord_id =$_SESSION['sa_role_no'];
                 if ($deshbord_id=='99') { 
            header("Location: dashboard/admin_dashboard.php");
                 }

            ?>
        </ul>
    </div>

    
        
    </form>
        
<?php
$conn->close();
?>
</body>

</html>