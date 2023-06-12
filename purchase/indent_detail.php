<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];

if (isset($_POST['submit'])) {
 $office_code = $conn->escape_string($_SESSION['office_code']);
  if ($_SESSION['office_code'] !== $_SESSION['org_no']) {
    $indent_from = $conn->escape_string($_SESSION['office_code']);
    $indent_to = $conn->escape_string($_SESSION['office_code']);
  } else {
    $indent_from = $conn->escape_string($_POST['indent_from']);
    $indent_to = $conn->escape_string($_SESSION['office_code']);
  }
  $indent_no = $conn->escape_string($_POST['indent_no']);
  $exp_delivery_date = $conn->escape_string($_POST['exp_delivery_date']);
  $exp_delivery_date = $conn->escape_string($_POST['exp_delivery_date']);
  $requirement_type = $conn->escape_string($_POST['requirement_type']);
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $indedent_date = $_POST['indedent_date'];
  $ss_org_no = $_SESSION['org_no'];

  for ($count = 0; $count < count($_POST['item_no']); ++$count) {

    $item_no = $conn->escape_string($_POST['item_no'][$count]);
    $item_unit = $conn->escape_string($_POST['item_unit'][$count]);
    $item_qty = $conn->escape_string($_POST['item_qty'][$count]);
    $unit_price = '0';
    $exp_tot_amt_loc = $conn->escape_string($_POST['exp_tot_amt_loc'][$count]);
    if ($item_no > 0) {
      $insertownerQuery = "insert into indent_info (id, `office_code`, indent_from, indent_to,`indent_no`,indent_date ,`exp_delivery_date`,`requirement_type`,`item_no`,`item_unit`,`item_qty`,`unit_price`,`exp_tot_amt_loc`,`delivery_qty`,`due_qty`,`indent_status`,`status_date`,`ss_creator`,`ss_created_on`,`ss_org_no`) values (null, '$office_code', '$indent_from','$indent_to', '$indent_no','$indedent_date', '$exp_delivery_date','$requirement_type','$item_no','$item_unit','$item_qty','$unit_price','$exp_tot_amt_loc','0','$item_qty','0','$ss_created_on','$ss_creator','$indedent_date','$ss_org_no')";
      $conn->query($insertownerQuery);

      if ($conn->affected_rows == TRUE) {
        $message = "Successfully";
      } else {
        $mess = "Failled";
      }
    }
  }
   echo "<meta http-equiv=\"refresh\" content=\"0;URL=indent_detail.php\">";
}
require "../source/top.php";
$pid = 1013000;
$role_no = $_SESSION['sa_role_no'];
$office_no = $_SESSION['office_code'];

auth_page($conn, $pid, $role_no);
$querys = "insert into bach_no (username) values ('$_SESSION[username]')";
$returns = mysqli_query($conn, $querys);
$lastRows = $conn->insert_id;


require "../source/header.php";
require "../source/sidebar.php";

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Indent Detail</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>

    <!-- ====-- button define====== -->
    <button id="ScaleSetupBtn" class="btn btn-success"><a class="active"></i>Indent </button>
    <button id="ViewScaleBtn" class="btn btn-primary"><a class=""></i>indent List</button>

    <!-- =======button Define closed===== -->
    <div class=" row">
      <div class="col-md-12">
        <div id="ScaleSetup" class="collapse">
          <div style="padding:5px">
            <form method="post">
              <table class="table bg-light table-bordered table-sm">
                <thead>
                  <tr>
                    <th>Indent Number</th>
                    <th style="text-align: center">Indent Date</th>
                    <th style="text-align: center">Time</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> <input type="text" name="indent_no" readonly class="org_form org_12" autofocus value="<?php echo $lastRows;  ?>"></td>
                    <td> <input type="date" id="date" class="org_form" name="indedent_date" value="<?php echo date('Y-m-d'); ?>"></td>
                    <td><input type="text" id="date" class="org_form" id="clock" value="<?php date_default_timezone_set('Asia/Dhaka');
                           echo date("h:i:sa"); ?>" readonly>
                    </td>
                  </tr>
                </tbody>
              </table>
              <!-- ========== -->

              <div class="form-group row" <?php if ($_SESSION['office_code'] !== $_SESSION['org_no']) {
                                            echo "hidden";
                                          } ?>>
                <label class="col-sm-3 col-form-label"> Indent From/To</label>
                <label class="col-form-label">:</label>
                <div class="col-sm-6">
                  <select name="indent_from" class="form-control" required>
                    <option value="">-Select Office Code-</option>
                    <?php
                    $selectQuery = "SELECT office_code, office_name FROM office_info where office_code != '$office_no'";
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
                <label class="col-sm-3 col-form-label">Expected Deliver Date</label>
                <label class="col-form-label">:</label>
                <div class="col">
                  <input type="date" class="form-control" id="" name="exp_delivery_date">
                </div>
              </div>


              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Requirement Type</label>
                <label class="col-form-label">:</label>
                <div class="col">
                  <select name="requirement_type" class="form-control">
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
                    <th>Expected Value</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <!-- <td style="width: 20px"><input type="text" name="item_no[]" id="item_no" data-srno="1" value="1" class="item_no form-control" /></td> -->
                    <td>1</td>
                    <td><select name="item_no[]" class="form-control item_no unitChange" required>
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

                    <!-- !/ -->
                    <input name="item_unit[]" class="item_unit" hidden>
                    <td><input type="text" class="item_unit_name form-control" readonly></td>
                    <!--  -->

                    <td><input type="text" name="item_qty[]" id="item_qty" data-srno="1" class="item_qty form-control" /></td>
                    <td><input type="text" name="exp_tot_amt_loc[]" id="exp_tot_amt_loc" data-srno="1" class="item_qty form-control" /></td>
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
        <h5 style="text-align: center">View Indent List</h5>
        <table class="table table-hover table-bordered" id="GLAddTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Indent From</th>
              <th>Indent No.</th>
              <th> Indent Date</th>
              <th>Expected Delivery Date</th>
              <th>Item</th>
              <th> Quentity</th>
              <th hidden> expected Unit Price</th>
              <th>Expected Indent Value</th>
              <th>Delivery Qty.</th>
              <th>Due Qty.</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $indent_no = '';
            $sql = "select indent_info.id, indent_info.indent_from, indent_info.indent_to, indent_info.indent_no, indent_info.indent_date, indent_info.exp_delivery_date, indent_info.requirement_type, indent_info.item_no, indent_info.item_unit, indent_info.item_qty, indent_info.unit_price, indent_info.exp_tot_amt_loc, indent_info.indent_status,indent_info.delivery_qty, indent_info.due_qty, office_info.office_name, item.item_name, code_master.softcode, code_master.description from indent_info, office_info, item, code_master where indent_info.indent_from=office_info.office_code and indent_info.item_no=item.id AND item.unit=code_master.softcode and code_master.hardcode='UCODE';";
            $query = $conn->query($sql);
            while ($row = $query->fetch_assoc()) {

            ?>

              <tr>
                <td style="text-align: right"><?php if ($row['indent_no'] != $indent_no) {
                                                echo $row['id'];
                                              } else {
                                                echo "";
                                              } ?></td>


                <td style="text-align: right"><?php if ($row['indent_no'] != $indent_no) {
                                                echo $row['office_name'];
                                              } else {
                                                echo "";
                                              } ?></td>

                <td style="text-align: right"><?php if ($row['indent_no'] != $indent_no) {
                                                echo $row['indent_no'];
                                              } else {
                                                echo "";
                                              } ?></td>
                <td style="text-align: right"><?php if ($row['indent_no'] != $indent_no) {
                                                echo $row['indent_date'];
                                              } else {
                                                echo "";
                                              } ?></td>


                <td style="text-align: right"><?php if ($row['indent_no'] != $indent_no) {
                                                echo $row['exp_delivery_date'];
                                                $indent_no = $row['indent_no'];
                                              } else {
                                                echo "";
                                              } ?></td>




                <td style=" background-color:powderblue; text-align: left"><?php echo $row['item_name']; ?></td>
                <td style=" background-color:powderblue; text-align: right"><?php echo $row['item_qty'];
                                                                            echo "  ";
                                                                            echo $row['description']; ?></td>
                <td style=" background-color:powderblue; text-align: right" hidden><?php echo $row['unit_price']; ?></td>
                <td style="background-color:powderblue; text-align: right"><?php echo $row['exp_tot_amt_loc']; ?></td>
                <td style=" background-color:white; text-align: right"><?php echo $row['delivery_qty'];
                                                                        echo "  ";
                                                                        echo $row['description']; ?></td>
                <td style=" background-color:white; text-align: right"><?php echo $row['due_qty'];
                                                                        echo "  ";
                                                                        echo $row['description']; ?></td>

                <td><a <?php if ($row['indent_status'] != '0') {
                          echo "onclick='return false";
                        } ?> <?php echo "href='indent_detail_edit.php?id=" . $row['indent_no'] . "'"  ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Edit</a>
                </td>

                <!-- <td><a <?php "href=indent_detail_edit.php?id=" . $row['indent_no'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Edit</a>
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

  $("#907000").addClass('active');
  $("#900000").addClass('active');
  $("#900000").addClass('is-expanded');

  $(document).ready(function() {
    var count = 1;
    $(document).on('click', '#add_row', function() {
      count++;
      var html_code = '';
      html_code += '<tr id="row_id_' + count + '">';
      html_code += '<td><span id="sr_no">' + count + '</span></td>';
      html_code += '<td><select name="item_no[]" onchange="unitChangeRow(' + count + ')" id="item_no' + count + '" class="form-control item_no"><option value="">-Select Item-</option><?php $selectQuery = "SELECT `id`, `item_name` FROM `item` where sellable_option='N'"; $selectQueryResult = $conn->query($selectQuery); while ($row = $selectQueryResult->fetch_assoc()){ echo '<option value="' . $row['id'] . '">' . $row['item_name'] .'</option>';} ?></select></td>';
   
     // unit code
      html_code += '<td hidden><input name="item_unit[]" id="item_unit' + count + '" data-srno="' + count + '" class="item_unit form-control"></td>';
      // unit name show
      html_code += '<td><input  id="item_code' + count + '" data-srno="' + count + '" class="item_unit form-control" readonly></td>';
      html_code += '<td><input type="text" name="item_qty[]" id="item_qty' + count + '" data-srno="' + count + '" class="form-control item_qty"/></td>';
      html_code += '<td><input type="text" name="exp_tot_amt_loc[]" exp_tot_amt_loc' + count + '" data-srno="' + count + '" class="form-control exp_tot_amt_loc"/></td>';
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

  $('.unitChange').on('change', function(e) {
            e.preventDefault;
            var item_no = this.value;
            $.ajax({
                url: "getCashPurchase.php",
                method: "get",
                data: {
                    item_no_soft: item_no
                },
                success: function(response) {
                     console.log(response);
                    $('.item_unit').val(response);
                }
            });
             $.ajax({
                url: "getCashPurchase.php",
                method: "get",
                data: {
                    item_no_des: item_no
                },
                success: function(response) {
                     console.log(response);

                    $('.item_unit_name').val(response);
                }
            });
        });

        function unitChangeRow(count) {
            var item = $('#item_no' + count).val();
            var item_code = $('#item_no' + count).val();
            $.ajax({
                type: "get",
                url: "getCashPurchase.php",
                data: {
                    item: item
                },
                dataType: "text",
                success: function(response) {
                    console.log(response);
                    $('#item_code' + count).val(response);
                    // $('#item_unit' + count).val(response);
                }
            });
            $.ajax({
                type: "get",
                url: "getCashPurchase.php",
                data: {
                    item_code: item_code
                },
                dataType: "text",
                success: function(response) {
                    console.log(response);
                    $('#item_unit' + count).val(response);
                }
            });
        }

</script>
<?php
$conn->close();
?>
</body>

</html>