<?php

require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
require '../source/sidebar.php';
require '../source/header.php';

function timeago($datetime, $full = false) {
    date_default_timezone_set('Asia/Dhaka');
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
    'y' => 'yr',
    'm' => 'mon',
    'w' => 'week',
    'd' => 'day',
    'h' => 'hr',
    'i' => 'min',
    's' => 'sec',
    );
    foreach ($string as $k => &$v) {
    if ($diff->$k) {
        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } 
    else {
        unset($string[$k]);
    }
    }
    if (!$full) {
    $string = array_slice($string, 0, 1);
    }
    
    return $string ? implode(', ', $string) . '' : 'just now';
}


?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://kit.fontawesome.com/f826455fa9.js" crossorigin="anonymous"></script>

    <title>Vehicles OUT</title>
  </head>
  <body>


  <main class="app-content">
        <div class="card">
            <div class="card-header">

                <h3 class="card-title">Vehicles OUT</h3>

                <div class="container">
                    <div style="text-align: right;">
                        <a href="javascript:avoid(0)" class="btn btn-outline-success btn-sm text-right" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fas fa-plus-circle fa-w-20"></i><span> ADD</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="studentTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                        <th>SL NO</th>
                        <th>IN Time</th>
                        <th>Out Time</th>
                        <th>Token No</th>
                        <th>Parking Charge</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php

                        $counter = 0;

                        // $hour_diff=mysqli_query($conn,"SELECT CONCAT(MOD(HOUR(TIMEDIFF(`in_time`,`out_time`)), 24)) AS difference from car_mov_reg");


                        // $cid=$_GET['viewid'];
                        
                        $ret=mysqli_query($conn,"SELECT id,in_time,out_time,total_parking_cost, CONCAT( FLOOR(HOUR(TIMEDIFF(`in_time`,`out_time`)) / 24), ' DAYS ',MOD(HOUR(TIMEDIFF(`in_time`,`out_time`)), 24), ' HOURS ',
                        MINUTE(TIMEDIFF(`in_time`,`out_time`)), ' MINUTES ') AS difference from car_mov_reg where status='Out'");
                    
                        while ($row=mysqli_fetch_array($ret)) {

                            $date= $row['in_time'];
                            $date2= $row['out_time'];
                            $time_diff= $row['difference'];

                    ?>

                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo date('d-M-y g:i a', strtotime($row['in_time'])) ?></td>
                    <td><?php echo date('d-M-y g:i a', strtotime($row['out_time'])) ?></td>
                    <td><?php echo $row['id'] ?></td>
                    <!-- <td><?php echo (strtotime($date2)-strtotime($date))/3600 ?></td> -->

                    <td>
                    <?php 
                    
                    if ($time_diff<'0 DAYS 0 HOURS 60 MINUTES') {
                       // echo "ek gontar kom 20 taka";
                        echo ( strtotime($date2) - strtotime($date))/3600;
                       // echo 20;
                    }elseif ($time_diff<'0 DAYS 24 HOURS 60 MINUTES') {
                         //echo "ek gontar beshi 40 taka";
                         //echo strtotime($date)-strtotime($date2);
                       echo ( strtotime($date2) - strtotime($date) ) / 3600;
                         //echo round((strtotime($date2)-strtotime($date))/3600);
                        //echo "my result is: $hour_diff.";
                    }elseif ($time_diff < '30 DAYS 24 HOURS 60 MINUTES') {
                        echo "ek din beshi 4000 taka";
                    }else {
                        echo "ek month er beshi 00 taka";
                    }
                    
                    ?>
                    </td>

                    <td></td>
                    

                        </tr>

                    <?php } ?>  

                    </tbody>
                    <tfoot>
                        <tr>
                        <th>SL NO</th>
                        <th>IN Time</th>
                        <th>Out Time</th>
                        <th>Token No</th>
                        <th>Parking Charge</th>
                        <th>Action</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
</main>


    <!-- Edit Modal Start -->

    <?php

        $query = "SELECT * FROM `parking_lots_info`";

        $result = mysqli_query($conn, $query) or die( mysqli_error($conn));

        while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['id'];

        $query2 = "SELECT * FROM `parking_lots_info` WHERE `id`='$id'";
        
        $result2 = mysqli_query($conn, $query2) or die( mysqli_error($conn));
    
        $updateResult = mysqli_fetch_assoc($result2);

    ?>

    <div class="modal fade" id="edit<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Parking Lots</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                        <div class="mb-3">

                        <input type="hidden" name="id" value="<?= $updateResult['id'] ?>" class="form-control"
                                required>

                            <input type="text" name="park_lot_no" value="<?= $updateResult['park_lot_no'] ?>"
                                class="form-control" placeholder="Enter Parking Lot No" required>
                        </div>
                        <div class="mb-3">

                            <select class="form-select" name="flat_no" required>
                                <option selected>Flat No</option>

                                <?php

                                    //$query4 = "SELECT * FROM `driver` d JOIN parking_lots_info p ON d.car_reg_no=p.id";
                                    //$query4 = "SELECT * FROM `flat_info` WHERE flat_info.flat_no=flat_no";
                                    //$query4 = "SELECT d.* , p.* FROM driver d,parking_lots_info p WHERE d.car_reg_no=p.id";

                                    $result41 = mysqli_query($conn, "SELECT * FROM `flat_info` WHERE flat_info.flat_no=flat_no") or die( mysqli_error($conn));

                                    while ($update_flat_no = mysqli_fetch_assoc($result41)) {
   
                                ?>

                                <option value="<?= $update_flat_no['id']; ?>" <?php echo $update_flat_no['id'] == $updateResult['flat_no'] ? 'selected' : ''?>><?php echo $update_flat_no['flat_no'] ?></option>
                                
                                <?php } ?>

                            </select>
                            
                        </div>
                        <div class="mb-3">
                            <input type="text" name="car_reg_no" value="<?= $updateResult['car_reg_no'] ?>" placeholder="Enter Car Reg No" class="form-control"
                                    required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="col-12" for="lot_type">Lot Type:</label>

                            <input type="radio" name="lot_type" value="Resident" required <?= $updateResult['lot_type']=="Resident" ? "checked" : ""?> > Resident
                            <input type="radio" name="lot_type" value="Non Resident" required <?= $updateResult['lot_type']=="Non Resident" ? "checked" : ""?> > Non Resident

                           
                        </div>

                        <button type="submit" name="updateParkingLots" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php

        }

        if (isset($_POST['updateParkingLots'])) {
            $id   = $_POST['id'];
            $park_lot_no = $_POST['park_lot_no'];
            $lot_type = $_POST['lot_type'];
            $flat_no = $_POST['flat_no'];
            $car_reg_no = $_POST['car_reg_no'];
            $ss_creator = $_SESSION['username'];
            $ss_modifier = $_SESSION['username'];
           //$ss_org_no = $_POST['ss_org_no'];
            $ss_org_no = $_SESSION['org_no'];
        
            $query3 = "UPDATE `parking_lots_info` SET `park_lot_no`='$park_lot_no',`lot_type`='$lot_type',`flat_no`='$flat_no',`car_reg_no`='$car_reg_no',`ss_creator`='$ss_creator',`ss_modifier`='$ss_modifier',`ss_org_no`='$ss_org_no' WHERE  `id`='$id'";
            
            mysqli_query($conn, $query3) or die( mysqli_error($conn));
        
            //header("location:index.php");
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
            
        }
            
    ?>

    <!-- Edit Modal End -->

    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
    </script>


    <script>
    $(document).ready(function() {
        $('#studentTable').DataTable();
    });
    </script>

  </body>
</html>