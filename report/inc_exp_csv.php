<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_GET['from']) && isset($_GET['to'])) {
    $startdate = $_GET['from'];
    $enddate = $_GET['to'];
    $org_name = $_SESSION['org_name'];
    $org_logo = $_SESSION['org_logo'];

}
?>