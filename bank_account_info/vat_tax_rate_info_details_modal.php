<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $rows['item']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel" style="text-align: center">Details Vat and Tax Rate</h4>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form method="POST" action="vat_tax_rate_info.php">
						<div class="row form-group">
							<div class="col-sm-2">
								<label class="control-label modal-label">tax_type</label>
							</div>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="tax_type" value="<?php echo $rows['type1']; ?>" readonly> </div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2">
								<label class="control-label modal-label">Name</label>
							</div>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="" value="<?php echo $rows['description']; ?>" readonly> </div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2">
								<label class="control-label modal-label">item_code</label>
							</div>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="item_code" value="<?php echo $rows['item']; ?>" readonly>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2">
								<label class="control-label modal-label">Sl No</label>
							</div>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="sl_no" value="<?php echo $rows['sl_no']; ?>">
							</div>
						</div>

						<div class="row form-group">
							<div class="col-sm-2">
								<label class="control-label modal-label">From Amount</label>
							</div>
							<div class="col-sm-10">
								<input type="text" name="from_amount" class="form-control" value="" placeholder="From Amount" required>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2">
								<label class="control-label modal-label">To Amount</label>
							</div>
							<div class="col-sm-10">
								<input type="text" name="to_amount" class="form-control" value="" placeholder="To Amount" required>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-2">
								<label class="control-label modal-label">Rate (%)</label>
							</div>
							<div class="col-sm-10">	
								<input type="text" name="tax_on_rate" class="form-control" value="<?php echo $rows['tax_on_rate']; ?>" placeholder="Enter Tax Vat Rate Percent" required>
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