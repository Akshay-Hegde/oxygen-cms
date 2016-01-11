<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Keywords module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Keywords
 */
class Module_Keywords extends Module {

	public $version = '1.0.0';

	public $_tables = array('keywords', 'keywords_applied');

	public function info()
	{
		return 
		[
			'name' => 
			[
				'en' => 'Keywords',
			],
			'description' => 
			[
				'en' => 'Maintain a central list of keywords to label and organize your content.',
			],
			'frontend' => false,
			'backend'  => true,
			'menu'     => false,
			'icon'          => 'fa fa-tags',
			'shortcuts' => [],
		];
	}



    public function admin_menu(&$menu)
    {
    	
        $menu['lang:cp:nav_system']['menu_items'][] = 
            [
                'name'          => 'Keywords',
                'uri'           => 'admin/keywords',
                'icon'          => 'fa fa-tags',
                'permission'    => '',
                'menu_items'    => [],
            ];
    }



	public function install()
	{
		$this->dbforge->drop_table('keywords');
		$this->dbforge->drop_table('keywords_applied');

		return $this->install_tables(
			[
				'keywords' => 
				[
					'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
					'name' => array('type' => 'VARCHAR', 'constraint' => 50,),
				],
				'keywords_applied' => 
				[
					'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
					'hash' => array('type' => 'CHAR', 'constraint' => 32, 'default' => '',),
					'keyword_id' => array('type' => 'INT', 'constraint' => 11,),
				],
			]
		);
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
