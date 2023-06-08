<?php
require __DIR__.'/../auth/auth.php';
require __DIR__.'/../set_db/set_database_after_login.php';
require __DIR__.'/../source/top.php';
require __DIR__.'/../source/sidebar.php';
require __DIR__.'/../source/header.php';
?>
<!-- write your contant start -->
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
      <p></p>
      <!-- logged in user information -->
      <p style="color:red">Welcome Accounting Managemet Software</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
  </div>
  <!-- Currency Symbole -->
  <?php
  $query8 = "Select org_loc_curr_symbol from org_info";
  $curr_symbol = mysqli_query($conn, $query8);
  $symbol = mysqli_fetch_assoc($curr_symbol);
  ?>
  
	<?php	if ($_SESSION['sa_role_no'] == '800') { ?>
    <div class="col-md-6 col-lg-3">
        <div class="info">
          <h4 style="color:blue;font-weight:bold"><a href="../dashboard/owner_dashboard.php" target="_blank">Owner Dashboard</a></h4>
        </div>
    </div>
	
	<?Php } ?>

  <?php	if ($_SESSION['sa_role_no'] == '99') { ?>
    <div class="col-md-6 col-lg-3">
        <div class="info">
          <h4 style="color:blue;font-weight:bold"><a href="../dashboard/admin_dashboard.php" target="_blank">Admin Dashboard</a></h4>
        </div>
    </div>
	
	<?Php } ?>

  <?php	if ($_SESSION['sa_role_no'] == '100') { ?>
    <div class="col-md-6 col-lg-3">
        <div class="info">
          <h4 style="color:blue;font-weight:bold"><a href="../dashboard/admin_dashboard.php" target="_blank">Super Admin Dashboard</a></h4>
        </div>
    </div>
	
	<?Php } ?>

  <?php	if ($_SESSION['sa_role_no'] == '200') { ?>
    <div class="col-md-6 col-lg-3">
        <div class="info">
          <h4 style="color:blue;font-weight:bold"><a href="../dashboard/admin_dashboard.php" target="_blank">Customer Dashboard</a></h4>
        </div>
    </div>
	
	<?Php } ?>

  <?php	if ($_SESSION['sa_role_no'] == '300') { ?>
    <div class="col-md-6 col-lg-3">
        <div class="info">
          <h4 style="color:blue;font-weight:bold"><a href="../dashboard/admin_dashboard.php" target="_blank">Supplier Dashboard</a></h4>
        </div>
    </div>
	
	<?Php } ?>

  <?php	if ($_SESSION['sa_role_no'] == '400') { ?>
    <div class="col-md-6 col-lg-3">
        <div class="info">
          <h4 style="color:blue;font-weight:bold"><a href="../dashboard/admin_dashboard.php" target="_blank">Member Dashboard</a></h4>
        </div>
    </div>
	
	<?Php } ?>

	
  <div class="row">
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Total Income</h3>
        <div class="embed-responsive embed-responsive-16by9">
          <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Total Expense</h3>
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