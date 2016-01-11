<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Widgets_admin {



	public function __construct()
	{
		$this->load->model('widgets/widget_m');
	}

	public function widgets_instances_add($data)
	{

	}

	public function widgets_instances_add_postback( $data = [] )
	{

	}

	
}