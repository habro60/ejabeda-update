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

    <title>Holiday Setup</title>
  </head>
  <body>


  <main class="app-content">
        <div class="card">
            <div class="card-header">

                <h3 class="card-title">Holiday Setup</h3>

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
                            <th>Id</th>
                            <th>Holyday Date</th>
                            <th>Holiday Type</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php

                        $counter = 0;

                        $query4 = "SELECT id,holiday_date,holiday_type, description
                        FROM holiday";

                        //$query = "SELECT * FROM `parking_lots_info`";

                        $result = mysqli_query($conn, $query4) or die( mysqli_error($conn));

                        while ($row = mysqli_fetch_assoc($result)) {
   
                    ?>

                        <tr>


                            <td>
                                <?php echo $row['id'] ?>
                            </td>
                            <td>
                                <?php echo $row['holiday_date'] ?>
                            </td>
                            <td>
                                <?php echo $row['holiday_type'] ?>
                            </td>
                            <td>
                                <?php echo $row['description'] ?>
                            </td>

                            <td>
                                <a href="#edit<?= $row['id'] ?>" class="btn btn-outline-info btn-sm"
                                data-toggle="modal"><i
                                        class="far fa-edit"></i></a>
                                <a href="delete.php?carParkingInfoDelete=<?= base64_encode($row['id']) ?>"
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
                        <th>Parking Lot No</th>
                        <th>Lot Type</th>
                        <th>flat No</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Parking Lots</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="create.php">
                        <div class="mb-3">
                            <input type="text" name="park_lot_no" value=""
                                class="form-control" placeholder="Enter Parking Lot No" required>
                        </div>
                        <div class="mb-3">

                            <select class="form-control" name="flat_no" required>
                                <option selected>Flat No</option>

                                <?php

                                    //$query4 = "SELECT * FROM `driver` d JOIN parking_lots_info p ON d.car_reg_no=p.id";
                                    $query4 = "SELECT * FROM `flat_info` WHERE flat_info.flat_no=flat_no";
                                    //$query4 = "SELECT d.* , p.* FROM driver d,parking_lots_info p WHERE d.car_reg_no=p.id";

                                    $result4 = mysqli_query($conn, $query4) or die( mysqli_error($conn));

                                    while ($flat_no = mysqli_fetch_assoc($result4)) {
   
                                ?>

                                <option value="<?php echo $flat_no['id'] ?>"><?php echo $flat_no['flat_no'] ?></option>
                                
                                <?php } ?>

                            </select>
                            
                        </div>
                        <div class="mb-3">
                            <input type="text" name="car_reg_no" value="" placeholder="Enter Car Reg No" class="form-control"
                                    required>
                        </div>
                       
                       
                        <div class="mb-3">
                            <label class="col-12" for="lot_type">Lot Type:</label>
                            <input type="radio" name="lot_type" value="Resident" required> Resident
                            <input type="radio" name="lot_type" value="Non Resident" required> Non Resident
                        </div>

                        <button type="submit" name="addHoliday" class="btn btn-primary btn-sm">Submit</button>
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

                            <select class="form-control" name="flat_no" required>
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