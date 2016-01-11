<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS file Admin Controller
 *
 * Provides an admin for the file module.
 *
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Controllers
 */
class Folders extends Admin_Controller {

	protected $section = 'folders'; 

	public function __construct() {

		parent::__construct();


		$this->config->load('files');
		$this->lang->load('files/files');
		$this->load->library('files/files');
		$this->load->model('files/media_m');
		$this->load->model('files/folders_m');

		$this->template->enable_parser(true);

		$this->limit = 20;

	}


	/**
	 * file Listing
	 */
	public function index()
	{
		$this->load->helper('files/file');

		$folders = $this->folders_m->get_all_folders();
		$this->template->set('folders',$folders);
		$this->template->build('admin/folders');		
	}

	public function create() {

		$this->load->helper('files/file');

		if($input =$this->input->post()) {

			if($this->folders_m->create_folder($input['name'])) {
				$this->session->set_flashdata('success','Folder created');
			}else {
				$this->session->set_flashdata('error','Unable to create folder');
			}

			redirect('admin/files/browse');
		} 
		else {
			//normal page request
		}

		$this->template->set_layout(false)->build('admin/folder_create');			
	}


	public function delete($folder_id) {


		if($count = $this->media_m->where('folder_id',$folder_id)->count_all()) {
			$this->session->set_flashdata('error','This folder has images assigned to it.');
		} else {
			if($this->folders_m->delete_folder($folder_id)) {
				$this->session->set_flashdata('success','Folder deleted.');
			}
			else {
				$this->session->set_flashdata('error','Folder failed to delete.');
			}
		}

		redirect('admin/files/folders');
	}



}