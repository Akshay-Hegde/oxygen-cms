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
class Entries extends Admin_Controller
{

	protected $section = 'entries';


	/**
	 * Sole constructor
	 */
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

	public function view( $list_slug = 'list_slug' ) 
	{

        // Get the stream
		$this->data->stream = $this->streams->streams->get_stream( $list_slug ,'lists');

		//add a shortcut
		$this->_sections($list_slug);


		$pagination_uri = null;
		$pagination = null;

		$view_override = false;
		$extra = [];

		$extra['title'] = $this->data->stream->stream_name.' (View &rarr; Entries)';

		$extra['buttons']	=
		[
			[
				'label' 	=> lang('global:edit'),
				'url'		=> 'admin/lists/entries/edit/-entry_id-/'.$list_slug,
				'confirm'	=> false
			],
			[
				'label' 	=> lang('global:delete'),
				'url'		=> 'admin/lists/entries/delete/-entry_id-/'.$list_slug,
				'confirm'	=> true
			]
		];

		$html = $this->streams->cp->entries_table($list_slug, $this->namespace, $pagination , $pagination_uri, $view_override, $extra);
		$this->template
			->set('title',$extra['title'])
			->set('list_slug',$list_slug)
			->set('list',$this->data->stream)
			->build('admin/entries/list_entries',['html'=>$html]);

	}


	/**
	 * View entry of a List
	 */
	public function _view($stream_slug='') 
	{
	}


	/**
	 * Add entry to List
	 */
	public function create($stream_slug='') 
	{

		$this->data->stream = $this->streams->streams->get_stream( $stream_slug ,'lists');

		$extra = 
		[
			'return' 			=> 'admin/lists/entries/view/'.$stream_slug,
		    'cancel_url'		=> 'admin/lists/entries/view/'.$stream_slug,
			'success_message' 	=> $this->lang->line('streams:new_entry_success'),
			'failure_message'	=> $this->lang->line('streams:new_entry_error')
		];

		if($v = $this->input->post('btnAction'))
		{
			if($v =='save_another') $extra['return'] = 'admin/lists/entries/create/'.$stream_slug;
		}

		$hidden 		=  ['List'];
		$defaults 		=  [];
		$tabs 			= false;
		$skips 			= []; 

		// Title
		$extra['title'] = ''.$this->data->stream->stream_name.' &rarr; '.lang('streams:new_entry');

		$result = $this->streams->cp->entry_form($stream_slug, $this->namespace, 'new', null, true, $extra,$skips,$tabs,$hidden,$defaults);	
	}


	public function edit($entry_id, $stream_slug = 'list_slug') 
	{

		//add a shortcut
		$this->_sections($stream_slug);

		$this->data->stream = $this->streams->streams->get_stream( $stream_slug ,'lists');

		$extra = 
		[
			'return' 			=> 'admin/lists/entries/view/'.$stream_slug,
		    'cancel_url'		=> 'admin/lists/entries/view/'.$stream_slug,
			'success_message' 	=> $this->lang->line('streams:new_entry_success'),
			'failure_message'	=> $this->lang->line('streams:new_entry_error')
		];

		// Do they want another entry
		if($v = $this->input->post('btnAction'))
		{
			if($v =='save_another') 
				$extra['return'] = 'admin/lists/entries/create/'.$stream_slug;
		}

		$hidden =  [];
		$defaults =  [];
		$tabs = false;
		$skips = []; 

		// Title
		$extra['title'] = ''.$this->data->stream->stream_name.' &rarr; '.lang('streams:new_entry');

		$this->streams->cp->entry_form($stream_slug, $this->namespace, 'edit', $entry_id, true, $extra,$skips,$tabs,$hidden,$defaults);	
	}

	/**
	 * remove entry from List
	 */
	public function delete($entry_id,$stream_slug='') 
	{
		 if($this->streams->entries->delete_entry($entry_id, $stream_slug, $this->namespace)) 
		 {
		 	$this->session->set_flashdata('success','Entry removed');
		 }
		 else 
		 {
			$this->session->set_flashdata('error','Failed to delete entry');
		 }

		 redirect('admin/lists/entries/view/'.$stream_slug);
	}

	/**
	 * create the shortcut and section for the List requested
	 */
	private function _sections($stream_slug) 
	{

		$shortcuts = 
		[
		    ['name' => 'lists:new_entry', 'uri' => 'admin/lists/entries/create/'.$stream_slug,'class' => ''], 
		    ['name' => 'lists:fields', 'uri' => 'admin/lists/admin_fields/listing/'.$stream_slug,'class' => ''], 



		];

		//add a section dynamically
        add_template_section($this,'entries','Entries','admin/lists/entries/view/'.$stream_slug,$shortcuts); 
	}	
	
}
