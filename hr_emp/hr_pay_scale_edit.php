<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['editSubmit'])) {
  $id = intval($_GET['id']);
  $office_code = $conn->escape_string($_SESSION['office_code']);
  $year_of_scale = $conn->escape_string($_POST['year_of_scale']);
  $ref_no = $conn->escape_string($_POST['ref_no']);
  $ref_date = $conn->escape_string($_POST['ref_date']);
  $effect_date = $conn->escape_string($_POST['effect_date']);
  $desig_code = $conn->escape_string($_POST['desig_code']);
  $increment_type = $conn->escape_string($_POST['increment_type']);
 

  $ss_creator = $_SESSION['username'];
  $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
  $ss_org_no = $_SESSION['org_no'];

  for ($count = 0; $count < count($_POST['increment_slno']); ++$count) {
    $increment_slno = $conn->escape_string($_POST['increment_slno'][$count]);
    $increment_amt = $conn->escape_string($_POST['increment_amt'][$count]);
    $last_pay_amt = $conn->escape_string($_POST['last_pay_amt'][$count]);
    if ($increment_slno > 0) {
        $insertownerQuery = "UPDATE `hr_pscale_setup` SET `office_code`='$office_code',`year_of_scale`='$year_of_scale',`ref_no`='$ref_no',`ref_date`='$ref_date',`effect_date`='$effect_date',`desig_code`='$desig_code',`increment_type`='$increment_type',`increment_slno`='$increment_slno',`increment_amt`='$increment_amt',`last_pay_amt`='$last_pay_amt',`ss_creator`='$ss_creator',`ss_created_on`='$ss_created_on',`ss_org_no`='$ss_org_no' WHERE `id`=$id";
        $conn->query($insertownerQuery);

      if ($conn->affected_rows == TRUE) {
        $message = "Successfully";
      } else {
        $mess = "Failled";
      }
    }
  }
 // header('refresh:1;hr_set_pay_scale_setup');


}

?>
<?php
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $selectQueryEdit = "SELECT * from hr_pscale_setup where id=$id";
  $selectQueryEditResult = $conn->query($selectQueryEdit);
  $rows = $selectQueryEditResult->fetch_assoc();
}
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Edit Pay Scale </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div>
        <!--  Flat Information -->
        <div id="">
          <div style="padding:5px">
            <!-- form start  -->
            <form action="" method="post">
            
              <input type="text" class="form-control" id="" value="<?php echo $rows['id']; ?>" name="id" hidden>
                 <!-- Year of scale   -->
                 <div class="form-group row">
                <label class="col-sm-2 col-form-label">Year of Scale</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="year_of_scale" value="<?php echo $rows['year_of_scale']; ?>">
                </div>
              </div>

              <!-- Referance no.  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Referance Number</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="ref_no" value="<?php echo $rows['ref_no']; ?>">
                </div>
              </div>
              <!-- Referance date  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Referance Date</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="ref_date" value="<?php echo $rows['ref_date']; ?>">
                </div>
              </div>
              <!-- Effect Date  -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Effect Date</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="" name="effect_date" value="<?php echo $rows['effect_date']; ?>">
                </div>
              </div>
              
              <!-- Designation Code   -->
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Designation  </label>
                <div class="col-sm-6">
                <select name="desig_code" id="desig_code" class="form-control">
                            <option value="">- Select Designation -</option>
                            <?php
                            $selectQuery = 'SELECT * FROM `hr_desig`';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                              while ($row = $selectQueryResult->fetch_assoc()) {

                                if($row['desig_code'] == $rows['desig_code']){
                                  $selected = "selected";
                                }else{
                                  $selected = "";
                                }
                               
                                echo '<option value="' . $row['desig_code'] . '" '.$selected.' >' .$row['desig_desc'] . '</option>';
                              }
                            }
                            ?>
                </select>
                </div>
              </div>

              <!--  increment type   -->

              <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Increment Type</label>  
                   <label class="col-form-label">:</label>
                   <div class="col">
                   <input type="radio" id="increment_type" name="increment_type" value="fixed"<?php echo ($rows['increment_type']=='fixed')?'checked':'' ?>>
                  <label for="fixed">Fixed</label><br>
                  <input type="radio" id="increment_type" name="increment_type" value="percentage"<?php echo ($rows['increment_type']=='percentage')?'checked':'' ?> >
                  <label for="percentage">Percentage</label>
                   </div>
                </div>


              <!-- new table data -->

        
                               
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
                  <tr>
                    <!-- <td style="width: 20px"><input type="text" name="increment_slno[]" id="increment_slno" data-srno="1" value="1" class="increment_slno form-control" /></td> -->
                    <td style="width:20px"><input type="text" name ="increment_slno[]" id="increment_slno" data-srno='1' value ='<?php echo $rows['increment_slno']; ?>' class="increment_slno from-control"/></td>
                    <td><input type="text" name="increment_amt[]" id="increment_amtc" data-srno="1" value ='<?php echo $rows['increment_amt']; ?>' class="increment_amt form-control" /></td>
                    <td><input type="text" name="last_pay_amt[]" id="last_pay_amt" data-srno="1" value ='<?php echo $rows['last_pay_amt']; ?>' class="last_pay_amt form-control"/></td>
                    
             
                  </tr>
                </tbody>
              </table>

                           


              <!-- submit  -->
              <div class="form-group row">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="editSubmit">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>

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
              title: "Oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
        } else {
        }
        ?>
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

<!-- registration_division_district_upazila_jqu_script -->
<script type="text/javascript">
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

              
            increment_amt = $("input[name='increment_amt[]']").val();
           // alert(increment_amt);
         
            if (increment_amt > 0) {
             result=parseFloat(increment_amt)+parseFloat(lastarray[lastarray.length-1]);
             
             $('#last_pay_amt'+ j).val(result.toFixed(2));
               }
               
        }

        
        if(inc_type=='percentage'){
           lastarray =$("input[name='last_pay_amt[]']")
              .map(function(){return $(this).val();}).get();
              increment_amt = $("input[name='increment_amt[]']").val();


            if (increment_amt > 0) {
             result=(parseFloat(increment_amt)*parseFloat(lastarray[lastarray.length-1]))/100;
             final_result=parseFloat(result)+parseFloat(lastarray[lastarray.length-1]);
             console.log(final_result);
             $('.last_pay_amt' + j).val(final_result.toFixed(2));
               }
               
        }
       
         
        
                }
               
            }


    $(document).on('keyup', '.increment_amt', function() {     
        //var inc_amount =parseInt($(this).val());
       
        total(count);
        

    });

    $("#301000").addClass('active');
    $("#300000").addClass('active');
    $("#300000").addClass('is-expanded');
  });


 
</script>

<?php
$conn->close();
?>
</body>

</html>