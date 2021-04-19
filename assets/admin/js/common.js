/**
 * @author Praveen Murali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "admin/deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});

	$('.salenote_insert_data').submit(function(e){
		e.preventDefault();
		
		var this_id = 'form[this_id=' + $(this).attr('this_id') + ']';
		
		var total_realised = $('#total_realised').val();
		var actual_sales = $('#actual_sales').val();
		var total_bank_amount = $('#total_bank_amount').val();
		var bank_cash = $('#bank_cash').val();
		
		if(is_required(this_id) === true)
		{
			if(total_realised == actual_sales ){
				if( total_bank_amount == bank_cash){
			$.ajax({
				type: 'POST',
				url: baseURL + "admin/salenote_insert_data",
				data: new FormData(this),
				dataType: "json",
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(this_id + ' input[type=submit]').attr('disabled', 'true');
				},
				success: function(response){
					console.log(response)
					if(response.result == 1)
					{
						$(this_id)[0].reset();
						toastr.success('Success!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
						
						if($(this_id).attr('reload-action') === 'true')
						{
							setTimeout(function(){ location.reload(); }, 1000);
						}
					}
					else
					{
						toastr.error('Something went wrong! Please try again later!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
					}
				}
			});
		}else{
			toastr.error('Total Bank Amount and Bank Cash are not equal!');
		}
		} else{
			toastr.error('Total Realised and Actual Sales are not equal!');
		}
	}
		else
		{
			toastr.error('Please check the required fields!');
		}
	
	});
	
	$('.salenote_update_data').submit(function(e){
		e.preventDefault();
		
		var this_id = 'form[this_id=' + $(this).attr('this_id') + ']';
		
		if(is_required(this_id) === true)
		{
			$.ajax({
				type: 'POST',
				url: baseURL + "admin/salenote_update_data",
				data: new FormData(this),
				dataType: "json",
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(this_id + ' input[type=submit]').attr('disabled', 'true');
				},
				success: function(response){
					console.log(response)
					if(response.result == 1)
					{
						toastr.success('Success!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
						
						if($(this_id).attr('reload-action') === 'true')
						{
							setTimeout(function(){ location.reload(); }, 1000);
						}
					}
					else
					{
						toastr.error('Something went wrong! Please try again later!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
					}
				}
			});
		}
		else
		{
			toastr.error('Please check the required fields!');
		}
	});
	
	$('body').on("submit", '.insert_data', function(e){
		e.preventDefault();
		
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances[instance].updateElement();
		}
		
		var this_id = 'form[this_id=' + $(this).attr('this_id') + ']';
		
		if(is_required(this_id) === true)
		{
			$.ajax({
				type: 'POST',
				url: baseURL + "admin/insert",
				data: new FormData(this),
				dataType: "json",
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(this_id + ' input[type=submit]').attr('disabled', 'true');
				},
				success: function(response){
					console.log(response)
					if(response.result == 1)
					{
						$(this_id)[0].reset();
						toastr.success('Success!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
						
						if($(this_id).attr('row-data') === 'yes')
						{
							update_table_data(this_id);
						}
						if($(this_id).attr('reload-action') === 'true')
						{
							setTimeout(function(){ location.reload(); }, 1000);
						}
					}
					else
					{
						toastr.error('Something went wrong! Please try again later!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
					}
				}
			});
		}
		else
		{
			toastr.error('Please check the required fields!');
		}
	});
	
	$('body').on("submit", '.update_data', function(e){
		e.preventDefault();
		
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances[instance].updateElement();
		}
		
		var this_id = 'form[this_id=' + $(this).attr('this_id') + ']';
		var is_ok = 1;
		if(is_required(this_id) === true)
		{
			if($(this).children('input[name=status]').val() == 1)
			{
				if(confirm("Are you sure to delete this record?"))
				{
					is_ok = 1;
				}
				else
				{
					is_ok = 0;
				}
			}
			
			if(is_ok == 1)
			{
				$.ajax({
					type: 'POST',
					url: baseURL + "admin/update",
					data: new FormData(this),
					dataType: "json",
					contentType: false,
					processData: false,
					beforeSend: function() {
						$(this_id + ' input[type=submit]').attr('disabled', 'true');
					},
					success: function(response){
						if(response.result == 1)
						{
							toastr.success('Success!');
							$(this_id + ' input[type=submit]').removeAttr('disabled');
							
							if($(this_id).attr('reload-action') === 'true')
							{
								setTimeout(function(){ location.reload(); }, 1000);
							}
						}
						else
						{
							toastr.error('Something went wrong! Please try again later!');
							$(this_id + ' input[type=submit]').removeAttr('disabled');
						}
					}
				});
			}
		}
		else
		{
			toastr.error('Please check the required fields!');
		}
	});
	
	function is_required(this_id){
		$('.error-span').hide();
		var inc = 0;
		$(this_id + " .required").each(function(){
			console.log($(this).attr('name'));
			if($(this).val() !== "undefined")
			{
				if($(this).val() != null)
				{
					if(($(this).val()).length > 0)
					{
						
					}
					else
					{
						console.log($(this).attr('name'));
						$(this).next("span").show();
						inc++;
					}
				}
				else
				{
					toastr.error('Something went wrong on ' + $(this).attr('name'));
					inc++;
				}
			}		
		});
		if(inc === 0)
		{
			return true;
		}
		return false;
	}
	
	function edit_record(row_id, table)
	{
		$.ajax({
			type: 'POST',
			url: baseURL + "admin/get_record/" + table + "/" + row_id,
			dataType: "json",
			beforeSend: function() {
				$('button').attr('disabled', 'true');
			},
			success: function(response){
				if(response.result == 1)
				{
					$('#edit input[name=row_id]').val(row_id);
					Object.keys(response.data).forEach(function (key) {
						$('#edit input[name=' + key + ']').val(response.data[key]);
						if(key == "payment_method" || key == "store_id") {

							$('#edit select[name=' + key + ']').val(response.data[key]);
						}
					});
					$('button').removeAttr('disabled');
					$('#edit').modal();
				}
				else
				{
					toastr.error('Something went wrong! Please try again later!');
					$('button').removeAttr('disabled');
				}
			}
		});
	}

	$('#closing_bill_validation').submit(function(e){
		e.preventDefault();
		
		var this_id = 'form[this_id=' + $(this).attr('this_id') + ']';
		
		if(is_required(this_id) === true)
		{
			$.ajax({
				type: 'POST',
				url: baseURL + "admin/closing-bill-validation",
				data: new FormData(this),
				dataType: "json",
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(this_id + ' input[type=submit]').attr('disabled', 'true');
				},
				success: function(response){
					if(response.result == 1)
					{
						toastr.success('Success! - Manual Bill Closed');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
						
						setTimeout(function(){ location.reload(); }, 1000);
						
					}
					else if(response.result == 2)
					{
						toastr.error('Payment method and Amount does not match!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
					}

					else if(response.result == 3)
					{
						toastr.error('Quantity and Amount does not match!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
					}

					else if(response.result == 4)
					{
						toastr.error('Payment method and Amount does not match!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
					}

					else if(response.result == 5)
					{
						toastr.error('Payment method and Quantity does not match!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
					}
					else if(response.result == 7)
					{
						toastr.error('Amount does not match!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
					}

					else if(response.result == 8)
					{
						toastr.error('Payment method does not match!');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
					}
				}
			});
		}
		else
		{
			toastr.error('Please check the required fields!');
		}
	});
