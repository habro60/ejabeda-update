<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';

if (isset($_POST['assignServices'])) {
  
    for ($count = 0; $count < count($_POST['p_menu_no']); ++$count) {
      $id = $_POST['id'][$count];
      $office_code = $_POST['office_code'][$count];
      $menu_no = $_POST['menu_no'][$count];
      $menu_name = $_POST['menu_name'][$count];
      $menu_obj_name=$_POST['menu_obj_name'][$count];
      $p_menu_no = $_POST['p_menu_no'][$count];
      // $main_id = $_POST['main_id'][$count];
      $role_no = $_POST['role_no'][$count];
      $active_stat = $_POST['active_stat'][$count];

      $grand_role = $conn->escape_string($_POST["grand_role"]);
      
      $ss_creator = $_SESSION['username'];
      $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
      $ss_modifier = $_SESSION['username'];
      $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
      $ss_org_no = $_SESSION['org_no'];
  
      if ($id != 0) {
        // if ($role_no  != '' || $role_no  != '0'){
        if ($role_no  != '' ) {
          $query = "update `sm_role_dtl` set  `active_stat`='$active_stat', ss_creator='$ss_creator', ss_created_on='$ss_created_on', ss_org_no='$ss_org_no' where menu_no='$menu_no' and role_no='$role_no'";
          // echo $query;
          // exit;
         
           
        } else {

          $query = "INSERT INTO `sm_role_dtl` (id,office_code,`role_no`, `menu_no`, `menu_name`, `menu_obj_name`,`main_id`,`p_menu_no`,`active_stat`,ss_creator,ss_created_on, ss_modifier, ss_modified_on,ss_org_no) VALUES (null, '$office_code','$grand_role', '$menu_no', '$menu_name','$menu_obj_name', '$id', '$p_menu_no', '$active_stat','$ss_creator','$ss_created_on','$ss_modifier', '$ss_modified_on','$ss_org_no')";
          // echo $query;
          // exit;

        }
      
        $conn->query($query);
      }
      if ($conn->affected_rows == TRUE) {
        $message = "Successfully";
      } else { 
        $mess = "Failled";
      }
    }
  //   header('refresh:1;owner_info.php');
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=user_roles_details.php\">";
  }



$pid= 704000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require '../source/header.php';
require '../source/sidebar.php';
?>
<style>
    .cols6 {
        -webkit-box-flex: 0;
        -ms-flex: 0;
        flex: 45%;
        max-width: 50%;
    }
    .bor,
    thead,
    tr,
    th,
    td {
        border-style: solid;
        border-color: black;
        border-width: 1px;
    }
</style>
<main class="app-content">
    <div class="app-title">
        <h1><i class="fa fa-dashboard"></i> Assigned Menu To Each Role </h1>

    </div>
    <form method="POST">
        <div>
            <label for="">Select Role </label>
            <!-- <input type="date" name="enddate" id="" required> -->
            <select name="grand_role" class="" id="grand_role" onchange="getRoleNo(this.value)">
                    <option value="">- Select Role -</option>
                    <?php
                    $selectQuery = 'SELECT role_no , role_name FROM `sm_role`';
                    $selectQueryResult = $conn->query($selectQuery);
                    if ($selectQueryResult->num_rows) {
                      while ($row = $selectQueryResult->fetch_assoc()) {
                        echo '<option value="' . $row['role_no'] . '">' . $row['role_name'] . '</option>';
                      }
                    }
                    ?>
                  </select>
            <input type="submit" name="submit" id="submitBtn" class="btn-info" value="View Main Menu">
        </div>
        
    </form>
    <div class="row">
        <div class="col-12">
            
            <?php
            if (isset($_POST['submit'])) {
                $grand_role = $conn->escape_string($_POST["grand_role"]);               
            ?>
                <div class="row">
                    <div class="col-2">
                        <table style="width:100%" class="bor">
                            <thead>
                                  <tr style="text-align: center; font-weight:bold">
                                    <td colspan="5">Selected Role</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $grand_role = $conn->escape_string($_POST["grand_role"]);
                                $sql = "SELECT `role_no`, `role_name`, `active_stat`  FROM  sm_role where `role_no`='$grand_role'";
                                $query = $conn->query($sql);
                                while ($role_row = $query->fetch_assoc()) {
                                 ?>
                                    <tr>
                                        <td><?php echo $role_row['role_name']; ?></td> 
                                    <?php
                                }
                                    ?>
                            </tbody>
                            
                        </table>
                    </div>
                    <div class="col-4">
                        <table style="width:100%" class="bor">
                            <thead>                
                                 <tr style="text-align: center; font-weight:bold">
                                    <td colspan="4"> Main Menu</td>
                                </tr>
                                <tr>
                                    <th>Menu Number</th>
                                    <th>Menu Name</th>
                                    <th>Select Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
                                
                                $sql = "SELECT sm_menu.id, sm_menu.office_code, sm_menu.menu_no, sm_menu.menu_name, sm_menu.p_menu_no FROM sm_menu where  p_menu_no='0' and active_stat = '1' order by menu_no

                                ";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) {
                                 ?>
                                    <tr>
                                      <input type="hidden" name="office_code[]" class="form-control" value="<?php echo $row['office_code']; ?>" style="width: 100%" readonly>
                                      <input type="hidden" name="p_menu_no[]" class="form-control" id="p_menu_no" value="<?php echo $row['p_menu_no']; ?>" style="width: 100%" readonly>
                                      <input type="hidden" name="id[]" class="form-control" id="id" value="<?php echo $row['id']; ?>" style="width: 100%" readonly>
                                     <td>
                                      <input type="text" name="menu_no[]" class="form-control" value="<?php echo $row['menu_no']; ?>" style="width: 100%" readonly>
                                     </td>
                                     <td>
                                      <input type="text" name="menu_name[]" class="form-control" value="<?php echo $row['menu_name']; ?>" style="width: 100%" readonly>
                                     </td>
                                     
                                     <td><button class='btn btn-success btn-lg' style="width: 100px" onclick="serviceAssign('<?php echo $row['id']; ?>')"><span class='fa fa-arrow-circle-right fa-lg'></span>Select</button></td>
                                    <?php
                                }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <table style="width:100%" class="bor">
                            <thead> 
                            </thead>
                            <tbody>
                            <div id="serviceResult">
                         <?php
                                // $p_menu_no=$row['id'];
                                $grand_role = $conn->escape_string($_POST["grand_role"]);
                                $sql=" create or replace view view_role as SELECT sm_menu.office_code, sm_menu.id, sm_menu.menu_no, sm_menu.menu_name, sm_menu.p_menu_no,sm_menu.menu_obj_name, sm_role_dtl.role_no, sm_role_dtl.main_id,sm_role_dtl.active_stat FROM sm_menu LEFT outer JOIN sm_role_dtl ON sm_menu.menu_no=sm_role_dtl.menu_no AND sm_role_dtl.role_no ='$grand_role'";
                                $query = $conn->query($sql);   
                                   ?>  
                           </div>
                               
                            </tbody>
                        </table>
                    </div>
                <div>
                        <?php
                    } else {
                        echo "<h1 style='color:red;text-align:center;margin-top:150px'>Please Select From Date and To Date</h1>";
                    }
                        ?>
                 </table>
             </div>
        </div>
</main>



 <!-- form close  -->
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
              title: "oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
          } else {
          }
          ?>


<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->

<script src="../js/select2.full.min.js"></script>

<script>
    $(function() {
        $('.select2').select2()
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#704000").addClass('active');
        $("#700000").addClass('active');
        $("#700000").addClass('is-expanded');
    });


    function getRoleNo(val) {
            var role_id = $('#grand_role').val();
            $.ajax({
                type: "POST",
                url: "getMenuAssign.php",
                data: {
                    role_id: role_id
                },
                dataType:"text",
                success: function(respose) {
                    $('#grand_role').val(response);
                }
            });
        }

    function serviceAssign(id) {
    var p_menu_no = id; 
    $.ajax({
      type: "POST",
      url: "getMenuAssign.php",
      data: {
        p_menu_no: p_menu_no,
      },
      dataType: "Text",
      success: function(response) {
        $('#serviceResult').html(response);
      }
    });
  }
</script>

</body>

</html>