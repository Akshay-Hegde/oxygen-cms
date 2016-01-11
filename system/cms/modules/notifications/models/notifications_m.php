<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notifications_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		
		$this->_table = 'notifications';
	}
	
	//create a new item
	public function create($name,$descrption='',$module='System',$type='success') {
		
		$to_insert = array(
			'name' => $name,
			'description' => $descrption,
			'module' => $module,
			'type'=>$type,
			'created'=>date("Y-m-d H:i:s"),
		);

		if($this->db->insert($this->_table, $to_insert)) {
			return $this->db->insert_id();
		}
		return false;
	}


}
