<?php
require "../database.php";
?>
<?php
if (isset($_POST['edit'])) {
	$id = $_POST['id'];
	$role_no = $_POST['role_no'];
	$role_name = $_POST['role_name'];
	$active_stat = $_POST['active_stat'];
	$ss_modifier = $_SESSION['username'];
	$ss_modified_on = date("Y-m-d H:i:s");
	$sql = "UPDATE sm_role SET role_no = '$role_no', role_name = '$role_name', active_stat = '$active_stat', ss_modifier = '$ss_modifier',ss_modified_on='$ss_modified_on' WHERE id = '$id'";
	// echo $sql; exit;

	$conn->query($sql);
	if ($conn->affected_rows == 1) {
		$message = "Save Successfully!";
	} else {
		$mess = "Failled!";
	}
	header('refresh:2;user_roles.php');
}
?>
<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<center>
					<h4 class="modal-title" id="myModalLabel">Edit User Role</h4>
				</center>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form method="POST">
						<input type="hidden" class="form-control" name="id" value="<?php echo $row['id']; ?>">
						<div class="row form-group">
							<div class="col-sm-3">
								<label class="control-label modal-label">ROLE_NO:</label>
							</div>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="role_no" value="<?php echo $row['role_no']; ?>">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3">
								<label class="control-label modal-label">ROLE_NAME:</label>
							</div>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="role_name" value="<?php echo $row['role_name']; ?>">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3">
								<label class="control-label modal-label">Active Status:</label>
							</div>
							<div class="col-sm-9">
								<label class="form-check-label" style="margin-right: 40px; margin-left: 20px">
									<input type="radio" class="form-check-input" name="active_stat" value="1" <?php if ($row['active_stat'] == 1) {
																													echo "checked";
																												} ?>>
									Active
								</label>

								<label class="form-check-label">
									<input type="radio" class="form-check-input" name="active_stat" value="0" <?php if ($row['active_stat'] == 0) {
																													echo "checked";
																												} ?>>
									In-Active
								</label>
							</div>
						</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
				<button type="submit" name="edit" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Update</a>
					</form>
					
			</div>

		</div>
	</div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete_<?php echo $rows['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Delete GL Account</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p class="text-center">Are you sure you want to Delete</p>
				<h2 class="text-center"><?php echo $rows['menu_no'] . ' ' . $rows['menu_name']; ?></h2>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
				<a href="delete.php?id=<?php echo $rows['id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Yes</a>
			</div>

		</div>
	</div>
</div>