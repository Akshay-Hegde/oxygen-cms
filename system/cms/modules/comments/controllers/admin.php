<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Comments\Controllers
 */
class Admin extends Admin_Controller {

	/**
	 * Array that contains the validation rules
	 * @access private
	 * @var array
	 */
	private $validation_rules = [
		[
			'field' => 'user_name',
			'label' => 'lang:comments:name_label',
			'rules' => 'trim'
		],
		[
			'field' => 'user_email',
			'label' => 'lang:global:email',
			'rules' => 'trim|valid_email'
		],
		[
			'field' => 'user_website',
			'label' => 'lang:comments:website_label',
			'rules' => 'trim'
		],
		[
			'field' => 'comment',
			'label' => 'lang:comments:send_label',
			'rules' => 'trim|required'
		],
	];

	/**
	 * Constructor method
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	
		// Load the required libraries, models, etc
		$this->load->library('form_validation');
		$this->load->model('comments/comments_m');
		$this->load->model('comments/comment_blacklists_m');
		$this->load->library('comments/comments');
		$this->load->helper('user');
		$this->lang->load('comments/comments');

		// Set the validation rules
		$this->form_validation->set_rules($this->validation_rules);
	}

	/**
	 * Index
	 * 
	 * @return void
	 */
	public function index()
	{
		// Filters
		$is_active = ($this->input->post('f_active')) ? $this->input->post('f_active') : 0;
		$module = $this->input->post('f_module') ? $this->input->post('f_module') : 0;

		$this->_prep_filter($is_active,$module);
		$total_rows = $this->db->from('comments')->count_all_results();

		$pagination = create_pagination('admin/comments/index', $total_rows);		

		$this->_prep_filter($is_active,$module);
		$comments = $this->db->limit($pagination['limit'],$pagination['offset'])->order_by('created_on', 'desc')->get('comments')->result();
  
		$this->input->is_ajax_request() && $this->template->set_layout(false);
		$module_list = $this->comments_m->get_slugs();
		$this->template
			->title($this->module_details['name'])
			->set('module_list',		$module_list)
			->set('comments',			$this->comments->process($comments))
			->set('comments_active',	$is_active)
			->set('pagination',			$pagination);
			
		$this->input->is_ajax_request() ? $this->template->build('admin/tables/comments') : $this->template->build('admin/index');
	}

	private function _prep_filter($is_active,$module)
	{
		if($is_active !== 'all')
		{
			$this->db->where('is_active',$is_active);
		}

		if($module !== 0)
		{
			$this->db->where('module',$module);
		}
	}

	/**
	 * Action method, called whenever the user submits the form
	 * 
	 * @return void
	 */
	public function action()
	{
		$action = strtolower($this->input->post('btnAction'));

		if ($action)
		{
			// Get the id('s)
			$id_array = $this->input->post('action_to');

			// Call the action we want to do
			if (method_exists($this, $action))
			{
				$this->{$action}($id_array);
			}
		}

		redirect('admin/comments');
	}

	/**
	 * Edit an existing comment
	 * 
	 * @return void
	 */
	public function edit($id = 0)
	{
		$id or redirect('admin/comments');

		// Get the comment based on the ID
		$comment = $this->comments_m->get($id);

		// Validate the results
		if ($this->form_validation->run())
		{
			if ($comment->user_id > 0)
			{
				$commenter['user_id'] = $this->input->post('user_id');
			}
			else
			{
				$commenter['user_name']	= $this->input->post('user_name');
				$commenter['user_email'] = $this->input->post('user_email');
			}

			$comment = array_merge($commenter, array(
				'user_website' => $this->input->post('user_website'),
				'comment' => $this->input->post('comment'),
			));

			// Update the comment
			$this->comments_m->update($id, $comment)
				? $this->session->set_flashdata('success', lang('comments:edit_success'))
				: $this->session->set_flashdata('error', lang('comments:edit_error'));

			// Fire an event. A comment has been updated.
			Events::trigger('comment_updated', $id);

			redirect('admin/comments');
		}

		// Loop through each rule
		foreach ($this->validation_rules as $rule)
		{
			if ($this->input->post($rule['field']) !== null)
			{
				$comment->{$rule['field']} = $this->input->post($rule['field']);
			}
		}

		$this->template
			->title($this->module_details['name'], sprintf(lang('comments:edit_title'), $comment->id))
			->append_metadata($this->load->view('fragments/wysiwyg', array(), true))
			->set('comment', $comment)
			->build('admin/form');
	}

	// Admin: report a comment to local tables/Akismet as spam
	public function report($id)
	{
		$api_key = Settings::get('akismet_api_key');
		$comment = $this->comments_m->get($id);
		if ( ! empty($api_key))
		{	
			$akismet = $this->load->library('akismet');
			$comment_array = array(
				'user_name' => $comment->user_name,
				'user_website' => $comment->user_website,
				'user_email' => $comment->user_email,
				'body' => $comment->comment
			);
      
			$config = array(
				'blog_url' => BASE_URL,
				'api_key' => $api_key,
				'comment' => $comment_array
			);

			$akismet->init($config);

			//expecting to see $comment as an array not an object...
			$akismet->submit_spam();          
		}
            
		$this->comment_blacklists_m->save(array(
			'website' => $comment->user_website,
			'email' => $comment->user_email
		));

		$this->delete($id);

		redirect('admin/comments');	
	}

        // Admin: Delete a comment
	public function delete($ids)
	{
		// Check for one
		$ids = ( ! is_array($ids)) ? array($ids) : $ids;

		// Go through the array of ids to delete
		$comments = [];
		foreach ($ids as $id)
		{
			// Get the current comment so we can grab the id too
			if ($comment = $this->comments_m->get($id))
			{
				$this->comments_m->delete((int) $id);

				// Wipe cache for this model, the content has changed
				$this->oxycache->delete('comments_m');
				$comments[] = $comment->id;
			}
		}

		// Some comments have been deleted
		if ( ! empty($comments))
		{
			(count($comments) == 1)
				? $this->session->set_flashdata('success', sprintf(lang('comments:delete_single_success'), $comments[0]))				/* Only deleting one comment */
				: $this->session->set_flashdata('success', sprintf(lang('comments:delete_multi_success'), implode(', #', $comments )));	/* Deleting multiple comments */
		
			// Fire an event. One or more comments were deleted.
			Events::trigger('comment_deleted', $comments);
		}

		// For some reason, none of them were deleted
		else
		{
			$this->session->set_flashdata('error', lang('comments:delete_error'));
		}

		redirect('admin/comments');
	}

	/**
	 * Approve a comment
	 * 
	 * @param  mixed $ids		id or array of ids to process
	 * @param  bool $redirect	optional if a redirect should be done
	 * @return void
	 */
	public function approve($id = 0, $redirect = true)
	{
		$id && $this->_do_action($id, 'approve');

		$redirect and redirect('admin/comments');
	}

	/**
	 * Unapprove a comment
	 * 
	 * @param  mixed $ids		id or array of ids to process
	 * @param  bool $redirect	optional if a redirect should be done
	 * @return void
	 */
	public function unapprove($id = 0, $redirect = true)
	{
		$id && $this->_do_action($id, 'unapprove');

		if ($redirect)
		{
			$this->session->set_flashdata('is_active', 1);

			redirect('admin/comments');
		}
	}

	/**
	 * Do the actual work for approve/unapprove
	 * @access protected
	 * @param  int|array $ids	id or array of ids to process
	 * @param  string $action	action to take: maps to model
	 * @return void
	 */
	protected function _do_action($ids, $action)
	{
		$ids		= ( ! is_array($ids)) ? array($ids) : $ids;
		$multiple	= (count($ids) > 1) ? '_multiple' : null;
		$status		= 'success';

		foreach ($ids as $id)
		{
			if ( ! $this->comments_m->{$action}($id))
			{
				$status = 'error';
				break;
			}

			if ($action == 'approve')
			{
				// add an event so third-party devs can hook on
				Events::trigger('comment_approved', $this->comments_m->get($id));
			}
			else
			{
				Events::trigger('comment_unapproved', $id);
			}
		}

		$this->session->set_flashdata(array($status => lang('comments:' . $action . '_' . $status . $multiple)));
	}

	public function preview($id = 0)
	{
		$this->template
			->set_layout(false)
			->set('comment', $this->comments_m->get($id))
			->build('admin/preview');
	}

}
