<?php defined('BASEPATH') OR die('No direct script access allowed');
/**
 * Maintenance Module
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Maintenance\Models
 */
class Maintenance_m extends MY_Model
{
	public function export($table = '', $type = 'xml', $table_list)
	{
		switch ($table)
		{
			case 'users':
				$data_array = $this->db
					->select('users.*')
					->join('users_profiles', 'users_profiles.user_id = users.id')
					->get('users')
					->result_array();

					foreach($data_array as $key=>$row)
					{
						unset($data_array[$key]['password']);
						unset($data_array[$key]['salt']);
						unset($data_array[$key]['io_stamp']);
						unset($data_array[$key]['remember_code']);
						unset($data_array[$key]['rgotten_password_code']);
						$data_array[$key]['active'] = ($data_array[$key]['active']=='1')?'Yes':'No';
					}

					
					/*				
					->select('users.id, email, IF(active = 1, "Y", "N") as active', false)
					->select('first_name, last_name, display_name, company, lang, gender, website')
					->join('users_profiles', 'users_profiles.user_id = users.id')
					->get('users')
					->result_array();
					*/
				break;

			case 'files':
				$data_array = $this->db
					->select('files.*, file_folders.name folder_name, file_folders.slug')
					->join('file_folders', 'files.folder_id = file_folders.id')
					->get('files')
					->result_array();
				break;

			default:
				$data_array = $this->db
					->get($table)
					->result_array();
				break;
		}
		force_download($table.'.'.$type, $this->format->factory($data_array)
			->{'to_'.$type}());
	}
}