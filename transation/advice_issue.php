<?php
require "../auth/auth.php";
require "../database.php";
if (isset($_POST["submit"])) {
    $office_code = $_SESSION['office_code'];
    $org_fin_year_st = $_SESSION['org_fin_year_st'];
    $batch_no = $_POST['batch_no'];
    $tran_date = $_POST['tran_date'];
    $admin = $_SESSION['username'];
    $ss_org_no = $_SESSION['org_no'];
    $cheque_no = $_POST['cheque_no'];
    $cheque_date = $_POST['cheque_date'];

    // if ($acc_type=='2') {
    //     $cheque_no = $_POST['cheque_no'];
    //     $cheque_date = $_POST['cheque_date']; 
    //      }else{
    //    $cheque_no = "00";
    //    $cheque_date = "";
    //     }
    
    for ($count = 0; $count < count($_POST["particular"]); $count++) {
        if (empty($_POST["craccount"][$count])) {
            $vaucher_type = "DR";
        } else {
            $vaucher_type = "CR";
        }
        $data = array(
            ':office_code'  => $office_code,
            ':year_code'  => $org_fin_year_st,
            ':batch_no'  => $batch_no,
            ':tran_date'  => $tran_date,
            ':by_account'   => $_POST["by_account"][$count],
            ':tran_mode'  => 'JR',
            ':vaucher_type'  => $vaucher_type,
            ':cheque_no'  => $cheque_no,
            ':cheque_date'  => $cheque_date,
            ':draccount' => $_POST["draccount"][$count],
            ':craccount' => $_POST["craccount"][$count],
            ':particular'  => $_POST["particular"][$count],
            ':ss_creator'  => $admin,
            ':ss_org_no' => $ss_org_no,
        );
        $query = "INSERT INTO tran_details (office_code, year_code, batch_no,tran_date, gl_acc_code,tran_mode,vaucher_type, cheque_no,cheque_date, dr_amt_loc, cr_amt_loc, description,ss_creator,ss_creator_on,ss_org_no) VALUES (:office_code,:year_code,:batch_no,:tran_date,:by_account,:tran_mode,:vaucher_type,:cheque_no, :cheque_date,:draccount,:craccount, :particular,:ss_creator,now(),:ss_org_no)";
        $statement = $connect->prepare($query);
        if ($statement->execute($data)) {
            $message = "Save Successfully!";
        } else {
            $mess = "Failled!";
        }
    }
    $updateChq = "update bank_chq_leaf_info set leaf_status=1, status_date= '$cheque_date' where chq_leaf_no='$cheque_no'";
    $conn->query($updateChq);
    
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=advice_issue.php\">";
}
require "../source/top.php";
$pid = 406000;
$role_no = $_SESSION['sa_role_no'];
auth_page($conn, $pid, $role_no);
require "../source/header.php";
require "../source/sidebar.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Bank Advice Issue</h1>
            <?php if (isset($message)) echo $message; ?>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <!-- ----------------code here---------------->
        <div class="c_main">
            <form method="post">
                <!-- head -->
                <div>
                    <!-- form start  -->

                    <!-- <form method="post" id="insert_form"> -->
                    <div class="c_main_left"><br>
                        <!-- batch_no -->
                        <?php
                        $querys = "insert into bach_no (username) values ('$_SESSION[username]')";
                        $returns = mysqli_query($conn, $querys);
                        $lastRows = $conn->insert_id;
                        ?>
                        <div class="org_row org_group">
                            <label class="org_2 org_label">Advice Number:</label>
                            <div class="org_10">
                                <input type="text" name="batch_no" readonly class="org_5 org_form" autofocus placeholder="ID" value="<?php echo $lastRows; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="c_main_right">
                        <div class="org_row org_group">
                            <label class="org_4 org_label">Transaction Date</label>
                            <div class="org_6">
                                <!-- <input type="date" id="date" class="org_form" name="tran_date" value="<?php echo $_SESSION['org_eod_bod_proceorg_date']; ?>" required> -->
                                <input type="date" name="tran_date" id="date" class="org_form" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="org_row org_group">
                            <label class="org_4 org_label">User ID</label>
                            <div class="org_6">
                                <input type="text" id="" class="org_form" value="<?php echo $_SESSION['username']; ?>" readonly>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- head close  -->
                <!-- 1st section  -->
                <div class="c_form_div">
                    <div class="form-row" style="width:98%">
                        <div class="form-group col-md-3">
                            <label>To Account</label>
                            <select class="form-control grand" name="by_account[]" onchange="byAccount()" id="by_account" required>
                                <option value="">---Select---</option>
                                <?php
                                $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' and acc_type='2' ORDER by acc_code";
                                
                                $selectQueryResult =  $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                    while ($drrow = $selectQueryResult->fetch_assoc()) {
                                        echo '<option value="' . $drrow['acc_code'] . '">'  . $drrow['acc_head'] . '</option>';
                                    }
                                }
                                ?>
                            </select>

                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPassword4">Particular</label>
                            <input type="text" class="form-control" name="particular[]">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPassword4">Dr. Amount</label>
                            <input type="text" class="form-control" name="draccount[]" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputPassword4">Cr. Amount</label>
                            <input type="text" class="form-control"  name="craccount[]">
                        </div>
                    </div>
                </div> <table class="table bg-light table-bordered table-sm">
                 <thead>
                    <tr id="cheque_no_td" hidden>
                    <td></td>
                    <td>
                        <select class="form-control" name="cheque_no" id="cheque_no">
                        </select>
                    </td>
                    <td colspan="2"> <input type="date" class="form-control" name="cheque_date" id="cheque_date"></td>
                    <td></td>
                </tr>
                 </thead>
                </table>

                <!-- 2nd section  -->
                <div class="c_form_div">
                    <!-- <form method="post" id="insert_form"> -->
                    <table id="item_table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>By Account</th>
                                <th>Particular</th>
                                <th>Dr. Amount</th>
                                <th>Cr. Amount</th>
                                <th><button type="button" name="add" class="btn btn-success btn-xs add text-right"><span class="fa fa-plus"></span></button></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="text-center" style="margin-right:20px; margin-top:30px">
                    <input type="hidden" name="acc_type" id="acc_type" value="">
                    <tr>
                    <th colspan="4" style="text-align:right"></th>
                    <td style="width: 250px"><input type="text" id="grand_total" class="grand_total form-control" style="width:100%" readonly></td>
                    </tr>
                    <input type="submit" value="Submit" name="submit" class="btn btn-success">
                </div>
            </form>
            <!-- form end  -->
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
        if (!empty($mess)) {
            echo '<script type="text/javascript">
          Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Sorry ' . $_SESSION['username'] . '",
            });
          </script>';
        } else {
        }
        ?>
    </div>
</main>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java script plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>
<script>
    $(document).ready(function() {
        var count = 0;
        $(document).on('click', '.add', function() {
            count++;
            var html = '';
            html += '<tr>';
            html += `<td> <select class="form-control select2" name="by_account[]">
                                <option value="">---Select---</option>
                                <?php
                                $selectQuery = "SELECT * FROM `gl_acc_code` where postable_acc= 'Y' and acc_type >'2'  ORDER by acc_code";
                                $selectQueryResult =  $conn->query($selectQuery);
                                if ($selectQueryResult->num_rows) {
                                    while ($drrow = $selectQueryResult->fetch_assoc()) {
                                        echo '<option value="' . $drrow['acc_code'] . '">'  . $drrow['acc_head'] . '</option>';
                                    }
                                }
                                ?>
                            </select></td>`;
            html += '<td><input type="text" name="particular[]" class="form-control" /></td>';
            // html += '<td><input type="text" name="draccount[]" class="form-control" /></td>';
            html += '<td><input type="text" name="draccount[]" id="draccount"  class="form-control draccount"/></td>';
            html += '<td><input type="text" name="craccount[]" class="form-control" readonly/></td>';
            html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><span class="fa fa-minus"></span></button></td>';
            $('tbody').append(html);
        });

        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
        });
    });
    $(function() {
        $('.select2').select2()

    })
    $(document).ready(function() {
        $("#406000").addClass('active');
        $("#400000").addClass('active');
        $("#400000").addClass('is-expanded');
    });
    function byAccount() {
            var account_no = $('#by_account').val();
            $.ajax({
                type: "POST",
                url: "getChequeData.php",
                data: {
                    by_account: account_no
                },
                dataType: "text",
                success: function(response) {

                    $('#acc_type').val(response);
                    $('#showalert').text();
                    $('#cheque_no_td').attr('hidden', true);
                    if (response == 1) {
                        $("#particularcr").val('Cash in Hand');
                    } else {
                        $("#particularcr").val('');
                    }

                    if (response == 2) {
                        $('#cheque_no_td').attr('hidden', false);
                        $.ajax({
                            type: "POST",
                            url: "getChequeData.php",
                            data: {
                                by_account_chq: account_no
                            },
                            dataType: "text",
                            success: function(data) {
                                $('#cheque_no').html(data);
                            }
                        });
                    }
                }
            });
        }
        
        function total(count) {
                 alert(count);
                var grand_total = 0;
                for (j = 1; j <= count; j++) {
                    var draccount = 0;
                    // var item_total = 0;
                    draccount = $('#draccount' + j).val();
                    if (draccount > 0) {
                        grand_total = parseFloat(grand_total) + parseFloat(draccunt);
                        
                    }
                }
                $('#grand_total').val(grand_total);
                $('#dr_amount').val(grand_total);
            
                
            }
            $(document).on('keyup', '.unit_price_loc', function() {
                total(count);
            });
         
        
</script>
</body>

</html>