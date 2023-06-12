<?php
require "../auth/auth.php";
require "../database.php";
if (!empty($_POST['by_account'])) {
    $by_account = $_POST['by_account'];
    $selectQuery = "SELECT acc_code, acc_head, acc_type  FROM `gl_acc_code` WHERE acc_code='$by_account'";
    $result =  $conn->query($selectQuery);
    if ($result->num_rows) {
        while ($data = $result->fetch_assoc()) {
            echo $data['acc_type'];
        }
    }
}
if (!empty($_GET['item_no_soft'])) {
    $id = $_GET['item_no_soft'];
    $selectQuery = "SELECT * FROM item WHERE id='$id'";
    $result = mysqli_query($conn, $selectQuery);
    $data = mysqli_fetch_assoc($result);
    if ($data['unit']) {
        $softcode = $data['unit'];
        $sql = "SELECT * FROM code_master WHERE hardcode='UCODE' AND softcode='$softcode'";
        $query = $conn->query($sql);
        $row = $query->fetch_assoc();
        
        echo $row['softcode'];
    }
}
if (!empty($_GET['item_no_des'])) {
    $id = $_GET['item_no_des'];
    $selectQuery = "SELECT * FROM item WHERE id='$id'";
    $result = mysqli_query($conn, $selectQuery);
    $data = mysqli_fetch_assoc($result);
    if ($data['unit']) {
        $softcode = $data['unit'];
        $sql = "SELECT * FROM code_master WHERE hardcode='UCODE' AND softcode='$softcode'";
        $query = $conn->query($sql);
        $row = $query->fetch_assoc();
        
        echo $row['description'];
    }
}
// unit row description

if (!empty($_GET['item'])) {
    $id = $_GET['item'];
    $selectQuery = "SELECT * FROM item WHERE id='$id'";
    $result = mysqli_query($conn, $selectQuery);
    $data = mysqli_fetch_assoc($result);
    if ($data['unit']) {
        $softcode = $data['unit'];
        $sql = "SELECT * FROM code_master WHERE hardcode='UCODE' AND softcode='$softcode'";
        $query = $conn->query($sql);
        $row = $query->fetch_assoc();
        $response = $row;
        echo $row['description'];
    }
}

// end unit row 

// unit row code

if (!empty($_GET['item_code'])) {
    $id = $_GET['item_code'];
    $selectQuery = "SELECT * FROM item WHERE id='$id'";
    $result = mysqli_query($conn, $selectQuery);
    $data = mysqli_fetch_assoc($result);
    if ($data['unit']) {
        $softcode = $data['unit'];
        $sql = "SELECT * FROM code_master WHERE hardcode='UCODE' AND softcode='$softcode'";
        $query = $conn->query($sql);
        $row = $query->fetch_assoc();
        $response = $row;
        echo $row['softcode'];
    }
}

// end unit code 
