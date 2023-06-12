<style>
  .hideshow {
    text-align: center;
    height: 35px;
    margin-left: 25%;
    margin-top: 10px;

  }

  .hideshow img {
    height: 50px;
    width: 50px;
    font-weight: bold;
    margin-top: -10px;

  }

  .hideshow span {
    font-size: 30px;
    font-weight: bold;
    color: #fff;
    text-align: center;
    font-family: 'Niconne';

  }

  @media only screen and (max-width: 800px) {
    .hideshow {
      display: none;
    }

    .hideshow span {
      font-size: 10px;

    }

    .hideshow img {
      height: 30px;
      width: 30px;
      margin: 5px;
    }
  }

  @media only screen and (max-width: 600px) {
    .hideshow {
      display: none;
    }

    .sidebardisplay {
      display: none;

    }
  }
</style>
</head>

<body class="app sidebar-mini rtl">
  <!-- Navbar-->
  <header class="app-header"><a class="app-header__logo" href="index.php"><img src="../upload/official_logo.png" height="70px" width="150px" alt=""></a>
    <!-- <header class="app-header"><a class="app-header__logo" href="index.php">E-Jabeda</a> -->
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>

    <div class="hideshow">
      <?php
      require __DIR__ . '/../set_db/set_database_after_login.php';
      $org_name = $_SESSION['org_name'];
      $org_logo = $_SESSION['org_logo'];
      $office_code = $_SESSION['office_code'];
      $sql = "SELECT office_code,office_name from office_info where office_code=?";
      $query = $conn->prepare($sql);
      $query->bind_param("i", $office_code);
      $query->execute();
      $result = $query->get_result()->fetch_array();
      $office_name = $result['office_name']??'';
      
    //   echo 'hh';
    //   echo $office_name;
    //   die;

      ?>
      <img src="../upload/<?php echo $org_logo; ?>" alt="logo"> <span style="font-size:20px;"><?php echo $org_name; ?></span>
    </div>



    <!-- Navbar Right Menu-->
    <ul class="app-nav">
      <li class="app-search">
        <!-- clock  -->
        <?php
        date_default_timezone_set('UTC');
        ?>
        <script>
          var d = new Date(<?php echo time() * 1000 ?>);

          function digitalClock() {
            d.setTime(d.getTime() + 1000);
            var hrs = d.getHours();
            var mins = d.getMinutes();
            var secs = d.getSeconds();
            mins = (mins < 10 ? "0" : "") + mins;
            secs = (secs < 10 ? "0" : "") + secs;
            var apm = (hrs < 12) ? "am" : "pm";
            hrs = (hrs > 12) ? hrs - 12 : hrs;
            hrs = (hrs == 0) ? 12 : hrs;
            var ctime = hrs + ":" + mins + ":" + secs + " " + apm;
            document.getElementById("clock").firstChild.nodeValue = ctime;
          }
          window.onload = function() {
            digitalClock();
            setInterval('digitalClock()', 1000);
          }
        </script>
        <div id="clock"> </div>
      </li>
      <!-- User Menu-->
      <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="page-user.php"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
          <li><a class="dropdown-item" href="../menu_role/user_password_change.php"><i class="fa fa-key fa-lg"></i> Change Password</a></li>
          <li><a class="dropdown-item" href="../logout.php"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
        </ul>
      </li>
    </ul>
  </header>