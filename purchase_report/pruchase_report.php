<?php
require "../auth/auth.php";
require "../database.php";
    

require "../source/top.php";
 $pid = 1016000;
// $role_no = $_SESSION['sa_role_no'];
// auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Purchase Report</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <form method="post">
        <table>
            <thead>
                <th> <a href="../purchase_report/purchase_details.php"><button type="button" class="btn btn-success" >Purchase Details</button></a></th>
                <th> <a href="../purchase_report/cash_purchase_rep.php"><button type="button" class="btn btn-primary" >Cash Purchase</button></a></th>
                <th> <a href="../purchase_report/credit_purchase_rep.php"><button type="button" class="btn btn-primary" >Credit Purchase</button></a></th>
                <th> <a href="../purchase_report/supp_bill_due_list.php"><button type="button" class="btn btn-success">Bill Due Report</button></a></th>
                <th> <a href="../purchase_report/supp_bill_paid_list.php"><button type="button" class="btn btn-success">Bill Paid Report</button></a></th>
                <th> <a href="../purchase_report/supp_return_report.php"><button type="button" class="btn btn-primary">Purchase Return Report</button></a></th>
                <th> <a href="../purchase_report/monthly.php"><button type="button" class="btn btn-primary">Monthly Purchase Report</button></a></th>
                <th> <a href="../purchase_report/summ_report.php"><button type="button" class="btn btn-primary">Summary Report</button></a></th>
                <th> <a href="../purchase_report/indent_list.php"><button type="button" class="btn btn-primary">Indent List</button></a></th>
                
            </thead>
        </table>
    </form>
        
<?php
$conn->close();
?>
</body>

</html>