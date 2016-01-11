<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Sitemap Module
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Sitemap
 */
class Module_Sitemap extends Module {

	public $version = '1.0.0';

	public function info()
	{
		return 
		[
			'name' => 
			[
				'en' => 'Sitemap',
			],
			'description' => 
			[
				'en' => 'The sitemap module creates an index of all pages and an XML sitemap for search engines.',
			],
			'frontend' => true,
			'backend' => false,
			'menu' => false,
		];
	}

	public function install()
	{
		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
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
}