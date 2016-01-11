<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Admin controller for the widgets module.
 *
 * @package   PyroCMS\Core\Modules\Addons\Controllers
 * @author    PyroCMS Dev Team
 * @copyright Copyright (c) 2012, PyroCMS LLC
 */
class Admin_Widgets extends Admin_Controller
{
	/**
	 * The current active section
	 *
	 * @var string
	 */
	protected $section = 'widgets';

	/**
	 * Every time this controller is called it should:
	 * - load the widgets library
	 * - load the widgets and addons language files
	 * - remove the view layout if the request is an AJAX request
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('widgets/widgets');
		$this->lang->load('addons');
		$this->lang->load('widgets');
		$this->load->model('widgets/widget_m');

		//$this->input->is_ajax_request() and $this->template->set_layout(false);

		if (in_array($this->method, array('index', 'manage')))
		{
			// requires to install and/or uninstall widgets
			$this->widgets->list_available_widgets();
		}

	}

	/**
	 * Index method, lists both enabled and disabled widgets
	 */
	public function index()
	{
		$data = [];

		$data['widgets'] = $this->widget_m->get_all();

		// Create the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/widgets/index', $data);
	}

	/**
	 * Enable widget
	 *
	 * @param string $id       The id of the widget
	 * @param bool   $redirect Optional if a redirect should be done
	 */
	public function enable($id = '')
	{
		$this->widget_m->enable_widget($id);
		redirect('admin/addons/widgets');
	}

	/**
	 * Disable widget
	 *
	 * @param string $id       The id of the widget
	 * @param bool   $redirect Optional if a redirect should be done
	 */
	public function disable($id = '')
	{
		$this->widget_m->disable_widget($id);
		redirect('admin/addons/widgets');
	}
}