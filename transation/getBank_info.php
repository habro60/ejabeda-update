<?php
   require "../auth/auth.php";
    require "../database.php";
if (! empty($_POST["acc_code"])) {
    $query = "SELECT * FROM bank_acc_info WHERE gl_acc_code = '" . $_POST["acc_code"] . "'";
    $results = $conn->query($query);
    ?>
<option value disabled selected>Select Bank Account</option>
<?php
 while ($District = $results->fetch_assoc()) {        ?>
<option value="<?php echo $District["bank_acc_no"]; ?>"><?php echo $District["acc_name"]; ?></option>
<?php
    }
}
?>
