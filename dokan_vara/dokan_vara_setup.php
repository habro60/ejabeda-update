<?php
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
      <h1><i class="fa fa-dashboard"></i>Dokan Vara Setup</h1>
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
                <h5 style="text-align: center">Dokan Vara Setup</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                      <th>Dokan Number</th>
                      <th>Dokan Name Name</th>
                      <th>Dokan Vara Gl A/C</th>
                      <th>Add GL A/C</th>
                      <th>Vara Setup</th>
                    </tr>
                  </thead>


                 <!-- =============================== -->
                 <tbody>
                    <?php
                    $sql = "SELECT id,flat_no,flat_title,dokan_vara_gl FROM flat_info order by flat_no";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row['flat_no'] . "</td>";
                      echo "<td>" . $row['flat_title'] . "</td>";
                      echo "<td>" . $row['dokan_vara_gl'] . "</td>";
                    ?> 
                   
                      <td><a <?php if ($row['dokan_vara_gl'] > '0') {
                                echo "onclick='return false";
                              } ?> <?php echo "href='dokan_vara_gl_add.php?id=" . $row['id'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Assigned GL</a>
                      </td>
                      <td><a <?php if ($row['dokan_vara_gl'] > '0') {
                                echo "onclick='return false";
                              } ?> <?php echo "href='dokan_vara_assigned.php?id=" . $row['flat_no'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Assigned Vara</a>
                      </td>
                    <?php

                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            
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
<script type="text/javascript">
  function auto_fill_address() {
    var same_addr = document.getElementById("both_same").checked;
    // var same_addr = $("#both_same").val();
    var village = $("#village").val();
    var division_list = $('#division-list').val();
    var district_list = $('#district-list').val();
    var upazilla_list = $('#upazilla-list').val();
    var p_office = $("#p_office").val();
    if (same_addr) {
      if ((village == '' || village == null) || (p_office == '' || p_office == null)) {
        alert('please fill address and post');
        document.getElementById("both_same").checked = false;
      } else {
        $("#p_village").val(village);
        $("#p_p_office").val(p_office);
        $('#division-list').val(division_list);
        $('#district-list').val(district_list);
        $('#upazilla-list').val(upazilla_list);
      }
    } else {
      $("#p_village").val('');
      $("#p_p_office").val('');
      $('#division-list1').val('');
      $('#district-list1').val('');
      $('#upazilla-list1').val('');
    }
  }
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#901000").addClass('active');
    $("#900000").addClass('active');
    $("#900000").addClass('is-expanded')
  });

  // on change
  $('#submit').hide();
  $(document).on('change', '.member', function() {
    $('.member').val($(this).val());
    $(".member").addClass("intro");
    // show and hide
    $('#submit').show();
  });


</script>

<script>
  function getDistrict(val) {
    $.ajax({
      type: "POST",
      url: "../common/getDistrict.php",
      data: 'division_id=' + val,
      success: function(data) {
        $("#district_id").html(data);
        getUpazilas();
      }
    });
  }

  function getUpazilas(val) {
    $.ajax({
      type: "POST",
      // url: "../common/getUpazilas.php",
      url: "../common/getDistrict.php",
      data: 'district_id=' + val,
      success: function(data) {
        $("#upazilla_id").html(data);
      }
    });
  }

  function p_getDistrict(val) {
    $.ajax({
      type: "POST",
      url: "../common/getDistrict1.php",
      data: 'p_division_id=' + val,
      success: function(data) {
        $("#p_district_id").html(data);
        p_getUpazilas();
      }
    });
  }

  function p_getUpazilas(val) {
    $.ajax({
      type: "POST",
      // url: "../common/getUpazilas.php",
      url: "../common/getDistrict1.php",
      data: 'p_district_id=' + val,
      success: function(data) {
        $("#p_upazilla_id").html(data);
      }
    });
  }

  function get_ref(val) {
    $.ajax({
      type: "POST",
      url: "getRefInfo.php",
      data: 'reffered_id=' + val,
      success: function(data) {
        $("#get_id").html(data);
      }
    });
  }

  //   $(document).ready(function() {
  //     $('.both_same').on('click', function name() {
  // var both_same =  $('.both_same').val();
  //   if(both_same.checked) {
  //     alert(this.value);
  //   } else {
  //     alert();
  //   }

  //     });
  //   });
</script>
<?php
$conn->close();
?>
</body>

</html>