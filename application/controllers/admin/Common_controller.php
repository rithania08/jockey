<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/libraries/Excel.php';

class Common_controller extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/common_model');
        $this->load->library('excel');
        $this->isLoggedIn();

        $this->global['tis'] = $this;
    }

    public function index() {
        $this->global['pageTitle'] = 'Dashboard : ' . $this->config->item('app_name');
        $where = "";
        if ($_SESSION['role'] == ROLE_STORE_ADMIN) {
            $where = " and store_id = '" . $_SESSION['store_id'] . "'";
        }
        $this->global['manual_bills'] = $this->common_model->get_records("tbl_bills", "status = '0' $where order by id desc");
        $this->global['salenotes'] = $this->common_model->get_records("tbl_salenote", "status = '0' $where order by id desc");


        $this->loadViews("dashboard", $this->global, NULL, NULL);
    }

    public function bills() {
        $this->global['pageTitle'] = 'Bills : ' . $this->config->item('app_name');

        $where = "";
        $this->global['role_id'] = 0;
        if ($_SESSION['role'] == ROLE_STORE_ADMIN) {
            $where = " and store_id = '" . $_SESSION['store_id'] . "'";
            $this->global['role_id'] = 1;
            $this->global['records'] = $this->common_model->get_records("tbl_bills", "status = '0' $where order by id desc");
        } else {

            $this->global['records'] = $this->common_model->get_custom_query("select * from tbl_bills where status = '0' group by store_id order by id desc");
        }
        $this->loadViews("bills/index", $this->global, NULL, NULL);
    }

    public function bill_list($id) {
        $this->global['pageTitle'] = 'Bills : ' . $this->config->item('app_name');
        $this->global['store_name'] = $this->common_model->get_record("tbl_stores", "id = '" . $id . "'", "name");
        $this->global['role_id'] = 1;
        $this->global['records'] = $this->common_model->get_records("tbl_bills", "status = '0' and store_id='$id' group by id order by id desc");

        $this->loadViews("bills/index", $this->global, NULL, NULL);
    }

    public function salenote() {
        $this->global['pageTitle'] = 'Sale Note : ' . $this->config->item('app_name');
        if ($_SESSION['role'] == ROLE_STORE_ADMIN) {
            $where = " and store_id = '" . $_SESSION['store_id'] . "'";
            $this->global['role_id'] = 1;
            $records = $this->common_model->get_records("tbl_salenote", "status = '0' $where order by id desc");
            $this->global['access'] = $this->common_model->get_records("tbl_admin_access", "status = '0' and store='$_SESSION[store_id]' and store_status='Pending'")[0];
        } else {

            $records = $this->common_model->get_custom_query("select * from tbl_salenote where status = '0' group by store_id order by id desc");
        }

        $this->global['alert'] = 0;
        foreach ($records as $record) {
            $date = explode(" ", $record->date_time);
            if(date("Y-m-d",strtotime($date[0])) ==  date("Y-m-d",strtotime("-1 days"))) {
                $this->global['alert'] = 1;
                break;
            }
        }
        $this->global['records'] = $records;

         $this->loadViews("salenote/index", $this->global, NULL, NULL);
    }

    public function salenote_list($id) {
        $this->global['pageTitle'] = 'Sale Note : ' . $this->config->item('app_name');
        $this->global['role_id'] = 1;
        $records = $this->common_model->get_records("tbl_salenote", "status = '0' and store_id='$id' order by id desc");

        $this->global['alert'] = 0;
        foreach ($records as $record) {
            $date = explode(" ", $record->date_time);
            if(date("Y-m-d",strtotime($date[0]))  ==  date("Y-m-d",strtotime("0 days"))) {

                $this->global['alert'] = 1;
                break;
            }
        }
        $this->global['records'] = $records;
        $this->loadViews("salenote/index", $this->global, NULL, NULL);
    }

    public function get_store_bills($id) {
        $open_bills = $this->common_model->get_records("tbl_bills", "status='0' and store_id='$id' and bill_status='0' ");
        //$closed_bills = $this->common_model->get_records("tbl_bills","status='0' and store_id='$id' and bill_status='1'");
        $data['result'] = 1;
        echo json_encode($data);
    }

    function get_property_type() {
        $json = array();
        $id = $this->input->post('store_id');
        $today = date("Y-m-d");
        $json = $this->common_model->get_custom_query("select * from tbl_bills a where bill_status='0' and store_id='$id' and a.bill_opened_date='$today' and a.bill_closed_date!= a.bill_opened_date");
        echo json_encode($json);
    }

    function get_manual_bills_minus() {
        $json = array();
        $id = $this->input->post('store_id');
        $today = date("Y-m-d");
        $json = $this->common_model->get_custom_query("select * from tbl_bills a where bill_status='1' and store_id='$id' and a.bill_closed_date='$today' and a.bill_closed_date!= a.bill_opened_date");
        echo json_encode($json);
    }

    public function create_salenote_page() {
        $this->global['pageTitle'] = 'Create Sale Note : ' . $this->config->item('app_name');

        $where = "";
        if ($_SESSION['role'] == ROLE_STORE_ADMIN) {
            $where = " and store_id = '" . $_SESSION['store_id'] . "'";
        }

        $this->global['records'] = $this->common_model->get_records("tbl_salenote", "status = '0' $where order by id desc");
        $this->global['created_bills'] = $this->common_model->get_records("tbl_bills", "status = '0' and bill_status='0' $where order by id desc");

        $this->global['closed_bills'] = $this->common_model->get_records("tbl_bills", "status = '0' and bill_status='1' $where order by id desc");


        $this->global['access'] = $this->common_model->get_records("tbl_admin_access", "status = '0' and store='$_SESSION[store_id]'and store_status='Pending'")[0];
        $this->loadViews("salenote/create-salenote", $this->global, NULL, NULL);
    }

    public function edit_salenote_page($id) {
        $this->global['pageTitle'] = 'Edit Sale Note : ' . $this->config->item('app_name');

        $where = "";
        if ($_SESSION['role'] == ROLE_STORE_ADMIN) {
            $where = " and store_id = '" . $_SESSION['store_id'] . "'";
        }

        $this->global['record'] = $this->common_model->get_records("tbl_salenote", "status = '0' and id = '$id' $where")[0];
        $this->global['register'] = $this->common_model->get_records("tbl_salenote_registers", "status = '0' and salenote_id = '$id' $where")[0];
        $this->global['bill_amount1'] = $this->common_model->get_records("tbl_salenote_bills", "status = '0' and salenote_id = '$id' and cr_dr = '1' $where");
        $this->global['bill_amount2'] = $this->common_model->get_records("tbl_salenote_bills", "status = '0' and salenote_id = '$id' and cr_dr = '0' $where");
        $this->global['bills'] = $this->common_model->get_records("tbl_bills", "status = '0' $where order by id desc");


        $this->loadViews("salenote/edit-salenote", $this->global, NULL, NULL);
    }

    public function stores() {
        $this->global['pageTitle'] = 'Stores : ' . $this->config->item('app_name');

        $this->global['records'] = $this->common_model->get_records("tbl_stores", "status = '0' order by id desc");

        $this->loadViews("stores/index", $this->global, NULL, NULL);
    }

    function file_manager() {
        $this->global['records'] = $this->common_model->get_records("tbl_files", "status = '0' order by id desc");
        $this->global['pageTitle'] = 'File Manager : ' . $this->config->item('app_name');
        $this->loadViews("file-manager", $this->global, NULL, NULL);
    }

    function get_deposits() {
        $this->global['records'] = $this->common_model->get_records("tbl_salenote_deposits", "status = '0' and salenote_id = '$_POST[row_id]' order by id desc");
        $this->global['row_id'] = $_POST['row_id'];
        $this->load->view("admin/salenote/get_deposits", $this->global);
    }

    function edit_get_bill_details_in_html($row_id) {
        $this->global['records'] = $this->common_model->get_records("tbl_salenote_bills", "status = '0' and salenote_id = '$row_id' order by id desc");
        $this->global['bills'] = $this->common_model->get_records("tbl_bills", "status = '0' order by id desc");
        $this->load->view("admin/salenote/edit_get_bill_details_in_html", $this->global);
    }

    function salenote_insert_data() {

        $info['date'] = $_POST['date'];
        $info['mtd'] = $_POST['mtd'];
        $info['lymtd'] = $_POST['lymtd'];
        $info['no_of_bills'] = $_POST['no_of_bills'];
        $info['no_of_qty'] = $_POST['no_of_qty'];
        $info['total_system_sales'] = $_POST['total_system_sales'];
        $info['dc_closing'] = $_POST['dc_closing'];
        $info['upi_sales'] = $_POST['upi_sales'];
        $info['card_sales'] = $_POST['card_sales'];
        $info['cash_sales'] = $_POST['cash_sales'];
        $info['store_id'] = $_POST['store_id'];
        $info['salenote_entry_access'] = $_POST['salenote_entry_access'];
        if($info['salenote_entry_access'] == 1) {
            $info4['store_status'] = "Completed";
            $this->common_model->update("tbl_admin_access",$info4,"status='0' and store='$_SESSION[store_id]'");

        $info['date_time'] = $_POST['date'];
        }

        if ($insert_id = $this->common_model->insert("tbl_salenote", $info)) {
            $info1['salenote_id'] = $insert_id;
            $inc = 0;
            foreach ($_POST['add_bill_no'] as $val) {
                if ($val != "") {
                    $info1['bill_no'] = $val;
                    $info1['cr_dr'] = "1";
                    $this->common_model->insert("tbl_salenote_bills", $info1);
                }
                $inc++;
            }

            foreach ($_POST['less_bill_no'] as $val) {
                if ($val != "") {
                    $info1['bill_no'] = $val;
                    $info1['cr_dr'] = "0";
                    $this->common_model->insert("tbl_salenote_bills", $info1);
                }
                $inc++;
            }

            $info2['salenote_id'] = $insert_id;
            $info2['total_cash_sales'] = $_POST['total_cash_sales'];
            $info2['transfer_to_petty_cash'] = $_POST['transfer_to_petty_cash'];
            $info2['count_2000'] = $_POST['count_2000'];
            $info2['count_500'] = $_POST['count_500'];
            $info2['count_200'] = $_POST['count_200'];
            $info2['count_100'] = $_POST['count_100'];
            $info2['count_50'] = $_POST['count_50'];
            $info2['count_20'] = $_POST['count_20'];
            $info2['count_10'] = $_POST['count_10'];
            $info2['count_coins'] = $_POST['count_coins'];
            $info2['deposit_amount'] = $_POST['deposit_amount'];
            $info2['deposited_on'] = $_POST['deposited_on'];
            $info2['transfer_pcs_bill_cash_deposited_on'] = $_POST['transfer_pcs_bill_cash_deposited_on'];
            $info2['note'] = $_POST['note'];

            $this->common_model->insert("tbl_salenote_registers", $info2);

            $data['result'] = 1;
        } else {
            $data['result'] = 0;
        }

        echo json_encode($data);
    }

    function salenote_update_data() {
        $info['mtd'] = $_POST['mtd'];
        $info['lymtd'] = $_POST['lymtd'];
        $info['no_of_bills'] = $_POST['no_of_bills'];
        $info['no_of_qty'] = $_POST['no_of_qty'];
        $info['total_system_sales'] = $_POST['total_system_sales'];
        $info['dc_closing'] = $_POST['dc_closing'];
        $info['upi_sales'] = $_POST['upi_sales'];
        $info['card_sales'] = $_POST['card_sales'];
        $info['cash_sales'] = $_POST['cash_sales'];
        $info['store_id'] = $_POST['store_id'];


        if ($insert_id = $this->common_model->update("tbl_salenote", $info, "id = '$_POST[salenote_id]'")) {
            $info1['salenote_id'] = $_POST['salenote_id'];

            $this->common_model->delete_data("tbl_salenote_bills", "salenote_id = '$_POST[salenote_id]'");

            $inc = 0;
            foreach ($_POST['add_bill_no'] as $val) {
                if ($val != "") {
                    $info1['bill_no'] = $val;
                    $info1['cr_dr'] = "1";
                    $this->common_model->insert("tbl_salenote_bills", $info1);
                }
                $inc++;
            }

            foreach ($_POST['less_bill_no'] as $val) {
                if ($val != "") {
                    $info1['bill_no'] = $val;
                    $info1['cr_dr'] = "0";
                    $this->common_model->insert("tbl_salenote_bills", $info1);
                }
                $inc++;
            }

            $info2['total_cash_sales'] = $_POST['total_cash_sales'];
            $info2['transfer_to_petty_cash'] = $_POST['transfer_to_petty_cash'];
            $info2['count_2000'] = $_POST['count_2000'];
            $info2['count_500'] = $_POST['count_500'];
            $info2['count_200'] = $_POST['count_200'];
            $info2['count_100'] = $_POST['count_100'];
            $info2['count_50'] = $_POST['count_50'];
            $info2['count_20'] = $_POST['count_20'];
            $info2['count_10'] = $_POST['count_10'];
            $info2['count_coins'] = $_POST['count_coins'];
            $info2['deposit_amount'] = $_POST['deposit_amount'];
            $info2['note'] = $_POST['note'];

            $this->common_model->update("tbl_salenote_registers", $info2, "salenote_id = '$_POST[salenote_id]'");

            $data['result'] = 1;
        } else {
            $data['result'] = 0;
        }

        echo json_encode($data);
    }

    function upload_csv($key) {
        $data['result'] = 0;
        if ($key == "shopper_sales") {
            $target_dir = "uploads/csv-files/";
            $FileType = strtolower(pathinfo($_FILES["shopper_sales"]["name"], PATHINFO_EXTENSION));
            $file_name = time() . uniqid() . "." . $FileType;
            $target_file = $target_dir . $file_name;
            $uploadOk = 1;

            if ($FileType != "csv") {
                $uploadOk = 0;
            }
            if ($FileType == "xls" || $FileType == "xlsx") {
                $uploadOk = 2;
            }

            if ($uploadOk == 2) {

                $path = $_FILES["shopper_sales"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                $count = 0;
                $count1 = 0;
                $success = 0;
                $amount_initial = 0;
                $cash_amount = 0;
                $cc_amount = 0;
                $upi_amount = 0;
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $salenote_id = $_POST['salenote_id'];

                        $salesperson_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $product_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $party = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $quantity = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $sale_value = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $discount = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $tax = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $other_charges = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $deductions = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $returns = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $amount = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $payment_method = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $file_name = $file_name;
                        $info[] = array(
                            'salenote_id' => $salenote_id,
                            'salesperson_id' => $salesperson_id,
                            'product_name' => $product_name,
                            'party' => $party,
                            'quantity' => $quantity,
                            'sale_value' => $sale_value,
                            'discount' => $discount,
                            'tax' => $tax,
                            'other_charges' => $other_charges,
                            'deductions' => $deductions,
                            'returns' => $returns,
                            'amount' => $amount,
                            'payment_method' => $payment_method,
                            'file_name' => $file_name
                        );
                        if ($salesperson_id != "") {
                            $success++;
                            $amount_initial += $amount;
                            if ($payment_method == "cash") {
                                $cash_amount += $amount_initial;
                            }
                            if ($payment_method == "cc") {
                                $cc_amount += $amount_initial;
                            }
                            if ($payment_method == "upi") {
                                $upi_amount += $amount_initial;
                            }
                        }
                    }

                    $this->common_model->batch_insert("tbl_uploaded_bills", $info);
                }

                $sales['shopper_sale_file'] = $file_name;
                $sales['shopper_sale_payments_total'] = $amount_initial;
                $sales['shopper_sale_cc_payments_total'] = $cc_amount;
                $sales['shopper_sale_cash_payments_total'] = $cash_amount;
                $sales['shopper_sale_upi_payments_total'] = $upi_amount;
                $this->common_model->update("tbl_salenote", $sales, "id = '" . $_POST['salenote_id'] . "'");

                $data['payments_total'] = $amount_initial;
                $data['cc_payments_total'] = $cc_amount;
                $data['cash_payments_total'] = $cash_amount;
                $data['upi_payments_total'] = $upi_amount;
                $data['result'] = 1;
                move_uploaded_file($_FILES["shopper_sales"]["tmp_name"], $target_file);
            } else if ($uploadOk == 1) {
                $db = get_instance()->db->conn_id;
                if (move_uploaded_file($_FILES["shopper_sales"]["tmp_name"], $target_file)) {
                    $file = fopen($target_file, "r");
                    $count = 0;
                    $count1 = 0;
                    $success = 0;
                    $amount = 0;
                    $cash_amount = 0;
                    $cc_amount = 0;
                    $upi_amount = 0;
                    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        if ($count > 1) {
                            if ($emapData[0] != "") {
                                $info['salenote_id'] = $_POST['salenote_id'];
                                $info['salesperson_id'] = mysqli_real_escape_string($db, $emapData[0]);
                                $info['product_name'] = mysqli_real_escape_string($db, $emapData[1]);
                                $info['party'] = mysqli_real_escape_string($db, $emapData[2]);
                                $info['quantity'] = mysqli_real_escape_string($db, $emapData[3]);
                                $info['sale_value'] = str_replace(",", "", mysqli_real_escape_string($db, $emapData[4]));
                                $info['discount'] = str_replace(",", "", mysqli_real_escape_string($db, $emapData[5]));
                                $info['tax'] = str_replace(",", "", mysqli_real_escape_string($db, $emapData[6]));
                                $info['other_charges'] = str_replace(",", "", mysqli_real_escape_string($db, $emapData[7]));
                                $info['deductions'] = str_replace(",", "", mysqli_real_escape_string($db, $emapData[8]));
                                $info['returns'] = str_replace(",", "", mysqli_real_escape_string($db, $emapData[9]));
                                $info['amount'] = str_replace(",", "", mysqli_real_escape_string($db, $emapData[10]));
                                $info['payment_method'] = mysqli_real_escape_string($db, $emapData[11]);
                                $info['file_name'] = $file_name;

                                if ($info['salesperson_id'] != "") {
                                    if ($this->common_model->insert("tbl_uploaded_bills", $info)) {
                                        $success++;
                                        $amount += $info['amount'];
                                        if ($info['payment_method'] == "cash") {
                                            $cash_amount += $info['amount'];
                                        }
                                        if ($info['payment_method'] == "cc") {
                                            $cc_amount += $info['amount'];
                                        }
                                        if ($info['payment_method'] == "upi") {
                                            $upi_amount += $info['amount'];
                                        }
                                    }
                                }
                                $count1++;
                            }
                        }
                        $count++;
                    }
                    if ($count1 == $success) {
                        $sales['shopper_sale_file'] = $file_name;
                        $sales['shopper_sale_payments_total'] = $amount;
                        $sales['shopper_sale_cc_payments_total'] = $cc_amount;
                        $sales['shopper_sale_cash_payments_total'] = $cash_amount;
                        $sales['shopper_sale_upi_payments_total'] = $upi_amount;
                        $this->common_model->update("tbl_salenote", $sales, "id = '" . $_POST['salenote_id'] . "'");

                        $data['payments_total'] = $amount;
                        $data['cc_payments_total'] = $cc_amount;
                        $data['cash_payments_total'] = $cash_amount;
                        $data['upi_payments_total'] = $upi_amount;
                        $data['result'] = 1;
                    }
                }
            }
        }

        if ($key == "cash_bank_statement") {
            $target_dir = "uploads/csv-files/";
            $FileType = strtolower(pathinfo($_FILES["cash_bank_statement"]["name"], PATHINFO_EXTENSION));
            $file_name = time() . uniqid() . "." . $FileType;
            $target_file = $target_dir . $file_name;
            $uploadOk = 1;

            if ($FileType != "csv") {
                $uploadOk = 0;
            }
            if ($FileType == "xls" || $FileType == "xlsx") {
                $uploadOk = 2;
            }

            if ($uploadOk == 2) {

                $path = $_FILES["cash_bank_statement"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                $count = 0;
                $count1 = 0;
                $success = 0;
                $amount_initial = 0;
                $dp_amount = 0;
                $cr_amount = 0;
                $dr_amount = 0;
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $salenote_id = $_POST['salenote_id'];

                        $transaction_date = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $value_date = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $cheque_no = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $transaction_particulars = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $amount = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $dr_cr = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $balance = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $branch_name = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $deposit = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $file_name = $file_name;
                        $info[] = array(
                            'salenote_id' => $salenote_id,
                            'transaction_date' => $transaction_date,
                            'cheque_no' => $cheque_no,
                            'transaction_particulars' => $transaction_particulars,
                            'amount' => $amount,
                            'dr_cr' => $dr_cr,
                            'balance' => $balance,
                            'branch_name' => $branch_name,
                            'deposit' => $deposit,
                            'file_name' => $file_name
                        );
                        if ($salesperson_id != "") {
                            $success++;
                            if ($deposit == 0) {
                                $amount_initial += $amount;
                                if ($dr_cr == "CR") {
                                    $cr_amount += $amount_initial;
                                }
                                if ($dr_cr == "DR") {
                                    $dr_amount += $amount_initial;
                                }
                            } else {
                                $dp_amount += $amount_initial;
                            }
                        }
                    }

                    $this->common_model->batch_insert("tbl_salenote_bank_statements", $info);
                }

                $sales['bank_statement_file'] = $file_name;
                $sales['bank_statement_amount'] = $amount_initial;
                $sales['bank_statement_deposited_amount'] = $dp_amount;
                $sales['bank_statement_cr_amount'] = $cr_amount;
                $sales['bank_statement_dr_amount'] = $dr_amount;
                $this->common_model->update("tbl_salenote", $sales, "id = '" . $_POST['salenote_id'] . "'");
                $data['payments_total'] = $amount_initial;
                $data['result'] = 1;
                move_uploaded_file($_FILES["cash_bank_statement"]["tmp_name"], $target_file);
            } else if ($uploadOk != 0) {
                $db = get_instance()->db->conn_id;
                if (move_uploaded_file($_FILES["cash_bank_statement"]["tmp_name"], $target_file)) {
                    $file = fopen($target_file, "r");
                    $count = 0;
                    $count1 = 0;
                    $success = 0;
                    $amount = 0;
                    $dp_amount = 0;
                    $cr_amount = 0;
                    $dr_amount = 0;
                    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        if ($count > 1) {
                            if ($emapData[0] != "") {
                                $info['salenote_id'] = $_POST['salenote_id'];
                                $info['transaction_date'] = mysqli_real_escape_string($db, $emapData[0]);
                                $info['value_date'] = mysqli_real_escape_string($db, $emapData[1]);
                                $info['cheque_no'] = mysqli_real_escape_string($db, $emapData[2]);
                                $info['transaction_particulars'] = mysqli_real_escape_string($db, $emapData[3]);
                                $info['amount'] = mysqli_real_escape_string($db, $emapData[4]);
                                $info['dr_cr'] = mysqli_real_escape_string($db, $emapData[5]);
                                $info['balance'] = mysqli_real_escape_string($db, $emapData[6]);
                                $info['branch_name'] = mysqli_real_escape_string($db, $emapData[7]);
                                $info['deposit'] = mysqli_real_escape_string($db, $emapData[8]);
                                $info['file_name'] = $file_name;

                                if ($info['transaction_date'] != "") {
                                    if ($this->common_model->insert("tbl_salenote_bank_statements", $info)) {
                                        $success++;
                                        if ($info['deposit'] == 0) {
                                            $amount += $info['amount'];
                                            if ($info['dr_cr'] == "CR") {
                                                $cr_amount += $info['amount'];
                                            }
                                            if ($info['dr_cr'] == "DR") {
                                                $dr_amount += $info['amount'];
                                            }
                                        } else {
                                            $dp_amount += $info['amount'];
                                        }
                                    }
                                }
                                $count1++;
                            }
                        }
                        $count++;
                    }
                    if ($count1 == $success) {
                        $sales['bank_statement_file'] = $file_name;
                        $sales['bank_statement_amount'] = $amount;
                        $sales['bank_statement_deposited_amount'] = $dp_amount;
                        $sales['bank_statement_cr_amount'] = $cr_amount;
                        $sales['bank_statement_dr_amount'] = $dr_amount;
                        $this->common_model->update("tbl_salenote", $sales, "id = '" . $_POST['salenote_id'] . "'");
                        $data['payments_total'] = $amount;
                        $data['result'] = 1;
                    }
                }
            }
        }

        if ($key == "cc_bank_statement") {
            $target_dir = "uploads/csv-files/";
            $FileType = strtolower(pathinfo($_FILES["cc_bank_statement"]["name"], PATHINFO_EXTENSION));
            $file_name = time() . uniqid() . "." . $FileType;
            $target_file = $target_dir . $file_name;
            $uploadOk = 1;
            $gross_amt = 0;
            if ($FileType != "csv") {
                $uploadOk = 0;
            }
            if ($FileType == "xls" || $FileType == "xlsx") {
                $uploadOk = 2;
            }

            if ($uploadOk == 2) {

                $path = $_FILES["cc_bank_statement"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                $count = 0;
                $count1 = 0;
                $success = 0;
                $amount = 0;
                $gross_amt_initial = 0;
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $salenote_id = $_POST['salenote_id'];

                        $term_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $tran_date = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $tran_time = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $batch_no = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $card_type = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $ti = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $balance = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $card_no = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $approve_code = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $rrn = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $gross_amt = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $mdr = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $emi = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $gst = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $net_amt = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $mid = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $intl_flag = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                        $cash_type = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $cash_amount = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                        $process_date = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                        $utr = $worksheet->getCellByColumnAndRow(20, $row)->getValue();

                        $file_name = $file_name;
                        $info[] = array(
                            'salenote_id' => $salenote_id,
                            'term_id' => $term_id,
                            'tran_date' => $tran_date,
                            'tran_time' => $tran_time,
                            'batch_no' => $batch_no,
                            'card_type' => $card_type,
                            'ti' => $ti,
                            'card_no' => $card_no,
                            'approve_code' => $approve_code,
                            'rrn' => $rrn,
                            'gross_amt' => $gross_amt,
                            'mdr' => $mdr,
                            'emi' => $emi,
                            'gst' => $gst,
                            'net_amt' => $net_amt,
                            'mid' => $mid,
                            'intl_flag' => $intl_flag,
                            'cash_type' => $cash_type,
                            'cash_amount' => $cash_amount,
                            'process_date' => $process_date,
                            'utr' => $utr,
                            'file_name' => $file_name
                        );
                        if ($term_id != "") {
                            $success++;
                            $gross_amt_initial += $gross_amt;
                        }
                    }
                    $this->common_model->batch_insert("tbl_salenote_cc_bank_statements", $info);
                }


                $sales['cc_bank_statement_file'] = $file_name;
                $sales['cc_bank_statement_gross_amt'] = $gross_amt_initial;
                $this->common_model->update("tbl_salenote", $sales, "id = '" . $_POST['salenote_id'] . "'");
                $data['total_gross_amt'] = $gross_amt_initial;
                $data['result'] = 1;
                move_uploaded_file($_FILES["cc_bank_statement"]["tmp_name"], $target_file);
            }

            if ($uploadOk != 0) {
                $db = get_instance()->db->conn_id;
                if (move_uploaded_file($_FILES["cc_bank_statement"]["tmp_name"], $target_file)) {
                    $file = fopen($target_file, "r");
                    $count = 0;
                    $count1 = 0;
                    $success = 0;
                    $amount = 0;
                    $gross_amt = 0;
                    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        if ($count > 1) {
                            if ($emapData[0] != "") {
                                $info['salenote_id'] = $_POST['salenote_id'];
                                $info['term_id'] = mysqli_real_escape_string($db, $emapData[0]);
                                $info['tran_date'] = mysqli_real_escape_string($db, $emapData[1]);
                                $info['tran_time'] = mysqli_real_escape_string($db, $emapData[2]);
                                $info['batch_no'] = mysqli_real_escape_string($db, $emapData[3]);
                                $info['card_type'] = mysqli_real_escape_string($db, $emapData[4]);
                                $info['ti'] = mysqli_real_escape_string($db, $emapData[5]);
                                $info['card_no'] = mysqli_real_escape_string($db, $emapData[6]);
                                $info['approve_code'] = mysqli_real_escape_string($db, $emapData[7]);
                                $info['rrn'] = mysqli_real_escape_string($db, $emapData[8]);
                                $info['gross_amt'] = mysqli_real_escape_string($db, $emapData[9]);
                                $info['mdr'] = mysqli_real_escape_string($db, $emapData[10]);
                                $info['emi'] = mysqli_real_escape_string($db, $emapData[11]);
                                $info['gst'] = mysqli_real_escape_string($db, $emapData[12]);
                                $info['net_amt'] = mysqli_real_escape_string($db, $emapData[13]);
                                $info['mid'] = mysqli_real_escape_string($db, $emapData[14]);
                                $info['intl_flag'] = mysqli_real_escape_string($db, $emapData[15]);
                                $info['cash_type'] = mysqli_real_escape_string($db, $emapData[16]);
                                $info['cash_amount'] = mysqli_real_escape_string($db, $emapData[17]);
                                $info['process_date'] = mysqli_real_escape_string($db, $emapData[18]);
                                $info['utr'] = mysqli_real_escape_string($db, $emapData[19]);
                                $info['file_name'] = $file_name;

                                if ($info['term_id'] != "") {
                                    if ($this->common_model->insert("tbl_salenote_cc_bank_statements", $info)) {
                                        $success++;
                                        $gross_amt += $info['gross_amt'];
                                    }
                                }
                                $count1++;
                            }
                        }
                        $count++;
                    }
                    if ($count1 == $success) {
                        $sales['cc_bank_statement_file'] = $file_name;
                        $sales['cc_bank_statement_gross_amt'] = $gross_amt;
                        $this->common_model->update("tbl_salenote", $sales, "id = '" . $_POST['salenote_id'] . "'");
                        $data['total_gross_amt'] = $gross_amt;
                        $data['result'] = 1;
                    }
                }
            }
        }

        echo json_encode($data);
    }

    function salenote_verify_now() {
        $success = 0;
        $data['msg'] .= "";
        $data['result'] = 0;
        $info['is_verified'] = 2;
        $salenote_id = $_POST['salenote_id'];
        $salenote = $this->common_model->get_records("tbl_salenote", "id = '$salenote_id'")[0];

        if ($salenote->shopper_sale_file != "" && $salenote->bank_statement_file != "" && $salenote->cc_bank_statement_file != "") {
            $total_system_sales = $this->common_model->get_custom_query("select total_system_sales from tbl_salenote where id = '$salenote_id' and status = '0'")[0]->total_system_sales;

            $cash_sales = $this->common_model->get_custom_query("select cash_sales from tbl_salenote where id = '$salenote_id' and status = '0'")[0]->cash_sales;

            $card_sales = $this->common_model->get_custom_query("select card_sales from tbl_salenote where id = '$salenote_id' and status = '0'")[0]->card_sales;

            $upi_sales = $this->common_model->get_custom_query("select upi_sales from tbl_salenote where id = '$salenote_id' and status = '0'")[0]->upi_sales;

            if ($salenote->shopper_sale_payments_total == $total_system_sales) {
                $success++;
            } else {
                $data['msg'] .= "<li>Shopper sale total payments does not matched with total system sale. <br><b>(₹" . $salenote->shopper_sale_payments_total . " - ₹" . $total_system_sales . ")</b></li>";
            }
            if ($salenote->shopper_sale_cc_payments_total == $card_sales) {
                $success++;
            } else {
                $data['msg'] .= "<li>Shopper sale total card payments does not matched with total system card sale. <br><b>(₹" . $salenote->shopper_sale_cc_payments_total . " - ₹" . $card_sales . ")</b></li>";
            }
            if ($salenote->shopper_sale_cash_payments_total == $cash_sales) {
                $success++;
            } else {
                $data['msg'] .= "<li>Shopper sale total cash payments does not matched with total system cash sale. <br><b>(₹" . $salenote->shopper_sale_cash_payments_total . " - ₹" . $cash_sales . ")</b></li>";
            }
            if ($salenote->shopper_sale_upi_payments_total == $upi_sales) {
                $success++;
            } else {
                $data['msg'] .= "<li>Shopper sale total upi payments does not matched with total system upi sale. <br><b>(₹" . $salenote->shopper_sale_upi_payments_total . " - ₹" . $upi_sales . ")</b></li>";
            }
            if ($salenote->shopper_sale_cc_payments_total == $salenote->cc_bank_statement_gross_amt) {
                $success++;
            } else {
                $data['msg'] .= "<li>Shopper sale total card payments does not matched with gross amount bank statement for card payments. <br><b>(₹" . $salenote->shopper_sale_cc_payments_total . " - ₹" . $salenote->cc_bank_statement_gross_amt . ")</b></li>";
            }
            if ($this->common_model->get_record("tbl_salenote_registers", "salenote_id = '$salenote_id'", "deposit_amount") == $salenote->bank_statement_deposited_amount) {
                $success++;
            } else {
                $data['msg'] .= "<li>System deposit amount does not matched with bank statement. <br><b>(₹" . $this->common_model->get_record("tbl_salenote_registers", "salenote_id = '$salenote_id'", "deposit_amount") . " - ₹" . $salenote->bank_statement_deposited_amount . ")</b></li>";
            }

            $cr_sales = $this->common_model->get_custom_query("select sum(b.amount) as cr_sales from tbl_salenote_bills as a, tbl_bills as b where a.salenote_id = '$salenote_id' and a.cr_dr = '0' and a.status = '0' and b.id = a.bill_no")[0]->cr_sales;
            $dr_sales = $this->common_model->get_custom_query("select sum(b.amount) as dr_sales from tbl_salenote_bills as a, tbl_bills as b where a.salenote_id = '$salenote_id' and a.cr_dr = '1' and a.status = '0' and b.id = a.bill_no")[0]->dr_sales;

            $leftsidetotal = $card_sales + $cash_sales + $upi_sales;
            $rightsidetotal = ($total_system_sales + $cr_sales) - $dr_sales;

            if ($leftsidetotal == $rightsidetotal) {
                $success++;
            } else {
                $data['msg'] .= "<li>Total payments (Card, Cash, UPI) does not matched with total system sale. <br><b>(₹" . $leftsidetotal . " - ₹" . $rightsidetotal . ")</b></li>";
            }

            if ($success == 7) {
                $info['is_verified'] = 1;
                $data['msg'] = "<li>All the payments are in correct format</li>";
                $this->common_model->update("tbl_salenote", $info, "id = '$salenote_id'");
            }

            $data['result'] = 1;
        } else {
            $data['msg'] = "<li>Please upload all the documents to verify!</li>";
        }

        echo json_encode($data);
    }

    function insert() {

        foreach ($_POST as $key => $value) {
            if ($key != 'table_name' && $key != 'row_id') {
                $info[$key] = $value;
            }
        }

        $table = $this->input->post('table_name');

        $folder_name = "common";

        if ($table == "tbl_stores") {
            $info['store_id'] = $this->common_model->get_record("tbl_stores", "status != 2", "max(store_id)") + 1;
        }

        foreach ($_FILES as $key => $value) {
            $file_new_name = date('Ydm') . time() . uniqid() . "." . strtolower(pathinfo($_FILES[$key]["name"], PATHINFO_EXTENSION));
            if ($this->image_upload($key, $file_new_name, 'uploads/' . $folder_name . '/') == true) {
                $info[$key] = $file_new_name;
            }
        }

        if ($insert_id = $this->common_model->insert($table, $info)) {
            $data['result'] = 1;
            $data['insert_id'] = $insert_id;
        } else {
            $data['result'] = 0;
        }

        echo json_encode($data);
    }

    function update() {
        $info = array();
        foreach ($_POST as $key => $value) {
            if ($key != 'table_name' && $key != 'row_id') {
                $info[$key] = $value;
            }
        }

        $table = $this->input->post('table_name');
        $row_id = $this->input->post('row_id');

        $folder_name = "common";

        foreach ($_FILES as $key => $value) {
            $file_new_name = date('Ydm') . time() . uniqid() . "." . strtolower(pathinfo($_FILES[$key]["name"], PATHINFO_EXTENSION));
            if ($this->image_upload($key, $file_new_name, 'uploads/' . $folder_name . '/') == true) {
                $info[$key] = $file_new_name;
            }
        }
        if ($this->common_model->update($table, $info, "id = '" . $row_id . "'")) {
            $data['result'] = 1;
        } else {
            $data['result'] = 0;
        }


        echo json_encode($data);
    }

    function get_record($table, $row_id) {
        $data['result'] = 0;
        $select = "*";
        $where = "id = '$row_id'";
        $query = "select " . $select . " from " . $table . " where " . $where;
        if (isset($_POST['custom'])) {
            if ($_POST['custom'] == "get-cash-sales") {
                $query = "select cash_sales from tbl_salenote where id = '$row_id' and status = '0'";

                $records = $this->common_model->get_custom_query($query);
                if (sizeof($records) > 0) {
                    if ($records[0]->cash_sales == "") {
                        $records[0]->cash_sales = 0;
                    }
                    $data['data'] = $records[0];
                    $data['result'] = 1;
                }
            } elseif ($_POST['custom'] == "get-bill-amount") {
                $amount1 = 0;
                $amount2 = 0;
                foreach (explode(",", $_POST['row_id1']) as $row_id) {
                    $query = "select amount from tbl_bills where id = '$row_id' and status = '0'";
                    $records = $this->common_model->get_custom_query($query);
                    if (sizeof($records) > 0) {
                        $amount1 += $records[0]->amount;
                    }
                }
                foreach (explode(",", $_POST['row_id2']) as $row_id) {
                    $query = "select amount from tbl_bills where id = '$row_id' and status = '0'";
                    $records = $this->common_model->get_custom_query($query);
                    if (sizeof($records) > 0) {
                        $amount2 += $records[0]->amount;
                    }
                }
                $data['data1'] = $amount1;
                $data['data2'] = $amount2;
                $data['result'] = 1;
            }
        } else {
            $records = $this->common_model->get_custom_query($query);
            if (sizeof($records) > 0) {
                $data['data'] = $records[0];
                $data['result'] = 1;
            }
        }

        echo json_encode($data);
    }

    function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    function image_upload($atr_name, $file_new_name, $target_dir) {
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($_FILES[$atr_name]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $file_new_name;
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG") {
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($_FILES[$atr_name]["tmp_name"], $target_file)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /*public function closing_bill_validation() {
        $id = $_POST['row_id'];
        $quantity = $_POST['quantity'];
        $payment_method = $_POST['payment_method'];
        $amount = $_POST['closed_amount'];
        $closing_bill_no = $_POST['closing_bill_no'];
        $closing_date = $_POST['closing_date'];
        $record = $this->common_model->get_records("tbl_bills", "status = '0' and id ='$id'")[0];
        if ($record->amount == $amount) {
            $info['bill_status'] = 1;
        } else if ($record->amount != $amount) {
            $info['bill_status'] = 2;
        }
        $info['closed_amount'] = $amount;
        $info['closing_bill_no'] = $closing_bill_no;
        $info['closing_date'] = $closing_date;
        $info['bill_closed_date'] = date("Y-m-d");
        $this->common_model->update("tbl_bills", $info, "status='0' and id='$id'");
        $data['result'] = 1;

        echo json_encode($data);
    }*/

    function get_close_bill($data_id) {
        $data['record'] = $this->common_model->get_records("tbl_bills", "status = '0' and id ='$data_id'")[0];
        $data['result'] = 1;
        echo json_encode($data);
    }
    

   public function closing_bill_validation() {
       $id = $_POST['row_id'];
       $quantity = $_POST['quantity'];
       $payment_method = $_POST['payment_method'];
       $amount = $_POST['closed_amount'];
       $closing_bill_no = $_POST['closing_bill_no'];
       $closing_date = $_POST['closing_date'];
       $record = $this->common_model->get_records("tbl_bills", "status = '0' and id ='$id'")[0];
       if ($record->quantity == $quantity && $record->amount == $amount && $record->payment_method == $payment_method) {
           $info['bill_status'] = 1;
           $info['closed_amount'] =  $record->closed_amount + $amount;
           $info['closing_bill_no'] = $closing_bill_no;
           $info['closing_date'] = $closing_date;
           $info['bill_closed_date'] = date("Y-m-d");
           $this->common_model->update("tbl_bills", $info, "status='0' and id='$id'");
           $data['result'] = 1;
       } else if ($record->quantity != $quantity && $record->payment_method != $payment_method) {
           $data['result'] = 2;
       } else if ($record->quantity != $quantity) {
           $data['result'] = 6;
       } else if ($record->payment_method != $payment_method) {
           $data['result'] = 8;
       }  else if ($record->amount != $amount) {
           $info['bill_status'] = 2;
           $info['closed_amount'] = $record->closed_amount + $amount;
           $this->common_model->update("tbl_bills", $info, "status='0' and id='$id'");
           $data['result'] = 7;
       }
       echo json_encode($data);
   }

    public function manual_bill_export($id) {
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);


        $table_columns = array("Store", "Bill No.", "Billed Date", "Bill Book No.", "Amount", "Payment Method", "Closing Bill No.(System bill)", "Closing Date", "Reason", "Status");

        $column = 0;

        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $where = "";
        if ($_SESSION['role'] == ROLE_STORE_ADMIN) {
            $where = " and store_id = '" . $_SESSION['store_id'] . "'";
        }

        $employee_data = $this->common_model->get_records("tbl_bills", "status='0' and store_id='$id' $where order by id desc");

        $excel_row = 2;

        foreach ($employee_data as $row) {
            $store = $this->common_model->get_record("tbl_stores", "id = '" . $row->store_id . "'", "name");
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $store);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->bill_no);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->billed_date);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->bill_book_no);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->amount);
            if ($row->payment_method == 0) {
                $payment_method = "Cash";
            } else if ($row->payment_method == 1) {
                $payment_method = "Card";
            } else {
                $payment_method = "UPI";
            }
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $payment_method);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->closing_bill_no);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->closing_date);
            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->reason);
            if ($row->bill_status == 0) {
                $status = "Open";
            } else {
                $status = "Closed";
            }

            $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $status);
            $excel_row++;
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Manual Bill Report.xls"');
        $object_writer->save('php://output');
    }

    public function bill_report($id) {

        $this->global['records'] = $this->common_model->get_records("tbl_bills", "status = '0' and store_id='$id' order by id desc");
        $this->global['store_id'] = $id;
        $this->loadViews("bills/bill-report", $this->global, NULL, NULL);
    }

    public function store_list() {
        $where = "";
        if ($_SESSION['role'] == ROLE_STORE_ADMIN) {
            $where = " and store_id = '" . $_SESSION['store_id'] . "'";
        }
        $this->global['records'] = $this->common_model->get_records("tbl_bills", "status = '0' $where group by store_id order by id desc");


        $this->loadViews("bills/store-list", $this->global, NULL, NULL);
    }

    public function admin_bill_export() {
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);


        $table_columns = array("Store Name", "Bill Count", "Open Bill Count", "Open Bill Total", "Closed Bill Count", "Closed Bill Total", "Total Amount");

        $column = 0;

        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $employee_data = $this->common_model->get_custom_query("select * from tbl_bills where status = '0' group by store_id order by id desc");

        $excel_row = 2;

        foreach ($employee_data as $row) {

            $amount = 0;
            $open_bill_count = 0;
            $open_bill_amount = 0;
            $closed_bill_count = 0;
            $closed_bill_amount = 0;
            $store = $this->common_model->get_record("tbl_stores", "id = '" . $row->store_id . "'", "name");
            $bills = $this->common_model->get_records("tbl_bills", "store_id = '" . $row->store_id . "' and status = '0'");
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
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $store);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, count($bills));
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $open_bill_count);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $open_bill_amount);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $closed_bill_count);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $closed_bill_amount);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $amount);
            $excel_row++;
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Admin Bill Report.xls"');
        $object_writer->save('php://output');
    }

    public function deposit_report() {
        $this->global['records'] = $this->common_model->get_records("tbl_salenote_deposits", "status = '0' order by id desc");
        $this->loadViews("salenote/deposit-report", $this->global, NULL, NULL);
    }

    public function deposit_report_export() {
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);


        $table_columns = array("Salenote ID", "Bank Name", "Chellan no.", "Amount", "Date", "Entry Date");

        $column = 0;

        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $employee_data = $this->common_model->get_records("tbl_salenote_deposits", "status = '0' order by id desc");

        $excel_row = 2;

        foreach ($employee_data as $row) {

            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->salenote_id);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->bank_name);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->chellan_no);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->amount);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, date("d-m-y", strtotime($row->date)));
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, date("d-m-y", strtotime($row->date_time)));
            $excel_row++;
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Deposit Report.xls"');
        $object_writer->save('php://output');
    }

    public function salenote_export() {
        $object = new PHPExcel();

        $object->setActiveSheetIndex(0);

        $day_array = array();
        $date = date('F Y'); //Current Month Year
        while (strtotime($date) <= strtotime(date('Y-m') . '-' . date('t', strtotime($date)))) {
            $day_num = date('d', strtotime($date)); //Day number
            $day_name = date('m', strtotime($date)); //Day name
            $day_abrev = date('Y', strtotime($date)); //th, nd, st and rd
            $day = "$day_abrev-$day_name-$day_num";
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date))); //Adds 1 day onto current date
            array_push($day_array, $day);
        }

        $column = 1;

        foreach ($day_array as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }
        $where = "";
        $where2 = "";
        if ($_SESSION['role'] == ROLE_STORE_ADMIN) {
            $where = " and store_id = '" . $_SESSION['store_id'] . "'";
            $where2 = " and id = '" . $_SESSION['store_id'] . "'";
        }

        //$employee_data = $this->common_model->get_records("tbl_salenote","status='0' $where order by store_id asc");

        $employee_data = $this->common_model->get_records("tbl_stores", "status='0' $where2 order by id asc");

        $excel_row = 2;

        foreach ($employee_data as $row) {
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->name);
            $excel_row_2 = 1;
            $data = $this->common_model->get_records("tbl_salenote", "status='0' and store_id='$row->id' $where order by store_id asc");
            foreach ($data as $row2) {
                $date_time = explode(" ", $row2->date_time);
                for ($i = 0; $i < sizeof($day_array); $i++) {
                    if ($day_array[$i] == $date_time[0]) {
                        $j = $i;
                        $object->getActiveSheet()->setCellValueByColumnAndRow($j + 1, $excel_row, $row2->total_system_sales);
                    }
                    $excel_row_2++;
                }
            }
            $excel_row++;
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Salenote Report.xls"');
        $object_writer->save('php://output');
    }

    public function sale_report() {
        $where = "";
        $where2 = "";
        if ($_SESSION['role'] == ROLE_STORE_ADMIN) {
            $where = " and store_id = '" . $_SESSION['store_id'] . "'";
            $where2 = " and id = '" . $_SESSION['store_id'] . "'";
        }
        $day_array = array();
        $date = date('F Y'); //Current Month Year
        while (strtotime($date) <= strtotime(date('Y-m') . '-' . date('t', strtotime($date)))) {
            $day_num = date('d', strtotime($date)); //Day number
            $day_name = date('m', strtotime($date)); //Day name
            $day_abrev = date('Y', strtotime($date)); //th, nd, st and rd
            $day = "$day_abrev-$day_name-$day_num";
            $date = date("d-m-Y", strtotime("+1 day", strtotime($date))); //Adds 1 day onto current date
            array_push($day_array, $date);
        }
        $employee_data = $this->common_model->get_records("tbl_stores", "status='0' $where2 order by id asc");

        $initial_array = array();
        $store_array = array();
        foreach ($employee_data as $row) {
            array_push($store_array, $row->name);
            $data = $this->common_model->get_records("tbl_salenote", "status='0' and store_id='$row->id' $where order by store_id asc");
            $temporary_array = array();

            foreach ($data as $row2) {
                $date_time = explode(" ", $row2->date_time);
                for ($i = 0; $i < sizeof($day_array); $i++) {
                    if ($day_array[$i] == $date_time[0]) {
                        $temporary_array[$i] = $row2->total_system_sales;
                    }
                }
            }

            array_push($initial_array, $temporary_array);
        }

        $this->global['day_array'] = $day_array;
        $this->global['records'] = $initial_array;
        $this->global['store_array'] = $store_array;

        $this->loadViews("salenote/sale-report", $this->global, NULL, NULL);
    }

    function salenote_entry_access() {
        $this->global['records'] = $this->common_model->get_records("tbl_admin_access", "status='0'  order by id asc");
        $this->loadViews("salenote-entry-access", $this->global, NULL, NULL);
    }

    public function admin_access() {
        $info['store'] = $_POST['store'];
        $info['date'] = $_POST['date'];
        $this->common_model->insert("tbl_admin_access",$info);
        $data['result'] = 1;
        echo json_encode($data);
    }
}

?>