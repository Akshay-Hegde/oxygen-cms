<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Supported Languages
|--------------------------------------------------------------------------
|
| Contains all languages your site will store data in. Other languages can
| still be displayed via language files, thats totally different.
|
| Check for HTML equivilents for characters such as � with the URL below:
|    http://htmlhelp.com/reference/html40/entities/latin1.html
|
|
|    array('en'=> 'English', 'fr'=> 'French', 'de'=> 'German')
|
*/
$config['supported_languages'] = 
[
    'en' => 
    [
        'name'        	=> 'English',
        'folder'    	=> 'english',
        'direction'    	=> 'ltr',
        'codes'        	=> ['en', 'english', 'en_US'],
        'ckeditor'    	=> null
    ],
    'it' => 
    [
        'name'        	=> 'Italian',
        'folder'    	=> 'italian',
        'direction'    	=> 'ltr',
        'codes'        	=> ['it', 'italian', 'it_EU'],
        'ckeditor'    	=> null
    ],    
];

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| If no language is specified, which one to use? Must be in the array above
|
|    en
|
*/
$config['default_language'] = 'en';

/*
|--------------------------------------------------------------------------
| Detect language using Accept-Language
|--------------------------------------------------------------------------
|
| Whether or not to take into account the Accept-Language client header
|
| Only turn it on for admin panel:
| 	$config['check_http_accept_language'] = (bool) preg_match('@\/admin(\/.+)?$@', $_SERVER['REQUEST_URI']);
|
*/
$config['check_http_accept_language'] = TRUE;
