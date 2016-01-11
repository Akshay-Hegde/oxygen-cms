<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * 
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 * @package     
 */
class Exporter extends Admin_Controller
{

	protected $section = 'exporter';
	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data = new StdClass;
		$this->lang->load('maintenance');

		$this->cache_path = SITE_DIR.'cache/';

		$this->config->load('maintenance');
		$this->lang->load('maintenance');		
	}


	public function index()
	{
		$table_list = config_item('maintenance.export_tables');

		asort($table_list);

		$tables = [];
		foreach ($table_list as $table)
		{
			//some core modules may not exist, dont query them..
			if($this->db->table_exists($table))
			{
				$tables[] = array(
					'name' => $table,
					'count' => $this->db->count_all($table),
				);
			}
		}


		$this->template
			->title($this->module_details['name'])
			->set('tables',$tables)
			->build('admin/exporter/list');		
	}


	public function navigation()
	{	
		// 1. Get a list of all packages
		$exportData=[];

		$navigation_groups = $this->db->get('navigation_groups')->result();

		foreach($navigation_groups as $key=>$group)
		{
			$group->links = $this->db->where('navigation_group_id',$group->id)->get('navigation_links')->result();
			$exportData[] = $group;
		}

		$this->okToDownLoad($exportData,'navigation');

	}


	public function redirects()
	{	
		// 1. Get a list of all packages
		$exportData=[];

		$redirects_data = $this->db->get('redirects')->result();

		$this->okToDownLoad($redirects_data,'redirects');

	}


	public function packages()
	{	
		// 1. Get a list of all packages
		$exportData=[];

		$packages_groups = $this->db->where('deleted',NULL)->get('storedt_packages_groups')->result();

		foreach($packages_groups as $key=>$group)
		{
			$group->packages = $this->db->where('deleted',NULL)->where('pkg_group_id',$group->id)->get('storedt_packages')->result();
			$exportData[] = $group;
		}

		$this->okToDownLoad($exportData,'packages');

	}

	public function countries()
	{	
		// 1. Get a list of all packages
		$exportData=[];

		$countries = $this->db->get('storedt_countries')->result();

		foreach($countries as $key=>$country)
		{
			$country->states = $this->db->where('country_id',$country->id)->get('storedt_states')->result();

			foreach($country->states as $key2=>$state)
			{
				unset($country->states[$key2]->id);				
				unset($country->states[$key2]->country_id);
			}
			unset($country->id);

			$exportData[] = $country;
		}

		//preformat states
		$this->okToDownLoad($exportData,'countries');
	
	}

	// here we keep the ids/parent ids but are ignored on import
	public function categories()
	{	
		//check if installed


		$exportData=[];

		//get only the top
		$categories = $this->db->where('parent_id',0)->get('storedt_categories')->result();

		foreach($categories as $key=>$category)
		{
			
			$category = $this->get_sub_categories($category);

			$exportData[] = $category;
		}

		$this->okToDownLoad($exportData,'categories');
	}

	private function get_sub_categories($category) {

		$category->subcategories = $this->db->where('parent_id',$category->id)->get('storedt_categories')->result();

		foreach($category->subcategories as $key=>$subc) {
			$category->subcategories[$key] = $this->get_sub_categories($subc);
		}

		return $category;
	}


	public function orders()
	{	
		$exportData=[];

		$orders = $this->db->get('storedt_orders')->result();

		foreach($orders as $key=>$order)
		{
			$order->items = $this->db->where('order_id',$order->id)->get('storedt_order_items')->result();
			$order->notes = $this->db->where('order_id',$order->id)->get('storedt_order_notes')->result();
			$order->invoice = $this->db->where('order_id',$order->id)->get('storedt_order_invoice')->result();
			$exportData[] = $order;
		}

		$this->okToDownLoad($exportData,'orders');
	}

	private function get_orderinfo($order) {

		

		foreach($order->subcategories as $key=>$subc) {
			$order->subcategories[$key] = $this->get_orderlines($subc);
		}

		return $order;
	}	

	private function okToDownLoad($exportData,$name='filename') {

		$result = json_encode($exportData);

		$this->load->helper('download');

		force_download("$name.json", $result ); 	
	}

}