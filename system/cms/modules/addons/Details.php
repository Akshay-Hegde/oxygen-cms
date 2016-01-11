<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Addons Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Modules
 */
class Module_Addons extends Module
{
	public $version = '1.0.0';

	public function info()
	{
		$info = 
		[
			'name' =>  
			[
				'en' => 'Add-ons',
			],
			'description' => 
			[
				'en' => 'Allows admins to see a list of currently installed modules.',
			],
			'frontend' => false,
			'backend' => true,
			'menu' => false,
			'icon' 			=> 'fa fa-laptop',
			'sections' => 
			[
				'modules' => 
				[
					'name' => 'addons:modules',
					'uri' => 'admin/addons/modules',
				],
				'themes' =>  
				[
					'name' => 'global:themes',
					'uri' => 'admin/addons/themes',					
				],
				'plugins' => 
				[
					'name' => 'global:plugins',
					'uri' => 'admin/addons/plugins',
				],
				'widgets' => 
				[
					'name' => 'global:widgets',
					'uri' => 'admin/addons/widgets',
				],				
				'field_types' =>  
				[
					'name' => 'global:field_types',
					'uri' => 'admin/addons/field-types',
				],						
			],
		];

	
		// Add upload options to various modules
		if ( ! class_exists('Module_import') and Settings::get('addons_upload'))
		{
			$info['sections']['modules']['shortcuts'] = 
			[
				[
					'name' => 'global:upload',
					'uri' => 'admin/addons/modules/upload',
					'class' => '',
				],
			];

			$info['sections']['themes']['shortcuts'] = array(
				array(
					'name' => 'global:upload',
					'uri' => 'admin/addons/themes/upload',
					'class' => 'as_modal',
				),
				array(
					'name' => 'global:themes',
					'uri' => 'admin/addons/themes',
				),	
				array(
					'name' => 'global:admin-themes',
					'uri' => 'admin/addons/admin-themes',
				),								
			);

			$info['sections']['admin_themes']['shortcuts'] = array(
				array(
					'name' => 'global:upload',
					'uri' => 'admin/addons/themes/upload',
					'class' => 'as_modal',
				),
			);
		}

		return $info;
	}
	
	public function admin_menu(&$menu)
	{
		$menu['lang:cp:nav_system']['menu_items'] = 
		[
			[
				'name' 			=> 'lang:cp:nav_addons',
				'uri' 			=> 'admin/addons',
				'icon' 			=> 'fa fa-gear',
				'permission' 	=> '',
				'menu_items'	=> 
				[
					[
						'name' 			=> 'lang:cp:nav_modules',
						'uri' 			=> 'admin/addons',
						'icon' 			=> 'fa fa-circle-o text-red',
						'permission' 	=> '',
					],
					[
						'name' 			=> 'lang:global:themes',
						'uri' 			=> 'admin/addons/themes',
						'icon' 			=> 'fa fa-circle-o text-red',
						'permission' 	=> '',
					],																	
					[
						'name' 			=> 'lang:cp:admin_theme',
						'uri' 			=> 'admin/addons/admin-themes',
						'icon' 			=> 'fa fa-circle-o text-red',
						'permission' 	=> '',
					],	
					[
						'name' 			=> 'lang:global:plugins',
						'uri' 			=> 'admin/addons/plugins',
						'icon' 			=> 'fa fa-circle-o text-red',
						'permission' 	=> '',
					],	
					[
						'name' 			=> 'lang:global:widgets',
						'uri' 			=> 'admin/addons/widgets',
						'icon' 			=> 'fa fa-circle-o text-red',
						'permission' 	=> '',
					],						
					[
						'name' 			=> 'lang:global:field_types',
						'uri' 			=> 'admin/addons/field-types',
						'icon' 			=> 'fa fa-circle-o text-red',
						'permission' 	=> '',
					],	
				]
			],


		];

		add_admin_menu_place('lang:cp:nav_addons', 10);

	}

	public function install()
	{
		$this->dbforge->drop_table('theme_options');

		$tables = 
		[
			'theme_options' => 
			[
				'id' 			=> ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true],
				'slug' 			=> ['type' => 'VARCHAR', 'constraint' => 30],
				'title' 		=> ['type' => 'VARCHAR', 'constraint' => 100],
				'description' 	=> ['type' => 'TEXT', 'constraint' => 100],
				'type' 			=> ['type' => 'set', 'constraint' => array('text', 'textarea', 'password', 'select', 'select-multiple', 'radio', 'checkbox', 'colour-picker')],
				'default' 		=> ['type' => 'VARCHAR', 'constraint' => 255],
				'value' 		=> ['type' => 'VARCHAR', 'constraint' => 255],
				'options' 		=> ['type' => 'TEXT'],
				'is_required' 	=> ['type' => 'INT', 'constraint' => 1],
				'theme' 		=> ['type' => 'VARCHAR', 'constraint' => 50],
			],
		];

		if ( ! $this->install_tables($tables)) {
			return false;
		}

		// Install settings
		$settings = 
		[
			[
				'slug' => 'addons_upload',
				'title' => 'Addons Upload Permissions',
				'description' => 'Keeps mere admins from uploading addons by default',
				'type' => 'text',
				'default' => '0',
				'value' => '0',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 0,
				'module' => '',
				'order' => 0,
			],
			[
				'slug' => 'public_theme',
				'title' => 'Default Theme',
				'description' => 'Select the theme you want users to see by default.',
				'type' => '',
				'default' => 'oxygen',
				'value' => 'oxygen',
				'options' => 'func:get_themes',
				'is_required' => 1,
				'is_gui' => 0,
				'module' => '',
				'order' => 0,
			],
			[
				'slug' => 'admin_theme',
				'title' => 'Control Panel Theme',
				'description' => 'Select the theme for the control panel.',
				'type' => '',
				'default' => 'oxygen_admin',
				'value' => 'oxygen_admin',
				'options' => 'func:get_themes',
				'is_required' => 1,
				'is_gui' => 0,
				'module' => '',
				'order' => 0,
			],
		];

		foreach ($settings as $setting)
		{
			if ( ! $this->db->insert('settings', $setting))
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
