<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Pages
 */
class Module_Pages extends Module
{
	public $version = '1.0.3';

	public function info()
	{
		$info = 
		[
			'name' => 
			[
				'en' => 'Pages',
			],
			'description' => 
			[
				'en' => 'Add custom pages to the site with any content you want.',
			],
			'frontend' => true,
			'backend'  => true,
			'clean_xss' => true, 
			'menu'	  => false,
			'icon'		=> 'fa fa-file-text-o',
			'roles' => 
			[
				'create_pages', 'manage_pages', 'manage_types', 'manage_specific_pages',
			],
			'sections' => 
			[
			    'pages' => 
			    [
				    'name' => 'pages:list_title',
				    'uri' => 'admin/pages',
				    'shortcuts'	=>
				    [
				    	[
					    	'name' 			=> 'global:new_page',
					    	'uri' 			=> 'admin/pages/create',
					    	'icon'			=> '',
					    ],			
				    ]
				]
			]
			];

			if(function_exists('group_has_role'))
			{
				if(group_has_role('pages','manage_types'))
				{

					$info['sections']['types'] = 
					[
					    'name' => 'page_types:list_title',
					    'uri' => 'admin/pages/types',
					    'shortcuts'	=>
					    [
					    	[
						    	'name' 			=> 'global:new_page',
						    	'uri' 			=> 'admin/pages/create',
						    	//'class'			=> 'as_modal',
						    	'icon'			=> '',					    	
						    ],		
					    	[
						    	'name' 			=> 'global:new_page_type',
						    	'uri' 			=> 'admin/pages/types/create',
						    ],						    	
					    ]

				    ];
				}
			}


		// We check that the table exists (only when in the admin controller)
		if (class_exists('Admin_controller') and $this->db->table_exists('page_types'))
		{
			// Shortcuts for New page
			// Do we have more than one page type? If we don't, no need to have a modal
			// ask them to choose a page type.
			if ($this->db->where('hidden',0)->from('page_types')->count_all_results() > 1)
			{
				//$_create_page_uri = 'admin/pages/choose_type?modal=true';
				$_create_page_uri = 'admin/pages/choose_type';
			}
			else
			{
				// Get the one page type. 
				$page_type = $this->db->where('hidden',0)->limit(1)->select('id')->get('page_types')->row();
				$_create_page_uri = 'admin/pages/create?page_type='.$page_type->id;

			}
	
		}

		return $info;
	}


	public function admin_menu(&$menu)
	{

		$menu['lang:cp:nav_pages']['icon'] = 'fa fa-file-text-o';

			if(group_has_role('pages','create_pages'))
			{	
				$menu['lang:cp:nav_pages']['menu_items'][] = 
				[
					'name' 			=> 'lang:global:new_page',
					'uri' 			=> 'admin/pages/create',
					'icon' 			=> 'fa fa-plus',
					'permission' 	=> '',
					'menu_items'	=> [],
				];	
			}

			if( group_has_role('pages','manage_pages') OR group_has_role('pages','manage_specific_pages') )
			{			
				$menu['lang:cp:nav_pages']['menu_items'][] = 
				[
					'name' 			=> 'lang:cp:nav_all_pages',
					'uri' 			=> 'admin/pages',
					'icon' 			=> 'fa fa-files-o',
					'permission' 	=> '',
					'menu_items'	=> [],
				];
			}

			if(group_has_role('pages','manage_types'))
			{
				$menu['lang:cp:nav_pages']['menu_items'][] =
					[
						'name' 			=> 'lang:cp:nav_page_types',
						'uri' 			=> 'admin/pages/types',
						'icon' 			=> 'fa fa-columns',
						'menu_items'	=> [],
					];
			}


	}

	/**
	 * We have a seperate installer file
	 */
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
		return false;
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