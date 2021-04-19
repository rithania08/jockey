<style>
	th, td{
		vertical-align: middle ! important;
	}
</style>
<div class="content-wrapper">
    <section class="content">
    
        <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-body">
					<form role="form" class="salenote_update_data" this_id="form-01" reload-action="true">
						<div class="row">
							<div class="col-md-12 table-reponsive">
								<table class="table table-bordered">
									<tr>
										<th class="text-center" colspan="4">
											<span class="text-primary">
												Salenote
											</span>
										</th>
									</tr>
									<tr>
										<th>Store ID</th>
										<td colspan="3">
											<select class="form-control select2" name="store_id" required>
												<?php foreach($this->common_model->get_records("tbl_stores", "status = 0") as $store): ?>
													<option <?=($store->id == $record->store_id)?"selected":""?> value="<?=$store->id?>">
														<?=$store->store_id?> - <?=$store->name?>
													</option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<th>Date</th>
										<td colspan="3">
											<input type="date" class="form-control" name="date" max="<?=date('Y-m-d')?>" value="<?=$record->date?>" readonly>
											<input type="hidden" name="salenote_id" value="<?=$record->id?>">
										</td>
									</tr>
									<tr>
										<th>MTD</th>
										<td colspan="3">
											<input type="text" class="form-control" name="mtd" value="<?=$record->mtd?>" required>
										</td>
									</tr>
									<tr>
										<th>LYMTD</th>
										<td colspan="3">
											<input type="text" class="form-control" name="lymtd" value="<?=$record->lymtd?>" required>
										</td>
									</tr>
									<tr>
										<th>No of bills</th>
										<td colspan="3">
											<input type="number" class="form-control" name="no_of_bills" min="1" value="<?=$record->no_of_bills?>" required>
										</td>
									</tr>
									<tr>
										<th>No of qty</th>
										<td colspan="3">
											<input type="number" class="form-control" name="no_of_qty" min="1" value="<?=$record->no_of_qty?>" required>
										</td>
									</tr>
									<tr>
										<th>Cash sales</th>
										<td>
											<input type="number" class="form-control" name="cash_sales" min="0" value="<?=$record->cash_sales?>" required>
										</td>
										<th>Total system sales</th>
										<td>
											<input type="number" class="form-control" name="total_system_sales" min="0" value="<?=$record->total_system_sales?>" required>
										</td>
									</tr>
									<tr>
										<th>Card sales</th>
										<td>
											<input type="number" class="form-control" name="card_sales" min="0" value="<?=$record->card_sales?>" required>
										</td>
										<th>(+) Manual Bills</th>
										<td>
											<select class="form-control select2" multiple="multiple" name="add_bill_no[]" onchange="get_bill_details(this)" id="bill_amount1">
												<?php foreach($bills as $bill): ?>
													<option <?=($bill->id == $this->common_model->get_record("tbl_salenote_bills", "status = '0' and salenote_id = '$record->id' and cr_dr = '1'", "bill_no"))?"selected":""?> value="<?=$bill->id?>" data-amount="<?=$bill->amount?>"><?=$bill->bill_no?></option>
												<?php endforeach; ?>
											</select>
											
											<?php $bill_amount11 = 0; ?>
											<?php foreach($bill_amount1 as $bill_amount): ?>
												<?php $bill_amount11 += $bill_amount; ?>
											<?php endforeach; ?>
											<input name="bill_amount1" type="hidden" value="<?=$bill_amount11?>">
										</td>
									</tr>
									<tr>
										<th>UPI sales</th>
										<td>
											<input type="number" class="form-control" name="upi_sales" min="0" value="0" required>
										</td>
										<th>(-) Manual Bills</th>
										<td>
											<select class="form-control select2" multiple="multiple" name="less_bill_no[]" onchange="get_bill_details(this)" id="bill_amount2">
												<?php foreach($bills as $bill): ?>
													<option <?=($bill->id == $this->common_model->get_record("tbl_salenote_bills", "status = '0' and salenote_id = '$record->id' and cr_dr = '0'", "bill_no"))?"selected":""?> value="<?=$bill->id?>" data-amount="<?=$bill->amount?>"><?=$bill->bill_no?></option>
												<?php endforeach; ?>
											</select>
											
											<?php $bill_amount22 = 0; ?>
											<?php foreach($bill_amount2 as $bill_amount): ?>
												<?php $bill_amount22 += $bill_amount; ?>
											<?php endforeach; ?>
											<input name="bill_amount2" type="hidden" value="<?=$bill_amount22?>">
										</td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>(-) DC Closing</th>
										<td>
											<input type="number" name="dc_closing" value="<?=$record->dc_closing?>" min="0" class="form-control da_less" required>
										</td>
									</tr>
									<tr>
										<th>Total Realised</th>
										<td>
											<input type="text" class="form-control" readonly value="0" id="total_realised">
										</td>
										<th>Actual Sales</th>
										<td>
											<input type="text" class="form-control" readonly value="0" id="actual_sales">
										</td>
									</tr>
									<tr>
										<th>Cash Sales</th>
										<td colspan="3">
											<input type="text" class="form-control" readonly value="0" id="cash_sales">
											<input type="hidden" name="total_cash_sales" value="<?=$register->total_cash_sales?>">
										</td>
									</tr>
									<tr>
										<th>(-) Transfer to petty cash</th>
										<td colspan="3">
											<input type="number" class="form-control" required min="0" value="<?=$register->transfer_to_petty_cash?>" name="transfer_to_petty_cash">
										</td>
									</tr>
									<tr>
										<th>Bank Cash</th>
										<td colspan="3">
											<input type="text" class="form-control" readonly value="0" id="bank_cash">
										</td>
									</tr>
									<tr>
										<th>2,000</th>
										<td>
											<input type="number" value="<?=$register->count_2000?>" min="0" class="form-control denomination_count" name="count_2000" data-value="2000" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_2000">
										</td>
									</tr>
									<tr>
										<th>500</th>
										<td>
											<input type="number" value="<?=$register->count_500?>" min="0" class="form-control denomination_count" name="count_500" data-value="500" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_500">
										</td>
									</tr>
									<tr>
										<th>200</th>
										<td>
											<input type="number" value="<?=$register->count_200?>" min="0" class="form-control denomination_count" name="count_200" data-value="200" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_200">
										</td>
									</tr>
									<tr>
										<th>100</th>
										<td>
											<input type="number" value="<?=$register->count_100?>" min="0" class="form-control denomination_count" name="count_100" data-value="100" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_100">
										</td>
									</tr>
									<tr>
										<th>50</th>
										<td>
											<input type="number" value="<?=$register->count_50?>" min="0" class="form-control denomination_count" name="count_50" data-value="50" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_50">
										</td>
									</tr>
									<tr>
										<th>20</th>
										<td>
											<input type="number" value="<?=$register->count_20?>" min="0" class="form-control denomination_count" name="count_20" data-value="20" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_20">
										</td>
									</tr>
									<tr>
										<th>10</th>
										<td>
											<input type="number" value="<?=$register->count_10?>" min="0" class="form-control denomination_count" name="count_10" data-value="10" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_10">
										</td>
									</tr>
									<tr>
										<th>Cash in coins</th>
										<td>
											<input type="number" value="<?=$register->count_coins?>" min="0" class="form-control denomination_count" name="count_coins" data-value="1" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_coins">
										</td>
									</tr>
									<tr>
										<th colspan="2">Total</th>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="total_bank_amount">
										</td>
									</tr>
									<tr>
										<th colspan="2">Deposit Amount</th>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="deposit_amount">
											<input type="hidden" value="<?=$register->deposit_amount?>" name="deposit_amount">
										</td>
									</tr>
									<tr>
										<th>Deposited on</th>
										<td colspan="3">
											<input type="text" value="<?=$register->deposited_on?>" class="form-control" readonly>
											<input type="hidden" name="deposited_on" value="<?=$register->deposited_on?>">
										</td>
									</tr>
									<tr>
										<th>Transfer pcs bill cash deposited on</th>
										<td colspan="3">
											<input type="date" value="<?=$register->transfer_pcs_bill_cash_deposited_on?>" class="form-control" readonly name="transfer_pcs_bill_cash_deposited_on">
										</td>
									</tr>
									<tr>
										<th>Notes</th>
										<td colspan="3">
											<input type="text" name="note" value="<?=$register->note?>" class="form-control" required>
										</td>
									</tr>
								</table>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<button type="submit" class="btn btn-primary" >Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/common.js" charset="utf-8"></script>
<script>
	
	rearrange_billers();
	calculate_denomination_total();
	get_bill_details();
	
	$('input[name=cash_sales]').change(function(){
		rearrange_billers();
	});
	
	$('input[name=card_sales]').change(function(){
		rearrange_billers();
	});
	
	$('input[name=upi_sales]').change(function(){
		rearrange_billers();
	});
	
	$('input[name=dc_closing]').change(function(){
		rearrange_billers();
	});
	
	$('input[name=total_system_sales]').change(function(){
		rearrange_billers();
	});
	
	$('input[name=cash_sales]').keyup(function(){
		rearrange_billers();
	});
	
	$('input[name=card_sales]').keyup(function(){
		rearrange_billers();
	});
	
	$('input[name=upi_sales]').keyup(function(){
		rearrange_billers();
	});
	
	$('input[name=dc_closing]').keyup(function(){
		rearrange_billers();
	});
	
	$('input[name=total_system_sales]').keyup(function(){
		rearrange_billers();
	});
	
	$('input[name=transfer_to_petty_cash]').keyup(function(){
		rearrange_billers();
	});
	
	$('input[name=transfer_to_petty_cash]').change(function(){
		rearrange_billers();
	});
	
	function rearrange_billers()
	{	
		var total_realised = parseInt($('input[name=cash_sales]').val()) + parseInt($('input[name=card_sales]').val()) + parseInt($('input[name=upi_sales]').val());
		$('#total_realised').val(total_realised);
		
		var actual_sales = (parseInt($('input[name=total_system_sales]').val()) + parseInt($('input[name=bill_amount1]').val())) - (parseInt($('input[name=dc_closing]').val()) + parseInt($('input[name=bill_amount2]').val()));
		$('#actual_sales').val(actual_sales);
		
		var bank_cash = parseInt($('input[name=total_cash_sales]').val()) - parseInt($('input[name=transfer_to_petty_cash]').val());
		$('#bank_cash').val(bank_cash);
		
		$('#cash_sales').val($('input[name=cash_sales]').val());
		$('input[name=total_cash_sales]').val($('input[name=cash_sales]').val());
	}
	
	function get_bill_details(tis)
	{
		var row_id1 = $('#bill_amount1').val();
		var row_id2 = $('#bill_amount2').val();
		var table = "tbl_bills";
		$.ajax({
			type: 'POST',
			url: baseURL + "admin/get_record/" + table + "/1",
			data: "row_id1=" + row_id1 + "&row_id2=" + row_id2 + "&custom=get-bill-amount",
			dataType: "json",
			success: function(response){
				if(response.result == 1)
				{
					$('input[name=bill_amount1]').val(response.data1);
					$('input[name=bill_amount2]').val(response.data2);
					rearrange_billers();
				}
				else
				{
					toastr.error('Something went wrong! Please try again later!');
					$('button').removeAttr('disabled');
				}
			}
		});
	}
	
	$('.denomination_count').keyup(function(){
		calculate_denomination_total();
	});
	
	$('.denomination_count').change(function(){
		calculate_denomination_total();
	});
	
	function calculate_denomination_total()
	{
		var tt = 0;
		var total_bank_amount = 0;
		$( ".denomination_count" ).each(function( index ) {
			tt = parseInt($(this).val()) * parseInt($(this).attr("data-value"));
			$("#" + $(this).attr('name')).val(tt);
			total_bank_amount += tt;
		});
		$('#total_bank_amount').val(total_bank_amount);
		$('#deposit_amount').val(total_bank_amount);
		$('input[name=deposit_amount]').val(total_bank_amount);
	}
</script>