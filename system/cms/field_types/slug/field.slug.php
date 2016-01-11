<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Slug Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_slug
{
	public $field_type_slug			= 'slug';
	
	public $db_col_type				= 'varchar';

	public $custom_parameters		= array( 'space_type', 'slug_field' );

	public $version					= '1.0.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	private $use_placeholder		= TRUE;

	// --------------------------------------------------------------------------

	/**
	 * Event
	 *
	 * Add the slugify plugin
	 *
	 * @access	public
	 * @return	void
	 */
	public function event()
	{
		if ( ! defined('ADMIN_THEME'))
		{
			//if we are not in the admin theme, we may need to load some resources
		}
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Pre Save
	 *
	 * No PyroCMS tags in slug fields.
	 *
	 * @return string
	 */
	public function pre_save($input)
	{
		$this->CI->load->helper('text');
		return escape_tags($input);
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre Output
	 *
	 * No PyroCMS tags in slugs.
	 *
	 * @return string
	 */
	public function pre_output($input)
	{
		$this->CI->load->helper('text');
		return escape_tags($input);
	}

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function form_output($params, $row_id=null, $field=null)
	{
		$options = [];
		return $this->gen_drop($options,$params,$field);
	}

	public function form_output_admin($params, $row_id=null, $field=null)
	{
		$options = [];
		$options['class']		= 'form-control';
		return $this->gen_drop($options,$params,$field);
	}	


	private function gen_drop( array $options, array $params,$field) {

		$options['name'] 	= $params['form_slug'];
		$options['id']		= $params['form_slug'];
		$options['value']	= $params['value'];	
			
		if($this->use_placeholder)
		{
			$field = (array) $field;
			//get the label placeholder by converting the lang:string
			$options['placeholder']	= (substr($field['field_name'],0,5)=='lang:')?lang(substr($field['field_name'],5)):$field['field_name'];
		}

		return form_input($options)."\n<script>(function($) {
			$(function(){
					oxy.generate_slug('#{$params['custom']['slug_field']}', '#{$params['form_slug']}', '{$params['custom']['space_type']}');
			});
		})(jQuery);
		</script>";
	}

	// --------------------------------------------------------------------------

	/**
	 * Dash or Underscore?
	 */	
	public function param_space_type($value = null)
	{	
		$options = [
			'-' => $this->CI->lang->line('streams:slug.dash'),
			'_' => $this->CI->lang->line('streams:slug.underscore')
		];
	
		return form_dropdown('space_type', $options, $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * What field to slugify?
	 */	
	public function param_slug_field($value = null)
	{
		$this->CI->load->model('fields_m');
	
		// Get all the fields
		$fields = $this->CI->fields_m->get_all_fields();
		
		$drop = array();
		
		foreach ($fields as $field)
		{
			// We don't want no slugs.
			if($field['field_type'] != 'slug')
			{
				$drop[$field['field_slug']] = $this->CI->fields->translate_label($field['field_name']);
			}
		}
		
		return form_dropdown('slug_field', $drop, $value);
	}

}