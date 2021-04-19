
<div id="edit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
			<form role="form" class="salenote_update_data" this_id="form-02" reload-action="true">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit</h4>
				</div>
				<div class="modal-body">
				
					<div class="row">
						<div class="col-md-6">                                
							<div class="form-group">
								<label for="date">Date</label>
								<input type="text" name="date" class="form-control" readonly>
								<input type="hidden" name="table_name" value="tbl_salenote">
								<input type="hidden" name="row_id" value="">
							</div>
							
						</div>
						<div class="col-md-6">                                
							<div class="form-group">
								<label for="mtd_lymtd">MTD / LYMTD</label>
								<input type="text" class="form-control" name="mtd_lymtd" required>
							</div>
							
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="no_of_bills">No of bills</label>
								<input type="number" class="form-control" name="no_of_bills" min="1" value="1" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="no_of_qty">No of qty</label>
								<input type="number" class="form-control" name="no_of_qty" min="1" value="1" required>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="cash_sales">Cash sales</label>
								<input type="number" class="form-control" name="cash_sales" min="0" value="1" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="card_sales">Card sales</label>
								<input type="number" class="form-control" name="card_sales" min="0" value="0" required>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="upi_sales">UPI sales</label>
								<input type="number" class="form-control" name="upi_sales" min="0" value="0" required>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="dc_closing">DC Closing (-)</label>
								<input type="number" name="dc_closing" value="0" min="0" class="form-control da_less" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="total_system_sales">Total system sales</label>
								<input type="number" class="form-control" name="total_system_sales" min="0" value="1" required>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12 billers">
							
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<hr>
							<table class="table">
								<thead>
									<tr>
										<th class="text-center">Cash Payments</th>
										<th class="text-center">Card Payments</th>
										<th class="text-center">UPI Payments</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-center">
											<b>Cr:</b> <span class="cash_cr">0</span><br>
											<b>Dr:</b> <span class="cash_dr">0</span>
										</td>
										<td class="text-center">
											<b>Cr:</b> <span class="card_cr">0</span><br>
											<b>Dr:</b> <span class="card_dr">0</span>
										</td>
										<td class="text-center">
											<b>Cr:</b> <span class="upi_cr">0</span><br>
											<b>Dr:</b> <span class="upi_dr">0</span>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td class="text-center" colspan="2">Total</td>
										<td class="text-center total_cr_dr">0</td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" >Submit</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
        </div>
    </div>
</div>