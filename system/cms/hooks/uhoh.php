<?php defined('BASEPATH') OR exit('No direct script access allowed.');
/**
 * OxygenCMS
 *
 * CodeIgniter UhOh!
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 * This is an extension on CI_Extensions that provides awesome error messages
 * with full backtraces and a view of the line with the error.  It is based
 * on Kohana v3 Error Handling.
 *
 * @package		CodeIgniter
 * @author		Dan Horrigan <http://dhorrigan.com>
 * @license		Apache License v2.0
 * @version		1.0
 */
/**
 * Load Exceptions
 *
 * Simply loads the Exception class
 */
function load_exceptions()
{
	// Due to a weird bug I have to get the absolute paths here -- Dan
	define('ABS_APPPATH', realpath(APPPATH) . '/');
	define('ABS_SYSDIR', realpath(SYSDIR) . '/');
	load_class('Exceptions', 'core');
}