<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS file Admin Controller
 *
 * Provides an admin for the file module.
 *
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Controllers
 */

class File extends Admin_Controller 
{

	protected $section = 'browse'; 

	public function __construct() 
	{

		parent::__construct();
		$this->config->load('files');
		$this->lang->load('files/files');
		$this->load->library('files/files');
	}

	public function rename($file_id=0) 
	{
		$object = new stdClass();
		$row = $this->db->where('id',$file_id)->get('files')->row();
		if(!$row) {
			redirect('admin/files/browse');
		}

		$body = $this->template
				->enable_parser(true)
				->set_layout(false)
				->build('admin/partials/rename',$row,true);
		
	}

	public function rename_post($file_id=0) {

		//ensure its a post
		if(!$this->input->post()) {
			if($this->input->is_ajax_request()) {
				echo json_encode(['status'=>'error']);die;
			}
			else {
				redirect('admin/files/browse');
			}
		}

		// get the input array
		$input = $this->input->post();		


		//get the existing item
		$row = $this->db->where('id',$file_id)->get('files')->row();
		if(!$row) {
			echo json_encode(['status'=>'error']);die;
		}

		if($status = $this->db->where('id',$file_id)->update('files',['name'=>$input['new_name']]) ) {
			echo json_encode(['status'=>'success']);die;
		}

		echo json_encode(['status'=>'error']);die;

	}

	public function replace( $file_id=null ) 
	{

		//handle non-valid post request
		$input = $this->input->post();

		//check if post
		if(!$this->input->post() AND !$this->input->is_ajax_request()) 
		{
			$this->session->set_flashdata('error','Action not defined.');
			redirect('admin/files/file/view/'.$file_id);
		}

		//check upload/replace permissions
		if ( ! in_array('upload', Files::allowed_actions()) AND
			// replacing files needs upload and delete permission
			! ( $this->input->post('file_id') && ! in_array('delete', Files::allowed_actions()) )
		) 
		{
			$this->session->set_flashdata('error',lang('files:no_permissions'));
			redirect('admin/files/file/view/'.$file_id);
		}

		$result = null;

		//ensure we have an ID of the original file to replace
		if($file_id == null) {
			$this->session->set_flashdata('error','No file selected for replace');
			redirect('admin/files/file/view/'.$file_id);
		}
 		
 		//double check of file id
		if ((isset($input['file_id']) AND $input['file_id'] !== $file_id)) {
			$this->session->set_flashdata('error','No file selected for replace (b)');
			redirect('admin/files/file/view/'.$file_id);
		}

		// now get the original file
		$original = Files::get_file($file_id);
		$file = null;


		if($original['status']=='success') {
			$file = $original['data'];
		} else {
			$this->session->set_flashdata('error','Cant locate original file');
			redirect('admin/files/file/view/'.$file_id);
		}


		//reset to auto
		$input['width'] = 0;
		$input['height'] = 0;
		$input['ratio'] = 0;

		//lets now replace the file
		$result = Files::replace_file($input['file_id'], $input['folder_id'], $file->name, 'userfile');
		$result['status'] AND Events::trigger('file_replaced', $result['data']);	

		// return status
		if($result['status']) {
			$this->session->set_flashdata('success','File has been replaced.');
		} else {
			$this->session->set_flashdata('error','Failed to replace original file.');
		}

		redirect('admin/files/file/view/'.$file_id);

	}



	/**
	 * file Listing
	 */
	public function view($file_id)
	{

		$this->load->library('keywords/keywords');

		$result = Files::get_file($file_id);

		if($result['status']=='success') {
			$file = $result['data'];
		}
		else {
			//cant find file
			$this->session->set_flashdata('error',$result['message']);
			redirect('admin/files');
		}

		//determin view for the file
		$view = $this->getFileViewName($result['data']);


		$file->keywords_hash = $file->keywords;
		$file->keywords = $this->keywords->get_string($file->keywords);


		$this->template
			->append_js('jquery/jquery.cooki.js')
			->enable_parser(true)
			->set('file',$file)
			->build('admin/'.$view);
	}

	/**
	 * view file info via ajax
	 */
	public function view_ajax($file_id)
	{

		$this->load->library('keywords/keywords');

		$result = Files::get_file($file_id);


		if($result['status']=='success') {
			$file = $result['data'];
		}
		else {
			//cant find file
			$this->session->set_flashdata('error',$result['message']);
			redirect('admin/files');
		}

		$file->keywords_hash = $file->keywords;
		$file->keywords = $this->keywords->get_string($file->keywords);

		$this->template
			->enable_parser(true)
			->set_layout(false)
			->set('file',$file)
			->build('admin/modal/file_general');

	}

	public function delete($file_id=0) 
	{

		// this is just a safeguard if they circumvent the JS permissions
		if ( ! in_array('manage', Files::allowed_actions())) {
			$this->set_flashdata('error','You do not have permissions for this action.');
			redirect('admin/files/browse');
		}

		$result = Files::delete_file($file_id,'files');
		
		if($result['status']) {
			//good grief, its gone
			$this->session->set_flashdata('success','The file was removed.');
		}
		else {
			$this->session->set_flashdata('error',$result['message']);
		}

		redirect('admin/files');
	}

	// Ensure we have the right setting before we execute the update
	public function update($id) {
		if($input = $this->input->post()) {
			$this->_update($id,$input);
		} else {
			redirect('admin/files/view/'.$id);
		}
	}

	private function _update($id,$input=[]) {

		//
		// Do some pre-validation tests
		//
		$this->updateValidation($id,$input);

		//
		// OK looks good to go.
		//
		$this->load->model('files/files_m');
		$this->load->library('keywords/keywords');

		// 
		// The original DB record, mainly for keyword processing
		//
		$original = $this->files_m->get($id);

		//process the keywords
		$input['keywords'] = $this->keywords->process( $input['keywords'] , $original->old_hash );

		// Lets update the file now
		$result = $this->files_m->updateFileData($id, $input);

		//set a flash data message for user
		$this->session->set_flashdata($result['jsonstatus'],$result['message']);

		//only if status is true, trigger the event
		if($result['status']==false) {
			redirect('admin/files/browse');
		} 

		Events::trigger('file_updated', $result['data']);	
		redirect('admin/files/browse');

	}

	private function updateValidation($id,$input) {

		//lets see if the user can edit the file
		$this->checkUpdatePerm();

		// if it fails it will handle the redirect
		$this->checkFileID($id,$input);

	}

	private function checkFileID($id,$input) {

		return true;

		if( $id != $input['id'] ) {

			$this->session->set_flashdata('error','Error trying to update file');
			redirect('admin/files/browse');		
		}

		return true;
	}

	private function checkUpdatePerm() {

		return true;

		if ( ! in_array('manage', Files::allowed_actions())) {

			$this->set_flashdata('error','You do not have permissions for this action.');
			redirect('admin/files/browse');
		}	

		return true;

	}


	private function getFileViewName($file) {

		//default
		$view = 'file_general';
		switch($file->type) {
			// image
			case 'i':
				$view = 'file_image';
				break;
			//we can add others once we have more specifics
			//for now image is the only other type we need to condition
		}
		return $view;
	}
}