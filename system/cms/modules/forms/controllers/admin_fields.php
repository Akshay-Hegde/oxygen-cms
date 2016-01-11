<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * OxygenCMS
 * 
 * manage fields of the main List table
 * All forms must have the same field structure
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 * @package     
 */
class Admin_fields extends Admin_Controller
{

	protected $section = 'admin_fields';


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

    /**
     * list all the fields in the namespace
     */
    public function index() 
    {

        $pagination = null;
        $pagination_uri = null;
        $view_override = false;
        $extra = [];
        $skips = [];
        $table = $this->streams->cp->fields_table(
            $this->namespace, $pagination, 
            $pagination_uri, $view_override, 
            $extra, $skips);

        $this->template->set('table',$table)->build('admin/fields/index');
    }

    /**
     * List all fields in the stream
     */
    public function listing($stream_slug = 'forms')  
    {

        $this->_field_sections($stream_slug);

        $extra = [];
        $extra['title'] = 'List Fields';

        $extra['buttons'] = 
        [
            [
                'label'     => lang('global:edit'),
                'url'       => 'admin/forms/admin_fields/edit/-assign_id-/'.$stream_slug,
                'locked'    => false,
            ],
            [
                'label'     => lang('global:delete'),
                'url'       => 'admin/forms/admin_fields/delete/-assign_id-/'.$stream_slug,
                'confirm'   => true,
                'locked'    => true,
            ]
        ];

        $skips = [];

        $pagination_uri = null;
        $pagination = null;
        $view_override=true;
        $this->streams->cp->assignments_table($stream_slug, $this->namespace, $pagination, $pagination_uri, $view_override , $extra, $skips);
    }

    public function create($stream_slug = 'forms') {

        $this->_field_sections($stream_slug);

        $extra                  = [];
        $extra['title']         = lang('streams:edit_field');
        $extra['show_cancel']   = true;

        $extra['cancel_uri']    = 'admin/forms/admin_fields/listing/'.$stream_slug;
        $return                 = 'admin/forms/admin_fields/listing/'.$stream_slug;

        $include_types          = [];
        $view_override          = true;

        $this
            ->streams
            ->cp
            ->field_form($stream_slug, $this->namespace, 'new', $return, null, $include_types, $view_override, $extra);
    }


    public function edit( $assign_id = 0, $stream_slug='list_slug' ) 
    {

        $this->_field_sections($stream_slug);

        $extra                  = [];
        $extra['title']         = lang('streams:edit_field');
        $extra['show_cancel']   = true;
        $extra['cancel_uri']    = 'admin/forms/admin_fields/listing/'.$stream_slug;

        $return                 = 'admin/forms/admin_fields/listing/'.$stream_slug;
        $include_types          = [];
        $view_override          = true;

        $this
            ->streams
            ->cp
            ->field_form($stream_slug, $this->namespace, 'edit', $return, $assign_id, $include_types, $view_override, $extra);
    }


    public function assign( $stream_slug='list_slug' ) 
    {

        // Get stream by slug
        $this->data->stream = $this->streams->streams->get_stream( $stream_slug ,$this->namespace );

        $this->data->method = 'new';
        
        $this->data->title_column_status = FALSE;
        

        if ($this->_manage_fields() == 'no_fields') 
        {
            return;
        }
        
        // Get fields that are available
        // Need to have the null/null so to tell UI we have 1 extra field
        $this->data->available_fields = [null => null];
        
        //
        // Check to make sure the field is not already used.
        //
        if ($this->data->fields)
        {
            foreach ($this->data->fields as $field)
            {
                if ( ! in_array($field->id, $this->data->in_use))
                {
                    $this->data->available_fields[$field->id] = $field->field_name;
                }
            }
        }

        $this->data->row = new stdClass();
        $this->data->row->field_id = null;
        

        if ($input = $this->input->post())
        {
            $this->_post_new_assignment($this->data->stream,$input);
        }

        $this->template->build('admin/fields/assign_new', $this->data);
    }

    private function _post_new_assignment($stream,$input)
    {

        if ($this->form_validation->run())
        {
            if ( $this->streams_m->add_field_to_stream( $input['field_id'], $stream->id, $input ))
            {
                $this->session->set_flashdata('success', lang('streams:stream_field_ass_add_success')); 
            }
            else
            {
                $this->session->set_flashdata('notice', lang('streams:stream_field_ass_add_error'));    
            }
    
            redirect('admin/forms/admin_fields/listing/'.$stream->stream_slug);
        }   
    }

    public function delete( $field_assign_id =0, $list_slug='' ) {


        // Get stream by slug
        $this->data->stream = $this->streams->streams->get_stream( $list_slug ,$this->namespace );

        //
        // Get field assignment
        //
        $assignment = $this->db->where('id', $field_assign_id)->get(ASSIGN_TABLE)->row();
        if( ! $assignment ) 
        {
            show_error(lang('streams:cannot_find_assign'));
        }

        $field = $this->fields_m->get_field( $assignment->field_id );

        if( ! $this->streams_m->remove_field_assignment($assignment, $field, $this->data->stream)  )
        {
            $this->session->set_flashdata('notice', lang('streams:remove_field_error'));
        }
        else
        {
            $this->session->set_flashdata('success', lang('streams:remove_field_success'));
        }

        redirect('admin/forms/admin_fields/listing/'.$list_slug);        
    }


    /**
     * create the shortcut and section for the List requested
     */
    private function _field_sections($stream_slug = 'forms') {

        $shortcuts = 
        [
            ['name' => 'forms:create_field', 'uri' => 'admin/forms/admin_fields/create/'.$stream_slug,'class' => ''], 
            ['name' => 'forms:assign_field', 'uri' => 'admin/forms/admin_fields/assign/'.$stream_slug,'class' => ''], 
        ];
        add_template_shortcuts($this,$this->section,$shortcuts);
    }   


    private function _manage_fields()
    {

        // Get list of available fields
        $this->data->fields = $this->fields_m->get_fields($this->namespace);
        
        // No fields? Show a message.       
        if (count($this->data->fields) == 0)
        {
            $this->template->build('admin/flows/no_fields_to_add', $this->data);            
            return 'no_fields';
        }
        
        // Get an array of field IDs that are already in use
        // So we can disable them in the drop down
        $obj = $this->db->where('stream_id', $this->data->stream->id)->get(ASSIGN_TABLE);
        
        $this->data->in_use = [];
        
        foreach ($obj->result() as $item)
        {
            $this->data->in_use[] = $item->field_id;
        }

        // Get if available
        $input = $this->input->post();
        
        // Validation & Setup
        $validation = 
        [
            [
                'field' => 'field_id',
                'label' => 'Field',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'is_required',
                'label' => 'Is Required',
                'rules' => 'trim'
            ],
            [
                'field' => 'is_unique',
                'label' => 'Is Unique',
                'rules' => 'trim'
            ],
            [
                'field' => 'instructions',
                'label' => 'Instructions',
                'rules' => 'trim'
            ]
        ];
        
        $this->form_validation->set_rules($validation);

        $this->data->values = new stdClass();
        
        foreach($validation as $valid)
        {
        
            $key = $valid['field'];
            
            // Get the data based on the method
            if( $this->data->method == 'edit' )
            {
                $current_value = $this->data->row->$key;
            }
            else
            {
                $current_value = $this->input->post($key);
            }
                        
            // Set the values
            if( $key == 'is_required' or $key == 'is_unique' )
            {
                $this->data->values->$key = ( $current_value == 'yes' ) ? true : false ;
            }
            else
            {
                $this->data->values->$key = set_value($key, $current_value);
            }
            
            $key = null;
        
        }
    }


}
