<?php
	$key = 0;
	foreach($records as $record)
	{
		?>
			<div class="row biller_row">
				<div class="col-md-7">
					<div class="form-group">
						<label for="bill_no"><span class="snumber"><?=$key?>.</span> Bill Number</label>
						<select class="form-control" name="bill_no[]" onchange="edit_get_bill_details(this)">
							<option value="">Select</option>
							<?php foreach($bills as $bill): ?>
								<option <?=($record->bill_no == $bill->id)?"selected":""?> value="<?=$bill->id?>"><?=$bill->bill_no?></option>
							<?php endforeach; ?>
						</select>
						<input name="bill_amount" type="hidden" value="<?=$this->common_model->get_record("tbl_bills", "id = '$record->bill_no'", "amount")?>">
						<input name="payment_method" type="hidden" value="<?=$this->common_model->get_record("tbl_bills", "id = '$record->bill_no'", "payment_method")?>">
						<input name="row_id_child[]" type="hidden" value="<?=$record->id?>">
					</div>
				</div>
				<div class="col-md-3 cr_dr_parent">
					<label for="bill_no">&nbsp;</label><br>
					<select class="form-control cr_dr" name="cr_dr[]" onchange="edit_rearrange_billers();">
						<option <?=($record->cr_dr == 0)?"selected":""?> value="0">Credit</option>
						<option <?=($record->cr_dr == 1)?"selected":""?> value="1">Debit</option>
					</select>
				</div>
				<div class="col-md-2">
					<label for="bill_no">&nbsp;</label><br>
					<?php if($key == 0): ?>
						<span class="btn btn-sm btn-success" onclick="edit_add_biller()">
							<i class="fa fa-plus"></i>
						</span>
					<?php else: ?>
						<span class="btn btn-sm btn-danger" onclick="edit_remove_biller(this)">
							<i class="fa fa-trash"></i>
						</span>
					<?php endif; ?>
				</div>
			</div>
		<?php
		$key++;
	}

?>