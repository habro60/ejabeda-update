<?php
require "../auth/auth.php";
require "../database.php";
    

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
            <h1><i class="fa fa-dashboard"></i>Sales Report</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <form method="post">
        <table>
            <thead>
                <th> <a href="../sales_report/sales_details.php"><button type="button" class="btn btn-success" >Sales Details</button></a></th>
                <th> <a href="../sales_report/cash_sales_rep.php"><button type="button" class="btn btn-primary" >Cash Sales</button></a></th>
                <th> <a href="../sales_report/credit_sales_rep.php"><button type="button" class="btn btn-primary" >Credit Sales</button></a></th>
                <th> <a href="../sales_report/cust_bill_due_list.php"><button type="button" class="btn btn-success">Customer Bill Due Report</button></a></th>
                <th> <a href="../sales_report/cust_bill_paid_list.php"><button type="button" class="btn btn-success">Customer Bill Paid Report</button></a></th>
                <th> <a href="../sales_report/cust_return_report.php"><button type="button" class="btn btn-primary">Sales Return Report</button></a></th>
                <th> <a href="../sales_report/monthly.php"><button type="button" class="btn btn-primary">Monthly sales Report</button></a></th>
                <th> <a href="../sales_report/sales_summ_report.php"><button type="button" class="btn btn-primary">Sales Summary Report</button></a></th>
               
                
            </thead>
        </table>
    </form>
        
<?php
$conn->close();
?>
</body>

</html>