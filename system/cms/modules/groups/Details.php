<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Groups module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Groups
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
			'shortcuts' => [],
			'icon'		=> 'fa fa-users',
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
			['name' => 'admin', 			'description' => 'Administrator','authority' => 0],
			['name' => 'user', 				'description' => 'User','authority' => 10],
			//['name' => 'content-editor', 	'description' => 'Content Editor',],
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