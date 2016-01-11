<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 * 
 * The admin class is basically the main controller for the backend.
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 * @package	 	PyroCMS\Core\Controllers
 *
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('users/user');
	}
	
	/**
	 * Show the control panel
	 */
	public function index()
	{
		// @deprecated - this should be removed for next version
		// define this so the views know its a dashboard layout, 
		// if not defined then its not the dashboard
		define('DASHBOARD_VIEW','');

		// let everyone know about the dashboard
		Events::trigger('admin_display_dashboard');

		// we could add this to notification
		if (is_dir('./installer'))
		{
			define('INSTALLER_DIR_WARNING',lang('cp:delete_installer'));		

			if (ENVIRONMENT !== OXYGEN_DEVELOPMENT)
			{
				$this->template->set('messages', array('error' => '<button id="remove_installer_directory" class="btn btn-warning">'.lang('cp:delete_installer').'</button>'.lang('cp:delete_installer_message')));
			}
		}

		$this->template	
			->enable_parser(true)
			->set_layout('dashboard')
			->title(lang('global:dashboard'))
			->build('admin/partials/o2/dashboard/rows');			
	}


	/**
	 * Log in
	 */
	public function login()
	{
		// Set the validation rules
		$this->validation_rules = 
		[
			[
				'field' => 'email',
				'label' => lang('global:email'),
				'rules' => 'required|callback__check_login'
			],
			[
				'field' => 'password',
				'label' => lang('global:password'),
				'rules' => 'required'
			]
		];

 
		// Call validation and set rules
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);

		// If the validation worked, or the user is already logged in
		if ($this->form_validation->run() or $this->ion_auth->logged_in())
		{
			//force current user
			$auser = $this->ion_auth->get_user();

			$this->timeline
				->user($auser->id)
				->icon('key')
				->name('AUTHENTICATION')
				->message('successfully logged in.')
				->commit();

			
			// if they were trying to go someplace besides the 
			// dashboard we'll have stored it in the session
			$redirect = $this->session->userdata('admin_redirect');
			$this->session->unset_userdata('admin_redirect');

			redirect($redirect ? $redirect : 'admin');
		}

		$this->template
			->set_layout('login')
			->build('blank');
	}

	/**
	 * Logout
	 */
	public function logout()
	{

		$this->timeline
			->user($this->current_user->id)
			->icon('key')
			->name('AUTHENTICATION')
			->message('logged out.')
			->commit();

		$this->load->language('users/user');
		$this->ion_auth->logout();

		$this->session->set_flashdata('success', lang('user:logged_out'));
		redirect('admin/login');
	}

	/**
	 * Callback From: login()
	 *
	 * @param string $email The Email address to validate
	 *
	 * @return bool
	 */
	public function _check_login($email)
	{
		if ($this->ion_auth->login($email, $this->input->post('password'), (bool)$this->input->post('remember')))
		{
			Events::trigger('post_admin_login');
			
			return true;
		}

		Events::trigger('login_failed', $email);
		error_log('Login failed for user '.$email);

		$this->form_validation->set_message('_check_login', $this->ion_auth->errors());
		return false;
	}

	/**
	 * Display the help string from a module's
	 * Details.php file in a modal window
	 *
	 * @param	string	$slug	The module to fetch help for
	 *
	 * @return	void
	 */
	public function help($slug)
	{
		$this->template
			->set_layout('modal', 'admin')
			->set('help', $this->module_m->help($slug))
			->build('admin/partials/help');
	}

	public function remove_installer_directory()
	{
		if ( ! $this->input->is_ajax_request())
		{
			die('Nope, sorry');
		}

		header('Content-Type: application/json');

		if (is_dir('./installer'))
		{
			$this->load->helper('file');
			// if the contents of "installer" delete successfully then finish off the installer dir
			if (delete_files('./installer', true) and count(scandir('./installer')) == 2)
			{
				rmdir('./installer');
				// This is the end, tell Sally I loved her.
				die(json_encode(array('status' => 'success', 'message' => lang('cp:delete_installer_successfully_message'))));
			}
		}

		die(json_encode(array('status' => 'error', 'message' => lang('cp:delete_installer_manually_message'))));
	}
}