
<div id="create" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
			<form role="form" class="salenote_insert_data" this_id="form-01" reload-action="true">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Create</h4>
				</div>
				<div class="modal-body">
				
					<div class="row">
						<?php if($_SESSION['role'] == ROLE_STORE_ADMIN): ?>
							<input type="hidden" name="store_id" value="<?=$_SESSION['store_id']?>">
						<?php else: ?>
							<div class="col-md-6">
								<div class="form-group">
									<label for="payment_method">Store ID</label>
									<select class="form-control select2" name="store_id" required>
										<?php foreach($this->common_model->get_records("tbl_stores", "status = 0") as $store): ?>
											<option value="<?=$store->id?>"><?=$store->store_id?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<div class="row">
						<div class="col-md-6">                                
							<div class="form-group">
								<label for="date">Date</label>
								<input type="date" class="form-control" name="date" max="<?=date('Y-m-d')?>" value="<?=date('Y-m-d')?>" required>
								<input type="hidden" name="table_name" value="tbl_salenote">
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
							<div class="row biller_row">
								<div class="col-md-7">
									<div class="form-group">
										<label for="bill_no"><span class="snumber">1.</span> Bill Number</label>
										<select class="form-control" name="bill_no[]" onchange="get_bill_details(this)">
											<option value="">Select</option>
											<?php foreach($bills as $bill): ?>
												<option value="<?=$bill->id?>"><?=$bill->bill_no?></option>
											<?php endforeach; ?>
										</select>
										<input name="bill_amount" type="hidden" value="0">
										<input name="payment_method" type="hidden" value="0">
									</div>
								</div>
								<div class="col-md-3 cr_dr_parent">
									<label for="bill_no">&nbsp;</label><br>
									<select class="form-control cr_dr" name="cr_dr[]" onchange="rearrange_billers();">
										<option value="0">Credit</option>
										<option value="1">Debit</option>
									</select>
								</div>
								<div class="col-md-2">
									<label for="bill_no">&nbsp;</label><br>
									<span class="btn btn-sm btn-success" onclick="add_biller()">
										<i class="fa fa-plus"></i>
									</span>
								</div>
							</div>
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
