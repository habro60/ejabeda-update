<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ejabeda</title>
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="../css/main.css">
  <!-- additional css  -->
  <link rel="stylesheet" href="../css/style.css">
  <!-- hoiliday style  -->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- sweet alart  -->
  <link rel="stylesheet" href="../css/jquery.toast.css">
  <!-- <script src="../js/sweetalert/sweetalert.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>


  <!-- bkash script   -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script id="myScript" src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- bkash script   -->


  <?php
  function auth_page($conn, $pid, $role_no)
  {
    $sql = "select menu_no from sm_role_dtl where role_no=$role_no and menu_no=$pid and active_stat=1";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    if ($row['menu_no'] == $pid) {
    } else {
      header("location:../index.php");
      exit('Authorization not found!!');
    }
  }
  ?>