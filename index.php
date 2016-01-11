<?php

// --------------------------------------------------------------------
// USER CONFIGURABLE SETTINGS.  
// --------------------------------------------------------------------

/**
 *  Paths to various application directories, always include the trailing slash here
 */
	$sites_path 	= 'sites';
	$shared_path 	= 'shared';
	$core_path	 	= 'system/cms';
	$system_path 	= 'system/codeigniter';


// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

	# If you have already installed then delete this
	if ( ! file_exists($core_path.'/config/database.php'))
	{
		// Make sure we've not already tried this
		if (strpos($_SERVER['REQUEST_URI'], 'installer/'))
		{
			header('Status: 404');
			exit('OxygenCMS is missing system/cms/config/database.php and cannot find the installer folder. Does your server have permission to access these files?');
		}
		
		// Otherwise go to installer
		header('Location: '.rtrim($_SERVER['REQUEST_URI'], '/').'/installer/');
		exit;
	}

/*
 *---------------------------------------------------------------
 * OXYGEN-CMS ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     local
 *     staging
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
	define('OXYGEN_DEVELOPMENT', 'development');
	define('OXYGEN_STAGING', 'staging');
	define('OXYGEN_PRODUCTION', 'production');

	define('ENVIRONMENT', (isset($_SERVER['ENVIRONMENT']) ? $_SERVER['ENVIRONMENT'] : OXYGEN_DEVELOPMENT));

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */

	error_reporting(E_ALL);

	switch (ENVIRONMENT)
	{
		case OXYGEN_DEVELOPMENT:
			ini_set('display_errors', true);
		    break;
		case OXYGEN_STAGING:
		case OXYGEN_PRODUCTION:
			ini_set('display_errors', false);
		    break;
		default:
			exit('The environment is not set correctly. ENVIRONMENT = '.ENVIRONMENT.'.');
	}
	
    
/*
|---------------------------------------------------------------
| DEFAULT INI SETTINGS
|---------------------------------------------------------------
|
| Hosts have a habbit of setting stupid settings for various
| things. These settings should help provide maximum compatibility
| for PyroCMS
|
*/

	// Set a include_path for compatibility on some OS'es
	set_include_path(dirname(__FILE__));

	// Some hosts (was it GoDaddy? complained without this
	@ini_set('cgi.fix_pathinfo', 0);
	
	// PHP 5.3 will BITCH without this
	if (ini_get('date.timezone') == '')
	{
		date_default_timezone_set('UTC');
	}



/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */
	if (function_exists('realpath') AND @realpath($system_path) !== FALSE)
	{
		$system_path = realpath($system_path).'/';
	}
	
	// ensure there's a trailing slash
	$system_path = rtrim($system_path, '/').'/';

	// Is the sytsem path correct?
	if ( ! is_dir($system_path))
	{
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */		
	// The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// The PHP file extension
	//define('EXT', '.php');

 	// Path to the system folder
	define('BASEPATH', str_replace("\\", "/", $system_path));

	
	// Path to the front controller (this file)
	define('FCPATH', str_replace(SELF, '', __FILE__));
	
	// Name of the "system folder"
	$parts = explode('/', trim(BASEPATH, '/'));
	define('SYSDIR', end($parts));
	unset($parts);


	// The site slug: (example.com)
	define('SITE_DOMAIN', $_SERVER['HTTP_HOST']);

	// the location where site data is kept
	define('SITE_STORAGE_PATH', str_replace("\\", "/", $sites_path).'/');

	// previously 'ADDON_FOLDER
	define('SHARED_ADDONPATH', str_replace("\\", "/", $shared_path).'/');  

	// The path to the "application" folder (cms)
	define('APPPATH', str_replace("\\", "/", $core_path).'/');


	// Path to the views folder
	define ('VIEWPATH', APPPATH.'views/' );
	
/*
 *---------------------------------------------------------------
 * DEMO
 *---------------------------------------------------------------
 *
 * Should OxygenCMS run as a demo, meaning no destructive actions
 * can be taken such as removing admins or changing passwords?
 *
 */

    define('OXYGEN_DEMO', (file_exists(FCPATH.'DEMO')));

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */
require_once BASEPATH.'core/CodeIgniter.php';

/* End of file index.php */