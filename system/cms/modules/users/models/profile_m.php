<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Users\Models
 */
class Profile_m extends MY_Model
{
	/**
	 * Get a user profile
	 *
	 * 
	 * @param array $params Parameters used to retrieve the profile
	 * @return object
	 */
	public function get_profile($params = array())
	{
		$query = $this->db->get_where('users_profiles', $params);

		return $query->row();
	}
	
	/**
	 * Update a user's profile
	 *
	 * 
	 * @param array $input A mirror of $_POST
	 * @param int $id The ID of the profile to update
	 * @return bool
	 */
	public function update_profile($input, $id)
	{
		$set = array(
			'gender'		=> 	$input['gender'],
			'bio'			=> 	$input['bio'],
			'phone'			=>	$input['phone'],
			'mobile'		=>	$input['mobile'],
			'address_line1'	=>	$input['address_line1'],
			'address_line2'	=>	$input['address_line2'],
			'address_line3'	=>	$input['address_line3'],
			'postcode'		=>	$input['postcode'],
	 		'website'		=>	$input['website'],
			'updated_on'	=>	now()
		);

		if (isset($input['dob_day']))
		{
			$set['dob'] = mktime(0, 0, 0, $input['dob_month'], $input['dob_day'], $input['dob_year']);
		}

		// Does this user have a profile already?
		if ($this->db->get_where('users_profiles', array('user_id' => $id))->row())
		{
			$this->db->update('users_profiles', $set, array('user_id'=>$id));
		}	
		else
		{
			$set['user_id'] = $id;
			$this->db->insert('users_profiles', $set);
		}
		
		return true;
	}
}