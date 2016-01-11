<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 * PyroCMS Admin Theme Helpers
 *
 * @package		PyroCMS\Core\Modules\Theme\Helpers
 */
if ( ! function_exists('anchor_if'))
{
	/**
	 * Anchor (IF) condition Link
	 *
	 * Creates an anchor based on the local URL only if the condition is met.
	 *
	 * @param	string	the URL
	 * @param	string	the link title
	 * @param	mixed	any attributes
	 * @return	string
	 */
	function anchor_if($condition, $uri = '', $title = '', $attributes = '')
	{
		if($condition) {
			return anchor($uri, $title, $attributes );
		}
		return $title;
	}
}
if (!function_exists('add_template_section'))
{
	function add_template_section($obj,$section,$text,$path,$shortcust=[])
	{

		$sections = $obj->module_details['sections'];
        $sections[$section] = 
        [
            'name' => $text,
            'uri' => $path,
            'shortcuts' => $shortcust
        ];
        $obj->module_details['sections'] = $sections;
		$obj->template->set('module_details', $obj->module_details);
	}
}

if (!function_exists('add_template_shortcuts'))
{
	function add_template_shortcuts($obj,$section,$shortcust=[])
	{
		$sections = $obj->module_details['sections'];

        $sections[$section]['shortcuts'] = array_merge($sections[$section]['shortcuts'],$shortcust);

        $obj->module_details['sections'] = $sections;

		$obj->template->set('module_details', $obj->module_details);

	}
}

/**
 * Partial Helper
 *
 * Loads the partial
 *
 * @param string $file The name of the file to load.
 * @param string $ext The file's extension.
 */
function file_partial($file = '', $ext = 'php')
{
	$CI = & get_instance();
	$data = & $CI->load->_ci_cached_vars;

	$path = $data['template_views'].'partials/'.$file;

	echo $CI->load->_ci_load(array(
		'_ci_path' => $data['template_views'].'partials/'.$file.'.'.$ext,
		'_ci_return' => true
	));
}

function theme_image($file = '',$options=null,$type='img')
{

	$file = trim(Asset::get_filepath_img( $file ));

	if($type=='path'){
		return site_url($file);
	}

	return '<img src="'.site_url($file) .'">';
}

/**
 * Template Partial
 *
 * Display a partial set by the template
 *
 * @param string $name The view partial to display.
 */
function template_partial($name = '')
{
	$CI = & get_instance();
	$data = & $CI->load->_ci_cached_vars;

	echo isset($data['template']['partials'][$name]) ? $data['template']['partials'][$name] : '';
}


/**
 * Add an admin menu item to the order array
 * at a specific place.
 *
 * For instance, if you have a menu item with a keu 'lang:my_menu',
 * and you want to add it to the 2nd position, you can do this:
 *
 * add_admin_menu_place('lang:my_menu', 2);
 *
 * @param 	string
 * @param 	int
 * @return 	void
 */
function add_admin_menu_place($key, $place)
{
	if ( ! is_numeric($place) or $place < 1)
	{
		return null;
	}

	$place--;

	$CI = get_instance();

	$CI->template->menu_order = array_merge(array_slice($CI->template->menu_order, 0, $place, true), array($key), array_slice($CI->template->menu_order, $place, count($CI->template->menu_order)-1, true));
}


/**
 * Accented Foreign Characters Output
 *
 * @return null|array The array of the accented characters and their replacements.
 */
function accented_characters()
{
	if (defined('ENVIRONMENT') and is_file(APPPATH.'config/'.ENVIRONMENT.'/foreign_chars.php'))
	{
		include(APPPATH.'config/'.ENVIRONMENT.'/foreign_chars.php');
	}
	elseif (is_file(APPPATH.'config/foreign_chars.php'))
	{
		include(APPPATH.'config/foreign_chars.php');
	}

	if (!isset($foreign_characters))
	{
		return;
	}

	$languages = [];
	foreach ($foreign_characters as $key => $value)
	{
		$languages[] = [
			'search' => $key,
			'replace' => $value
		];
	}

	return $languages;
}