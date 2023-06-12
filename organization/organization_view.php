<?php
require "../auth/auth.php";
require "../database.php";
require "../source/top.php";
require "../source/sidebar.php";
require "../source/header.php";
?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Organization View </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <div class="table-responsive border-dark border-top">
        <table class="table table-hover">
            <tr class="active">
                <th>org_no</th>
                <th>org_name</th>
                <th>org_addr1</th>
                <th>org_addr2</th>
                <th>org_email</th>
                <th>org_website</th>
                <th>org_fax</th>
                <th>Action</th>
            </tr>
            <?php
            $no = 1;
            $sql = "SELECT * FROM org_info";
            $query = $conn->query($sql);
            while ($rows = $query->fetch_assoc()) {
                echo
                    "<tr>

									<td>" . $rows['org_no'] . "</td>
									<td>" . $rows['org_name'] . "</td>
									<td>" . $rows['org_addr1'] . "</td>
									<td>" . $rows['org_addr2'] . "</td>
									<td>" . $rows['org_email'] . "</td>
									<td>" . $rows['org_website'] . "</td>
									<td>" . $rows['org_fax'] . "</td>
                                    <td>
                                    <a href='organization_edit.php?id=" . $rows['org_no'] . "' target='_blank' class='btn btn-success btn-sm><span class='glyphicon glyphicon-edit'></span>Edit</a>
                                    <a data-id='" . $rows['org_no'] . "' id='delete_id' class='btn btn-danger btn-sm'<span class='glyphicon glyphicon-trash' href='javascript:void(0)'></span>delete</a>
                                </td>
								</tr>";
            }
            ?>
        </table>
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