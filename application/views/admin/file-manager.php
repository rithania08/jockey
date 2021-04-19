<div class="content-wrapper">
    
    <section class="content"> 
        <div class="row">
            <div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<div class="row">
							<form class="insert_data" this_id="form-9900" reload-action="true">
								<div class="col-md-3">
									<label>File</label>
									<input type="file" name="image" required class="form-control">
									<input type="hidden" name="table_name" value="tbl_files">
								</div>
								<div class="col-md-3">
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
							<th>File</th>
							<th>Link</th>
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
								<a target="_blank" href="<?=base_url()?>uploads/common/<?php echo $record->image ?>">
									<img width="50" height="50" src="<?=base_url()?>uploads/common/<?php echo $record->image ?>">
								</a>
							</td>
							<td>
								<input class="form-control" type="text" value="<?=base_url()?>uploads/common/<?=$record->image?>">
							</td>
							<td>
								<?=$record->date_time?>
							</td>
							<td class="text-center">
								<form class="update_data" this_id="0003<?=uniqid()?>" reload-action="true">
									<input type="hidden" name="status" value="1">
									<input type="hidden" name="table_name" value="tbl_files">
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
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/common.js" charset="utf-8"></script>
