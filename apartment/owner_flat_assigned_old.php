<?php
require "../auth/auth.php";
require "../database.php";

$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['ownerSubmit'])) {

//   header('refresh:1;owner_info.php');
  echo "<meta http-equiv=\"refresh\" content=\"0;URL=owner_info.php\">";
}
?>

<?php
require "../source/top.php";
$pid = 1301000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
}
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Owner Flat Assigned</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php

  if ($seprt_cs_info == 'Y') { ?>
    
    <div class="row">
      <div class="col-md-12">
        <div>
          <br>
            <div class="card" id="assignedFlat">
              <div class="card-header" style="background-color:#85C1E9">
                <h4 style="text-align:center">Assign Flat to Owner</h4>
              </div>
              <form method="POST">
                <table class="table bg-light table-bordered table-sm">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Flat Number</th>
                      <th>Flat Title</th>
                      <th>Flat Area</th>
                      <th>Side</th>
                      <th>location</th>
                      <th>Block Number</th>
                      <th>Assigned To Owner</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT flat_info.id,flat_info.office_code, flat_info.flat_no, flat_info.flat_area, flat_info.side_of_flat, flat_info.building, flat_info.block_no, flat_info.owner_id,flat_info.flat_status, flat_info.flat_title FROM `flat_info` where flat_info.id='$id'";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                    ?>
                      <tr>
                        <input type="hidden" name="flat_status[]" class="form-control" value="<?php echo $row['flat_status']; ?>" style="width: 100%" readonly>
                        <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $row['office_code']; ?>" style="width: 100%" readonly>
                        <td>
                          <input type="text" name="id[]" class="form-control" value="<?php echo $row['id']; ?>" style="width: 100%" readonly>
                        </td>
                        <td>
                          <input type="text" name="flat_no[]" class="form-control" value="<?php echo $row['flat_no']; ?>" style="width: 100%" readonly>
                        </td>
                        <td>
                          <input type="text" name="flat_title[]" class="form-control" value="<?php echo $row['flat_title']; ?>" style="width: 100%" readonly>
                        </td>
                        <td>
                          <input type="text" name="flat_area[]" class="form-control" value="<?php echo $row['flat_area']; ?>" style="width: 100%" readonly>
                        </td>
                        <td>
                          <input type="text" name="side_of_flat[]" class="form-control" value="<?php echo $row['side_of_flat']; ?>" style="width: 100%" readonly>
                        </td>
                        <td>
                          <input type="text" name="building[]" class="form-control" value="<?php echo $row['building']; ?>" style="width: 100%" readonly>
                        </td>
                        <td>
                          <input type="text" name="block_no[]" class="form-control" value="<?php echo $row['block_no']; ?>" style="width: 100%" readonly>
                        </td>

                        <input type="hidden" name="owner_id[]" class="form-control" value="<?php echo $row['owner_id']; ?>" readonly>

                        <td>
                          <!-- Owner for Flat -->
                          <select name="owner_no[]" class="form-control" id="owner_id<?php echo $row['id']; ?>" onchange="ownerAssign('<?php echo $row['id']; ?>')" <?php if ($row['flat_status'] == 1) {
                                                                                                                                                                      echo 'disabled';
                                                                                                                                                                    } ?> style="width: 200px">

                            <option value="">- Select owner -</option>
                            <?php
                            $selectQuery = 'SELECT owner_id, owner_name FROM `apart_owner_info`';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                              while ($row_owner = $selectQueryResult->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $row_owner['owner_id']; ?>" <?php if ($row_owner['owner_id'] == $row['owner_id']) { ?> selected="selected" <?php } ?>><?php echo $row_owner['owner_name']; ?></option>

                            <?php
                              }
                            }
                            ?>
                          </select>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>

                  </tbody>
                </table>
              </form>
            </div>
          </div>
         
          <!-- =====Services Facility===== -->
          
            </div>
          </div>
        <?php
      } else {
        echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
      } ?>
        <!-- end of service facility -->
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
<!--  -->
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script type="text/javascript">
  $('#GLAddTable').DataTable();
  $('#ownerListTable').DataTable();
  $('#servicesListTable').DataTable();
</script>
<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
  $(document).ready(function() {
    $("#1301000").addClass('active');
    $("#1300000").addClass('active');
    $("#1300000").addClass('is-expanded');
  });
  // more informatino script start
  $('#more_show').hide();
  var id = this.value;
  $('#more').on('click', function() {
    $('#more_show').show(1000);
  });
  //=========
  $('.group').on('click', function() {
    $('#more_show').hide();
  });
  //=========
  function ownerAssign(id) {
    $.confirm({
      title: 'Assigned To Owner',
      content: 'Are You Assign To Owner !!',
      btnClass: 'btn-btn info',
      buttons: {
        Assign: function() {
          var owner_id = $('#owner_id' + id).val();
          
          // alert(owner_id);
          $.ajax({
            type: "POST",
            url: "getFlatUpdate.php",
            data: {
              id: id,
              owner_id: owner_id
            },
            dataType: "JSON",
            success: function(response) {
              $("#owner_id" + id).attr("disabled", true);
              $.alert('Assigned Successfull!');
            },
            error: function(response) {
              alert('Assign Failled!');
              // location.reload();
            }
          });
         
        },
        cancel: function() {
          $.alert('Canceled!');
        }
      }
    })
  }
  
  // on change
  $('#submit').hide();
  $(document).on('change', '.owner', function() {
    $('.owner').val($(this).val());
    $(".owner").addClass("intro");
    // show and hide
    $('#submit').show();
  });
  
  
  $("#assignedFlatBtn").click(function() {
    $('#assignedFlat').show();
    

  });


 
</script>
<?php
$conn->close();
?>
</body>

</html>