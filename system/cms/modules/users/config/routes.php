<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// Admin Routes
$route['users/admin/fields(/:any)?']		= 'admin_fields$1';
$route['users/admin/adminprofile(/:any)?']		= 'admin_adminprofile$1';
$route['users/admin/timeline(/:any)?']		= 'admin_timeline/index$1';
