<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Widgets Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Widgets
 */
class Module_Widgets extends Module {

	public $version = '1.0.0';

	public function info()
	{
		return 
		[
			'name' => 
			[
				'en' => 'Widgets',
			],
			'description' => 
			[
				'en' => 'Manage small sections of self-contained logic in blocks or "Widgets".',
			],
			'frontend' 	=> false,
			'backend'  	=> true,
			'menu'	  	=> false,
			'skip_xss'	=> true,
			'icon' 		=> 'fa fa-cubes',	
			'sections' 	=> 
			[
				'widgets' =>
				[
					'name' => 'Widgets',
					'uri' => 'admin/widgets',				
					'shortcuts' => 
					[
						[
							'name' => 'widgets:all_widgets',
							'uri' => 'admin/widgets',
						]
					],
			
				],
			],	

		];

	}

	public function admin_menu(&$menu)
	{
		$menu['lang:cp:nav_content']['menu_items'][] = 
			[
				'name' 			=> 'Widgets',
				'uri' 			=> 'admin/widgets',
				'icon' 			=> 'fa fa-cubes',
				'permission' 	=> '',
				'menu_items'	=> [],
			];
	}	

	public function install()
	{
		$tables = 
		[
			'widget_areas' => 
			[
				'id' 			=> ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,],
				'name' 			=> ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
				'slug' 			=> ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
				'order' 		=> ['type' => 'INT', 'constraint' => 10, 'default' => 0,],
				'created_on' 	=> ['type' => 'INT', 'constraint' => 11, 'default' => 0,],
				'updated_on' 	=> ['type' => 'INT', 'constraint' => 11, 'default' => 0,],
			],		
			'widget_instances' => 
			[
				'id' 			=> ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,],
				'name' 			=> ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
				'title' 		=> ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true,],
				'description' 	=> ['type' => 'TEXT'],
				'area_id' 		=> ['type' => 'INT', 'constraint' => 11, 'null' => true,],
				'widget_id' 	=> ['type' => 'INT', 'constraint' => 11, 'null' => true,],
				'options' 		=> ['type' => 'TEXT'],
				'order' 		=> ['type' => 'INT', 'constraint' => 10, 'default' => 0,],
				'created_on' 	=> ['type' => 'INT', 'constraint' => 11, 'default' => 0,],
				'updated_on' 	=> ['type' => 'INT', 'constraint' => 11, 'default' => 0,],
			],
			'widgets' => 
			[
				'id' 			=> ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,],
				'slug' 			=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => '',],
				'title' 		=> ['type' => 'TEXT', 'constraint' => 100,],
				'description' 	=> ['type' => 'TEXT', 'constraint' => 100,],
				'author' 		=> ['type' => 'VARCHAR', 'constraint' => 100, 'default' => '',],
				'website' 		=> ['type' => 'VARCHAR', 'constraint' => 255, 'default' => '',],
				'version' 		=> ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 0,],
				'enabled' 		=> ['type' => 'INT', 'constraint' => 1, 'default' => 1,],
				'order' 		=> ['type' => 'INT', 'constraint' => 10, 'default' => 0,],
				'updated_on' 	=> ['type' => 'INT', 'constraint' => 11, 'default' => 0,],
			],
		];

		log_message('debug', '-- Widgets: Installing Widget tables.');

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		return true;
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('widget_areas');
		$this->dbforge->drop_table('widget_instances');
		$this->dbforge->drop_table('widgets');

		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}

}
