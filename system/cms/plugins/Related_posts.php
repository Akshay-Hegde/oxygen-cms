<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 * Related Posts
 *
 * Fetches posts that are tagged with keyword(s) specified.
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 * @author		Rick Mills (WDWFans.com) <rick.sketchy@gmail.com>
 * @copyright	Copyright (c) 2012 Rick Mills
 *
 */
class Plugin_Related_Posts extends Plugin
{
	public $version = '1.0.0';
	
	public $name = 
	[
		'en' => 'Related Post',
	];
	
	public $description = 
	[
		'en' => 'Access Related Post for the Blog',
	];

	/**
	 * Posts
	 *
	 * Usage:
	 * {{ related_posts:posts keywords="keyword1,keyword2,keyword3,etc" maximum_posts="5" maximum_length="100" }}
	 *
	 * @return	string (related posts are returned as part of a list and should be wrapped with 'ul' or 'ol' tags.
	 */
	function posts()
	{
		$keywords = $this->attribute('keywords');
		$maxposts = $this->attribute('maximum_posts');
		$maxlength = $this->attribute('maximum_length');
		
		$keywordArray = explode(",", $keywords);
		
		$this->db->select('id');
		$this->db->from('keywords');
		$this->db->where_in('name', $keywordArray);
		$result = $this->db->get();
		
		$keywordIds = array();
		foreach($result->result() as $r)
		{
			$keywordIds[] = $r->id;
		}

		if(!empty($result))
		{
			$this->db->select('*');
			$this->db->from('keywords_applied');
			$this->db->where_in('keyword_id', $keywordIds);
			$applied = $this->db->get();
			
			if(!empty($applied))
			{
				$hash_store = array();
				foreach($applied->result() as $a)
				{
					$hash_store[] = $a->hash;
				}
				
				if(!empty($hash_store))
				{
					// time to search the blog posts!
					$this->db->select('*');
					$this->db->from('blog');
					$this->db->where_in('keywords', $hash_store);
					$this->db->limit($maxposts);
					$this->db->order_by('created_on', 'desc');
					$postQuery = $this->db->get();
					
					$postString = '';
					
					foreach($postQuery->result() as $post)
					{
						$postString .='<li>'.anchor('blog/'.date('Y/m', $post->created_on) .'/'.$post->slug, $this->neat_trim($post->title, $maxlength)).' - '.date('M jS Y', $post->created_on).'</li>';
					}
					
					return $postString;
				}
			}
		}
	}
	
	function neat_trim($str, $n, $delim='...') 
	{
	   $len = strlen($str);
	   if ($len > $n) 
	   {
	       preg_match('/(.{' . $n . '}.*?)\b/', $str, $matches);
	       return rtrim($matches[1]) . $delim;
	   }
	   else 
	   {
	       return $str;
	   }
	}
}
/* End of file related_posts.php */