<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Blog Module
 *
 * @author  OxygenCMS (2015)
 * @author  PyroCMS Dev Team (2008-2014)
 *
 * @package PyroCMS\Core\Modules\Blog
 */
class Module_Blog extends Module
{
	public $version = '1.0.0';

	//
	// if set to FALSE, it will not install
	// with the core installer
	//
	public $auto_install	= false;

	//
	// Main info() function
	//
	public function info()
	{
		$info = 
		[
			'name' => 
			[
				'en' => 'Blog',
			],
			'description' => 
			[
				'en' => 'Post blog entries.',
			],
			'icon'		=> 'fa fa-newspaper-o',
			'frontend' => true,
			'backend' => true,
			'clean_xss' => true,
			'menu' => false,
			'roles' => 
			[
				'create_posts', 'manage_posts', 'admin_setup'
			],
			'sections' => 
			[
				'posts' => 
				[
					'name' => 'blog:posts_title',
					'uri' => 'admin/blog',
					'shortcuts' => 
					[
						[
							'name' => 'blog:create_title',
							'uri' => 'admin/blog/create',
						],
					],
				],
				'categories' => 
				[
					'name' => 'cat:list_title',
					'uri' => 'admin/blog/categories',
					'shortcuts' => 
					[
						[
							'name' => 'cat:create_title',
							'uri' => 'admin/blog/categories/create',
						],
					],
				],
			],
		];

		return $info;
	}

	//
	// Display the menu in CP
	//
	public function admin_menu(&$menu)
	{

		$menu['lang:cp:nav_blog']['icon'] = 'fa fa-newspaper-o';
		$has_categories = false;
		if(group_has_role('blog','create_posts'))
		{
			$has_categories = true;
			$menu['lang:cp:nav_blog']['menu_items'][] = 
			[
				'name' 			=> 'lang:global:new_post',
				'uri' 			=> 'admin/blog/create',
				'icon' 			=> 'fa fa-plus',
				'permission' 	=> '',
				'menu_items'	=> [],
			];
		}
		if(group_has_role('blog','manage_posts'))
		{		
			$has_categories = true;
			$menu['lang:cp:nav_blog']['menu_items'][] = 
				[
					'name' 			=> 'lang:cp:nav_posts',
					'uri' 			=> 'admin/blog/',
					'icon' 			=> 'fa fa-newspaper-o',
					'permission' 	=> '',
					'menu_items'	=> [],
				];
		}
		if($has_categories)
		{
			$menu['lang:cp:nav_blog']['menu_items'][] = 
				[
					'name' 			=> 'lang:cp:nav_blog_categories',
					'uri' 			=> 'admin/blog/categories',
					'icon' 			=> 'fa fa-edit',
					'permission' 	=> '',
					'menu_items'	=> [],
				];
		}

 
		if(group_has_role('blog', 'admin_setup')) {
			$menu['lang:cp:nav_blog']['menu_items'][] = 
				[
					'name' 			=> 'lang:cp:nav_blog_fields',
					'uri' 			=> 'admin/blog/fields',
					'icon' 			=> 'fa fa-edit',
					'permission' 	=> '',
					'menu_items'	=> [],
				];
		}
   

    	add_admin_menu_place('lang:cp:nav_blog', 2);
	}

	public function install()
	{
		return false;
	}

	public function uninstall()
	{
		return false;
	}

	public function upgrade($old_version)
	{
		return false;
	}

    public function disable() 
	{
		return false;
	}
    
    public function enable() 
	{
		return false;
	}
}