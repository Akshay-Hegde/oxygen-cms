<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_search_lib
{

	protected static $results;
	protected static $added;

	public function __construct()
	{
		get_instance()->load->driver('Streams');

		self::$added 	= [];		
		self::$results 	=
		[
			'total-results'=>0,
			'results'=> []
		];
	}


	public function admin_search($query_string='') 
	{
		$terms = explode ( ' ', $query_string );

		foreach($terms as $term) {
			$this->list_all_blogs($term);
		}

		return self::$results;
	}

	private function list_all_blogs($term) {

		$posts = get_instance()->db->like('title',''.$term.'')->get('blog')->result();

		foreach($posts as $post) 
		{
			if(isset(self::$added[$post->id])) {
				//pass this post is already added
				continue; 
			}

			//add the index
			self::$added[$post->id]= $post->id;

			$this->_add_result($post);
		}	
	}

	private function _add_result($post)
	{
		self::$results['total-results'] = self::$results['total-results'] + 1;
		self::$results['results'][] = 
		[
			'title'=>$post->title,
			'icon'=> 'fa fa-edit',
			'description'=>$post->title,
			'url'=>site_url('blog/view/'.$post->slug),
			'admin_url'=>site_url('admin/blog/edit/'.$post->id),
		];
	}



}
