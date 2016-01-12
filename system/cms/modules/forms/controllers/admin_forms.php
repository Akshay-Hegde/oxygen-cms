<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * OxygenCMS
 * 
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 * @package     
 */
class Admin_forms extends Admin_Controller
{

	protected $section = 'forms';


	public function __construct() 
	{

		parent::__construct();

		$this->load->driver('Streams');

		$this->load->config('forms/forms');

		$this->lang->load('forms/forms');

		$this->data = new stdClass();

		// Set our namespace
		$this->namespace = $this->config->item('forms:namespace');

		// Set the flow prefix
		$this->prefix = $this->config->item('forms:prefix');        

		// Set the per page limitter
		$this->per_page = $this->config->item('forms:per_page');  
	}

	public function index($offset=0)  
	{

		// 
		// Get our flows from the stream api
		// We only want to show the visible flows, so we pass `no` to the api
		//
		$this->data->flows = $this->streams->streams->get_streams($this->namespace, $this->per_page, $offset,'no');

		// 
		// Get the paginated results
		//
		$this->data->pagination = create_pagination('admin/forms/index', $this->streams_m->total_streams($this->namespace,'no'),4);

		// 
		// Send to our presenter
		//
		$this->template->build('admin/forms/index', $this->data);
	}


	public function syntax($stream_slug=0)  
	{

		//$stream_row = $this->db->where('stream_slug',$stream_slug)->get('data_streams')->row();

		$this->template
			->set_layout(false)
			->set('slug',$stream_slug)
			->build('admin/forms/syntax');
	}

	/**
	 * @author Sal McDonald
	 *
	 * Create a new List
	 * This will create a new stream for each List, 
	 * as each List may require different fields
	 *
	 */
	public function create()
	{
	
		
		//initial stream/flow
		$data = new stdClass();
		$data->method = 'create';
		$data->stream = new stdClass();

		//check for callback
		if($input = $this->input->post())
		{
			$this->_post_create($data,$input);
		}

		//initialize
		foreach ($this->streams_m->streams_validation as $field)
		{
			$key = $field['field'];
			$data->stream->$key = $this->input->post($key) || '';
			$key = null;
		}
		
		$this->template->append_js('module::admin.js');
		$this->template->build('admin/forms/create', $data);
	}

	private function _post_create($data, $input)
	{

		//dump($input);die;

		//
		// Check requires
		//
		if(!(isset($input['stream_slug'])))
		{
			return false;
		}

		// 
		// Clean the slug of white space
		//
		$input['stream_slug']  = str_replace(' ', '_', $input['stream_slug']);



		// Set to overwrite
		$data->method = 'new';		



		//set rules
		$this->form_validation->set_rules($this->streams_m->streams_validation);

		foreach ($this->streams_m->streams_validation as $field)
		{
			$key = $field['field'];
			$data->stream->$key = ($this->input->post($key))? $this->input->post($key) : '' ;
			$key = null;
		}

		// Also clean user input
		if(isset($data->stream->stream_slug))
		{
			$data->stream->stream_slug  = str_replace(' ', '_', $data->stream->stream_slug);
		}

		if(!(isset($data->stream->stream_prefix)))
		{
			$data->stream->stream_prefix  = $this->prefix;
		}

		$extra = [];

		//
		// Get all groups (non-admins) and assign to permissions
		//
		$extra['permissions'] = $this->groupie();	


		//before creating the stream, lets collect our db record info
		$this->load->model('forms/metadata_m');		

		$record_input = [];	        
		$record_input['store_db'] = 1; //always
		$record_input['notify_email'] = (isset($input['notify_email']))?1:0;
		$record_input['email'] = (isset($input['notify_email']))? $input['email'] :'';
		$record_input['form_stream_id'] = 1;

		unset($input['email']);
		unset($input['notify_email']);


		$this->_create_form_stream(
								$data->stream->stream_name,
								$data->stream->stream_slug,
								$this->prefix,
								$this->namespace,
								$this->input->post('about'),
								$extra,
								$record_input
							);


		redirect('admin/forms/forms');		
	}	


	private function _create_form_stream($stream_name, $stream_slug, $prefix, $namespace,$about,$extra,$record_input)
	{
		if ( $stream_id = $this->streams_m->create_new_stream($stream_name,$stream_slug,$prefix,$namespace,$about,$extra) )
		{
			$record_input['form_stream_id'] = $stream_id;
			$this->metadata_m->create($record_input);

			//assign the required fields to a List stream
			$this->streams->fields->assign_field( 'forms', $stream_slug , 'message', []);
			$this->session->set_flashdata('success', lang('streams:create_stream_success'));
		}
		else
		{
			$this->session->set_flashdata('notice', lang('streams:create_stream_error'));		
		}
	}	

	/**
	 * Edit an name of existing List
	 *
	 */
	public function edit($list_id=0)  
	{
		//check postback
		$this->_check_edit_postback($list_id);

		//$this->data->stream
		if($stream_row = $this->db->where('id',$list_id)->get('data_streams')->row())
		{
			//the List stream
			$this->data->stream = $this->streams->streams->get_stream($stream_row->stream_slug,$this->namespace);

			// Get Stream Fields        
			// @todo - do we really need the 1000, 0 here? Did I take care of that? Check it out!
			$this->data->stream_fields = $this->streams_m->get_stream_fields($this->data->stream->id, 1000, 0);

			$metadata_row = $this->db->where('form_stream_id',$stream_row->id)->get('forms')->row();

		}
		else
		{
			$this->session->set_flashdata('notice', 'An error occured.');
			redirect('admin');
		}

		$this->template->set('method','edit');
		$this->template->set('stream',$stream_row);
		$this->template->set('metadata',$metadata_row);
		$this->template->build('admin/forms/edit',$this->data);
	}

	public function viewoptions($stream_slug='forms')
	{
		// Process Data
		if( $this->input->post('view_options') )
		{
			$input = $this->input->post();

			$this->_viewoptions($input,$stream_slug);
		}
	}


	private function _check_edit_postback($list_id=0)  
	{
		$return_message = '';

		if($this->input->post('stream_name'))
		{
			$input = $this->input->post();

			$view_options = $input['view_options'];
			$update_data['view_options'] = serialize($view_options);
			$this->db->where('id', $list_id); //list_id == stream_id
			if( !$this->db->update(STREAMS_TABLE, $update_data) )
			{
				$return_message .= lang('streams:view_options_update_error');
			}
			else
			{
				$return_message .= lang('streams:view_options_update_success');
			}

			//$this->data->stream
			$original = $this->db->where('id',$list_id)->get('data_streams')->row();

			$original->stream_name = $input['stream_name'];
			$original->about = $input['about'];

			$data = 
			[
				'email' => $input['email'],
				'notify_email' => isset($input['notify_email'])?1:0,
				'redir_success' => isset($input['redir_success'])?$input['redir_success']:'',
				'msg_success' =>isset($input['msg_success'])?$input['msg_success']:'',
				'redir_error' => isset($input['redir_error'])?$input['redir_error']:'',
				'msg_error' => isset($input['msg_error'])?$input['msg_error']:'',
				'replyto_field' => isset($input['replyto_field'])?$input['replyto_field']:'',
			];

			if($this->db->where('form_stream_id',$list_id)->limit(1)->update('forms',$data))
			{
				$this->session->set_flashdata('success', 'Update success. '. $return_message);
			}

			//check redirect
			if($input['btnAction'] == 'save_exit')
			{
				redirect('admin/forms/forms/');
			}

			redirect('admin/forms/forms/edit/'.$list_id);

		}
	}


	/**
	 * Delete an existing List
	 */
	public function delete($stream_slug='') 
	{
		if($stream_row = $this->db->where('stream_slug',$stream_slug)->get('data_streams')->row())
		{
			if( ! $this->streams->streams->delete_stream($stream_slug, $this->namespace) )
			{
				$this->session->set_flashdata('notice', lang('streams:delete_entry_error'));	
			}
			else
			{
				$this->session->set_flashdata('success', lang('streams:delete_entry_success'));	
				//now delete from our records
				$this->db->where('form_stream_id',$stream_row->id)->delete('forms');
			}
		}
		redirect('admin/forms/forms/');
	}

	private function groupie()
	{
		// Assign all users with stream access Write access to this flow
		$groups = $this->db
						->select('*, users_groups.id as group_id')
						->from('users_groups, permissions')
						->where('users_groups.id', 'permissions.group_id')
						->where('permissions.module', 'forms')
						->where('users_groups.name !=', 'admin')->get()->result();

		$groups_arr = [];

		foreach ($groups as $g)
		{
			$groups_arr[] = $g->group_id;
		}

		return serialize($groups_arr);
	}	
}