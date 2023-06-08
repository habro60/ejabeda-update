<?php
require "../auth/auth.php";
require "../database.php";
/*
** Flat Update  
*/
if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $owner_id = $_POST['owner_id'];
        $updateQuery = "UPDATE `flat_info` SET owner_id='$owner_id', flat_status='1', `status_date`=now(), `ss_modifier`='abdullah',`ss_modified_on`=now() WHERE id='$id'";
        if ($conn->query($updateQuery)) {
            echo 1;
        } else {
            echo 0;
        }

        $id = $_POST['id'];
        $flat_no = $_POST['flat_no'];
        $owner_id = $_POST['owner_id'];
        $updateOwner = "UPDATE `apart_owner_info` SET flat_no='$flat_no', `ss_modifier`='abdullah',`ss_modified_on`=now() WHERE owner_id='$owner_id'";
        if ($conn->query($updateOwner)) {
            echo 1;
        } else {
            echo 0;
        }
    }
