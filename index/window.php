<?php

require __DIR__ . '/../auth/auth.php';
require __DIR__ . '/../database.php';
require __DIR__ . '/../source/top.php';
require __DIR__ . '/../source/header.php';
require __DIR__ . '/../source/sidebar.php';

?>



<!-- write your contant start -->

<main class="app-content">

  <div class="app-title">

    <?php



    $id = $_SESSION['id'];

    $main_id = $_GET['id'];



    $sql_item = "SELECT sm_role_dtl.role_no, sm_role_dtl.menu_name ,sm_role_dtl.main_id, sm_role_dtl.active_stat, user_info.id,user_info.sa_role_no FROM sm_role_dtl, user_info WHERE sm_role_dtl.role_no=user_info.sa_role_no AND sm_role_dtl.main_id=$main_id AND user_info.id=$id AND sm_role_dtl.active_stat = 1";

    $result_item = $conn->query($sql_item);

    $data = $result_item->fetch_assoc();

    ?>

    <div>

      <h1><i class="fa fa-dashboard"></i> <?php echo $data['menu_name']; ?></h1>

      <p></p>

    </div>

    <ul class="app-breadcrumb breadcrumb">

      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>

      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>

    </ul>

  </div>

  <!-- Currency Symbole -->

  <!-- !- menu -->

  <div class="row">

    <?php

    $id = $_SESSION['id'];

    $p_menu_no = $_GET['id'];



    $sql = "SELECT sm_role_dtl.role_no, sm_role_dtl.menu_no, sm_role_dtl.menu_name, sm_role_dtl.menu_obj_name,sm_role_dtl.main_id,sm_role_dtl.p_menu_no, sm_role_dtl.active_stat, user_info.id, user_info.username, user_info.sa_role_no FROM sm_role_dtl, user_info WHERE sm_role_dtl.role_no=user_info.sa_role_no AND sm_role_dtl.p_menu_no=$p_menu_no AND user_info.id=$id AND sm_role_dtl.active_stat = 1";

    $result = $conn->query($sql);

    ?>

    <?php

    if (mysqli_num_rows($result)) {

      while ($rows = $result->fetch_assoc()) {

    ?>

        <div class="col-md-6 col-lg-3">

          <div class="widget-small info coloured-icon"> <img src="../dashboard_image/asset_final.png" alt="asset" width="60px" height="60px">

            <div class="info">

              <h4 style="color:green;font-weight:bold"><a class="" href="<?php echo $rows['menu_obj_name']; ?>"><?php echo $rows['menu_name']; ?></a></h4>

              <p><b><?php // echo $rows['menu_name']; 

                    ?> <?php echo " "; ?><?php // echo $rows['menu_name']; 

                                          ?></b></p>

            </div>

          </div>

        </div>

    <?php

      }
    }

    ?>

  </div>

  <!-- !- durmmy -->

  <div class="row">

    <div class="col-md-6">

      <div class="tile">

        <h3 class="tile-title">Total Sales</h3>

        <div class="embed-responsive embed-responsive-16by9">

          <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>

        </div>

      </div>

    </div>

    <div class="col-md-6">

      <div class="tile">

        <h3 class="tile-title">Total Income-Expense</h3>

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
  $(document).ready(function() {

    $("#205000").css('active');

    $("#200000").css('backgronud:red');

    $("#200000").addClass('is-expanded');

  });

  $('body').click(function() {

    var id = event.target.id;

    alert(id);

  });

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

    var tt = $('#bill_amount' + amount + '').css({

      "color": "black",

      "border": "2px solid white"

    });

    var id = <?php echo $_GET['id']; ?>;

    $("#dashboard").addClass('active');

    $("#1000000").addClass('active');

    // $("#1300000").css({

    //   "color": "black",

    //   "border": "2px solid white"

    // });

  });

  $('body').click(function() {

    var segments = url.split('?');

    // var action = segments[3];

    var id = segments[1];

    // var id = <?php echo $_GET['id']; ?>;

    // alert(itemId);

    alert(id);

  });
</script>



</body>



</html>