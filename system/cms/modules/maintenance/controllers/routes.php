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
class Routes extends Admin_Controller
{

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('maintenance');

	}
	
	public function index()
	{
		Asset::css('plugins/xeditable/bootstrap-editable.css');
		Asset::js('plugins/xeditable/bootstrap-editable.js',false,'endscripts');

		$routes = $this->db->order_by('ordering_count','asc')->get('routes')->result();

		$this->template
			->title($this->module_details['name'])
			->set('routes', $routes)
			->build('admin/routes/index');
	}

	public function build_routes()
	{
		$this->load->library('maintenance/routes_lib');
		$Routes_lib = new Routes_lib();
		$Routes_lib::Build();
		redirect('admin/maintenance/routes');
	}

	public function xeditroute()
	{
		if($field = $this->input->post('name'))
		{
			if($value = $this->input->post('value'))
			{
				if($id = $this->input->post('pk'))
				{
					$data = new stdClass();
					$data->$field = $value;
					$this->db->where('id',$id)->update('routes',$data);
				}
			}
		}
	}

	public function order_routes()
	{
		$this->load->model('maintenance/routes_m');

		if($fields = $this->input->post()) 
		{
			//reset the order, 
			$this->routes_m->reset_order();
			//update all to 0 order
			foreach ($fields as $field_id=>$order) {
				$this->routes_m->set_order($field_id,$order);
			}
		}
	}

	public function reset_route($id)
	{
		if($row = $this->db->where('id',$id)->get('routes')->row())
		{
			$this->db->where('id',$id)->update('routes',['uri'=>$row->default_uri]);
		}

		redirect('admin/maintenance/routes');
	}

}