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
      <p style="color:red">Welcome to Your Personal Account</p>
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
  
  
  <!-- Cash Balance -->
  <?php
  $query6 = "select personal_ledger.owner_rec_id, sum((personal_ledger.dr_amt_loc)- (personal_ledger.cr_amt_loc)) as cash_balance, personal_account.id, personal_account.category_code from personal_ledger,personal_account where personal_ledger.owner_rec_id=personal_account.owner_rec_id and personal_ledger.owner_rec_id='6' and personal_account.id=personal_ledger.gl_acc_code and personal_account.category_code='1'";
  $rows1 = mysqli_query($conn, $query6);
  $cashBalance = mysqli_fetch_assoc($rows1);
  ?>
  
  <!-- Bank Balance -->
  <?php
  $query4 = "select personal_ledger.owner_rec_id, sum((personal_ledger.dr_amt_loc)- (personal_ledger.cr_amt_loc)) as bank_balance, personal_account.id, personal_account.category_code from personal_ledger,personal_account where personal_ledger.owner_rec_id=personal_account.owner_rec_id and personal_ledger.owner_rec_id='6' and personal_account.id=personal_ledger.gl_acc_code and personal_account.category_code='2'";
  $rows2 = mysqli_query($conn, $query4);
  $bankBalance = mysqli_fetch_assoc($rows2);
  ?>
  
  <!-- total income  -->
  <?php
  $query2 = "select personal_ledger.owner_rec_id, sum((personal_ledger.cr_amt_loc)- (personal_ledger.dr_amt_loc)) as total_income, personal_account.id, personal_account.category_code from personal_ledger,personal_account where personal_ledger.owner_rec_id=personal_account.owner_rec_id and personal_ledger.owner_rec_id='6' and personal_account.id=personal_ledger.gl_acc_code and personal_account.category_code='3'";
  $rows3 = mysqli_query($conn, $query2);
  $totalIncome = mysqli_fetch_assoc($rows3);
  ?>
  <!-- totoal Expense  -->
  <?php
  $query1 = "select personal_ledger.owner_rec_id, sum((personal_ledger.dr_amt_loc)- (personal_ledger.cr_amt_loc)) as total_expenses, personal_account.id, personal_account.category_code from personal_ledger,personal_account where personal_ledger.owner_rec_id=personal_account.owner_rec_id and personal_ledger.owner_rec_id='6' and personal_account.id=personal_ledger.gl_acc_code and personal_account.category_code='4'";
  $rows4 = mysqli_query($conn, $query1);
  $totalExpense = mysqli_fetch_assoc($rows4);
  ?>
  
  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"> <img src="../dashboard_image/asset_final.png" alt="asset" width="60px" height="60px">
        <div class="info">
          <h4 style="color:green;font-weight:bold">Cash Balance</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?> <?php echo " "; ?><?php echo $cashBalance['cash_balance']; ?></b></p>

        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><img src="../dashboard_image/Liablity.png" alt="asset" width="60px" height="60px">
        <div class="info">
          <h4 style="color:red;font-weight:bold">Bank Balance</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?><?php echo " "; ?> <?php echo $bankBalance['bank_balance']; ?></b></p>
        </div>
      </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><img src="../dashboard_image/Expense.png" alt="asset" width="60px" height="60px">
        <div class="info">
          <h4 style="color:#e7d51e;font-weight:bold">Total Income</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?><?php echo " "; ?><?php echo $totalIncome['total_income']; ?></b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><img src="../dashboard_image/income_final.png" alt="asset" width="60px" height="60px">
        <div class="info">
          <h4 style="color:green;font-weight:bold">Total Expenses</h4>
          <p><b><?php echo $symbol['org_loc_curr_symbol']; ?><?php echo " "; ?><?php echo $totalExpense['total_expenses']; ?></b></p>
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