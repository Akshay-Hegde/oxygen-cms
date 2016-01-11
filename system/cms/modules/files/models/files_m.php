<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Files_m extends MY_Model {

	protected $table = 'files';

	public function __construct() {
		parent::__construct();
	}


	/**
	 * Exists
	 *
	 * Checks if a given file exists.
	 * 
	 * @param	int		The file id
	 * @return	bool	If the file exists
	 */
	public function exists($file_id)
	{
		return (bool) (parent::count_by(array('id' => $file_id)) > 0);
	}


	public function updateFileData($id=0, $input=[]) {

		// we do this just in case any other 
		// field exist in the incoming array
		$update_array = 
		[
			'name' => $input['name'], 
			'description' => $input['description'],  
			'keywords' => $input['keywords'],    
			'alt_attribute' => $input['alt_attribute'], 
		];

		if($this->update($id, $update_array)) {

			return self::result(true, 'File updated', $input['name'], ['id' => $id, 'name' => $name]);

		}

		return self::result(false, 'File failed to update.', $input['name'], ['id' => $id, 'name' => $name]);

	}


	public static function result($status = true, $message = '', $args = false, $data = '')
	{
		return array('status' 	=> $status,
					 'jsonstatus' => ($status)?'success':'error', 
					 'message' 	=> $args ? sprintf($message, $args) : $message, 
					 'data' 	=> $data
					 );
	}

	/**
	 * Tagged
	 *
	 * Selects files with any of the specified tags
	 * 
	 * @param	array|string	The tags to search by
	 * @return	array	
	 */
	public function get_tagged($tags)
	{
		// Make sure we have an array
		if (is_string($tags))
		{
			$tags = array_map('trim', explode('|', $tags));
		}

        // join keywords, filter by tags
        // group_by files.id to avoid duplicates files
		$this->db
			->join('keywords_applied', 'keywords_applied.hash = files.keywords')
			->join('keywords', 'keywords.id = keywords_applied.keyword_id')
			->where_in('keywords.name', $tags)
			->group_by('files.id');

		return $this->get_all();
	}
}

/* End of file file_m.php */
