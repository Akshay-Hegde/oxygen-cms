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
// admin
$route['maintenance/admin/checklist(/:any)?'] = 'checklist$1';
$route['maintenance/admin/product_maintenance(/:any)?'] = 'product_maintenance$1';
$route['maintenance/admin/importer(/:any)?'] = 'importer$1';
$route['maintenance/admin/exporter(/:any)?'] = 'exporter$1';
$route['maintenance/admin/routes(/:any)?'] = 'routes$1';
$route['maintenance/admin(/:any)?']	= 'admin$1';