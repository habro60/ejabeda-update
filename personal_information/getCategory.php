<?php
require "../auth/auth.php";
require "../database.php";
if (!empty($_POST['account'])) {
    $account = $_POST['account'];
    $owner_rec_id= $_SESSION['link_id'];
    $selectQuery = "SELECT id, acc_head, category_code  FROM `personel_account` WHERE id='$account' and owner_rec_id=$owner_rec_id";
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
