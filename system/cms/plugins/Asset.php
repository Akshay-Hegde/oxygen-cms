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
 * Asset Plugin
 *
 * Load and print asset data
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Plugins
 */
class Plugin_Asset extends Plugin
{

	public $version = '1.0.0';

	public $name = 
	[
		'en' => 'Asset',
	];
	
	public $description = 
	[
		'en' => 'Access to static content such as CSS or Javascript file assets.',
	];

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Asset plugin for a larger example
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = 
		[
			'css' => 
			[
				'description' => 
				[
					'en' => 'Add a StyleSheet to a specific group. Returns empty.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'example'	=> '
				 {{hello:there}}
				',
				'attributes' => 
				[
					'file' => 
					[
						'type' => 'text',
						'required' => true,
					],
					'file_min' => 
					[
						'type' => 'text',
						'default' => '(uses normal file)',
						'required' => false,
					],
					'group' => 
					[
						'type' => 'text',
						'default' => 'global',
						'required' => false,
					],
				],
			],
			'css_inline' => 
			[
				'description' => 
				[
					'en' => 'Add inline CSS to the Assets Library. Automatically wrapped in <style> tag.',
				],
				'single' => false,
				'double' => true,
				'variables' => '',
				'attributes' => [],
			],
			'css_url' => 
			[
				'description' => 
				[
					'en' => 'Get the full file URL to a CSS asset.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'file' => 
					[
						'type' => 'text',
						'required' => true,
					],
				],
			],
			'css_path' => 
			[
				'description' => 
				[
					'en' => 'Get the file path to a CSS asset.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'file' => 
					[
						'type' => 'text',
						'required' => true,
					],
				],
			],
			
			'js' => 
			[
				'description' => 
				[
					'en' => 'Add a JavaScript file to a specific group. Returns empty.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'file' => 
					[
						'type' => 'text',
						'required' => true,
					],
					'file_min' => 
					[
						'type' => 'text',
						'default' => '(uses normal file)',
						'required' => false,
					],
					'group' => 
					[
						'type' => 'text',
						'default' => 'global',
						'required' => false,
					],
				],
			],
			'js_inline' => 
			[
				'description' => 
				[
					'en' => 'Add inline JS to the Assets Library. Automatically wrapped in <script> tag.',
				],
				'single' => false,
				'double' => true,
				'variables' => '',
				'attributes' => [],
			],
			'js_url' => 
			[
				'description' => 
				[
					'en' => 'Get the full file URL to a JS asset.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'file' => 
					[
						'type' => 'text',
						'required' => true,
					],
				],
			],
			'js_path' => 
			[
				'description' => 
				[
					'en' => 'Get the file path to a JS asset.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'file' => 
					[
						'type' => 'text',
						'required' => true,
					],
				],
			],
			
			'image' => array(
				'description' => array(
					'en' => 'Return an <img/> tag with an image from Assets.',
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'file' => array(
						'type' => 'text',
						'required' => true,
					),
					'alt' => array(
						'type' => 'text',
						'default' => '',
						'required' => false,
					),
					'[attribute]' => array(
						'type' => 'text',
						'required' => false,
					),
				),
			),
			'image_url' => 
			[
				'description' => 
				[
					'en' => 'Get the URL of an image from Assets.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'file' => 
					[
						'type' => 'text',
						'required' => true,
					],
				],
			],
			'image_path' => 
			[
				'description' => 
				[
					'en' => 'Get the file path of an image from Assets.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'file' => 
					[
						'type' => 'text',
						'required' => true,
					],
				],
			],
			
			'render' => 
			[
				'description' => 
				[
					'en' => 'Render the CSS and JS of a specific group.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'group' => 
					[
						'type' => 'text',
						'default' => 'global',
						'required' => false,
					],
				],
			],
			'render_css' => 
			[
				'description' => 
				[
					'en' => 'Render only the CSS of a specific group.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'group' => 
					[
						'type' => 'text',
						'default' => 'global',
						'required' => false,
					],
				],
			],
			'render_css_inline' => 
			[
				'description' => 
				[
					'en' => 'Render only the inline CSS.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => [],
			],
			'render_js' => 
			[
				'description' => 
				[
					'en' => 'Render only the JS of a specific group.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'group' => 
					[
						'type' => 'text',
						'default' => 'global',
						'required' => false,
					],
				],
			],
			'render_js_inline' => 
			[
				'description' => 
				[
					'en' => 'Render only the inline JS.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => [],
			],
		];
	
		return $info;
	}

	/**
	 * Asset CSS
	 *
	 * Insert a CSS tag
	 *
	 * Usage:
	 *
	 * {{ asset:css file="" group="" }}
	 *
	 * @return string Full url to css asset
	 */
	public function css()
	{
		$file     = $this->attribute('file');
		$file_min = $this->attribute('file_min');
		$group    = $this->attribute('group');

		return Asset::css($file, $file_min, $group);
	}
	
	/**
	 * Asset Inline CSS
	 *
	 * Insert a CSS tag
	 *
	 * Usage:
	 *
	 * {{ asset:css_inline }}
	 *   #id .class { background: red }
	 * {{ /asset:css_inline }}
	 *
	 * @return string empty
	 */
	public function css_inline()
	{
		$string = $this->content();
		
		return Asset::css_inline($string);
	}

	/**
	 * Asset CSS URL
	 *
	 * Generate CSS asset URLs.
	 *
	 * Usage:
	 *
	 * {{ asset:css_url file="" }}
	 *
	 * @return string Full url to CSS asset
	 */
	public function css_url()
	{
		$file = $this->attribute('file');

		return Asset::get_filepath_css($file, true);
	}

	/**
	 * Asset CSS Path
	 *
	 * Generate CSS asset path locations.
	 *
	 * Usage:
	 *
	 * {{ asset:css_path file="" }}
	 *
	 * @return string Path to the CSS asset relative to web root
	 */
	public function css_path()
	{
		$file = $this->attribute('file');

		return BASE_URI . Asset::get_filepath_css($file, false);
	}

	/**
	 * Asset Image
	 *
	 * Insert a image tag
	 *
	 * Usage:
	 *
	 * {{ asset:image file="" alt="" }}
	 *
	 * @return array Full url to image asset
	 */
	public function image()
	{
		$file = $this->attribute('file');
		$alt = $this->attribute('alt');

		$attributes = $this->attributes();
		unset($attributes['file']);
		unset($attributes['alt']);

		return Asset::img($file, $alt, $attributes);
	}

	/**
	 * Asset Image URL
	 *
	 * Helps generate image URLs.
	 *
	 * Usage:
	 *
	 * {{ asset:image_url file="" }}
	 *
	 * @return string Full url to image asset
	 */
	public function image_url()
	{
		$file = $this->attribute('file');

		return Asset::get_filepath_img($file, true);
	}

	/**
	 * Asset Image Path
	 *
	 * Helps generate image paths.
	 *
	 * Usage:
	 *
	 * {{ asset:image_path file="" }}
	 *
	 * @return string Path to the image asset relative to web root
	 */
	public function image_path()
	{
		$file = $this->attribute('file');

		return BASE_URI . Asset::get_filepath_img($file, false);
	}

	/**
	 * Asset JS
	 *
	 * Insert a JS tag
	 *
	 * Usage:
	 *
	 * {{ asset:js file="" group="" }}
	 *
	 * @return string
	 */
	public function js()
	{
		$file     = $this->attribute('file');
		$file_min = $this->attribute('file_min');
		$group    = $this->attribute('group');

		return Asset::js($file, $file_min, $group);
	}
	
	/**
	 * Asset Inline JS
	 *
	 * Insert a JS tag
	 *
	 * Usage:
	 *
	 * {{ asset:js_inline }}
	 *   alert('Are you sure?');
	 * {{ /asset:js_inline }}
	 *
	 * @return string empty
	 */
	public function js_inline()
	{
		$string = $this->content();
		
		return Asset::js_inline($string);
	}

	/**
	 * Asset JS URL
	 *
	 * Helps generate JavaScript asset locations.
	 *
	 * Usage:
	 *
	 * {{ asset:js_url file="" }}
	 *
	 * @return string Full url to the Javascript asset
	 */
	public function js_url()
	{
		$file = $this->attribute('file');

		return Asset::get_filepath_js($file, true);
	}

	/**
	 * Asset JS Path
	 *
	 * Helps generate JavaScript asset paths.
	 *
	 * Usage:
	 *
	 * {{ asset:js_path file="" }}
	 *
	 * @return string Path to the JavaScript asset relative to web root
	 */
	public function js_path()
	{
		$file = $this->attribute('file');

		return BASE_URI . Asset::get_filepath_js($file, false);
	}

	/**
	 * Asset Render
	 *
	 * Render an asset group (of JS and/or CSS).
	 *
	 * Usage:
	 *
	 * {{ asset:render group="" }}
	 *
	 * @return string Style and script tags for CSS and Javascript
	 */
	public function render()
	{
		$group = $this->attribute('group', false);

		return Asset::render($group);
	}

	/**
	 * Asset Render CSS
	 *
	 * Render a CSS asset group.
	 *
	 * Usage:
	 *
	 * {{ asset:render_css group="" }}
	 *
	 * @return string Style tags for CSS
	 */
	public function render_css()
	{
		$group = $this->attribute('group', false);

		return Asset::render_css($group);
	}

	/**
	 * Asset Render CSS Inline
	 *
	 * Render inline CSS.
	 *
	 * Usage:
	 *
	 * {{ asset:render_css_inline }}
	 *
	 * @return string Inline CSS content
	 */
	public function render_css_inline()
	{
		return Asset::render_css_inline();
	}
	
	/**
	 * Asset Render Javascript
	 *
	 * Render a Javascript asset group.
	 *
	 * Usage:
	 *
	 * {{ asset:render_js group="" }}
	 *
	 * @return string Script tags for Javascript
	 */
	public function render_js()
	{
		$group = $this->attribute('group', false);

		return Asset::render_js($group);
	}
	
	/**
	 * Asset Render JS Inline
	 *
	 * Render inline JS.
	 *
	 * Usage:
	 *
	 * {{ asset:render_js_inline }}
	 *
	 * @return string Inline JS content
	 */
	public function render_js_inline()
	{
		return Asset::render_js_inline();
	}

}