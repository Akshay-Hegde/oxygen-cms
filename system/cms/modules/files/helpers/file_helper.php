<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
if ( ! function_exists('file_folder_name'))
{
	function file_folder_name($folder_id=0)
	{
		$folders = get_instance()->db->get('file_folders')->result();
		foreach($folders as $cat) {
			if($cat->id ==$folder_id)
				return $cat->name;
		}
		return 'Default';
	}
}