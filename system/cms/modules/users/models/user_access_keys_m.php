<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Users\Models
 */
class User_access_keys_m extends MY_Model
{
	protected $_table = 'users_access_keys';
	protected $profile_table = 'users_profiles';

	/**
	 * needs updating with a sql join
	 * same as by_module but gathers more profile data about them
	 */
	public function list_users($module='users')
	{
		$users = $this->db->where('module',$module)->get('users_access_keys')->result();

		foreach($users as $key => $user)
		{
			$users[$key]->profile = $this->get_profile_data(['id'=>$user->user_id]);
		}

		return $users;
	}

	private function get_profile_data($params)
	{
		if (isset($params['id']))
		{
			$this->db->where('users.id', $params['id']);
		}

		if (isset($params['email']))
		{
			$this->db->where('LOWER('.$this->db->dbprefix('users.email').')', strtolower($params['email']));
		}

		if (isset($params['role']))
		{
			$this->db->where('users.group_id', $params['role']);
		}

		$this->db
			->select($this->profile_table.'.*, users.*')
			->limit(1)
			->join('users_profiles', 'users_profiles.user_id = users.id', 'left');

		return $this->db->get('users')->row();
	}

	/**
	 * model->add(1,2,'forums')
	 */
	public function add($user_id,$ref_id,$module='users')
	{
		//first check that it exist, if so return true
		if($row = $this->has_access($user_id,$ref_id,$module))
		{
			return true;
		}

		//else
		$data = array( 'user_id'=> $user_id, 'module'=>$module, 'ref_id'=>$ref_id );

		return $this->db->insert('users_access_keys', $data );
	}
	
	public function has_access($user_id,$ref_id,$module='users')
	{
		if($row = $this->db->where('module',$module)->where('user_id',$user_id)->where('ref_id',$ref_id)->get('users_access_keys')->row())
		{
			return true;
		}	

		return false;
	}

	public function revoke_access($user_id,$ref_id,$module='users')
	{
		$this->db->where('module',$module)->where('user_id',$user_id)->where('ref_id',$ref_id)->delete('users_access_keys');
		return true;
	}	

	public function revoke_access_by_module_ref_id($ref_id,$module='users')
	{
		$this->db->where('module',$module)->where('ref_id',$ref_id)->delete('users_access_keys');
		return true;
	}		

	public function revoke_access_by_module($module='users')
	{
		$this->db->where('module',$module)->delete('users_access_keys');
		return true;
	}		

	public function revoke_access_by_id($id)
	{
		return $this->delete($id);
	}

	public function by_module($module='users')
	{
		return $this->db->where('module',$module)->get('users_access_keys')->result();
	}

	public function by_user($user_id=0)
	{
		return $this->db->where('user_id',$user_id)->get('users_access_keys')->result();
	}
	public function by_user_module($user_id=0,$module='users')
	{
		return $this->db->where('user_id',$user_id)->where('module',$module)->get('users_access_keys')->result();
	}


}