<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 *
 * Navigation Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Navigation
 */
class Module_Navigation extends Module {
	
	public $version = '1.0.0';

	public function info()
	{
		return 
		[
			'name' 		=> 
			[
				'en' 	=> 'Navigation',
			],
			'description' => 
			[
				'en' 	=> 'Manage links on navigation menus and all the navigation groups they belong to.',
			],
			'frontend' 	=> false,
			'backend'  	=> true,
			'menu'	  	=> false,
			'icon'		=> 'fa fa-hand-o-right',
			'sections' 		=> 
			[
				[
					'name' => 'All Groups',
					'uri' 	=> 'admin/navigation',
					'shortcuts' => 
			    	[
					    'name' 	=> 'Create',
					    'uri' 	=> 'admin/navigation/groups/create',    	
			    	]
				],
			],
	
		];
	}

	public function admin_menu(&$menu)
	{
		$menu['lang:cp:nav_content']['menu_items'][] = 
			[
				'name' 			=> 'lang:cp:nav_links',
				'uri' 			=> 'admin/navigation',
				'icon' 			=> 'fa fa-hand-o-right',
				'permission' 	=> '',
				'menu_items'	=> [],
			];

	}
	
	public function install()
	{
		$this->dbforge->drop_table('navigation_groups');
		$this->dbforge->drop_table('navigation_links');

		$tables = 
		[
			'navigation_groups' => 
			[
				'id' 		=> ['type' => 'INT', 		'constraint' => 11, 'auto_increment' => true, 'primary' => true],
				'title' 	=> ['type' => 'VARCHAR', 	'constraint' => 50],
				'slug' 	=> ['type' => 'VARCHAR', 	'constraint' => 50, 'key' => true],
				'order'		=> ['type' => 'INT', 		'constraint' => 5, 	'default' 	=> 0],				
			],
			'navigation_links' => 
			[
				'id' 					=> ['type' => 'INT', 		'constraint' => 11, 	'auto_increment' => true, 'primary' => true,],
				'navigation_group_id' 	=> ['type' => 'INT', 		'constraint' => 11, 	'default' 	=> 1,'null'=>true],
				'title' 				=> ['type' => 'VARCHAR', 	'constraint' => 100, 	'default' 	=> '',],
				'parent' 				=> ['type' => 'INT', 		'constraint' => 11, 	'null' 		=> true,],
				'link_type' 			=> ['type' => 'VARCHAR', 	'constraint' => 20, 	'default' 	=> 'uri',],
				'page_id' 				=> ['type' => 'INT', 		'constraint' => 11, 	'null' 		=> true,],
				'module_name' 			=> ['type' => 'VARCHAR', 	'constraint' => 50, 	'default' 	=> '',],
				'url' 					=> ['type' => 'VARCHAR', 	'constraint' => 255, 	'default' 	=> '',],
				'uri' 					=> ['type' => 'VARCHAR', 	'constraint' => 255, 	'default' 	=> '',],
				'position' 				=> ['type' => 'INT', 		'constraint' => 5, 		'default' 	=> 0,],
				'target' 				=> ['type' => 'VARCHAR', 	'constraint' => 10, 	'null' 		=> true,],
				'restricted_to' 		=> ['type' => 'VARCHAR', 	'constraint' => 255, 	'null' 		=> true,],
				'class' 				=> ['type' => 'VARCHAR', 	'constraint' => 255, 	'default' 	=> '',],
				'data' 					=> ['type' => 'VARCHAR', 	'constraint' => 255, 	'default' 	=> '',],
				'icon' 					=> ['type' => 'VARCHAR', 	'constraint' => 255, 	'default' 	=> '',],
			],
		];
		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		$groups = 
		[
			['title' => 'Header', 'slug' => 'header', 'order' => 1],
			['title' => 'Footer', 'slug' => 'footer', 'order' => 2],
		];
		
		foreach ($groups as $group)
		{
			if ( ! $this->db->insert('navigation_groups', $group))
			{
				return false;
			}
		}

		//404 is the 5 index
		$links = 
		[
			['title' => 'Home'	 , 'link_type' => 'page'	, 'page_id' => 1 	, 'navigation_group_id' => 1, 'position' => 1,],
			['title' => 'About'	 , 'link_type' => 'page'	, 'page_id' => 3 	, 'navigation_group_id' => 1, 'position' => 4,],
			['title' => 'Contact', 'link_type' => 'page'	, 'page_id' => 4 	, 'navigation_group_id' => 1, 'position' => 5,],
			['title' => 'Home'	 , 'link_type' => 'page'	, 'page_id' => 1 	, 'navigation_group_id' => 3, 'position' => 1,],
			['title' => 'About'	 , 'link_type' => 'page'	, 'page_id' => 3 	, 'navigation_group_id' => 3, 'position' => 2,],
		];
		foreach ($links as $link)
		{
			if ( ! $this->db->insert('navigation_links', $link))
			{
				return FALSE;
			}
		}

		// Now convert the table to a stream, not the existing fields, just so that extra fields can be added
		$this->load->driver('Streams');

		if ( ! $this->streams->utilities->convert_table_to_stream('navigation_links', 'navigation', null, 'Navigation', 'Customizable navigation links', 'title', array('title')))
		{
			return false;
		}


		return TRUE;
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