<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Dashboard extends Module {

	public $version = '1.0.0';

	public function info() {

		return 
		[
			'name' => 
			[
				'en' => 'Dashboard'
			],
			'description' => 
			[
				'en' => 'This is dashboard module.'
			],
			'frontend' => false,
			'backend' => true,
			'clean_xss' => true,			
			'menu' => false,
			'sections' => [],
			'icon' => 'fa fa-dashboard',
		];
	}

	public function install() 
	{
        return true;
	}

	public function uninstall()
	{
		return false;
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
