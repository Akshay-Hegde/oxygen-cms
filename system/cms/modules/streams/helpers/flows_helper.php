<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * This entire file needs re-writing, linked to issue#5
 * a complete re-write of stream-permissions
 */
function can_flow($stream)
{
	$CI = get_instance();

	// Just allow the admins
	if( isset($CI->current_user->group) )
	{
		if( ($CI->current_user->group == 'admin') )
		{
			return true;
		}
	}

	/**
	 * Permissions are not set, 
	 * do not allow them in
	 */
	if (!isset($stream->permissions))
	{
		return false;
	} 

	//suppress warning
	$perms = @unserialize($stream->permissions);

	// if its not an array what do we have
	if ( ! is_array($perms)) 
		return false;


	//has the user got access to the stream admin ?
	if (in_array($CI->current_user->group_id, $perms)) 
		return true;


	return false;
}

function flow_or_die($stream, $redir_url ='admin/flows')
{
	$CI = get_instance();

	if(can_flow($stream))
	{
		return true;
	}

	$CI->session->set_flashdata('error', lang('cp:access_denied'));
	redirect($redir_url);
}


/**
 * Get the fields from the stream/flow 
 * and convert to assoc array
 */
function flows_fields_array($stream_id)
{
	$CI = get_instance();
    $CI->load->driver('Streams');

   	$stream_fields = $CI->streams_m->get_stream_fields($stream_id);
   	
    $fields = [];
    
    if( $stream_fields )
    {
        foreach( $stream_fields as $field )
        {
			$fields[$field->field_slug] = $field->field_name;
        }
    }

    return $fields;
}


function get_flow_or_redirect($stream_id, $redir=null)
{
	$CI = get_instance();	
	if ($stream = $CI->streams_m->get_stream($stream_id))
	{
		return $stream;
	}
	redirect($extra);		
}

function get_flow_or_warn($stream_id, $redir=null)
{
	$CI = get_instance();		
	if ($stream = $CI->streams_m->get_stream($stream_id))
	{
		return $stream;
	}
	show_error(lang('streams:invalid_stream_id'));		
}