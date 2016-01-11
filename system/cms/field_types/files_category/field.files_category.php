<?php defined('BASEPATH') or exit('No direct script access allowed');


class Field_files_category
{
	
	public $field_type_name			= 'Files category';
	
	public $field_type_slug			= 'files_category';
	
	public $db_col_type				= 'varchar';

	public $version					= '1.0.0';

	public $author					= array(
										'name' => 'Sal McDonald',
										'url' => 'http://oxygen-cms.com');
	

	public function form_output($data, $params, $field)
	{
		$drop_name = $data['form_slug'];
		$current_product = $data['value'];	

		return  $this->build_select($drop_name,$current_product,$field->is_required);
	}
	
	private function build_select($drop_name,$current_id=0,$required='no') {

		$categories = $this->CI->db->get('file_folders')->result();
		$options = [];

		if ($required == 'no') {
			$extra_nonreq = [''=> get_instance()->config->item('dropdown_choose_null') ];
		}else {
			$extra_nonreq=[];
		}
		
		foreach($categories as $category) {
			$options[$category->id] = $category->name;
		}
		$extra = "id='{$drop_name}'";
		return form_dropdown($drop_name,$options+$extra_nonreq,$current_id,$extra);
	}



	public function pre_output_plugin($input, $params,$test=[])
	{

		if ( ! $input or ! is_string($input)) {
			return null;
		}


		$files = $this->CI->db->where('folder_id',$input)->get('files')->result();

		if ( ! $files) return null;

		return $files;
	}
	
}