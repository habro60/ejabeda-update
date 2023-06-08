<?php






	if ($_SESSION['org_no'] == '1000000000') {
   $conn = new mysqli("localhost","root","","ejabeda_green_daru_apart");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost; dbname=ejabeda_banik;', 'root', '');
	$connect->exec("set names utf8");
  } elseif ($_SESSION['org_no'] == '1500000000') {
    $conn = new mysqli("localhost","root","","ejabeda_habro");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost; dbname=ejabeda_habro;', 'root', '');
	$connect->exec("set names utf8");
  } elseif ($_SESSION['org_no'] == '1600000000') {
    $conn = new mysqli("localhost","root","","ejabeda_15eng");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost; dbname=ejabeda_15eng;', 'root', '');
	$connect->exec("set names utf8");
  } elseif ($_SESSION['org_no'] == '1700000000') {
    $conn = new mysqli("localhost","root","","ejabeda_banik");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost; dbname=ejabeda_banik;', 'root', '');
	$connect->exec("set names utf8");
  }elseif ($_SESSION['org_no'] == '1900000000') {
    $conn = new mysqli("localhost","root","","ejabeda_hashem");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost; dbname=ejabeda_hashem;', 'root', '');
	$connect->exec("set names utf8");
  }elseif ($_SESSION['org_no'] == '2000000000') {
    $conn = new mysqli("localhost","root","","ejabeda_darululo_dhaka");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost; dbname=ejabeda_darululo_dhaka;', 'root', '');
	$connect->exec("set names utf8");
  }elseif ($_SESSION['org_no'] == '5000000000') {
    $conn = new mysqli("localhost","root","","ejabeda_demo");
	$conn->set_charset("utf8");
	$connect = new PDO('mysql:host=localhost; dbname=ejabeda_demo;', 'root', '');
	$connect->exec("set names utf8");
  }
	?>

