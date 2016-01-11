<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * Roles controller for the groups module
 * 
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 * @package     PyroCMS\Core\Modules\Groups\Controllers
 */
class Admin extends Admin_Controller
{

	protected $section = 'groups'; 
	
	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();


		// Load the required classes
		$this->load->library('form_validation');

		$this->load->model('group_m');

		$this->lang->load('group');
		$this->lang->load('permissions/permissions');

		// Validation rules
		$this->validation_rules = 
		[
			[
				'field' => 'name',
				'label' => lang('groups:name'),
				'rules' => 'trim|required|max_length[100]'
			],
			[
				'field' => 'description',
				'label' => lang('groups:description'),
				'rules' => 'trim|required|max_length[250]'
			]
		];
	}

	/**
	 * Create a new group role
	 */
	public function index()
	{

		$this->current_user OR redirect('admin');

		//this page can now use the new layout
		$groups = $this->group_m->order_by('authority','asc')->get_all();

		$this->current_user->group_data =  $this->group_m->get_by('name',$this->current_user->group);

		$this->template
			->title($this->module_details['name'])
			->set('groups', $groups)
			->build('admin/index');
	}


	/**
	 * Create a new group role
	 */
	public function add()
	{

		$this->current_user->group_data =  $this->group_m->get_by('name',$this->current_user->group);
		$max_auth = $this->current_user->group_data->authority;		
		
		$group = new stdClass();

		if ($_POST)
		{
			$this->form_validation->set_rules($this->validation_rules);

			if ($this->form_validation->run())
			{
				if ($id = $this->group_m->insert($this->input->post()))
				{
					// Fire an event. A new group has been created.
					Events::trigger('group_created', $id);

					$this->session->set_flashdata('success', sprintf(lang('groups:add_success'), $this->input->post('name')));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('groups:add_error'), $this->input->post('name')));
				}

				redirect('admin/groups');
			}
		}

		$group = new stdClass();

		// Loop through each validation rule
		foreach ($this->validation_rules as $rule)
		{
			$group->{$rule['field']} = set_value($rule['field']);
		}

		$this->template
			->set_layout(false)
			->title($this->module_details['name'], lang('groups:add_title'))
			->set('group', $group)
			->set('can_edit', true)
			->set('max_auth', $max_auth)					
			->build('admin/form');
	}

	/**
	 * Edit a group role
	 *
	 * @param int $id The id of the group.
	 */
	public function edit($id = 0)
	{
		$this->current_user OR redirect('admin/groups');
		$this->current_user->group_data =  $this->group_m->get_by('name',$this->current_user->group);

		$group = $this->group_m->get($id);

		//can the editor change the authority of the group
		$can_edit = ($this->current_user->group_data->authority <= $group->authority)?true:false;
		$max_auth = $this->current_user->group_data->authority;

		// Make sure we found something
		$group or redirect('admin/groups');

		if ($_POST)
		{
			// Got validation?
			if ($group->name == 'admin' or $group->name == 'user' )
			{
				//if they're changing description on admin or user save the old name
				$_POST['name'] = $group->name;
				$this->form_validation->set_rules('description', lang('groups:description'), 'trim|required|max_length[250]');
			}
			else
			{
				$this->form_validation->set_rules($this->validation_rules);
			}

			if ($this->form_validation->run())
			{
				if ($success = $this->group_m->update($id, $this->input->post()))
				{
					// Fire an event. A group has been updated.
					Events::trigger('group_updated', $id);
					$this->session->set_flashdata('success', sprintf(lang('groups:edit_success'), $this->input->post('name')));
				}
				else
				{
					$this->session->set_flashdata('error', sprintf(lang('groups:edit_error'), $this->input->post('name')));
				}

				redirect('admin/groups');
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('groups:edit_title'), $group->name))
			->set('group', $group)
			->set('can_edit', $can_edit)
			->set('max_auth', $max_auth)		
			->build('admin/form');
	}

	/**
	 * Delete group role(s)
	 *
	 * @param int $id The id of the group.
	 */
	public function delete($id = 0)
	{
		
		$this->current_user OR redirect('admin');

		$this->current_user->group_data =  $this->group_m->get_by('name',$this->current_user->group);


		// First lets get the group
		if($group = $this->group_m->get($id))
		{
			if($this->current_user->group_data->authority >= $group->authority)
			{
				$this->session->set_flashdata('error','You do not have access to delete this group.');
				redirect('admin/groups');
			}

			//double check to see its not a core group
			if ( in_array($group->name, array('user', 'admin')))
			{
				$this->session->set_flashdata('error', lang('groups:delete_error'));
			}
			else
			{
				if ($success = $this->group_m->delete($id))
				{
					// Fire an event. A group has been deleted.
					Events::trigger('group_deleted', $id);

					$this->session->set_flashdata('success', lang('groups:delete_success'));
				}
				else
				{
					$this->session->set_flashdata('error', lang('groups:delete_error'));
				}
			}
		}
		else
		{
			$this->session->set_flashdata('error', lang('groups:delete_error'));
		}
		
		redirect('admin/groups');
	}
}
