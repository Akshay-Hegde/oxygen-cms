<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX core module class */
require dirname(__FILE__).'/Modules.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter router class.
 *
 * Install this file as application/third_party/MX/Router.php
 *
 * @copyright	Copyright (c) 2011 Wiredesignz
 * @version 	5.4
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Router extends CI_Router
{
	private $module;

	static $is_multisite;

	static $active_site;	

	public function __construct() {
		if(!isset(self::$active_site))
		{
			$this->run_siter();
		}
		parent::__construct();
	}


	public function fetch_module() {
		return $this->module;
	}
	
	public function _validate_request($segments) {

		if (count($segments) == 0) return $segments;
		
		/* locate module controller */
		if ($located = $this->locate($segments)) return $located;
		
		/* use a default 404_override controller */
		if (isset($this->routes['404_override']) and $this->routes['404_override']) {
			$segments = explode('/', $this->routes['404_override']);
			if ($located = $this->locate($segments)) return $located;
		}
		
		/* no controller found */
		show_404();
	}
	
	/** Locate the controller **/
	public function locate($segments) {		

		//Defaults for site status
		$_site_status = true;
		$_site_status_message = 'Active';
		$_site_throttle = 0;

		/**
		 * Load the site ref for multi-site support if the "sites" module exists
		 * and the multi-site constants haven't been defined already (hmvc request)
		 */
		if (self::$is_multisite and ! defined('SITE_REF'))
		{
			require_once BASEPATH.'database/DB.php';
			
			//$site = self::$active_site; 
			self::$active_site = DB()->where('site.domain', SITE_DOMAIN)->get('$_sites site')->row();
			

			// The site ref. Used for building site specific paths
			define('SITE_REF', self::$active_site->ref);
			
			// 
			// Is site disabled ?
			//
			if (isset(self::$active_site->active) and ! self::$active_site->active)
			{
				$_site_status = false;
				$_site_status_message = 'This site has been disabled by a super-administrator';								
			}


			// If this domain is an alias and it is a redirect
			if (self::$active_site and self::$active_site->domain !== null and self::$active_site->type === 'redirect' and str_replace(array('http://', 'https://'), '', trim(strtolower(BASE_URL), '/')) !== self::$active_site->domain)
			{
				$protocol = ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
					? 'https' : 'http';

				// Send them off to the original domain
				header("Location: {$protocol}://{self::$active_site->domain}{$_SERVER['REQUEST_URI']}");
				exit;
			}
			
			// Use the correct table session name, instead of deafult_session_log replace `default_` with `site_slug_`)
			$this->config->set_item('sess_table_name', self::$active_site->ref.'_'.str_replace('default_', '', config_item('sess_table_name')));

		}

		// Define the status for later use
		defined('SITE_STATUS') or define('SITE_STATUS', $_site_status);
		defined('SITE_STATUS_MESSAGE') or define('SITE_STATUS_MESSAGE', $_site_status_message);
		defined('SITE_THROTTLE') or define('SITE_THROTTLE', self::$active_site->throttle);				

		// we aren't running the Multi-Site Manager so define the defaults
		if ( ! defined('SITE_REF'))
		{
			// The site ref. Used for building site specific paths
			define('SITE_REF', 'default');
		}

		// Path to uploaded files for this site
		// defines: sites/<default>/
		defined('SITE_DIR') OR define('SITE_DIR', SITE_STORAGE_PATH.SITE_REF.'/');
				
		// Path to the addon folder for this site
		defined('ADDONPATH') or define('ADDONPATH', SITE_STORAGE_PATH.SITE_REF.'/addons/');


		// update the config paths with the site specific paths
		self::update_module_locations(SITE_REF);
	
		$this->module = '';
		$this->directory = '';
		$ext = $this->config->item('controller_suffix').'.php';
		
		/* use module route if available */
		if (isset($segments[0]) and $routes = Modules::parse_routes($segments[0], implode('/', $segments))) 	
		{
			$segments = $routes;
		}
		
	
		/* get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, null);

		/* check modules */
		foreach (Modules::$locations as $location => $offset) {
		
			/* module exists? */
			if (is_dir($source = $location.$module.'/controllers/')) {
				
				$this->module = $module;
				$this->directory = $offset.$module.'/controllers/';
				
				/* module sub-controller exists? */
				if ($directory and is_file($source.$directory.$ext)) {
					return array_slice($segments, 1);
				}
					
				/* module sub-directory exists? */
				if ($directory and is_dir($source.$directory.'/')) {

					$source = $source.$directory.'/';
					$this->directory .= $directory.'/';

					/* module sub-directory controller exists? */
					if(is_file($source.$directory.$ext)) {
						return array_slice($segments, 1);
					}
				
					/* module sub-directory sub-controller exists? */
					if ($controller and is_file($source.$controller.$ext))	{
						return array_slice($segments, 2);
					}
				}
				
				/* module controller exists? */			
				if(is_file($source.$module.$ext)) {
					return $segments;
				}
			}			
		}

  		
		/* application controller exists? */			
		if (is_file(APPPATH.'controllers/'.$module.$ext)) {
			return $segments;
		}
		
		/* application sub-directory controller exists? */
		if ($directory and is_file(APPPATH.'controllers/'.$module.'/'.$directory.$ext)) {
			$this->directory = $module.'/';
			return array_slice($segments, 1);
		}
		
		/* application sub-directory default controller exists? */
		if (is_file(APPPATH.'controllers/'.$module.'/'.$this->default_controller.$ext)) {
			$this->directory = $module.'/';
			return array($this->default_controller);
		}
	}

	public function set_class($class) {
		$this->class = $class.$this->config->item('controller_suffix');
	}

	private function is_multisite()
	{
		//if(CMS_EDITION === 'Enterprise')
		$msm_path = SITE_STORAGE_PATH.'default/addons/modules/sites/';
		if (is_dir($msm_path))
		{
			return $msm_path;
		}
		return false;
	}

	private function update_module_locations($site_ref)
	{
		$locations = [];

		foreach (config_item('modules_locations') AS $location => $offset)
		{
			$locations[str_replace('__SITE_REF__', $site_ref, $location)] = str_replace('__SITE_REF__', $site_ref, $offset);
		}

		Modules::$locations = $locations;
	}

	public function _set_routing()
	{
		// Are query strings enabled in the config file? Normally CI doesn't utilize query strings
		// since URI segments are more search-engine friendly, but they can optionally be used.
		// If this feature is enabled, we will gather the directory/class/method a little differently
		$segments = array();
		if ($this->config->item('enable_query_strings') === TRUE && isset($_GET[$this->config->item('controller_trigger')]))
		{
			if (isset($_GET[$this->config->item('directory_trigger')]))
			{
				$this->set_directory(trim($this->uri->_filter_uri($_GET[$this->config->item('directory_trigger')])));
				$segments[] = $this->fetch_directory();
			}

			if (isset($_GET[$this->config->item('controller_trigger')]))
			{
				$this->set_class(trim($this->uri->_filter_uri($_GET[$this->config->item('controller_trigger')])));
				$segments[] = $this->fetch_class();
			}

			if (isset($_GET[$this->config->item('function_trigger')]))
			{
				$this->set_method(trim($this->uri->_filter_uri($_GET[$this->config->item('function_trigger')])));
				$segments[] = $this->fetch_method();
			}
		}

		// Load the routes.php file.
		if (defined('ENVIRONMENT') && is_file(APPPATH.'config/'.ENVIRONMENT.'/routes.php'))
		{
			include(APPPATH.'config/'.ENVIRONMENT.'/routes.php');
		}
		elseif (is_file(APPPATH.'config/routes.php'))
		{
			include(APPPATH.'config/routes.php');
		}
		if(self::$active_site)
		{
			// find the dir
			$dir = SITE_STORAGE_PATH.self::$active_site->ref.'/config/';

			// Load the specifc site routes
			if (is_file($dir.'routes.php'))
			{
				include_once($dir.'routes.php');
			}	

		}

		$this->routes = ( ! isset($route) OR ! is_array($route)) ? array() : $route;
		unset($route);

			
		// Set the default controller so we can display it in the event
		// the URI doesn't correlated to a valid controller.
		$this->default_controller = empty($this->routes['default_controller']) ? FALSE : strtolower($this->routes['default_controller']);

		// Were there any query string segments? If so, we'll validate them and bail out since we're done.
		if (count($segments) > 0)
		{
			return $this->_validate_request($segments);
		}

		// Fetch the complete URI string
		$this->uri->_fetch_uri_string();

		// Is there a URI string? If not, the default controller specified in the "routes" file will be shown.
		if ($this->uri->uri_string == '')
		{
			return $this->_set_default_controller();
		}

		$this->uri->_remove_url_suffix(); // Remove the URL suffix
		$this->uri->_explode_segments(); // Compile the segments into an array
		$this->_parse_routes(); // Parse any custom routing that may exist
		$this->uri->_reindex_segments(); // Re-index the segment array so that it starts with 1 rather than 0
	}	

	/**
	 * Should only run once
	 */
	private function run_siter()
	{
		self::$active_site = new stdClass();
		self::$active_site->ref = 'default';
		//do not throttle default site
		self::$active_site->throttle = 0;
		self::$active_site->active = 1;		

		if (self::is_multisite())
		{
			self::$is_multisite = true;
		}
		else
		{
			//else
			self::$is_multisite = false;
		}
	}


}
