<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
$pid = 1304000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
$id = $_SESSION['link_id'];
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
            <h1><i class="fa fa-dashboard"></i> Owner Profile <?php // echo $rows['id']; 
                                                                    ?> </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <?php
    if (!empty($id)) {
        $id = $_SESSION['link_id'];
        $sql = "SELECT apart_owner_info.id,apart_owner_info.office_code,apart_owner_info.owner_id,apart_owner_info.owner_name,apart_owner_info.flat_no, apart_owner_info.father_hus_name,apart_owner_info.mother_name,apart_owner_info.nid,apart_owner_info.mobile_no,apart_owner_info.passport_no,apart_owner_info.permanent_add,code_master.hardcode, code_master.softcode, code_master.description FROM apart_owner_info, code_master where code_master.hardcode='owntp' AND code_master.softcode>0 AND apart_owner_info.id='$id'";
        $result = $conn->query($sql);
        $rows = $result->fetch_assoc();
    ?>
        <div id="profile" class="w3-container profile">
            <div class="container main-secction">
                <div class="row">
                    <!-- total supplied amount -->
                    <?php
                    $query1 = "SELECT `owner_id`,`bill_paid_flag`,sum(bill_amount) as bill_amt,`owner_gl_code`,`link_gl_acc_code` from apart_owner_bill_detail where  owner_id='$id'";
                    $returnSup = mysqli_query($conn, $query1);
                    $bill = mysqli_fetch_assoc($returnSup);
                    ?>
                    <!-- total bill Paid amount -->
                    <?php
                    $query2 =  "SELECT `owner_id`,`bill_paid_flag`,sum(bill_amount) as bill_paid_amt,`owner_gl_code`,`link_gl_acc_code` from apart_owner_bill_detail where bill_paid_flag=1 and owner_id='$id'";
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
                                <!-- Owner  Picture -->
                                <div class="col-md-12 col-md-12-sm-12 col-xs-12 user-image text-center">
                                    <img src="../upload/<?php echo $rows['image']; ?>" class="rounded-circle">
                                </div>
                                <!--  -->
                                <div class="col-md-12 col-sm-12 col-xs-12 user-detail-section1 text-center">
                                    <button class="btn btn-success btn-block follow">Follow me</button>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
                                        <div class="panel-body"><a href="<?php echo 'www.' . strtolower(trim($rows['owner_name'])) . '.info'; ?>"><?php echo 'www.' . trim(strtolower($rows['owner_name'])) . '.info'; ?></a></div>
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item text-muted"> Activity <i class="fa fa-dashboard fa-1x"></i></li>
                                        <li class="list-group-item text-right"><span class="pull-left"><strong>Bill Amt.</strong></span> <?php echo $bill['bill_amt']; ?></li>
                                        <li class="list-group-item text-right"><span class="pull-left"><strong>Paid amt.</strong></span> <?php echo $paid['bill_paid_amt']; ?></li>
                                        <li class="list-group-item text-right"><span class="pull-left"><strong>Bill Due amt.</strong></span><?php echo ($bill['bill_amt'] - $paid['bill_paid_amt']); ?></li>
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
                                            <h1><?php echo $rows['owner_name']; ?></h1>
                                            <h5>Supplier</h5>
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
                                                            <p><?php echo $rows['owner_name']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Flat No.</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['flat_no']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Father/Husband Name</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['father_hus_name']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>mother Name</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['mother_name']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="Paris" class="tabcontent">
                                                <div role="tabpanel" class="tab-pane fade show active" id="profile">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>NID</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['nid']; ?></p>
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
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Parmenant Address.</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?php echo $rows['permanent_add']; ?></p>
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
        echo "<h1 style='text-align:center'>Sorry !! You Are Not Supplier</h1>";
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
        $("#1006000").addClass('active');
        $("#1000000").addClass('active');
        $("#1000000").addClass('is-expanded')
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
    function supplierProfile(profileName) {
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