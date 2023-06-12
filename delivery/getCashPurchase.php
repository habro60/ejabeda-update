<?php
require "../auth/auth.php";
require "../database.php";
if (!empty($_POST['to_account'])) {
    $to_account = $_POST['to_account'];
    $selectQuery = "SELECT acc_code, acc_head, acc_type  FROM `gl_acc_code` WHERE acc_code='$to_account'";
    $result =  $conn->query($selectQuery);
    if ($result->num_rows) {
        while ($data = $result->fetch_assoc()) {
            echo $data['acc_type'];
        }
    }
}
if (!empty($_POST['to_account_chq'])) {
    $to_account_chq = $_POST['to_account_chq'];
    $selectQuery = "SELECT acc_code, acc_head, acc_type  FROM `gl_acc_code` WHERE acc_code='$to_account_chq'";
    $result =  $conn->query($selectQuery);
    $data = $result->fetch_assoc();
    if ($result->num_rows) {
        if ($data['acc_type'] == '2') {
            $selectChque = "SELECT bank_acc_info.gl_acc_code, bank_acc_info.bank_acc_no,bank_chq_leaf_info.account_no, bank_chq_leaf_info.chq_leaf_no, bank_chq_leaf_info.leaf_status FROM `bank_acc_info`,bank_chq_leaf_info WHERE `gl_acc_code`='$to_account_chq' AND bank_chq_leaf_info.leaf_status='0' AND bank_acc_info.bank_acc_no=bank_chq_leaf_info.account_no;";
            $resultChque =  $conn->query($selectChque);
            $num =  $resultChque->num_rows;
            if ($num > 0) {
                while ($rows = $resultChque->fetch_assoc()) {
?>
                    <option value="<?php echo $rows["chq_leaf_no"]; ?>"><?php echo $rows["chq_leaf_no"]; ?></option>
    <?php
                }
            }
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
if (!empty($_POST['cust_id'])) {
    $id = $_POST['cust_id'];
    $selectQuery = "SELECT DISTINCT cust_order_no, order_from FROM `cust_order_info` WHERE order_from ='$id'";
    $result = mysqli_query($conn, $selectQuery);
    ?>
    <option value="">-Select indent Number-</option>
    <?php
    while ($data = mysqli_fetch_assoc($result)) {
    ?>
        <option value="<?php echo $data["cust_order_no"]; ?>"><?php echo $data["cust_order_no"]; ?></option>
<?php
    };
}
?>
<?php
$output = '';
if (!empty($_POST['indent_no'])) {
    $id = $_POST['indent_no'];
    $selectQuery = "SELECT DISTINCT indent_info.indent_no, indent_info.indent_from, indent_info.item_no, indent_info.item_qty, indent_info.unit_price, indent_info.exp_tot_amt_loc,indent_info.delivery_qty, indent_info.due_qty, item.item_name, item.unit, code_master.hardcode, code_master.softcode, code_master.description FROM `indent_info`, item, code_master WHERE code_master.hardcode='UCODE' AND code_master.softcode =item.unit AND indent_info.item_no=item.id AND indent_info.indent_no ='$id' AND indent_info.due_qty!='0'";
    $result = mysqli_query($conn, $selectQuery);
?>
    <?php
    while ($data = mysqli_fetch_assoc($result)) {
    ?>
        <tr>
            <input type="hidden" name="item_no[]" class="form-control item_no" value="<?php echo $data["item_no"]; ?>" readonly>
            <td><input type="text" class="form-control" value="<?php echo $data["item_name"]; ?>" readonly></td>
            <input type="hidden" name="item_unit[]" class="form-control item_no" value="<?php echo $data["softcode"]; ?>" readonly>
            <td><input type="text" value="<?php echo $data["description"]; ?>" class="item_unit form-control" readonly></td>
            <!-- total qty -->
            <td><input type="text" class="form-control" name="due_qty[]" id="due_qty<?php echo $data['item_no']; ?>" value="<?php echo $data["item_qty"]; ?>" readonly></td>
            <!-- delivery_qty -->
            <td hidden><input type="text" class="form-control" name="delivery_qty[]" id="delivery_qty<?php echo $data['item_no']; ?>" value="<?php echo $data["delivery_qty"]; ?>" readonly></td>
            <!-- due_qty -->
            <td><input type="text" class="form-control" name="item_qty2[]" id="item_qty2<?php echo $data['item_no']; ?>" value="<?php echo $data["due_qty"]; ?>" readonly></td>
            <!-- delivery quantity -->
            <td><input type="text" name="item_qty[]" id="item_qty1<?php echo $data['item_no']; ?>" data-srno="1" class="item_qty form-control" value="<?php echo $data["due_qty"]; ?>" onkeyup="unitPrice('<?php echo $data['item_no']; ?>')" /></td>
            <!-- ! -->
            <td><input type="text" name="unit_price_loc[]" id="unit_price_loc1<?php echo $data['item_no']; ?>" data-srno="1" class="unit_price_loc form-control" value="<?php echo $data["unit_price"]; ?>" readonly /></td>
            <td><input type="text" name="total_price[]" id="total_price1<?php echo $data['item_no']; ?>" data-srno="1" value="" class="total_price form-control" readonly /></td>
        </tr>
<?php
    };
}
?>
<?php
if (!empty($_POST['item_no_deli'])) {
    $id = $_POST['item_no_deli'];
    $selectQuery = "SELECT * FROM invoice_detail WHERE order_type='PVC' AND item_no='$id'";
    $result = mysqli_query($conn, $selectQuery);
    $data = mysqli_fetch_assoc($result);
    echo $data['unit_price_loc'];
    // echo $data['unit'];
}

?>