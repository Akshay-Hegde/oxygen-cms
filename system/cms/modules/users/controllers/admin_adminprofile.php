<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the users module
 *
 * @author		 PyroCMS Dev Team
 * @package	 PyroCMS\Core\Modules\Users\Controllers
 */
class admin_adminprofile extends Admin_Controller
{

	protected $section = 'users';


	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		//set new layout
		
		
		// Load the required classes
		$this->load->model('user_m');
		$this->load->model('groups/group_m');
		$this->load->helper('user');
		$this->load->library('form_validation');
		$this->lang->load('user');

		$this->load->helper('users/field_forms');

		if ($this->current_user->group != 'admin') 
		{
			$this->template->groups = $this->group_m->where_not_in('name', 'admin')->get_all();
		} 
		else 
		{
			$this->template->groups = $this->group_m->get_all();
		}
		
		$this->template->groups_select = array_for_select($this->template->groups, 'id', 'description');
	}


	/**
	 * Edit an existing user
	 *
	 * @param int $id The id of the user.
	 */
	public function edit($id = 0)
	{
		if (OXYGEN_DEMO)
		{
			$this->session->set_flashdata('notice', lang('global:demo_restrictions'));
			redirect('admin/users');
		}

		// Get the user's data
		if ( ! ($member = $this->ion_auth->get_user($id)))
		{
			$this->session->set_flashdata('error', lang('user:edit_user_not_found_error'));
			redirect('admin/users');
		}

		// Get the profile fields validation array from streams
		$this->load->driver('Streams');

		//

		try
		{
			$extra = 
			[
				'return' => 'admin/users/adminprofile/edit/'.$id,
				'success_message' => 'Success',
				'failure_message' => 'Error',
				'title' => 'Edit',
			];

			$this->streams->cp->entry_form('users_admin_profiles', 'users', 'edit', $id, true, $extra);
		}
		catch(\Oxygen\Exceptions\InvalidRowException $ire)
		{
			//lets show a create form
			$this->do_create($id);
		}

		return;
		////

		//we want to show this data too!
		$this->load->model('users/admin_profile_m');
		$admin_profile_data = $this->admin_profile_m->get_profile($id);


		$this->template
			->title($this->module_details['name'], sprintf(lang('user:edit_title'), $member->username))
			->set('display_name', $member->display_name)
			->set('member', $member)
			->set('admin_profile_data',$admin_profile_data)
			->build('admin/admin_profile_form');		

	}

	private function do_create($user_id)
	{

		$extra = [
			'return' => 'admin/users/adminprofile/edit/'.$user_id,
			'success_message' => 'Success',
			'failure_message' => 'Error',
			'title' => 'New',
		];
		$skips = [];
		$tabs = false;
		$hidden = [];
		$default = ['user_id'=>$user_id];

		//entry_form($stream_slug, $namespace_slug, $mode = 'new', $entry = null, $view_override = false, $extra = [], $skips = [])
		$this->streams->cp->entry_form('users_admin_profiles', 'users', 'new', NULL, true, $extra,$skips,$tabs,$hidden,$default);
	}	


	private function randUN()
	{

		$min = 30;
		$max = 70;
		$userlength = rand(3, 10);

		$username = '';

		for ($i=0; $i<$userlength; $i++) 
		{
			$username .= chr(rand($min, $max));
		}

		//Now check if exist, otherwise
		if($user = $this->db->where('username',$username)->get('users')->row())
		{
			return $this->randUN();
		}

		return $username;
	
	}

	private function randPW()
	{

		$min = 30;
		$max = 70;
		$userlength = 5;

		$username = '';

		for ($i=0; $i<$userlength; $i++) 
		{
			$username .= chr(rand($min, $max));
		}

		$username =  'user' . $username;

		//Now check if exist, otherwise
		if($user = $this->db->where('username',$username)->get('users')->row())
		{
			return $this->randUN();
		}

		return $username;
	
	}


}