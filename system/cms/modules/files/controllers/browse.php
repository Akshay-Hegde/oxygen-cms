<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS file Admin Controller
 *
 * Provides an admin for the file module.
 *
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Controllers
 */
class Browse extends Admin_Controller {

	protected $section = 'browse'; 
	protected $user_view_type;

	public function __construct() 
	{

		parent::__construct();

		$this->config->load('files');
		$this->lang->load('files/files');
		$this->load->library('files/files');
		$this->load->model('files/media_m');
		$this->load->model('files/folders_m');
		$this->load->helper('files/file');

		$this->load->model('files/file_folders_m');
		
		$allowed_extensions = [];

		// flatten the array
		foreach (config_item('files:allowed_file_ext') as $type) {
			$allowed_extensions = array_merge($allowed_extensions, $type);
		}

		$this->user_view_type = ($this->session->userdata('files:view:method'))?$this->session->userdata('files:view:method'):'list';
		$this->template->folder = ($this->session->userdata('files:filter:folder'))?$this->session->userdata('files:filter:folder'):'all';
		$this->template->per_page = ($this->session->userdata('files:filter:count'))?$this->session->userdata('files:filter:count'):5;


		$this->template
			->enable_parser(true)
			->set('allowed_extensions',$allowed_extensions)
			->append_js('plugins/dropzone/dropzone.js')
			->append_css('module::upload.css')
			->append_js('jquery/jquery.cooki.js');


		//all limit options
		$this->template->filter_count_values = ['5'=>'5','15'=>'15','25'=>'25','50'=>'50','100'=>'100'];

		//all folders
		$this->template->folders = ['all'=>'All Files'] + $this->folders_m->get_all_folders_drop();
	}

	public function api($mode='ckeditor')
	{
		$this->loadExtentionList();

		//filter by folder
		$total_items = $this->media_m->count_all();

		$pagination = create_pagination( 'admin/files/browse/api' , $total_items, $this->template->per_page,5);

		//filter by folder
		if($this->template->folder != 'all') {
			$this->media_m->where('folder_id',$this->template->folder);
		}

		$files = $this->media_m->limit( $pagination['limit'] )->offset($pagination['offset'] )->get_all();

		//
		// Display a different view based on the mode
		//
		$this->template
			->enable_parser(true)
			->set_layout('modal')		
			->set('files',$files)	
			->set('pagination',$pagination)
			->build('admin/modal/selector');

	}

	/**
	 * file Listing
	 */
	public function index($offset=0) 
	{

		$ajax = false;

		if($this->input->is_ajax_request())
		{
			$ajax = true;
		}

		$this->filter($offset,$ajax);

	}

	public function filter($offset=0,$isajax=false) 
	{

		$this->loadExtentionList();

		//update filter
		if($input = $this->input->post()) {

			if($this->input->post('f_filter_count')) {
				$this->template->per_page = $this->input->post('f_filter_count');
				$this->session->set_userdata('files:filter:count',$this->template->per_page);
			}

			if($this->input->post('f_filter_folder')) {
				$this->template->folder = $this->input->post('f_filter_folder');
				$this->session->set_userdata('files:filter:folder',$this->template->folder);
			}

			if($this->input->post('f_filter_view_method')) {
				$this->user_view_type = $this->input->post('f_filter_view_method');
				$this->session->set_userdata('files:view:method',$this->user_view_type);
			}
		}

		//filter by folder
		if($this->template->folder === 'all') {
			$total_items = $this->media_m->count_all();
		} else {
			$total_items = $this->media_m->count_by('folder_id',$this->template->folder);
		}

		//$total_items = $this->media_m->count_all();
		
		$pagination = create_pagination( 'admin/files/browse/index' , $total_items, $this->template->per_page,5);

		//filter by folder
		if($this->template->folder != 'all') {
			$this->media_m->where('folder_id',$this->template->folder);
		}

		$files = $this->media_m->limit( $pagination['limit'] )->offset($pagination['offset'] )->get_all();

		$this->template->set('files',$files);
		
		$this->template->set('f_filter_view_method',$this->user_view_type);		
		$this->template->set('pagination',$pagination);	
		if($isajax)
		{
			$this->template->set_layout(false);
			$this->template->build('admin/layouts/partials/'.$this->user_view_type);
		}	
		else
		{
			$this->template->build('admin/layouts/index');//.$this->user_view_type);
		}
	}

	private function loadExtentionList() {
		//
		$allowed_extensions = [];

		// flatten the array
		foreach (config_item('files:allowed_file_ext') as $type) {
			$allowed_extensions = array_merge($allowed_extensions, $type);
		}

		$this->template
			->set('allowed_extensions',$allowed_extensions);
	}
}