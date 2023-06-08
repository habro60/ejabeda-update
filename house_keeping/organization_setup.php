<?php
require "../auth/auth.php";
require "../database.php";
?>
<?php
//insrt query
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



    $insertQuery = "INSERT INTO `org_info` (`org_no`, `org_name`, `org_addr1`, `org_addr2`,`org_email`,`org_website`,`org_fax`,`org_tel`,`org_country`,`org_slorgan`,`org_fin_month`,`org_fin_year_st`,`org_budget_year`,`org_maintain_inv`,`org_loc_curr_symbol`,`org_loc_curr_name`,`org_for_symbol`,`org_for_curr_name`,`org_no_of_decimal`,`org_rounding_decl`,`org_rounding_type`) VALUES ('$org_no','$org_name','$org_addr1','$org_addr2','$org_email','$org_website','$org_fax','$org_tel','$org_country','$org_slorgan','$org_fin_month','$org_fin_year_st','$org_budget_year','$org_maintain_inv','$org_loc_curr_symbol','$org_loc_curr_name','$org_for_symbol','$org_for_curr_name','$org_no_of_decimal','$org_rounding_decl','$org_rounding_type')";

    $conn->query($insertQuery);
    //   echo $insertQuery; exit;
    if ($conn->affected_rows == 1) {
        $message = "Save Successfully";
    }

    //   header("Location:organization.php");
}
?>
<?php
require "../source/top.php";
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Organigation SetUp</h1>
            <!-- <p>Start a beautiful journey here</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Blank Page</a></li>
        </ul>
    </div>

    <!-- code here start -->
    <style>
        .org_main {
            width: 90%;
            height: 510px;
            margin: 0 auto;
            /* background-color: red; */
            /* clear: both; */
        }

        .org_left {
            float: left;
            width: 48%;
            /* background-color: magenta; */
            height: 440px;
            padding: 10px;
        }

        .org_right {
            float: right;
            width: 48%;
            /* background-color: blue; */
            height: 440px;
            padding: 10px;


        }

        .org_group {
            margin-bottom: 1rem;
        }

        .org_row {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            /* margin-left: 5px; */
        }

        .org_label {
            padding-top: calc(0.375rem + 2px);
            padding-bottom: calc(0.375rem + 2px);
            margin-bottom: 0;
            font-size: inherit;
            line-height: 1;
        }

        .org_1 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 8.3333333333%;
            flex: 0 0 8.3333333333%;
            max-width: 8.3333333333%;
        }

        .org_2 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 16.6666666667%;
            flex: 0 0 16.6666666667%;
            max-width: 16.6666666667%;
        }

        .org_3 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }

        .org_4 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 33.3333333333%;
            flex: 0 0 33.3333333333%;
            max-width: 33.3333333333%;
        }

        .org_5 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 41.6666666667%;
            flex: 0 0 41.6666666667%;
            max-width: 41.6666666667%;
        }

        .org_6 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .org_7 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 58.3333333333%;
            flex: 0 0 58.3333333333%;
            max-width: 58.3333333333%;
        }

        .org_8 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 66.6666666667%;
            flex: 0 0 66.6666666667%;
            max-width: 66.6666666667%;
        }

        .org_9 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 75%;
            flex: 0 0 75%;
            max-width: 75%;
        }

        .org_10 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 83.3333333333%;
            flex: 0 0 83.3333333333%;
            max-width: 83.3333333333%;
        }

        .org_11 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 91.6666666667%;
            flex: 0 0 91.6666666667%;
            max-width: 91.6666666667%;
        }

        .org_12 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }

        .org_form {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1;
            color: #495057;
            background-color: #FFF;
            background-clip: padding-box;
            border: 2px solid #ced4da;
            border-radius: 4px;
            -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            -o-transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;

        }

        .org_left_left {
            float: left;
            width: 75%;

        }

        .org_left_right {
            float: right;
            width: 23%;
            /* background-color: red; */
        }

        .form__logo {
            background-color: #eee;
            height: 145px;
            width: 145px;
            border-radius: 50%;
            margin-top: -10px;
        }

        .form__profile {
            display: -webkit-box !important;
            display: -ms-flexbox !important;
            display: flex !important;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .extra {
            margin-left: 40px;
        }

        /* for tab  */
        @media only screen and (max-width: 800px) {
            .org_left {
                width: 100%;
                float: left;
            }

            .org_right {
                width: 100%;
                float: left;
                margin-top: 160px;
            }

            .org_left_left {
                width: 100%;
            }

            .org_left_right {
                width: 100%;
                margin-top: 10px;
            }

            .org_1,
            .org_2,
            .org_3,
            .org_4,
            .org_5,
            .org_6,
            .org_7,
            .org_8,
            .org_9,
            .org_10,
            .org_11,
            .org_12 {
                width: 100%;
            }

            .org_form {
                width: 100%;
            }

        }

        /* for Mobile  */
        @media only screen and (max-width: 500px) {
            .org_left {
                width: 100%;
                float: left;
            }

            .org_right {
                width: 100%;
                float: left;
                margin-top: 160px;
            }

            .org_left_left {
                width: 100%;
            }

            .org_left_right {
                width: 100%;
                margin-top: 10px;
            }

            .org_1,
            .org_2,
            .org_3,
            .org_4,
            .org_5,
            .org_6,
            .org_7,
            .org_8,
            .org_9,
            .org_10,
            .org_11,
            .org_12 {
                width: 100%;
            }

            .org_label {
                width: 100%;
            }

        }

        .org_buttom {
            /* margin-top: 20px; */
            width: 20%;
            /* background-color: red; */
            height: 50px;
            margin-left: auto;
            margin-right: auto;

        }
    </style>

    <div class="org_main">

        <div class="org_left">
            <fieldset>
                <legend style="text-align: center;">General SetUp</legend>
                <div class="org_left_left">


                    <?php if (isset($message)) echo $message; ?>
                    <!-- --------------------------------------------------- -->
                    <form action="" method="post">
                        <!-- org no -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org No</label>
                            <div class="org_8">
                                <input type="text" name="org_no" id="" class="org_form">
                            </div>
                        </div>
                        <!-- org name -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Name</label>
                            <div class="org_8">
                                <input type="text" name="org_name" id="" class="org_form" required>
                            </div>
                        </div>
                        <!-- org email -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Email</label>
                            <div class="org_8">
                                <input type="email" name="org_email" id="" class="org_form" required>
                            </div>
                        </div>
                        <!-- org phone -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Phone</label>
                            <div class="org_8">
                                <input type="tel" name="org_tel" id="" class="org_form" required>
                            </div>
                        </div>
                        <!-- org fax -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Fax</label>
                            <div class="org_8">
                                <input type="text" name="org_fax" id="" class="org_form" required>
                            </div>
                        </div>
                        <!-- org website -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Website</label>
                            <div class="org_8">
                                <input type="text" name="org_website" id="" class="org_form" required>
                            </div>
                        </div>
                        <!-- org Address1 -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Address1</label>
                            <div class="org_8">
                                <input type="text" name="org_addr1" id="" class="org_form" required>
                            </div>
                        </div>
                        <!-- org Address2 -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Address2</label>
                            <div class="org_8">
                                <input type="text" name="org_addr2" id="" class="org_form" required>
                            </div>
                        </div>
                        <!-- org country -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Country</label>
                            <div class="org_8">
                                <input type="text" name="org_country" id="" class="org_form" required>
                            </div>
                        </div>
                        <!-- org slogan -->
                        <div class="org_row org_group">
                            <label class="org_3 org_label">Org Slogan</label>
                            <div class="org_8">
                                <input type="text" name="org_slorgan" id="" class="org_form" required>
                            </div>
                        </div>
                        <!-- --------------------------------------------------- -->

                </div>
                <div class="org_left_right">
                    <!-- for image  -->
                    <div class="form__profile">
                        <img src="../images/profile-icon-9.png" id="profileImage" onclick="triggerClick()" class="form__logo" />
                        <input type="file" name="profiler" id="profile" onchange="displayImage(this)" style="display:none">
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
                        <select name="org_fin_month" id="" class="org_form">
                            <option value="">---Select---</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <label class="org_2 org_label extra">Org Fin. Year</label>
                    <div class="org_3">
                        <select name="org_fin_year_st" id="" class="org_form">
                            <option value="">---Select---</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                        </select>
                    </div>
                </div>
                <!-- org Budget year -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">Org Budget year</label>
                    <div class="org_3">
                        <select name="org_budget_year" id="" class="org_form">
                            <option value="">---Select---</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                        </select>
                    </div>
                    <label class="org_2 org_label extra">Org maintain</label>
                    <div class="org_3">
                        <select name="org_maintain_inv" id="" class="org_form">
                            <option value="">---Select---</option>
                            <option value="y">Yes</option>
                            <option value="n">No</option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <!-- org loc currency symbol -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">loc Curr symbol</label>
                    <div class="org_9">
                        <input type="text" name="org_loc_curr_symbol" id="" class="org_form">
                    </div>
                </div>
                <!-- org loc currency name -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">loc Curr Name</label>
                    <div class="org_9">
                        <input type="text" name="org_loc_curr_name" id="" class="org_form">
                    </div>
                </div>
                <!-- org For currency symbol -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">For curr symbol</label>
                    <div class="org_9">
                        <input type="text" name="org_for_symbol" id="" class="org_form">
                    </div>
                </div>
                <!-- org for currency name -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">For curr Name</label>
                    <div class="org_9">
                        <input type="text" name="org_for_curr_name" id="" class="org_form">
                    </div>
                </div>
                <!-- org no of decemel -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">No Of Decimal</label>
                    <div class="org_9">
                        <input type="text" name="org_no_of_decimal" id="" class="org_form">
                    </div>
                </div>
                <!-- org rounding deci -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">Rounding Decimal</label>
                    <div class="org_9">
                        <input type="text" name="org_rounding_decl" id="" class="org_form">
                    </div>
                </div>
                <!-- org Rounding Type -->
                <div class="org_row org_group">
                    <label class="org_3 org_label">Rounding Type</label>
                    <div class="org_9">
                        <input type="text" name="org_rounding_type" id="" class="org_form">
                    </div>
                </div>
            </fieldset>
            <!-- ---------------------------------------------  -->

        </div>
    </div>
    <div class="org_buttom clearfix text-center">
        <input type="submit" value="Submit" name="subBtn" class="btn btn-success">
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