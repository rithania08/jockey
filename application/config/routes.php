<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "Frontend";
$route['404_override'] = 'frontend/pageNotFound';

/*********** ADMIN ROUTES *******************/

$route['admin'] = 'admin/login/loginMe';
$route['admin/login'] = 'admin/login/loginMe';
$route['admin/loginMe'] = 'admin/login/loginMe';
$route['admin/dashboard'] = 'admin/common_controller/index';
$route['admin/logout'] = 'admin/user/logout';
$route['admin/userListing'] = 'admin/user/userListing';
$route['admin/userListing/(:num)'] = "admin/user/userListing/$1";
$route['admin/addNew'] = "admin/user/addNew";

$route['admin/addNewUser'] = "admin/user/addNewUser";
$route['admin/editOld'] = "admin/user/editOld";
$route['admin/editOld/(:num)'] = "admin/user/editOld/$1";
$route['admin/editUser'] = "admin/user/editUser";
$route['admin/deleteUser'] = "admin/user/deleteUser";
$route['admin/loadChangePass'] = "admin/user/loadChangePass";
$route['admin/changePassword'] = "admin/user/changePassword";
$route['admin/pageNotFound'] = "admin/user/pageNotFound";
$route['admin/checkEmailExists'] = "admin/user/checkEmailExists";

$route['admin/forgotPassword'] = "admin/login/forgotPassword";
$route['admin/resetPasswordUser'] = "admin/login/resetPasswordUser";
$route['admin/resetPasswordConfirmUser'] = "admin/login/resetPasswordConfirmUser";
$route['admin/resetPasswordConfirmUser/(:any)'] = "admin/login/resetPasswordConfirmUser/$1";
$route['admin/resetPasswordConfirmUser/(:any)/(:any)'] = "admin/login/resetPasswordConfirmUser/$1/$2";
$route['admin/createPasswordUser'] = "admin/login/createPasswordUser";

$route['admin/insert'] = "admin/common_controller/insert";
$route['admin/update'] = "admin/common_controller/update";
$route['admin/get_record/(:any)/(:any)'] = "admin/common_controller/get_record/$1/$2";
$route['get-property-type']="admin/common_controller/get_property_type";
$route['get-manual-bills-minus']="admin/common_controller/get_manual_bills_minus";

$route['admin/file-manager'] = "admin/common_controller/file_manager";
$route['admin/stores'] = "admin/common_controller/stores";
$route['admin/sale-report'] = "admin/common_controller/sale_report";

/*********** CUSTOM ADMIN ROUTES *******************/
$route['admin/bills'] = "admin/common_controller/bills";
$route['admin/bills/(:any)'] = "admin/common_controller/bill_list/$1";
$route['admin/salenote-export'] = "admin/common_controller/salenote_export";
$route['admin/closing-bill-validation'] = "admin/common_controller/closing_bill_validation";
$route['admin/get/get-close-bill/(:any)'] = "admin/common_controller/get_close_bill/$1";
$route['admin/manual-bill-export/(:any)'] = "admin/common_controller/manual_bill_export/$1";
$route['admin/store-list'] = "admin/common_controller/store_list";
$route['admin/salenote/(:any)'] = "admin/common_controller/salenote_list/$1";
$route['admin/bill-report/(:any)'] = "admin/common_controller/bill_report/$1";
$route['admin/salenote'] = "admin/common_controller/salenote";

$route['admin/admin-bill-export'] = "admin/common_controller/admin_bill_export";
$route['admin/deposit-report'] = "admin/common_controller/deposit_report";
$route['admin/deposit-report-export'] = "admin/common_controller/deposit_report_export";


$route['admin/create-salenote-page'] = "admin/common_controller/create_salenote_page";
$route['admin/edit-salenote-page/(:any)'] = "admin/common_controller/edit_salenote_page/$1";
$route['admin/salenote_insert_data'] = "admin/common_controller/salenote_insert_data";
$route['admin/salenote_update_data'] = "admin/common_controller/salenote_update_data";
$route['admin/get_bill_details_in_html/(:any)'] = "admin/common_controller/edit_get_bill_details_in_html/$1";
$route['admin/get_deposits'] = "admin/common_controller/get_deposits";
$route['admin/upload_csv/(:any)'] = "admin/common_controller/upload_csv/$1";
$route['admin/salenote_verify_now'] = "admin/common_controller/salenote_verify_now";
$route['admin/salenote-entry-access'] = "admin/common_controller/salenote_entry_access";
$route['admin/admin-access'] = "admin/common_controller/admin_access";

/*********** FRONTEND ROUTES *******************/

$route['/'] = 'admin/login/loginMe';
$route['login'] = 'admin/login/loginMe';