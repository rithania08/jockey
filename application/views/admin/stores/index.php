<div class="content-wrapper">
    <section class="content"> 
        <div class="row">
            <div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<div class="row">
							<form class="insert_data" this_id="form-9900" reload-action="true">
								<div class="col-md-4">
									<label>Store ID</label>
									<input type="text" name="store_new_id" required class="form-control">
									<input type="hidden" name="table_name" value="tbl_stores">
								</div>
								<div class="col-md-4">
									<label>Store Name</label>
									<input type="text" name="name" required class="form-control"> 
								</div>
								
								<div class="col-md-4">
									<br>
									<button class="btn btn-sm btn-primary">Submit</button>
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
							<th>Store ID</th>
							<th>Store Name</th>
							<th>Date | Time</th>
							<th class="text-center">Actions</th>
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
								<?php echo $record->store_id; ?>
							</td>
							<td>
								<?php echo $record->store_new_id; ?>
							</td>
							<td>
								<form class="update_data" this_id="0002<?=uniqid()?>">
									<input type="text" name="name" required class="form-control" value="<?=$record->name?>">
									<input type="hidden" name="table_name" value="tbl_stores">
									<input type="hidden" name="row_id" value="<?=$record->id?>">
								</form>
							</td>
							<td>
								<?=$record->date_time?>
							</td>
							<td class="text-center">
								<form class="update_data" this_id="0003<?=uniqid()?>" reload-action="true">
									<input type="hidden" name="status" value="1">
									<input type="hidden" name="table_name" value="tbl_stores">
									<input type="hidden" name="row_id" value="<?=$record->id?>">
									<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
								</form>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/common.js" charset="utf-8"></script>