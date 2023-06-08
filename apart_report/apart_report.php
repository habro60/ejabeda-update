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
            <h1><i class="fa fa-dashboard"></i> Apartment Report</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <form method="post">
        <table>
            <thead>
                <th> <a href="../apart_report/monthly_electric_bill_list.php"><button type="button" class="btn btn-success" >Mthly Elect. Bill Entry</button></a></th>
                <th> <a href="../apart_report/monthly_other_bill_list.php"><button type="button" class="btn btn-primary" >Mthly sevice Bill Entry</button></a></th>
                <th> <a href="../apart_report/print_bill_recite.php"><button type="button" class="btn btn-success">Single Bill Issue Slip</button></a></th>
                <th> <a href="../apart_report/print_all_bill_issue.php"><button type="button" class="btn btn-success">All Bill Issue Slip</button></a></th>
                <th> <a href="../apart_report/print_bill_due_rept.php"><button type="button" class="btn btn-primary">Bill Due Report</button></a></th>
                <th> <a href="../apart_report/print_bill_paid_rept.php"><button type="button" class="btn btn-success">Bill Received Report</button></a></th>
                <th> <a href="../apart_report/bill_charge_setup_rept.php"><button type="button" class="btn btn-success">Bill Setup Report</button></a></th>
                <th> <a href="../apart_report/print_owner_list.php"><button type="button" class="btn btn-primary">Owner/Merchant List</button></a></th>
            </thead>
            <thead>
                <th> <a href="../apart_report/bill_receive_summ_rept.php"><button type="button" class="btn btn-success" >Bill Receive Summ. Rept</button></a></th>
                <th> <a href="../apart_report/print_money_receive_rept.php"><button type="button" class="btn btn-primary">Money Receive</button></a></th>

            </thead>
        </table>
    </form>
        
<?php
$conn->close();
?>
</body>

</html>