<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
				<form method="post" action="<?php echo base_url(); ?>admin/deposit-report-export">
			     	<input type="submit" name="export" class="btn btn-success" value="Export Report" />
			    </form>
            </div>
            <div class="col-md-12">
              <div class="box">
                <div class="box-body table-responsive">
           	<div id="content">
                  <table class="table table-hover data_table">
					<thead>
						<tr>
							<th>Sl. No.</th>
							<th>Salenote Id</th>
							<th>Bank Name</th>
							<th>Chellan No.</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Entry Date</th>
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
								<?=$record->salenote_id?>
							</td>
							<td>
								<?=$record->bank_name?>
							</td>
							<td>
								<?=$record->chellan_no?>
							</td>
							<td>
								<?=$record->amount?>
							</td>
							<td>
								<?=date("d-m-Y", strtotime($record->date))?>
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
        </div>    
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/common.js" charset="utf-8"></script>