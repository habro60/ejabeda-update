<?php
require "../auth/auth.php";
require "../database.php";
if (!empty($_POST['to_account'])) {
    $to_account = $_POST['to_account'];
    $selectQuery = "SELECT id, acc_head, category_code  FROM `personel_account` WHERE id='$to_account'";
    $result =  $conn->query($selectQuery);
    echo $selectQuery;
    exit;
    if ($result->num_rows) {
        while ($data = $result->fetch_assoc()) {
            echo $data['category_code'];
        }
    }
}
?>
