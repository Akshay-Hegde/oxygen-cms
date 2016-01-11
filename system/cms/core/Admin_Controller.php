<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * This is the basis for the Admin class that is used throughout PyroCMS.
 * 
 * Code here is run before admin controllers
 *
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 * @package OxygenCMS\Core\Controllers
 *
 */
class Admin_Controller extends MY_Controller {

	/**
	 * Admin controller section, normally an arbitrary string
	 *
	 * @var string 
	 */
	protected $section = null;


	/**
	 * Load language, check flashdata, define https, load and setup the data 
	 * for the admin theme
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the Language files ready for output
		$this->lang->load('admin');
		$this->lang->load('buttons');
		$this->load->helper('users/user');
		$this->load->helper('admin_theme');

		// Show error and exit if the user does not have sufficient permissions
		if ( ! self::_check_access())
		{
			$this->session->set_flashdata('error', lang('cp:access_denied'));
			redirect();
		}

		// If the setting is enabled redirect request to HTTPS
		if ($this->settings->admin_force_https and strtolower(substr(current_url(), 4, 1)) != 's')
		{
			redirect(str_replace('http:', 'https:', current_url()).'?session='.session_id());
		}

		get_instance()->admin_theme = $this->theme_m->get_admin();
		
		// Check to see if admin_theme has been set with a empty slug
		if (empty($this->admin_theme->slug))
		{
			show_error('This site has been set to use an admin theme that does not exist.');
		}

		// make a constant as this is used in a lot of places
		defined('ADMIN_THEME') or define('ADMIN_THEME', $this->admin_theme->slug);
			
		// Set the location of assets
		Asset::add_path('theme', $this->admin_theme->web_path.'/');
		Asset::set_path('theme');
		
		// grab the theme options if there are any
		get_instance()->theme_options = $this->oxycache->model('theme_m', 'get_values_by', [['theme' => ADMIN_THEME]]);
	
		// Active Admin Section (might be null, but who cares)
		$this->template->active_section = $this->section;
		
		
		// -------------------------------------
		// Build Admin Navigation
		// -------------------------------------
		// We'll get all of the backend modules
		// from the DB and run their module items.
		// -------------------------------------
		if (is_logged_in())
		{
			//
			// Lets see if this user has a cahced menu handy, if so
			// we can simply de-serialize it rather than build the menu
			//

			// if($menu = $this->get_cached_menu($this->current_user->id)) {
			//
			//    $this->template->cms_menu_items = unserialize($menu);
			//
			// }

			// first load the menu model
			//$this->load->model('maintenance/menu_m');

			// check if menu cahe exist
			//$cache_menu_name = $this->menu_m->generate_name($this->current_user->id,'admin');

			//if (false === true AND $this->template->cms_menu_items = $this->oxycache->get($cache_menu_name))
			//{ 
				//now this saves plenty of queries and calls
			//}
			//else
			{
				// Here's our menu array.
				$menu_items = [];
				$new_menu_items = [];

				// This array controls the order of the admin items. A few empty strings to offset the index
				$this->template->menu_order = [ '','','lang:cp:nav_pages','lang:cp:nav_content', 'Email', 'lang:cp:nav_users', 'lang:cp:nav_system',  'lang:global:profile'];

				// Set some group icons for the default paren levels
				//move the icons into lang files or at least out of the php files
				$menu_items['lang:cp:nav_users']['icon'] = 'fa fa-user';
				$menu_items['lang:cp:nav_content']['icon'] = 'fa fa-th';
				$menu_items['lang:cp:nav_system']['icon'] = 'fa fa-laptop';

				$modules = $this->module_m->where('installed',1)->get_all(
					[
						'is_backend' => true,
						'group' => $this->current_user->group,
						'lang' => CURRENT_LANGUAGE,
					]
				);

				foreach ($modules as $module)
				{		
					if ((isset($this->permissions[$module['slug']]) or $this->current_user->group == 'admin' )):		
						// If we do not have an admin_menu function, we use the
						// regular way of checking out the Details.php data.
						if ($module['menu'])
						{

							$menu_items['lang:cp:nav_'.$module['menu']]['menu_items'][] = 
							[
								'name' 			=> $module['name'],
								'uri' 			=> 'admin/'.$module['slug'],
								'icon' 			=> (isset($module['icon'])) ? $module['icon'] :'fa fa-edit' ,
								'permission' 	=> '',
							];

						}
						
						if (method_exists($module['module'], 'admin_menu'))
						{
							$module['module']->admin_menu($menu_items);
						}
					
					endif;
				}

				// Order the menu items. We go by our menu_order array.
				$this->template->cms_menu_items = $this->navigation_links( $menu_items );

				//$this->menu_m->store_menu($this->current_user->id,'admin', $this->template->cms_menu_items);
			}
		}

		/**
		 * Allow all admin controllers to access the timeline Object
		 */
		$this->timeline = new \Oxygen\Loggers\Timeline();

		Events::trigger('admin_controller');


		// Template configuration
		// set_layout is always set to default, 
		// can be overriden by each controller
		$this->template
			->enable_parser(false)
			->set('theme_options', $this->theme_options)
			->set_theme(ADMIN_THEME)
			->set_layout('default', 'admin');

		// trigger the run() method in the selected admin theme
		$class = 'Theme_'.ucfirst($this->admin_theme->slug);
		call_user_func([new $class, 'run']);
	}

	/**
	 * Order the system navigation links
	 */
	private function navigation_links( & $menu_items ) {

		$ordered_menu = [];

		foreach ($this->template->menu_order as $order => $menu)
		{
			if (isset($menu_items[$menu]))
			{
				$ordered_menu[lang_label($menu)] = $menu_items[$menu];
				unset($menu_items[$menu]);
			}
		}

		// Any stragglers?
		if ($menu_items)
		{
			$translated_menu_items = [];

			// translate any additional top level menu keys so the array_merge works
			foreach ($menu_items as $key => $menu_item)
			{
				$translated_menu_items[lang_label($key)] = $menu_item;
			}

			$ordered_menu = array_merge_recursive($ordered_menu, $translated_menu_items);
		}

		return $ordered_menu;
	}


	/**
	 * Checks to see if a user object has access rights to the admin area.
	 *
	 * @return boolean 
	 */
	private function _check_access()
	{

		// These pages get past permission checks
		$ignored_pages = array('admin/login', 'admin/logout', 'admin/help');

		// Check if the current page is to be ignored
		$current_page = $this->uri->segment(1, '') . '/' . $this->uri->segment(2, 'index');

		// Dont need to log in, this is an open page
		if (in_array($current_page, $ignored_pages))
		{
			return true;
		}

		if ( ! $this->current_user)
		{
			// save the location they were trying to get to
			$this->session->set_userdata('admin_redirect', $this->uri->uri_string());
			redirect('admin/login');
		}

		// of course
		if ($this->current_user->group === 'admin')
		{
			return true;
		}

		// Well they at least better have permissions!
		if ($this->current_user)
		{
			// We are looking at the index page. Show it if they have ANY admin access at all
			if ($current_page == 'admin/index' && $this->permissions)
			{
				return true;
			}

			//if we are trying to search the admin area
			if ($current_page == 'admin/search' && $this->permissions)
			{
				return true;
			}

			// Check if the current user can view that page
			return array_key_exists($this->module, $this->permissions);
		}

		// god knows what this is... erm...
		return false;
	}

}