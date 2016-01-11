<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Subscriptions extends Module {

    public $version = '1.0.0';

	public function info() 
	{
		return 
		[
			'name' => 
			[
				'en' 	=> 'Subscribe'
			],
			'description' => 
			[
				'en' 	=> 'This is a Subscribe module.'
			],
			'frontend' 	=> false,
			'backend' 	=> true,
			'clean_xss' => true,			
			'menu' 		=> false,
			'icon' 		=> 'fa fa-edit',
			'sections' 	=> [],
		];
	}

    public function admin_menu(&$menu)
    {
        $menu['lang:cp:nav_users']['menu_items'][] = 
            [
                'name'          => 'Subscriptions',
                'uri'           => 'admin/subscriptions',
                'icon'          => 'fa fa-edit',
                'permission'    => '',
                'menu_items'    => [],
            ];
    }


	public function install() 
	{
        $tables_to_install = 
        [
        	'subscriptions'	 =>
			[ 
	 			'id'    		 	=> [ 'type' 		=> 'INT', 'constraint' 		=> '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE],
	 			'name'  		 	=> [ 'type' 		=> 'VARCHAR', 'constraint' 	=> '512', 'null' 	=> TRUE, 'default' => '' ],
	 			'module'  		 	=> [ 'type' 		=> 'VARCHAR', 'constraint' 	=> '512', 'null' 	=> TRUE, 'default' => '' ],
	 			'order' 			=> [ 'type' 		=> 'INT', 'constraint' 		=> '8','default' 	=> 0 ],
 			],         
        	'subscribers'	 =>
			[ 
				//first 3 fields are key identifiers
	 			'id'    		 	=> [ 'type' 	=> 'INT', 'constraint' 		=> '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE],
	 			'subscription_id' 	=> [ 'type' 	=> 'INT', 'constraint' 		=> '11','default' => 0 ],
	 			'email'  		 	=> [ 'type' 	=> 'VARCHAR', 'constraint' 	=> '512', 'null' => TRUE, 'default' => '' ],
	 			'created'  		 	=> [ 'type' 	=> 'DATETIME', 'null' 		=> true, 'default' => NULL],
 			], 			 
 		];

        $tables_installed = $this->install_tables( $tables_to_install );

        if( ! $tables_installed  )
        {
        	return false;
        }

		return true;
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('subscribers');
		$this->dbforge->drop_table('subscriptions');
		return true;
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
	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br>Contact the module developer for assistance.";
	}
}
/* End of file Details.php */
