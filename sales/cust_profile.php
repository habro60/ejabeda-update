<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
// $pid = 1006000;
// $role_no = $_SESSION['sa_role_no'];
// auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
$cust_id = $_SESSION['link_id'];
?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="profile.css">
<!--  -->
<style>
    body {
        font-family: Arial;
    }

    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
</style>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Customer Profile <?php // echo $rows['id']; 
                                                                    ?> </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <?php
    if (!empty($cust_id)) {
        $cust_id = $_SESSION['link_id'];
        $sql = "SELECT cust_info.id, cust_info.cust_name, cust_info.cust_add ,cust_info.cust_business_category, cust_info.cust_contact_per,cust_info.cust_VAT_no,cust_info.cust_VAT_no,cust_info.cust_TIN_no,cust_info.cust_TDS_no,code_master.hardcode, code_master.softcode, code_master.description FROM `cust_info`, code_master where code_master.hardcode='CUSTP' AND code_master.softcode>0 AND cust_info.id='$cust_id' GROUP BY cust_info.id";
        $result = $conn->query($sql);
        $rows = $result->fetch_assoc();
    ?>
        <div id="profile" class="w3-container profile">
            <div class="container main-secction">
                <div class="row">
                    <!-- total custlied amount -->
                    <?php
                    $query1 = "SELECT tran_details.gl_acc_code, sum(tran_details.cr_amt_loc) as total_cust, tran_details.tran_date,  cust_info.id, cust_info.gl_acc_code FROM tran_details , cust_info WHERE tran_details.gl_acc_code= cust_info.gl_acc_code  AND cust_info.id='$cust_id'";
                    $returnSup = mysqli_query($conn, $query1);
                    $cust = mysqli_fetch_assoc($returnSup);
                    ?>
                    <!-- total bill Paid amount -->
                    <?php
                    $query2 = "SELECT tran_details.gl_acc_code, sum(tran_details.dr_amt_loc) as total_paid, tran_details.tran_date, cust_info.id, cust_info.gl_acc_code FROM tran_details , cust_info WHERE tran_details.gl_acc_code= cust_info.gl_acc_code AND cust_info.id='$cust_id'";
                    $returnPaid = mysqli_query($conn, $query2);
                    $paid = mysqli_fetch_assoc($returnPaid);
                    ?>
                    <!-- Profile Picture -->
                    <div class="col-md-12 col-sm-12 col-xs-12 image-section">
                        <img src="../upload/abdullah1.jpg">
                    </div>
                    <!--  -->
                    <div class="row user-left-part">
                        <div class="col-md-3 col-sm-3 col-xs-12 user-profil-part pull-left">
                            <div class="row ">
                                <!-- Customer Picture -->
                                <div class="col-md-12 col-md-12-sm-12 col-xs-12 user-image text-center">
                                    <img src="../upload/<?php echo $rows['image']; ?>" class="rounded-circle">
                                </div>
                                <!--  -->
                                <div class="col-md-12 col-sm-12 col-xs-12 user-detail-section1 text-center">
                                    <button class="btn btn-success btn-block follow">Follow me</button>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
                                        <div class="panel-body"><a href="<?php echo 'www.' . strtolower(trim($rows['cust_name'])) . '.info'; ?>"><?php echo 'www.' . trim(strtolower($rows['cust_name'])) . '.info'; ?></a></div>
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item text-muted"> Activity <i class="fa fa-dashboard fa-1x"></i></li>
                                        <li class="list-group-item text-right"><span class="pull-left"><strong>custlied Amt.</strong></span> <?php echo $cust['total_cust']; ?></li>
                                        <li class="list-group-item text-right"><span class="pull-left"><strong>Bill Paid amt.</strong></span> <?php echo $paid['total_paid']; ?></li>
                                        <li class="list-group-item text-right"><span class="pull-left"><strong>Bill Due amt.</strong></span><?php echo ($cust['total_cust'] - $paid['total_paid']); ?></li>
                                    </ul>
                                    <div class="card">
                                        <div class="card-title text-center">
                                            Social Media
                                        </div>
                                        <div class="card-body text-center">
                                            <i class="fa fa-facebook fa-2x"></i><i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12 pull-right profile-right-section">
                            <div class="row profile-right-section-row">
                                <div class="col-md-12 profile-header">
                                    <div class="row">
                                        <div class="col-md-8 col-sm-6 col-xs-6 profile-header-section1 pull-left">
                                            <h1><?php echo $rows['cust_name']; ?></h1>
                                            <h5>Customer</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="tab">
                                                <button class="tablinks" onclick="openCity(event, 'London')" selected>General Information</button>
                                                <button class="tablinks" onclick="openCity(event, 'Paris')">Others Information</button>
                                                <button class="tablinks" onclick="openCity(event, 'Tokyo')">More Information</button>
                                            </div>

                                            <div id="London" class="tabcontent">
                                                <div role="tabpanel" class="tab-pane fade show active" id="profile">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>ID</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['id']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Name</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['cust_name']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Address</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['cust_add']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Business</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['description']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Contact</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['cust_contact_per']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="Paris" class="tabcontent">
                                                <div role="tabpanel" class="tab-pane fade show active" id="profile">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>VAT No.</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['cust_VAT_no']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>TAX No.</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['cust_TIN_no']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>TDS No.</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['cust_TDS_no']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="Tokyo" class="tabcontent">
                                                <h3>There is no information </h3>
                                            </div>
                                            <!--  -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
        echo "<h1 style='text-align:center'>Sorry !! You Are Not Customer</h1>";
    }
    ?>

    <!-- Setting -->

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
    $(document).ready(function() {
        $("#1103000").addClass('active');
        $("#1100000").addClass('active');
        $("#1100000").addClass('is-expanded')
    });
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>
<script type="text/javascript">
    // image
    $(document).ready(function() {
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.avatar').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".file-upload").on('change', function() {
            readURL(this);
        });
    });
</script>
<script>
    // tab move
    function CustomerProfile(profileName) {
        var i;
        var x = document.getElementsByClassName("profile");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        document.getElementById(profileName).style.display = "block";
    }
    // Infomation tab
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
</body>

</html>