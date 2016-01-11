<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * More added goodness by Store dev team
 */

/**
 * Fields Driver
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */ 
 
class Streams_fields extends CI_Driver {

	private $CI;

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
	}



	/**
	 * Add field
	 *
	 * @access	public
	 * @param	array - field_data
	 * @return	bool
	 */
	public function add_field($field)
	{
		extract($field);
	
		// -------------------------------------
		// Validate Data
		// -------------------------------------
		
		// Do we have a field name?
		if ( ! isset($name) or ! trim($name))
		{
			$this->log_error('empty_field_name', 'add_field');
			return false;
		}			

		// Do we have a field slug?
		if( ! isset($slug) or ! trim($slug))
		{
			$this->log_error('empty_field_slug', 'add_field');
			return false;
		}

		// Do we have a namespace?
		if( ! isset($namespace) or ! trim($namespace))
		{
			$this->log_error('empty_field_namespace', 'add_field');
			return false;
		}
		
		// Is this stream slug already available?
		if (is_object($this->CI->fields_m->get_field_by_slug($slug, $namespace)))
		{
			$this->log_error('field_slug_in_use', 'add_field');
			return false;
		}

		// Is this a valid field type?
		if ( ! isset($type) or ! isset($this->CI->type->types->$type) )
		{
			//var_dump($type);
			echo 'Type:'.$type.'<br>';
			echo 'Namespace:'.$namespace.'<br>';
			echo 'Name:'.$name.'<br>';
			echo 'Slug:'.$slug.'<br>';
			var_dump($this->CI->type->types);
			die;
			$this->log_error('invalid_fieldtype', 'add_field {'.$type.'}');

			return false;
		}

		// Set locked 
		$locked = (isset($locked) and $locked === true) ? 'yes' : 'no';
		
		// Set extra
		if ( ! isset($extra) or ! is_array($extra)) $extra = [];
	
		// -------------------------------------
		// Create Field
		// -------------------------------------

		if ( ! $this->CI->fields_m->insert_field($name, $slug, $type, $namespace, $extra, $locked)) return false;
		
		$field_id = $this->CI->db->insert_id();

		// -------------------------------------
		// Assignment (Optional)
		// -------------------------------------

		if (isset($assign) and $assign != '' and (is_object($stream = $this->CI->streams_m->get_stream($assign, true, $namespace))))
		{
			$data = [];
		
			// Title column
			if (isset($title_column) and $title_column === true)
			{
				$data['title_column'] = 'yes';
			}

			// Instructions
			$data['instructions'] = (isset($instructions) and $instructions != '') ? $instructions : null;
			
			// Is Unique
			if (isset($unique) and $unique === true)
			{
				$data['is_unique'] = 'yes';
			}
			
			// Is Required
			if (isset($required) and $required === true)
			{
				$data['is_required'] = 'yes';
			}
		
			// Add actual assignment
			return $this->CI->streams_m->add_field_to_stream($field_id, $stream->id, $data);
		}
		
		return $field_id;
	}



	/**
	 * Add an array of fields
	 *
	 * @access	public
	 * @param	array - array of fields
	 * @return	bool
	 */
	public function add_fields($fields)
	{
		if ( ! is_array($fields)) return false;
		$ret_value = true;	
		foreach ($fields as $field){
			if(!$this->add_field($field)){
	            $ret_value = false;
	        }
	    }
	    return $ret_value;
	}



	/**
	 * Assign field to stream
	 *
	 * @access	public
	 * @param	string - namespace
	 * @param	string - stream slug
	 * @param	string - field slug
	 * @param	array - assign data
	 * @return	mixed - false or assignment ID
	 */
	public function assign_field($namespace, $stream_slug, $field_slug, $assign_data = [])
	{
		// -------------------------------------
		// Validate Data
		// -------------------------------------

		if ( ! $stream = $this->stream_obj($stream_slug, $namespace))
		{
			$this->log_error('invalid_stream', 'assign_field');
			return false;
		}

		if ( ! $field = $this->CI->fields_m->get_field_by_slug($field_slug, $namespace))
		{
			$this->log_error('invalid_field', 'assign_field');
			return false;
		}

		// -------------------------------------
		// Assign Field
		// -------------------------------------

		$data = [];
		extract($assign_data);
	
		// Title column
		if (isset($title_column) and $title_column === true)
		{
			$data['title_column'] = 'yes';
		}

		// Instructions
		$data['instructions'] = (isset($instructions) and $instructions != '') ? $instructions : null;
		
		// Is Unique
		if (isset($unique) and $unique === true)
		{
			$data['is_unique'] = 'yes';
		}
		
		// Is Required
		if (isset($required) and $required === true)
		{
			$data['is_required'] = 'yes';
		}
	
		// Is Locked
		if (isset($locked) and $locked === true)
		{
			$data['is_locked'] = 'yes';
		}
	
		// Add actual assignment
		return $this->CI->streams_m->add_field_to_stream($field->id, $stream->id, $data);
	}



	/**
	 * De-assign field
	 *
	 * This also removes the actual column
	 * from the database.
	 *
	 * @access	public
	 * @param	string - namespace
	 * @param	string - stream slug
	 * @param	string - field slug
	 * @return	bool
	 */
	public function deassign_field($namespace, $stream_slug, $field_slug)
	{
		// -------------------------------------
		// Validate Data
		// -------------------------------------

		if ( ! $stream = $this->stream_obj($stream_slug, $namespace))
		{
			$this->log_error('invalid_stream', 'deassign_field');
			return false;
		}

		if ( ! $field = $this->CI->fields_m->get_field_by_slug($field_slug, $namespace))
		{
			$this->log_error('invalid_field', 'deassign_field');
			return false;
		}

		$obj = $this->CI->db
					->limit(1)
					->where('field_id', $field->id)
					->where('stream_id', $stream->id)
					->get(ASSIGN_TABLE);
		
		if ($obj->num_rows() == 0)
		{
			$this->log_error('invalid_assignment', 'deassign_field');
			return false;
		}
		
		$assignment = $obj->row();
		
		// -------------------------------------
		// De-assign Field
		// -------------------------------------

		return $this->CI->streams_m->remove_field_assignment($assignment, $field, $stream);
	}


	
	/**
	 * Delete field
	 *
	 * @access	public
	 * @param	string - field slug
	 * @param	string - field namespace
	 * @return	bool
	 */
	public function delete_field($field_slug, $namespace)
	{
		if ( ! trim($field_slug)) return false;
	
		if ( ! $field = $this->CI->fields_m->get_field_by_slug($field_slug, $namespace)) return false;
	
		return $this->CI->fields_m->delete_field($field->id);
	}



	/**
	 * Update field
	 *
	 * @access	public
	 * @param	string - slug
	 * @param	array - new data
	 * @return	bool
	 */
	/*function update_field($field_name, $field_slug, $field_namespace, $field_type, $extra_data)
	{
		if ( ! trim($field_slug) ) return false;
	
		if ( ! $field = $this->CI->fields_m->get_field_by_slug($field_slug, $field_namespace)) return false;

		return $this->CI->fields_m->update_field($field, $field_data);
	}*/



	/**
	 * Get assigned fields for
	 * a stream.
	 *
	 * @access	public
	 * @param	string - field slug
	 * @param	string - namespace
	 * @return	object
	 */
	public function get_field_assignments($field_slug, $namespace)
	{
		if ( ! trim($field_slug)) return false;
	
		if ( ! $field = $this->CI->fields_m->get_field_by_slug($field_slug, $namespace)) return false;
	
		return $this->CI->fields_m->get_assignments($field->id);
	}



	/**
	 * Get fields for a stream.
	 *
	 * This includes the input and other
	 * associated data.
	 *
	 * @param	string 	$stream 			Stream name
	 * @param	string 	$stream_namespace	Namespace name
	 * @param 	array 	$current_data		Any data that should be populated
	 * @param 	int 	$entry_id 			Entry if we are editing the fields.
	 * @param 	string 	$slug_prefix 		Optional prefix for field slugs.
	 * @return	object
	 */
	public function get_stream_fields($stream, $stream_namespace, $current_data = [], $entry_id = null, $slug_prefix = null, array $ignor_fields = [])
	{
		$assignments = $this->CI->fields_m->get_assignments_for_stream( $this->stream_id($stream, $stream_namespace) );

		$return = [];
		
		$this->CI->load->library('streams/Fields');
		
		if ( ! $assignments) return $return;
		
		$count = 0;

		foreach ($assignments as $assign)
		{
			// Do we have a prefix for the slug?
			// This is useful for things like Grid which need
			// to prefix the field slufs so it can have multiples.
			if ($slug_prefix) {
				$assign->field_slug = $slug_prefix.$assign->field_slug;
			}

			if(in_array($assign->field_slug,$ignor_fields)) continue;

			$value = (isset($current_data[$assign->field_slug])) ? $current_data[$assign->field_slug] : null;

			// Format the serialized stuff.
			$assign->field_data 			= @unserialize($assign->field_data);
			$assign->stream_view_options 	= @unserialize($assign->stream_view_options);
	
			$return[$count]['input'] = $this->CI->fields->build_form_input($assign, $value, $entry_id);
					
			// Other data
			$return[$count]['value'] 				= $value;
			$return[$count]['instructions']			= $assign->instructions;
			$return[$count]['field_name']			= $this->CI->fields->translate_label($assign->field_name);
			$return[$count]['field_unprocessed']	= $assign->field_name;
			$return[$count]['field_type']			= $assign->field_type;
			$return[$count]['field_slug']			= $assign->field_slug;
			
			$return[$count]['required']				= ($assign->is_required == 'yes') ? true : false;

			unset($value);
			
			$count++;
		}

		return $return;
	}



	/**
	 * This gets all the fields in a namespace
	 */
	//public function fields_table_data($namespace, $pagination = null, $pagination_uri = null, $extra = [], $skips = [])
	public function get_namespace_fields($namespace, $pagination = null, $pagination_uri = null, $extra = [], $skips = [])
	{

		$CI = get_instance();
		$data['buttons'] = isset($extra['buttons']) ? $extra['buttons'] : null;

		// Determine the offset and the pagination URI.
		if (is_numeric($pagination))
		{
			$segs = explode('/', $pagination_uri);
			$page_uri = count($segs)+1;
	
	 		$offset = $CI->uri->segment($page_uri, 0);

			// Calculate actual offset if not first page
			if ( $offset > 0 )
			{
				$offset = ($offset - 1) * $pagination;
			}
  		}
  		else
  		{
  			$page_uri = null;
  			$offset = 0;
  		}

		// -------------------------------------
		// Get fields
		// -------------------------------------

		if (is_numeric($pagination))
		{	
			$data['fields'] = $CI->fields_m->get_fields($namespace, $pagination, $offset, $skips);
		}
		else
		{
			$data['fields'] = $CI->fields_m->get_fields($namespace, false, 0, $skips);
		}

		// -------------------------------------
		// Pagination
		// -------------------------------------

		if (is_numeric($pagination))
		{	
			$data['pagination'] = create_pagination(
											$pagination_uri,
											$CI->fields_m->count_fields($namespace),
											$pagination, // Limit per page
											$page_uri // URI segment
										);
		}
		else
		{ 
			$data['pagination'] = null;
		}

		// Allow view to inherit custom 'Add Field' uri
		$data['add_uri'] = isset($extra['add_uri']) ? $extra['add_uri'] : null;
				
		// Otherwise, we are returning the table
		return $data;	
	}
}
