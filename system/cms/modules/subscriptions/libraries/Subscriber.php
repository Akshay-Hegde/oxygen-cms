<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subscriber 
{

	public function __construct()
	{		

	}

	public static function get($subscription_id)
	{
		$model = self::getModel();

		return $model->get($subscription_id);
	}

	public static function get_subscribers($subscription_id,$offset)
	{
		$model = self::getModel();

		return $model->get_all_subscribers($subscription_id,$offset);
	}

	/**
	 * @deprecated : see Subscriptions lib
	 */
	public static function get_subscriptions()
	{
		$model = self::getModel();

		return $model->get_all_subscriptions();
	}


	//
	// Add some email to the global unsubscribe list
	//
	// (bool) Subscriber::blacklist('yourname@youremail.com');
	//
	public static function subscribe($subscription_id,$subscriber_email)
	{	
		$model = self::getModel();

		return $model->subscribe($subscription_id,$subscriber_email);
	}

	//
	// Unsubscribe a user from a list
	//
	// (bool) Subscriber::unsubscribe('yourname@youremail.com');
	//
	public static function unsubscribe($subscriber_id)
	{	
		$model = self::getModel();

		return $model->unsubscribe($subscriber_id);
	}

	
	protected static function getModel()
	{	
		//load model
		get_instance()->load->model('subscriptions/subscribe_m');

		$model = get_instance()->subscribe_m;

		return $model;
	}	
}
