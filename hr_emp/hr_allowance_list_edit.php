<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['editSubmit'])) {
    $id = intval($_GET['id']);
    $office_code = $_SESSION['office_code'];
    //$office_code = $conn->escape_string($_POST['office_code']);
    $year_of_scale = $conn->escape_string($_POST['year_of_scale']);
    $desig_code = $conn->escape_string($_POST['desig_code']);
    $allowance_code = $conn->escape_string($_POST['allowance_code']);
    $allowance_desc = $conn->escape_string($_POST['allowance_desc']);
    $allowance_type = $conn->escape_string($_POST['allowance_type']);
    $allowance_amt = $conn->escape_string($_POST['allowance_amt']);
    
    $ref_no = $conn->escape_string($_POST['ref_no']);
    $ref_date = $conn->escape_string($_POST['ref_date']);
    $ss_modifier = $_SESSION['username'];
    $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    $updateQuery = "UPDATE `hr_allowance_setup` SET `office_code`='$office_code',`year_of_scale`='$year_of_scale',
  `desig_code`='$desig_code', `allowance_code`='$allowance_code',
   `allowance_desc`='$allowance_desc', `allowance_type`='$allowance_type', `allowance_amt`='$allowance_amt',
    `ref_no`='$ref_no', `ref_date`='$ref_date',`ss_modifier`='$ss_modifier', 
    `ss_modified_on`=now(), `ss_org_no`='$ss_org_no' where id='$id'";

    // echo $updateQuery;
    // exit;



    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {
        $message = "Update Successfully!";
        header('refresh:1;hr_allowance_setup.php');
    } else {
        $mess = "Failled!";
    }
}
?>
<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $selectQueryEdit = "SELECT * FROM hr_allowance_setup where id='$id'";
    $selectQueryEditResult = $conn->query($selectQueryEdit);
    $rows = $selectQueryEditResult->fetch_assoc();
}

$selectQuerydes = "SELECT desig_desc FROM hr_desig where desig_code = $rows[desig_code]";
$selectQuerydesResult = $conn->query($selectQuerydes);
$row = $selectQuerydesResult->fetch_assoc();
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Edit Allowance Information </h1>
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

                            <!-- Designation Code -->
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
                            <!-- Year Of Scale -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Year Of Scale</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="" name="year_of_scale" value="<?php echo $rows['year_of_scale']; ?>">
                                </div>
                            </div>
                     
                            <!-- Allowance Code -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Allowance Code</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="" name="allowance_code" value="<?php echo $rows['allowance_code']; ?>">
                                </div>
                            </div>

                            <!-- Allowance Description -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Allowance Description</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="" name="allowance_desc" value="<?php echo $rows['allowance_desc']; ?>">
                                </div>
                            </div>

                            <!-- Allowance Type -->
  
                            <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label">Deduction Type</label>
                                                   
                                                    <div class="col-sm-6">
                                                   <input type="radio" id="amntslt" name="allowance_type" value="fixed"<?php echo ($rows['allowance_type']=='fixed')?'checked':'' ?> >
                                        <label for="amount"> Fixed</label><br>

                                        <input type="radio" id="amntperc" name="allowance_type" value="percentage"<?php echo ($rows['allowance_type']=='percentage')?'checked':'' ?>  >
                                        <label for="percentage"> Percentage</label>
                                                        
                                                    </div>
                             </div>

                            <!-- Allowance Amount -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Allowance Amount</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="" name="allowance_amt" value="<?php echo $rows['allowance_amt']; ?>">
                                </div>
                            </div>

                           
                            <!-- Reference Number -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Reference Number</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="" name="ref_no" value="<?php echo $rows['ref_no']; ?>">
                                </div>
                            </div>

                            <!-- Reference date -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Reference date</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" id="" name="ref_date" value="<?php echo $rows['ref_date']; ?>">
                                </div>
                            </div>

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