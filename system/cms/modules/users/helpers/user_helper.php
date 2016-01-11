<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Phil Sturgeon
 */
// ------------------------------------------------------------------------

/**
 * Checks to see if a user is logged in or not.
 * 
 * @access public
 * @return bool
 */
function is_logged_in()
{
    return (isset(get_instance()->current_user->id)) ? true : false; 
}

// ------------------------------------------------------------------------


/**
 * Checks if a group has access to module or role
 * 
 *
 * @access public
 * @param string $module sameple: pages
 * @param string $role sample: put_live
 * @return bool
 */
function group_has_role($module, $role)
{
    // Uh...noo
	if (empty(get_instance()->current_user)) {
		return false;
	}

    // go right it ?
    if (get_instance()->current_user->group === 'admin') {
        return true;
    }

    // check permissions for user and group (group first)
	$permissions = get_instance()->permission_m->get_group(get_instance()->current_user->group_id);
	
	if (empty($permissions[$module]) or empty($permissions[$module][$role]))
	{
        //now check if the user has access
        $permissions_user = get_instance()->permission_m->get_user(get_instance()->current_user->id);
        if (empty($permissions_user[$module]) or empty($permissions_user[$module][$role]))  {
            return false;
        }
        else {
		  return true;
        }
	}

	return true;
}

// ------------------------------------------------------------------------

/**
 * Checks if role has access to module or returns error 
 * 
 * @access public
 * @param string $module sample: pages
 * @param string $role sample: edit_live
 * @param string $redirect_to (default: 'admin') Url to redirect to if no access
 * @param string $message (default: '') Message to display if no access
 * @return mixed
 */
function role_or_die($module, $role, $redirect_to = 'admin', $message = '')
{
    get_instance()->lang->load('admin');

    if (! group_has_role($module, $role))
    {
        if (get_instance()->input->is_ajax_request())
        {
            echo json_encode(array('error' => ($message ? $message : lang('cp:access_denied')) ));
            return false;
        }

        get_instance()->session->set_flashdata('error', ($message ? $message : lang('cp:access_denied')) );
        redirect($redirect_to);
        
    }
    
    return true;
}
// ------------------------------------------------------------------------

/**
 * Return a users display name based on settings
 *
 * @param int $user the users id
 * @param string $linked if true a link to the profile page is returned, 
 *                       if false it returns just the display name.
 * @return  string
 */
function user_displayname($user, $linked = true,$display_override=false)
{
    // User is numeric and user hasn't been pulled yet isn't set.
    if (is_numeric($user))
    {
        $user = get_instance()->ion_auth->get_user($user);
    }

    if($user)
    {
        $user = (array) $user;
        $name = empty($user['display_name']) ? $user['username'] : $user['display_name'];
        //$name =  $user['first_name'].' '.$user['last_name'];
        if($display_override)
        {
            $name = $display_override;
        }


        // Static var used for cache
        if ( ! isset($_users))
        {
            static $_users = array();
        }

        // check if it exists
        if (isset($_users[$user['id']]))
        {
            if( ! empty( $_users[$user['id']]['profile_link'] ) and $linked)
            {
                return $_users[$user['id']]['profile_link'];
            }
            else
            {
                return $name;
            }
        }

        // Set cached variable.
        if (get_instance()->settings->enable_profiles and $linked)
        {
            $_users[$user['id']]['profile_link'] = anchor('user/'.$user['id'], $name);
            return $_users[$user['id']]['profile_link'];
        }

        // Not cached, Not linked. get_user caches the result so no need to cache non linked
        return $name;  
    }

    return '--unknown--';

    
}

/* End of file users/helpers/user_helper.php */