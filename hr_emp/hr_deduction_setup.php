<?php
require "../auth/auth.php";
require "../database.php";
$seprt_cs_info = $_SESSION['seprt_cs_info'];
if (isset($_POST['submit'])) {

    $office_code = $conn->escape_string($_SESSION['office_code']);
    $year_of_scale = $conn->escape_string($_POST['year_of_scale']);
    $desig_code = $conn->escape_string($_POST['desig_code']);
    $deduction_code = $conn->escape_string($_POST['deduction_code']);
    $deduction_desc = $conn->escape_string($_POST['deduction_desc']);
    $deduction_type = $conn->escape_string($_POST['deduction_type']);
    $deduction_amt = $conn->escape_string($_POST['deduction_amt']);
   
    // $desig_creat_dt = date('Y-m-d H:i:s');
    //$desig_abolished_dt = $conn->escape_string($_POST['desig_abolished_dt']);
    //$temporary = $conn->escape_string($_POST['temporary']);
    //$rec_status = $conn->escape_string($_POST['rec_status']);
    //$remarks = $conn->escape_string($_POST['remarks']);
    $ref_no = $conn->escape_string($_POST['ref_no']);
    $ref_date = $conn->escape_string($_POST['ref_date']);
    //$effect_date = $conn->escape_string($_POST['effect_date']);
    $ss_creator = $_SESSION['username'];
    $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];

    $insertData = "INSERT INTO hr_deduction_setup (office_code, year_of_scale, desig_code, 
    deduction_code, deduction_desc,  deduction_type, deduction_amt,ref_no, ref_date, is_current, 
    ss_creator, ss_created_on,ss_modifier,ss_modified_on,ss_org_no) values('$office_code', '$year_of_scale',
     '$desig_code','$deduction_code', '$deduction_desc','$deduction_type','$deduction_amt',
     '$ref_no', '$ref_date', '1', '$ss_creator','$ss_created_on','$ss_creator',
    '$ss_created_on','$ss_org_no')";


    //  echo $insertData;
    //  exit;
   

    $conn->query($insertData);

    if ($conn->affected_rows == 1) {
        $message = "Save owner Successfully!";
    } else {
        $mess = "Failled!";
    }
    header('refresh:1;hr_deduction_setup.php');
}

require "../source/top.php";
$pid = 1310000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Deduction Setup </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <?php if ($seprt_cs_info == 'Y') { ?>


        <!-- ===== button define ====== -->
        <div>
            <button id="desigAddBtn" class="btn btn-success"><i class="fa fa-plus"></i>Add Deduction Setup</button>
            <button id="desigListBtn" class="btn btn-primary"><i class="fa fa-eye"></i>View Deduction List</button>
        </div>
        <!-- ====== button Define closed ====== -->
        <div class="row">
            <div class="col-md-12">
                <div>
                    <div id="desigAdd" class="collapse">
                        <div style="padding:5px">
                            <!-- form start  -->
                            <form method="post">
                                <!-- ======= Office Code ======-->
                                <div class="form-row form-group">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">
                                                Setup Deduction
                                            </div>
                                            <div class="card-body">
                                                <!-- -=====Office Code======
                        <div class="form-group row">
                          <label class="col-sm-5 col-form-label">Office Code</label>
                          <label class="col-form-label">:</label>
                          <div class="col">
                            <input type="text" class="form-control" id="" name="office_code">
                          </div>
                        </div> -->
                                                <!---======Year Of Scale=======-->
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label">Year Of Scale</label>
                                                    <label class="col-form-label">:</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="" name="year_of_scale">
                                                    </div>
                                                </div>
                                                
                                                <!--======Designation Code=======--->
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label">Designation Code</label>
                                                    <label class="col-form-label">:</label>
                                                    <div class="col">
                                                    <select name="desig_code" class="form-control desig_code unitChange" required>
                                                            <option value="">-Select Designation Code-</option>
                                                            <?php
                                                            require '../database.php';
                                                            $selectQuery = 'SELECT desig_desc, desig_code FROM hr_desig';
                                                            $selectQueryResult = $conn->query($selectQuery);
                                                            if ($selectQueryResult->num_rows) {
                                                                while ($row = $selectQueryResult->fetch_assoc()) {
                                                            ?>
                                                            <?php
                                                                    echo '<option value="' . $row['desig_code'] . '">' . $row['desig_desc'] . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                             

                                                <!-- ======Deduction code=======-->

                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label">Deduction code</label>
                                                    <label class="col-form-label">:</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="" name="deduction_code" required>
                                                    </div>
                                                </div>

                                                <!--======Deduction Description=======--->

                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label">Deduction Description</label>
                                                    <label class="col-form-label">:</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="" name="deduction_desc">
                                                    </div>
                                                </div>

                                                <!--======Deduction Type=======--->

                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label">Deduction Type</label>
                                                    <label class="col-form-label">:</label>
                                                    <div class="col">
                                                   <input type="radio" id="amntslt" name="deduction_type" value="fixed" onclick="EnableDisableTextBox(this)" >
<label for="amount"> Fixed</label><br>

<input type="radio" id="amntperc" name="deduction_type" value="percentage" onclick="EnableDisableTextBox(this)" >
<label for="percentage"> Percentage</label>
                
                                                    </div>
                                                </div>

                                                <!--======Deduction Amount=======--->
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label">Deduction Amount</label>
                                                    <label class="col-form-label">:</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="allamnt" name="deduction_amt" disabled="disabled">
                                                    </div>
                                                </div>

                                                

                                                <!--======Reference number=======--->

                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label">Reference number</label>
                                                    <label class="col-form-label">:</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" id="" name="ref_no">
                                                    </div>
                                                </div>

                                                <!--======Reference date=======--->

                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label">Reference date</label>
                                                    <label class="col-form-label">:</label>
                                                    <div class="col">
                                                        <input type="date" class="form-control" id="" name="ref_date">
                                                    </div>
                                                </div>

                                                <div>
                                                    <input type="hidden" name="activation_key" value="0">
                                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
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
        <!-- ====== flat View List ====== -->
        <div class="tile" id="desigList">
            <div class="tile-body">
                <h5 style="text-align: center">Deduction List </h5>
                <!-- General Account View start -->
                <table class="table table-hover table-bordered" id="memberTable">
                    <thead>
                        <tr>
                            <th>Office Code</th>
                            <th>Year Of Scale</th>
                            <th>Designation </th>
                            <th>deduction Code</th>
                            <th>deduction Description</th>
                            <th>deduction Type</th>
                            <th>deduction Amount</th>
                            <th>Reference number</th>
                            <th>Reference Date</Th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $sql = "select hr_deduction_setup.*,hr_desig.desig_desc from hr_desig RIGHT JOIN hr_deduction_setup
                        ON hr_desig.desig_code=hr_deduction_setup.desig_code";
                        //use for MySQLi-OOP
                        $query = $conn->query($sql);
                        while ($row = $query->fetch_assoc()) {
                            $no++;
                            echo
                                "<tr>
                       <td>" . $row['office_code'] . "</td>
                       <td>" . $row['year_of_scale'] . "</td>
                       <td>" . $row['desig_desc'] . "</td>
                       <td>" . $row['deduction_code'] . "</td>
                       <td>" . $row['deduction_desc'] . "</td>
                       <td>" . $row['deduction_type'] . "</td>
                       <td>" . $row['deduction_amt'] . "</td>
                       <td>" . $row['ref_no'] . "</td>
                       <td>" . $row['ref_date'] . "</td>
                       <td><a target='_blank' href='hr_deduction_list_edit.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Edit</a>
                       </td>
								</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    } else {
        echo "<h6>NOT APPLICABLE FOR SEPERATE INFORMATION </h6>";
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
<script type="text/javascript">
    $('#sampleTable').DataTable();
    $('#memberTable').DataTable();
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#1310000").addClass('active');
        $("#1300000").addClass('active');
        $("#1300000").addClass('is-expanded')
    });

    $('#desigList').hide();

    // desigAddBtn
    $('#desigAddBtn').on('click', function() {
        $('#desigAdd').show();
        $('#desigList').hide();

    });
    // memberistBtn
    $('#desigListBtn').on('click', function() {
        $('#desigList').show();
        $('#desigAdd').hide();
    });

    function EnableDisableTextBox(amntslt) {
        var allamnt = document.getElementById("allamnt");
        allamnt.disabled = amntslt.checked ? false : true;
        if (!allamnt.disabled) {
            allamnt.focus();
        }
    }

    function EnableDisableTextBox(amntperc) {
        var allamnt = document.getElementById("allamnt");
        allamnt.disabled = amntperc.checked ? false : true;
        if (!allamnt.disabled) {
            allamnt.focus();
        }
    }

    $('.unitChange').on('change', function(e) {
            e.preventDefault;
            var desig_code = this.value;
            $.ajax({
                url: "getHrCommonCheck.php",
                method: "get",
                data: {
                    desig_code_soft: desig_code
                },
                success: function(response) {
                     console.log(response);
                    $('.grade_code').val(response);
                }
            });
            $.ajax({
                url: "getHrCommonCheck.php",
                method: "get",
                data: {
                    item_no_des: item_no
                },
                success: function(response) {
                     console.log(response);

                    $('.item_unit_name').val(response);
                }
            });
        })
</script>
<?php
$conn->close();

?>
</body>

</html>