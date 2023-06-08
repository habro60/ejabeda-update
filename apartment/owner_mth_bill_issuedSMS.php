<?php
require "../auth/auth.php";
require "../database.php";
require '../source/top.php';
$pid = 1305000;
$seprt_cs_info = $_SESSION['seprt_cs_info'];
$role_no = $_SESSION['sa_role_no'];

// auth_page($conn,$pid,$role_no);
$querys = "insert into bach_no (username) values ('$_SESSION[username]')";
$returns = mysqli_query($conn, $querys);
$lastRows = $conn->insert_id;
$regular_pay_flag = '0';
// $bill_for_month=$_POST['bill_for_month'];



require '../source/sidebar.php';
require '../source/header.php';
?>
<main class="app-content">


    <div id="loading" style="display:none;  position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(0, 0, 0, 0.5);">
        <div id="" style="  position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 20px;
        color: white;
        text-align: center;">
            <i class="fa fa-spinner fa-spin" style="font-size: 40px;"></i> <br><strong style="font-size: 25px;">Processing. Please Wait...</strong>
        </div>
    </div>


    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Bill Issued Reminder</h1>
        </div>
    </div>

    <div class="container my-4">
        <button class="btn btn-lg btn-success" id="sendSMSreminder"><i class="fa fa-envelope" style="font-size:large;"></i>Send SMS Reminder To All</button>
    </div>

    <div class="container">
        <?php
        $duebills = "SELECT apart_owner_bill_detail.owner_gl_code, apart_owner_info.mobile_no,apart_owner_info.owner_name, apart_owner_bill_detail.bill_charge_name, apart_owner_bill_detail.flat_no,apart_owner_bill_detail.bill_for_month, apart_owner_bill_detail.bill_last_pay_date,apart_owner_bill_detail.bill_amount FROM flat_info, apart_owner_info, apart_owner_bill_detail where apart_owner_bill_detail.bill_paid_flag=0 and flat_info.flat_no=apart_owner_bill_detail.flat_no and flat_info.flat_no=apart_owner_info.flat_no";
        $query = mysqli_query($conn, $duebills);


        echo '<table class="table table-bordered" id="dueTable">';
        echo '<thead>';
        echo '<tr>';

        echo '<th>Owner Name</th>';
        echo '<th>Flat No</th>';
        echo '<th>Mobile No</th>';
        echo '<th>Bill For Month</th>';
        echo '<th>Bill Last Pay Date</th>';
        echo '<th>Bill Amount</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Loop through the results and output each row as a table row
        while ($row = mysqli_fetch_assoc($query)) {

            echo '<tr>';

            echo '<td>' . $row['owner_name'] . '</td>';
            echo '<td>' . $row['flat_no'] . '</td>';
            echo '<td>' . $row['mobile_no'] . '</td>';
            echo '<td>' . $row['bill_for_month'] . '</td>';
            echo '<td>' . $row['bill_last_pay_date'] . '</td>';
            echo '<td>' . $row['bill_amount'] . '</td>';
            echo '</tr>';
        }
        echo '<tbody>';
        echo '</table>';


        ?>
    </div>

</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- table  -->

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dueTable').DataTable({
            "order": [
                [3, "desc"]
            ]
        });
    });
</script>
<!-- The javascript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#1305000").addClass('active');
        $("#1300000").addClass('active');
        $("#1300000").addClass('is-expanded');
    });
</script>


<script>
    $(document).ready(function() {
        // Attach a click event handler to the button
        $('#sendSMSreminder').click(function() {

            // Send an AJAX request to the server

            $('#loading').show();
            $.ajax({
                url: 'owner_mth_bill_sendSMSreminder.php', // Replace with the actual path to your PHP file
                type: 'POST',
                success: function(response) {

                    console.log('success');
                    $('#loading').hide();
                    // Handle the response from the server if needed
                    alert('Reminders has been sent ');
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    alert('error');
                    console.log('error');
                    $('#loading').hide();
                    // Handle the error if the request fails
                    console.error(error);
                }
            });
        });
    });
</script>
</body>

</html>