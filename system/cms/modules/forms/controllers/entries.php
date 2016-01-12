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
class Entries extends Public_Controller
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


	/**
	 * Add entry to List
	 */
	public function create($stream_slug='') 
	{
		if(!$this->input->post())
		{
			$this->refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
			redirect($this->refer);
		}

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

		$this->streams->cp->entry_form($stream_slug, $this->namespace, 'new', null, true, $extra,$skips,$tabs,$hidden,$defaults);	

	}
}