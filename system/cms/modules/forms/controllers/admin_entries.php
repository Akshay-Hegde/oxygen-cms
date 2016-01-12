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
class Admin_entries extends Admin_Controller
{

	protected $section = 'entries';

	/**
	 * Sole constructor
	 */
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

	public function view( $list_slug = 'list_slug' ) 
	{

        // Get the stream
		$this->data->stream = $this->streams->streams->get_stream( $list_slug ,'forms');

		$pagination_uri = null;
		$pagination = null;

		$view_override = true;
		$extra = [];

		$extra['buttons']	=
		[
			[
				'label' 	=> lang('global:view'),
				'url'		=> 'admin/forms/entries/item/-entry_id-/'.$list_slug,
				'confirm'	=> false
			],
			[
				'label' 	=> lang('global:delete'),
				'url'		=> 'admin/forms/entries/delete/-entry_id-/'.$list_slug,
				'confirm'	=> true
			]
		];

		$this->streams->cp->entries_table($list_slug, $this->namespace, $pagination , $pagination_uri, $view_override, $extra);
	}


	/**
	 * View entry of a List
	 */
	public function item($entry_id, $stream_slug='') 
	{

		$this->data->stream = $this->streams->streams->get_stream( $stream_slug ,'forms');

		$extra = 
		[
			'return' 			=> $this->refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
		    'cancel_url'		=> $this->refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
			'success_message' 	=> $this->lang->line('streams:new_entry_success'),
			'failure_message'	=> $this->lang->line('streams:new_entry_error')
		];

		$hidden 		=  [];
		$defaults 		=  [];
		$tabs 			= false;
		$skips 			= [];

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

		 redirect('admin/forms/entries/view/'.$stream_slug);
	}
}