<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Search module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Search
 */
class Module_Search extends Module
{
	public $version = '1.0.0';

	public function info()
	{
		return 
		[
			'name' => 
			[
				'en' => 'Search',
			],
			'description' => 
			[
				'en' => 'Search through various types of content with this modular search system.',
			],
			'frontend' => false,
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
