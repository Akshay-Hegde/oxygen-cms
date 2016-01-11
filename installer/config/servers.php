<?php
/*
|--------------------------------------------------------------------------
| Supported servers
|--------------------------------------------------------------------------
|
| An array that contains a list of servers supported by OxygenCMS.
|
*/

$config['supported_servers'] = [

	'apache_w' => [
		'name' => 'Apache (with mod_rewrite)',
		'rewrite_support' => TRUE
	],
	'apache_wo' => [
		'name' => 'Apache (without mod_rewrite)',
		'rewrite_support' => FALSE
	],
	'abyss' => [
		'name' => 'Abyss Web Server X1/X2',
		'rewrite_support' => FALSE
	],
	'cherokee' => [
		'name' => 'Cherokee Web Server 0.99.x',
		'rewrite_support' => FALSE
	],
	'uniform' => [
		'name' => 'Uniform Server 4.x/5.x',
		'rewrite_support' => FALSE
	],
	'zend' => [
		'name' => 'Zend Server',
		'rewrite_support' => TRUE
	],
	'other'	=> [
		'name' => 'Other',
		'rewrite_support' => FALSE
	]
];