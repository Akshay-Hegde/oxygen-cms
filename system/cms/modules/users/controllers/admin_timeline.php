<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * Oxygen-CMS 
 *
 * @author Sal McDonald (2013-2016)
 *
 * @package OxygenCMS\Core\
 *
 *
 * @copyright  Copyright (c) 2013-2016
 * @copyright  Oxygen-CMS
 * @copyright  oxygen-cms.com
 * @copyright  Sal McDonald
 *
 * @contribs PyroCMS Dev Team, PyroCMS Community, Oxygen-CMS Community
 *
 */

class Admin_timeline extends Admin_Controller
{

	// Define Section
	protected $section = 'users';
	private $data;

	/**
	 * @constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->data = new ViewObject();

		$this->load->library('timeline_library');

	}

	public function index($user_id=0)
	{

		$timeline = $this->timeline_library->getTimelineData($user_id);

		$this->template->title($this->module_details['name'])
			->enable_parser(true)	
			->set('timelineData', $timeline )
			->build('admin/timeline/customer');			
	}


}