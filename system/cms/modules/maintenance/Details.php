<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Maintenance Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Maintenance
 */
class Module_Maintenance extends Module
{

	public $version = '1.0.0';

	public function info()
	{
		return 
		[
			'name' => 
			[
				'en' => 'Maintenance',
			],
			'description' 	=> 
			[
				'en' 		=> 'Manage the site cache and export information from the database.',
			],
			'frontend' 		=> false,
			'backend' 		=> true,
			'menu' 			=> false,
			'icon'          => 'fa fa-wrench',
			'sections' 		=> 
			[
				'maintenance' => 
				[
					'name' => 'maintenance:title',
					'uri' => 'admin/maintenance/admin',
					'shortcuts' => []
				],
				'importer' => 
				[
					'name' => 'maintenance:importer',
					'uri' => 'admin/maintenance/importer',
					'shortcuts' => []
				],
				'exporter' => 
				[
					'name' => 'maintenance:exporter',
					'uri' => 'admin/maintenance/exporter',
					'shortcuts' => []
				],
				'routes' => 
				[
					'name' => 'maintenance:routes',
					'uri' => 'admin/maintenance/routes',
					'shortcuts' => []
				],																	
			],
		];
	}

	protected $r_routes =
	[
		['name'=>'User Registration',	  'uri'=>'register', 											'dest'=>'users/register',		  'can_change' => 1, 'ordering_count'=> 1, 'module' =>'users'],		
		['name'=>'User Any',			  'uri'=>'user/(:any)', 										'dest'=>'users/view/$1',		  'can_change' => 1, 'ordering_count'=> 2, 'module' =>'users' ],					
		['name'=>'User Profile',		  'uri'=>'my-profile', 											'dest'=>'users/index',			  'can_change' => 1, 'ordering_count'=> 3, 'module' =>'users' ],					
		['name'=>'User Edit prodile',	  'uri'=>'edit-profile', 										'dest'=>'users/edit',			  'can_change' => 1, 'ordering_count'=> 4, 'module' =>'users' ],					
		['name'=>'User Change Password',  'uri'=>'user/change-password', 								'dest'=>'users/change_password',  'can_change' => 1, 'ordering_count'=> 5, 'module' =>'users' ],					
		['name'=>'Sitemap XML',			  'uri'=>'sitemap.xml', 										'dest'=>'sitemap/xml',			  'can_change' => 1, 'ordering_count'=> 6, 'module' =>'core' ],				
		['name'=>'Subscriptions',		  'uri'=>'subscriptions/(:any)?',								'dest'=>'subscriptions/index$1',  'can_change' => 1 , 'ordering_count'=> 7, 'module' =>'subscriptions'],	
	];

    public function admin_menu(&$menu)
    {
        $menu['lang:cp:nav_system']['menu_items'][] = 
        [
            'name'          => 'Maintenance',
            'uri'           => 'admin/maintenance',
            'icon'          => 'fa fa-wrench',
            'permission'    => '',
            'menu_items'    => [],
        ];

        $menu['lang:cp:nav_system']['menu_items'][] = 
        [
            'name'          => 'Routes',
            'uri'           => 'admin/maintenance/routes',
            'icon'          => 'fa fa-bullseye',
            'permission'    => '',
            'menu_items'    => [],
        ];            
    }

	public function install()
	{
		foreach($this->r_routes as $route)
		{
			$route['module'] = isset($route['module'])?$route['module']:'core';
			$route['default_uri'] = $route['uri'];
			$route['created'] = date("Y-m-d H:i:s");
			$route['updated'] = date("Y-m-d H:i:s");
			get_instance()->db->insert('routes',$route);
		}			
		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}


	public function upgrade($old_version)
	{
		return true;
	}
	
    public function disable() 
    {
        return true;
    }
    
    public function enable() 
    { 
        return true;
    }
}
