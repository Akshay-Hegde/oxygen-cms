<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Modules controller, lists all installed modules
 *
 * @package 	PyroCMS\Core\Modules\Addons\Controllers
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */

class Admin_modules extends Admin_Controller
{
	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'modules';

	/**
	 * Constructor method
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->lang->load('addons');

	}

	/**
	 * Index method
	 * 
	 * @return void
	 */
	public function index()
	{
		
		$this->module_m->import_unknown();

		$all_modules = $this->module_m->get_all(null, true);

		$core_modules = $addon_modules = [];

		//dump($all_modules);die;

		foreach ($all_modules as $module)
		{
			if ($module['is_core'])
			{
				$core_modules[] = $module;
			}
			else
			{
				$addon_modules[] = $module;
			}
		}

		$this->template
			->title($this->module_details['name'])
			->set('core_modules', $core_modules)
			->set('addon_modules', $addon_modules)
			->build('admin/modules/index');
	}

	/**
	 * Upload
	 *
	 * Uploads an addon module
	 *
	 * @return	void
	 */
	public function upload()
	{
		if ( ! $this->settings->addons_upload)
		{
			show_error('Uploading add-ons has been disabled for this site. Please contact your administrator');
		}

		if ($this->input->post('btnAction') == 'upload')
		{
			$config['upload_path'] 		= SITE_DIR;
			$config['allowed_types'] 	= 'zip';
			$config['max_size']			= 20480;
			$config['overwrite'] 		= true;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload())
			{
				$upload_data = $this->upload->data();

				// Now try to unzip
				$this->load->library('unzip');
				$this->unzip->allow( ['xml', 'html', 'css', 'js', 'png', 'gif', 'jpeg', 'jpg', 'swf', 'ico', 'php'] );

				// Try and extract
				if ( is_string($slug = $this->unzip->extract($upload_data['full_path'], ADDONPATH.'modules/', true, true)) )
				{
					$redirect = 'addons/modules';
					$this->session->set_flashdata('success', sprintf(lang('addons:modules:upload_success'), $slug));
				}
				else
				{
					$redirect = 'addons/modules/upload';
					$this->session->set_flashdata('error', $this->unzip->error_string());
				}

				// Delete uploaded file
				@unlink($upload_data['full_path']);
			}
			else
			{
				$redirect = 'addons/modules/upload';
				$this->session->set_flashdata('error', $this->upload->display_errors());
			}

			redirect('admin/'.$redirect);
		}

		$this->template
			->title($this->module_details['name'], lang('addons:modules:upload_title'))

			->build('admin/modules/upload');
	}
	
	/**
	 * Uninstall
	 *
	 * Uninstalls an addon module
	 *
	 * @param	string	$slug	The slug of the module to uninstall
	 * @return	void
	 */
	public function uninstall($slug = '',$is_core=0)
	{

		if ($this->module_m->uninstall($slug,$is_core))
		{
			$this->session->set_flashdata('success', sprintf(lang('addons:modules:uninstall_success'), $slug));
			
			// Fire an event. A module has been disabled when uninstalled. 
			Events::trigger('module_disabled', $slug);
		}
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('addons:modules:uninstall_error'), $slug));
		}

		redirect('admin/addons/modules');
	}

	/**
	 * Enable
	 *
	 * Enables an addon module
	 *
	 * @param	string	$slug	The slug of the module to enable
	 * @return	void
	 */
	public function install($slug,$core=false)
	{
		if ($this->module_m->install($slug,$core))
		{
			// Fire an event. A module has been enabled when installed. 
			Events::trigger('module_enabled', $slug);
							
			// Clear the module cache
			$this->oxycache->delete_all('module_m');
			$this->session->set_flashdata('success', sprintf(lang('addons:modules:install_success'), $slug));
		}
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('addons:modules:install_error'), $slug));
		}

		redirect('admin/addons/modules');
	}

	/**
	 * Enable
	 *
	 * Enables an addon module
	 *
	 * @param	string	$slug	The slug of the module to enable
	 * @return	void
	 */
	public function enable($slug)
	{
		//need to check if installed
		if ($this->module_m->enable($slug))
		{
			// Fire an event. A module has been enabled. 
			Events::trigger('module_enabled', $slug);
			
			// Clear the module cache
			$this->oxycache->delete_all('module_m');
			$this->session->set_flashdata('success', sprintf(lang('addons:modules:enable_success'), $slug));
		}
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('addons:modules:enable_error'), $slug));
		}

		redirect('admin/addons/modules');
	}

	/**
	 * Disable
	 *
	 * Disables an addon module
	 *
	 * @param	string	$slug	The slug of the module to disable
	 * @return	void
	 */
	public function disable($slug)
	{
		if ($this->module_m->disable($slug))
		{
			// Fire an event. A module has been disabled. 
			Events::trigger('module_disabled', $slug);
			
			// Clear the module cache
			$this->oxycache->delete_all('module_m');
			$this->session->set_flashdata('success', sprintf(lang('addons:modules:disable_success'), $slug));
		}
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('addons:modules:disable_error'), $slug));
		}

		redirect('admin/addons/modules');
	}
	
	/**
	 * Upgrade
	 *
	 * Upgrade an addon module
	 *
	 * @param	string	$slug	The slug of the module to disable
	 * @return	void
	 */
	public function upgrade($slug)
	{
		// If upgrade succeeded
		if ($this->module_m->upgrade($slug))
		{
			// Fire an event. A module has been upgraded. 
			Events::trigger('module_upgraded', $slug);
			
			$this->session->set_flashdata('success', sprintf(lang('addons:modules:upgrade_success'), $slug));
		}
		// If upgrade failed
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('addons:modules:upgrade_error'), $slug));
		}
		
		redirect('admin/addons/modules');
	}

}