
<div id="files_upload" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Verify the sale note</h4>
			</div>
			<div class="modal-body">
				<form class="shopper_sales">
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label>Upload shopper sales</label>
								<input type="file" class="form-control" name="shopper_sales" required>
								<input type="hidden" name="salenote_id" required>
							</div>
						</div>
					</div>
				</form>
				<form class="cash_bank_statement">
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label>Upload Bank Statement</label>
								<input type="file" class="form-control" name="cash_bank_statement" required>
								<input type="hidden" name="salenote_id" required>
							</div>
						</div>
					</div>
				</form>
				<form class="cc_bank_statement">
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label>Upload CC Bank Statement</label>
								<input type="file" class="form-control" name="cc_bank_statement" required>
								<input type="hidden" name="salenote_id" required>
							</div>
						</div>
					</div>
				</form>
				<form class="salenote_verify_now">
					<div class="row">
						<div class="col-md-4">                                
							<div class="form-group">
								<a class="btn btn-sm btn-info shopper_sale_file_download" href="">
									Download Shopper Sale
								</a>
							</div>
						</div>
						<div class="col-md-4">                                
							<div class="form-group">
								<a class="btn btn-sm btn-info bank_statement_file_download" href="">
									Download Bank Statement
								</a>
							</div>
						</div>
						<div class="col-md-4">                                
							<div class="form-group">
								<a class="btn btn-sm btn-info cc_bank_statement_file_download" href="">
									Download CC Bank Statement
								</a>
							</div>
						</div>
						<div class="col-md-12 text-right">                                
							<div class="form-group">
								<input type="hidden" name="salenote_id" required>
								<button class="btn btn-sm btn-primary" type="submit">
									Verify Now
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
        </div>
    </div>
</div>