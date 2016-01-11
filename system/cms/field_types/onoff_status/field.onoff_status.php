<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Store Boolean Field Type
 * 
 * The choice field just want good enought. It stores data as a VARCHAR, and we need INT(1) for better SQL
 *
 * @package		Store
 * @author		Store Dev Team : Sal McDonald 2012-2014
 * @copyright	Copyright (c) 2012 - 2014, Store
 */
class Field_onoff_status
{
	public $field_type_slug			= 'onoff_status';
	
	public $db_col_type				= 'int';

	public $col_constraint			= 1;

	public $custom_parameters		= ['default_value'];
	
	public $extra_validation		= 'integer';

	public $version					= '1.0.0';

	public $author					= array('name'=>'Sal McDonald', 'url'=>'http://oxygen-cms.com');


	public function param_dv($value)
	{
		return form_dropdown( 'default_value' , array(0=>'Off',1=>'On') , (((int)$value)?$value:0)  );
	}


	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data,$entry_id)
	{
		$mode='edit';

		if ( ! $data['value'] and ! $entry_id)
		{
			$data['value'] = (isset($field->field_data['default_value'])) ? $field->field_data['default_value'] : 0;
			$mode='new';
		}

		return $this->_display_as_dropdown($data, $data['value'], $mode );
	}


    /**
     * Display the drop
     * 
     * @param  [type] $data  [description]
     * @param  [type] $value [description]
     * @param  string $mode  [description]
     * @return [type]        [description]
     */
	private function _display_as_dropdown($data, $value,$mode='edit')
	{

		$myoptions = $data['custom'];
		if( ! is_array($myoptions))
		{
			$myoptions=unserialize($myoptions);
		}

		$extra = "id='{$data['form_slug']}' class='form-control'";
		$options = [ 0=>'Off', 1 => 'On' ];

		return form_dropdown( $data['form_slug'] , $options , $value , $extra );
	}

	/**
	 * Output for front-end
	 */
	public function pre_output($input,$params)
	{
		return $this->_get_string($input);
	}

	/**
	 * Output for Admin
	 */
	public function alt_pre_output($row_id, $extra, $type, $stream)
	{
		return $this->_get_string($extra);
	}

	/**
	 * Get the string value for the status
	 */
	private function _get_string($val)
	{
		if($val==1 || $val == '1') return 'On';
		
		return 'Off';
	}

}