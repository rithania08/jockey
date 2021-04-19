<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
				<form method="post" action="<?php echo base_url(); ?>admin/manual-bill-export/<?=$store_id?>">
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
							<th>Store Name</th>
							<th>Bill No</th>
							<th>Billed Date</th>
							<th>Bill Book No.</th>
							<th>Amount</th>
							<th>Payment Method</th>
							<th>Closing Bill No.</th>
							<th>Closing Bill Date</th>
							<th>Reason</th>
							<th>Status</th>
							<th>Date</th>
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
							<td>
								<?=$record->bill_no?>
							</td>
							<td>
								<?=date("d-m-Y", strtotime($record->billed_date));?>
							</td>
							<td>
								<?=$record->bill_book_no?>
							</td>
							<td>
								<?=$record->amount?>
							</td><?php
							 if($record->payment_method == 0) {
							   		$payment_method = "Cash";
							   }
							   else if($record->payment_method == 1) {
							   		$payment_method = "Card";
							   }
							   else {
							   		$payment_method = "UPI";
							   }
							   ?>
							  
							<td>
								<?=$payment_method?>
							</td>
							<td>
								<?=$record->closing_bill_no?>
							</td>

							<td>
								<?=date("d-m-Y", strtotime($record->closing_date))?>
							</td>

							<td>
								<?=$record->reason?>
							</td>

							<td>
								<?php if($record->bill_status == 0) { echo "<b style='color:red'>Open</b>";}else {echo "<b style='color:green'>Closed</b>";} ?>
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