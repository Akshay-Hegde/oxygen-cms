<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['maintenance.cache_protected_folders'] 	= ['simplepie', 'cloud_cache'];
$config['maintenance.cannot_remove_folders'] 	= ['codeigniter', 'theme_m'];

// An array of database tables that are eligible to be exported.
$config['maintenance.export_tables'] 			= ['subscribers','subscriptions','users_groups', 'users', 'contact_log', 'files', 'pages', 'blog', 'navigation_links', 'comments','redirects'];