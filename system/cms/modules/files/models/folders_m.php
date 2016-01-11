<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Folders_m extends MY_Model {

	protected $_table = 'file_folders';

	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_folders() {
		return $this->db->get('file_folders')->result();
	}
	public function get_all_folders_drop() {
		$folders = $this->db->get('file_folders')->result();
		$return = [];
		foreach($folders as $folder) {
			$return[$folder->id] = $folder->name;
		}

		return $return;
	}

	/**
	 * create a file folder
	 */
	public function create_folder($name='') {

		$to_insert =
		[	
			'name' => $name,
			'parent_id'=>0,
			'slug' =>slugify($name),
			'location'=>'local',
			'date_added'=>time(),
			'sort'=>time(),
			'hidden'=>0,
			'core'=>0
		];
		return $this->db->insert('file_folders',$to_insert);

	}	


	public function delete_folder($folder_id) {
		
		$this->db->where('id',$folder_id)->delete('file_folders');

		return true;
	}
}

/* End of file file_m.php */
