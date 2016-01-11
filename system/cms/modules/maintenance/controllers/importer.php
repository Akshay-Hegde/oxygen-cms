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
class Importer extends Admin_Controller
{

	protected $section = 'importer';
	private $data;

	public function __construct()
	{
		parent::__construct();
        Events::trigger('STOREVT_ShopAdminController');	
		$this->data = new StdClass;
		$this->lang->load('maintenance');
	}


	public function index()
	{
		$this->template->title($this->module_details['name'])
			->build('admin/importer/list');		
	}

	private function getFile()
	{
		$this->load->helper('file');

		$json = '[]';
		$this->load->library('files/files');
		$this->load->model('files/file_folders_m');

		//upload each image
		foreach($_FILES as $key => $_file)
		{
			$filename = $_file['tmp_name'];
			if( file_exists($filename) )
			{			
				$json = read_file($filename);
			}
		}	

		return $json;

	}

	public function navigation()
	{	
		$json_file = $this->getFile();

		$navigation_groups = json_decode($json_file);

		$this->truncate_if_exist('navigation_groups');
		$this->truncate_if_exist('navigation_links');

		foreach($navigation_groups as $group)
		{
			$this->db->trans_start();

			$links = $group->links;

			$this->db->insert('navigation_groups',$group);
			$group_id = $this->db->insert_id();

			foreach($links as $link)
			{
				$link->navigation_group_id = $group_id;
				$this->db->insert('navigation_links',$link);
			}

			$this->db->trans_complete();
			
		}

		redirect('admin/maintenance/importer/');
	}

	public function redirects()
	{	
		$json_file = $this->getFile();

		$redirects = json_decode($json_file);

		$this->truncate_if_exist('redirects');

		foreach($redirects as $key => $redirect)
		{

			$this->db->trans_start();


			unset($redirect->id);


			$this->db->insert('redirects',$redirect);

			$this->db->trans_complete();
			
		}

		redirect('admin/maintenance/importer/');
	}

	public function packages()
	{	
		$json_packages = $this->getFile();

		$packageGroups = json_decode($json_packages);

		foreach($packageGroups as $group)
		{
			$this->db->trans_start();

			$packages = $group->packages;

			unset($group->packages);
			unset($group->id);

			$this->db->insert('storedt_packages_groups',$group);
			$group_id = $this->db->insert_id();



			foreach($packages as $package)
			{
				unset($package->id);
				//dump($package);die;
				$package->pkg_group_id = $group_id;
				$this->db->insert('storedt_packages',$package);
			}

			$this->db->trans_complete();
			
		}

		redirect('admin/maintenance/importer/');
	}

	public function countries()
	{	
		$json_countries = $this->getFile();

		$countriesData = json_decode($json_countries);


		$this->truncate_if_exist('storedt_countries');
		$this->truncate_if_exist('storedt_states');

		foreach($countriesData as $country)
		{
			$this->db->trans_start();

			$states = $country->states;

			unset($country->states);

			$this->db->insert('storedt_countries',$country);
			$country_id = $this->db->insert_id();

			foreach($states as $state)
			{
				$state->country_id = $country_id;
				$this->db->insert('storedt_states',$state);
			}

			$this->db->trans_complete();
			
		}

		redirect('admin/maintenance/importer/');
	}

	public function categories()
	{	
		$json_categories = $this->getFile();

		$categoriesData = json_decode($json_categories);

		$this->truncate_if_exist('storedt_categories');

		foreach($categoriesData as $category)
		{
			$this->db->trans_start();

			$subcategories = $category->subcategories;

			unset($category->subcategories);

			//top level
			$category->parent_id = 0;
			$category->file_id = '';

			//insert the parent
			$this->db->insert('storedt_categories',$category);

			$parent_id = $this->db->insert_id();

			//recursive
			$this->import_category($subcategories,$parent_id);

			$this->db->trans_complete();
			
		}

		redirect('admin/maintenance/importer/');
	}

	private function import_category($subcategories,$parent_id) {

		foreach($subcategories as $category) {

			$its_subcategories = $category->subcategories;
			$category->parent_id = $parent_id;
			$category->file_id = '';
			$new_parent_id = $category->id;

			unset($category->id);
			unset($category->subcategories);

			$this->db->insert('storedt_categories',$category);

			//any children
			$this->import_category($its_subcategories,$new_parent_id);

		}

	}

	protected function truncate_if_exist($table_name)
	{
        if($this->db->table_exists($table_name) )
        {
            $this->db->truncate($table_name);
        }
	}		
}