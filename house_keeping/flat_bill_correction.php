<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];


function get_gl_code($batch_no,$all_bill){

foreach ( $all_bill as $var ) {
 


  if($var['batch_no']==$batch_no){
    return $var['woner_gl_account'];
  }


 
}

return 0;



}
 
if (isset($_POST['assignServices'])) {
  //$a = $_POST['owner'];
$old_bill_amount=[];
$new_bill_amount=[];
$uniqe_batch_no=[];
  $flat_no_for_tran = $_POST['flat_no_for_tran'];

  $bill_for_month_tran = $_POST['bill_for_month_tran'];

  for ($count = 0; $count < count($_POST['flat_no']); ++$count) {
    $id = $_POST['id'][$count];
    $sql="SELECT bill_amount,owner_gl_code,link_gl_acc_code,batch_no FROM `apart_owner_bill_detail` WHERE id=$id;";
    $query = mysqli_query($conn, $sql);
    $rows=mysqli_fetch_assoc($query);
    //$old_bill_amount=$rows['bill_amount'];
    $a=$rows['bill_amount'];
    $b=$rows['owner_gl_code'];
    $c=$rows['link_gl_acc_code'];
    $d=$rows['batch_no'];
    $newdata =  array (
      'bill_amount' => "$a",
      'woner_gl_account' => "$b",
      'link_gl_account' => "$c",
      'batch_no' => "$d"
    );

    
    //array_unique($uniqe_batch_no);
    array_push($uniqe_batch_no,$d);
    array_push($old_bill_amount,$newdata);
    
    $bill_amount = $_POST['bill_amount'][$count];


    array_push($new_bill_amount,$bill_amount);

    //for woner bill deteils update

    if ($id > 0) {
      $query = "update `apart_owner_bill_detail` set `bill_amount`='$bill_amount' where id='$id'";
      // echo $query;
      // exit;
      $conn->query($query);
       
    }

    if ($conn->affected_rows == TRUE) {

      $message = "Successfully";
    } else {
      $assign_menu_failled = "Failled";
    }
    
  }
  
  $batch_no=array_unique($uniqe_batch_no);
  
  $length=count($batch_no);
  $i=0;
  $nextVal= $batch_no[$i];

  // sum  fixed amount and variable amount and update
  while($length!=0){
    
    $sql_dr="SELECT SUM(bill_amount) AS dr_amount FROM apart_owner_bill_detail 
    WHERE bill_for_month =  '$bill_for_month_tran' AND 
    `flat_no`='$flat_no_for_tran' AND batch_no='$nextVal'";
    $query2= mysqli_query($conn,$sql_dr);
    $rows=mysqli_fetch_assoc($query2);
    $total_bill=$rows['dr_amount'];
    $gl_code=get_gl_code($nextVal,$old_bill_amount);

    $query = "update `tran_details` set `dr_amt_loc`='$total_bill' where batch_no='$nextVal'and gl_acc_code='$gl_code'";
    $query=mysqli_query($conn,$query);

    $nextVal = next($batch_no);

    $length--;
  }

  //$tlength=count($old_bill_amount);

  //for cr_amt_update
$i=0;
  foreach ( $old_bill_amount as $var ) {
    // echo "\n", $var['link_gl_account'], "\t\t", $var['woner_gl_account'];
    // echo";". floatval($var['bill_amount']);
    // echo";". floatval($new_bill_amount[$i]);
    $b_number=$var['batch_no'];
    $link_number=$var['link_gl_account'];
   $result=floatval($var['bill_amount'])-floatval($new_bill_amount[$i]);

   $sql_dr="SELECT cr_amt_loc FROM tran_details 
  where  batch_no='$b_number'  and gl_acc_code='$link_number'";
  
   $query2= mysqli_query($conn,$sql_dr);
   $rows=mysqli_fetch_assoc($query2);
      
    $total_cr=$rows['cr_amt_loc'];
    $final_result=floatval($total_cr)-floatval($result);

      $sql = "update `tran_details` set  cr_amt_loc='$final_result' where  batch_no='$b_number'  and gl_acc_code='$link_number'";
      $query=mysqli_query($conn,$sql);

      //echo "final_cr".$final_result."batch".$b_number."LINK".$link_number;
   $i++;
    
   }
   
// echo $final_result;
// die;


  
//print_r($old_bill_amount);
//print_r($new_bill_amount);
  //die;
  echo "<meta http-equiv=\"refresh\" content=\"0;URL=flat_bill_correction.php\">";
}
?>

<?php
require "../source/top.php";
$pid = 1301000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fa fa-dashboard"></i> Flat Bill Correction</h1>
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
          
          <div class="card" id="BillCorrection">
            <div class="card-header" style="background-color:#85C1E9">
              <h4 style="text-align:center">Assign Services to Owner</h4>
            </div>
            <div class="card-body">
              <table style="width: 100%">
                <th>Flat Number</th>
                <th>For Month</th>
                <th></th>
                <tbody>
                  <tr>
                    <form method="POST" name="search">
                      <div class="search-box">
                        <td>
                          <select name="flat_no" id="flat_no" class="form-control">
                            <option value="">- Select Flat -</option>
                            <?php
                            $selectQuery = 'SELECT flat_no FROM `flat_info`';
                            $selectQueryResult = $conn->query($selectQuery);
                            if ($selectQueryResult->num_rows) {
                              while ($row = $selectQueryResult->fetch_assoc()) {
                                echo '<option value="' . $row['flat_no'] . '">' . $row['flat_no'] . '</option>';
                              }
                            }
                            ?>
                          </select>
                        </td>
                        <td> <input type="month" name="bill_for_month" id="bill_for_month" class="form-control" required></td>                        </td>
                        <td><input class="btn btn-info" id="search" value=" Search Now !" onclick="BillAssign()" readonly></td>
                      </div>
                    </form>
                  </tr>
                </tbody>
              </table> <br>
              <div id="serviceResult">
                <!-- serviceResult -->
              </div>
            </div>
          </div>
        <?php
      } else {
        echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
      } ?>
        <!-- end of service facility -->
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
              title: "oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
          } else {
          }
          ?>

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
  
  // on change
  $('#submit').hide();
  $(document).on('change', '.owner', function() {
    $('.owner').val($(this).val());
    $(".owner").addClass("intro");
    // show and hide
    $('#submit').show();
  });
  

  function BillAssign() {
    var bill_for_month = $('#bill_for_month').val();
    var flat_no = $('#flat_no').val();
    $.ajax({
      type: "POST",
      url: "getBill.php",
      data: {
        bill_for_month: bill_for_month,
        flat_no: flat_no
      },
      dataType: "Text",
      success: function(response) {
        $('#serviceResult').html(response);
      }
    });
  }
</script>
<?php
$conn->close();
?>
</body>

</html>