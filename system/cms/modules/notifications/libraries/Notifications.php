<?php defined('BASEPATH') or exit('No direct script access allowed');

class Notifications 
{
	/**
	 * Notifications::Add('New order', 'Jessy James placed an order with the store', 'store');
	 */
	public static function Add($name, $desc, $module ='core', $type = 'success' ) 
	{
		// Add an initial notification
		$to_insert = 
		[
			'name' => $name,
			'description' => $desc,
			'module' => $module,
			'type'=>$type,
			'created'=> date("Y-m-d H:i:s"),
		];

		get_instance()->db->insert('notifications', $to_insert);
		return true;
	}

}