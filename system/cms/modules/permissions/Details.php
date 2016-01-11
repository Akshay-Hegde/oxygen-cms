<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Permissions Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Permissions
 */
class Module_Permissions extends Module {

	public $version = '1.0.1';

	public function info()
	{
		return 
		[
			'name' => 
			[
				'en' 		=> 'Permissions',
			],
			'description' 	=> 
			[
				'en' 		=> 'Control what type of users can see certain sections within the site.',
			],
			'frontend' 		=> false,
			'backend'  		=> true,
			'menu'	  		=> false,
			'icon' 			=> 'fa fa-ban',
		];
	}



    public function admin_menu(&$menu)
    {

		$menu['lang:cp:nav_users']['menu_items'][] =
		[
			'name' 			=> 'Permissions',
			'uri' 			=> 'admin/permissions',
			'icon' 			=> 'fa fa-ban',
			'permission' 	=> '',
		];
	}


	public function install()
	{
		$this->dbforge->drop_table('permissions');

		$tables = 
		[
			'permissions' => 
			[
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'group_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'module' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'roles' => array('type' => 'TEXT', 'null' => true,),
			],
			//if the user_group has no perm but the user does, allow them
			'permissions_users' => 
			[
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'user_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'module' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'roles' => array('type' => 'TEXT', 'null' => true,),
			],			
		];

		if ( ! $this->install_tables($tables))
		{
			return false;
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
		$tables = 
		[
			//if the user_group has no perm but the user does, allow them
			'permissions_users' => 
			[
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'user_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'module' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'roles' => array('type' => 'TEXT', 'null' => true,),
			],			
		];

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

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