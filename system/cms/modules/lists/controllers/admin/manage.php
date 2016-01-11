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
class Manage extends Admin_Controller
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

	/**
	 * View a list of lists
	 */
    public function index($offset=0)  
    {
        // Redirect to lists/index
        redirect('admin/lists/lists/');

        /*
    	// 
    	// Get our flows from the stream api
    	// We only want to show the visible flows, so we pass `no` to the api
    	//
    	$this->data->flows = $this->streams->streams->get_streams($this->namespace, $this->per_page, $offset,'no');

		// 
		// Get the paginated results
		//
		$this->data->pagination = create_pagination('admin/lists/index', $this->streams_m->total_streams($this->namespace,'no'),4);

		// 
		// Send to our presenter
		//
        $this->template->build('admin/manage/index', $this->data);
        */
    }



    public function viewoptions($stream_slug='lists')
    {

        //the List stream
        $this->data->stream = $this->streams->streams->get_stream($stream_slug,$this->namespace);

        // Process Data
        if( $this->input->post('view_options') )
        {
            $input = $this->input->post();

            $this->_viewoptions($input,$stream_slug);
        }

        // Get Stream Fields        
        // @todo - do we really need the 1000, 0 here? Did I take care of that? Check it out!
        $this->data->stream_fields = $this->streams_m->get_stream_fields($this->data->stream->id, 1000, 0);

        // Build Pages  
        $this->template
            ->set_layout(false)
            ->build('admin/manage/view_options', $this->data);
    }


    private function _viewoptions($input,$stream_slug)
    {

        $opts = $input['view_options'];
    
        $update_data['view_options'] = serialize($opts);
        
        $this->db->where('id', $this->data->stream->id);
        
        if( !$this->db->update(STREAMS_TABLE, $update_data) )
        {
            $this->session->set_flashdata('notice', lang('streams:view_options_update_error'));
        }
        else
        {
            $this->session->set_flashdata('success', lang('streams:view_options_update_success'));
        }
        
        redirect('admin/lists/lists/');
    }

    /**
     * delete a List - deletes the stream and Db table
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
