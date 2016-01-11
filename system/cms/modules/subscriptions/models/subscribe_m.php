<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subscribe_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		
		$this->_table = 'subscribers';
	}
	
	//create a new item
	public function subscribe($subscription_id,$subscriber_email) {
		
		$to_insert = 
		[
			'email' 			=> $subscriber_email,
			'subscription_id' 	=> $subscription_id,
			'created'			=> date("Y-m-d H:i:s"),
		];

		if($this->db->insert($this->_table, $to_insert)) {
			return $this->db->insert_id();
		}
		return false;
	}

	public function unsubscribe($subscriber_id)
	{
		return $this->db->where('id',$subscriber_id)->delete('subscribers');
	}

	public function get_all_subscriptions()
	{
		return $this->db->get('subscriptions')->result();
	}

	public function get_all_subscribers($subscription_id,$offset=0)
	{
		return $this->db->where('subscription_id',$subscription_id)->get('subscribers')->result();
	}


}
