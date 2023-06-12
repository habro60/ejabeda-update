<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
$pid = 903000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
$member_id = $_SESSION['link_id'];
?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="profile.css">
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
            <h1><i class="fa fa-dashboard"></i> Member Profile <?php // echo $rows['id']; 
                                                                    ?> </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <?php
    if (!empty($member_id)) {
        $member_id = $_SESSION['link_id'];
        $sql = "SELECT fund_member.member_id, fund_member.full_name, fund_member.father_name ,fund_member.mother_name, fund_member.email,fund_member.mobile,fund_member.nid_birth_no,fund_member.passport_no,code_master.hardcode, code_master.softcode, code_master.description FROM `fund_member`, code_master where fund_member.member_id='$member_id'  and code_master.hardcode ='MTYPE' and code_master.Softcode > '0' GROUP BY fund_member.member_id";
        $result = $conn->query($sql);
        $rows = $result->fetch_assoc();
    ?>
        <div id="profile" class="w3-container profile">
            <div class="container main-secction">
                <div class="row">
                    <!-- total supplied amount -->
                    <?php
                    $query1 = "SELECT  donner_fund_detail.member_id, sum((donner_fund_detail.donner_pay_amt)* (donner_fund_detail.num_of_pay)) as pay_amount FROM  `donner_fund_detail` where donner_fund_detail.member_id='$member_id'";
                    $returnSup = mysqli_query($conn, $query1);
                    $pay = mysqli_fetch_assoc($returnSup);
                    ?>
                    <!-- total bill Paid amount -->
                    <?php
                    $query2 = "SELECT  donner_fund_detail.member_id,  sum(donner_fund_detail.donner_paid_amt) as paid_amount FROM  `donner_fund_detail` where donner_fund_detail.member_id='$member_id'";
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
                                <!-- Member Picture -->
                                <div class="col-md-12 col-md-12-sm-12 col-xs-12 user-image text-center">
                                    <img src="../upload/<?php echo $rows['image']; ?>" class="rounded-circle">
                                </div>
                                <!--  -->
                                <div class="col-md-12 col-sm-12 col-xs-12 user-detail-section1 text-center">
                                    <button class="btn btn-success btn-block follow">Follow me</button>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
                                        <div class="panel-body"><a href="<?php echo 'www.' . strtolower(trim($rows['full_name'])) . '.info'; ?>"><?php echo 'www.' . trim(strtolower($rows['full_name'])) . '.info'; ?></a></div>
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item text-muted"> Activity <i class="fa fa-dashboard fa-1x"></i></li>
                                        <li class="list-group-item text-right"><span class="pull-left"><strong>Total Fund to Pay</strong></span> <?php echo $pay['pay_amount']; ?></li>
                                        <li class="list-group-item text-right"><span class="pull-left"><strong>Total Fund Paid</strong></span> <?php echo $paid['paid_amount']; ?></li>
                                        <li class="list-group-item text-right"><span class="pull-left"><strong>Net Due amt.</strong></span><?php echo ($pay['pay_amount'] - $paid['paid_amount']); ?></li>
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
                                            <h1><?php echo $rows['full_name']; ?></h1>
                                            <h5>Member</h5>
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
                                                            <p><?php echo $rows['member_id']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Name</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['full_name']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Father Name</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['father_name']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Mother_name</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['mother_name']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Email Address</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['email']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="Paris" class="tabcontent">
                                                <div role="tabpanel" class="tab-pane fade show active" id="profile">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Member Type </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['description']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>TIN No.</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['nid_birth_no']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Passport No.</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['passport_no']; ?></p>
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
        echo "<h1 style='text-align:center'>Sorry !! You Are Not Member</h1>";
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
        $("#903000").addClass('active');
        $("#900000").addClass('active');
        $("#900000").addClass('is-expanded')
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
    function MemberProfile(profileName) {
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