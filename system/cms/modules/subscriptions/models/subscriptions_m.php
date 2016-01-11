<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subscriptions_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		
		$this->_table = 'subscriptions';
	}
	
	//create a new item
	public function create($name,$module='core') {
		
		$to_insert = [
			'name' 	=> $name,
			'order'	=>0,
			'module'=>$module,
		];

		if($this->db->insert($this->_table, $to_insert)) {
			return $this->db->insert_id();
		}
		return false;
	}

	public function edit($id, $name) {
		
		$to_update = [
			'name' 	=> $name,
		];
		return $this->db->where('id',$id)->update($this->_table, $to_update);
	}

	public function delete($id,$module='core') {

		$this->db->where('id',$id)->delete($this->_table);

		//now delete the subscribers
		$this->db->where('subscription_id',$id)->delete('subscribers');
		
		return true;

	}

	public function get($id) {

		return $this->db->where('id',$id)->get($this->_table)->row();
	}

	public function get_all_subscriptions()
	{
		return $this->db->get('subscriptions')->result();
	}


}
