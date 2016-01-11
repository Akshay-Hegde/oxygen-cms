<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Oxygen_admin extends Theme {

    public $name			= 'Oxygen - Admin Theme';
    public $author			= 'OxygenCMS';
    public $author_website	= 'http://oxygen-cms.com/';
    public $website			= 'http://oxygen-cms.com/';
    public $description		= 'Oxygen Admin theme (default) - Twitter Bootstrap 3.x';
    public $version			= '1.0.0';
	public $type			= 'admin';
	public $options 		= [];

	/**
	 * Run() is triggered when the theme is loaded for use
	 *
	 * This should contain the main logic for the theme.
	 *
	 * @access	public
	 * @return	void
	 */
	public function run()
	{
		$data = new stdClass();
		
		if ($this->module == '' && $this->method != 'login' && $this->method != 'help')
		{
			//this only executes in dashboard
		}
		else
		{
			//executes on ALL other admin pages even login
		}


		$data->row1 = $this->db->where('is_visible',1)->where('section','row1')->get('widgets_admin')->result();
		$data->row2 = $this->db->where('is_visible',1)->where('section','row2')->get('widgets_admin')->result();
		$data->row3 = $this->db->where('is_visible',1)->where('section','row3')->get('widgets_admin')->result();		

		$this->get_analytics();

		$data->rss_items = $this->get_rss_feed();

		$this->get_recent_comments();

		$this->template->set($data);	
	}


	public function get_analytics()
	{
		$data = [];

		$data['analytic_visits'] = 0;
		$data['analytic_views'] = 0;
		$data['analytic_total_visits'] = 0;
		$data['analytic_views'] = 0;

		if ($this->settings->ga_email and $this->settings->ga_p12_key and $this->settings->ga_view_id)
		{

			// Not false? Return it
			if ( (1==3) && $cached_response = $this->oxycache->get('analytics'))
			{
				$data['analytic_visits'] = $cached_response['analytic_visits'];
				$data['analytic_views'] = $cached_response['analytic_views'];
				$data['analytic_total_visits'] = $cached_response['analytic_total_visits'];
				$data['analytic_views'] = $cached_response['analytic_views'];
			}
			else
			{
				try
				{
				    require_once(FCPATH . 'system/cms/libraries/Analytics.php');

					$analytics2 = new Analytics(['email'=>$this->settings->ga_email,'key_file'=>$this->settings->ga_p12_key]);

				    if($analytics2->initGapi()) {
				    	
				    } else {
				    	return;
				    }
					    
		
					// Set by GA Profile ID if provided, else try and use the current domain
					$analytics2->setProfileById($this->settings->ga_view_id);
					$end_date = date('Y-m-d');
					$start_date = date('Y-m-d', strtotime('-7 days'));
					$analytics2->setDateRange($start_date, $end_date);
					$visits = $analytics2->getVisitors();
					$views = $analytics2->getPageviews();
					
					$myviews = $myvisits = $labels = '';
					$isfirst = true;
					$data['analytic_total_visits'] = $data['analytic_total_views'] = 0;

					/* build tables */
					if (count($visits))
					{
						foreach ($visits as $date => $visit)
						{
							$_date = $this->cleanDate($date);
							$prepend = ($isfirst)?'':',';

							$labels 	.= $prepend . '"'.$_date.'"';
							$myvisits 	.= $prepend . $visit;
							$data['analytic_total_visits'] += (int) $visit;
							$data['analytic_total_views']  += (int) $views[$date];
							$myviews 	.= $prepend . $views[$date] ; 

							$isfirst = false;
						}
						$labels = '[' . $labels . ']';
						$myvisits = '[' . $myvisits . ']';
						$myviews = '[' . $myviews . ']';
					}
					$data['analytic_labels'] = $labels; //this is an  array
					$data['analytic_visits'] = $myvisits;
					$data['analytic_views'] = $myviews;
					// Call the model or library with the method provided and the same arguments
					$this->oxycache->write(
						[	
							'analytic_total_visits' => $data['analytic_total_visits'],
							'analytic_total_views'=> $data['analytic_total_views'] ,
							'analytic_visits' => $data['analytic_visits'],
							'analytic_views' => $data['analytic_views']
						],
						'analytics', 5 /* 6 hours - (60 * 60 * 6) */
					); 
				}
				catch (Exception $e)
				{
					$data['messages']['notice'] = sprintf(lang('cp:google_analytics_no_connect').'<br>'.$e->getMessage(), anchor('admin/settings', lang('cp:nav_settings')));
				}
			}

	
			// make it available in the theme
			$this->template->set($data);
		}
	}

	private function cleanDate($date)
	{
		$year = substr($date, 0, 4);
		$month = substr($date, 4, 2);
		$day = substr($date, 6, 2);
		return $day.'/'.$month.'/'.$year;
	}
	

	public function get_rss_feed()
	{
		// Dashboard RSS feed (using SimplePie)
		$this->load->library('simplepie');
		$this->simplepie->set_cache_location($this->config->item('simplepie_cache_dir'));
		$this->simplepie->force_feed(true);
		$this->simplepie->set_feed_url($this->settings->dashboard_rss);
		
		$this->simplepie->init();
		$this->simplepie->handle_content_type();


		// Store the feed items
		return $this->simplepie->get_items(0, $this->settings->dashboard_rss_count);
		
	}
	
	public function get_recent_comments()
	{
		$this->load->library('comments/comments');
		$this->load->model('comments/comments_m');
		$this->load->model('users/user_m');
		$this->lang->load('comments/comments');

		$recent_comments = $this->comments_m->get_recent(5);
		$data['recent_comments'] = $this->comments->process($recent_comments);
		
		$this->template->set($data);
	}
		
}
/* End of file Theme.php */