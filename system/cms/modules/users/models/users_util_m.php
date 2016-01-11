<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The User model.
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Users\Models
 */
class Users_util_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->profile_table = $this->db->dbprefix('users_profiles');
	}

	public function get_users_select($field='id')
	{
		$this->db->select('users.email,users.id,users_profiles.first_name,users_profiles.last_name');
		$this->db->from('users');
		$result = $this->db->join('users_profiles', 'users_profiles.user_id = users.id')->get()->result();
		return $this->convert_to_select($result,$field);
	}

	public function get_user_email($id)
	{
		return $this->db->select('users.email')
						->from('users')
						->join('users_profiles', 'users_profiles.user_id = users.id')
						->where('users.id',$id)->get()->row();
	}

	public function get_all_but_user($user_id,$for='select') {

		$result = $this->db
			->select('users.email,users.id,users_profiles.first_name,users_profiles.last_name')
			->where('users.id !=',$user_id)
			->from('users')
			->join('users_profiles', 'users_profiles.user_id = users.id')->get()->result();

		switch($for) {
			case 'select':
				return $this->convert_to_select($result);
			default:
				break;
		}

		return $result;
	}

	/**
	 * as is either 'select' or 'normal'
	 */
	public function get_all_admin_users($for='select')
	{
		$result = [];

		if($admin_group = $this->db->where('name','admin')->get('users_groups')->row())
		{
			$result = $this->db
				->select('users.group_id,users.email,users.id,users_profiles.first_name,users_profiles.last_name')
				->where('users.id !=',$user_id)
				->where('users.group_id',$admin_group->id)
				->from('users')
				->join('users_profiles', 'users_profiles.user_id = users.id')->get()->result();
		}

		switch($for) {
			case 'select':
				$result = $this->convert_to_select($result);
			default:
				break;
		}

		return $result;

	}

	private function convert_to_select($result,$field='id')
	{
		$return = [];
		foreach($result as $key=>$user)
		{
			$return[$user->$field] = $user->last_name . ', ' . $user->first_name;
		}

		return $return;
	}
}