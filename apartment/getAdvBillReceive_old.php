<?php
require "../auth/auth.php";
require "../database.php";

if (!empty($_POST['by_account'])) {
    $by_account = $_POST['by_account'];
    $selectQuery = "SELECT flat_info.owner_id, flat_info.flat_no, apart_owner_info.owner_id FROM `flat_info`, apart_owner_info where flat_info.owner_id=apart_owner_info.owner_id and  apart_owner_info.gl_acc_code='$by_account'";
    $result = mysqli_query($conn, $selectQuery);
    ?>
    <option value="">-Select flat Number-</option>
    <?php
    while ($data = mysqli_fetch_assoc($result)) {
    ?>
        <option value="<?php echo $data["flat_no"]; ?>"><?php echo $data["flat_no"]; ?></option>
<?php
    };
}
?>

<?php
if (!empty($_POST['flat_no'])) {
    $$id = $_POST['flat_no'];
    $selectQuery = "SELECT flat_no, owner_id  FROM `flat_info` where flat_no='$id'";
    $result =  $conn->query($selectQuery);
    if ($result->num_rows) {
        while ($row = $result->fetch_assoc()) {
            echo $row['owner_id'];
        }
    }
}
?>

<?php
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



if (!empty($_GET['bill_charge_code_soft'])) {
    $id = $_GET['bill_charge_code_soft'];
    $selectQuery = "SELECT * FROM apart_bill_charge_setup WHERE bill_charge_code='$id'";
    $result = mysqli_query($conn, $selectQuery);
    $data = mysqli_fetch_assoc($result);
    if ($data['link_gl_acc_code']) {
        $linkGlCode = $data['link_gl_acc_code'];
        $sql = "SELECT acc_code, acc_head FROM gl_acc_code WHERE acc_code ='$linkGlCode'";
        $query = $conn->query($sql);
        $row = $query->fetch_assoc();

        echo $row['acc_code'];
    }
        
    }

if (!empty($_GET['bill_charge_code_des'])) {
    $id = $_GET['bill_charge_code_des'];
    $selectQuery = "SELECT * FROM apart_bill_charge_setup WHERE bill_charge_code='$id'";
    $result = mysqli_query($conn, $selectQuery);
    $data = mysqli_fetch_assoc($result);
    if ($data['link_gl_acc_code']) {
        $linkGlCode = $data['link_gl_acc_code'];
        $sql = "SELECT acc_code, acc_head FROM gl_acc_code WHERE acc_code ='$linkGlCode'";
        $query = $conn->query($sql);
        $row = $query->fetch_assoc();

        echo $row['acc_head'];
    }
    }

    if (!empty($_GET['bill_charge_code_name'])) {
        $id = $_GET['bill_charge_code_name'];
        $selectQuery = "SELECT bill_charge_code, bill_charge_name  FROM apart_bill_charge_setup WHERE bill_charge_code='$id'";
        $result = mysqli_query($conn, $selectQuery);
        $data = mysqli_fetch_assoc($result);
            echo $data['bill_charge_name'];
        }    
    
?>
<?php
// code check from bill  Month
if(!empty($_POST["Fmth"])) {
    $inputMth=0;
    $tableMth=0;
    $id= $_POST["flatno"];
    $month=$_POST["Fmth"];
    $inputMth = $month.substr(0,7);
	$sql="SELECT max(bill_for_month) as pmonth FROM apart_owner_bill_detail where flat_no ='$id'";
	$query = mysqli_query( $conn, $sql);
    $rows = $query->fetch_assoc();
    $datamth = $rows['pmonth'];
    $tableMth = $datamth.substr(0,7);
     if ($tableMth >= $inputMth)  echo 5; // "<span style='color:red'> This month bill  Already process .</span>"
	else echo "<span style='color:green'> (Month ok)</span>";

}
?>