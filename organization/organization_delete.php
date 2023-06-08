<?php
if (isset($_POST['id'])) {
    require '../database.php';
    $id = intval($_POST['id']);
    $deleteQuery = "delete from `org_info` where org_no='$id' limit 1";
    $conn->query($deleteQuery);
    if ($conn->affected_rows == 1) {
        $response['status']  = 'success';
        $response['message'] = 'Product Deleted Successfully ...';
    } else {
        $response['status']  = 'error';
        $response['message'] = 'Unable to delete product ...';
    }
    echo json_encode($response);
}
?>
