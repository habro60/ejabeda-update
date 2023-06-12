<?php
// $connect = new PDO('mysql:host=localhost; dbname=darululo_acc;', 'darululo_acc', 'Acc@1234!@#$');
$connect = new PDO('mysql:host=localhost; dbname=acc_management;', 'root', '');
$connect->exec("set names utf8");
	function fill_select_box($connect)
{
 $query = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' ORDER by acc_code";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  $output .= '<option class="select2 form-control" value="'.$row["acc_code"].'">'.$row["acc_head"].'</option>';
 }
 return $output;
}
function fill_select_boxs($connect)
{
 $query = "SELECT * FROM `item`";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  $output .= '<option class="form-control" value="'.$row["id"].'">'.$row["item_name"].'</option>';
 }
 return $output;
}
?>