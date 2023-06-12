<?php

use Sabberworm\CSS\Value\Value;

require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];

require "../source/top.php";
$pid = 1318000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";

$querys = "select max(id) from apart_owner_info";
$return = mysqli_query($conn, $querys);
$result = mysqli_fetch_assoc($return);
$maxMemID = $result['max(id)'];
$lastRow = $maxMemID + 1;

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i>Dokan  Vara Status</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  
   <?php 
    if (!empty($message)) {
            echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
          } else {
          }
          if (!empty($mess)) {
            echo '<script type="text/javascript">
          Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
          } else {
          }
          ?>
          

            <!-- == General Ledger == -->
            <div class="tile" id="memberGLAddForm">
              <div class="tile-body">
                <h5 style="text-align: center">Dokan Vara Status</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                      <th>Dokan Number</th>
                      <th>Dokan Name Name</th>
                      <th>Dokan Vara Gl A/C</th>
                      <th>Status</th>
                    </tr>
                  </thead>


                 <!-- =============================== -->
                 <tbody>
                    <?php
                    $sql = "SELECT flat_info.id,flat_info.flat_no,flat_info.flat_title,flat_info.dokan_vara_gl,dokan_vara_detail.allow_flag,dokan_vara_detail.effect_date
                     FROM flat_info,dokan_vara_detail WHERE flat_info.flat_no=dokan_vara_detail.flat_no  order by flat_no";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row['flat_no'] . "</td>";
                      echo "<td>" . $row['flat_title'] . "</td>";
                      echo "<td>" . $row['dokan_vara_gl'] . "</td>";
                      echo "<td style='display:none'>" . $row['allow_flag'] . "</td>";
              

                     
                    ?> 
                   
                      <td>
                      <?php
                      if ($row['allow_flag'] =='1') {
                          ?>
                          <a  
                               
                          class='btn btn-success btn-sm editbtn1'>
                               
                          <span class='fa fa-plus'></span>Active</a>

                               <?php

                            }
                            
                            ?>


                        <?php

                          if ($row['allow_flag'] =='0') {
                          ?>
                          <a class='btn btn-danger btn-sm editbtn'><span class='fa-solid fa-dash'></span> In Active</a>

                               <?php

                            } 
                            
                            ?>
                      </td>
                      
                    <?php

                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>



         <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Update Dokan </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="dokan_vara_status_update.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="status" id="status">
                        <input type="hidden" name="flate_no" id="flate_no">

                        <div class="form-group">
                            <label> Dokan Name </label>
                            <input readonly type="text" name="dname" id="dname" class="form-control"
                                >
                        </div>

                        <div class="form-group">
                            <label> Payment Amount </label>
                            <input type="number" name="payamount" id="payamount" class="form-control"
                                placeholder="Amount">
                        </div>

                        <div class="form-group">
                            <label> Last Payment Date </label>
                            <input type="date" name="date" id="date" class="form-control"
                                placeholder="Enter Course">
                        </div>
                        <div class="form-group">
                            <label> Effect Date </label>
                            <input type="date" name="edate" id="edate" class="form-control"
                                placeholder="Enter Course">
                        </div>

                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>



         <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
         <div class="modal fade" id="editmodal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Update Dokan </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="dokan_vara_status_update.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="status1" id="status1">
                        <input type="hidden" name="flate_no1" id="flate_no1">

                        <div class="form-group">
                            <label> Dokan Name </label>
                            <input readonly type="text" name="dname1" id="dname1" class="form-control"
                                >
                        </div>

                      
                        <div class="form-group">
                            <label> Effect Date </label>
                            <input type="date" name="edate" id="edate" class="form-control"
                                placeholder="Enter Course">
                        </div>

                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


</main>
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
  $('#sampleTable').DataTable();
  $('#memberTable').DataTable();
</script>





<script>
        $(document).ready(function () {

            $('.editbtn').on('click', function () {

              
              $('#editmodal').modal('show');
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);
                 $('#flate_no').val(data[0]);
                 $('#dname').val(data[1]);
                 $('#status').val(data[3]);
                
                // $('#course').val(data[3]);
                // $('#contact').val(data[4]);
            });

            $('.editbtn1').on('click', function () {

              
              $('#editmodal1').modal('show');
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);
                 $('#flate_no1').val(data[0]);
                 $('#dname1').val(data[1]);
                 $('#status1').val(data[3]);
                
                // $('#course').val(data[3]);
                // $('#contact').val(data[4]);
            });
        });
    </script>
<?php
$conn->close();
?>
</body>

</html>