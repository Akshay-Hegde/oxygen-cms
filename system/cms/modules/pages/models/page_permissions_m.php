<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Page_permissions_m extends MY_Model
{
	protected $_table = 'pages_permissions';

	public function __construct() {
		parent::__construct();
	}


	public function save($id,$dpa=[],$daa=[]) {

		//create hash of new data

		//compare hash of new and existing data

		//delete what needs to be removed
		$this->db->where('page_id',$id)->delete($this->_table);

		$all_users = [];
		foreach ($daa as $user_id => $value) {
			$all_users[$user_id]=[];
			$all_users[$user_id]['admin'] = true;
			$all_users[$user_id]['public'] = false;
		}
		foreach ($dpa as $user_id => $value) {
			//change my value
			$all_users[$user_id]['admin'] = (isset($all_users[$user_id]['admin']))?$all_users[$user_id]['admin']:false;
			$all_users[$user_id]['public'] = true;
		}

		foreach($all_users as $user_id => $data) {
			//no records will exist for this user, and page id
			$this->db->insert($this->_table,[
				'page_id' => $id,
				'user_id' => $user_id,
				'access_front' => $data['public'],
				'access_admin' => $data['admin'],
			]);

		}

	}

	public function has_public_access($user_id,$page_id) {
		
		if($row = $this->db->where('user_id',$user_id)->where('page_id',$page_id)->get($this->_table)->row())
		{
			//well if they have admin give them public as well
			return ($row->access_admin) OR $row->access_front;
		}

		return false;
	}


	public function has_admin_access($user_id,$page_id) {
		
		if($row = $this->db->where('user_id',$user_id)->where('page_id',$page_id)->get($this->_table)->row())
		{
			//well if they have admin give them public as well
			return ($row->access_admin);
		}

		return false;
	}

	/**
	 * This gets a list of users with the merged permissions
	 */
	public function get_users_merged($page_id=null) {

		$admin_group = $this->db->where('name','admin')->get('users_groups')->row();
		//
		// We also need to join with groups so that we can avoid any group that is admin
		//
		$users = $this->db
			->select('users_profiles.display_name, users.id')
			->join('users_profiles', 'users_profiles.user_id = users.id', 'left')
			->where('group_id !=',$admin_group->id)
			->get('users')
			->result();


		foreach($users as &$u) {
			$r = null;

			if( $page_id !== null ) {
				$r = $this->db->where('page_id',$page_id)->where('user_id',$u->id)->get($this->_table)->row();
			}

			if($r) {
				$u->has_dpa = ($r->access_front==1)?true:false;
				$u->has_daa = ($r->access_admin==1)?true:false;
			} else {
				$u->has_dpa = false;
				$u->has_daa = false;
			}
		}

		return $users;
	}

}
