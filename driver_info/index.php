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

    <title>Driver</title>
  </head>
  <body>


  <main class="app-content">
        <div class="card">
            <div class="card-header">

                <h3 class="card-title">Driver Info</h3>

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
                            <th>Driver Name</th>
                            <th>Driver License No</th>
                            <th>Car Reg No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php

                        $counter = 0;

                        
                        
                        $query4 = "SELECT driver_info.id as did,driver_info.driver_name,driver_info.driver_license_no, parking_lots_info.id,parking_lots_info.car_reg_no
                        FROM driver_info
                        INNER JOIN parking_lots_info ON driver_info.car_reg_no=parking_lots_info.id;";
                        //$query = "SELECT d.*,p.* FROM driver_info d,parking_lots_info p WHERE d.car_reg_no=p.id";
                        //$query = "SELECT * FROM `driver_info`";

                        $result = mysqli_query($conn, $query4) or die( mysqli_error($conn));

                        while ($row = mysqli_fetch_assoc($result)) {

                        
   
                    ?>

                        <tr>

                            <td>
                                <?php echo ++$counter; ?>
                            </td>
                            <td>
                                <?php echo $row['driver_name'] ?>
                            </td>
                            <td>
                                <?php echo $row['driver_license_no'] ?>
                            </td>
                           
                            <td>
                                <?php echo $row['car_reg_no'] ?>
                            </td>
                            

                            <td>
                               
                                <a href="#edit<?= $row['did'] ?>" class="btn btn-outline-info btn-sm"
                                data-toggle="modal"><i
                                        class="far fa-edit"></i></a>
                                <a href="delete.php?carDriverInfoDelete=<?= base64_encode($row['did']) ?>"
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
                        <th>Driver Name</th>
                        <th>Driver License No</th>
                        <th>Car Reg No</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Driver Info</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="create.php">
                        <div class="mb-3">
                            <input type="text" name="driver_name" value=""
                                class="form-control" placeholder="Enter Driver Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="driver_add" value=""
                                class="form-control" placeholder="Enter Driver Address">
                        </div>
                        <div class="mb-3">
                            <input type="text" name="driver_license_no" value=""
                                class="form-control" placeholder="Enter Driver License No" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="license_issue_place" value=""
                                class="form-control" placeholder="Enter License Issue Place">
                        </div>
                        <div class="mb-3">
                            <label for="">License Issue Date</label>
                            <input type="date" name="license_issue_date" value=""
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">License Expiry Date</label>
                            <input type="date" name="license_exp_date" value=""
                                class="form-control">
                        </div>
                        <div class="mb-3">

                            <select class="form-control" name="car_reg_no" required>
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
                       
                        <button type="submit" name="addDriverInfo" class="btn btn-primary btn-sm">Submit</button>
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

        $query = "SELECT * FROM `driver_info`";

        $result = mysqli_query($conn, $query) or die( mysqli_error($conn));

        while ($row = mysqli_fetch_assoc($result)) {

        $id = $row['id'];

        $query2 = "SELECT * FROM `driver_info` WHERE `id`='$id'";
        
        $result2 = mysqli_query($conn, $query2) or die( mysqli_error($conn));
    
        $updateResult = mysqli_fetch_assoc($result2);

    ?>

    <div class="modal fade" id="edit<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Driver Info</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                        <div class="mb-3">

                        <input type="hidden" name="id" value="<?= $updateResult['id'] ?>" class="form-control"
                                required>

                            <input type="text" name="driver_name" value="<?= $updateResult['driver_name'] ?>"
                                class="form-control" placeholder="Enter driver name" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="driver_add" value="<?= $updateResult['driver_add'] ?>"
                                class="form-control" placeholder="Enter driver Address">
                        </div>
                        <div class="mb-3">
                            <input type="text" name="driver_license_no" value="<?= $updateResult['driver_license_no'] ?>"
                                class="form-control" placeholder="Enter driver license no" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="license_issue_place" value="<?= $updateResult['license_issue_place'] ?>"
                                class="form-control" placeholder="Enter License issue Place">
                        </div>

                        <div class="mb-3">
                            <label for="">License Issue Date</label>
                            <input type="date" name="license_issue_date" value="<?= $updateResult['license_issue_date'] ?>"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">License Expiry Date</label>
                            <input type="date" name="license_exp_date" value="<?= $updateResult['license_exp_date'] ?>"
                                class="form-control">
                        </div>

                        <div class="mb-3">

                            <select class="form-control" name="car_reg_no" required>
                                <option selected>Car No</option>

                                <?php

                                    //$query4 = "SELECT * FROM `driver` d JOIN parking_lots_info p ON d.car_reg_no=p.id";
                                    //$query4 = "SELECT * FROM `flat_info` WHERE flat_info.flat_no=flat_no";
                                    //$query4 = "SELECT d.* , p.* FROM driver d,parking_lots_info p WHERE d.car_reg_no=p.id";

                                    $result41 = mysqli_query($conn, "SELECT * FROM `parking_lots_info`") or die( mysqli_error($conn));

                                    while ($update_car_no = mysqli_fetch_assoc($result41)) {
   
                                ?>

                                <option value="<?= $update_car_no['id']; ?>" <?php echo $update_car_no['id'] == $updateResult['car_reg_no'] ? 'selected' : ''?>><?php echo $update_car_no['car_reg_no'] ?></option>
                                
                                <?php } ?>

                            </select>
                            
                        </div>

                        <button type="submit" name="updateDriverInfo" class="btn btn-primary btn-sm">Update</button>
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

        if (isset($_POST['updateDriverInfo'])) {
            //print_r($_POST);
   
            $id   = $_POST['id'];
            $driver_name = $_POST['driver_name'];
            $driver_add = $_POST['driver_add'];
            $driver_license_no = $_POST['driver_license_no'];
            $license_issue_place = $_POST['license_issue_place'];
            $license_issue_date = $_POST['license_issue_date'];
            $license_exp_date = $_POST['license_exp_date'];
            $car_reg_no = $_POST['car_reg_no'];
            $ss_creator = $_SESSION['username'];
            $ss_modifier = $_SESSION['username'];
        
            $query31 = "UPDATE `driver_info` SET `driver_name`='$driver_name',`driver_add`='$driver_add',`driver_license_no`='$driver_license_no',`license_issue_place`='$license_issue_place',`license_issue_date`='$license_issue_date',`license_exp_date`='$license_exp_date',`car_reg_no`='$car_reg_no',`ss_creator`='$ss_creator',`ss_modifier`='$ss_modifier' WHERE `id` = '$id' ";
            
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