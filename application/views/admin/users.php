<div class="content-wrapper">

    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/addNew"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover data_table">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Store ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Role</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								if(!empty($userRecords))
								{
									$inc = 1;
									foreach($userRecords as $record)
									{
								?>
										<tr>
											<td><?php echo $inc; ?></td>
											<td><?php echo $this->common_model->get_record("tbl_stores", "id = '" . $record->store_id . "'", "store_id") ?></td>
											<td><?php echo $record->name ?></td>
											<td><?php echo $record->email ?></td>
											<td><?php echo $record->mobile ?></td>
											<td><?php echo $record->role ?></td>
											<td class="text-center">
												<a class="btn btn-sm btn-info" href="<?php echo base_url().'admin/editOld/'.$record->userId; ?>">
													<i class="fa fa-pencil"></i>
												</a>
												<a class="btn btn-sm btn-danger deleteUser" href="javascript: void(0);" data-userid="<?php echo $record->userId; ?>">
													<i class="fa fa-trash"></i>
												</a>
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