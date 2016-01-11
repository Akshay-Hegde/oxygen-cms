<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Notifications extends Module {

	public $version = '1.0.0';

	public function info() {

		return 
		[
			'name' => 
			[
				'en' => 'Notifications Core'
			],
			'description' => 
			[
				'en' => 'This is a OxygenCMS module.'
			],
			'frontend' => false,
			'backend' => true,
			'clean_xss' => true,			
			'menu' => false,
			'sections' => [],
		];
	}

	public function install() {

		$this->dbforge->drop_table('notifications');

		$notifications_table = 
		[
			'notifications'=>
			[
	 			'id'    		=> array('type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE),
	 			'name'  		=> array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'default' => '' ),
	 			'description'  	=> array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE, 'default' => '' ),
	 			'module'  		=> array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'default' => '' ),
	 			'type'  		=> array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE, 'default' => 'success' ),
	 			'created'  		=> array('type' => 'DATETIME', 'null' => true, 'default' => NULL),
 			]
		];

		if($this->install_tables( $notifications_table )) {

			// Add an initial notification
			$to_insert = 
			[
				'name' => 'Welcome',
				'description' => 'Congrats on installing OxygenCMS.',
				'module' => 'System',
				'type'=>'success',
				'created'=>date("Y-m-d H:i:s"),
			];

			$this->db->insert('notifications', $to_insert);

			return true;
		}

		return false;
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('notifications');

		return TRUE;

	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
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
