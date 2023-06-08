<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['subBtn'])) {
    $office_code = $_SESSION['office_code'];
    $bank_acc_no = $_POST['bank_acc_no'];
    $acc_name = $_POST['acc_name'];
    $bank_code = $_POST['bank_code'];
    $bank_name = $_POST['bank_name'];
    $branch_code = $_POST['branch_code'];
    $branch_name = $_POST['branch_name'];
    $bank_address = $_POST['bank_address'];
    $gl_acc_code = $_POST['gl_acc_code'];
    $ss_creator = $_SESSION['username'];
    $ss_creator_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_modifier = $_SESSION['username'];
    $ss_modifier_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    $insertQuery = "INSERT INTO `bank_acc_info` (`office_code`, `bank_acc_no`,`acc_name`, `bank_code`,`bank_name`,`branch_code`,`branch_name`,`bank_address`,`gl_acc_code`,`ss_creator`,`ss_creator_on`,ss_modifier, ss_modifier_on,`ss_org_no`) VALUES ('$office_code','$bank_acc_no','$acc_name','$bank_code','$bank_name','$branch_code','$branch_name','$bank_address','$gl_acc_code','$ss_creator','$ss_creator_on','$ss_modifier','$ss_modifier_on','$ss_org_no')";
    $conn->query($insertQuery);
    if ($conn->affected_rows == 1) {
        $message = "Successfully";
    } else {
        // $message = "Save Invalid !!";
        echo "<script>alert('Save Invalid !!')</script>";
    }
    // header('refresh:0; url=bank_acc_info.php');
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=bank_acc_info.php\">";
}
require "../source/top.php";
$pid = 801000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Bank Account Information </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <?php if ($seprt_cs_info == 'Y') { ?>
        <div>
            <button id="bankbtn" class="btn btn-success col-3"><i class="fa fa-plus" aria-hidden="true"></i>Bank info. </button>
            <button data-toggle="" data-target="#gl_account" id="bankglbtn" class="btn btn-info col-3"><i class="fa fa-plus" aria-hidden="true"></i>GL A/C For Bank</button>
            <button id="banklistbtn" class="btn btn-primary col-3"><i class="fa fa-eye" aria-hidden="true"></i> Bank List </button>

        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <form method="post" id="bankForm">
                    <!-- Bank Account No. -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Bank Account No.</label>
                        <div class="col-sm-6">
                            <input type="text" name="bank_acc_no" class="form-control" id="" placeholder="Bank Account No" required>
                        </div>
                    </div>
                    <!-- Account Name -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Account Name</label>
                        <div class="col-sm-6">
                            <input type="text" name="acc_name" class="form-control" id="" placeholder="Account Name" required>
                        </div>
                    </div>
                    <!-- Bank Code  -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Bank</label>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" name="bank_code" class="form-control" id="" placeholder="Bank Code" required>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="bank_name" class="form-control" id="" placeholder="Bank Name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Branch name  -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Branch</label>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" name="branch_code" class="form-control" id="" placeholder="Branch Code" required>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="branch_name" class="form-control" id="" placeholder="Branch Name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bank Address  -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Bank Address </label>
                        <div class="col-sm-6">
                            <input type="text" name="bank_address" class="form-control" id="" placeholder="Bank Address" required>
                        </div>
                    </div>
                    <!-- General Account Code  -->
                    <input type="text" name="gl_acc_code" class="form-control" id="" hidden>
                    <!-- submit  -->
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <input type="submit" class="btn btn-primary" name="subBtn" value="submit">
                            <input type="reset" class="btn btn-danger" name="subBtn" value="cancel">
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
        ?>
        <div class="tile" id="banklist">
            <div class="tile-body">
                <h5 style="text-align: center">Bank List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered table-responsive" id="bankTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Office Name</th>
                            <th>A/C No</th>
                            <th>A/C Name</th>
                            <th>Bank Code </th>
                            <th>Bank Name</th>
                            <th>Bank Address</th>
                            <th>Gl A/C Code </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = "SELECT bank_acc_info.id,bank_acc_info.office_code,bank_acc_info.bank_acc_no,bank_acc_info.acc_name,bank_acc_info.bank_code,bank_acc_info.bank_name,bank_acc_info.bank_address,bank_acc_info.gl_acc_code,office_info.office_code, office_info.office_name FROM bank_acc_info, office_info where bank_acc_info.office_code=office_info.office_code";
                        $query = $conn->query($sql);
                        while ($row = $query->fetch_assoc()) {
                            echo
                                "<tr>
									<td>" . $no++ . "</td>
									<td>" . $row['office_name'] . "</td>
									<td>" . $row['bank_acc_no'] . "</td>
									<td>" . $row['acc_name'] . "</td>
									<td>" . $row['bank_code'] . "</td>
									<td>" . $row['bank_name'] . "</td>
									<td>" . $row['bank_address'] . "</td>
									<td>" . $row['gl_acc_code'] . "</td>
                                    <td>
                                    <a href='bank_acc_info_edit.php?id=" . $row['id'] . "' target='_blank' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                                </td>
								</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tile" id="bankGlAcc">
            <div class="tile-body">
                <h5 style="text-align: center">Bank General Account List</h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="GLTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Account Code</th>
                            <th>Account Name</th>
                            <th>Printing GL Code</th>
                            <th>Ledger</th>
                            <th>Account Type</th>
                            <th>Add Supplier GL A/C</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT gl_acc_code.id, gl_acc_code.category_code,gl_acc_code.acc_code,gl_acc_code.acc_head,gl_acc_code.rep_glcode,gl_acc_code.parent_acc_code,gl_acc_code.postable_acc,gl_acc_code.acc_level,gl_acc_code.acc_type,code_master.hardcode,code_master.softcode,code_master.description,code_master.sort_des FROM gl_acc_code,code_master where gl_acc_code.category_code=code_master.softcode AND code_master.hardcode='acat'AND gl_acc_code.acc_type='2' ORDER by acc_code";
                        $query = $conn->query($sql);
                        while ($rows = $query->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $rows['id'] . "</td>";
                            echo "<td>" . $rows['description'] . "</td>";
                            echo "<td>" . $rows['acc_code'] . "</td>";
                            echo "<td>" . $rows['acc_head'] . "</td>";
                            echo "<td>" . $rows['rep_glcode'] . "</td>";
                            
                            ?>
                     <td style="text-align: left"><?php if ($rows['postable_acc'] =='N') {
                                                            echo "Group A/C"; 
                                                        } else {
                                                            echo "Ledger A/C";
                                                        }?></td>  

                     
                      <td style="text-align: left"><?php if ($rows['acc_type'] =='2') {
                                                        echo "Bank A/C"; 
                                                        } else {
                                                            echo "";
                                                        }?></td>  

                     
                            
                            
                            <!--echo "<td>" . $rows['postable_acc'] . "</td>";-->
                            <!--echo "<td>" . $rows['acc_type'] . "</td>";-->
                        
                            <td><a <?php if ($rows['postable_acc'] != 'N') {
                                        echo "onclick='return false";
                                    } ?> <?php echo "href='bank_gl_account_add.php?id=" . $rows['id'] . "'" ?> class='btn btn-success btn-sm'><span class='fa fa-plus'></span>Add</a>
                            </td>
                        <?php

                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- Data table plugin-->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>
<script type="text/javascript">
    $('#GLTable').DataTable();
    $('#bankTable').DataTable();
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#801000").addClass('active');
        $("#800000").addClass('active');
        $("#800000").addClass('is-expanded')
    });

    $('#bankGlAcc').hide();
    $("#bankViewList").hide();
    $('#bankForm').hide();
    //bank information

    $('#bankbtn').on('click', function() {
        $('#bankForm').show();
        $('#bankGlAcc').hide();
        $("#banklist").hide();
    });
    // Bank List
    $('#banklistbtn').on('click', function() {
        $('#banklist').show();
        $('#bankForm').hide();
        $('#bankGlAcc').hide();
    });
    // bank Gl Account
    $("#bankglbtn").on('click', function() {
        $("#bankGlAcc").show();
        $("#bankForm").hide();
        $("#banklist").hide();
    });
</script>
</body>

</html>