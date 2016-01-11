<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Navigation model for the navigation module.
 * 
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Navigation\Models
 */
class Navgroups_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_table = 'navigation_groups';
	}


	/**
	 * Get group by..
	 *
	 * 
	 * @param string $what What to get
	 * @param string $value The value
	 * @return mixed
	 */
	public function get_group_by($what, $value)
	{
		return $this->db->where($what, $value)->get('navigation_groups')->row();
	}
	
	/**
	 * Return an array of Navigation Groups
	 *
	 * 
	 * @return void
	 */
	public function get_groups()
	{
		return $this->db->get('navigation_groups')->result();
	}
	
	/**
	 *
	 * Insert a new group into the DB
	 *
	 * @param array $input The data to insert
	 * @return int
	 */
	public function insert_group($input = [])
	{
		$data = [
        	'title' => $input['title'],
        	'slug' => $input['slug']
		];

		$data['order'] = (isset($input['order'])) ? (int) $input['order'] : time();

		$this->db->insert('navigation_groups', $data );

        return $this->db->insert_id();
	}
	
	/**
	 * Delete a Navigation Group
	 *
	 * 
	 * @param int $id The ID of the group to delete
	 * @return array
	 */
	public function delete_group($id = 0)
	{
		$params = is_array($id) ? $id : array('id'=>$id);
		
		$this->db->delete('navigation_groups', $params);
        return $this->db->affected_rows();
	}
}