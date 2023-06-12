<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST['subBtn'])) {
    $org_no = $_POST['org_no'];
    $org_name = $_POST['org_name'];
    $org_addr1 = $_POST['org_addr1'];
    $org_addr2 = $_POST['org_addr2'];
    $org_email = $_POST['org_email'];
    $org_website = $_POST['org_website'];
    $org_fax = $_POST['org_fax'];
    $org_tel = $_POST['org_tel'];
    $org_country = $_POST['org_country'];
    $org_slorgan = $_POST['org_slorgan'];
    $org_fin_month = $_POST['org_fin_month'];
    $org_fin_year_st = $_POST['org_fin_year_st'];
    $org_budget_year = $_POST['org_budget_year'];
    $org_maintain_inv = $_POST['org_maintain_inv'];
    $org_loc_curr_symbol = $_POST['org_loc_curr_symbol'];
    $org_loc_curr_name = $_POST['org_loc_curr_name'];
    $org_for_symbol = $_POST['org_for_symbol'];
    $org_for_curr_name = $_POST['org_for_curr_name'];
    $org_no_of_decimal = $_POST['org_no_of_decimal'];
    $org_rounding_decl = $_POST['org_rounding_decl'];
    $org_rounding_type = $_POST['org_rounding_type'];
    $org_rounding_type = $_POST['org_rounding_type'];
    $ss_modifier_on = date("Y-m-d H:i:s");
    $idno = $_SESSION['org_no'];
    $updateQuery = "UPDATE `org_info` SET org_no='$org_no', org_name='$org_name', org_addr1='$org_addr1', org_addr2='$org_addr2',org_email='$org_email',org_website='$org_website', org_fax='$org_fax', org_tel='$org_tel', org_country='$org_country', org_slorgan='$org_slorgan', org_fin_month='$org_fin_month', org_fin_year_st='$org_fin_year_st', org_budget_year='$org_budget_year', org_maintain_inv='$org_maintain_inv', org_loc_curr_symbol='$org_loc_curr_symbol', org_loc_curr_name='$org_loc_curr_name', org_for_symbol='$org_for_symbol', org_for_curr_name='$org_for_curr_name', org_no_of_decimal='$org_no_of_decimal', org_rounding_decl='$org_rounding_decl', org_rounding_type='$org_rounding_type' WHERE org_no = '$idno'";
    $conn->query($updateQuery);
    if ($conn->affected_rows == 1) {
        $message = "Update Successfully";
    }
}
if (isset($_SESSION['org_no'])) {
    $selectQuery = "SELECT * FROM `org_info` WHERE org_no=$_SESSION[org_no]";
    // echo $selectQuery; exit;
    $selectQueryResult = $conn->query($selectQuery);
    //if($selectQueryResult->num_rows){		
    $rows = $selectQueryResult->fetch_array();
    //}
}
?>
<?php
require "../source/top.php";
$pid= 109000; 
$role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Organigation SetUp</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Blank Page</a></li>
        </ul>
    </div>

    <div class="org_main">
        <div class="org_left">
            <fieldset>
                <legend style="text-align: center;">General SetUp</legend>
                <div class="org_left_left">
                    <!-- --------------------------------------------------- -->
                    <form action="" method="post">
                        <!-- org no -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org No</label>
                            <div class="org_8">
                                <input type="text" name="org_no" id="" value="<?php echo $rows['org_no']; ?>" value="<?php echo $rows['org_no']; ?>" class="org_form">
                            </div>
                        </div>
                        <!-- org name -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Name</label>
                            <div class="org_8">
                                <input type="text" name="org_name" id="" value="<?php echo $rows['org_name']; ?>" class="org_form" required>
                            </div>
                        </div>
                        <!-- org email -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Email</label>
                            <div class="org_8">
                                <input type="email" name="org_email" id="" value="<?php echo $rows['org_email']; ?>" class="org_form" required>
                            </div>
                        </div>
                        <!-- org phone -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Phone</label>
                            <div class="org_8">
                                <input type="tel" name="org_tel" id="" value="<?php echo $rows['org_tel']; ?>" class="org_form" required>
                            </div>
                        </div>
                        <!-- org fax -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Fax</label>
                            <div class="org_8">
                                <input type="text" name="org_fax" id="" value="<?php echo $rows['org_fax']; ?>" class="org_form">
                            </div>
                        </div>
                        <!-- org website -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Website</label>
                            <div class="org_8">
                                <input type="text" name="org_website" id="" value="<?php echo $rows['org_website']; ?>" class="org_form">
                            </div>
                        </div>
                        <!-- org Address1 -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Address1</label>
                            <div class="org_8">
                                <input type="text" name="org_addr1" id="" value="<?php echo $rows['org_addr1']; ?>" class="org_form">
                            </div>
                        </div>
                        <!-- org Address2 -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Address2</label>
                            <div class="org_8">
                                <input type="text" name="org_addr2" id="" value="<?php echo $rows['org_addr2']; ?>" class="org_form">
                            </div>
                        </div>
                        <!-- org country -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Country</label>
                            <div class="org_8">
                                <input type="text" name="org_country" id="" value="<?php echo $rows['org_country']; ?>" class="org_form">
                            </div>
                        </div>
                        <!-- org slogan -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Slogan</label>
                            <div class="org_8">
                                <input type="text" name="org_slorgan" id="" value="<?php echo $rows['org_slorgan']; ?>" class="org_form">
                            </div>
                        </div>
                        <!-- --------------------------------------------------- -->

                </div>
                <div class="org_left_right">
                    <!-- for image  -->
                    <div class="form__profile">
                        <img src="../<?php echo $rows['org_logo']; ?>" id="profileImage" onclick="triggerClick()" class="form__logo" />
                        <input type="file" name="profiler" id="profile" value="../images/<?php echo $rows['org_logo']; ?>" onchange="displayImage(this)" style="display:none">
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="org_right">
            <!-- ---------------------------------------------  -->
            <fieldset>
                <legend style="text-align: center;">Other SetUp</legend>
                <!-- org org fin month year -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">Org Fin. Month</label>
                    <div class="org_3">
                        <select name="org_fin_month" class="org_form">
                            <option value="">---Select---</option>
                            <option value="January" <?php if ($rows['org_fin_month'] == "January") {
                                                        echo 'selected="selected"';
                                                    } ?>>January</option>
                            <option value="February" <?php if ($rows['org_fin_month'] == "February") {
                                                            echo 'selected="selected"';
                                                        } ?>>February</option>
                            <option value="March" <?php if ($rows['org_fin_month'] == "March") {
                                                        echo 'selected="selected"';
                                                    } ?>>March</option>
                            <option value="April" <?php if ($rows['org_fin_month'] == "April") {
                                                        echo 'selected="selected"';
                                                    } ?>>April</option>
                            <option value="May" <?php if ($rows['org_fin_month'] == "May") {
                                                    echo 'selected="selected"';
                                                } ?>>May</option>
                            <option value="June" <?php if ($rows['org_fin_month'] == "June") {
                                                        echo 'selected="selected"';
                                                    } ?>>June</option>
                            <option value="July" <?php if ($rows['org_fin_month'] == "July") {
                                                        echo 'selected="selected"';
                                                    } ?>>July</option>
                            <option value="August" <?php if ($rows['org_fin_month'] == "August") {
                                                        echo 'selected="selected"';
                                                    } ?>>August</option>
                            <option value="September" <?php if ($rows['org_fin_month'] == "September") {
                                                            echo 'selected="selected"';
                                                        } ?>>September</option>
                            <option value="October" <?php if ($rows['org_fin_month'] == "October") {
                                                        echo 'selected="selected"';
                                                    } ?>>October</option>
                            <option value="November" <?php if ($rows['org_fin_month'] == "November") {
                                                            echo 'selected="selected"';
                                                        } ?>>November</option>
                            <option value="December" <?php if ($rows['org_fin_month'] == "December") {
                                                            echo 'selected="selected"';
                                                        } ?>>December</option>
                        </select>
                    </div>
                    <label class="org_2 org_label extra">Org Fin. Year</label>
                    <div class="org_3">
                        <input type="date" name="org_fin_year_st" value="<?php echo $rows['org_fin_year_st']; ?>" class="org_form">
                    </div>
                </div>
                <!-- org Budget year -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">Org Budget year</label>
                    <div class="org_3">
                        <select name="org_budget_year" id="" value="<?php echo $rows['org_budget_year']; ?>" class="org_form">
                            <option value="">---Select---</option>
                            <option value="2017" <?php if ($rows['org_budget_year'] == "2017") {
                                                        echo 'selected="selected"';
                                                    } ?>>2017</option>
                            <option value="2018" <?php if ($rows['org_budget_year'] == "2018") {
                                                        echo 'selected="selected"';
                                                    } ?>>2018</option>
                            <option value="2019" <?php if ($rows['org_budget_year'] == "2019") {
                                                        echo 'selected="selected"';
                                                    } ?>>2019</option>
                            <option value="2020" <?php if ($rows['org_budget_year'] == "2020") {
                                                        echo 'selected="selected"';
                                                    } ?>>2020</option>
                            <option value="2021" <?php if ($rows['org_budget_year'] == "2021") {
                                                        echo 'selected="selected"';
                                                    } ?>>2021</option>
                            <option value="2022" <?php if ($rows['org_budget_year'] == "2022") {
                                                        echo 'selected="selected"';
                                                    } ?>>2022</option>
                        </select>
                    </div>
                    <label class="org_2 org_label extra">Org maintain</label>
                    <div class="org_3">
                        <select name="org_maintain_inv" class="org_form">
                            <option value="">---Select---</option>
                            <option value="y" <?php if ($rows['org_maintain_inv'] == "y") {
                                                    echo 'selected="selected"';
                                                } ?>>Yes</option>
                            <option value="n" <?php if ($rows['org_maintain_inv'] == "n") {
                                                    echo 'selected="selected"';
                                                } ?>>No</option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <!-- org loc currency symbol -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">loc Curr symbol</label>
                    <div class="org_9">
                        <input type="text" name="org_loc_curr_symbol" id="" value="<?php echo $rows['org_loc_curr_symbol']; ?>" class="org_form">
                    </div>
                </div>
                <!-- org loc currency name -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">loc Curr Name</label>
                    <div class="org_9">
                        <input type="text" name="org_loc_curr_name" id="" value="<?php echo $rows['org_loc_curr_name']; ?>" class="org_form">
                    </div>
                </div>
                <!-- org For currency symbol -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">For curr symbol</label>
                    <div class="org_9">
                        <input type="text" name="org_for_symbol" id="" value="<?php echo $rows['org_for_symbol']; ?>" class="org_form">
                    </div>
                </div>
                <!-- org for currency name -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">For curr Name</label>
                    <div class="org_9">
                        <input type="text" name="org_for_curr_name" id="" value="<?php echo $rows['org_for_curr_name']; ?>" class="org_form">
                    </div>
                </div>
                <!-- org no of decemel -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">No Of Decimal</label>
                    <div class="org_9">
                        <input type="text" name="org_no_of_decimal" id="" value="<?php echo $rows['org_no_of_decimal']; ?>" class="org_form">
                    </div>
                </div>
                <!-- org rounding deci -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">Rounding Decimal</label>
                    <div class="org_9">
                        <input type="text" name="org_rounding_decl" id="" value="<?php echo $rows['org_rounding_decl']; ?>" class="org_form">
                    </div>
                </div>
                <!-- org Rounding Type -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">Rounding Type</label>
                    <div class="org_9">
                        <input type="text" name="org_rounding_type" id="" value="<?php echo $rows['org_rounding_type']; ?>" class="org_form">
                    </div>
                </div>
            </fieldset>
            <!-- ---------------------------------------------  -->

        </div>
    </div>
    <div class="org_buttom clearfix text-center">
        <input type="submit" value="Update" name="subBtn" class="btn btn-success">
        <input type="submit" value="Cancel" name="cancel" class="btn btn-danger"><br>
    </div>

    </form>
    <!-- code here end -->

</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<script src="../js/profile.js"></script>

<script>
    $(document).ready(function() {
        $("#201000").addClass('active');
        $("#200000").addClass('active');
        $("#200000").addClass('is-expanded');
    });
</script>
</body>

</html>