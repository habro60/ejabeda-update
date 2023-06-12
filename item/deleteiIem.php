<?php
require "../auth/auth.php";
require '../database.php';

if (isset($_GET['id'])) {
    $deleteQuery = "delete from item where id='" . $_GET['id'] . "' limit 1";
    //echo $deleteQuery;
    $conn->query($deleteQuery);
    if ($conn->affected_rows == 1) {
        header('location:item.php');
    }
}
