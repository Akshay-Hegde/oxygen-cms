<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * OxygenCMS
 * 
 * Groups module
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 * @package 	OxygenCMS\Core\Modules\Groups
 *
 */
 class Module_Groups extends Module
{

	public $version = '1.0.0';

	public function info()
	{
		return 
		[
			'name' => 
			[
				'en' => 'Groups',
			],
			'description' => 
			[
				'en' => 'Users can be placed into groups to manage permissions.',
			],
			'frontend' => false,
			'backend' => true,
			'menu' => false,
			'icon'		=> 'fa fa-users',
			'sections' => 
			[
				'groups' => 
				[
					'name' 	=> 'groups:user_groups',
					'uri' 	=> 'admin/groups',
					'shortcuts' => 
					[
						'create' => 
						[
							'name' 	=> 'groups:add_title',
							'uri' 	=> 'admin/groups/add',
							'modal' => true,
						]
					]
				]
			]			

		];
	}

    public function admin_menu(&$menu)
    {

		$menu['lang:cp:nav_users']['menu_items'][] =
		[
			'name' 			=> 'Groups',
			'uri' 			=> 'admin/groups',
			'icon' 			=> 'fa fa-users',
			'permission' 	=> '',
		];
	}

	public function install()
	{
		$this->dbforge->drop_table('users_groups');

		$tables = 
		[
			'users_groups' => 
			[
				'id' 			=> 	['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,],
				'name' 			=> 	['type' => 'VARCHAR', 'constraint' => 100,],
				'description' 	=>  ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true,],
				'authority' 	=> 	['type' => 'INT', 'constraint' => 4, 'default' => 10, 'null'=>false],
			],
		];

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		$groups = 
		[
			['name' => 'admin', 			'description' => 'Administrator',	'authority' => 0],			
			//['name' => 'content-editor', 	'description' => 'User',			'authority' => 5],				
			['name' => 'user', 				'description' => 'User',			'authority' => 10],
		];

		foreach ($groups as $group)
		{
			if ( ! $this->db->insert('users_groups', $group))
			{
				return false;
			}
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