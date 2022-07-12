<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['login'] = 'Login';
$route['Logout'] = 'Logout/index';
$route['denied'] = 'Admin/denied';

$route['login_company'] = 'Login/login_company';
$route['login_company/(:any)'] = 'Login/login_company/$1';

$route['ForgotPassword'] = 'Login/forgotPassword';
$route['resetPassword'] = 'Login/resetPasswordUser';
$route['resetPasswordConfirmUser'] = "Login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "Login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "Login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "Login/createPasswordUser";

$route['dashboard'] = "Admin/index";

$route['users'] = "Admin/users";
$route['users/(:any)'] = "Admin/users/$1";
$route['users/(:any)/(:any)'] = "Admin/users/$1/$2";

$route['roles'] = "Admin/roles";
$route['roles/(:any)'] = "Admin/roles/$1";
$route['roles/(:any)/(:any)'] = "Admin/roles/$1/$2";

$route['items'] = "Admin/items";
$route['items/(:any)'] = "Admin/items/$1";
$route['items/(:any)/(:any)'] = "Admin/items/$1/$2";

$route['price_matrix'] = "Admin/price_matrix";
$route['price_matrix/(:any)'] = "Admin/price_matrix/$1";
$route['price_matrix/(:any)/(:any)'] = "Admin/price_matrix/$1/$2";


$route['customers'] = "Admin/customers";
$route['customers/(:any)'] = "Admin/customers/$1";
$route['customers/(:any)/(:any)'] = "Admin/customers/$1/$2";

$route['parameters'] = "Admin/parameters";
$route['parameters/(:any)'] = "Admin/parameters/$1";
$route['parameters/(:any)/(:any)'] = "Admin/parameters/$1/$2";
//$route['users_add'] = "Admin/users_add";


$route['invoices'] = "Invoice/invoice_list";
$route['invoices/(:any)'] = "Invoice/invoice_list/$1";
$route['invoices/(:any)/(:any)'] = "Invoice/invoice_list/$1/$2";

$route['invoice_uploadcheck'] = "Invoice/invoice_uploadcheck"; 
$route['invoice_vieworders'] = "Invoice/invoice_vieworders"; 

$route['batch_printing'] = "Invoice/batch_print"; 


$route['upload_csv'] = "Invoice/invoice_upload";
$route['upload_csv/(:any)'] = "Invoice/invoice_upload/$1";
$route['upload_csv/(:any)/(:any)'] = "Invoice/invoice_upload/$1/$2";




$route['default_controller'] = 'Login';
$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;
