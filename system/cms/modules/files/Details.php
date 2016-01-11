<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Files module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Files
 */
class Module_Files extends Module
{

	public $version = '1.0.0';

	public function info()
	{
		$info = [
			'name' => 
			[
				'en' => 'Files',
			],
			'description' => 
			[
				'en' => 'Manages files and folders for your site.',
			],
			'frontend' => false,
			'backend' => true,
			'menu' => false,
			'icon'		=>	'fa fa-folder-o',
			'roles' => 
			[
				'upload', 
				'manage', 
			]
		];
		$info['sections']['browse'] = 
		[
			'name' => 'Files',
			'uri' => 'admin/files/browse',
		];

		$info['sections']['folders'] = 
		[
			'name' => 'Folders',
			'uri' => 'admin/files/folders',
		];

		return $info;	
	}



	public function admin_menu(&$menu)
	{
		$menu['lang:cp:nav_content']['menu_items'][] =
		[
			'name' 			=> 'Files',
			'uri' 			=> 'admin/files',
			'icon' 			=> 'fa fa-folder-o',
			'permission' 	=> '',
		];
	}


	public function install()
	{
		return false;
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
