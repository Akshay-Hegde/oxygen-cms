<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author Sal McDonald
 * @author Oxygen-CMS Dev Team
 */
/**
 * PyroStreams Integer Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_integer
{
	public $field_type_slug			= 'integer';
	
	public $db_col_type				= 'int';
	
	public $custom_parameters		= array('max_length', 'default_value', 'readonly');
	
	public $extra_validation		= 'integer';

	public $version					= '1.0.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');
		

	

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data,$params,$x)
	{
		return $this->gen_form_output($data,$params,$x,$admin_class='');
	}

	public function form_output_admin($data,$params,$x)
	{
		return $this->gen_form_output($data,$params,$x,'form-control');
	}

	private function gen_form_output($data,$params,$x,$admin_class='')
	{
		$options['name'] 	= $data['form_slug'];
		$options['id']		= $data['form_slug'];
		$options['value']	= $data['value'];
		$options['class']	= $admin_class;
		$options['placeholder'] = 'Points';

		$readonly = (isset($data['custom']['readonly'])) ? $data['custom']['readonly']  : '0' ;
		$uihidden = (isset($data['custom']['uihidden'])) ? $data['custom']['uihidden']  : '0' ;

		// Max length
		$max_length = (isset($data['max_length']) and $data['max_length']) ? $options['maxlength'] = $data['max_length'] : null;

		if($readonly=='1')
		{
			$slug				= $data['form_slug'];
			$value				= (int) $data['value'];
			if($uihidden==1)
			{
				return "<input type='hidden' id='{$slug}' name='{$slug}' value='{$value}' >";
			}
			return "<input type='hidden' id='{$slug}' name='{$slug}' value='{$value}' >".$value;
		}


		return form_input($options);	

	}
	private function get_default($data)
	{
		return $data['readonly'];
	}
	public function param_readonly($value = null)
	{	
		$value = ($value=='1')?'1':'0';
		$options = 
		[
			'1' => 'Yes',
			'0' => 'No',
		];
		return form_dropdown('readonly', $options, $value);
	}	
	
	public function param_uihidden($value = null)
	{	
		$value = ($value=='1')?'1':'0';
		$options = 
		[
			'1' => 'Hide from UI',
			'0' => 'Normal (Display)',
		];
		return form_dropdown('readonly', $options, $value);
	}	
}