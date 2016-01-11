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
class Field_boolean
{
	public $field_type_slug			= 'boolean';
	
	public $db_col_type				= 'int';

	public $col_constraint			= 1;

	public $custom_parameters		= array('dv','false_text','true_text');
	
	public $extra_validation		= 'integer';

	public $version					= '1.0.0';

	public $author					= array('name'=>'Sal McDonald', 'url'=>'http://oxygen-cms.com');



	public function param_dv($value)
	{
		return form_dropdown( 'dv' , array(0=>'False',1=>'True') , (($value)?$value:0)  );
	}


	/**
	 * Format the param false_text option in admin
	 * 
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function param_false_text($value)
	{

		return array(
		      'input'     => form_input('false_text', $value),
		      'instructions'  => 'Enter the text for the FALSE option'
		    );
	}

	/**
	 * Format the param true_text option in admin
	 * 
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function param_true_text($value)
	{
		return array(
		      'input'     => form_input('true_text', $value),
		      'instructions'  => 'Enter the text for the TRUE option'
		    );
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
			$data['value'] = (isset($field->field_data['dv'])) ? $field->field_data['dv'] : 0;
			$mode='new';
		}

		return $this->_display_as_dropdown($data, $data['value'], $mode );
	}

	public function form_output_admin($data,$entry_id)
	{
		$mode='edit';
		if ( ! $data['value'] and ! $entry_id)
		{
			$data['value'] = (isset($field->field_data['dv'])) ? $field->field_data['dv'] : 0;
			$mode='new';
		}

		return $this->_display_as_dropdown_alt($data, $data['value'], $mode );
	}	

	/**
	 * pre-format for display
	 * 
	 * @param  [type] $input  [description]
	 * @param  [type] $params [description]
	 * @return [type]         [description]
	 */
    public function pre_output($input, $params) 
    {

        $test = (!$input) ? FALSE : ((int)$input==1)?TRUE:FALSE;

        $key = ($test) ? 'true_text' : 'false_text' ;

        $r = $params['field_data'][$key];

        return $r;
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
		$no = $myoptions['false_text'];
		$yes = $myoptions['true_text'];
		$form_name = $data['form_slug'];
		$extra = "id='{$form_name}'";
		$options = ($mode=='new')? array( 0=>'False', 1 => 'True' ) : array( 0=>$no, 1 => $yes ) ;


		return form_dropdown( $form_name , $options , $value , $extra );
	}
	private function _display_as_dropdown_alt($data, $value,$mode='edit')
	{

		$myoptions = $data['custom'];
		if( ! is_array($myoptions))
		{
			$myoptions=unserialize($myoptions);
		}
		$no = $myoptions['false_text'];
		$yes = $myoptions['true_text'];
		$form_name = $data['form_slug'];
		$extra = "id='{$form_name}' class='form-control'";
		$options = ($mode=='new')? array( 0=>'False', 1 => 'True' ) : array( 0=>$no, 1 => $yes ) ;


		return form_dropdown( $form_name , $options , $value , $extra );
	}
}