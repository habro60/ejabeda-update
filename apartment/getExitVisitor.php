<?php
require "../database.php";
if (isset($_POST['id'])) {
  $id = $_POST['id'];
  $query = "UPDATE `apart_visitor_info` set `visitor_exit_dtime`=now(), `status`='1',ss_modified_on=now() WHERE id ='$id'";
  $conn->query($query);
}