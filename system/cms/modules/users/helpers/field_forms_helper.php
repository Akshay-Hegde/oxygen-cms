<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin forms helps draw form-controls for field types
 */

function draw_admin_form($field,$options=[])
{
	
	extract($options);


	$extra = "id='".$field['field_slug']."' class='".$class."'";

	switch($field['field_type'])
	{
		case 'text':
			return form_input($field['field_slug'],$field['value'],$extra);
			break;
		case 'select':
		dump($field);die;
			break;
	}
}