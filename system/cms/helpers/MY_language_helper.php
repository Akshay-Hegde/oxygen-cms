<?php defined('BASEPATH') OR exit('No direct script access allowed.');
/**
 * OxygenCMS
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 * CodeIgniter Language Helpers
 *
 * @package		CodeIgniter
 */

function get_supported_lang()
{
	$supported_lang = config_item('supported_languages');

	$arr = [];
	foreach ($supported_lang as $key => $lang)
	{
		$arr[] = $key . '=' . $lang['name'];
	}

	return $arr;
}

// ------------------------------------------------------------------------

/**
 * Language Label
 *
 * Takes a string and checks for lang: at the beginning. If the
 * string does not have lang:, it outputs it. If it does, then
 * it will remove lang: and use the rest as the language line key.
 *
 * @param 	string
 * @return 	string
 */
if ( ! function_exists('lang_label'))
{
	function lang_label($key)
	{
		if (substr($key, 0, 5) == 'lang:')
		{
			return lang(substr($key, 5));
		}
		else
		{
			return $key;
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('sprintf_lang'))
{
    function sprintf_lang($line, $variables = [])
    {
        array_unshift($variables, lang($line));
        return call_user_func_array('sprintf', $variables);
    }
}