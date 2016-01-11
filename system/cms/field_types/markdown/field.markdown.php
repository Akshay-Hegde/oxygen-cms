<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Textarea Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_markdown
{
	public $field_type_slug			= 'markdown';
	
	public $db_col_type				= 'longtext';

	public $admin_display			= 'full';

	public $version					= '1.0.0';

	public $author					= array('name' => 'Sal McDonald', 'url' => 'http://oxygen-cms');

	public $custom_parameters		= array('default_text', 'allow_tags', 'contentbase_url');
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data, $entry_id, $field)
	{
		// Value
		// We only use the default value if this is a new entry
		if ( ! $entry_id)
		{
			$value = (isset($field->field_data['default_text']) and $field->field_data['default_text']) 
				? $field->field_data['default_text']
				: $data['value'];

			// If we still don't have a default value, maybe we have it in
			// the old default value string. So backwards compat.
			if ( ! $value and isset($field->field_data['default_value']))
			{
				$value = $field->field_data['default_value'];
			}
		}
		else
		{
			$value = $data['value'];
		}

		return form_textarea(array(
			'name'		=> $data['form_slug'],
			'id'		=> $data['form_slug'],
			'value'		=> $value,
			'class'		=> 'form-control'
		));
	}

	// --------------------------------------------------------------------------

	public function pre_save($input)
	{
		//dump($input);die;
		return $input;
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre-Ouput content
	 *
	 * @access 	public
	 * @return 	string
	 */
	public function pre_output($input, $params)
	{
		$parse_tags = ( isset($params['allow_tags'])) ?  $params['allow_tags'] : 'n';
		$contentbase_url = ( isset($params['contentbase_url'])) ? $params['contentbase_url'] : '';

		// If this is the admin, show only the source
		// @TODO This is hacky, there will be times when the admin wants to see a preview or something
		if (defined('ADMIN_THEME'))
		{
			return $input;
		}

		// If this isn't the admin and we want to allow tags,
		// let it through. Otherwise we will escape them.
		if ($parse_tags == 'y')
		{
			$content = $this->CI->parser->parse_string($input, array(), true);
		}
		else 
		{
			$content = $input;
		}

		$parser = new Oxygen\Parsers\Markdown\MarkDownParser();

		$parser->setUrlsLinked(false);
		$parser->setBreaksEnabled(true); # enables automatic line breaks
		$parser->setMarkupEscaped(false); # escapes markup (HTML)
		$parser->setBaseUrl($contentbase_url); 
		return $parser->text($content);

	}

	// --------------------------------------------------------------------------
	
	/**
	 * Default Textarea Value
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function param_default_text($value = null)
	{
		return form_textarea(array(
			'name'		=> 'default_text',
			'id'		=> 'default_text',
			'value'		=> $value,
		));
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Allow tags param.
	 *
	 * Should tags go through or be converted to output?
	 */
	public function param_allow_tags($value = null)
	{
		$options = array(
			'n'	=> lang('global:no'),
			'y'	=> lang('global:yes')
		);

		// Defaults to No
		$value or $value = 'n';
	
		return form_dropdown('allow_tags', $options, $value,'class="form-control"');
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Content Type
	 *
	 * Is this plain text, HTML or Markdown?
	 */
	public function param_contentbase_url($value = null)
	{
		// Defaults to Plain Text
		$value or $value = base_url();
	
		return form_input('contentbase_url', $value,'class="form-control"');
	}	

}
