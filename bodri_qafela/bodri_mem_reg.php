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
   
    

    <title>Driver</title>
  </head>
  <body>


  <main class="app-content">
        <div class="card">
            <div class="card-header">

                <h3 class="card-title">Member List</h3>

                <div class="container">
                    <div style="text-align: right;">
                    <a href="bidri_member_add.php" class="btn btn-outline-success btn-sm text-right">
                            <i class="fa fa-plus-circle fa-w-20"></i><span> ADD MEMBER</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-hover table-bordered table-sm" id="studentTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>Member Number</th>
                            <th>Name</th>
                            <th>Father/Husband Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <!--<th>Shop Name</th>-->
                            <!--<th>Shop Owner_name</th>-->
                            <th>GL Account</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php

                        $counter = 0;

                        $sql = "SELECT member_id,member_no, full_name, father_name,email,mobile,referred_person,shop_name,shop_owner_name, gl_acc_code FROM `fund_member` order by member_no";

                    //use for MySQLi-OOP
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                        
   
                    ?>

                        <tr>

                            <td>
                                <?php echo ++$counter; ?>
                            </td>
                            <td>
                                <?php echo $row['member_no'] ?>
                            </td>
                            <td>
                                <?php echo $row['full_name'] ?>
                            </td>
                           
                            <td>
                                <?php echo $row['father_name'] ?>
                            </td>
                            <td>
                                <?php echo $row['email'] ?>
                            </td>
                            <td>
                                <?php echo $row['mobile'] ?>
                            </td>
                           
                            <td>
                                <?php echo $row['gl_acc_code'] ?>
                            </td>
                           
                            

                            <td>

                                <a href="bodri_mem_reg_edit.php?id=<?= $row['member_id'] ?>"
                                    class="btn btn-outline-success btn-sm mb-3"><i
                                        class="fa fa-edit"> Edit</i></a>
                                <a href="bodri_member_setup.php?id=<?= $row['member_id'] ?>"
                                    class="btn btn-outline-info btn-sm"><i
                                        class="fa fa-plus"> Setup</i></a>
                            </td>

                        </tr>

                        <?php
                    }
                        
                        ?>

                    </tbody>
                 
                </table>

            </div>
        </div>
</main>





    

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