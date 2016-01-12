<?php defined('BASEPATH') or exit('No direct script access allowed');


class Plugin_Forms extends Plugin
{

	public $version = '1.0.0';

	public $name = 
	[
		'en' => 'Forms Plugin',
	];

	public $description = 
	[
		'en' => 'Display custom forms on your site anywhere',
	];


	public function __construct(){	}

	public function display()
	{
		$params 				= [];
		$this->namespace		= 'forms';
		$this->view_layout		= 'default'; // <form name="{{form_name}}" > {{body}} </form>

		$this->stream_slug		= $this->attribute('slug','');

		// first get the stream
		$this->stream = $this->streams_m->get_stream($this->stream_slug, true, $this->namespace);

		//see if we have the handle
		if(!$this->stream)
		{
			return '';
		}

		$meta_row = $this->db->where('form_stream_id',$this->stream->id)->limit(1)->get('forms')->row();

		$this->redirect_error	= $meta_row->redir_success;
		$this->redirect_success	= $meta_row->redir_error;
		$this->success_message	= $meta_row->msg_success; 
		$this->error_message	= $meta_row->msg_error; 

		
		return $this->_process($params);
	}


	protected function _process( array $params )
	{
		// If we dont have a stream/form, we still want to produce, dont display the content
		if ( ! $this->stream)
		{
			return '';	
		}

		$extra = 
		[
			'return' 			=> $this->redirect_success,
		    'cancel_url'		=> $this->redirect_error,
			'success_message' 	=> $this->success_message,
			'failure_message'	=> $this->error_message,
		];


		$hidden 		=  [];
		$defaults 		=  [];
		$skips 			= []; 
		$plugin 		= false;

		$stream_fields = $this->streams_m->get_stream_fields($this->stream->id);
		$this->fields->run_field_events($stream_fields, [], []);
		$fields = $this->fields->build_fields($stream_fields, [], false, 'create', [], null);


		$return_fields = [];

		if($fields==null)
			return '';

		foreach($fields as $field)
		{

			$return_fields[] = [ 'form_field_label' => $field['input_title'], 'form_field' => $field['input'] ];
		}

		return $this->make_form($return_fields);

	}

	private function make_form($return_fields=[])
	{
		//forms/entries/create/'.$this->stream_slug.'

		return 
		[	
			[
				'form_start'  	=> '<form name="'.$this->stream_slug.'" action="#" method="post">
									<input type="hidden" name="forms_0xyg3n" value="'.$this->stream_slug.'">
									<input type="hidden" name="forms_redirect_success" value="'.$this->redirect_success.'">
									<input type="hidden" name="redirect_error" value="'.$this->redirect_error.'">
									<input type="hidden" name="forms_send_email" value="true">',
				'form_fields'	=> $return_fields,
				'form_slug'  	=> $this->stream_slug,
				'form_end'  	=> '</form>', 
			]
		];

	}

	public function start()
	{
		$this->form_name	= $this->attribute('name','myform');
		$this->form_action	= $this->attribute('action','#');
		$this->form_method	= $this->attribute('method','post');

		return '<form name="'.$this->form_name.'" action="'.$this->form_action.'" method="'.$this->form_method.'">';
	}

	public function end()
	{
		return '</form>';
	}
}