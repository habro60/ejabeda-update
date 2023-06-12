<?php
require "../auth/auth.php";
require "../database.php";

$seprt_cs_info = $_SESSION['seprt_cs_info'];


if (isset($_POST['submit'])) {

  

  $office_code = $conn->escape_string($_SESSION['office_code']);
  $year_of_scale = $conn->escape_string($_POST['year_of_scale']);
  $ref_no = $conn->escape_string($_POST['ref_no']);
  $ref_date = $conn->escape_string($_POST['ref_date']);
  $effect_date = $conn->escape_string($_POST['effect_date']);
  $desig_code = $conn->escape_string($_POST['desig_code']);
  $increment_type = $conn->escape_string($_POST['increment_type']);
  $start_pay_amt = '20000';
 
  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];
  // print_r($increment_type);
  // exit;
  
  for ($count = 0; $count < count($_POST['increment_slno']); ++$count) {
    $increment_slno = $conn->escape_string($_POST['increment_slno'][$count]);
    $increment_amt = $conn->escape_string($_POST['increment_amt'][$count]);
    $last_pay_amt = $conn->escape_string($_POST['last_pay_amt'][$count]);
    if ($increment_slno > 0) {
        $insertownerQuery = "INSERT INTO  hr_pscale_setup (`id`,`office_code`,`year_of_scale`,`ref_no`,`ref_date`,`effect_date`,`desig_code`,`increment_type`,`start_pay_amt`,`increment_slno`,`increment_amt`,`last_pay_amt`,`is_current`,`ss_creator`,`ss_created_on`,`ss_org_no`) values (null, '$office_code', '$year_of_scale','$ref_no','$ref_date','$effect_date','$desig_code', '$increment_type', '$start_pay_amt', '$increment_slno', '$increment_amt', '$last_pay_amt','1','$ss_creator','$ss_created_on', '$ss_org_no')";
        $conn->query($insertownerQuery);

      if ($conn->affected_rows == TRUE) {
        $message = "Successfully";
      } else {
        $mess = "Failled";
      }
    }
  }
  //header('refresh:1;hr_set_pay_scale_setup.php');
}
require "../source/top.php";
$pid = 205000;
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
      <h1><i class="fa fa-dashboard"></i> Pay Scale Setup</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <?php if ($seprt_cs_info == 'Y') { ?>

    <!-- ====-- button define====== -->
    <button id="ScaleSetupBtn" class="btn btn-success"><a class="active"></i>Scale Setup</button>
    <button id="ViewScaleBtn" class="btn btn-primary"><a class=""></i>View Scale List</button>
    
    <!-- =======button Define closed===== -->
    <div class=" row">
      <div class="col-md-12">
        <div id="ScaleSetup" class="collapse">
          <div style="padding:5px">
            <form method="post">
            
               <div class="form-group row">
                   <label class="col-sm-3 col-form-label">Year of Scale</label>
                   <label class="col-form-label">:</label>
                   <div class="col">
                        <input type="text" class="form-control" id="" name="year_of_scale">
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-3 col-form-label">Referance Number</label>
                   <label class="col-form-label">:</label>
                   <div class="col">
                        <input type="text" class="form-control" id="" name="ref_no">
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-3 col-form-label">Referance Date</label>
                   <label class="col-form-label">:</label>
                   <div class="col">
                        <input type="date" class="form-control" id="" name="ref_date">
                   </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Effect Date</label>  
                   <label class="col-form-label">:</label>
                   <div class="col">
                        <input type="date" class="form-control" id="" name="effect_date">
                   </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Designation</label>  
                   <label class="col-form-label">:</label>

                    <div class="col">
                      <!-- <select id="designation" name="designation" class="form-control">
                      <option value="">----- Select Any-----</option> -->

                    
                          <select name="desig_code" id="desig_code" class="form-control">
                            <option value="">- Select Designation -</option>
                            <?php
                            $selectQuery = 'SELECT * FROM `hr_desig`';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                              while ($row = $selectQueryResult->fetch_assoc()) {
                                echo '<option value="' . $row['desig_code'] . '">' . $row['desig_desc'] . '</option>';
                              }
                            }
                            ?>
                          </select>
                     

                       
                      
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Increment Type</label>  
                   <label class="col-form-label">:</label>
                   <div class="col">
                   <input type="radio"  id="increment_type" name="increment_type" value="fixed">
<label for="fixed">Fixed</label><br>
<input type="radio" id="increment_type" name="increment_type" value="percentage" >
<label for="percentage">Percentage</label>
                   </div>
                </div>
              <!-- =========  increment Input ======== -->
              <table class="table bg-light table-bordered table-sm" id="multi_table">
                <thead>
                  <tr class="table-active">
                    <th>Sl. No.</th>
                    <th>increment Amount</th>
                    <th>Current Pay Amount</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="parent">
                    <!-- <td style="width: 20px"><input type="text" name="increment_slno[]" id="increment_slno" data-srno="1" value="1" class="increment_slno form-control" /></td> -->
                    <td style="width:20px"><input type="text" name ="increment_slno[]" id="increment_slno" data-srno='1' value ='1' class="increment_slno from-control"/></td>
                    <td><input type="text" name="increment_amt[]" id="increment_amtc" data-srno="1" class="increment_amt form-control" /></td>
                    <td><input type="text" name="last_pay_amt[]" id="last_pay_amt" data-srno="1" class="last_pay_amt form-control"/></td>
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
        <h5 style="text-align: center">ViewScale Notice</h5>
        <table class="table table-hover table-bordered table-striped" id="GLAddTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Year of Scale</th>
              <th>Referance No.</th>
              <th>Referance Date</th>
              <th>Effect Date</th>
              <th>Designation</th>
              <th>Sl. No.</th>
              <th>increment Amount</th>
              <th>current Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "select hr_pscale_setup.*,hr_desig.desig_desc from hr_desig RIGHT JOIN hr_pscale_setup
            ON hr_desig.desig_code=hr_pscale_setup.desig_code";
            $query = $conn->query($sql);
            while ($row = $query->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['id'] . "</td>";
              echo "<td>" . $row['year_of_scale'] . "</td>";
              echo "<td>" . $row['ref_no'] . "</td>";
              echo "<td>" . $row['ref_date'] . "</td>";
              echo "<td>" . $row['effect_date'] . "</td>";
              echo "<td>" . $row['desig_desc'] . "</td>";
              echo "<td>" . $row['increment_slno'] . "</td>";
              echo "<td>" . $row['increment_amt'] . "</td>";
              echo "<td>" . $row['last_pay_amt'] . "</td>";
            ?>
              <td><a target='_blank' href='hr_pay_scale_edit.php?id=<?php echo $row['id']; ?>' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
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
      html_code += '<td><input type="text" name="increment_slno[]" id="increment_slno' + count + '" data-srno="' + count + '" value="' + count + '" class="form-control increment_slno"/></td>';
      html_code += '<td><input type="text" name="increment_amt[]" id="increment_amt' + count + '" data-srno="' + count + '" class="form-control increment_amt"/></td>';
      html_code += '<td><input type="text" name="last_pay_amt[]" id="last_pay_amt' + count + '" data-srno="' + count + '" class="form-control last_pay_amt"/></td>';
      html_code += '<td><button type="button" name="remove_row" id="' + count + '" class="form-control btn btn-danger btn-xl remove_row">-</button></td>';
      html_code += '</tr>';
      $('#multi_table').append(html_code);
    });
    $(document).on('click', '.remove_row', function() {
      var row_id = $(this).attr("id");
      $('#row_id_' + row_id).remove();
      count--;
    });


    function total(count) {
                 //alert(count);

              
                for (j = 1; j <= count; j++) {


                  var inc_type=$('input[name="increment_type"]:checked').val();
               
       
        if(inc_type=='fixed'){
           lastarray =$("input[name='last_pay_amt[]']")
              .map(function(){return $(this).val();}).get();
            increment_amt = $('#increment_amt' + j).val();


            if (increment_amt > 0 && count==j) {
             result=parseFloat(increment_amt)+parseFloat(lastarray[lastarray.length-2]);
             $('#last_pay_amt' + j).val(result.toFixed(2));
               }
               
        }

        
        if(inc_type=='percentage'){
           lastarray =$("input[name='last_pay_amt[]']")
              .map(function(){return $(this).val();}).get();
            increment_amt = $('#increment_amt' + j).val();


            if (increment_amt > 0 && count==j) {
             result=(parseFloat(increment_amt)*parseFloat(lastarray[lastarray.length-2]))/100;
             final_result=parseFloat(result)+parseFloat(lastarray[lastarray.length-2]);
             $('#last_pay_amt' + j).val(final_result.toFixed(2));
               }
               
        }
       
         
        
                }
               
            }


    $(document).on('keyup', '.increment_amt', function() {     
        //var inc_amount =parseInt($(this).val());
        total(count);
        //alert(count);

    });

  });
//salery calculate


    // function calculate(dis, paid) {
    //     var purchasesubtotal = 0;
    //     var purchasedue = 0;
    //     var purchasepaid = paid;
    //     // var del_shipping_charge = parseFloat(del_shipping_charge);
    //     //alert(del_shipping_charge);
    //     $(".ptotal").each(function() {
    //         purchasesubtotal = purchasesubtotal + ($(this).val() * 1);
    //     })
    //     purchasedue = purchasesubtotal - purchasepaid;
    //     $("#grand_total").val(purchasesubtotal.toFixed(2));
    //     $("#due").val(purchasedue.toFixed(2));

    // }



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