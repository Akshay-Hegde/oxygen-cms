<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 */
/**
 * Session Plugin
 *
 * Read and write session data
 *
 * @author  Oxygen-CMS Dev Team
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Url extends Plugin
{

	public $version = '1.0.0';

	public $name = 
	[
		'en' => 'URL',
	];

	public $description = 
	[
		'en' => 'Access URL variables, segments, and more.',
	];

	/**
	 * Returns a PluginDoc array
	 *
	 * Refer to the Blog plugin for full documentation
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = 
		[
			'current' => 
			[
				'description' => 
				[
					'en' => 'Output the current url.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => [],
			],
			'uri_string' => 
			[
				'description' => 
				[
					'en' => 'Output the current uri string.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => [],
			],
			'get' => 
			[
				'description' => 
				[
					'en' => 'Retrieve a GET variable from the url.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'key' => 
					[
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					],
				],
			],
			'site' => 
			[
				'description' => 
				[
					'en' => 'Display the site url of this installation with or without the index.php (depending on url rewrite settings).',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'uri' => 
					[
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
				],
			],
			'base' => 
			[
				'description' => 
				[
					'en' => 'Display the base url of the installation without the index.php.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => [],
			],
			'segments' => 
			[
				'description' => 
				[
					'en' => 'Return the specified segments from the url.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'segment' => 
					[
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					],
					'default' => 
					[
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
				],
			],
			'anchor' => 
			[
				'description' => 
				[
					'en' => 'Build an anchor tag with the url segments you pass in.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'segments' => 
					[
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
					'title' => 
					[
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
					'class' => 
					[
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
				],
			],
			'is_ssl' => 
			[
				'description' => 
				[
					'en' => 'Returns true if the site is running on https.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => [],
			],
			'redirect' => 
			[
				'description' => 
				[
					'en' => 'Send the visitor to another url.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'to' =>
					[
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => true,
					],
				],
			],
		];

		return $info;
	}

	/**
	 * Current uri string
	 *
	 * Usage:
	 *
	 *     {{ url:current }}
	 *
	 * @return string The current URI string.
	 */
	public function current()
	{
		return site_url($this->uri->uri_string());
	}
	
	/**
	 * Current uri string sans site_url()
	 *
	 * Usage:
	 *
	 *     {{ url:uri_string }}
	 *
	 * @return string The current URI string.
	 */
	public function uri_string()
	{
		return $this->uri->uri_string();
	}
	
	/**
	 * Current uri query_string
	 *
	 * Usage:
	 *
	 *     {{ url:query_string }}
	 *
	 * @return string The current URI string.
	 */
	public function query_string()
	{
		return $_SERVER['QUERY_STRING'];
	}
	
	/**
	 * Build a query string
	 *
	 * Usage:
	 *
	 *     {{ url:http_build_query use_query_string="no" skip="var1|var2" var3="foo" }}
	 *
	 * @return mixed Parameters
	 */
	public function http_build_query()
	{
		// Use current query_string?
		if ($this->attribute('use_query_string') == 'yes' and $this->input->get())
		{
			$query = $this->input->get();
		}
		else
		{
			$query = [];
		}

		
		// Skip any?
		if ($skips = $this->attribute('skip'))
		{
			foreach (explode('|', $this->attribute('skip')) as $skip)
			{
				unset($query[$skip]);
			}
		}


		// Build
		foreach ($this->attributes() as $key=>$value)
		{
			if (in_array($key, array('use_query_string', 'skip', 'parse_params'))) continue;

			$query[$key] = $value;
		}

		return http_build_query($query);
	}

	/**
	 * Current uri string
	 *
	 * Usage:
	 *
	 *     {{ url:get key="foo" }}
	 *
	 * @return string The key of the item in $_GET
	 */
	public function get()
	{
		return $this->input->get($this->attribute('key'));
	}

	/**
	 * Site URL of the installation.
	 *
	 * Usage:
	 *
	 *     {{ url:site }}
	 *
	 * @return string Site URL of the install.
	 */
	public function site()
	{
		$uri = $this->attribute('uri');

		return $uri ? site_url($uri) : rtrim(site_url(), '/') . '/';
	}

	/**
	 * Base URL of the installation.
	 *
	 * Usage:
	 *
	 *     {{ url:base }}
	 *
	 * @return string The base URL for the installation.
	 */
	public function base()
	{
		return base_url();
	}

	/**
	 * Get URI segment.
	 *
	 * Usage:
	 *
	 *     {{ url:segments segment="1" default="home" }}
	 *
	 * @return string The URI segment, or the provided default.
	 */
	public function segments()
	{
		$default = $this->attribute('default');
		$segment = $this->attribute('segment');

		return $this->uri->segment($segment, $default);
	}

	/**
	 * Build an anchor tag
	 *
	 * Usage:
	 *
	 *     {{ url:anchor segments="users/login" title="Login" class="login" }}
	 *
	 * @return string The anchor HTML tag.
	 */
	public function anchor()
	{
		$segments = $this->attribute('segments');
		$title    = $this->attribute('title', '');
		$class    = $this->attribute('class', '');

		$class = !empty($class) ? 'class="' . $class . '"' : '';

		return anchor($segments, $title, $class);
	}

	/**
	 * Test if the current protocol is SSL or not (https)
	 *
	 * Usage:
	 *
	 *     {{ if url:is_ssl }} Yep {{ else }} Nope {{ endif }}
	 *
	 * @return bool
	 */
	public function is_ssl()
	{
		return (isset($_SERVER['HTTPS']) ? ($_SERVER['HTTPS'] == "on" ? true : false) : false);
	}

	/**
	 * Send the visitor to another location
	 *
	 * Usage:
	 *
	 *     {{ url:redirect to="contact" }}
	 *
	 * @return bool
	 */
	public function redirect()
	{
		redirect($this->attribute('to'));
	}
}
