<?php
	$conn = new mysqli("localhost:3306","ejabeda_green_da","G10iiil@kwq98@P*8","ejabeda_green_daru_apart");

	$conn->set_charset("utf8");
	
	

	$connect = new PDO('mysql:host=localhost:3306; dbname=ejabeda_green_daru_apart;', 'ejabeda_green_da', 'G10iiil@kwq98@P*8');
	$connect->exec("set names utf8");
	
	
?>