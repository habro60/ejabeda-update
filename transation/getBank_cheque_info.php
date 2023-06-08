<?php
   require "../auth/auth.php";
   require "../database.php";
if (! empty($_POST["bank_acc_no"])) {
    $query = "SELECT * FROM bank_chq_leaf_info WHERE account_no = '" . $_POST["bank_acc_no"] . "' AND leaf_status=0";
    $results = $conn->query($query);
    ?>
<option value disabled selected>Select Cheque No</option>
<?php
 while ($chk = $results->fetch_assoc()) {      
echo '<option value="'.$chk['chq_leaf_no'].'">'.$chk["chq_leaf_no"].'</option>';  

    }
}
?>