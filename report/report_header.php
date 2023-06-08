 <!-- ==================================
File Name: gl_ledger.php
Description: Create general ledger .
Featheure: 
Create Date: 30-11-2019
Create by: Mohammad Ali Abdullah.
phone : 01849378511.
Protect by: Habro Systems Limited..
======================================== -->
 <?php
    if (isset($_POST['submit'])) {
        $startdate = $_POST['startdate'];
        $enddate = $conn->escape_string($_POST['enddate']);
        $org_fin_month =  $_SESSION["org_fin_month"];
        
    }
    ?>
 <?php
    $sql2 = "SELECT `org_logo`, `org_name` FROM `org_info`";

    $returnD = mysqli_query($conn, $sql2);
    $result = mysqli_fetch_assoc($returnD);

    ?>
 <div>
     <h2 style="text-align:center"><img src="../upload/<?php echo $result['org_logo']; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $result['org_name']; ?></h2>
 </div>