<?php defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Blog Plugin
 *
 * @author  OxygenCMS (2015)
 * @author  PyroCMS Dev Team (2008-2014)
 *
 * @package PyroCMS\Core\Modules\Blog\Plugin
 */
class Plugin_Blog extends Plugin
{

	public $version = '1.0.0';
	
	public $name = 
	[
		'en' => 'Blog',
	];

	public $description = 
	[
		'en' => 'A plugin to display information such as blog categories and posts.',
	];

	/**
	 * Returns a PluginDoc array
	 *
	 * @return array
	 */
	public function _self_doc()
	{

		$info = 
		[
			'posts' => 
			[
				'description' => 
				[
					'en' => 'Display blog posts optionally filtering them by category.',
				],
				'single' => false,
				'double' => true,
				'variables' => 'category_title|category_slug|author_name|title|slug|url|category_id|intro|body|parsed|created_on|updated_on|count',// the variables available inside the double tags
				'attributes' => 
				[
					'category' => 
					[
						'type' => 'slug',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
					'limit' => 
					[
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
					'offset' => 
					[
						'type' => 'number',
						'flags' => '',
						'default' => '0',
						'required' => false,
					],
					'order-by' => 
					[
						'type' => 'column',
						'flags' => '',
						'default' => 'created_on',
						'required' => false,
					],
					'order-dir' => 
					[
						'type' => 'flag',
						'flags' => 'asc|desc|random',
						'default' => 'asc',
						'required' => false,
					],
				],
			],
			'categories' => 
			[
				'description' => 
				[
					'en' => 'List blog categories.',
				],
				'single' => false,
				'double' => true,
				'variables' => 'title|slug|url',
				'attributes' => 
				[
					'limit' => 
					[
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
					'order-by' => 
					[
						'type' => 'flag',
						'flags' => 'id|title',
						'default' => 'title',
						'required' => false,
					],
					'order-dir' => 
					[
						'type' => 'flag',
						'flags' => 'asc|desc|random',
						'default' => 'asc',
						'required' => false,
					],
				],
			],
			'count_posts' => 
			[
				'description' => 
				[
					'en' => 'Count blog posts that meet the conditions specified.',					
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'category_id' => 
					[
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
					'author_id' => 
					[
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
					'status' => 
					[
						'type' => 'flag',
						'flags' => 'live|draft',
						'default' => '',
						'required' => false,
					],
				],
			],
			// method name
			'tags' => 
			[
				'description' => 
				[
					'en' => 'Retrieve all tags that have been applied to blog posts.',
				],
				'single' => false,
				'double' => true,
				'variables' => 'title|url',
				'attributes' => 
				[
					'limit' => 
					[
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
				],
			],
		];

		return $info;
	}

	/**
	 * Blog List
	 *
	 * Creates a list of blog posts. Takes all of the parameters
	 * available to streams, sans stream, where, and namespace.
	 *
	 * Usage:
	 * {{ blog:posts limit="5" }}
	 *		<h2>{{ title }}</h2>
	 * {{ /blog:posts }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function posts()
	{
		$this->load->driver('Streams');

		// Get all of our default entry items:
		$params = $this->streams->entries->entries_params;

		// Override them with some settings
		// that should be these values:
		$overrides = array(
			'stream'		=> 'blog',
			'namespace'		=> 'blogs',
			'where'			=> array("`status` = 'live'"),
			'order_by'		=> 'created_on',
			'sort'			=> 'desc',
			'show_past'		=> 'no',
			'date_by'		=> 'created_on',
			'limit'			=> $this->attribute('limit', null),
			'offset'		=> $this->attribute('offset')
		);
		foreach ($overrides as $k => $v)
		{
			$params[$k] = $v;
		}

		// Convert our two non-matching posts params to their
		// stream counterparts. This is for backwards compatability.

		// Order by
		if ($this->attribute('order-by')) {
			$params['order_by'] = $this->attribute('order-by');
		}
		elseif ($this->attribute('order_by')) {
			$params['order_by'] = $this->attribute('order_by');
		}

		// Sort
		if ($this->attribute('order-dir')) {
			$params['sort'] = $this->attribute('order-dir');
		}
		elseif ($this->attribute('order_by')) {
			$params['sort'] = $this->attribute('sort');
		}

		// See if we have any attributes to contribute.
		foreach ($params as $key => $default_value)
		{
			if ( ! in_array($key, array('where', 'stream', 'namespace')))
			{
				$params[$key] = $this->attribute($key, $default_value);
			}
		}

		// Categories
		// We need to filter by certain categories
		if ($category_string = $this->attribute('category'))
		{
			$categories = explode('|', $category_string);
			$cate_filter_by = [];

			foreach($categories as $category)
			{
				$cate_filter_by[] = '`'.$this->db->dbprefix('blog_categories').'`.`'.(is_numeric($category) ? 'id' : 'slug').'` = \''.$category."'";
			}

			if ($cate_filter_by)
			{
				$params['where'][] = implode(' OR ', $cate_filter_by);
			}
		}

		// Extra join and selects for categories.
		$this->row_m->sql['select'][] = $this->db->protect_identifiers('blog_categories.title', true)." as 'category_title'";
		$this->row_m->sql['select'][] = $this->db->protect_identifiers('blog_categories.slug', true)." as 'category_slug'";
		$this->row_m->sql['select'][] = $this->db->protect_identifiers('blog_categories.title', true)." as 'category||title'";
		$this->row_m->sql['select'][] = $this->db->protect_identifiers('blog_categories.slug', true)." as 'category||slug'";
		$this->row_m->sql['join'][] = 'LEFT JOIN '.$this->db->protect_identifiers('blog_categories', true).' ON '.$this->db->protect_identifiers('blog_categories.id', true).' = '.$this->db->protect_identifiers('blog.category_id', true);

		// Get our posts.
		$posts = $this->streams->entries->get_entries($params);

		if ($posts['entries'])
		{		
			// Process posts.
			// Each post needs some special treatment.
			foreach ($posts['entries'] as &$post)
			{
				$this->load->helper('text');

				// Keywords array
				$keywords = Keywords::get($post['keywords']);
				$formatted_keywords = [];
				$keywords_arr = [];

				foreach ($keywords as $key)
				{
					$formatted_keywords[] 	= array('keyword' => $key->name);
					$keywords_arr[] 		= $key->name;

				}
				$post['keywords'] = $formatted_keywords;
				$post['keywords_arr'] = $keywords_arr;

				// Full URL for convenience.
				$post['url'] = site_url('blog/'.date('Y/m', $post['created_on']).'/'.$post['slug']);
			
				// What is the preview? If there is a field called intro,
				// we will use that, otherwise we will cut down the blog post itself.
				$post['preview'] = (isset($post['intro'])) ? $post['intro'] : $post['body'];
			}
		}
		
		// {{ entries }} Bypass.
		// However, users can use {{ entries }} if using pagination.
		$loop = false;

		if (preg_match('/\{\{\s?entries\s?\}\}/', $this->content()) == 0)
		{
			$posts = $posts['entries'];
			$loop = true;
		}

		// Return our content.	
		return $this->streams->parse->parse_tag_content($this->content(), $posts, 'blog', 'blogs', $loop);
	}

	/**
	 * Categories
	 *
	 * Creates a list of blog categories
	 *
	 * Usage:
	 * {{ blog:categories order-by="title" limit="5" }}
	 *		<a href="{{ url }}" class="{{ slug }}">{{ title }}</a>
	 * {{ /blog:categories }}
	 *
	 * @param array
	 * @return array
	 */
	public function categories()
	{
		$limit     = $this->attribute('limit', null);
		$order_by  = $this->attribute('order-by', 'title');
		$order_dir = $this->attribute('order-dir', 'ASC');

		$categories = $this->db
			->select('title, slug')
			->order_by($order_by, $order_dir)
			->limit($limit)
			->get('blog_categories')
			->result();

		foreach ($categories as &$category)
		{
			$category->url = site_url('blog/category/'.$category->slug);
		}
		
		return $categories;
	}

	/**
	 * Count Posts By Column
	 *
	 * Usage:
	 * {{ blog:count_posts author_id="1" }}
	 *
	 * The attribute name is the database column and 
	 * the attribute value is the where value
	 * 
	 * @return int
	 */
	public function count_posts()
	{
		$wheres = $this->attributes();

		// make sure they provided a where clause
		if (count($wheres) == 0) return false;

		foreach ($wheres as $column => $value)
		{
			$this->db->where($column, $value);
		}

		return $this->db->count_all_results('blog');
	}
	
	/**
	 * Tag/Keyword List
	 *
	 * Create a list of blog keywords/tags
	 *
	 * Usage:
	 * {{ blog:tags limit="10" }}
	 *		<span><a href="{{ url }}" title="{{ title }}">{{ title }}</a></span>
	 * {{ /blog:tags }}
	 *
	 * @param array
	 * @return array
	 */	
	public function tags()
	{
		$limit = $this->attribute('limit', null);
		
		$this->load->library(array('keywords/keywords'));

		$posts = $this->db->select('keywords')->get('blog')->result();

		$buffer = []; // stores already added keywords
		$tags   = [];

		foreach($posts as $p)
		{
			$kw = Keywords::get_array($p->keywords);

			foreach($kw as $k)
			{
				$k = trim(strtolower($k));

				if(!in_array($k, $buffer)) // let's force a unique list
				{
					$buffer[] = $k;

					$tags[] = array(
						'title' => ucfirst($k),
						'url'   => site_url('blog/tagged/'.$k)
					);
				}
			}
		}
		
		if(count($tags) > $limit) // Enforce the limit
		{
			return array_slice($tags, 0, $limit);
		}
	
		return $tags;
	}


	/**
	 * Gets the next post info, with the id of the current post
	 *
	 *
	 * Usage:
	 * {{ blog:next current="10" }}
	 *		{{title}}
	 *		{{url}}
	 *		{{id}}
	 * {{ /blog:next }}
	 *
	 * @param array
	 * @return array
	 */	
	public function next()
	{
		$current = $this->attribute('current', 0);

		if($current = $this->db->where('id',$current)->get('blog')->row())
		{

		}
		else
		{
			return [];
		}

		if($next = $this->db->where('status','live')->where('created_on >',$current->created_on)->order_by('created_on','asc')->get('blog')->row())
		{
			return (array) $next;
		}

		//return the empty array
		return [];

	}

	public function prev()
	{
		$current = $this->attribute('current', 0);

		if($current = $this->db->where('id',$current)->get('blog')->row())
		{

		}
		else
		{
			return [];
		}

		if($prev = $this->db->where('status','live')->where('created_on <',$current->created_on)->order_by('created_on','desc')->get('blog')->row())
		{
			return (array) $prev;
		}

		//return the empty array
		return [];
	}	


	public function archive()
	{

		$this->load->model('blog/blog_m');
		$this->lang->load('blog/blog');

		$data = $this->blog_m->get_archive_months();

		$return = [];

		foreach($data as $month)
		{
			$item = [];
			$item['url'] = site_url('blog/archive/'.date('Y/m', $month->date));
			$item['post_count'] = $month->post_count;
			$item['month'] = format_date($month->date, lang('blog:archive_date_format'));

			$return[] = $item;
		}

		return $return;
	}

	/**
	 * {{ blog:recent limit='5' }}
	 *
	 * 			{{ url }}
	 *
	 * 			{{ date }}
 	 *
	 * 			{{ title }}
	 *
	 * {{ blog:recent }}
	 */
	public function recent()
	{

		// load the blog module's model
		$this->load->model('blog/blog_m');

		$limit = $this->attribute('limit', 5);

		// retrieve the records using the blog module's model
		$blogs = $this->blog_m
			->limit($limit)
			->get_many_by(array('status' => 'live'));


		$return = [];

		foreach($blogs as $blog)
		{
			$item = [];
			$item['url'] = 'blog/'.date('Y/m', $blog->created_on) .'/'.$blog->slug;
			$item['title'] = $blog->title;
			$item['date'] = date('D M Y', $blog->created_on);

			$return[] = $item;
		}

		return $return;
	}
		
}