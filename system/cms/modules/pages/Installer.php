<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Pages
 */
class Installer_Pages extends Component
{

	public $info;

	public function __construct()
	{
		$this->ci = get_instance();
	}


	public function info()
	{
		return $this->info;
	}
	public function set_info($info)
	{
		$this->info = $info;
	}


	public function install()
	{

		log_message('debug', '-- Pages: Installing pages Module.');
		
		$this->dbforge->drop_table('page_types');
		$this->dbforge->drop_table('pages');


		// We only need to do this if the page_type_standard table
		// has already been added.
		if ($this->db->table_exists('page_type_standard'))
		{
			$this->load->driver('Streams');
			$this->streams->utilities->remove_namespace('pages');
			$this->dbforge->drop_table('page_type_standard');
		}

		if ($this->db->table_exists('data_streams'))
		{
			$this->db->where('stream_namespace', 'pages')->delete('data_streams');
		}

		$this->load->helper('date');
		$this->load->config('pages/pages');

		$tables = 
		[
			'page_types' => 
			[
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'title' => array('type' => 'VARCHAR', 'constraint' => 60),
				'description' => array('type' => 'TEXT', 'null' => true),
				'stream_id' => array('type' => 'INT', 'constraint' => 11),
				'meta_title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'meta_keywords' => array('type' => 'CHAR', 'constraint' => 32, 'null' => true),
				'meta_description' => array('type' => 'TEXT', 'null' => true),
				'css' => array('type' => 'TEXT', 'null' => true),
				'js' => array('type' => 'TEXT', 'null' => true),
				'theme_layout' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => 'default.html'),
				'theme_struct' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => 'standard.php'),
				'updated_on' => array('type' => 'INT', 'constraint' => 11),
	            'save_as_files'     => array('type' => 'CHAR', 'constraint' => 1, 'default' => 'n'),
	            'content_label'     => array('type' => 'VARCHAR', 'constraint' => 60, 'null' => true),
	            'title_label'     => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
	            'hidden' => array('type' => 'INT', 'constraint' => 11,'null'=>true,'default'=>0),
				'allow_create' => array('type' => 'INT', 'constraint' => 11, 'default' => 1),	            
			],
			'pages' => 
			[
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '', 'key' => 'slug'),
				'class' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'uri' => array('type' => 'TEXT', 'null' => true),
				'parent_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0, 'key' => 'parent_id'),
				'type_id' => array('type' => 'VARCHAR', 'constraint' => 255),
				'entry_id' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'entry_id_offline' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'css' => array('type' => 'TEXT', 'null' => true),
				'js' => array('type' => 'TEXT', 'null' => true),
				'meta_title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'meta_keywords' => array('type' => 'CHAR', 'constraint' => 32, 'null' => true),
				'meta_robots_no_index' => array('type' => 'TINYINT', 'constraint' => 1, 'null' => true),
				'meta_robots_no_follow' => array('type' => 'TINYINT', 'constraint' => 1, 'null' => true),
				'meta_description' => array('type' => 'TEXT', 'null' => true),
				'rss_enabled' => array('type' => 'INT', 'constraint' => 1, 'default' => 0),
				'comments_enabled' => array('type' => 'INT', 'constraint' => 1, 'default' => 0),
				'status' => array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
				'created_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'restricted_to' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'is_home' => array('type' => 'INT', 'constraint' => 1, 'default' => 0),
				'strict_uri' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
				'order' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			],
			//if the user_group has no perm but the user does, allow them
			'pages_permissions' => 
			[
				'user_id' => array('type' => 'INT', 'constraint' => 11, 'key' => 'user_id','primary' => true),
				'page_id' => array('type' => 'INT', 'constraint' => 11, 'key' => 'page_id','primary' => true),
				'access_front' => array('type' => 'INT', 'constraint' => 1,),
				'access_admin' => array('type' => 'INT', 'constraint' => 1,),
			],				
		];

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		$this->load->driver('streams');

		$default_stream_id = $this->streams->streams->add_stream(
			'Standard',
			'page_type_standard',
			'pages',
			null,
			'A simple page type with a WYSIWYG editor that will get you adding content quickly.'
		);

		$contact_stream_id = $this->streams->streams->add_stream(
			'Contact',
			'page_type_contact',
			'pages',
			null,
			'A customized contact page so your clients get get in touch with you..'
		);

		$fourohfour_stream_id = $this->streams->streams->add_stream(
			'404',
			'page_type_404',
			'pages',
			null,
			'A 404 page type stream.'
		);

		//
		// Add fields to the system
		//
		$this->streams->fields->add_fields(config_item('pages:default_fields'));

		//
		// Assign fields to teh page streams
		//

		// Required for all page types
		$this->streams->fields->assign_field('pages', 'page_type_standard', 'page_ref_id');
		$this->streams->fields->assign_field('pages', 'page_type_contact', 'page_ref_id');		
		$this->streams->fields->assign_field('pages', 'page_type_404', 'page_ref_id');

		// just some defaults
		$this->streams->fields->assign_field('pages', 'page_type_standard', 'body');
		$this->streams->fields->assign_field('pages', 'page_type_404', 'body');
		$this->streams->fields->assign_field('pages', 'page_type_contact', 'body');
		$this->streams->fields->assign_field('pages', 'page_type_contact', 'success_send');
		$this->streams->fields->assign_field('pages', 'page_type_contact', 'error_send');

		//
		// Create the Default page type, used for home,about ect..
		//
		if($def_page_type_id = $this->_installType('standard',$default_stream_id)) 
		{
			//all good
		} 
		else 
		{
			return false;
		}

		//
		// Create the contact Page type
		//
		if($contact_page_type_id = $this->_installType('contact',$contact_stream_id)) 
		{
			//all good
		} 
		else {
			return false;
		}
	

		//
		// Create the contact Page type
		//
		if($error_404_page_type_id = $this->_installType('fourohfour',$fourohfour_stream_id)) 
		{
			//all good
		} 
		else {
			return false;
		}


		$page_content = config_item('pages:page_content');
		$page_stream = config_item('pages:page_stream');

		$page_entries = 
		[
			'home' => 
			[
				'slug' => 'home',
				'title' => 'Home',
				'uri' => 'home',
				'parent_id' => 0,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => true,
				'order' => now()
			],	
			'fourohfour' =>  
			[
				'slug' => '404',
				'title' => 'Page missing',
				'uri' => '404',
				'parent_id' => 0,
				'type_id' => $error_404_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => false,
				'order' => now()
			],	
			'about' => 
			[
				'slug' => 'about',
				'title' => 'About',
				'uri' => 'about',
				'parent_id' => 0,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => false,
				'order' => now()
			],								
			'contact' => 
			[
				'slug' => 'contact',
				'title' => 'Contact',
				'uri' => 'contact',
				'parent_id' => 0,
				'type_id' => $contact_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => false,
				'order' => now()
			],					
		];


		//default pages for all page types
		foreach ($page_entries as $key => $d)
		{
			$this->db->insert('pages', $d);
			$page_id = $this->db->insert_id();
			//set the page ref for page-history
			$page_content[$key]['page_ref_id'] = $page_id;

			$this->db->insert($page_stream[$key], $page_content[$key]);
			$entry_id = $this->db->insert_id();

			$this->db->where('id', $page_id);
			$this->db->update('pages', array('entry_id' => $entry_id));

			unset($page_id);
			unset($entry_id);
		}

		$this->_install_settings();

		return true;
	}

	private function _install_settings()
	{
		$settings = 
		[
			'pages_enhanced_security' => 
			[
				'title' => 'Enhanced Page Security',
				'description' => 'Enable granular control on page access. This will enable you to allow certain users access to edit or view individual pages',
				'type' => 'select',
				'default' => false,
				'value' => false,
				'options' => '0=Disabled|1=Enabled',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'security',
				'order' => 999,
			],
		];
		// Lets add the settings for this module.
		foreach ($settings as $slug => $setting_info)
		{
			log_message('debug', '-- Settings: installing '.$slug);
			$setting_info['slug'] = $slug;
			if ( ! $this->db->insert('settings', $setting_info))
			{
				log_message('debug', '-- -- could not install '.$slug);

				return false;
			}
		}
	}

	private function _installType($page_type=[],$stream_id=0) 
	{

		$types=[];
		$types['standard'] =
		[
			'id' => 2,
			'title' => 'Standard',
			'slug' => 'standard',
			'description' => 'A simple page type with a WYSIWYG editor that will get you started adding content.',
			'stream_id' => $stream_id,
			'theme_layout'=>'default.html',
			'theme_struct'=>'standard.php',
			'hidden'	=> 0,
			//'body' => '{{ body }}',
			'css' => '',
			'js' => '',
			'updated_on' => now()
		];
		$types['contact'] =
		[
			'id' => 3,
			'title' => 'Contact',
			'slug' => 'contact',
			'description' => 'A customized contact page so your clients get get in touch with you..',
			'stream_id' => $stream_id,
			'theme_layout'=>'default.html',
			'theme_struct'=>'contact.php',
			'hidden'	=> 0,
			//'body' => '{{ body }}',
			'css' => '',
			'js' => '',
			'updated_on' => now()
		];		
		$types['fourohfour'] =
		[
			'id' => 4,
			'title' => '404',
			'slug' => '404',
			'description' => 'A customized 404 error page',
			'stream_id' => $stream_id,
			'theme_layout'=>'default.html',
			'theme_struct'=>'404.php',
			'hidden'	=> 0,
			//'body' => '{{ body }}',
			'css' => '',
			'js' => '',
			'updated_on' => now()
		];	


		if ( ! $this->db->insert('page_types', $types[$page_type] ))
		{
			return false;
		}

		$page_type_id = $this->db->insert_id();

		return $page_type_id;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{
		$tables =
		[
			'pages_permissions' => 
			[
				'user_id' => array('type' => 'INT', 'constraint' => 11, 'key' => 'user_id','primary' => true),
				'page_id' => array('type' => 'INT', 'constraint' => 11, 'key' => 'page_id','primary' => true),
				'access_front' => array('type' => 'INT', 'constraint' => 1,),
				'access_admin' => array('type' => 'INT', 'constraint' => 1,),
			],				
		];

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

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