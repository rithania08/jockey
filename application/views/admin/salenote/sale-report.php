<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
			<form method="post" action="<?php echo base_url(); ?>admin/salenote-export">
			     	<input type="submit" name="export" class="btn btn-success" value="Export Report" />
			    </form>
			    <br>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="box-body table-responsive">
           	<div id="content">
                  <table class="table table-hover data_table">
					<thead>
						<tr>
							<th>Sl. No.</th>
							<th>Store Name</th>
							<?php foreach($day_array as $header){?>
								<th><?=$header?></th>
							<?php }?>
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
								<?php echo $store_array[$inc-1]; ?>
							</td>
							<?php for($i=0;$i<sizeof($day_array);$i++){?>
								<td><?=$records[$inc-1][$i]?></td>
							<?php }?>
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