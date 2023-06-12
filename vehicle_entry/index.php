<?php

require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
require '../source/sidebar.php';
require '../source/header.php';

// if (isset($_POST['addVehicleEntry'])) {

//     $vehicle_type = $_POST['vehicle_type'];
//     $car_reg_no = $_POST['car_reg_no'];
//     $ss_creator = $_SESSION['username'];
//     $ss_modifier = $_SESSION['username'];

//     $query2 = mysqli_query($conn, "SELECT * FROM `car_mov_reg` WHERE car_reg_no='$car_reg_no'") or die( mysqli_error($conn));

//     if (mysqli_num_rows($query2) > 0) {
//         $error = "Car Reg Duplicate Data !..";
//     }else{

//     $query = "INSERT INTO `car_mov_reg`(`vehicle_type`,`car_reg_no`,`ss_creator`,`ss_modifier`) VALUES ('$vehicle_type','$car_reg_no','$ss_creator','$ss_modifier')";
    
//     $result = mysqli_query($conn, $query) or die( mysqli_error($conn));

//     if ($result) {
//         $success = "Data Save Successfully!..";
//     }else{
//         $error = "Data Not Save!..";
//     }

// }

//     //header('location:/carparking/index.php');
//     //echo "<meta http-equiv=\"refresh\" content=\"0;URL=../dashboard/\">";
    
// }

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

    <title>Vehicle Entry</title>
  </head>
  <body>


  <main class="app-content">
        <div class="card">
            <div class="card-header">

                <h3 class="card-title">Vehicle Entry</h3>

            </div>

            <div class="card-body">
                <form method="post" action="create.php">
                <div class="mb-3">

                    <select class="form-select" name="car_reg_no" required>
                        <option selected>Car Reg No</option>

                        <?php

                            //$query4 = "SELECT * FROM `driver` d JOIN parking_lots_info p ON d.car_reg_no=p.id";
                            $query4 = "SELECT * FROM `parking_lots_info` WHERE parking_lots_info.car_reg_no=car_reg_no";
                            //$query4 = "SELECT d.* , p.* FROM driver d,parking_lots_info p WHERE d.car_reg_no=p.id";

                            $result4 = mysqli_query($conn, $query4) or die( mysqli_error($conn));

                            while ($driver_car_reg_no = mysqli_fetch_assoc($result4)) {

                        ?>

                        <option value="<?php echo $driver_car_reg_no['id'] ?>"><?php echo $driver_car_reg_no['car_reg_no'] ?></option>
                        
                        <?php } ?>

                    </select>

                </div>

                <div class="mb-3">

                    <select class="form-select" name="vehicle_type" required>
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
                    
                    
                    <button type="submit" name="addVehicleEntry" class="btn btn-primary btn-sm">Entry</button>
                </form>
            </div>
        </div>
</main>

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