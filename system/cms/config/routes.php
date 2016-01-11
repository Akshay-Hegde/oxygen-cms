<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


/*
 * Core routes for OxygenCMS
 */

$route['default_controller'] = 'pages';
$route['404_override'] = 'pages';
$route['admin/help/([a-zA-Z0-9_-]+)'] = 'admin/help/$1';
$route['admin/([a-zA-Z0-9_-]+)/(:any)'] = '$1/admin/$2';
$route['admin/(login|logout|remove_installer_directory)'] = 'admin/$1';
$route['admin/([a-zA-Z0-9_-]+)'] = '$1/admin/index';
$route['api/ajax/(:any)'] = 'api/ajax/$1';
$route['api/([a-zA-Z0-9_-]+)/(:any)'] = '$1/api/$2';
$route['api/([a-zA-Z0-9_-]+)'] = '$1/api/index';
/* End of file routes.php */