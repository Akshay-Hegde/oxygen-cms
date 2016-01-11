<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the widgets module.
 * 
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\Widgets\Controllers
 *
 */
class Admin extends Admin_Controller {

	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'widgets';

	/**
	 * Constructor method
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('widgets');
		$this->lang->load('widgets');
		$this->load->model('widgets/widget_m');

		$this->input->is_ajax_request() and $this->template->set_layout(false);

		if (in_array($this->method, array('index', 'manage')))
		{
			// requires to install and/or uninstall widgets
			$this->widgets->list_available_widgets();
		}

		$this->template->append_js('module::widgets.js');
	}



	
	/**
	 * List all available areas
	 */
	public function index($slug = '')
	{
		$data = new stdClass();

		// Get the list of areas from db, replace get from theme.
		$data->areas = $this->widgets->get_all_areas();

		//dump($data->areas);die;

		// Create the layout
		$this->template
			->title($this->module_details['name'])
			->build('admin/index', $data);
	}



	/**
	 * Update the order of the widgets
	 * 
	 * @return void
	 */
	public function update_order($to = 'instance')
	{
		$ids = explode(',', $this->input->post('order'));

		$i = 0;

		switch ($to)
		{
			case 'instance':
				foreach ($ids as $id)
				{
					$id = str_replace('instance-', '', $id);
					$this->widgets->update_instance_order($id, ++$i);
				}
				break;

			case 'widget':
				foreach ($ids as $id)
				{
					$this->widgets->update_widget_order($id, ++$i);
				}
				break;
		}

		$this->oxycache->delete_all('widget_m');
	}	


////////
		/**
	 * Enable widget
	 *
	 * @access	public
	 * @param	string	$id			The id of the widget
	 * @param	bool	$redirect	Optional if a redirect should be done
	 * @return	void
	 */
	public function enable($id = '', $redirect = true)
	{
		$id && $this->_do_action($id, 'enable');

		if ($redirect)
		{
			$this->session->set_flashdata('enabled', 0);

			redirect('admin/widgets/manage');
		}
	}

	/**
	 * Disable widget
	 *
	 * @access	public
	 * @param	string	$id			The id of the widget
	 * @param	bool	$redirect	Optional if a redirect should be done
	 * @return	void
	 */
	public function disable($id = '', $redirect = true)
	{
		$id && $this->_do_action($id, 'disable');

		$redirect and redirect('admin/widgets/manage');
	}

	/**
	 * Do the actual work for enable/disable
	 *
	 * @access	protected
	 * @param	int|array	$ids	Id or array of Ids to process
	 * @param	string		$action	Action to take: maps to model
	 * @return	void
	 */
	protected function _do_action($ids = array(), $action = '')
	{
		$ids		= ( ! is_array($ids)) ? array($ids) : $ids;
		$multiple	= (count($ids) > 1) ? '_mass' : null;
		$status		= 'success';

		foreach ($ids as $id)
		{
			if ( ! $this->widget_m->{$action . '_widget'}($id))
			{
				$status = 'error';
				break;
			}
			else
			{
				// Fire an Event. A widget has been enabled or disabled. 
				switch ($action)
				{
					case 'enable':		
						Events::trigger('widget_enabled', $ids);
						break;
					
					case 'disable':		
						Events::trigger('widget_disabled', $ids);
						break;
				}
			}
		}

		$this->session->set_flashdata( array($status=> lang('widgets:'.$action.'_'.$status.$multiple)));
	}


	public function areas($method='create',$p1='',$p2='')
	{
		$this->input->is_ajax_request() and $this->template->set_layout(false);


		//re hash db with uptodate list of widgets
		//$this->widgets->list_available_widgets();

		// Get Widgets
		if($this->input->is_ajax_request()) {

		} else {
			$available_widgets = $this->widgets->get_all_enabled();
			$_widgets = [];
			foreach($available_widgets as $w)
			{
				$_widgets[$w->slug] = $w->title ;
			}

			// Get the instances and add to the widget array
			//$this->widgets->format_for_admin($available_widgets);
			$this->template->available_widgets = form_dropdown('widget-slug',$_widgets,null,'id="available_widgets" class="dyn-available_widgets form-control"');

		}

		switch($method) 
		{
			case 'create':
				//to enter it cant be a ajax request
				if($widget_name = $this->input->post('widget_name'))
				{
					$widget_slug = $this->input->post('widget_slug');

					if($this->widgets->create_area($widget_name,$widget_slug))
					{
						redirect('admin/widgets');
					}
				}

				//here we want to load the view for the ajax form
				$this->template->build('admin/areas/form');
				break;
		
			case 'delete':
				$area_id = $p1;
				$this->widgets->delete_area($area_id);
				redirect('admin/widgets');
				break;
			case 'edit':
				$area_id = $p1;
				if($widget_name = $this->input->post('widget_name'))
				{
					$widget_slug = $this->input->post('widget_slug');

					if($this->widgets->update_area($area_id,$widget_name,$widget_slug))
					{
						redirect('admin/widgets');
					}
				}	
				//1. get the area
				$area = $this->widgets->get_area($area_id);
				$this->template->build('admin/areas/form',$area);		
				break;	
			case 'widgets':
				$area_id = $p1;
				$widgets = $this->widgets->get_by_area($area_id); 

				$this->template
					->set('widget_area',$area_id)
					->set('widgets',$widgets)
					->build('admin/areas/widgets');	
				break;

		}
	}


	public function instances($action='',$p1='',$p2='') {

		switch($action) {
			
			case 'add':
				$this->instances_add($p1);
				break;			
			case 'delete':
				$this->instances_delete($p1, $p2);
				break;
			case 'edit':
				$this->instances_edit($p1, $p2);
				break;				
		}
	}


	/**
	 * Add a widget instance to the area
	 */
	private function instances_add($area_id=0)
	{

		$slug = $this->input->post('widget-slug');
		
		if ( $widget = $this->widgets->get_widget($slug))
		{
			$data = [];

			$data['widget']	= $widget;
			$data['form']	= $this->widgets->render_backend($widget->slug, isset($widget->options) ? $widget->options : [] );

			$data['area_id'] = $area_id;
			$data['areas'] = []; 
			foreach($this->widgets->get_all_areas() as $a) {
				$data['areas'][$a->id] = $a->name;
			}
			$data['current_action']	= 'add';

			 //$data['areas']

			$this->template->build('admin/widgets/add', $data);
		}
		else
		{
			//get outter here
			redirect('admin/widgets');
		}
	}

	public function instances_add_postback()
	{
		if($input = $this->input->post()) 
		{
			$slug = $this->input->post('widget-slug');
			
			$info = [];
			$info['name'] = $input['name'];
			$info['title'] = $input['title'];
			$info['area_id'] = $input['area_id'];
			$info['widget_id'] = $input['widget_id'];

			//dont need these anymore
			unset($input['btnAction'],$input['area_id'],$input['title'],$input['name'], $input['widget_id']);

			$result = $this->widgets->add_instance($info, $input);



			if ($result['status'] === 'success')
			{
				// Fire an event. A widget instance has been created. pass the widget id 
				Events::trigger('widget_instance_created', $info['widget_id']);
				
				$status		= 'success';
				$message	= lang('success_label');
			}
			else
			{
				$status		= 'error';
				$message	= $result['error'];
			}

			$this->session->set_flashdata($status, $message);




			if ($status === 'success')
			{	
				redirect('admin/widgets/areas/widgets/'.$info['area_id']);
			}
			else {
				redirect('admin/widgets/instances/add/'.$info['area_id'].'/'.$slug);
			}

			$data['messages'][$status] = $message;		
		}

		redirect('admin/widgets/');
	}

	/**
	 * Create the form for editing a widget instance
	 * 
	 * @return void
	 */
	public function instances_edit($area_id=0,$instance_id = 0)
	{
		$areas = [];

		if ( ! ($instance_id && $widget = $this->widgets->get_instance($instance_id)))
		{
			// @todo: set error
			return false;
		}

		$data = [];

		if ($input = $this->input->post())
		{

			$info = [];
			$info['name'] 		= $input['name'];
			$info['title'] 		= $input['title'];
			$info['area_id'] 	= $input['area_id'];
			$info['widget_id'] 	= $input['widget_id'];
			$info['instance_id'] = $input['widget_instance_id'];

			unset($input['btnAction'], $input['name'],  $input['area_id'],$input['title'], $input['widget_id'],  $input['widget_instance_id']); 

			$result = $this->widgets->edit_instance($info, $input);


			if ($result['status'] === 'success')
			{
				// Fire an event. A widget instance has been updated pass the widget instance id.
				Events::trigger('widget_instance_updated', $info['instance_id']);
				
				$status		= 'success';
				$message	= lang('success_label');

			}
			else
			{
				$status		= 'error';
				$message	= $result['error'];
			}

			if ($this->input->is_ajax_request())
			{
				$data = [];

				$status === 'success' and $data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, true);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'active'	=> false,
				));
			}

			if ($status === 'success')
			{
				$this->session->set_flashdata($status, $message);
				redirect('admin/widgets');
				return;
			}

			$data['messages'][$status] = $message;
		}

		$data['areas'] = []; 
		foreach($this->widgets->get_all_areas() as $a) {
			$data['areas'][$a->id] = $a->name;
		}

		$data['area_id'] = $area_id;


		$data['widget']	= $widget;
		$data['form']	= $this->widgets->render_backend($widget->slug, isset($widget->options) ? $widget->options : []);
		$data['current_action']	= 'edit';

		$this->template->build('admin/widgets/add', $data);
	}

	public function instances_edit_postback($instance_id = 0)
	{
		$areas = [];

		if ( ! ($instance_id && $widget = $this->widgets->get_instance($instance_id)))
		{
			// @todo: set error
			return false;
		}

		$data = [];

		if ($input = $this->input->post())
		{

			$info = [];
			$info['name'] 		= $input['name'];
			$info['title'] 		= $input['title'];
			$info['area_id'] 	= $input['area_id'];
			$info['widget_id'] 	= $input['widget_id'];
			$info['instance_id'] = $input['widget_instance_id'];

			unset($input['btnAction'], $input['name'],  $input['area_id'],$input['title'], $input['widget_id'],  $input['widget_instance_id']); 

			$result = $this->widgets->edit_instance($info, $input);


			if ($result['status'] === 'success')
			{
				// Fire an event. A widget instance has been updated pass the widget instance id.
				Events::trigger('widget_instance_updated', $info['instance_id']);
				
				$status		= 'success';
				$message	= lang('success_label');

			}
			else
			{
				$status		= 'error';
				$message	= $result['error'];
			}

			if ($this->input->is_ajax_request())
			{
				$data = [];

				$status === 'success' and $data['messages'][$status] = $message;
				$message = $this->load->view('admin/partials/notices', $data, true);

				return $this->template->build_json(array(
					'status'	=> $status,
					'message'	=> $message,
					'active'	=> false,
				));
			}

			if ($status === 'success')
			{
				$this->session->set_flashdata($status, $message);
				redirect('admin/widgets');
				return;
			}

			$data['messages'][$status] = $message;
		}

		$data['areas'] = []; 
		foreach($this->widgets->get_all_areas() as $a) {
			$data['areas'][$a->id] = $a->name;
		}

		$data['area_id'] = $area_id;


		$data['widget']	= $widget;
		$data['form']	= $this->widgets->render_backend($widget->slug, isset($widget->options) ? $widget->options : []);
		$data['current_action']	= 'edit';

		$this->template->build('admin/widgets/add', $data);
	}

	/**
	 * Delete a widget instance
	 * 
	 * @return void
	 */
	private function instances_delete($area_id, $id = 0)
	{
		if ($this->widgets->delete_instance($id))
		{
			// Fire an event. A widget instance has been deleted. 
			Events::trigger('widget_instance_deleted', $id);
				
			$status = 'success';
			$message = lang('success_label');
		}
		else
		{
			$status = 'error';
			$message = lang('general_error_label');
		}

		$this->session->set_flashdata($status, $message);
		redirect('admin/widgets/areas/widgets/'.$area_id);
	}


}
