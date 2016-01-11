<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Widgets Plugin
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Widgets\Plugins
 */
class Plugin_Widgets extends Plugin
{

	public $version = '1.0.0';
	public $name = 
	[
		'en' => 'Widgets',
	];
	public $description = 
	[
		'en' => 'Display widgets',
	];

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = 
		[
			'display' => 
			[
				'description' => 
				[
					'en' => 'Render a widget specified by its id.',
				],
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => 
				[
					'id' => 
					[
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					],
					'name' => 
					[
						'type' => 'string',
						'flags' => '',
						'default' => '',
						'required' => false,
					],					
				],
			],// end first method
		];
	
		return $info;
	}


	public function __construct()
	{
		$this->load->library('widgets/widgets');
	}



	/**
	 * Display
	 *
	 * Usage:
	 * {{ widgets:display id="8" }}
	 * {{ widgets:display name="sidebar_login" }}
	 *
	 * @param array
	 * @return array
	 */
	public function display()
	{

		$id     = $this->attribute('id','---');
		$name     = $this->attribute('name','---');
		$area     = $this->attribute('area','---');

		if($area!='---')
		{
			return $this->widgets->render_area($area);
		}

		if($name!='---')
		{
			//else
			$widget = $this->widgets->get_instance_by_name($name);
			return $this->_getinstance($widget);
		}

		if($id!='---')
		{
			$widget = $this->widgets->get_instance($id);
			return $this->_getinstance($widget);
		}

		return '';
	
	}


	private function _getinstance($widget)
	{
		if ( ! $widget)
		{
			return;
		}

		$attributes = array_merge(
			[
				'instance_title'  => $widget->instance_title
			], 
			$this->attributes(), 
			[
				'instance_id'       => $widget->instance_id,
				'widget_id'         => $widget->id,
				'widget_slug'       => $widget->slug,
				'widget_title'      => $widget->title,
			]
		);

		$widget->options['widget'] = $attributes;

		return $this->widgets->render($widget->slug, $widget->options);
	}	
}

/* End of file Plugin.php */