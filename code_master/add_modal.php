<!-- Add New -->
<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Add New</h4></center>
            </div>
            <div class="modal-body">
			<div class="container-fluid">
			<form method="POST" action="add.php">
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">hardcode:</label>
					</div>
					<div class="col-sm-10">
						<!-- ----------------------- -->
						<select class="form-control" name="hardcode">
						   <?php
						   require "../database.php"; 
						   $selectQuery = "SELECT * FROM `code_master` WHERE `softcode`=0";
						   $selectQueryResult =  $conn->query($selectQuery);		 
						   if($selectQueryResult->num_rows){
						       while($row = $selectQueryResult->fetch_assoc()){
						         	echo '<option value="'.$row['hardcode'].'">'.$row['description'].'</option>';           
						             }
						           }
							?>
						</select>
						<!-- ----------------------- -->
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">softcode:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="softcode" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">description:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="description" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-sm-2">
						<label class="control-label modal-label">sort_des:</label>
					</div>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="sort_des" required>
					</div>
				</div>
            </div> 
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <button type="submit" name="add" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
			</form>
            </div>

        </div>
    </div>
</div>