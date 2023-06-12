<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<!-- write your contant start -->
<main class="app-content">
  <div class="app-title">
    <div>
      <!-- <h1><i class="fa fa-dashboard"></i> Dashboard</h1> -->
      <p></p>
      <!-- logged in user information -->
      <p style="color:red">Welcome Accounting Managemet Software</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#"><?php echo $_SESSION['office_code']; ?></a></li>
    </ul>
  </div>
  <!-- Currency Symbole -->
  <?php
  $query8 = "Select org_loc_curr_symbol from org_info";
  $curr_symbol = mysqli_query($conn, $query8);
  $symbol = mysqli_fetch_assoc($curr_symbol);
  ?>
  <!-- total employee -->
  <?php
  $query = "Select count(emp_no) From sm_hr_emp";
  $returnD = mysqli_query($conn, $query);
  $result = mysqli_fetch_assoc($returnD);
  ?>
  <!-- total Sales  -->
  <?php
  $query7 = "select invoice_detail.in_out_flag, sum(invoice_detail.total_price_loc) as total_sales from invoice_detail where invoice_detail.in_out_flag = 2";
  $returnPur = mysqli_query($conn, $query7);
  $sales = mysqli_fetch_assoc($returnPur);
  ?>
  <!-- total purchase  -->
  <?php
  $query6 = "select invoice_detail.in_out_flag, sum(invoice_detail.total_price_loc) as total_purchase from invoice_detail where invoice_detail.in_out_flag = 1";
  $returnPur = mysqli_query($conn, $query6);
  $purchase = mysqli_fetch_assoc($returnPur);
  ?>
  
  <!-- total Assets  -->
  <?php
  $query4 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as balance FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< now() AND gl_acc_code.category_code = '1' group by gl_acc_code.category_code";
  $returnAssets = mysqli_query($conn, $query4);
  $assets = mysqli_fetch_assoc($returnAssets);
  ?>
  <!-- total Liabulity  -->
  <?php
  $query3 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.cr_amt_loc- tran_details.dr_amt_loc) as balance FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< now() AND gl_acc_code.category_code = '2' group by gl_acc_code.category_code";
  $returnLiability = mysqli_query($conn, $query3);
  $liability = mysqli_fetch_assoc($returnLiability);
  ?>
  <!-- total income  -->
  <?php
  $query2 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.cr_amt_loc- tran_details.dr_amt_loc) as balance FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< now() AND gl_acc_code.category_code = '3' group by gl_acc_code.category_code";
  $returnIncome = mysqli_query($conn, $query2);
  $income = mysqli_fetch_assoc($returnIncome);
  ?>
  <!-- totoal Expense  -->
  <?php
  $query1 = "SELECT gl_acc_code.acc_code, gl_acc_code.acc_head,gl_acc_code.category_code, gl_acc_code.acc_level, tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as cr_amt_loc, sum(tran_details.dr_amt_loc) as dr_amt_loc, tran_details.tran_date, SUM(tran_details.dr_amt_loc- tran_details.cr_amt_loc) as balance FROM gl_acc_code JOIN tran_details ON gl_acc_code.acc_code=tran_details.gl_acc_code AND tran_details.tran_date< now() AND gl_acc_code.category_code = '4' group by gl_acc_code.category_code";
  $returnD = mysqli_query($conn, $query1);
  $expense = mysqli_fetch_assoc($returnD);
  ?>
  
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"> <img src="../dashboard_image/asset_final.png" alt="asset" width="60px" height="60px">
        <div class="info">
          <h4 style="color:green;font-weight:bold">Total Asset</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?> <?php echo " "; ?><?php echo $assets['balance']; ?></b></p>

        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><img src="../dashboard_image/Liablity.png" alt="asset" width="60px" height="60px">
        <div class="info">
          <h4 style="color:red;font-weight:bold">Total Liability</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?><?php echo " "; ?> <?php echo $liability['balance']; ?></b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><img src="../dashboard_image/Sale.png" alt="asset" width="60px" height="60px">
        <div class="info">
          <h4 style="color:green;font-weight:bold">Total Sale</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?><?php echo " "; ?><?php echo $sales['total_sales']; ?></b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon"><img src="../dashboard_image/Employee.png" alt="asset" width="55px" height="60px">
        <div class="info">
          <h4 style="color:#47C3D2;font-weight:bold">Total Employee</h4>
          <p><b><?php echo "No.:"; ?><?php echo $maxRows = $result['count(emp_no)']; ?></b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><img src="../dashboard_image/Expense.png" alt="asset" width="60px" height="60px">
        <div class="info">
          <h4 style="color:#e7d51e;font-weight:bold">Total Expense</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?><?php echo " "; ?><?php echo $expense['balance']; ?></b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><img src="../dashboard_image/income_final.png" alt="asset" width="60px" height="60px">
        <div class="info">
          <h4 style="color:green;font-weight:bold">Total Income</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?><?php echo " "; ?><?php echo $income['balance']; ?></b></p>
        </div>
      </div>
    </div>


    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><img src="../dashboard_image/Purchase.png" alt="asset" width="50px" height="60px">
        <div class="info">
          <h4 style="color:blue;font-weight:bold">Total Purchase</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?><?php echo " "; ?><?php echo $purchase['total_purchase']; ?></b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><img src="../dashboard_image/Stock.png" alt="asset" width="60px" height="60px">
        <div class="info">
          <h4 style="color:green;font-weight:bold">Total Stock</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?><?php echo " "; ?><?php echo ($purchase['total_purchase'] - $sales['total_sales']); ?></b></p>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><img src="../dashboard_image/gross_profit.png" alt="asset" width="60px" height="60px">
        <div class="info">
          <h4 style="color:green;font-weight:bold">Gross Profit</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?><?php echo " "; ?><?php echo ($income['balance'] - $expense['balance']); ?></b></p>
        </div>
      </div>
    </div>
    <!-- custom end -->
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="tile">
        <!-- <h3 class="tile-title">Total Sales</h3> -->
        <div class="embed-responsive embed-responsive-16by9">
          <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
        </div>
      </div>
    </div> 
    <div class="col-md-6">
      <div class="tile">
        <!-- <h3 class="tile-title">Total Income-Expense</h3> -->
        <div class="embed-responsive embed-responsive-16by9">
          <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
        </div>
      </div>
    </div>
  </div>
</main>
<!-- Write your contant end -->
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../script plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<script type="text/javascript" src="../js/plugins/chart.js"></script>
<script type="text/javascript">
  var data = {
    labels: ["January", "February", "March", "April", "May"],
    datasets: [{
        label: "My First dataset",
        fillColor: "rgba(220,220,220,0.2)",
        strokeColor: "rgba(220,220,220,1)",
        pointColor: "rgba(220,220,220,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(220,220,220,1)",
        data: [65, 59, 80, 81, 56]
      },
      {
        label: "My Second dataset",
        fillColor: "rgba(151,187,205,0.2)",
        strokeColor: "rgba(151,187,205,1)",
        pointColor: "rgba(151,187,205,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(151,187,205,1)",
        data: [28, 48, 40, 19, 86]
      }
    ]
  };

  var pdata = [{
      value: <?php echo $income['balance']; ?>,
      color: "green",
      highlight: "#5AD3D1",
      label: "Income"
    },

    {
      value: <?php echo $expense['balance']; ?>,
      color: "red",
      highlight: "#FF5A5E",
      label: "Expense"
    }
  ]

  var ctxl = $("#lineChartDemo").get(0).getContext("2d");
  var lineChart = new Chart(ctxl).Line(data);

  var ctxp = $("#pieChartDemo").get(0).getContext("2d");
  var pieChart = new Chart(ctxp).Pie(pdata);
</script>
<!-- get out  -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#dashboard").addClass('active');
  });
</script>
</body>

</html>