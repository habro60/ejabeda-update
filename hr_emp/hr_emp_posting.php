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
            <h1><i class="fa fa-dashboard"></i> Employee Posting and Transfer</h1>
        </div>
    </div>
    <!-- <table class="table table-hover table-bordered table-sm"> -->
    <table class="table bg-light table-bordered table-sm table" id="sampleTable">
        <thead>
            <tr>
                
                <th>Employee No.</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Joining Date</th>
                <th>Place </th>
                <th>Mobile Number</th>
                 <th>Email</th>
                <th>Action</th>
                    
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $sql = "SELECT sm_hr_emp.emp_no, sm_hr_emp.office_code, sm_hr_emp.f_name, sm_hr_emp.l_name, sm_hr_emp.desig_code, sm_hr_emp.join_date, sm_hr_emp.father_name, sm_hr_emp.phone_mobile,sm_hr_emp.email_personal,hr_desig.desig_desc, office_info.office_name FROM `sm_hr_emp`,hr_desig,office_info where sm_hr_emp.desig_code=hr_desig.desig_code and office_info.office_code=sm_hr_emp.office_code";
            $query = $conn->query($sql);
            while ($rows = $query->fetch_assoc()) {
                echo
                        "<tr>       
                            
                            <td>" . $rows['emp_no'] . "</td>
                            <td>" . $rows['f_name'] . "  ".$rows['l_name'] ."</td>
                            <td>" . $rows['desig_desc'] . "</td>
                            <td>" . $rows['join_date'] . "</td>
                            <td>" . $rows['office_name'] . "</td>
                            <td>" . $rows['phone_mobile'] . "</td>
                            <td>" . $rows['email_personal'] . "</td>
                            
                            <td><a target='_blank' href='hr_emp_posting_add.php?id=" . $rows['emp_no'] . "' class='btn btn-success btn-sm'><span class='fa fa-edit'></span>Posting & Transfer</a>
                            </td>
                        </tr>";
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