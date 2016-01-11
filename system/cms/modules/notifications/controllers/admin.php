<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * 
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 * @package     
 */
class Admin extends Admin_Controller
{
	protected $section = 'items';

	public function __construct()
	{
		parent::__construct();

		

		// Load all the required classes
		$this->load->model('notifications_m');
		$this->load->library('form_validation');
		$this->lang->load('notifications');

		// Set the validation rules
		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'description',
				'label' => 'Description',
				'rules' => 'trim'
			),
			array(
				'field' => 'pcent',
				'label' => 'Percent Complete',
				'rules' => 'trim|numeric'
			)							
		);

		// We'll set the partials and metadata here since they're used everywhere
		$this->template->append_js('module::admin.js');
	}

	/**
	 * List all items
	 */
	public function index()
	{
		

		
		// here we use MY_Model's get_all() method to fetch everything
		$items = $this->notifications_m->get_all();

		// Build the view with Notifications/views/admin/items.php
		$this->template
			->title($this->module_details['name'])
			->set('items', $items)
			->build('admin/items');
	}


	public function del_ajax($id=0)
	{
		if($this->input->is_ajax_request()) {

			// See if the model can create the record
			if ($this->notifications_m->delete($id))
			{
				$count = $this->notifications_m->count_all();

				//send notification
				echo json_encode(['status'=>'success','message'=>'','count'=>$count]);die;

			}

			echo json_encode(['status'=>'error']);die;
		}
	}
	
	public function delete($id = 0) {

		if (isset($_POST['btnAction']) AND is_array($_POST['action_to'])) {

			$this->notifications_m->delete_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id)) {

			$this->notifications_m->delete($id);
		}

		redirect('admin/notifications');
	}

}
