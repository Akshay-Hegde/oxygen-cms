<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * OxygenCMS
 * Integration Plugin
 *
 * Attaches a Google Analytics tracking piece of code.
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Integration extends Plugin
{

	public $version = '1.0.0';

	public $name = 
	[
		'en' => 'Integration',
	];

	public $description = 
	[
		'en' => 'Google analytics tracking code and data.',
	];

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'analytics' => array(
				'description' => 
				[ 
					'en' => 'Output the Google Analytics tracking code to your theme.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => [],
			),// end analytics method
			'visitors' => 
			[
				'description' => 
				[
					'en' => 'Show the number of visitors as recorded by Google Analytics since the specified date. Cache for [refresh] hours.'
				],
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'start' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '2010-01-01',
						'required' => false,
					),
					'end' => array(
						'type' => 'text',
						'flags' => '',
						'default' => date('Y-m-d'),
						'required' => false,
					),
					'refresh' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '24',
						'required' => false,
					),
				),
			],
		);
	
		return $info;
	}

	/**
	 * Partial
	 *
	 * Loads Google Analytic
	 *
	 * Usage:
	 *
	 *     {{ integration:analytics }}
	 *
	 * @return string The analytics partial view.
	 */
	public function analytics()
	{
		return $this->load->view('fragments/google_analytics', null, true);
	}
	/**
	 * Visitors
	 *
	 * Uses Google Analytics data to show page views and visitors for a given time period
	 *
	 * Usage:
	 *
	 *     {{ integration:visitors }}
	 *
	 * @return array The number of page views and visitors.
	 */
	public function visitors()
	{
		$data    = 
		[
			'visits' => 0,
			'views'  => 0
		];
		
		$start   = $this->attribute('start', '2010-01-01');
		$end     = $this->attribute('end', date('Y-m-d'));
		$refresh = $this->attribute('refresh', 24); // refresh the cache every n hours
		if (Settings::get('ga_email') and Settings::get('ga_p12_key') and Settings::get('ga_view_id'))
		{
			// do we have it? Return it
			if ($cached_response = $this->oxycache->get('analytics_plugin'))
			{
				return $cached_response;
			}
			try
			{
				$this->load->library('analytics', [
					'email' => Settings::get('ga_email'),
					'key_file' => Settings::get('ga_p12_key')
				]);
				// Set by GA Profile ID if provided, else try and use the current domain
				$this->analytics->setProfileById(Settings::get('ga_view_id'));
				$this->analytics->setDateRange($start, $end);
				$visits = $this->analytics->getVisitors();
				$views = $this->analytics->getPageviews();
				if ($visits)
				{
					foreach ($visits as $visit)
					{
						if ($visit > 0)
						{
							$data['visits'] += $visit;
						}
					}
				}
				if ($views)
				{
					foreach ($views as $view)
					{
						if ($view > 0)
						{
							$data['views'] += $view;
						}
					}
				}
				// Call the model or library with the method provided and the same arguments
				$this->oxycache->write($data, 'analytics_plugin', 60 * 60 * (int) $refresh); // 24 hours
			}
			catch (Exception $e)
			{
				log_message('error', 'Could not connect to Google Analytics. Called from the analytics plugin');
			}
		}
		return $data;
	}
}