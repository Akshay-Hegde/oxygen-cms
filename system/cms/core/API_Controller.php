<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * Shared logic and data for all CMS controllers
 *
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 * @package OxygenCMS\Core\Controllers
 *
 */
class API_Controller extends REST_Controller
{
	/**
	 * Let the CodeIngiter instance know of the current_user. 
	 */
	public function __construct()
	{
		parent::__construct();

		get_instance()->current_user = $this->current_user = $this->rest->user_id ? $this->ion_auth->get_user($this->rest->user_id) : null;
	}
	
	/**
	 * Check that the API is enabled
	 */
	public function early_checks()
	{
		if ( ! Settings::get('api_enabled'))
		{
			$this->response( array('status' => false, 'error' => 'This API is currently disabled.'), 505 );
			exit;
		}
	}
}