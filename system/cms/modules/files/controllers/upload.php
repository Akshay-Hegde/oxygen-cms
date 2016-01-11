<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS file Admin Controller
 *
 * Provides an admin for the file module.
 *
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Controllers
 */
class Upload extends Admin_Controller {

	protected $section = 'upload'; 

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
		$this->config->load('files');
		$this->lang->load('files/files');
		$this->load->library('files/files');
		$this->load->model('files/file_folders_m');
		
	}

	/**
	 * file Listing
	 */
	public function index()
	{
		$this->load->model('files/folders_m');

		$this->template->append_js('plugins/dropzone/dropzone.js')->append_js('module::files.js');

		$this->template->enable_parser(true);
		$this->template->folders = $this->folders_m->get_all_folders_drop();
		$this->template->build('admin/upload');
	}

	/**
	 * experimental-not in use
	 */
	public function modal()
	{
		$this->load->model('files/folders_m');
		$this->template->folders = $this->folders_m->get_all_folders_drop();
		$this->template
			->set_layout(false)
			->enable_parser(true)
			->build('admin/upload');
	}

	public function ajax_display()
	{
		$this->load->model('files/folders_m');

		$this->template->enable_parser(true);
		$this->template->folders = $this->folders_m->get_all_folders_drop();
		$this->template
			->set_layout(false)
			//->append_js('module::files.js')
			->build('admin/upload');	
	}

	public function ajax()
	{

		if( ! $this->checkUserUploadPerm() ) {
			$this->set_flashdata('error','You do not have permissions.');
			redirect('admin/files/browse');
		}

		$module_name = ($this->input->post('module'))?$this->input->post('module'):'files';
		$folder = $this->input->post('folder');
		$folder_id = $folder; 

		//Check if exist
		$exists = $this->file_folders_m->exists($folder_id);

		if( ! $exists ) 
		{
			$result = Files::create_folder(0,'files');
			
			if($result['status']==true) {
				$folder_id = $result['data']['id'];die;
			}
		}

		//upload each image
		foreach($_FILES as $key => $_file) {

			//uploads images to files module
			$upload = Files::upload($folder_id, $_file['name'], $key );

			// Get the Image ID
	    	$file_id = $upload['data']['id'];

			//re-assign permissions
			Files::alter_permissions($image_id,$module_name,1);	    	


			$this->result($this->getArrayResult('completed',$file_id));


		}

		die('Could not find any suitable file to upload.');


	}

	private function checkUserUploadPerm() {
		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('upload', Files::allowed_actions()) AND
			// replacing files needs upload and delete permission
			! ( $this->input->post('replace_id') && ! in_array('delete', Files::allowed_actions()) )
		)
		{
			return false;
		}	

		return true;	
	}

	private function result($array=[]) {
		echo json_encode($array);die;	
	}

	private function getArrayResult($status='false',$file_id=0) {
			
			$result = [ 
				'status' =>'completed',
				'file_id' => $file_id,
			];

			return $result;
	}
}
