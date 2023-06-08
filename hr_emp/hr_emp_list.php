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
            <h1><i class="fa fa-dashboard"></i> Employee List</h1>
        </div>
    </div>
    <!-- <table class="table table-hover table-bordered table-sm"> -->
    <table class="table bg-light table-bordered table-sm table" id="sampleTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Office Code</th>
                <th>Image</th>
                <th>Name</th>
                 <th>Designation</th>
                <th>Mobile Number</th>
                 <th>joining Date</th>
                <th>Action</th>
                    
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $sql = "SELECT sm_hr_emp.emp_no, sm_hr_emp.office_code, sm_hr_emp.username ,sm_hr_emp.f_name, sm_hr_emp.l_name, 
            sm_hr_emp.desig_code, sm_hr_emp.phone_mobile, sm_hr_emp.employee_image, sm_hr_emp.join_date, 
            office_info.office_name, hr_desig.desig_desc FROM `sm_hr_emp`, office_info, hr_desig WHERE sm_hr_emp.office_code = office_info.office_code and sm_hr_emp.desig_code=hr_desig.desig_code";
            $query = $conn->query($sql);
            while ($row = $query->fetch_assoc()){
                echo '<tr>';
                echo '<td style="width:40px">' . $no++ . '</td>'; // ' . $row['employee_image'] . '
                echo '<td>' . $row['office_name'] . '</td>';
                echo '<td style="width:85px; height:85px"><img src="../upload/' . $row['employee_image'] . '" style="width:85px; height:85px"></td>';
                echo '<td>' . $row['f_name'] . ' ' . $row['l_name'] . '</td>';
                 echo '<td>' . $row['desig_desc'] . '</td>';
                echo '<td>' . $row['phone_mobile'] . '</td>';
                echo '<td>' . $row['join_date'] . '</td>';
            ?>
                <td style="text-align:center;width:100px"> <a href="hr_emp_edit.php?id=<?php echo $row['emp_no']; ?>"><button class="btn btn-info" title="Edit User <?php echo $row['f_name']; ?>"><i class="fa fa-edit"></i></button></a> <a href="hr_emp_view.php?id=<?php echo $row['emp_no']; ?>"><button class="btn btn-primary" title="view User <?php echo $row['f_name']; ?>"><i class="fa fa-eye"></i></button></a></td>
            <?php
            }
            ?>
        </tbody>
        <script>
            $(function() {
                $('.toggle-class').change(function() {
                    var status = $(this).prop('checked') == true ? 1 : 0; // ternary operator
                    var id = $(this).data('id');

                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: 'getChangeUserStatus.php',
                        data: {
                            'status': status,
                            'id': id
                        },
                        success: function(data) {
                            console.log(data.success)
                        }
                    });
                })
            })
        </script>
    </table>
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