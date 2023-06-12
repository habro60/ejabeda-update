<?php 
require_once("../database.php");
require_once("../auth/auth.php");
// require "../database.php";
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $ss_modifier =$_SESSION['username'];  
    
    $query = "update apart_visitor_info set visitor_exit_dtime=now(), ss_modified_on=now()  where id ='$id'";
    $conn->query($query);

header('refresh:2;visitor_info.php');

  }
  ?>