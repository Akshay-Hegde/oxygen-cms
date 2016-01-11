<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 *
 * Code here is run before frontend controllers
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 * @package 	PyroCMS\Core\Controllers
 */
class Public_Controller extends MY_Controller
{
	/**
	 * Loads the gazillion of stuff, in Flash Gordon speed.
	 * @todo Document properly please.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->benchmark->mark('public_controller_start');

		// Check redirects if GET and Not AJAX
		if ( ! $this->input->is_ajax_request() and $_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$this->load->model('redirects/redirect_m');
			$uri = trim(uri_string(), '/');

			if ($uri and $redirect = $this->redirect_m->get_from($uri))
			{
				// Check if it was direct match
				if ($redirect->from == $uri)
				{
					redirect($redirect->to, 'location', $redirect->type);
				}

				// If it has back reference
				if (strpos($redirect->to, '$') !== false)
				{
					$from = str_replace('%', '(.*?)', $redirect->from);
					$redirect->to = preg_replace('#^'.$from.'$#', $redirect->to, $uri);
				}
				// Redirect with wanted redirect header type
				redirect($redirect->to, 'location', $redirect->type);
			}
		}


		// Check if we have access to view the site when closed
		if ( empty($this->current_user) OR ( isset($this->current_user) AND ($this->current_user->group !== 'admin')) )
		{
			// Check the frontend hasnt been disabled by an admin
			if ( ! $this->settings->frontend_enabled  )
			{
				set_status_header(503);
				//show a custom 503 page
				header('Retry-After: 600');
				$error = $this->settings->unavailable_message ? $this->settings->unavailable_message : lang('cms:fatal_error');
				//show_error($error, 503);
				echo $this->load->view('errors/error_503',['message'=>$error],true);die;
			}	
		}

		Events::trigger('public_controller');

		// -- Navigation menu -----------------------------------
		$this->load->model('pages/page_m');

		// Load the current theme so we can set the assets right away
		get_instance()->theme = $this->theme_m->get();

		if (empty($this->theme->slug))
		{
			show_error('This site has been set to use a theme that does not exist. If you are an administrator please '.anchor('admin/themes', 'change the theme').'.');
		}

		//Define the public theme const
		defined('PUBLIC_THEME') or define('PUBLIC_THEME',$this->theme->slug);

		// Set the theme as a path for Asset library
		Asset::add_path('theme', $this->theme->path.'/');
		Asset::set_path('theme');

		// Support CDN URL's like Amazon CloudFront 
		if (Settings::get('cdn_domain'))
		{
			$protocol = ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';

			// Make cdn.pyrocms.com into https://cdn.pyrocms.com/
			Asset::set_url($protocol.'://'.rtrim(Settings::get('cdn_domain'), '/').'/');
		}

		// Set the theme view folder
		$this->template->set_theme($this->theme->slug);

		// Is there a layout file for this module?
		if ($this->template->layout_exists($this->module.'.html'))
		{
			$this->template->set_layout($this->module.'.html');
		}

		// Nope, just use the default layout
		elseif ($this->template->layout_exists('default.html'))
		{
			$this->template->set_layout('default.html');
		}

		// Make sure whatever page the user loads it by, its telling search robots the correct formatted URL
		$this->template->set_metadata('canonical', site_url($this->uri->uri_string()), 'link');


		// grab the theme options if there are any
		$this->theme->options = $this->oxycache->model('theme_m', 'get_values_by', array(array('theme' => $this->theme->slug)));

		// Assign segments to the template the new way
		$this->template->server = $_SERVER;
		$this->template->theme = $this->theme;

		//call the functions in the theme .. if it exist!
		$this->load->helper('theme');
		poke_func($this->theme->slug,'run');

		// Call the event ONCE on widgets that have been instantiated.
		$this->load->library('widgets/widgets');		
		$this->widgets->call_widget_events();

		//load public language if it exist
		$this->lang->theme_lang($this->theme->slug,$this->theme->path);

		//end the benchmarking program..
		$this->benchmark->mark('public_controller_end');	

	}

}