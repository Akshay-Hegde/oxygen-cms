<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a Notifications module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Notifications Module
 */
class Admin extends Admin_Controller
{
	protected $section = 'items';

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		redirect('admin');
	}

	public function toggle($id)
	{
		$this->db->where('id',$id)->update('widgets_admin',['is_visible'=>0]);
		redirect('admin');
	}


	public function add_widget($id)
	{
		$this->db->where('id',$id)->update('widgets_admin',['is_visible'=>1]);
		redirect('admin');
	}

	/**
	 * We are looking specifically for an array 
	 * of widget id's. We can then set which widgets
	 * todisplay and take them back to dashboard view
	 */
	public function widget_post()
	{
		//turn them all off
		$this->db->update('widgets_admin',['is_visible'=>0]);
		
		if($widgets = $this->input->post('widgets'))
		{
			foreach($widgets as $widget_id=>$status)
			{
				if(is_numeric($widget_id))
				{
					$this->db->where('id',$widget_id)->update('widgets_admin',['is_visible'=>1]);
				}
			}
		}

		//go to dashboard
		redirect('admin/');
	}

	//
	// from admin theme
	// this nneeds to be refactored into the 
	// shop controller somewhere external to core cms
	//
	public function shop_dash()
	{

		$this->load->model('store/statistics_m');		

		$data = new stdClass();

		$data->revenue_today = 0;
		$data->revenue_week = 0;
		$data->revenue_monthly = 0;
		$data->revenue_anual = 0;

		$data->row1 = [];
		$data->row2 = [];
		$data->row3 = [];

		$data->uninstalled_widgets = [];
		$data->order_items = [];
        $data->cat = [];
        $data->most_viewed =  [];
		$data->SalesRecords =  [] ;
		$data->recent_users = [];

		$data->average_order = 0;
		$data->active_carts = null;
		$data->file_count = 0;
		

		if($this->db->table_exists('storedt_products')) 
		{
	        //Events::trigger('STOREVT_ShopAdminController');
			$this->load->model('store/orders_m');
			
			$this->load->model('store/admin/orders_admin_m');		
			$this->load->model('store/admin/products_admin_m');		
	        $this->lang->load('store/store_admin_dashboard');

			// Collect 5 most recent orders
			$limit = 5;
			

			$data->revenue_today = $this->statistics_m->getStoreRevenue(1);
			$data->revenue_week = $this->statistics_m->getStoreRevenue(7);
			$data->revenue_monthly = $this->statistics_m->getStoreRevenue(30);
			$data->revenue_anual = $this->statistics_m->getStoreRevenue(365);

			$data->row1 = $this->db->where('is_visible',1)->where('section','row1')->get('widgets_admin')->result();
			$data->row2 = $this->db->where('is_visible',1)->where('section','row2')->get('widgets_admin')->result();
			$data->row3 = $this->db->where('is_visible',1)->where('section','row3')->get('widgets_admin')->result();

			$data->uninstalled_widgets = $this->db->where('is_visible',0)->get('widgets_admin')->result();

			$data->order_items = $this->orders_admin_m->get_most_recent($limit);
			//$data->order_items = $this->orders_admin_m->where('storedt_orders.deleted',NULL)->limit($max)->offset(0)->order_by('order_date','desc')->get_all();
	        $data->most_viewed =  $this->statistics_m->_get_most_viewed(5);

	        $data->cat = $this->statistics_m->get_catalogue_data();

			//TODO: Use better chart api, also improve the data
			$rows = $this->db->query("select order_date, count(id) as `Val` from ".$this->db->dbprefix('storedt_orders')." group by DATE(FROM_UNIXTIME(order_date)) LIMIT 4");
			
			$data->SalesRecords = ($rows) ? $rows->result() : [] ;	 

			$data->average_order = $this->statistics_m->monthlyAverageSale();
			$data->active_carts = $this->statistics_m->activeCarts();			       
		} 

		$data->recent_users = $this->statistics_m->get_recent_members(6);
		$data->file_count = $this->statistics_m->countFiles();
		$this->template->set($data);
	}
		
}
