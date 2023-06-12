<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Apartment Setting </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <script>
        $(function() {
            $("#tabs").tabs();
        });
    </script>
    </head>

    <body>

        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Bill Setting</a></li>
                <li><a href="#tabs-2">Facility Setting</a></li>
            </ul>
            <div id="tabs-1">
                one
            </div>
            <div id="tabs-2">
                two
            </div>
        </div>


</main>
</body>

</html>