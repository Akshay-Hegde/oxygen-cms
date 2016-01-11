<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subscriptions
{

	public function __construct()
	{		

	}

	/**
	 * Create
	 */
	public static function create($name)
	{
		$model = self::getModel();

		return $model->create($name);
	}

	/**
	 * read
	 */
	public static function get($id)
	{
		$model = self::getModel();

		return $model->get($id);
	}

	/**
	 * Update
	 */
	public static function update($id, $name)
	{
		$model = self::getModel();

		return $model->edit($id, $name);
	}

	/**
	 * Delete
	 */
	public static function delete($id)
	{
		$model = self::getModel();

		return $model->delete($id);
	}


	/**
	 * List
	 */
	public static function get_all()
	{
		$model = self::getModel();

		return $model->get_all_subscriptions();
	}

	/**
	 * @deprecated
	 */
	public static function get_subscriptions()
	{
		$model = self::getModel();

		return $model->get_all_subscriptions();
	}

	/**
	 * Model
	 */
	protected static function getModel()
	{	
		//load model
		get_instance()->load->model('subscriptions/subscriptions_m');

		$model = get_instance()->subscriptions_m;

		return $model;
	}	
}
