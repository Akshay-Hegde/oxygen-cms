<?php  defined('BASEPATH') or exit('No direct script access allowed');
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
 * PyroCMS Theme Definition
 *
 * This class should be extended to allow for theme management.
 *
 * @author		Stephen Cozart
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Libraries
 * @abstract
 */
class Theme
{
	
	/**
	 * @var theme name
	 */
	public $name;

	/**
	 * @var author name
	 */
	public $author;

	/**
	 * @var authors website
	 */
	public $author_website;

	/**
	 * @var theme website
	 */
	public $website;

	/**
	 * @var theme description
	 */
	public $description;

	/**
	 * @var The version of the theme.
	 */
	public $version;
	
	/**
	 * @var Front-end or back-end.
	 */
	public $type;
	
	/**
	 * @var Designer defined options.
	 */
	public $options;


	/**
	 * @var The array of widget areas. This is so widgets can be 
	 * applied by area. if not set. Then widgets can only be applied by name/instance id.
	 */
	public $widget_areas;
	
	
	/**
	 * __get
	 *
	 * Allows this class and classes that extend this to use $this-> just like
	 * you were in a controller.
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->{$var};
	}

	/**
	 * Called everytime the theme is displayed
	 */
	public function run() {}


	public function tag($key,$value)
	{
		get_instance()->template->set($key,$value);
	}
}
/* End of file Theme.php */