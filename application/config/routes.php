<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'user';
$route['404_override'] = 'error_page';
$route['translate_uri_dashes'] = FALSE;

$route[FAQ] = UE_FOLDER . '/faqs/frontend';
$route[UA_LOGIN] = 'auth/login';
$route[UA_LOGOUT] = 'auth/logout';
$route[UA_REGISTRATION] = 'auth/registration';
$route[UA_RESETPASSWORD] = 'auth/resetpassword';
$route[UA_FORGOTPASSWORD] = 'auth/forgotpassword';
$route[UA_VERIFY] = 'auth/verify';
$route[UA_CHANGEPASSWORD] = 'user/changepassword';
$route[UA_PROFILE] = 'user';
$route[UA_EDITPROFILE] = 'user/update';
$route[UA_TRANSACTION] = '/transaction/add';
$route[UA_TRANSACTIONDETAIL . '/(:any)'] = '/transaction/detail/$1';
$route[UA_TRANSHISTORY] = '/transaction';
$route[UA_SCHEDULE] = '/schedule/add';
$route[UA_SCHEHISTORY] = '/schedule';
$route[UA_RATINGS] = '/ratings';
$route[UA_COMPLAINT] = '/complaint';

$route[UE_ADMIN] = UE_FOLDER . '/beranda';
$route[UE_LOGIN] = UE_FOLDER . '/auth/login';
$route[UE_LOGOUT] = UE_FOLDER . '/auth/logout';
$route[UE_EMPLOYEE] = UE_FOLDER . '/employee';
$route[UE_APPLICANT] = UE_FOLDER . '/applicant';
$route[UE_JOBCAT] = UE_FOLDER . '/jobcat';
$route[UE_POSITION] = UE_FOLDER . '/position';
$route[UE_VERIFY] = UE_FOLDER . '/auth/verify';
$route[UE_EDITPROFILE] = UE_FOLDER . '/beranda/update';
$route[UE_CHANGEPASSWORD] = UE_FOLDER . '/beranda/changepassword';
$route[UE_TRANSACTION] = UE_FOLDER . '/transaction';
$route[UE_TRANSACTIONDETAIL . '/(:any)'] = UE_FOLDER . '/transaction/detail/$1';
$route[UE_SCHEDULE] = UE_FOLDER . '/schedule';
$route[UE_REQTYPE] = UE_FOLDER . '/request/request';
$route[UE_REQSUBTYPE] = UE_FOLDER . '/request/subrequest';
$route[UE_RATINGS] = UE_FOLDER . '/ratings';
$route[UE_QUESTIONS] = UE_FOLDER . '/questions';
$route[UE_COMPLAINT] = UE_FOLDER . '/complaint';
$route[UE_MANAGEFAQ] = UE_FOLDER . '/faqs';
$route[UE_MANAGEFAQ . UE_ADD] = UE_FOLDER . '/faqs/add';
$route[UE_MANAGEFAQ . UE_UPDATE . '/(:num)'] = UE_FOLDER . '/faqs/update/$1';
$route[UE_COMPLAINT . '/pesan/(:any)'] = UE_FOLDER . '/complaint/update/$1';
$route[UE_SCHEDULE . '/pesan/(:any)'] = UE_FOLDER . '/schedule/update/$1';
$route[UE_REPORTTRANSRATE] = UE_FOLDER . '/report/reportTransRate';
$route[UE_REPORTTRANSNONRATE] = UE_FOLDER . '/report/reportTransNonRate';
$route[UE_CONFIGURATION] = UE_FOLDER . '/configuration';
