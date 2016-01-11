<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 */
/**
 * Search
 *
 * A simple search system for OxygenCMS.
 *
 * @version		1.0
 * @author		Dan Horrigan <http://dhorrigan.com>
 * @author		Eric Barnes <http://ericlbarnes.com>
 * @license		Apache License v2.0
 * @copyright	2010 Dan Horrigan
 * @package		PyroCMS\Core\Libraries
 */
class Search
{
	/**
	 * An array of listeners
	 * 
	 * @var	array
	 */
	protected static $_listeners = [];

	/**
	 * Constructor
	 * 
	 * Load up the modules. 
	 */
	public function __construct()
	{
		self::_load_modules();
	}

	/**
	 * Load Modules
	 *
	 * Loads all active modules
	 */
	private static function _load_modules()
	{
		$_ci = get_instance();

		$is_core = true;

		$_ci->load->model('addons/module_m');

		if ( ! $results = $_ci->enabled_modules)
		{
			return false;
		}

		foreach ($results as $row)
		{
			// This does not have a valid Details.php file! :o
			if (!$details_class = self::_spawn_class($row['slug'], $row['is_core']))
			{
				continue;
			}
		}

		return true;
	}

	/**
	 * Spawn Class
	 *
	 * Checks to see if a Search.php exists and returns a class
	 * 
	 * @param string $slug The folder name of the module.
	 * @param boolean $is_core Whether the module is a core module.
	 * @return object|boolean 
	 */
	private static function _spawn_class($slug, $is_core = false)
	{
		$path = $is_core ? APPPATH : ADDONPATH;

		// Before we can install anything we need to know some details about the module
		$search_file = $path.'modules/'.$slug.'/Search.php';

		// Check the details file exists
		if (!is_file($search_file))
		{
			$search_file = SHARED_ADDONPATH.'modules/'.$slug.'/Search.php';

			if (!is_file($search_file))
			{
				return false;
			}
		}

		// Sweet, include the file
		include_once $search_file;

		// Now call the details class
		$class = 'Search_'.ucfirst(strtolower($slug));

		// Now we need to talk to it
		return class_exists($class) ? new $class : false;
	}

	/**
	 * Register
	 *
	 * Registers a Callback for a given event
	 *
	 * @param string $event The name of the event.
	 * @param array $callback The callback for the event.
	 */
	public static function register($event, array $callback)
	{
		$key = get_class($callback[0]).'::'.$callback[1];
		self::$_listeners[$event][$key] = $callback;
		log_message('debug', 'Search::register() - Registered "'.$key.' with event "'.$event.'"');
	}

	/**
	 * Triggers an event and returns the results.
	 * 
	 *
	 * @param string $event The name of the event
	 * @param string $terms Any data that is to be passed to the listener
	 * @return string|array The return of the listeners, in the return type
	 */
	public static function trigger($event, $terms = '')
	{
		log_message('debug', 'Search::trigger() - Triggering event "'.$event.'"');

		$calls = [];

		if (self::has_listeners($event)) 
		{
			foreach (self::$_listeners[$event] as $listener) 
			{
				if (is_callable($listener)) 
				{
					$calls[] = call_user_func($listener, $terms, $event);
				}
			}
		}

		if (self::has_listeners('*')) 
		{
			foreach (self::$_listeners['*'] as $listener) 
			{
				if (is_callable($listener)) 
				{
					$calls[] = call_user_func($listener, $terms, $event);
				}
			}
		}


		//
		// format the return
		//
    	$ret_array = [];

    	foreach($calls as $key=>$r)
    	{
			if($r['total-results'] > 0)
			{
				$ret_array = array_merge($ret_array,$r['results']);
			}
    	}

    	unset($calls);

    	return $ret_array;

	}


	/**
	 *
	 * @access	public
	 * @param	string	
	 * @return	bool	
	 */

	/**
	 * Checks if the event has listeners
	 *
	 * @param string $event The name of the event
	 * @return boolean Whether the event has listeners
	 */
	public static function has_listeners($event)
	{
		log_message('debug', 'Search::has_listeners() - Checking if event "'.$event.'" has listeners.');

		if (isset(self::$_listeners[$event]) and count(self::$_listeners[$event]) > 0)
		{
			return true;
		}

		return false;
	}

}