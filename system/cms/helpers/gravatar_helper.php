<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * Gravatar helper for CodeIgniter.
 * @package 	PyroCMS\Core\Helpers
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 */
if (!function_exists('gravatar'))
{
	/**
	 * Extended by Store Dev Team
	 * -Added class_override capabilities
	 *
	 * Gravatar helper for CodeIgniter.
	 *
	 * @param string $email The Email address used to generate the gravatar
	 * @param int $size The size of the gravatar in pixels. A size of 50 would return a gravatar with a width and height of 50px.
	 * @param string $rating The rating of the gravatar. Possible values are g, pg, r or x
	 * @param boolean $url_only Set this to true if you want the plugin to only return the gravatar URL instead of the HTML.
	 * @param boolean $default Url to image used instead af Gravatars default when email has no gravatar
	 * @return string The gravatar's URL or the img HTML tag ready to be used.
	 */
	function gravatar($email = '', $size = 50, $rating = 'g', $url_only = false, $default = false, $class='gravatar',$style='')
	{
		$base_url = (IS_SECURE ? 'https://secure.gravatar.com' : 'http://www.gravatar.com').'/avatar/';
		$email = empty($email) ? '3b3be63a4c2a439b013787725dfce802' : md5(strtolower(trim($email)));
		$size = '?s='.$size;
		$rating = '&amp;r='.$rating;
		$default = ! $default ? '' : '&amp;d='.urlencode($default);

		$gravatar_url = $base_url.$email.$size.$rating.$default;
		// URL only or the entire block of HTML ?
		if ($url_only == true)
		{
			return $gravatar_url;
		}

		return '<img src="'.$gravatar_url.'" alt="Gravatar" class="'.$class.'" style="'.$style.'"/>';
	}

	function gravatar_alt($email = '', $options=[])
	{
		$size = (isset($options['size']))?$options['size']:50;
		$rating = (isset($options['rating']))?$options['rating']:'g';
		$url_only = (isset($options['url_only']))?$options['url_only']:false;
		$default= (isset($options['default']))?$options['default']:false;
		$class = (isset($options['class']))?$options['class']:'gravatar';
		$style = (isset($options['style']))?$options['style']:'';
		return gravatar($email, $size, $rating, $url_only, $default, $class,$style);
	}
}