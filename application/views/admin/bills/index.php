<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#create">
                    Create
                </button>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <?php if ($role_id == 1) { ?>  <h4>Store Name : <?= $store_name ?> </h4>
                          
                            <a href="<?= base_url() ?>admin/bill-report" class="btn btn-success" >Bill Report</a><br><br>
                            <div id="content">
                                <table class="table table-hover data_table">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Bill No</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Balance</th>
                                            <th>Date | Time</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($records)) {
                                            $inc = 1;
                                            foreach ($records as $record) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $inc; ?>
                                                    </td>
                                                    <td>
                                                        <?= $record->bill_no ?>
                                                    </td>
                                                    <td>
                                                        <?= $record->amount ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        if ($record->bill_status == 0) {
                                                            echo "<b style='color:red'>Open</b>";
                                                        } elseif ($record->bill_status == 1) {
                                                            echo "<b style='color:green'>Closed</b>";
                                                        } else {
                                                            echo "<b style='color:orange'>Partially Closed</b>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?= $record->amount - $record->closed_amount ?>
                                                    </td>
                                                    <td>
                                                        <?= date("d M, Y", strtotime($record->date_time)) ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <form class="update_data" this_id="form-0003<?= uniqid() ?>" reload-action="true">
                                                            <input type="hidden" name="status" value="1">
                                                            <input type="hidden" name="table_name" value="tbl_bills">
                                                            <input type="hidden" name="row_id" value="<?= $record->id ?>">
                                                            <?php if ($record->bill_status == '0' || $record->bill_status == '2') { ?>
                                                                <a class="btn btn-sm btn-success" data-target="#close-bill" data-toggle="modal" onclick="$('input[name=row_id]').val(<?= $record->id ?>)">
                                                                    <i class="fa fa-book"></i>
                                                                </a>
                                                            <?php } else { ?>
                                                                <a class="btn btn-sm btn-success get-close-bill" data-target="#close-bill-status" data-toggle="modal" data-id="<?= $record->id ?>">
                                                                    <i class="fa fa-book"></i>
                                                                </a>
                                                            <?php } ?>
                                                            <span class="btn btn-sm btn-warning" onclick="edit_record('<?= $record->id ?>', 'tbl_bills');">
                                                                <i class="fa fa-edit"></i>
                                                            </span>
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
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
                        <?php } else { ?>
                            <form method="post" action="<?php echo base_url(); ?>admin/admin-bill-export">
                                <input type="submit" name="export" class="btn btn-success" value="Export Report" />
                            </form><br>
                            <table class="table table-hover data_table">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Store Name</th>
                                        <th>Bill Count</th>
                                        <th>Open Bill Count</th>
                                        <th>Open Bill Total</th>
                                        <th>Closed Bill Count</th>
                                        <th>Closed Bill Total</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($records)) {
                                        $inc = 1;
                                        foreach ($records as $record) {

                                            $amount = 0;
                                            $open_bill_count = 0;
                                            $open_bill_amount = 0;
                                            $closed_bill_count = 0;
                                            $closed_bill_amount = 0;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $inc; ?>
                                                </td>
                                                <td><a href="<?= base_url() ?>admin/bills/<?= $record->store_id ?>"><b><?= $this->common_model->get_record("tbl_stores", "id = '" . $record->store_id . "'", "name") ?></td>
                                                            <?php $bills = $this->common_model->get_records("tbl_bills", "store_id = '" . $record->store_id . "' and status = '0'"); ?></b></a>
                                                <td><?= count($bills); ?>
                                                </td>
                                                <?php
                                                foreach ($bills as $bill) {
                                                    $amount += $bill->amount;
                                                    if ($bill->bill_status == 0) {
                                                        $open_bill_count++;
                                                        $open_bill_amount += $bill->amount;
                                                    } else {
                                                        $closed_bill_count++;
                                                        $closed_bill_amount += $bill->amount;
                                                    }
                                                }
                                                ?>
                                                <td><?= $open_bill_count; ?></td>
                                                <td>₹ <?= $open_bill_amount; ?></td>
                                                <td><?= $closed_bill_count; ?></td>
                                                <td>₹ <?= $closed_bill_amount; ?></td>
                                                <td>
                                                    ₹ <?= $amount ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $inc++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>



<div id="create" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="insert_data" this_id="form-01">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create</h4>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <?php if ($_SESSION['role'] == ROLE_STORE_ADMIN): ?>
                            <input type="hidden" name="store_id" value="<?= $_SESSION['store_id'] ?>">
                        <?php else: ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_method">Store Name</label>
                                    <select class="form-control" name="store_id" required>
                                        <?php foreach ($this->common_model->get_records("tbl_stores", "status = 0") as $store): ?>
                                            <option value="<?= $store->id ?>"><?= $store->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="bill_no">Bill Number</label>
                                <input type="number" class="form-control" name="bill_no" min="1" value="1" required>
                                <input type="hidden" name="table_name" value="tbl_bills">
                                <!-- <input type="hidden" value="0" name="payment_method"> -->
                            </div>
                        </div>	<div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="text" class="form-control" name="quantity" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" name="amount" min="1" value="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <select class="form-control" name="payment_method" required>
                                    <option value="0">Cash</option>
                                    <option value="1">Card</option>
                                    <option value="2">UPI</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="billed_date">Billed Date</label>
                                <input type="date" class="form-control" name="billed_date" required>
                                <input type="hidden" class="form-control" name="bill_opened_date" value= <?php echo date("Y-m-d"); ?> >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_book_no">Bill Book No</label>
                                <input type="text" class="form-control" name="bill_book_no" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reason">Reason</label>
                                <input type="text" class="form-control" name="reason" required>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="edit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="update_data" this_id="form-02">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit</h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <?php if ($_SESSION['role'] == ROLE_STORE_ADMIN): ?>
                            <input type="hidden" name="store_id" value="<?= $_SESSION['store_id'] ?>">
                        <?php else: ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_method">Store Name</label>
                                    <select class="form-control" name="store_id" required>
                                        <?php foreach ($this->common_model->get_records("tbl_stores", "status = 0") as $store): ?>
                                            <option value="<?= $store->id ?>"><?= $store->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_no">Bill Number</label>
                                <input type="number" class="form-control" name="bill_no" min="1" value="1" required>
                                <input type="hidden" name="table_name" value="tbl_bills">
                                <input type="hidden" name="row_id" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" name="amount" min="1" value="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <select class="form-control" name="payment_method" required>
                                    <option value="0">Cash</option>
                                    <option value="1">Card</option>
                                    <option value="2">UPI</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" name="quantity" min="1" value="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="billed_date">Billed Date</label>
                                <input type="date" class="form-control" name="billed_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_book_no">Bill Book No</label>
                                <input type="text" class="form-control" name="bill_book_no" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reason">Reason</label>
                                <input type="text" class="form-control" name="reason" required>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="close-bill" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="closing_bill_validation" this_id="form-03">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Close Manual Bill</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_no">System Bill Number</label>
                                <input type="number" class="form-control" name="closing_bill_no" min="1" value="1" required>
                                <input type="hidden" name="table_name" value="tbl_bills">
                                <input type="hidden" name="row_id" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product">Closing Date</label>
                                <input type="date" class="form-control" name="closing_date" required value="<?= date("Y-m-d"); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <select class="form-control" name="payment_method" required>
                                    <option value="0">Cash</option>
                                    <option value="1">Card</option>
                                    <option value="2">UPI</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" name="closed_amount" min="1" value="1" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Quantity</label>
                                <input type="number" class="form-control" name="quantity" min="1" value="1" required>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="close-bill-status" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="closing_bill_validation" this_id="form-03">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Close Manual Bill</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bill_no">System Bill Number</label>
                                <input type="number" class="form-control" name="closing_bill_no" min="1" value="1" required disabled="">
                                <input type="hidden" name="table_name" value="tbl_bills">
                                <input type="hidden" name="data-id" value="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product">Closing Date</label>
                                <input type="date" class="form-control" name="closing_date" required disabled="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <select class="form-control" name="payment_method" required disabled="">
                                    <option value="0">Cash</option>
                                    <option value="1">Card</option>
                                    <option value="2">UPI</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" name="closed_amount" min="1" value="1" required disabled="">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Quantity</label>
                                <input type="number" class="form-control" name="quantity" min="1" value="1" required disabled="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <!--<button type="submit" class="btn btn-primary" >Submit</button>-->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/common.js" charset="utf-8"></script>
<script>

                                                    function print_report() {
                                                        var printContents = document.getElementById('content').innerHTML;
                                                        var originalContents = document.body.innerHTML;

                                                        document.body.innerHTML = printContents;

                                                        window.print();

                                                        document.body.innerHTML = originalContents;
                                                    }
</script>
