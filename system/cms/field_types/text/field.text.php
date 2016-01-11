<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Text Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_text
{
	public $field_type_slug			= 'text';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.0.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');
	
	public $custom_parameters		= array('max_length', 'default_value');

	private $use_placeholder 		= TRUE;
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data, $row_id=null, $field=null)
	{
		return $this->gen_text($data, $row_id, $field);
	}

	public function form_output_admin($data, $row_id=null, $field=null)
	{
		return $this->gen_text($data, $row_id, $field,'form-control');
	}

	public function gen_text($data, $row_id=null, $field=null, $admin_class = '')
	{
		$options['name'] 	= $data['form_slug'];
		$options['id']		= $data['form_slug'];
		$options['value']	= $data['value'];
		$options['class']	= $admin_class;

		$field = (array) $field;

		if($this->use_placeholder)
		{
			//get the label placeholder by converting the lang:string
			$options['placeholder']	= (substr($field['field_name'],0,5)=='lang:')?lang(substr($field['field_name'],5)):$field['field_name'];
		}

		if(!isset($options['placeholder']) OR trim($options['placeholder'])=='')
			$options['placeholder'] = $field['field_name'];

		if (isset($data['max_length']) and is_numeric($data['max_length']))
		{
			$options['maxlength'] = $data['max_length'];
		}

		return form_input($options);
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre Output
	 *
	 * No PyroCMS tags in text input fields.
	 *
	 * @return string
	 */
	public function pre_output($input)
	{
		$this->CI->load->helper('text');
		return escape_tags($input);
	}
}