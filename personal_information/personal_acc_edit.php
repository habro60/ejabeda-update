<?php
require "../auth/auth.php";
require "../database.php";

if (isset($_POST['editSubmit'])) {
    $id = intval($_GET['id']);
    $office_code = $_SESSION['office_code'];
    // $acc_code = $conn->escape_string($_POST['owner_id']);
    $acc_head = $conn->escape_string($_POST['acc_head']);
    $category_code = $conn->escape_string($_POST['category_code']);
    $ss_modifier = $_SESSION['username'];
    $ss_modified_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    $updateQuery = "UPDATE `personal_account` SET `office_code`='$office_code',`category_code`='$category_code',
  `acc_head`='$acc_head',`ss_modifier`='$ss_modifier',`ss_modified_on`=now(),
   `ss_org_no`='$ss_org_no' where id='$id'";

    // echo $updateQuery;
    // exit;



    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {
        $message = "Update Successfully!";
        header('refresh:1;personal_acc.php');
    } else {
        $mess = "Failled!";
    }
}
?>
<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $selectQueryEdit = "SELECT * FROM personal_account where id='$id'";
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
            <h1><i class="fa fa-dashboard"></i> Edit A/C Information </h1>
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
                            <!-- A/C Head -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">A/C Head</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="" name="acc_head" value="<?php echo $rows['acc_head']; ?>">
                                </div>
                            </div>
                            <!-- Category Code -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category Code</label>
                                <div class="col-sm-6">
                                <select required name="category_code" id="" class="form-control">
                                    <option value="1" <?php if ($rows['category_code']== "1") {echo 'selected="selected"';} ?>>Cash</option>
                                    <option value="2" <?php if ($rows['category_code']== "2") {echo 'selected="selected"';} ?>>Bank</option>
                                    <option value="3" <?php if ($rows['category_code']== "3") {echo 'selected="selected"';} ?>>Income</option>
                                    <option value="4" <?php if ($rows['category_code']== "4") {echo 'selected="selected"';} ?>>Expenses</option>
                                     
                               </select>                                </div>
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