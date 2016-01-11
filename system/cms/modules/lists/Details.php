<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Module_Lists extends Module
{

	public $version = '1.0.0';

	public function __construct()
	{
		$this->ci = get_instance();

        // Set our namespace
	    $this->namespace = $this->ci->config->item('lists:namespace');
	}


	public function info()
	{

		$info =  
		[
			'name' => 
			[
				'en' => 'Lists',
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
			'icon'			=> 'fa fa-bars',
			'roles' 		=> 
			[
				'admin_lists',
				'manage',
			],
			'sections' 		=> 
			[
				'lists' 	=> 
				[
					'name' => 'All Lists',
					'uri' 	=> 'admin/lists',
					'shortcuts' => 
					[
						[
							'name' 	=> 'lists:create',
							'uri'	=> 'admin/lists/lists/create'
						]
					]
				],	
			]
		];

		return $info;

	}

	/*
	 * The menu is handled by the main SHOP module
	 */
	public function admin_menu(&$menu)
	{

		$menu['lang:cp:nav_content']['menu_items'][] = 
			[
				'name' 			=> 'Lists',
				'uri' 			=> 'admin/lists/lists',
				'icon' 			=> 'fa fa-bars',
				'permission' 	=> '',
				'menu_items'	=> 
				[
					[
						'name' 			=> 'Add List',
						'uri' 			=> 'admin/lists/lists/create',
						'icon' 			=> 'fa fa-plus',
						'permission' 	=> '',
						'menu_items'	=> [],
					],					
					[
						'name' 			=> 'All Lists',
						'uri' 			=> 'admin/lists/lists',
						'icon' 			=> 'fa fa-bars',
						'permission' 	=> '',
						'menu_items'	=> [],
					],
				
				],
			];
	
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