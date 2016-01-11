<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 */
class Sites_Controller extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		// Site locations
		get_instance()->site_locations = $this->site_locations = 
		[
			'addons' => 
			[
				'modules',
				'widgets',
				'themes',
			],
			'config'	=> 
			[

			],	
			'cache'	=> 
			[

			],							
			'files'	=> 
			[

			],		
		];
	}
}