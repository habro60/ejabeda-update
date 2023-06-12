<?php
require "../auth/auth.php";
require "../database.php";

if (!empty($_GET['desig_code_soft'])) {
    $id = $_GET['desig_code_soft'];
    $selectQuery = "SELECT * FROM hr_desig WHERE desig_code = '$id'";
    $result = mysqli_query($conn, $selectQuery);
    $data = mysqli_fetch_assoc($result);

    echo $data['grade_code'];

    
}
