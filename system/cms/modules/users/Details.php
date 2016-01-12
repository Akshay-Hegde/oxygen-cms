<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Users Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Users
 */
class Module_Users extends Module {

    public $version = '1.0.0';

	public function info()
	{
		$info = 
		[
			'name' => 
			[
				'en' => 'Users',
			],
			'description' => 
			[
				'en' => 'Let users register and log in to the site, and manage them via the control panel.',
			],
			'frontend' 	=> false,
			'backend'  	=> true,
			'menu'	  	=> false,
			'roles'		=> 
			[
				'admin_profile_fields'
			],
			'icon'		=> 'fa fa-user',
		];
 		
		if (function_exists('group_has_role'))
		{
			if(group_has_role('users', 'admin_profile_fields'))
			{
				$info['sections'] = 
				[
					'users' => 
					[
						'name' 	=> 'user:list_title',
						'uri' 	=> 'admin/users',
						'shortcuts' => 
						[
							'newuser' => 
							[
								'name' 	=> 'user:add_title',
								'uri' 	=> 'admin/users/create',
							],												
						]
					],
					'fields' => 
					[
						'name' 	=> 'user:profile_fields_label',
						'uri' 	=> 'admin/users/fields',
						'shortcuts' => 
						[
							'create' => 
							[
								'name' 	=> 'user:add_field',
								'uri' 	=> 'admin/users/fields/create',
								'class' => ''
							]
						]
					]
				];
			}
		}

		return $info;
	}

    public function admin_menu(&$menu)
    {

		$menu['lang:cp:nav_users']['menu_items'][] =
		[
			'name' 			=> 'lang:global:new_user',
			'uri' 			=> 'admin/users/create',
			'icon' 			=> 'fa fa-fw fa-user-plus',
			'permission' 	=> '',
		];
		$menu['lang:cp:nav_users']['menu_items'][] =
		[
			'name' 			=> 'Users',
			'uri' 			=> 'admin/users',
			'icon' 			=> 'fa fa-user',
			'permission' 	=> '',
		];

		if (function_exists('group_has_role'))
		{
			if(group_has_role('users', 'admin_profile_fields'))
			{

				$menu['lang:cp:nav_users']['menu_items'][] =
				[
					'name' 			=> 'lang:user:profile_fields_label',
					'uri' 			=> 'admin/users/fields',
					'icon' 			=> 'fa fa-ellipsis-v',
					'permission' 	=> '',
				];
			}

		}
    }


	/**
	 * Installation logic
	 *
	 * This is handled by the installer only so that a default user can be created.
	 *
	 * @return boolean
	 */
	public function install()
	{
		return false;
	}

	public function uninstall()
	{
		return false;
	}

	private function install_ua_table()
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

}