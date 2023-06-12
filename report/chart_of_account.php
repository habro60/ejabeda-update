<?php
require "../auth/auth.php";
require '../database.php';
require '../source/top.php';
$pid= 707000; $role_no = $_SESSION['sa_role_no'];
auth_page($conn,$pid,$role_no);
require '../source/header.php';
require '../source/sidebar.php';
?>
<main class="app-content">
    <div class="app-title">
        <div style="width: 100%;">
            <h1><i class="fa fa-dashboard"></i>Chart Of Account</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            $sql2 = "SELECT `org_logo`, `org_name` FROM `org_info`";
            $returnD = mysqli_query($conn, $sql2);
            $result = mysqli_fetch_assoc($returnD);
            ?>
            <div>
                <h2 style="text-align:center"><img src="../upload/<?php echo $result['org_logo']; ?>" alt="logo" style="width:40px;height:40px;"> <?php echo $result['org_name']; ?></h2>
            </div>

            <h3 style="text-align:center">Chart Of Account</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="btn btn-info">Search</span>
                            <input type="text" name="search_text" id="search_text" placeholder="Search chart of account ..." class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="pull-right">
                        <a id='print' title="Print" class="btn btn-danger" target="_blank" href="chart_of_account_print.php"><i class="fa fa-print"></i>Print</a>
                        <a id='print' title="Print" class="btn btn-danger"  href="chart_of_account_pdf.php"></i>PDF</a>
                        <a id='print' title="Print" class="btn btn-danger" href="chart_of_account_word.php"></i>docx</a>
                        <a id='print' title="Print" class="btn btn-danger" href="chart_of_account_excel.php?id=1"></i>Excel</a>
                        <a id='print' title="Print" class="btn btn-danger" href="chart_of_account_csv.php"></i>csv</a>
                    </div>
                </div>
            </div>
            <div id="result"></div>
            <div style="clear:both"></div>
        </div>
    </div>
</main>
<?php
require "report_footer.php";
?>
<!-- Essential javascripts for application to work-->
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/main.js"></script>
<!-- The java../jcript plugin to display page loading on top-->
<script src="../js/plugins/pace.min.js"></script>
<!-- registration_division_district_upazila_jqu_script -->
<script src="../js/select2.full.min.js"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#707000").addClass('active');
        $("#700000").addClass('active');
        $("#700000").addClass('is-expanded');
    });
</script>

<script>
    $(document).ready(function() {
        load_data();

        function load_data(query) {
            $.ajax({
                url: "fetch.php",
                method: "post",
                data: {
                    query: query
                },
                success: function(data) {
                    $('#result').html(data);
                }
            });
        }

        $('#search_text').keyup(function() {
            var search = $(this).val();
            if (search != '') {
                load_data(search);
            } else {
                load_data();
            }
        });
    });
</script>

</body>

</html>