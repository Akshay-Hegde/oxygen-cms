<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Tasks extends Module {

    public $version = '1.0.0';

	public function info()
	{
		return 
		[
			'name'			=> 
			[
				'en' 		=> 'Tasks'
			],
			'description' 	=> 
			[
				'en' 		=> 'This is a OxygenCMS module.'
			],
			'frontend' 		=> false,
			'backend' 		=> true,
			'clean_xss' 	=> true,			
			'menu' 			=> false, // You can also place modules in their top level menu. For example try: 'menu' => 'tasks',
			'sections' 		=> [],
			'icon'			=> 'fa fa-check',
		];
	}



	public function admin_menu(&$menu)
	{
		$menu['lang:cp:nav_content']['menu_items'][] = 
			[
				'name' 			=> 'Tasks',
				'uri' 			=> 'admin/tasks',
				'icon' 			=> 'fa fa-check',
				'permission' 	=> '',
				'menu_items'	=> [],
			];
	}	
	
	public function install()
	{
		$this->dbforge->drop_table('tasks');
		$this->db->delete('settings', array('module' => 'tasks'));

		$tables_to_install = 
		[
			'tasks' 			=> 
			[
	            'id' 			=> ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,],
				'name'			=> [ 'type' => 'VARCHAR', 'constraint' => '100' ],
				'description' 	=> [ 'type' => 'TEXT', ],						
				'complete' 		=> [ 'type' => 'DATETIME', 'null' => true, 'default' => NULL ],
	            'pcent' 		=> [ 'type' => 'INT', 'constraint' => '4','default' => 0 ],	
	            'order' 		=> [ 'type' => 'INT', 'constraint' => '8','default' => 0 ],		
			],
		];


        $tables_installed = $this->install_tables( $tables_to_install );

        if( ! $tables_installed  )
        {
        	return false;
        }

 		$data = 
 		[
 			'section'=>'row2',
 			'name'=>'Todos Dashboard Widget',
 			'partial'=>'tasks/admin/partials/dashboard/widget',
 			'order'=> 1, 
 			'is_visible'=> 1,
 			'module'=>'tasks'
 		];
 		$this->db->insert('widgets_admin',$data);

		return true;
		
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('tasks');
		$this->db->delete('settings', array('module' => 'tasks'));
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		//remove tghe todo setting
		$this->db->delete('settings', array('module' => 'tasks'));
		// Your Upgrade Logic
		return TRUE;
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
