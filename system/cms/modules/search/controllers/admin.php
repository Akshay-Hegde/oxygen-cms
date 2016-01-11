<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

	static $results;

	public function __construct() {
		parent::__construct();
		self::$results = [];
	}

	public function index($query_string='')
	{
		//have we posted a value?
		if($this->input->post('q')) {
			$query_string = $this->input->post('q');
		}
		/*
		elseif($this->input->get('qs')) {
			$query_string = $this->input->get('qs');
		}
		*/

		// Any registerd search module can provide results
		$ret = Search::trigger('admin_search',$query_string);

		/*
		//cut the length so it fits in the sidebar, but leaving full text so that it can have hover title
        foreach($ret as &$result) {
            $result['dtitle'] = substr($result['title'],0,15);  
        }
        */

		//now display as required
		if($this->input->is_ajax_request()) 
		{
			exit(json_encode(array('status'=>'success','results' => $ret)));
		} 
		else 
		{
			dump($ret);die;
		}

    }

}