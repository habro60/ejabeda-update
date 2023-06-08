<?php

	if ($_SESSION['org_no'] == '1000000000') {
   $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_green_daru_apart");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_green_daru_apart;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

}elseif ($_SESSION['org_no'] == '1100000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_vorosha");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_vorosha;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");
	
	} elseif ($_SESSION['org_no'] == '1200000000') {
   $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_kah_high_school");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_kah_high_school;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

 } elseif ($_SESSION['org_no'] == '1300000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_sheltech");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_sheltech;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

}elseif ($_SESSION['org_no'] == '1400000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_pastry_ghar");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_pastry_ghar;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");
	
  } elseif ($_SESSION['org_no'] == '1500000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_habro");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_habro;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

  } elseif ($_SESSION['org_no'] == '1600000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_15eng");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_15eng;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

  
  }elseif ($_SESSION['org_no'] == '1700000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_landmark_Apt");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_landmark_Apt;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");
 
  }elseif ($_SESSION['org_no'] == '1800000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_banik");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_banik;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

  }elseif ($_SESSION['org_no'] == '1900000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_hashem");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_hashem;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

  }elseif ($_SESSION['org_no'] == '2000000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_darululo_dhaka");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_darululo_dhaka;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

}elseif ($_SESSION['org_no'] == '2100000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_karna_ind");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_karna_ind;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");

}elseif ($_SESSION['org_no'] == '2200000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_rupganj_somaj");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_rupganj_somaj;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");
	
  }elseif ($_SESSION['org_no'] == '5000000000') {
    $conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_demo");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_demo;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");
  }
  
	?>

