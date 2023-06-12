<?php

require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
require '../source/sidebar.php';
require '../source/header.php';

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    
    <script src="https://kit.fontawesome.com/f826455fa9.js" crossorigin="anonymous"></script>

    <title>Parking Rate Setup</title>
  </head>
  <body>


  <main class="app-content">
        <div class="card">
            <div class="card-header">

                <h3 class="card-title">Parking Rate Setup Info</h3>

                <div class="container">
                    <div style="text-align: right;">
                    <a href="#addModal" data-toggle="modal" class="btn btn-outline-success btn-sm text-right">
                            <i class="fas fa-plus-circle fa-w-20"></i><span> ADD</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-hover table-bordered table-sm" id="studentTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>Vehicle Type</th>
                            <th>First_hr_rate</th>
                            <th>Next_hr_rate</th>
                            <th>Day_rate</th>
                            <th>Monthly_rate</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php

                        $counter = 0;

                        
                        
                        // $query4 = "SELECT driver_info.id as did,driver_info.driver_name,driver_info.driver_license_no, parking_lots_info.id,parking_lots_info.car_reg_no
                        // FROM driver_info
                        // INNER JOIN parking_lots_info ON driver_info.car_reg_no=parking_lots_info.id;";
                        //$query = "SELECT d.*,p.* FROM driver_info d,parking_lots_info p WHERE d.car_reg_no=p.id";
                        $query = "SELECT * FROM `parking_rate_setup`";

                        $result = mysqli_query($conn, $query) or die( mysqli_error($conn));

                        while ($row = mysqli_fetch_assoc($result)) {

                        
   
                    ?>

                        <tr>

                            <td>
                                <?php echo ++$counter; ?>
                            </td>
                            <td>
                                <?php echo $row['vehicle_type'] ?>
                            </td>
                            <td>
                                <?php echo $row['first_hr_rate'] ?>
                            </td>
                           
                            <td>
                                <?php echo $row['next_hr_rate'] ?>
                            </td>
                            <td>
                                <?php echo $row['day_rate'] ?>
                            </td>
                            <td>
                                <?php echo $row['monthly_rate'] ?>
                            </td>
                            

                            <td>
                               
                                <a href="#edit<?= $row['id'] ?>" class="btn btn-outline-info btn-sm"
                                data-toggle="modal"><i
                                        class="far fa-edit"></i></a>
                                <a href="delete.php?carDriverInfoDelete=<?= base64_encode($row['id']) ?>"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Are you sure to delete?')"><i
                                        class="far fa-trash-alt"></i></a>
                            </td>

                        </tr>

                        <?php
                    }
                        
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                        <th>SL NO</th>
                        <th>Vehicle Type</th>
                        <th>First_hr_rate</th>
                        <th>Next_hr_rate</th>
                        <th>Day_rate</th>
                        <th>Monthly_rate</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Parking Rate Setup Info</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="create.php">
                        <div class="mb-3">
                            <input type="text" name="vehicle_type" value=""
                                class="form-control" placeholder="Enter Vehicle Type" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="first_hr_rate" value=""
                                class="form-control" placeholder="Enter First Hour Rate">
                        </div>
                        <div class="mb-3">
                            <input type="text" name="next_hr_rate" value=""
                                class="form-control" placeholder="Enter Next Hour Rate" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="day_rate" value=""
                                class="form-control" placeholder="Enter Day Rate" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="monthly_rate" value=""
                                class="form-control" placeholder="Enter Monthly Rate" required>
                        </div>
                       
                        <button type="submit" name="addParkSetupInfo" class="btn btn-primary btn-sm">Submit</button>
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

        $query = "SELECT * FROM `parking_rate_setup`";

        $result = mysqli_query($conn, $query) or die( mysqli_error($conn));

        while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['id'];

        $query2 = "SELECT * FROM `parking_rate_setup` WHERE `id`='$id'";
        
        $result2 = mysqli_query($conn, $query2) or die( mysqli_error($conn));
    
        $updateResult = mysqli_fetch_assoc($result2);

    ?>

    <div class="modal fade" id="edit<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Parking Rate Setup Info</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                        <div class="mb-3">

                        <input type="hidden" name="id" value="<?= $updateResult['id'] ?>" class="form-control"
                                required>
                                <label for="vehicle_type">Vehicle Type</label>
                                <input type="text" name="vehicle_type" value="<?= $updateResult['vehicle_type'] ?>"
                                class="form-control" placeholder="Enter Vehicle Type" required>
                        </div>
                        <div class="mb-3">
                            <label for="first_hr_rate">First Hour Rate</label>
                            <input type="text" name="first_hr_rate" value="<?= $updateResult['first_hr_rate'] ?>"
                                class="form-control" placeholder="Enter First Hour Rate">
                        </div>
                        <div class="mb-3">
                            <label for="next_hr_rate">Next Hour Rate</label>
                            <input type="text" name="next_hr_rate" value="<?= $updateResult['next_hr_rate'] ?>"
                                class="form-control" placeholder="Enter Next Hour Rate" required>
                        </div>
                        <div class="mb-3">
                            <label for="day_rate">Day Rate</label>
                            <input type="text" name="day_rate" value="<?= $updateResult['day_rate'] ?>"
                                class="form-control" placeholder="Enter Day Rate" required>
                        </div>
                        <div class="mb-3">
                            <label for="monthly_rate">Monthly Rate</label>
                            <input type="text" name="monthly_rate" value="<?= $updateResult['monthly_rate'] ?>"
                                class="form-control" placeholder="Enter Monthly Rate" required>
                        </div>

                        <button type="submit" name="updateParkSetupInfo" class="btn btn-primary btn-sm">Update</button>
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

        if (isset($_POST['updateParkSetupInfo'])) {
            //print_r($_POST);
   
            $id   = $_POST['id'];
            $vehicle_type = $_POST['vehicle_type'];
            $first_hr_rate = $_POST['first_hr_rate'];
            $next_hr_rate = $_POST['next_hr_rate'];
            $day_rate = $_POST['day_rate'];
            $monthly_rate = $_POST['monthly_rate'];
            $ss_creator = $_SESSION['username'];
            $ss_modifier = $_SESSION['username'];
        
            $query31 = "UPDATE `parking_rate_setup` SET `vehicle_type`='$vehicle_type',`first_hr_rate`='$first_hr_rate',`next_hr_rate`='$next_hr_rate',`day_rate`='$day_rate',`monthly_rate`='$monthly_rate',`ss_creator`='$ss_creator',`ss_modifier`='$ss_modifier' WHERE `id` = '$id' ";
            
            mysqli_query($conn, $query31) or die( mysqli_error($conn));
        
            //header("location:index.php");
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
            
        }
            
    ?>

    <!-- Edit Modal End -->

    

    <!-- Option 1: Bootstrap Bundle with Popper -->
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
  
</script>

  </body>
</html>