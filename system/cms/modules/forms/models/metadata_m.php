<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Metadata_m extends MY_Model
{
	protected $_table = 'forms';


	public function create($input = [])
	{
		return parent::insert(
				[
					'form_stream_id'	=> $input['form_stream_id'],
					'store_db'	        => 1,
					'notify_email'		=> $input['notify_email'],
					'email'	        	=> $input['email'],		
					'replyto_field'		=> 'email',			
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
					'replyto_field'		=> $input['replyto_field'],						
				]
		);
	}

	public function get_by_stream($stream_id)
	{
		return $this->db->where('form_stream_id', $stream_id)->get($this->_table)->row();
	}
}