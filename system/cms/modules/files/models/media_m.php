<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Media_m extends MY_Model {

	protected $_table = 'files';

	public function __construct() {
		parent::__construct();
	}

	public function get_all() {
		$results = parent::get_all();
		foreach($results as &$file) {
			$folder =$this->db->where('id',$file->folder_id)->get('file_folders')->row();
			$file->folder = $folder->name;
		}
		return $results;
	}
}
/* End of file file_m.php */