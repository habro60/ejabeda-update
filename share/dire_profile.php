<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
$pid = 1006000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
$sql = "SELECT dire_info.id, dire_info.dire_name, dire_info.dire_add ,dire_info.dire_business_category, dire_info.dire_contact_per,code_master.hardcode, code_master.softcode, code_master.description FROM `dire_info`, code_master where code_master.hardcode='SUPTP' AND code_master.softcode>0 AND dire_info.id=1 GROUP BY dire_info.id";
$result = $conn->query($sql);
$rows = $result->fetch_assoc();
?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="profile.css">
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> direlier Profile <?php echo $rows['id']; ?> </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>

    <div id="profile" class="w3-container profile">
        <div class="container main-secction">
            <div class="row">
                <!-- Profile Picture -->
                <div class="col-md-12 col-sm-12 col-xs-12 image-section">
                    <img src="../upload/abdullah1.jpg">
                </div>
                <!--  -->
                <div class="row user-left-part">
                    <div class="col-md-3 col-sm-3 col-xs-12 user-profil-part pull-left">
                        <div class="row ">
                            <!-- direlier Picture -->
                            <div class="col-md-12 col-md-12-sm-12 col-xs-12 user-image text-center">
                                <img src="../upload/abdullah.png" class="rounded-circle">
                            </div>
                            <!--  -->
                            <div class="col-md-12 col-sm-12 col-xs-12 user-detail-section1 text-center">
                                <button class="btn btn-success btn-block follow">Follow me</button>
                                <div class="panel panel-default">
                                    <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
                                    <div class="panel-body"><a href="<?php echo 'www.'.strtolower(trim($rows['dire_name'])).'.info';?>"><?php echo 'www.'.trim(strtolower($rows['dire_name'])).'.info';?></a></div>
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item text-muted"> Activity <i class="fa fa-dashboard fa-1x"></i></li>
                                    <li class="list-group-item text-right"><span class="pull-left"><strong>Total Due</strong></span> 125</li>
                                    <li class="list-group-item text-right"><span class="pull-left"><strong>Total Paid</strong></span> 13</li>
                                    <li class="list-group-item text-right"><span class="pull-left"><strong>Total Receive</strong></span> 37</li>
                                    <li class="list-group-item text-right"><span class="pull-left"><strong>Total Transcation</strong></span> 78</li>
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
                                        <h1><?php echo $rows['dire_name']; ?></h1>
                                        <h5>direlier</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#profile" role="tab" data-toggle="tab"><i class="fas fa-user-circle"></i> General Info.</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#buzz" role="tab" data-toggle="tab"><i class="fas fa-info-circle"></i> Information</a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
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
                                                        <p><?php echo $rows['dire_name']; ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label>Address</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><?php echo $rows['dire_add']; ?></p>
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
                                                        <p><?php echo $rows['dire_contact_per']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="buzz">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Experience</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>Expert</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Hourly Rate</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>10$/hr</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Total Projects</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>230</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>English Level</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>Expert</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Availability</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>6 months</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Your Bio</label>
                                                        <br />
                                                        <p>Your detail description</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-4 img-main-rightPart">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row image-right-part">
                                                    <div class="col-md-6 pull-left image-right-detail">
                                                        <h6>PUBLICIDAD</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="http://camaradecomerciozn.com/">
                                                <div class="col-md-12 image-right">
                                                </div>
                                            </a>
                                            <div class="col-md-12 image-right-detail-section2">
                                                <!-- cde -->

                                                <!-- abc -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    function direlierProfile(profileName) {
        var i;
        var x = document.getElementsByClassName("profile");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        document.getElementById(profileName).style.display = "block";
    }
</script>
</body>

</html>