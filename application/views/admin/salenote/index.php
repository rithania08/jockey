<div class="content-wrapper">
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <?php if(($_SESSION['role'] == ROLE_SUPER_ADMIN) || $alert == 1 || $access->id!='') {  ?>
                <a class="btn btn-info mb-3" href="<?= base_url() ?>admin/create-salenote-page">
                    Create
                </a>
            <?php }else {?>
                <a class="btn btn-info mb-3" href="#" onclick="salenote_alert()">
                    Create
                </a>
            <?php }?>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <?php if ($role_id == 1) { ?>

                <h4> Store name : <?= $this->common_model->get_record("tbl_stores", "id = '" . $records[0]->store_id . "'", "name") ?></h4>
                 <!-- <form method="post" action="<?php echo base_url(); ?>admin/salenote-export">
                     <input type="submit" name="export" class="btn btn-success" value="Export Report" />
                   </form> -->
                            <table class="table table-hover data_table">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Date</th>
                                        <th>Total Sales</th>
                                        <th>No of bills</th>
                                        <th>No of qty</th>
                                        <th>Date | Time</th>
                                        <th>Is verified?</th>
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
                                                <td><?= date("d-m-Y", strtotime($record->date)); ?></td>
                                                <td>₹<?= number_format($record->total_system_sales) ?></td>
                                                <td><?= $record->no_of_bills ?></td>
                                                <td><?= $record->no_of_qty ?></td>
                                                <td>
                                                    <?= date("d-m-Y", strtotime($record->date_time));  ?>
                                                </td>
                                                <td>
                                                    <?php if ($record->is_verified == 0): ?>
                                                        <span class="btn btn-sm btn-warning">Pending</span>
                                                    <?php elseif ($record->is_verified == 1): ?>
                                                        <span class="btn btn-sm btn-success">Verified</span>
                                                    <?php else: ?>
                                                        <span class="btn btn-sm btn-danger">Failed</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <form class="update_data" this_id="form-0003<?= uniqid() ?>" reload-action="true">
                                                        <input type="hidden" name="status" value="1">
                                                        <input type="hidden" name="table_name" value="tbl_salenote">
                                                        <input type="hidden" name="row_id" value="<?= $record->id ?>">

                                                        <?php if (sizeof($this->common_model->get_records("tbl_salenote_registers", "salenote_id = '$record->id' and status = '0'")) == 0): ?>

                                                        <?php else:
                                                            if(($_SESSION['role'] != ROLE_STORE_ADMIN)) { ?>
                                                            <span class="btn btn-sm btn-primary" onclick="files_upload('<?= $record->id ?>', '<?= $record->shopper_sale_file ?>', '<?= $record->bank_statement_file ?>', '<?= $record->cc_bank_statement_file ?>');">
                                                                Verify
                                                            </span>
                                                            <?php }?>
                                                            <span class="btn btn-sm btn-info" onclick="view_deposits('<?= $record->id ?>')">
                                                                Deposits
                                                            </span>
                                                       
                                                       <?php endif; 
                                                        if(date("d-m-Y") == date("d-m-Y", strtotime($record->date_time))) {?>

                                                        <a href="<?= base_url() ?>admin/edit-salenote-page/<?= $record->id ?>" class="btn btn-sm btn-warning">
                                                            Edit
                                                        </a>
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            Delete
                                                        </button>
                                                    <?php }?>

                                                      
                                                    
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

                        <?php } else { ?>
                            <table class="table table-hover data_table">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Store Name</th>
                                        <th>No of days posted</th>
                                        <th>Total Amount</th>
                                        <th>Posted Status </th>
                                        <th>Last Posted date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($records)) {
                                        $inc = 1;

                                        foreach ($records as $record) {
                                            $total_amt = 0;
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $inc; ?>
                                                </td>
                                                <td><a href="<?= base_url() ?>admin/salenote/<?= $record->store_id ?>"><b><?= $this->common_model->get_record("tbl_stores", "id = '" . $record->store_id . "'", "name") ?></b></a></td>
                                                <?php $salenote_records = $this->common_model->get_records("tbl_salenote", "store_id = '" . $record->store_id . "' and status='0'");
                                                ?>
                                                <td><?= count($salenote_records); ?></td>
                                                <?php
                                                foreach ($salenote_records as $salenote_record) {
                                                    $total_amt += $salenote_record->total_system_sales;
                                                }
                                                ?>
                                                <td>₹<?= number_format($total_amt) ?></td>
                                                <?php
                                                $last_posted_date = $this->common_model->get_records("tbl_salenote", "status='0' and store_id='$record->store_id' order by date desc")[0];
                                                $yesterday = date("Y-m-d", strtotime("-1 days"));


                                                if ($last_posted_date->date == $yesterday) {
                                                    $status = "Posted";
                                                } else {
                                                    $status = "Not Posted";
                                                }
                                                ?>

                                                <td><?= $status; ?> </td>

                                                <td> <?= date("d-m-Y", strtotime($last_posted_date->date)) ?>
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

<?php include("edit-salenote.php"); ?>
<?php include("close-register.php"); ?>
<?php include("view-deposits.php"); ?>
<?php include("view-register.php"); ?>
<?php include("verify-now.php"); ?>


<script>

    // Verify now

    $('#files_upload input[name=shopper_sales]').change(function () {
        $.ajax({
            type: 'POST',
            url: baseURL + "admin/upload_csv/shopper_sales",
            data: new FormData($('.shopper_sales')[0]),
            dataType: "json",
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('button[type=submit]').attr('disabled', 'true');
            },
            success: function (response) {
                if (response.result == 1)
                {
                    toastr.success('Upload Success!');
                    $('button[type=submit]').removeAttr('disabled');
                    if (response.success == 1)
                    {
                        $('.shopper_sales input').remove();
                        $('.shopper_sales lebel').after("<i class='fa fa-check text-success'></i>");
                    } else
                    {
                        $('.shopper_sales input').remove();
                        $('.shopper_sales lebel').after("<i class='fa fa-close text-danger'></i>");
                    }
                } else
                {
                    toastr.error('Something went wrong! Please try again later!');
                    $('button[type=submit]').removeAttr('disabled');
                }
            }
        });
    });

    $('#files_upload input[name=cash_bank_statement]').change(function () {
        $.ajax({
            type: 'POST',
            url: baseURL + "admin/upload_csv/cash_bank_statement",
            data: new FormData($('.cash_bank_statement')[0]),
            dataType: "json",
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('button[type=submit]').attr('disabled', 'true');
            },
            success: function (response) {
                if (response.result == 1)
                {
                    toastr.success('Upload Success!');
                    $('button[type=submit]').removeAttr('disabled');
                    if (response.success == 1)
                    {
                        $('.cash_bank_statement input').remove();
                        $('.cash_bank_statement lebel').after("<i class='fa fa-check text-success'></i>");
                    } else
                    {
                        $('.cash_bank_statement input').remove();
                        $('.cash_bank_statement lebel').after("<i class='fa fa-close text-danger'></i>");
                    }
                } else
                {
                    toastr.error('Something went wrong! Please try again later!');
                    $('button[type=submit]').removeAttr('disabled');
                }
            }
        });
    });

    $('#files_upload input[name=cc_bank_statement]').change(function () {
        $.ajax({
            type: 'POST',
            url: baseURL + "admin/upload_csv/cc_bank_statement",
            data: new FormData($('.cc_bank_statement')[0]),
            dataType: "json",
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('button[type=submit]').attr('disabled', 'true');
            },
            success: function (response) {
                if (response.result == 1)
                {
                    toastr.success('Upload Success!');
                    $('button[type=submit]').removeAttr('disabled');
                    if (response.success == 1)
                    {
                        $('.cc_bank_statement input').remove();
                        $('.cc_bank_statement lebel').after("<i class='fa fa-check text-success'></i>");
                    } else
                    {
                        $('.cc_bank_statement input').remove();
                        $('.cc_bank_statement lebel').after("<i class='fa fa-close text-danger'></i>");
                    }
                } else
                {
                    toastr.error('Something went wrong! Please try again later!');
                    $('button[type=submit]').removeAttr('disabled');
                }
            }
        });
    });

    $('#files_upload .salenote_verify_now').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: baseURL + "admin/salenote_verify_now",
            data: new FormData($('.salenote_verify_now')[0]),
            dataType: "json",
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('button[type=submit]').attr('disabled', 'true');
            },
            success: function (response) {
                if (response.result == 1)
                {
                    if (response.verification == 1)
                    {
                        toastr.success('Your salenote has been verified!');
                    } else
                    {
                        toastr.error('Your salenote has not been verified!');
                    }
                    $('#files_upload .modal-body').html("<ol>" + response.msg + "</ol>");
                    $('button[type=submit]').removeAttr('disabled');
                } else
                {
                    toastr.error('Something went wrong! Please try again later!');
                    $('button[type=submit]').removeAttr('disabled');
                }
            }
        });
    });

    function files_upload(id, file1 = null, file2 = null, file3 = null) {
        $('#files_upload .salenote_verify_now .shopper_sale_file_download').hide();
        $('#files_upload .salenote_verify_now .bank_statement_file_download').hide();
        $('#files_upload .salenote_verify_now .cc_bank_statement_file_download').hide();
        var count = 0;
        if (file1 !== null && file1 !== "")
        {
            count++;
            $('#files_upload .salenote_verify_now .shopper_sale_file_download').attr("href", "<?= base_url() ?>uploads/csv-files/" + file1);
            $('#files_upload .salenote_verify_now .shopper_sale_file_download').attr("download", file1);
            $('#files_upload .salenote_verify_now .shopper_sale_file_download').show();
        }
        if (file2 !== null && file2 !== "")
        {
            count++;
            $('#files_upload .salenote_verify_now .bank_statement_file_download').attr("href", "<?= base_url() ?>uploads/csv-files/" + file2);
            $('#files_upload .salenote_verify_now .bank_statement_file_download').attr("download", file2);
            $('#files_upload .salenote_verify_now .bank_statement_file_download').show();
        }
        if (file3 !== null && file3 !== "")
        {
            count++;
            $('#files_upload .salenote_verify_now .cc_bank_statement_file_download').attr("href", "<?= base_url() ?>uploads/csv-files/" + file3);
            $('#files_upload .salenote_verify_now .cc_bank_statement_file_download').attr("download", file3);
            $('#files_upload .salenote_verify_now .cc_bank_statement_file_download').show();
        }
        if (count == 3)
        {
            $('#files_upload .salenote_verify_now button').show();
        } else
        {
            $('#files_upload .salenote_verify_now button').hide();
        }

        $('#files_upload input[name=salenote_id]').val(id);
        $('#files_upload').modal();
    }

    // Edit functions
    function edit_add_biller()
    {
        $('#edit .billers').append('<div class="row biller_row">' +
                '<div class="col-md-7">' +
                '<div class="form-group">' +
                '<label for="bill_no"><span class="snumber"></span> Bill Number</label>' +
                '<select class="form-control" name="bill_no[]" required onchange="edit_get_bill_details(this)">' +
                '<option value="">Select</option>' +
                '<?php foreach ($bills as $bill): ?>' +
                    '<option value="<?= $bill->id ?>"><?= $bill->bill_no ?></option>' +
                    '<?php endforeach; ?>' +
                '</select>' +
                '<input name="bill_amount" type="hidden" value="0">' +
                '<input name="payment_method" type="hidden" value="0">' +
                '<input name="row_id_child[]" type="hidden" value="new">' +
                '</div>' +
                '</div>' +
                '<div class="col-md-3 cr_dr_parent">' +
                '<label for="bill_no">&nbsp;</label><br>' +
                '<select class="form-control cr_dr" name="cr_dr[]" required onchange="edit_rearrange_billers();">' +
                '<option value="0">Credit</option>' +
                '<option value="1">Debit</option>' +
                '</select>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<label for="bill_no">&nbsp;</label><br>' +
                '<span class="btn btn-sm btn-danger" onclick="edit_remove_biller(this)">' +
                '<i class="fa fa-trash"></i>' +
                '</span>' +
                '</div>' +
                '</div>');
        edit_rearrange_billers();
    }
    function edit_remove_biller(tis)
    {
        $(tis).parent().parent().remove();
        edit_rearrange_billers();
    }

    $('#edit input[name=cash_sales]').change(function () {
        edit_rearrange_billers();
    });

    $('#edit input[name=card_sales]').change(function () {
        edit_rearrange_billers();
    });

    $('#edit input[name=upi_sales]').change(function () {
        edit_rearrange_billers();
    });

    $('#edit input[name=dc_closing]').change(function () {
        edit_rearrange_billers();
    });

    $('#edit input[name=total_system_sales]').change(function () {
        edit_rearrange_billers();
    });

    function edit_rearrange_billers()
    {
        $("#edit .snumber").each(function (index) {
            $(this).text(index + 1 + ". ");
        });

        var cash_cr = 0;
        var cash_dr = 0;
        var card_cr = 0;
        var card_dr = 0;
        var upi_cr = 0;
        var upi_dr = 0;

        $("#edit input[name=bill_amount]").each(function (index) {
            if ($(this).next().val() == 0)
            {
                if ($(this).parents('.biller_row').children('.cr_dr_parent').children('.cr_dr').val() == 0)
                {
                    cash_cr += parseInt($(this).val());
                } else if ($(this).parents('.biller_row').children('.cr_dr_parent').children('.cr_dr').val() == 1)
                {
                    cash_dr += parseInt($(this).val());
                }
            } else if ($(this).next().val() == 1)
            {
                if ($(this).parents('.biller_row').children('.cr_dr_parent').children('.cr_dr').val() == 0)
                {
                    card_cr += parseInt($(this).val());
                } else if ($(this).parents('.biller_row').children('.cr_dr_parent').children('.cr_dr').val() == 1)
                {
                    card_dr += parseInt($(this).val());
                }
            } else if ($(this).next().val() == 2)
            {
                if ($(this).parents('.biller_row').children('.cr_dr_parent').children('.cr_dr').val() == 0)
                {
                    upi_cr += $parseInt($(this).val());
                } else if ($(this).parents('.biller_row').children('.cr_dr_parent').children('.cr_dr').val() == 1)
                {
                    upi_dr += parseInt($(this).val());
                }
            }
        });

        $('#edit .cash_cr').text(cash_cr);
        $('#edit .cash_dr').text(cash_dr);
        $('#edit .card_cr').text(card_cr);
        $('#edit .card_dr').text(card_dr);
        $('#edit .upi_cr').text(upi_cr);
        $('#edit .upi_dr').text(upi_dr);

        var total = (parseInt(cash_cr) + parseInt(card_cr) + parseInt(upi_cr));
        var dr = (parseInt(cash_dr) + parseInt(card_dr) + parseInt(upi_dr));
        var ttotal = parseInt(total) - parseInt(dr);

        $('#edit .total_cr_dr').text("(" + total + ") - (" + dr + ") = " + (parseInt(total) - parseInt(dr)));

        var left_side_total = parseInt($('#edit input[name=cash_sales]').val()) + parseInt($('#edit input[name=card_sales]').val()) + parseInt($('#edit input[name=upi_sales]').val());

        if (ttotal < 0)
        {
            var right_side_total = (parseInt($('#edit input[name=total_system_sales]').val()) - parseInt($('#edit input[name=dc_closing]').val())) + parseInt(ttotal);
        } else
        {
            var right_side_total = parseInt($('#edit input[name=total_system_sales]').val()) - (parseInt($('#edit input[name=dc_closing]').val()) + parseInt(ttotal));
        }

        if (left_side_total == right_side_total)
        {
            $('#edit .modal-footer button[type=submit]').removeClass("btn-primary");
            $('#edit .modal-footer button[type=submit]').removeClass("btn-danger");
            $('#edit .modal-footer button[type=submit]').addClass("btn-success");
        } else
        {
            $('#edit .modal-footer button[type=submit]').removeClass("btn-primary");
            $('#edit .modal-footer button[type=submit]').removeClass("btn-success");
            $('#edit .modal-footer button[type=submit]').addClass("btn-danger");
        }
    }

    function edit_get_bill_details(tis)
    {
        var row_id = $(tis).val();
        var table = "tbl_bills";
        $.ajax({
            type: 'POST',
            url: baseURL + "admin/get_record/" + table + "/" + row_id,
            dataType: "json",
            success: function (response) {
                if (response.result == 1)
                {
                    $(tis).next().val(response.data.amount);
                    $(tis).next().next().val(response.data.payment_method);
                    edit_rearrange_billers();
                } else
                {
                    toastr.error('Something went wrong! Please try again later!');
                    $('button').removeAttr('disabled');
                }
            }
        });
    }

    function edit_get_bill_details_in_html(row_id)
    {
        $.ajax({
            type: 'POST',
            url: baseURL + "admin/get_bill_details_in_html/" + row_id,
            success: function (response) {
                $('#edit .billers').html(response);
                edit_rearrange_billers();
            }
        });
    }

    // close_register
    function close_register(row_id)
    {
        var table = "tbl_salenote_bills";
        $.ajax({
            type: 'POST',
            url: baseURL + "admin/get_record/" + table + "/" + row_id,
            data: "custom=get-cash-sales",
            dataType: "json",
            success: function (response) {
                if (response.result == 1)
                {
                    $('#close_register #total_cash_sales').val(response.data.cash_sales);
                    $('#close_register input[name=total_cash_sales]').val(response.data.cash_sales);
                    $('#close_register #deposit_amount').val(response.data.cash_sales);
                    $('#close_register input[name=deposit_amount]').val(response.data.cash_sales);
                    $('#close_register').modal();
                    calculate_denomination_total();
                    $('#close_register input[name=salenote_id]').val(row_id);
                } else
                {
                    toastr.error('Something went wrong! Please try again later!');
                    $('button').removeAttr('disabled');
                }
            }
        });
    }

    $('#close_register .denomination_count').keyup(function () {
        calculate_denomination_total();
    });

    $('#close_register .da_less').keyup(function () {
        calculate_denomination_total();
    });

    function calculate_denomination_total()
    {
        var total = 0;
        $("#close_register .denomination_count").each(function (index) {
            total += parseInt($(this).val()) * parseInt($(this).attr("data-value"));
        });
        $('#close_register #denomination_total').val(total);
        if ($('#close_register input[name=total_cash_sales]').val() != total)
        {
            $('#close_register #denomination_total').css("border", "1px solid red");
            $('#close_register #close_register button[type=submit]').attr("disabled", "true");
        } else
        {
            $('#close_register #denomination_total').css("border", "1px solid green");
            $('#close_register #close_register button[type=submit]').removeAttr("disabled");
        }

        var deposit_amount = 0;
        deposit_amount = parseInt($('#close_register input[name=total_cash_sales]').val()) - (parseInt($('#close_register input[name=transfer_to_petty_cash]').val()));
        $('#close_register #deposit_amount').val(deposit_amount);
        $('#close_register input[name=deposit_amount]').val(deposit_amount);
    }

    // view_deposits
    function view_deposits(row_id)
    {
        $.ajax({
            type: 'POST',
            url: baseURL + "admin/get_deposits",
            data: "row_id=" + row_id,
            success: function (response) {
                $('#view_deposits_body').html(response);
                $('#view_deposits').modal();
            }
        });
    }

    // view_register
    function view_register(row_id)
    {
        var table = "tbl_salenote_registers";
        $.ajax({
            type: 'POST',
            url: baseURL + "admin/get_record/" + table + "/" + row_id,
            dataType: "json",
            beforeSend: function () {
                $('button').attr('disabled', 'true');
            },
            success: function (response) {
                if (response.result == 1)
                {
                    Object.keys(response.data).forEach(function (key) {
                        $('#view_register input[name=' + key + ']').val(response.data[key]);
                    });
                    $('#view_register input[name=denomination_total]').val(response.data.total_cash_sales);
                    $('button').removeAttr('disabled');
                    $('#view_register').modal();
                } else
                {
                    toastr.error('Something went wrong! Please try again later!');
                    $('button').removeAttr('disabled');
                }
            }
        });
    }

    function salenote_alert() {
        toastr.error("Please contact admin to create salenote");
    }
</script>