<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a tasks module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	tasks Module
 */
class Admin extends Admin_Controller
{
	protected $section = 'items';

	public function __construct()
	{
		parent::__construct();

		
		// Load all the required classes
		$this->load->model('tasks_m');
		$this->load->library('form_validation');
		$this->lang->load('tasks');

		// Set the validation rules
		$this->item_validation_rules = 
		[
			[
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|max_length[100]|required'
			],
			[
				'field' => 'description',
				'label' => 'Description',
				'rules' => 'trim'
			],
			[
				'field' => 'pcent',
				'label' => 'Percent Complete',
				'rules' => 'trim|numeric'
			]						
		];

	}

	/**
	 * List all items
	 */
	public function index()
	{

		$this->load->model('tasks/tasks_m');
        $todo_tasks = $this->tasks_m->where('complete',null)->order_by('pcent','desc')->get_all();
        $this->template->set('todo_tasks',$todo_tasks);

		// Build the view with tasks/views/admin/items.php
		$this->template
			->title($this->module_details['name'])
			//->set('todo_tasks', $todo_tasks)
			->build('admin/items');
	}

	public function create()
	{
		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if ($this->form_validation->run())
		{
			// See if the model can create the record
			if ($this->tasks_m->create($this->input->post()))
			{
				// All good...
				$this->session->set_flashdata('success', lang('tasks.success'));
				redirect('admin/tasks');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('tasks.error'));
				redirect('admin/tasks/create');
			}
		}
		
		$tasks = new stdClass;
		foreach ($this->item_validation_rules as $rule)
		{
			$tasks->{$rule['field']} = $this->input->post($rule['field']);
		}

		// Build the view using tasks/views/admin/form.php
		$this->template
			->title($this->module_details['name'], lang('tasks.new_item'))
			->set('tasks', $tasks)
			->build('admin/form');
	}
	
	
	public function via_ajax($postData=0)
	{
		if($this->input->is_ajax_request()) {

			$input = $this->input->post();

			//var_dump($input);die;

			// See if the model can create the record
			if ($id = $this->tasks_m->create_simple($input['task']))
			{
				$count = $this->tasks_m->count_all();
				//send notification
				echo json_encode(['status'=>'success','id'=>$id,'count'=>$count]);die;

			}

			echo json_encode(['status'=>'error']);die;
		}

	}


	
	public function del_ajax($id=0)
	{
		if($this->input->is_ajax_request()) {

			// See if the model can create the record
			if ($this->tasks_m->delete($id))
			{
				$count = $this->tasks_m->count_all();

				//send notification
				echo json_encode(['status'=>'success','message'=>'','count'=>$count]);die;

			}

			echo json_encode(['status'=>'error']);die;
		}

	}

	public function edit($id = 0)
	{
		$tasks = $this->tasks_m->get($id);

		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if ($this->form_validation->run())
		{
			// get rid of the btnAction item that tells us which button was clicked.
			// If we don't unset it MY_Model will try to insert it
			unset($_POST['btnAction']);
			
			// See if the model can create the record
			if ($this->tasks_m->update($id, $this->input->post()))
			{
				// All good...
				$this->session->set_flashdata('success', lang('tasks.success'));
				redirect('admin/tasks');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('tasks.error'));
				redirect('admin/tasks/create');
			}
		}

		// Build the view using tasks/views/admin/form.php
		$this->template
			->title($this->module_details['name'], lang('tasks.edit'))
			->set('tasks', $tasks)
			->build('admin/form');
	}
	
	public function delete($id = 0)
	{
		// make sure the button was clicked and that there is an array of ids
		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
			// pass the ids and let MY_Model delete the items
			$this->tasks_m->delete_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			// they just clicked the link so we'll delete that one
			$this->tasks_m->delete($id);
		}
		redirect('admin/tasks');
	}


	public function complete($id = 0)
	{
		if (is_numeric($id))
		{
			// they just clicked the link so we'll delete that one
			$this->tasks_m->complete($id);
		}
		redirect('admin/tasks');
	}	


	public function maintenance_delete_all()
	{
		$this->db->truncate('tasks');
		redirect('admin/maintenance');
	}
}
