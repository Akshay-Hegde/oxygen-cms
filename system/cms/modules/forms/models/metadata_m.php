<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Metadata_m extends MY_Model
{
	protected $_table = 'forms';


	/*
	$tables = 
	[
		'forms' => 
		[
			'id' 			=> 	['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,],
			'form_stream_id'=> 	['type' => 'INT', 'constraint' => 11, 'default' => 0],
			'store_db' 		=> 	['type' => 'INT', 'constraint' => 1, 'default' => 1],
			'notify_email' 	=> 	['type' => 'INT', 'constraint' => 1, 'default' => 0],
			'email' 		=> 	['type' => 'VARCHAR', 'constraint' => 255,],
		],
	];
	*/


	public function create($input = [])
	{
		return parent::insert(
				[
					'form_stream_id'	=> $input['form_stream_id'],
					'store_db'	        => 1,
					'notify_email'		=> $input['notify_email'],
					'email'	        	=> $input['email'],					
				]
		);
	}


	public function update($id = 0, $input = [], $skip_validation = false)
	{
		return parent::update($id,
				[
					'store_db'	        => 1,
					'notify_email'		=> $input['notify_email'],
					'email'	        	=> $input['email'],					
				]
		);
	}

	public function get_by_stream($stream_id)
	{
		return $this->db->where('form_stream_id', $stream_id)->get($this->_table)->row();
	}


}