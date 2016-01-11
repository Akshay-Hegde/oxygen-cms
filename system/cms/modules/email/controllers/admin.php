<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**	
 * Oxygen-CMS 
 *
 * @author Sal McDonald (2013-2016)
 *
 * @package OxygenCMS\Core\
 *
 *
 * @copyright  Copyright (c) 2013-2016
 * @copyright  Oxygen-CMS
 * @copyright  oxygen-cms.com
 * @copyright  Sal McDonald
 *
 * @contribs PyroCMS Dev Team, PyroCMS Community, Oxygen-CMS Community
 *
 */
class Admin extends Admin_Controller
{

	protected $section = 'compose';


	/**
	 * @constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->lang->load('email');
		$this->lang->load('templates');
		// For db access we only need the email address
		$this->imap_user = Settings::get('mail_imap_email');
		$this->interval_time = Settings::get('mail_interval_minutes');

		// Set the view limit
		$this->limit = 20;		

		$this->template->enable_parser(true);
	}


	public function index($offset=0)
	{

		$folder = $this->get_local_folder();
		$total_items = $this->email_headers_m->where('folder_id',$folder)->count_all();


		//  Build pagination for these items
		$pagination = create_pagination( 'admin/email/index' , $total_items, $this->limit, 4);

		//read from session value
		$messages = $this->email_headers_m->where('folder_id',$folder)->fetch($pagination['offset'],$pagination['limit'] );


		// Display
		$this->template
			->set('custom_folders',$this->email_folders_m->get_all())
			->set('messages',$messages)
			->set('pagination',$pagination)
			->set('inttime',$this->interval_time)
			->append_js("module::admin_email.js")
			->build('admin/list/index');
	}

	public function compose()
	{

		$this->load->model('users/users_util_m');
		$this->load->model('groups/group_m');
		
		$users = $this->users_util_m->get_users_select('email');
		$groups = $this->group_m->get_all_select();

		if($this->input->post('to'))
		{
			$this->_handle_compose_postback();
		}

		$this->template
			->set('users',$users)
			->set('groups',$groups)
			->build('admin/compose');
	}

	private function _handle_compose_postback()
	{
		$input = $this->input->post();

		if(isset($input['body'])) {

			if(isset($input['subject'])) {

				$input['slug'] = 'email_compose';


				$tos = explode(';',$input['to']);

				unset($input['to']);

				foreach($tos as $email)
				{
					if(trim($email) == '') continue;
					
					//$x = $this->users_util_m->get_user_email($user_id);
					$input['to'] = $email;
					
					//check if valid email

					if(Events::trigger('email',$input))
					{
						$this->session->set_flashdata('success','Email sent..');
						
					}
				}

				redirect(current_url());

			}
		}
	}
	
}