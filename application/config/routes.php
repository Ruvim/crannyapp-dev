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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'adminuser';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* for admin panel - starts */
// Login
$route['admin'] = 'adminuser/index';
$route['admin/login'] = 'adminuser/index';
$route['admin/googlelogin'] = 'adminuser/googleLoginSubmit';
$route['admin/logout'] = 'adminuser/logout';
$route['admin/login/validate'] = 'adminuser/validateCredentials';
$route['admin/dashboard'] = 'adminuser/dashboard';
$route['admin/forgot'] = 'adminuser/forgot';
$route['admin/forgot/validate'] = 'adminuser/forgot_validateCredentials';

// Admin User Manage
$route['admin/adminuser'] = 'adminuser/index';
$route['admin/adminuser/pagesize/(.+)'] = 'adminuser/index/pagesize/$1'; // for paging
$route['admin/adminuser/add'] = 'adminuser/add';
$route['admin/adminuser/update'] = 'adminuser/update';
$route['admin/adminuser/update/(.+)'] = 'adminuser/update/$1';
$route['admin/adminuser/changestatus'] = 'adminuser/changestatus';
$route['admin/adminuser/chagepagesize'] = 'adminuser/chagepagesize';
$route['admin/adminuser/previewChanges'] = 'adminuser/previewChanges';
$route['admin/adminuser/delete'] = 'adminuser/delete'; 
$route['admin/adminuser/deleteimage'] = 'adminuser/deleteimage'; 
$route['admin/adminuser/deleteSelected'] = 'adminuser/deleteSelected';
$route['admin/adminuser/exportToexcel'] = 'adminuser/exportToexcel';  /// For Export
$route['admin/adminuser/(.+)'] = 'adminuser/index/$1'; 

// Setting
$route['admin/settings'] = 'settings/index';
$route['admin/settings/update'] = 'settings/update';

// Image module
$route['admin/image'] = 'image/index';
$route['admin/image/add'] = 'image/add';
$route['admin/image/update'] = 'image/update';
$route['admin/image/update/(.+)'] = 'image/update/$1';
$route['admin/image/pagesize/(.+)'] = 'image/index/pagesize/$1'; // for paging
$route['admin/image/changestatus'] = 'image/changestatus';
$route['admin/image/changeallstatus'] = 'image/changeallstatus'; // for selected
$route['admin/image/chagepagesize'] = 'image/chagepagesize';
$route['admin/image/delete'] = 'image/delete';
$route['admin/image/deleteimage'] = 'image/deleteimage'; 
$route['admin/image/deleteSelected'] = 'image/deleteSelected';
$route['admin/image/exportToexcel'] = 'image/exportToexcel';  /// For Export
$route['admin/image/(.+)'] = 'image/index/$1';


/* for admin panel - ends */

//GetLog
$route['log'] = 'logs/getlogs';
$route['log/clearlog'] = 'logs/clearlog';

