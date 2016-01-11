<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comments module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Comments
 */
class Module_Comments extends Module
{

	public $version = '1.0.0';

	public function info()
	{
		$info = 
		[
			'name' => 
			[
				'en' 	=> 'Comments',
			],
			'description' => 
			[
				'en' 	=> 'Users and guests can write comments for content like blog, pages and photos.',
			],
			'frontend' 	=> false,
			'backend' 	=> true,
			'menu'		 => false,	
			'icon' 		=> 'fa fa-commenting',
		];

		return $info;

	}



	public function admin_menu(&$menu)
	{
		$menu['lang:cp:nav_content']['menu_items'][] =
		[
			'name' 			=> 'Comments',
			'uri' 			=> 'admin/comments',
			'icon' 			=> 'fa fa-commenting',
			'permission' 	=> '',
		];
	}



	public function install()
	{
		$this->dbforge->drop_table('comments');
		$this->dbforge->drop_table('comment_blacklists');

		$tables = 
		[
			'comments' => 
			[
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'is_active' => array('type' => 'INT', 'constraint' => 1, 'default' => 0),
				'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'user_name' => array('type' => 'VARCHAR', 'constraint' => 40, 'default' => ''),
				'user_email' => array('type' => 'VARCHAR', 'constraint' => 40, 'default' => ''), // @todo Shouldn't this be 255?
				'user_website' => array('type' => 'VARCHAR', 'constraint' => 255),
				'comment' => array('type' => 'TEXT'),
				'parsed' => array('type' => 'TEXT'),
				'module' => array('type' => 'VARCHAR', 'constraint' => 40),
				'entry_id' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => 0),
				'entry_title' => array('type' => 'char', 'constraint' => 255, 'null' => false),
				'entry_key' => array('type' => 'varchar', 'constraint' => 100, 'null' => false),
				'entry_plural' => array('type' => 'varchar', 'constraint' => 100, 'null' => false),
				'uri' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
				'cp_uri' => array('type' => 'varchar', 'constraint' => 255, 'null' => true),
				'created_on' => array('type' => 'INT', 'constraint' => 11, 'default' => '0'),
				'ip_address' => array('type' => 'VARCHAR', 'constraint' => 45, 'default' => ''),
			],
			'comment_blacklists' => 
			[
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'website' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'email' => array('type' => 'VARCHAR', 'constraint' => 150, 'default' => ''),
			],
		];

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		// Install the setting
		$settings = array(
			array(
				'slug' => 'akismet_api_key',
				'title' => 'Akismet API Key',
				'description' => 'Akismet is a spam-blocker from the WordPress team. It keeps spam under control without forcing users to get past human-checking CAPTCHA forms.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 981,
			),
			array(
				'slug' => 'enable_comments',
				'title' => 'Enable Comments',
				'description' => 'Enable comments.',
				'type' => 'radio',
				'default' => true,
				'value' => true,
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'comments',
				'order' => 968,
			),
			array(
				'slug' => 'moderate_comments',
				'title' => 'Moderate Comments',
				'description' => 'Force comments to be approved before they appear on the site.',
				'type' => 'radio',
				'default' => true,
				'value' => true,
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'comments',
				'order' => 967,
			),
			array(
				'slug' => 'comment_order',
				'title' => 'Comment Order',
				'description' => 'Sort order in which to display comments.',
				'type' => 'select',
				'default' => 'ASC',
				'value' => 'ASC',
				'options' => 'ASC=Oldest First|DESC=Newest First',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'comments',
				'order' => 966,
			),
			array(
				'slug' => 'comment_markdown',
				'title' => 'Allow Markdown',
				'description' => 'Do you want to allow visitors to post comments using Markdown?',
				'type' => 'select',
				'default' => '0',
				'value' => '0',
				'options' => '0=Text Only|1=Allow Markdown',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'comments',
				'order' => 965,
			),
		);

		foreach ($settings as $setting)
		{
			if ( ! $this->db->insert('settings', $setting))
			{
				return false;
			}
		}

 		$data = 
 		[
 			'section'=>'row2',
 			'name'=>'Recent Comments',
 			'partial'=>'comments/admin/partials/dashboard_widget',
 			'order'=> 1, 
 			'is_visible'=> 1,
 			'module'=>'comments'
 		];
 		$this->db->insert('widgets_admin',$data);	




		return true;
	}

	public function uninstall()
	{
 		$this->db->where('module','comments')->delete('widgets_admin');	
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
