<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Redirects module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Redirects
 */
class Module_Redirects extends Module {

	public $version = '1.0.0';

	public function info()
	{
		return 
		[
			'name' => 
			[
				'en' => 'Redirects',
			],
			'description' 	=> 
			[
				'en' 		=> 'Redirect from one URL to another.',
			],
			'frontend' 		=> false,
			'backend'  		=> true,
			'menu'	  		=> false,
			'icon'          => 'fa fa-retweet',
			'sections' 		=> 	
			[
				'redirects' =>
				[
					'name'	=> 'redirects:title',
					'uri'	=> 'admin/redirects',
				]
			],
			'shortcuts' 	=> 	[],
		];
	}

	public function install()
	{
		$this->dbforge->drop_table('redirects');

		$tables = 
		[
			'redirects' => 
			[
				'id' 		=> ['type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,],
				'from' 		=> ['type' => 'varchar', 'constraint' => 250, 'key' => 'request'],
				'to' 		=> ['type' => 'varchar', 'constraint' => 250,],
				'type' 		=> ['type' => 'int','constraint' => 3,'default' => 302],
				'module' 	=> ['type' => 'varchar', 'constraint' => 250, 'null'=>'true', 'default'=>''],
			],
		];

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		return true;
	}

    public function admin_menu(&$menu)
    {
        $menu['lang:cp:nav_system']['menu_items'][] = 
            [
                'name'          => 'Redirects',
                'uri'           => 'admin/redirects',
                'icon'          => 'fa fa-retweet',
                'permission'    => '',
                'menu_items'    => [],
            ];
    }

	

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{

        $fields = 
        [
            'module' 	=> ['type' => 'varchar', 'constraint' => 250, 'null'=>'true', 'default'=>''],
        ];
        $this->dbforge->add_column('redirects', $fields);
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
