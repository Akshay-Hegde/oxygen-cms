<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * Code here is run before ALL controllers
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 * @package 	PyroCMS\Core\Controllers
 *
 */
require APPPATH."libraries/MX/Controller.php";

class MY_Controller extends MX_Controller
{

	/**
	 * The name of the module that this controller instance actually belongs to.
	 *
	 * @var string 
	 */
	public $module;

	/**
	 * The name of the controller class for the current class instance.
	 *
	 * @var string
	 */
	public $controller;

	/**
	 * The name of the method for the current request.
	 *
	 * @var string 
	 */
	public $method;

	/**
	 * Load and set data for some common used libraries.
	 */
	public function __construct()
	{
		parent::__construct();

		//$this->output->enable_profiler(TRUE);

		$this->benchmark->mark('my_controller_start');

		// Default fallback lang
		$site_lang = 'en';


		// No record? Probably DNS'ed but not added to multisite
		if ( ! defined('SITE_REF'))
		{
			show_error('This domain is not set up correctly. Please go to '.anchor('sites') .' and log in to add this site.');
		}
		
		//
		// Check if the site is active or not
		//
		if(SITE_STATUS == false) exit(SITE_STATUS_MESSAGE);

		//Slow down the connection
		(SITE_THROTTLE === 0) or $this->throttle();

		// By changing the prefix we are essentially "namespacing" each site
		$this->db->set_dbprefix(SITE_REF.'_');

		// Load the cache library now that we know the siteref
		$this->load->library('oxycache');

		// Add the site specific theme folder
		//$this->template->add_theme_location(SITE_DIR.'addons/themes/');
		$this->template->add_theme_location(ADDONPATH.'themes/');

		// Migration logic helps to make sure OxygenCMS is running the latest changes
		$this->load->library('migration');
		
		if ( ! ($schema_version = $this->migration->current()))
		{
			show_error($this->migration->error_string());
		}
		// Result of schema version migration
		elseif (is_numeric($schema_version))
		{
			log_message('debug', 'OxygenCMS was migrated to version: ' . $schema_version);
		}

		// With that done, load settings
		$this->load->library(array('session', 'settings/settings'));

		// Lock front-end language
		if ( ! (is_a($this, 'Admin_Controller') and ($site_lang = AUTO_LANGUAGE)))
		{
			$site_public_lang = explode(',', Settings::get('site_public_lang'));

			if (in_array(AUTO_LANGUAGE, $site_public_lang))
			{
				$site_lang = AUTO_LANGUAGE;
			}
			else
			{
				$site_lang = Settings::get('site_lang');
			}
		}


		// What language us being used
		defined('CURRENT_LANGUAGE') or define('CURRENT_LANGUAGE', $site_lang);

		$langs = $this->config->item('supported_languages');


		$oxyvars=[];
		$oxyvars['lang'] = $langs[CURRENT_LANGUAGE];
		$oxyvars['lang']['code'] = CURRENT_LANGUAGE;

		$this->load->vars($oxyvars);

		// Set php locale time
		if (isset($langs[CURRENT_LANGUAGE]['codes']) and sizeof($locale = (array) $langs[CURRENT_LANGUAGE]['codes']) > 1)
		{
			array_unshift($locale, LC_TIME);
			call_user_func_array('setlocale', $locale);
			unset($locale);
		}

		// Reload languages
		if (AUTO_LANGUAGE !== CURRENT_LANGUAGE)
		{
			$this->config->set_item('language', $langs[CURRENT_LANGUAGE]['folder']);
			$this->lang->is_loaded = [];
			$this->lang->load( ['errors', 'global', 'users/user', 'settings/settings', 'files/files'] );
		}
		else
		{
			$this->lang->load( ['global', 'users/user', 'files/files'] );
		}

		$this->load->library('users/ion_auth');

		// Use this to define hooks with a nicer syntax
		get_instance()->hooks =& $GLOBALS['EXT'];

		// Get user data
		$this->template->current_user = get_instance()->current_user = $this->current_user = $this->ion_auth->get_user();


		// Work out module, controller and method and make them accessable throught the CI instance
		get_instance()->module = $this->module = $this->router->fetch_module();
		get_instance()->controller = $this->controller = $this->router->fetch_class();
		get_instance()->method = $this->method = $this->router->fetch_method();
		

		// Loaded after $this->current_user is set so that data can be used everywhere
		$this->load->model(
			[
				'permissions/permission_m',
				'addons/module_m',
				'addons/theme_m',
				'pages/page_m',
			]
		);

		// List available module permissions for this user
		get_instance()->permissions = $this->permissions = $this->current_user ? $this->permission_m->get_group($this->current_user->group_id) : [];


		//also get the permissions of the user if they are logged in
		if($this->current_user) {
			$_p = $this->permission_m->get_user($this->current_user->id);
			get_instance()->permissions = $this->permissions =  array_merge($this->permissions,$_p);
			unset($_p);
		}


		// load all modules (the Events library uses them all) and make their details widely available
		// disabled for now until cache is sorted out, but definitly a benifit if we can cache this
		if (false === true AND get_instance()->enabled_modules = $this->oxycache->get('info'.DIRECTORY_SEPARATOR.'enabled_modules'))
		{
			$this->enabled_modules = get_instance()->enabled_modules;
		}
		else
		{
			$this->enabled_modules = get_instance()->enabled_modules = $this->module_m->get_all();
			$this->oxycache->write($this->enabled_modules, 'info'.DIRECTORY_SEPARATOR.'enabled_modules',0);
		}

		// now that we have a list of enabled modules, we can load events.
		// do not load events without having the modules.
		$this->load->library('events');
		
		// search is a similar system but kept seperate 
		// from the events system for more specific usage
		// onlyenable search if admin has allowed on system
		if(Settings::get('search_enabled')) {
			$this->load->library('search');
		}

		// set defaults
		$this->template->module_details = get_instance()->module_details = $this->module_details = false;

		// now pick our current module out of the enabled modules array
		foreach (get_instance()->enabled_modules as $module)
		{
			if ($module['slug'] === $this->module)
			{
				// Set meta data for the module to be accessible system wide
				$this->template->module_details = get_instance()->module_details = $this->module_details = $module;
				break;
			}
		}

		// certain places (such as the Dashboard) we aren't running a module, provide defaults
		if ( ! $this->module)
		{
			$this->module_details = 
			[
				'name' => null,
				'slug' => null,
				'version' => null,
				'description' => null,
				'clean_xss' => null,
				'is_frontend' => null,
				'is_backend' => null,
				'menu' => false,
				'enabled' => 1,
				'sections' => [],
				'shortcuts' => [],
				'is_core' => null,
				'is_current' => null,
				'current_version' => null,
				'updated_on' => null,
				'icon' => 'fa fa-dashboard',
			];
		}

		// If the module is disabled, then show a 404.
		empty($this->module_details['enabled']) AND show_404();

		if ( $this->module_details['clean_xss'])
		{
			$_POST = $this->security->xss_clean($_POST);
		}

		//add a temp path to the module location for assets,views ect.
		if ($this->module and isset($this->module_details['path']))
		{
			Asset::add_path('module', $this->module_details['path'].'/');
		}

		// Add the scripts path, this is used for all sites inc admin
		// a common share repository of code
		Asset::add_path('scripts', SHARED_ADDONPATH.'scripts/');	


		// Load the notifications library
		$this->load->library('notifications/notifications');


	    // check and update current user
	    // refactor this into users lib
	    if (isset($this->current_user->id))
	    {
	    	//$five_minutes_ago = strtotime("-5 minutes");
			$this->db->where('id',$this->current_user->id)->update('users',['io_stamp'=>time()]);
	    }

		// Enable profiler on local box
	    if ((isset($this->current_user->group) and ($this->current_user->group === 'admin') and is_array($_GET) and array_key_exists('_debug', $_GET)))
	    {
			unset($_GET['_debug']);
	    	$this->output->enable_profiler(true);
	    }

		$this->benchmark->mark('my_controller_end');
	}


	/**
	 * Should we throttle back a site? has a client not paid their bill!
	 */
	private function throttle()
	{
		//return; //not available in std edition
		//only if speed is > 0, where 0 doesnt go anywehere!
		if($speed = (int) SITE_THROTTLE)
		{	
			if($speed <5) return;
			$speed = ($speed>100)?100:$speed;

			//update the timeout limit on php so we dont timeout
			if ($speed>30) set_time_limit($speed);
			
			sleep($speed);	
		}
	}
}