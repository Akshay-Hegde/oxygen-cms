<?php defined('BASEPATH') OR exit('No direct script access allowed');
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
 * Poke a little run at the theme
 */
if (!function_exists('poke_func'))
{
	function poke_func($theme_slug,$func_name,$params=null)
	{
		$class = 'Theme_'.ucfirst($theme_slug);
		
		$class_instance = new $class;

		if (method_exists($class_instance, $func_name)  && is_callable(array($class_instance, $func_name)))
		{
			call_user_func(array($class_instance, $func_name),$params);
		}		
	}
}

if (!function_exists('initialize_theme'))
{
	function initialize_theme($theme_slug)
	{
		$class = 'Theme_'.ucfirst($theme_slug);
		
		$class_instance = new $class;
	
		if (method_exists($class_instance, 'initialize')  && is_callable(array($class_instance, 'initialize')))
		{
			$theme_values = call_user_func(array($class_instance, 'initialize'));
			$navgroups = explode(',',$theme_values['navigation-groups']);
			$widareas = explode(',',$theme_values['widget-areas']);
			$streams = $theme_values['streams'];

			foreach($navgroups as $group)
			{
				$slug =slugify(strtolower($group));
				$data = [];
				$data['title'] = $group;
				$data['slug'] = slugify($group);
				$data['order'] = 0;
				if(!get_instance()->db->where('slug',$slug)->get('navigation_groups')->row()) {
					get_instance()->db->insert('navigation_groups',$data);
				}
			}

			foreach($widareas as $area)
			{
				$slug = slugify(strtolower($area));
				$data = [];
				$data['name'] = $area;
				$data['slug'] = $slug;
				$data['order'] = 0;
				$data['created_on'] = time();
				$data['updated_on'] = time();
				if(!get_instance()->db->where('slug',$slug)->get('widget_areas')->row()) {
					get_instance()->db->insert('widget_areas',$data);
				}
			}	

			foreach($streams as $stream)
			{
				$stream['namespace'] = (isset($stream['namespace']))?$stream['namespace']:'lists';
				$stream_id  = get_instance()->streams->streams->add_stream($stream['name'], $stream['slug'],  $stream['namespace'] , '' ,  '');
			}
		
		}	
	}
}