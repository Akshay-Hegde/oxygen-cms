<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a tasks module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	tasks Module
 */
class Tasks_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		
		$this->_table = 'tasks';
	}
	
	//create a new item
	public function create($input)
	{

		$to_insert = 
		[
			'name' 			=> $input['name'],
			'description' 	=> $input['description'],
			'complete' 		=> null,
			'pcent'			=> $input['pcent'],
			'order'			=> time(),
		];

		if($this->db->insert('tasks', $to_insert)) 
		{
			return $this->db->insert_id();
		}

		return false;
	}

	public function create_simple($task)
	{
		$to_insert = 
		[
			'name' 			=> $task,
			'description' 	=> '',
			'complete' 		=> null,
			'pcent'			=> 0,
			'order'			=> time(),
		];

		if($this->db->insert('tasks', $to_insert)) 
		{
			return $this->db->insert_id();
		}

		return false;
	}

	public function complete($id) {

		$to_update = 
		[
			'complete' => date("Y-m-d H:i:s"),
			'pcent'=>100
		];

		return $this->db->where('id',$id)->update('tasks', $to_update);
	}
}
