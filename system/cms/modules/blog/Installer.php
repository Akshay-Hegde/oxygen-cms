<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Blog Installer
 *
 * @author  OxygenCMS (2015)
 * @author  PyroCMS Dev Team (2008-2014)
 *
 * @package PyroCMS\Core\Modules\Blog\Installer
 */
class Installer_Blog extends Component
{

	public $info;
	
	public $auto_install	= false;

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

		log_message('debug', '-- Blog: Installing blog Module.');

		$this->load->driver('Streams');
		
		$this->uninstall();

		//end uninstall

		// Create the blog categories table.
		$this->install_tables(
			[
				'blog_categories' => 
				[
					'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
					'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true, 'key' => true),
					'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true),
				],
			]
		);

		$this->streams->streams->add_stream(
			'lang:blog:blog_title',
			'blog',
			'blogs',
			null,
			null
		);

		// This can be later removed by an admin.
		$fields = 
		[
			[
				'name'		=> 'lang:blog:intro_label',
				'slug'		=> 'intro',
				'namespace' => 'blogs',
				'type'		=> 'wysiwyg',
				'assign'	=> 'blog',
				'extra'		=> array('editor_type' => 'simple', 'allow_tags' => 'y'),
				'required'	=> true
			],
			[
				'name'		=> 'lang:blog:body',
				'slug'		=> 'body',
				'namespace' => 'blogs',
				'type'		=> 'wysiwyg',
				'assign'	=> 'blog',
				'extra'		=> array('editor_type' => 'advanced', 'allow_tags' => 'y'),
				'required'	=> true,
				'locked'	=> true
			],			
			[
				'name'		=> 'lang:blog:post_image',
				'slug'		=> 'blog_image',
				'namespace' => 'blogs',
				'type'		=> 'image',
				'assign'	=> 'blog',
				'extra'		=> ['folder'=>'default_data_folder','allowed_types'=>'jpg|png|gif'],
				'required'	=> false,
				'locked'	=> true
			]
		];	
			
		$this->streams->fields->add_fields($fields);

		// Ad the rest of the blog fields the normal way.
		$blog_fields = 
		[
			'title' => array('type' => 'VARCHAR', 'constraint' => 200, 'null' => false, 'unique' => true),
			'slug' => array('type' => 'VARCHAR', 'constraint' => 200, 'null' => false),
			'category_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
			'parsed' => array('type' => 'TEXT'),
			'keywords' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => ''),
			'author_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			'created_on' => array('type' => 'INT', 'constraint' => 11),
			'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			'comments_enabled' => array('type' => 'ENUM', 'constraint' => array('no','1 day','1 week','2 weeks','1 month', '3 months', 'always'), 'default' => '3 months'),
			'status' => array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
			'preview_hash' => array('type' => 'CHAR', 'constraint' => 32, 'default' => ''),
		];

		$this->dbforge->add_column('blog', $blog_fields);

		//get the first nav group and assign it to the menu?
		$links = 
		[
			['title' => 'Blog'	 , 'link_type' => 'module'	, 'page_id' => NULL , 'navigation_group_id' => 1, 'position' => 1, 'module_name' => 'blog'],
		];
		foreach ($links as $link)
		{
			$this->db->insert('navigation_links', $link);
		}

 		$data = 
 		[
 			'section'=>'row2',
 			'name'=>'RSS Feed',
 			'partial'=>'widgets/rss_feed',
 			'order'=> 1, 
 			'is_visible'=> 1,
 			'module'=>'blog'
 		];
 		$this->db->insert('widgets_admin',$data);	

		$r_routes =
		[
			['name'=>'Blog Listing', 	'uri'=>'blog/(:num)/(:num)/(:any)', 'dest'=>'blog/view/$3','can_change'=>true],
			['name'=>'Blog Page', 		'uri'=>'blog/page(/:num)?', 		'dest'=>'blog/index$1','can_change'=>true],
			['name'=>'Blog RSS', 		'uri'=>'blog/rss/all.rss', 			'dest'=>'blog/rss/index','can_change'=>true],
			['name'=>'Blog RSS Item', 	'uri'=>'blog/rss/(:any).rss', 		'dest'=>'blog/rss/category/$1','can_change'=>true],			
		];
		
		//Install the site routes
		// we could have the lib autoloaded so the dev doesnt have to
	    $this->load->library('maintenance/routes_lib');
	    Routes_lib::InstallModule('blog',$r_routes);

		return true;		
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('blog_categories');

		$this->load->driver('Streams');
		$this->streams->utilities->remove_namespace('blogs');

		// Just in case.
		$this->dbforge->drop_table('blog',true);

		if ($this->db->table_exists('data_streams'))
		{
			$this->db->where('stream_namespace', 'blogs')->delete('data_streams');
		}

 		$this->db->where('module','blog')->delete('widgets_admin');	

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