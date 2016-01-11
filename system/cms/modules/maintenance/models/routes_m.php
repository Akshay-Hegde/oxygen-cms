<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Survey Survey model
 *
 * @author Sal McDonald
 * @category Models
 */
class Routes_m extends MY_Model {


	protected $_table = 'routes';


	public function reset_order(){
		$this->where('can_change',0)->update($this->_table,['ordering_count'=>0]);
	}
		
	public function set_order($field_id=0,$order=0){
		$this->db->where('id',$field_id)->update($this->_table,['ordering_count'=>$order]);
	}

}