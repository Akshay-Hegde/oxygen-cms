<?php  defined('BASEPATH') or exit('No direct script access allowed');
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
| 	www.your-site.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://www.codeigniter.com/user_guide/general/routing.html
*/

// public
// admin
$route['forms/admin/entries(/:any)?'] 		= 'admin_entries$1';
$route['forms/admin/admin_fields(/:any)?']	= 'admin_fields$1';
$route['forms/admin/fields(/:any)?']		= 'admin_fields$1';
$route['forms/admin/forms(/:any)?']			= 'admin_forms$1';