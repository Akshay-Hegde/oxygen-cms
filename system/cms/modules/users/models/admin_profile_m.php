<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Users\Models
 */
class Admin_profile_m extends MY_Model
{

	public function get_profile($user_id)
	{
		return $this->db->where('user_id',$user_id)->get('users_admin_profiles')->row();
	}


}