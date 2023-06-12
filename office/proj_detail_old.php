<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];

if (isset($_POST['submit'])) {

  $office_code = $conn->escape_string($_SESSION['office_code']);
  $proj_no = $conn->escape_string($_POST['proj_no']);
  $proj_phase_no = $conn->escape_string($_POST['proj_phase_no']);
  $proj_phase_date = $conn->escape_string($_POST['proj_phase_date']);
  $phase_complete_date = $conn->escape_string($_POST['phase_complete_date']);
  $proj_phase_value = $conn->escape_string($_POST['proj_phase_value']);
  $requirement_type = $conn->escape_string($_POST['requirement_type']);
 
  
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  for ($count = 0; $count < count($_POST['item_no']); ++$count) {
    $sl_no = $conn->escape_string($_POST['sl_no'][$count]);
    $item_no = $conn->escape_string($_POST['item_no'][$count]);
    $item_unit = $conn->escape_string($_POST['item_unit'][$count]);
    $item_qty = $conn->escape_string($_POST['item_qty'][$count]);
    $unit_price = $conn->escape_string($_POST['unit_price'][$count]);
    $tot_amt_loc = $conn->escape_string($_POST['tot_amt_loc'][$count]);
    if ($item_no > 0) {
        $insertownerQuery = "insert into  project_detail (id, `office_code`,`proj_no`,`proj_phase_no`,`proj_phase_date`,`proj_phase_value`,`requirement_type`,sl_no,`item_no`,`item_unit`,`item_qty`,`unit_price`,`tot_amt_loc`,`phase_complete_date`,`is_current`,`ss_creator`,`ss_created_on`,`ss_org_no`) values (null, '$office_code','$proj_no', '$proj_phase_no','$proj_phase_date', '$proj_phase_value','$requirement_type','$sl_no','$item_no','$item_unit','$item_qty','$unit_price','$tot_amt_loc','$phase_complete_date','1','$ss_creator','$ss_created_on','$ss_org_no')";
        $conn->query($insertownerQuery);

      if ($conn->affected_rows == TRUE) {
        $message = "Successfully";
      } else {
        $mess = "Failled";
      }
    }
  }
  header('refresh:1;proj_detail.php');
}
require "../source/top.php";
$pid = 206000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
// $querys = "insert into bach_no (username) values ('$_SESSION[username]')";
// $returns = mysqli_query($conn, $querys);
// $lastRows = $conn->insert_id;
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Project Detail</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>

    <!-- ====-- button define====== -->
    <button id="ScaleSetupBtn" class="btn btn-success"><a class="active"></i>Project Detail Info.</button>
    <button id="ViewScaleBtn" class="btn btn-primary"><a class=""></i>View Project detail Info.</button>
    
    <!-- =======button Define closed===== -->
    <div class=" row">
      <div class="col-md-12">
        <div id="ScaleSetup" class="collapse">
          <div style="padding:5px">
            <form method="post">
            
               <div class="form-group row">
                   <label class="col-sm-3 col-form-label">Project Number</label>
                   <label class="col-form-label">:</label>
                   <div class="col-sm-6">
                    <select name="proj_no" class="form-control" required>
                      <option value="">-Select Office Code-</option>
                      <?php
                      // require '../database.php';
                      $selectQuery = "SELECT office_code, office_name FROM office_info where office_type='2'";
                      $selectQueryResult = $conn->query($selectQuery);
                      if ($selectQueryResult->num_rows) {
                        while ($row_off = $selectQueryResult->fetch_assoc()) {
                      ?>
                      <?php
                          echo '<option value="' . $row_off['office_code'] . '">' . $row_off['office_name'] . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-3 col-form-label">Project Phase Number</label>
                   <label class="col-form-label">:</label>
                   <div class="col">
                        <input type="text" class="form-control" id="" name="proj_phase_no">
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-3 col-form-label">Project Phase Date</label>
                   <label class="col-form-label">:</label>
                   <div class="col">
                        <input type="date" class="form-control" id="" name="proj_phase_date">
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-3 col-form-label">Phase Complete Date</label>
                   <label class="col-form-label">:</label>
                   <div class="col">
                        <input type="date" class="form-control" id="" name="phase_complete_date">
                   </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Project Phase Value</label>  
                   <label class="col-form-label">:</label>
                   <div class="col">
                        <input type="text" class="form-control" id="" name="proj_phase_value">
                   </div>
                </div>
               
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Requirement Type</label>  
                   <label class="col-form-label">:</label>
                   <div class="col">
                   <select name="requierment_type" class="form-control">
                          <option value="">----Select any----</option>
                          <option value="1">Services</option>
                          <option value="2">Goods</option>
                      </select>
                   </div>
                </div>
              <!-- =========  increment Input ======== -->
              <table class="table bg-light table-bordered table-sm" id="multi_table">
                <thead>
                  <tr class="table-active">
                    <th>Sl. No.</th>
                    <th>Item</th>
                    <th>Unit</th>
                    <th>Quentity</th>
                    <th>unit Price</th>
                    <th>Expected Value</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  
                  <td style="width 100%"><input type ="text" name="sl_no[]" id="sl_no" data-srno="1" value="1" class="sl_no from-control" /></td>
                    <td><select name="item_no[]" class="form-control item_no" required>
                            <option value="">-Select Item-</option>
                            <?php
                            $selectQuery = "SELECT * FROM `item` where sellable_option='N'";
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . $row['item_name'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                    <td><select name="item_unit[]" class="item_unit form-control" required>
                            <option value="">-Select Item-</option>
                            <?php
                            $selectQuery = 'SELECT * FROM `code_master` where hardcode="UCODE" and softcode>0';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                                while ($row = $selectQueryResult->fetch_assoc()) {
                                    echo '<option value="' . $row['description'] . '">' . $row['description'] . '</option>';
                                }
                            }
                            ?>
                        </select></td>
                        
                    <td><input type="text" name="item_qty[]" id="item_qty" data-srno="1" class="item_qty form-control" /></td>
                    <td><input type="text" name="unit_price[]" id="unit_price" data-srno="1" class="unit_price form-control" /></td>
                    <td><input type="text" name="tot_amt_loc[]" id="tot_amt_loc" data-srno="1" class="tot_amt_loc form-control" /></td>
                    <td style="width: 20px"><button type="button" name="add_row" id="add_row" class="btn btn-success btn-xl">+</button></td>
                  </tr>
                </tbody>
              </table>
              <hr>
             
              <!-- ===== Input Closed =====  -->
              <div>
                <input type="hidden" name="activation_key" value="0">
                <button type="submit" class="btn btn-primary" id="submit" name="submit">Submit</button>
              </div>
          </div>
          </form>
        </div>
      </div>
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
    <!--====== Notice View List ======-->
    <div class="tile" id="ViewScale">
      <div class="tile-body">
        <h5 style="text-align: center">View  project Detail</h5>
        <table class="table table-hover table-bordered" id="GLAddTable">
          <thead>
            <tr>
            <th>ID</th>
              
              <th>Project Name</th>
              <th>Project Phase No.</th>
              <th>Project Phase Date</th>
              <th>Phase Complete Date</th>
              <th>Project Phase Value</th>
          
              <th>Item</th>
              <th> Quentity</th>
              <th> Unit Price</th>
              <th> Expected Value</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $proj_phase_no= '';
            $sql = "select project_detail.id, project_detail.office_code,project_detail.proj_no, project_detail.proj_phase_no, project_detail.proj_phase_date, project_detail.phase_complete_date, project_detail.proj_phase_value, project_detail.sl_no, project_detail.item_no, project_detail.item_unit, project_detail.item_qty, project_detail.unit_price, project_detail.tot_amt_loc, office_info.office_name, item.item_name from project_detail, office_info, item where project_detail.item_no=item.id and  project_detail.proj_no=office_info.office_code";
            $query = $conn->query($sql);
            while ($row = $query->fetch_assoc()) {
              ?>
              
              <tr>
                      <td style="text-align: right"><?php if ($row['proj_phase_no'] != $proj_phase_no) {
                                                            echo $row['id']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                    
                      <td style="text-align: right"><?php if ($row['proj_phase_no'] != $proj_phase_no) {
                                                            echo $row['office_name']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>
                      <td style="text-align: right"><?php if ($row['proj_phase_no'] != $proj_phase_no) {
                                                            echo $row['proj_phase_no']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>
                      <td style="text-align: right"><?php if ($row['proj_phase_no'] != $proj_phase_no) {
                                                            echo $row['proj_phase_date']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>

                      <td style="text-align: right"><?php if ($row['proj_phase_no'] != $proj_phase_no) {
                                                            echo $row['phase_complete_date']; 
                                                        } else {
                                                            echo "";
                                                        }?></td>

                     
                      <td style="text-align: right"><?php if ($row['proj_phase_no'] != $proj_phase_no) {
                                                            echo $row['proj_phase_value']; 
                                                            $proj_phase_no=$row['proj_phase_no'];
                                                        } else {
                                                            echo "";
                                                        }?></td>
                      
                     
                     <td style=" background-color:powderblue; text-align: right"><?php echo $row['item_name']; ?></td>
                       <td style=" background-color:powderblue; text-align: right"><?php echo $row['item_qty'];echo "  "; echo $row['item_unit']; ?></td>
                       <td style=" background-color:powderblue; text-align: right"><?php echo $row['unit_price']; ?></td>
                       <td style="background-color:powderblue; text-align: right"><?php echo $row['tot_amt_loc']; ?></td>
                       
                       <td><a <?php if ($row['sl_no'] != '1') {
                                echo "onclick='return false";
                              } ?> <?php echo "href='proj_detail_edit.php?id=" . $row['proj_phase_no'] . "'"  ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Edit</a>
                      </td>
                     
                       <!-- <td><a <?php  "href='proj_detail_edit.php?id=" . $row['proj_phase_no'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Edit</a>
                      </td> -->

                       
                         
              </tr>
          
          <?php } ?>

        </tbody>
              
        </table>
      </div>
    </div>
      </div>
    </div>
  <?php
  } else {
    echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION</h6>";
  } ?>
  <!-- Supplier Account View start -->
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
<!-- toggle btn -->
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script type="text/javascript">
  // $(document).ready(function() {
  $("#907000").addClass('active');
  $("#900000").addClass('active');
  $("#900000").addClass('is-expanded')
  // });
  $(document).ready(function() {
    var count = 1;
    $(document).on('click', '#add_row', function() {
      count++;
      var html_code = '';
      html_code += '<tr id="row_id_' + count + '">';
      html_code += '<td><input type="text" name="sl_no[]" id="sl_no' + count + '" data-srno="' + count + '" value="' + count + '" class="form-control sl_no"/></td>';
                html_code += `<td><select name="item_no[]" class="form-control item_no" >
                                <option value="">-Select Item-</option>
                                <?php
                                $selectQuery = "SELECT * FROM `item` where sellable_option='N'";
                                $selectQueryResult = $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                    while ($row = $selectQueryResult->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['item_name'] . '</option>';
                                    }
                                }
                                ?>
                                </select></td>`;
                html_code += `<td><select name="item_unit[]" id="item_unit' + count + '" data-srno="' + count + '" class="item_unit form-control" >
                            <option value="">-Select Item-</option>
                        <?php
                        $selectQuery = 'SELECT * FROM `code_master` where hardcode="UCODE" and softcode>0';
                        $selectQueryResult = $conn->query($selectQuery);
                        if ($selectQueryResult->num_rows) {
                            while ($row = $selectQueryResult->fetch_assoc()) {
                                echo '<option value="' . $row['description'] . '">' . $row['description'] . '</option>';
                            }
                        }
                        ?>
                            </select></td>`;
      html_code += '<td><input type="text" name="item_qty[]" id="item_qty' + count + '" data-srno="' + count + '" class="form-control item_qty"/></td>';
      html_code += '<td><input type="text" name="unit_price[]" id="unit_price' + count + '" data-srno="' + count + '" class="form-control unit_price"/></td>';
      html_code += '<td><input type="text" name="tot_amt_loc[]" id="tot_amt_loc' + count + '" data-srno="' + count + '" class="form-control tot_amt_loc"/></td>';
      html_code += '<td><button type="button" name="remove_row" id="' + count + '" class="form-control btn btn-danger btn-xl remove_row">-</button></td>';
      html_code += '</tr>';
      $('#multi_table').append(html_code);
    });
    $(document).on('click', '.remove_row', function() {
      var row_id = $(this).attr("id");
      $('#row_id_' + row_id).remove();
      count--;
    });
  });
  // table 
  $('#sampleTable').DataTable();
  $('#memberTable').DataTable();
  
  // Button 
  $('#ViewScale').hide();
  $('#ScaleSetup').hide();

  // ScaleSetup
  $('#ScaleSetupBtn').on('click', function() {
    $('#ScaleSetup').show();
    $('#ViewScale').hide();
    
  });
  // ViewScale
  $('#ViewScaleBtn').on('click', function() {
    $('#ScaleSetup').hide();
    $('#ViewScale').show();
    
  });
 
  // -----------------search notice --------
  function searchNotice() {
    var notice_no = $("#notice_no").val();
    //  alert(notice_no);
    $.ajax({
      type: "POST",
      url: "getMeeting.php",
      data: {
        notice_no: notice_no
      },
      dataType: "text",
      success: function(response) {
        $("#attendance_result").html(response);
        // alert(response);
      }
    });
  }
 
  function confirmDialog(message, onConfirm) {
    var fClose = function() {
      modal.modal("hide");
    };
    var modal = $("#exampleModalCenter");
    modal.modal("show");
    $("#confirmMessage").empty().append(message);
    $("#presentConfirm").bind().one('click', onConfirm).one('click', fClose);
    // $("#presentConfirm").one('click', onConfirm).one('click', fClose);
    $("#confirmCancel").unbind().one("click", fClose);
  }
</script>
<?php
$conn->close();
?>
</body>

</html>