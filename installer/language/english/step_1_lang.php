<?php defined('BASEPATH') or exit('No direct script access allowed');

// labels
$lang['header']			=	'Step 1: Configure Database and Server';
$lang['intro_text']		=	'OxygenCMS is very easy to install and should only take a few minutes, but there are a few questions that may appear confusing if you do not have a technical background. If at any point you get stuck please ask your web hosting provider or <a href="http://www.oxygen-cms.com/contact" target="_blank">contact us</a> for support.';

$lang['db_settings']	=	'Database Settings';
$lang['db_text']		=	'OxygenCMS requires a database (MySQL) to store all of your content and settings, so the first thing we will do is establish a connection to an existing database or create a new one if the box below is checked. If you do not understand what you are being asked to enter please ask your web hosting provider or server administrator for the details. <br><br>If you type the name of an existing database its data will be overwritten!';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.';
$lang['db_create']		=	'Create Database';
$lang['db_notice']		=	'You might need to do this yourself via your hosting control panel';
$lang['database']		=	'MySQL Database';

$lang['server']			=	'MySQL Hostname';
$lang['username']		=	'MySQL Username';
$lang['password']		=	'MySQL Password';
$lang['portnr']			=	'MySQL Port';
$lang['server_settings']=	'Server Settings';
$lang['httpserver']		=	'HTTP Server';

$lang['httpserver_text']=	'If you do not know what any of this means just ignore it and carry on with the installation.';
$lang['rewrite_fail']	=	'You have selected "(Apache with mod_rewrite)" but we are unable to tell if mod_rewrite is enabled on your server. Ask your host if mod_rewrite is enabled or simply install at your own risk.';
$lang['mod_rewrite']	=	'You have selected "(Apache with mod_rewrite)" but your server does not have the rewrite module enabled. Ask your host to enable it or install OxygenCMS using the "Apache (without mod_rewrite)" option.';
$lang['step2']			=	'Step 2';

// messages
$lang['db_success']		=	'The database settings have been tested and are working correctly.';
$lang['db_failure']		=	'Problem connecting to or creating the database: ';

/* End of file step_1_lang.php */
