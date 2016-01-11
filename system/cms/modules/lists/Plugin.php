<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
	{{stream:flow namespace='banners' slug='about-page-banner'  [... options ...] }}
		...

	{{list:items slug='about-page-banner' [... options ...] }}
		...		
*/

if(!class_exists("Plugin_Streams"))
{
	require_once APPPATH.'modules/streams/Plugin.php';
}
class Plugin_Lists extends Plugin_Streams
{

	public $version = '1.0.0';

	public $name = 
	[
		'en' => 'Lists Plugin',
	];

	public $description = 
	[
		'en' => 'Get List information',
	];


	public function __construct()
	{
		parent::__construct();
		$this->load->config('lists/lists');
		$this->namespace = 'lists';

	}

	/**
	 * The default is with meta=yes where streams/flows is no by default
	 */

	/*

		{{lists:items slug=links.list_slug }}
			{{if exists =='yes' }}
				<div class='row'>
					{{results}}
						{{image:thumb_img}}
					{{/results}}
				</div>
			{{else}}
			Some html when no existing
			{{endif}}
		{{/lists:items }}
	*/
	public function items()
	{

		$this->_where			= 'onoff_status=1|'; 
		//$this->_where			.= $this->attribute('where', '' );

		$this->field_prefix		= $this->attribute('prefix','');
		$this->stream_slug		= $this->attribute('slug','');
		$this->_display			= $this->attribute('display','');

		$this->with_meta 		= strtolower(trim($this->attribute('with_meta', 'yes')));

		//init after we have some info
		$this->init();

		return $this->_flow([]);
	
	}

	
}