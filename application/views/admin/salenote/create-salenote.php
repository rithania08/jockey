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
					<form role="form" class="salenote_insert_data" this_id="form-01" reload-action="true">
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
										<?php
										
												 $store =$this->common_model->get_records("tbl_stores", "status = 0 and  id = '" . $_SESSION['store_id'] . "'")[0];
												  ?>
											<input class="form-control" value='<?=$store->store_id?>-<?=$store->name?>' name="store_id" id="store-id" readonly>
											
											
														
												
											
												
										</td>
									</tr>
									<tr>
										<th>Date</th>
										<td colspan="3">
											<input type="date" class="form-control" name="date" <?php  if($access->date != ''){echo "min='".date("Y-m-d", strtotime($access->date))."';";}else if($_SESSION['role'] != ROLE_SUPER_ADMIN){echo "min='".date('Y-m-d')."';";}?> max="<?=date('Y-m-d')?>" value="<?=date('Y-m-d')?>" required>
										</td>
									</tr>
									<?php if($access->id != '') {?>
									<input type="hidden" name="salenote_entry_access" value="1">
								<?php }else{?>

									<input type="hidden" name="salenote_entry_access" value="0">
								<?php }?>
									<tr>
										<th>MTD</th>
										<td colspan="3">
											<input type="text" class="form-control" name="mtd" required>
										</td>
									</tr>
									<tr>
										<th>LYMTD</th>
										<td colspan="3">
											<input type="text" class="form-control" name="lymtd" required>
										</td>
									</tr>
									<tr>
										<th>No of bills</th>
										<td colspan="3">
											<input type="number" class="form-control" name="no_of_bills" min="1" value="0" required>
										</td>
									</tr>
									<tr>
										<th>No of qty</th>
										<td colspan="3">
											<input type="number" class="form-control" name="no_of_qty" min="1" value="0" required>
										</td>
									</tr>
									<tr>
										<th>Cash sales</th>
										<td>
											<input type="number" class="form-control" name="cash_sales" min="0" value="0" required>
										</td>
										<th>Total system sales</th>
										<td>
											<input type="number" class="form-control" name="total_system_sales" min="0" value="1" required>
										</td>
									</tr>
									<tr>
										<th>Card sales</th>
										<td>
											<input type="number" class="form-control" name="card_sales" min="0" value="0" required>
										</td>
										<th>(+) Manual Bills</th>
										<td>
											<select class="form-control select2" multiple="multiple" name="add_bill_no[]" onchange="get_bill_details(this)" id="bill_amount1">
											
											</select>
											<input name="bill_amount1" type="hidden" value="0">
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
												<?php foreach($closed_bills as $bill): ?>
													<option value="<?=$bill->id?>" data-amount="<?=$bill->amount?>"><?=$bill->amount?></option>
												<?php endforeach; ?>
											</select>
											<input name="bill_amount2" type="hidden" value="0">
										</td>
									</tr>
									<tr>
										<th></th>
										<td></td>
										<th>(-) DC Closing</th>
										<td>
											<input type="number" name="dc_closing" value="0" min="0" class="form-control da_less" required>
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
											<input type="hidden" name="total_cash_sales" value="0">
										</td>
									</tr>
									<tr>
										<th>(-) Transfer to petty cash</th>
										<td colspan="3">
											<input type="number" class="form-control" required min="0" value="0" name="transfer_to_petty_cash">
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
											<input type="number" value="0" min="0" class="form-control denomination_count" name="count_2000" data-value="2000" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_2000">
										</td>
									</tr>
									<tr>
										<th>500</th>
										<td>
											<input type="number" value="0" min="0" class="form-control denomination_count" name="count_500" data-value="500" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_500">
										</td>
									</tr>
									<tr>
										<th>200</th>
										<td>
											<input type="number" value="0" min="0" class="form-control denomination_count" name="count_200" data-value="200" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_200">
										</td>
									</tr>
									<tr>
										<th>100</th>
										<td>
											<input type="number" value="0" min="0" class="form-control denomination_count" name="count_100" data-value="100" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_100">
										</td>
									</tr>
									<tr>
										<th>50</th>
										<td>
											<input type="number" value="0" min="0" class="form-control denomination_count" name="count_50" data-value="50" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_50">
										</td>
									</tr>
									<tr>
										<th>20</th>
										<td>
											<input type="number" value="0" min="0" class="form-control denomination_count" name="count_20" data-value="20" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_20">
										</td>
									</tr>
									<tr>
										<th>10</th>
										<td>
											<input type="number" value="0" min="0" class="form-control denomination_count" name="count_10" data-value="10" required>
										</td>
										<td colspan="2">
											<input type="text" class="form-control" readonly value="0" id="count_10">
										</td>
									</tr>
									<tr>
										<th>Cash in coins</th>
										<td>
											<input type="number" value="0" min="0" class="form-control denomination_count" name="count_coins" data-value="1" required>
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
									<!--<tr>-->
									<!--	<th colspan="2">Deposit Amount</th>-->
									<!--	<td colspan="2">-->
									<!--		<input type="text" class="form-control" readonly value="0" id="deposit_amount">-->
									<!--		<input type="hidden" value="0" name="deposit_amount">-->
									<!--	</td>-->
									<!--</tr>-->
									<tr>]
										<th>Deposited on</th>
										<td colspan="3">
											<input type="text" value="<?=date("d-m-Y")?>" class="form-control" readonly>
											<input type="hidden" name="deposited_on" value="<?=date("Y-m-d")?>">
										</td>
									</tr>
									<tr>
										<th>Notes</th>
										<td colspan="3">
											<input type="text" name="note" class="form-control" required>
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
		highlight();
		
		var actual_sales = (parseInt($('input[name=total_system_sales]').val()) + parseInt($('input[name=bill_amount1]').val())) - (parseInt($('input[name=dc_closing]').val()) + parseInt($('input[name=bill_amount2]').val()));
		$('#actual_sales').val(actual_sales);
		highlight();
		
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
	$('#store-id').on('change', function () {

var selected_val = $('#store-id').val();

get_property_type(selected_val);
get_manual_bills_minus(selected_val);

});
// function get_property_type(store_id) {
// 	$("#bill_amount1").select2({
// 	//minimumInputLength: 2,
//     tags: [],
//    	ajax: {
//         url: baseURL + "get-property-type",
//         dataType: 'json',
//         type: "post",
// 		data: function (store_id) {
//             return {
//                 store_id: store_id
//             };
//         },
//         results: function (data) {
//             return {
//                 results: $.map(data, function (item) {
//                     return {
//                         text: item.amount,
//                         slug: item.amount,
//                         id: item.id
//                     }
//                 })
//             };
//         }
//     }
// });
//  }
 function get_property_type(store_id) {
                                                            $.ajax({
                                                                url: baseURL + "get-property-type",
                                                                type: 'post',
                                                                data: {
                                                                    store_id: store_id
                                                                },
                                                                dataType: 'json',

                                                                success: function (json) {
                                                                    var options = '';
                                                                    options += '<option value="">Select Bill Amount</option>';
                                                                    for (var i = 0; i < json.length; i++) {
                                                                        options += '<option value="' + json[i].id + '">' +
                                                                                json[i].amount + '</option>';
                                                                    }
                                                                    $("#bill_amount1").html(options);
                                                                    //alert(options);
                                                                },
                                                                error: function (xhr, ajaxOptions, thrownError) {
                                                                    console.log(thrownError + "\r\n" + xhr.statusText +
                                                                            "\r\n" + xhr.responseText);
                                                                }
                                                            });

                                                        }
														function get_manual_bills_minus(store_id) {
                                                            $.ajax({
                                                                url: baseURL + "get-manual-bills-minus",
                                                                type: 'post',
                                                                data: {
                                                                    store_id: store_id
                                                                },
                                                                dataType: 'json',

                                                                success: function (json) {
                                                                    var options = '';
                                                                    options += '<option value="">Select Bill Amount</option>';
                                                                    for (var i = 0; i < json.length; i++) {
                                                                        options += '<option value="' + json[i].id + '">' +
                                                                                json[i].amount + '</option>';
                                                                    }
                                                                    $("#bill_amount2").html(options);
                                                                    //alert(options);
                                                                },
                                                                error: function (xhr, ajaxOptions, thrownError) {
                                                                    console.log(thrownError + "\r\n" + xhr.statusText +
                                                                            "\r\n" + xhr.responseText);
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

	function highlight() {
		if($('#total_realised').val() == $('#actual_sales').val()) {

    		$('#total_realised').css('border-color', 'green');
    		$('#actual_sales').css('border-color', 'green');
		}
		else {

    		$('#total_realised').css('border-color', 'red');
    		$('#actual_sales').css('border-color', 'red');
		}
		
	}

</script>