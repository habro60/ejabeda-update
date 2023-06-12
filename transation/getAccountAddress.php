<?php
     require "../auth/auth.php";
    include_once '../database.php';

if (!empty($_POST['to_account'])) {
    $to_account = $_POST['to_account'];
    $selectQuery = "SELECT acc_code, acc_head, acc_type, category_code  FROM `gl_acc_code` WHERE acc_code='$to_account'";
    $result =  $conn->query($selectQuery);
    if ($result->num_rows) {
        while ($data = $result->fetch_assoc()) {
            echo $data['category_code'];
        }
    }
}
?>