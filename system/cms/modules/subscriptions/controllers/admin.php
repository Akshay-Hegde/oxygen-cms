<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	protected $section = 'items';

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('subscriptions/subscribe_m');
		$this->lang->load('subscriptions/subscriptions');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->load->library('subscriptions/subscriber');
		$this->template->subscriptions = Subscriber::get_subscriptions();
		$this->template->build('admin/index');
	}

	public function create()
	{
		$this->load->library('subscriptions/subscriptions');
		if($name = $this->input->post('name'))
		{
			Subscriptions::create($name);
			redirect('admin/subscriptions');
		}
		
		$this->template->set_layout(false)->build('admin/modal_create');
	}

	public function edit($id)
	{
		$this->load->library('subscriptions/subscriptions');

		if($name = $this->input->post('name'))
		{
			if($id = $this->input->post('id'))
			{
				Subscriptions::update($id,$name);
				redirect('admin/subscriptions');
			}
		}

		$this->template->subscription = Subscriptions::get($id);

		$this->template->set_layout(false)->build('admin/modal_create');
	}

	public function delete($id=0)
	{
		$this->load->library('subscriptions/subscriptions');

		Subscriptions::delete($id);

		redirect('admin/subscriptions');
	}

	public function subscribers($subscription_id,$offset=0)
	{
		$this->load->library('subscriptions/subscriber');
		$this->template->subscribers = Subscriber::get_subscribers($subscription_id,$offset);
		$this->template->set('subscription_id',$subscription_id)->build('admin/subscribers');
	}

	public function subscribe($subid=0)
	{
		if($subscription_id = $this->input->post('subscription_id'))
		{
			if($subscriber_email = $this->input->post('subscriber_email'))
			{
				$this->load->library('subscriptions/subscriber');
				Subscriber::subscribe($subscription_id,$subscriber_email);
				redirect('admin/subscriptions/subscribers/'.$subscription_id);
			}
		}

		if($this->input->is_ajax_request())
		{
			$this->template->set_layout(false);
		}

		$this->template
			->set('subscription_id',$subid)
			->build('admin/subscribers_form');	
	}

	public function unsubscribe($subscriber_id=0)
	{
		$this->load->library('subscriptions/subscriber');
		if($info = Subscriber::get($subscriber_id))
		{
			Subscriber::unsubscribe($subscriber_id);
			redirect('admin/subscriptions/subscribers/'.$info->subscription_id);
		}

	}		
}
