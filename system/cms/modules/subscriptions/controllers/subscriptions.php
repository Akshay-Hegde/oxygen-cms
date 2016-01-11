<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subscriptions extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('subscriptions/subscriptions_m');
		$this->load->model('subscriptions/subscribe_m');
		$this->lang->load('subscriptions/subscriptions');
	}

	public function index()
	{
		$this->load->library('subscriptions/subscriber');
		$subscriptions = $this->subscriptions_m->get_all();
		$this->template->set('subscriptions',$subscriptions)->build('index');
	}


}
