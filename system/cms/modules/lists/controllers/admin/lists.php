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
class Lists extends Admin_Controller
{

	protected $section = 'lists';


	public function __construct() 
	{

		parent::__construct();

        $this->load->driver('Streams');

        $this->load->config('lists/lists');

        $this->lang->load('lists/lists');

        $this->data = new stdClass();

        // Set our namespace
        $this->namespace = $this->config->item('lists:namespace');

        // Set the flow prefix
        $this->prefix = $this->config->item('lists:prefix');        

        // Set the per page limitter
        $this->per_page = $this->config->item('lists:per_page');  
	}

    public function index($offset=0)  {

    	// 
    	// Get our flows from the stream api
    	// We only want to show the visible flows, so we pass `no` to the api
    	//
    	//$this->per_page;
    	$this->data->lists = $this->streams->streams->get_streams($this->namespace, null, $offset,'no');


		$count = $this->streams_m->total_streams($this->namespace,'no');

		// 
		// Get the paginated results
		//
		$this->data->pagination = create_pagination('admin/lists/list/index', $count,$this->per_page,5);



		// 
		// Send to our presenter
		//
        $this->template->build('admin/lists/index', $this->data);
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
        $this->template->build('admin/lists/create2', $data);
	}

	private function _post_create($data, $input)
	{

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


        $this->_create_list_stream(
								$data->stream->stream_name,
								$data->stream->stream_slug,
								$this->prefix,
								$this->namespace,
								$this->input->post('about'),
								$extra
							);


		redirect('admin/lists/lists');		
	}	

	private function groupie()
	{
		// Assign all users with stream access Write access to this flow
        $groups = $this->db
                        ->select('*, users_groups.id as group_id')
                        ->from('users_groups, permissions')
                        ->where('users_groups.id', 'permissions.group_id')
                        ->where('permissions.module', 'lists')
                        ->where('users_groups.name !=', 'admin')->get()->result();

        $groups_arr = [];

        foreach ($groups as $g)
        {
            $groups_arr[] = $g->group_id;
        }

        return serialize($groups_arr);
	}	

	/**
	 * All lists will have a common status field type assigned to them
	 */
	private function _create_list_stream($stream_name, $stream_slug, $prefix, $namespace,$about,$extra)
	{
		if ( $this->streams_m->create_new_stream($stream_name,$stream_slug,$prefix,$namespace,$about,$extra) )
		{
			//assign the required fields to a List stream
        	//$this->streams->fields->assign_field( 'lists', $stream_slug , 'title', []);  
        	$this->streams->fields->assign_field( 'lists', $stream_slug , 'onoff_status', [ ] );
			$this->session->set_flashdata('success', lang('streams:create_stream_success'));

			//update the timeline logger
			$this->timeline
				->user($this->current_user->id)
				->icon('plus')
				->name('List')
				->message('created list '.$stream_name)
				->commit();
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
    	$this->_edit($list_id);

		//$this->data->stream
		$row = $this->db->where('id',$list_id)->get('data_streams')->row();

		$this->template->set('method','edit');
		$this->template->set('List',$row);
		$this->template->set_layout(false)->build('admin/lists/form');
    }


    public function export($list_id=0)  
    {
    	
    	//check postback
    	$this->_edit($list_id);

		//$this->data->stream
		$row = $this->db->where('id',$list_id)->get('data_streams')->row();

		$row->fields = $this->db->where('stream_id',$row->id)->get('data_field_assignments')->result();

		foreach($row->fields as &$field_assignment) {
			$field_assignment->field = $this->db->where('id',$field_assignment->field_id)->get('data_fields')->result();
				
		} 

		$row->export = json_encode($row);


		$this->template->set('method','edit');
		$this->template->set('List',$row);
		$this->template->build('admin/lists/export');
    }
 

    private function _edit($list_id=0)  
    {

    	if($this->input->post('stream_name'))
    	{
    		$input = $this->input->post();

			//$this->data->stream
			$original = $this->db->where('id',$list_id)->get('data_streams')->row();

			$original->stream_name = $input['stream_name'];
			$original->about = $input['about'];

			$this->db->where('id',$list_id)->update('data_streams',$original);

			redirect('admin/lists/entries/view/'.$original->stream_slug);

    	}

    	redirect('admin/lists/');
    }

    /**
     * Delete an existing List
     */
	public function delete($list_slug='') {

		
		

		if( ! $this->streams->streams->delete_stream($list_slug, $this->namespace) )
		{
			$this->session->set_flashdata('notice', lang('streams:delete_entry_error'));	
		}
		else
		{
			$this->session->set_flashdata('success', lang('streams:delete_entry_success'));	
		}

		redirect('admin/lists/lists/');
	}


}
