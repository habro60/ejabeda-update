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
    <!-- <link href="../assets/css/bootstrap.min.css" rel="stylesheet"> -->
    
    <script src="https://kit.fontawesome.com/f826455fa9.js" crossorigin="anonymous"></script>

    <title>Vehicle Movement Register</title>
  </head>
  <body>


  <main class="app-content">
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">

                <h3 class="card-title">Vehicle Movement Register</h3>
                <div class="container">
                    <div style="text-align: right;">
                        <a href="#addModal" data-toggle="modal" class="btn btn-outline-success btn-sm text-right">
                            <i class="fas fa-plus-circle fa-w-20"></i><span> IN</span>
                        </a>

                        
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-hover table-bordered table-sm" id="studentTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                        <th>SL NO</th>
                        <th>IN Time</th>
                        <th>Time Calculate</th>
                        <th>Token No</th>
                        <th>Car No</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                            <?php

                                $counter = 0;

                                //$query = "SELECT d.*,p.* FROM driver_info d,parking_lots_info p WHERE d.car_reg_no=p.id";
                                // $query ="SELECT car_mov_reg.id as cid,car_mov_reg.in_time,car_mov_reg.car_reg_no, parking_lots_info.id,parking_lots_info.car_reg_no
                                // FROM car_mov_reg
                                // INNER JOIN parking_lots_info ON car_mov_reg.car_reg_no=parking_lots_info.id where status='';";
                                $query ="SELECT * FROM car_mov_reg where status=''";

                                $result = mysqli_query($conn, $query) or die( mysqli_error($conn));

                                while ($row = mysqli_fetch_assoc($result)) {

                                     $date= $row['in_time'];
                                    //$date_1 = date("F j, Y, g:i a", $row['in_time'];
                            ?>

                            <td> <?php echo ++$counter; ?></td>
                            <td><?php echo date('d-M-y g:i a', strtotime($row['in_time']));
                            
                            //$_SESSION['separate_date_time']=date('d-M-y g:i a', strtotime($row['in_time']));
                            
                            ?></td>
                            <td><?php echo timeago($date);
                            
                            
                            
                            ?></td>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['car_reg_no'] ?></td>
                            
                           <td>
                                <a href="#edit<?= $row['id'] ?>" class="btn btn-outline-info btn-sm"
                                data-toggle="modal">OUT</a>

                                   
                            </td>
                          

                        </tr>

                        <?php
                    }
                        
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                        <th>SL NO</th>
                        <th>IN Time</th>
                        <th>Time Calculate</th>
                        <th>Token No</th>
                        <th>Car No</th>
                        <th>Action</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>

</main>

    <!-- Add Modal Start -->

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Vehicle Entry</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="../fpdf184/index.php">
                        <div class="mb-3">

                        <input type="text" name="car_reg_no"
                                class="form-control" placeholder="Enter Car Reg No" required>

                        </div>

                        <div class="mb-3">

                        <select class="form-control" name="vehicle_type" required>
                            <option selected>Vehicle Type</option>

                            <?php

                                //$query4 = "SELECT * FROM `driver` d JOIN parking_lots_info p ON d.car_reg_no=p.id";
                                $query = "SELECT * FROM `parking_rate_setup` WHERE parking_rate_setup.vehicle_type=vehicle_type";
                                //$query4 = "SELECT d.* , p.* FROM driver d,parking_lots_info p WHERE d.car_reg_no=p.id";

                                $result = mysqli_query($conn, $query) or die( mysqli_error($conn));

                                while ($row = mysqli_fetch_assoc($result)) {

                            ?>

                            <option value="<?php echo $row['id'] ?>"><?php echo $row['vehicle_type'] ?></option>
                            
                            <?php } ?>

                        </select>

                        </div>

                        <button type="submit" name="addVehicleEntry" class="btn btn-primary btn-sm">Submit</button>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Add Modal End -->



    <!-- Edit Modal Start -->

    <?php

        $query = "SELECT * FROM `car_mov_reg`";

        $result = mysqli_query($conn, $query) or die( mysqli_error($conn));

        while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['id'];

        $query2 = "SELECT * FROM `car_mov_reg` WHERE `id`='$id'";
        
        $result2 = mysqli_query($conn, $query2) or die( mysqli_error($conn));
    
        $updateResult = mysqli_fetch_assoc($result2);

    ?>

    <div class="modal fade" id="edit<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Vehicles OUT</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="../fpdf184/out.php">

                        <div class="mb-3">

                            <label for="id">Token No</label>

                                <input type="number" name="id" value="<?= $updateResult['id'] ?>"
                                    class="form-control" readonly>
                                <input type="hidden" name="car_reg_no" value="<?= $updateResult['car_reg_no'] ?>"
                                    class="form-control" readonly>
                        </div>

                        <!-- <div class="mb-3">

                            <label for="id">Vehicle IN Time</label>

                                <input type="text" name="in_time" value="<?= $updateResult['in_time'] ?>"
                                    class="form-control" readonly>
                        </div> -->
                        <!-- <div class="mb-3">

                        <label>Current Status</label>
							<input type="text" class="form-control" value="<?php if($updateResult['status']==""){ echo "Vehicle In"; } if($updateResult['status']=="Out"){echo "Vehicle out";} ;?>" name="status" readonly>
                        </div> -->

                        <div class="form-group">
                            <label>Out Status</label>
                            <select name="status" class="form-control" required="true" >
                                <option value="Out">Outgoing Vehicle</option>
                            </select>
                        </div>

                       
                        <button type="submit" name="updateOutVehicle" class="btn btn-primary btn-sm">Submit For Out-Going</button>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>


    <?php

        }

        
            
    ?>

    <!-- Edit Modal End -->
    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <!-- <script src="../assets/js/bootstrap.bundle.min.js"></script> -->

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
    </script> -->

    <!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<!-- Data table plugin-->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $('#studentTable').DataTable();
  $('#exitTable').DataTable();
</script>
<!-- script  -->


    <!-- <script>
    $(document).ready(function() {
        $('#studentTable').DataTable();
    });
    $(document).ready(function() {
        $('#exitTable').DataTable();
    });
    </script> -->

  </body>
</html>