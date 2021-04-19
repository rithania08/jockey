<?php
$balance_cash_total = $this->common_model->get_custom_query("select deposit_amount from tbl_salenote_registers  where salenote_id = '$row_id' and status = '0'")[0]->deposit_amount;
$deposits = $this->common_model->get_custom_query("select sum(amount) as amount from tbl_salenote_deposits where status = '0' and salenote_id = '$row_id'");
if (sizeof($deposits) > 0) {
    if ($deposits[0]->amount != "") {
        $balance_cash_total = $balance_cash_total - $deposits[0]->amount;
    }
}
?>
<form role="form" class="insert_data_deposit" this_id="form-02" reload-action="true">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="date">Balance cash</label>
                <input class="form-control" name="balance_cash_total" readonly value="<?= $balance_cash_total ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" name="date" max="<?= date('Y-m-d') ?>" required>
                <input type="hidden" name="table_name" value="tbl_salenote_deposits">
                <input type="hidden" name="salenote_id" value="<?= $row_id ?>">
                <input type="hidden" id="balance_cash_total" value="<?= $balance_cash_total ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="date">Amount</label>
                <input type="number" class="form-control" name="amount" value="0" min="1" required onkeyup="check_amount(this)">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="date">Bank Name</label>
                <input type="text" class="form-control" name="bank_name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="date">Chellan Number</label>
                <input type="chellan_no" class="form-control" name="chellan_no" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="date">Deposit Amount</label>
                <input type="text" class="form-control" name="deposit_amount" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="date">Deposited on</label>
                <input type="date" class="form-control" name="deposited_on" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="date">Transfer pcs bill cash deposited on</label>
                <input type="date" class="form-control" name="transfer_pcs_bill_cash_deposited_on" required>
            </div>
        </div>
        <div class="col-md-12 text-right"> 
            <button type="submit" class="btn btn-primary" >Submit</button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12">
        <table class="table table-border">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Bank Name</th>
                    <th>Chellan Number</th>
                    <th>Deposit Amount </th>
                    <th>Deposited on</th>
                    <th>Transfer pcs bill cash deposited on </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($records as $record): ?>
                    <tr>
                        <td><?= $record->date ?></td>
                        <td><?= $record->amount ?></td>
                        <td><?= $record->bank_name ?></td>
                        <td><?= $record->chellan_no ?></td>
                        <td><?= $record->deposit_amount ?></td>
                        <td><?= $record->deposited_on ?></td>
                        <td><?= $record->transfer_pcs_bill_cash_deposited_on ?></td>
                        <td>
                            <form class="update_data" this_id="form-001<?= uniqid() ?>" reload-action="true">
                                <input type="hidden" name="status" value="1">
                                <input type="hidden" name="table_name" value="tbl_salenote_deposits">
                                <input type="hidden" name="row_id" value="<?= $record->id ?>">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
<?php endforeach; ?>
                <?php if (sizeof($records) == 0): ?>
                    <tr>
                        <td colspan="5" class="text-center">No records</td>
                    </tr>
<?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function check_amount(tis)
    {
        if (parseInt($(tis).val()) > $('#balance_cash_total').val())
        {
            $('#view_deposits button[type=submit]').attr("disabled", "true");
        } else
        {
            $('#view_deposits button[type=submit]').removeAttr("disabled");
        }
    }
</script>