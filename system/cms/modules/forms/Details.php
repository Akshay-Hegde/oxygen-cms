<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Module_Forms extends Module
{

	public $version = '1.0.0';

	public function __construct()
	{
		$this->ci = get_instance();

        // Set our namespace
	    $this->namespace = $this->ci->config->item('forms:namespace');
	}

	public function info()
	{
		$info =  
		[
			'name' => 
			[
				'en' => 'Forms',
			],
			'description' => 
			[
				'en' => 'User defined Flows for the OxygenCMS platform',
			],
			'clean_xss' 	=> false,
			'frontend' 		=> true,
			'backend' 		=> true,
			'menu' 			=> false,
			'author' 		=> 'Sal McDonald',
			'icon'			=> 'fa fa-dot-circle-o',
			'roles' 		=> 
			[
				'view_entries','admin_create',
			],
			'sections' 		=> 
			[
				'forms' 	=> 
				[
					'name' 			=> 'All Forms',
					'uri' 			=> 'admin/forms',
					'shortcuts' 	=> [],
				],
		
			]
		];

		$info['sections']['admin_fields'] = 
		[
			'name' => 'Fields',
			'uri' => 'admin/forms/admin_fields',
			'shortcuts' => []
		];	

		return $info;
	}

	/*
	 * The menu is handled by the main SHOP module
	 */
	public function admin_menu(&$menu)
	{

		$all_forms = 
		[
			'name' 			=> 'Forms',
			'uri' 			=> 'admin/forms/forms',
			'icon' 			=> 'fa fa-dot-circle-o',
			'permission' 	=> '',
			'menu_items'	=> [],
		];

		if(group_has_role('forms','view_entries') AND (!group_has_role('forms','admin_create')))
		{
			$menu['lang:cp:nav_content']['menu_items'][] = $all_forms;
			return;
		}

		if(group_has_role('forms','admin_create'))
		{
			$all_forms['menu_items'][] =
			[
				'name' 			=> 'Add Form',
				'uri' 			=> 'admin/forms/forms/create',
				'icon' 			=> 'fa fa-plus',
				'permission' 	=> '',
				'menu_items'	=> [],
			];		
		}

		if(group_has_role('forms','view_entries'))
		{

			$all_forms['menu_items'][] =
			[
				'name' 			=> 'All Forms',
				'uri' 			=> 'admin/forms/forms',
				'icon' 			=> 'fa fa-dot-circle-o',
				'permission' 	=> '',
				'menu_items'	=> [],
			];
		}


		$menu['lang:cp:nav_content']['menu_items'][] = $all_forms;	
	}

	public function install()
	{
		return false;
	}

	public function uninstall()
	{
		return false;
	}

	public function upgrade($old_version)
	{
		return false;
	}

    public function disable() 
    {
        return true;
    }
    
    public function enable() 
    { 
        return true;
    }

	public function help()
	{
		return "No documentation has been added for this module.<br>Contact the module developer for assistance.";
	}
}
/* End of file Details.php */