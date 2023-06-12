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


        <div>

            <h1><i class="fa fa-dashboard"></i> Bill Payment</h1>

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





        <div class="col-md-6 col-lg-3">

            <div class="widget-small info coloured-icon"> <img src="../dashboard_image/asset_final.png" alt="asset" width="60px" height="60px">

                <div class="info">

                    <h4 style="color:green;font-weight:bold"><a class="" href="../billPayment/onlinePayment.php">Online Payment</a></h4>



                </div>

            </div>

        </div>


    </div>

    <!-- !- durmmy -->



   

  

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



</body>



</html>