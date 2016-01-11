<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Admin controller for field types.
 *
 * @package   PyroCMS\Core\Modules\Addons\Controllers
 * @author    PyroCMS Dev Team
 * @copyright Copyright (c) 2012, PyroCMS LLC
 */
class Admin_field_types extends Admin_Controller
{

	/** @var string The current active section */
	protected $section = 'field_types';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->language('addons');
	}

	/**
	 * Index method
	 * 
	 * Lists all plugins.
	 */
	public function index()
	{
		
		$data = [];

		$this->load->driver('Streams');

		foreach ($this->type->types as $type)
		{
			$data[$type->ft_mode][] = 
			[
				'name'		=> $type->field_type_name,
				'version'	=> (isset($type->version)) ? $type->version : null
			];
		}

		// Create the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/field_types/index', $data);
	}

	/**
	 * Remap based on URL call
	 */
	public function info($type)
	{
		
		$this->load->library('streams/Type');
	
		$field_type = $this->type->load_single_type($type);

		$this->template
			->set('field',$field_type)
			->build('admin/field_types/info');
	}
}
