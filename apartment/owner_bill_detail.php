<?php
require "../auth/auth.php";
require "../database.php";

//insrt query
if (isset($_POST['subBtn'])) {
    $org_fin_year_st = $_SESSION['org_fin_year_st']; // 2017-07-01
    // echo $org_fin_year_st;
    // exit;
    $office_code = $_POST['office_code'];
    $office_name = $_POST['office_name'];
    $office_type = $_POST['office_type'];
    $office_address = $_POST['office_address'];
    $area_code = $_POST['area_code'];
    $office_cont_person = $_POST['office_cont_person'];
    $office_con_mobile_no = $_POST['office_con_mobile_no'];
    $office_start_dt = $_POST['office_start_dt'];
    $office_end_dt = $_POST['office_end_dt'];
    $ss_creator = $_SESSION['username'];
    $ss_created_on = $_SESSION['org_eod_bod_proceorg_date'];
    $ss_org_no = $_SESSION['org_no'];
    $start_check = date('Y', strtotime($_POST['office_start_dt']));
    $end_check = date('Y', strtotime($_POST['office_end_dt']));

    if ($start_check >= $org_fin_year_st && $start_check >= $end_check) {
        $insertQuery = "INSERT INTO `office_info` (`id`,`office_code`, `office_name`, `office_type`,`office_address`,`office_cont_person`,`office_con_mobile_no`,`office_start_dt`,`office_end_dt`,`area_code`,`ss_creator`,`ss_created_on`,`ss_org_no`) VALUES (NULL,'$office_code','$office_name','$office_type','$office_address','$office_cont_person','$office_con_mobile_no','$office_start_dt','$office_end_dt','$area_code','$ss_creator','$ss_created_on','$ss_org_no')";
        // echo $insertQuery;
        // exit;
        $conn->query($insertQuery);
        if ($conn->affected_rows == 1) {
            $last_id = $conn->insert_id;
            $massage_success = "Save Successfully!!";
        } else {
            $massage_failled = "Failled!!";
        }
    } else {
        $massage_failled_date = "Failled Date!!";
    }
    header("refresh:2;office_info.php");
}
require "../source/top.php";
require "../source/sidebar.php";
require "../source/header.php";
?>


<!-- ======================tab panel============== -->
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box}

/* Set height of body and the document to 100% */
body, html {
  height: 100%;
  margin: 0;
  font-family: Arial;
}

/* Style tab links */
.tablink {
  background-color: #555;
  color: white;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
  width: 25%;
}

.tablink:hover {
  background-color: #777;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  color: black;
  display: none;
  padding: 100px 20px;
  height: 100%;
}

#Home {background-color: #5DADE2;}
#News {background-color: #85C1E9;}
#Contact {background-color: #5DADE2;}
#About {background-color: #85C1E9;}
</style>
</head>
<body>

<button class="tablink" onclick="openPage('Home', this, '#5DADE2')">Home</button>
<button class="tablink" onclick="openPage('News', this, '#85C1E9')" id="defaultOpen">News</button>
<button class="tablink" onclick="openPage('Contact', this, '#5DADE2')">Contact</button>
<button class="tablink" onclick="openPage('About', this, '#85C1E9')">About</button>

<div id="Home" class="tabcontent">
  <h3>Home</h3>
  <p>Home is where the heart is..</p>
</div>

<div id="News" class="tabcontent">
  <h3>News</h3>
  <p>Some news this fine day!</p> 
</div>

<div id="Contact" class="tabcontent">
  <h3>Contact</h3>
  <p>Get in touch, or swing by for a cup of coffee.</p>
</div>

<div id="About" class="tabcontent">
  <h3>About</h3>
  <p>Who we are and what we do.</p>
</div>

<script>
function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
   
</body>
</html> 

<!-- ==================close table panel================= -->
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Office Information </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- form start  -->
            <form id="example-form" action="#">
                <div>
                    <h3>Account</h3>
                    <section>
                        <label for="userName">User name *</label>
                        <input id="userName" name="userName" type="text" class="required">
                        <label for="password">Password *</label>
                        <input id="password" name="password" type="text" class="required">
                        <label for="confirm">Confirm Password *</label>
                        <input id="confirm" name="confirm" type="text" class="required">
                        <p>(*) Mandatory</p>
                    </section>
                    <h3>Profile</h3>
                    <section>
                        <label for="name">First name *</label>
                        <input id="name" name="name" type="text" class="required">
                        <label for="surname">Last name *</label>
                        <input id="surname" name="surname" type="text" class="required">
                        <label for="email">Email *</label>
                        <input id="email" name="email" type="text" class="required email">
                        <label for="address">Address</label>
                        <input id="address" name="address" type="text">
                        <p>(*) Mandatory</p>
                    </section>
                    <h3>Hints</h3>
                    <section>
                        <ul>
                            <li>Foo</li>
                            <li>Bar</li>
                            <li>Foobar</li>
                        </ul>
                    </section>
                    <h3>Finish</h3>
                    <section>
                        <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                    </section>
                </div>
            </form>
        </div>
        <?php
        if (!empty($massage_success)) {
            echo '<script type="text/javascript">
            Swal.fire(
                "Save Successfully!!",
                "Welcome ' . $_SESSION['username'] . '' . $last_id . '",
                "success"
              )
            </script>';
        } else {
        }
        if (!empty($massage_failled)) {
            echo '<script type="text/javascript">
                Swal.fire(
                    "Failled!!",
                    "Sorry ' . $_SESSION['username'] . '",
                    "success"
                  )
                </script>';
        } else {
        }
        if (!empty($massage_failled_date)) {
            echo '<script type="text/javascript">
            Swal.fire(
                "Failled Date!!",
                "Sorry ' . $_SESSION['username'] . '",
                "success"
              )
            </script>';
        } else {
        }
        ?>
        <div class="table-responsive border-dark border-top">
            <table class="table table-hover">
                <tr class="active">
                    <th>ID</th>
                    <th>Office Code</th>
                    <th>Office Name</th>
                    <th>Office Type</th>
                    <th>Office Address</th>
                    <th>Office Contact Person</th>
                    <th>Office Mobile No</th>
                    <th>Office Start</th>
                    <th>Office End</th>
                    <th>Action</th>
                </tr>
                <?php
                $no = 1;
                $sql = "SELECT office_info.id, office_info.office_code, office_info.office_name, office_info.office_type, office_info.office_address, office_info.office_cont_person, office_info.office_con_mobile_no, office_info.office_start_dt, office_info.office_end_dt, code_master.hardcode, code_master.softcode, code_master.description FROM office_info, code_master WHERE office_info.office_type = code_master.softcode AND code_master.hardcode = 'OFFTP'";
                $query = $conn->query($sql);
                while ($rows = $query->fetch_assoc()) {
                    echo
                        "<tr>
									<td>" . $rows['id'] . "</td>
                                    <td>" . $rows['office_code'] . "</td>
                                    <td>" . $rows['office_name'] . "</td>
									<td>" . $rows['description'] . "</td>
									<td>" . $rows['office_address'] . "</td>
									<td>" . $rows['office_cont_person'] . "</td>
									<td>" . $rows['office_con_mobile_no'] . "</td>
									<td>" . $rows['office_start_dt'] . "</td>
									<td>" . $rows['office_end_dt'] . "</td>
                                    <td>
                                    <a href='office_info_edit.php?id=" . $rows['id'] . "' target='_blank' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span>Edit</a>
                                </td>
								</tr>";
                }
                ?>
            </table>
            <!-- <a data-id='" . $rows['id'] . "' id='delete_id' class='btn btn-danger btn-sm'<span class='glyphicon glyphicon-trash' href='javascript:void(0)'></span>delete</a> -->
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<script src="../js/select2.full.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.select2').select2()
    })
    $(document).ready(function() {
        $("#accinfo").addClass('active');
        $("#gl_acc").addClass('active');
        $("#accinfo").addClass('is-expanded');
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#delete_id', function(e) {
            var id = $(this).data('id');
            SwalDelete(id);
            e.preventDefault();
        });
    });

    function SwalDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "It will be deleted permanently!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                            url: 'office_info_delete.php',
                            type: 'POST',
                            data: 'id=' + id,
                            dataType: 'json'
                        })
                        .done(function(response) {
                            Swal.fire('Deleted!', 'Your file has been deleted.', 'success')
                        })
                        .fail(function() {
                            Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                        });
                });
            },
        });
    }
</script>
<?php
$conn->close();
?>
</body>

</html>