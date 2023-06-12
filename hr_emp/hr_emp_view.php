<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
$pid = 602000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require '../source/sidebar.php';
require '../source/header.php';
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> View Employee Data</h1>
        </div>
    </div>
            <?php
            $id=$_GET['id'];
            $no = 1;
            $sql = "SELECT sm_hr_emp.emp_no, sm_hr_emp.office_code, sm_hr_emp.username ,sm_hr_emp.f_name, sm_hr_emp.l_name, 
            sm_hr_emp.desig_code, sm_hr_emp.phone_mobile, sm_hr_emp.employee_image, sm_hr_emp.email_personal, office_info.office_name
             FROM `sm_hr_emp`, office_info WHERE sm_hr_emp.office_code = office_info.office_code AND sm_hr_emp.emp_no=$id";
            $query = $conn->query($sql);
            $row = $query->fetch_assoc();
        
            ?>
image :<img src="../upload/<?php echo $row['employee_image']; ?>" style="width:85px; height:85px">
<?php echo $row['f_name'];?> <?php echo $row['l_name'];?>


</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- table  -->
<script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable();
</script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#dashboard").addClass('active');
    });
    $(document).ready(function() {
        $("#602000").addClass('active');
        $("#600000").addClass('active');
        $("#600000").addClass('is-expanded');
    });
</script>


</body>

</html>