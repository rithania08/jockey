<div class="content-wrapper">
    <section class="content">
        <div class="row">
           <div class="col-md-12">
              <div class="box">
                <div class="box-body table-responsive">
           	<div id="content">
                  <table class="table table-hover data_table">
					<thead>
						<tr>
							<th>Sl. No.</th>
							<th>Store Name</th>
							<th>Report</th>
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
							<td><?=$this->common_model->get_record("tbl_stores", "id = '" . $record->store_id . "'", "name")?></td>
							<td><a href="<?=base_url()?>admin/bill-report/<?=$record->store_id?>" class="btn btn-sm btn-success">View Detailed Report</a></td>
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
        </div>    
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/common.js" charset="utf-8"></script>