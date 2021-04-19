<div class="content-wrapper">
    <section class="content"> 
        <div class="row">
            <div class="col-md-12">
				<div class="box">
					<div class="box-body">
    	<h3><b>Salenote Entry Access</b></h3><br>
						<div class="row">
							<form class="access" this_id="form-9902" reload-action="true">
								<div class="col-md-4">
									<label>Store</label>
											<select class="form-control select2" name="store" required>
											<option value="0">
														Select a store
													</option>
												<?php foreach($this->common_model->get_records("tbl_stores", "status = 0") as $store): ?>
													<option value="<?=$store->id?>">
														<?=$store->store_id?> - <?=$store->name?>
													</option>
												<?php endforeach; ?>
											</select>
								</div>
								<div class="col-md-4">
									<label>Entry Access</label>
									<input type="date" name="date" required class="form-control"> 
								</div>
								
								<div class="col-md-4">
									<br>
									<button class="btn btn-sm btn-primary"><b>Give Access</b></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
              <div class="box">
                <div class="box-body table-responsive">
                  <table class="table table-hover data_table">
					<thead>
						<tr>
							<th>Sl. No.</th>
							<th>ID</th>
							<th>Store</th>
							<th>Date</th>
							<th>Status</th>
							<th>Entry Date | Time</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(!empty($records))
						{
							$inc = 1;
							foreach($records as $record)
							{
						?>
						<tr>
							<td>
								<?php echo $inc; ?>
							</td>
							<td>
								<?php echo $this->common_model->get_record("tbl_stores", "id = '" . $record->store . "'", "name"); ?>
							</td>
							<td>
								<?php echo $record->date; ?>
							</td>
							<td>
								<?= date("d-m-Y", strtotime($record->date))?>
							</td>
							<td>
								<?=$record->store_status;?>
							</td>
							<td>
								<?=date("d-m-Y", strtotime($record->date_time))?>
							</td>
							</tr>
						<?php
							$inc++;
							}
						}
						?>
					</tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
	$('.access').submit(function(e){
		e.preventDefault();
		
		var this_id = 'form[this_id=' + $(this).attr('this_id') + ']';
		
		if(is_required(this_id) === true)
		{
			$.ajax({
				type: 'POST',
				url: baseURL + "admin/admin-access",
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
						toastr.success('Access Provided');
						$(this_id + ' input[type=submit]').removeAttr('disabled');
						
						setTimeout(function(){ location.reload(); }, 1000);
						
					}
					else
					{
						toastr.error('Something went wrong!');
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

</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/common.js" charset="utf-8"></script>