<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Menu_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
	}

	public function generate_name($user_id,$menu_type='admin')
	{
		$cache_name = 'info'.DIRECTORY_SEPARATOR.'menu_'.$user_id.'_'.substr(md5($menu_type),0,5);
		return $cache_name;
	}

	public function store_menu($user_id,$menu_type='admin',array $menu)
	{
		//create a unique name
		$cache_name = $this->generate_name($user_id,$menu_type);

		// first check to delete it
		$this->oxycache->delete($cache_name);

		$this->oxycache->write($menu, $cache_name,0);
		
	}
	

}
