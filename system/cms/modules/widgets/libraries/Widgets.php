<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Widget library takes care of the logic for widgets
 * 
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Widgets\Libraries
 */
class Widgets {

	private $_widget = null;
	private $_rendered_areas = [];	
	private $_widget_locations = [];

	public function __construct()
	{
		$this->load->model('widgets/widget_m');
		
		// where should we look in
		//
		// We should only look to the theme folder, not each module
		// developers were getting confused about view overrides
		// so lets keep it all in 1 place.
		$front_theme = Settings::get('public_theme');

		$locations = 
		[
		   //APPPATH.'themes/'.$front_theme.'/widgets/*',
		   //ADDONPATH.'themes/'.$front_theme.'/widgets/*',
		   SHARED_ADDONPATH.'widgets/*',
		];

		// Map where all widgets are
		// Map where all widgets are
		foreach ($locations as $path)
		{
			// get an array of found widgets
			$widgets = glob($path, GLOB_ONLYDIR);

			//if not, create empty array
			if ( ! is_array($widgets))
			{
				$widgets = [];
			}
			

			//set the widget paths
			foreach ($widgets as $widget_path)
			{
				$slug = basename($widget_path);

				// Set this so we know where it is later
				$this->_widget_locations[$slug] = $widget_path.'/';
			}

			unset($widgets);
		}
	}

	public function create_area($widget_name ='',$widget_slug='')
	{
		return $this->widget_m->create_area($widget_name,$widget_slug);
	}

	public function update_area($area_id, $widget_name ='',$widget_slug='')
	{
		return $this->widget_m->update_area($area_id, $widget_name,$widget_slug);
	}

	public function delete_area($area_id ='')
	{
		return $this->widget_m->delete_area($area_id);
	}

	public function get_all_areas()
	{
		return $this->widget_m->get_all_areas();
	}

	public function get_area($area_id)
	{
		return $this->widget_m->get_area($area_id);
	}

	public function get_all_enabled()
	{
		return $this->widget_m->get_all_enabled();
	}

	public function enable_widget($id = 0)
	{
		return $this->widget_m->enable_widget($id);
	}

	public function disable_widget($id = 0)
	{
		return $this->widget_m->disable_widget($id);
	}


	public function get_all()
	{
		return $this->widget_m->get_all();
	}


	public function format_for_admin(&$widgets=[])
	{

		foreach ($widgets as &$widget) 
		{
			$widget->instances = $this->widget_m->get_instances_by_widget($widget->id);
		}
	
	}

	/**
	 * Gets all the widgets that have been setup (instances)
	 */
	public function get_all_instances()
	{
		return $this->widget_m->get_all_instances();
	}

	/**
	 * List everything available
	 */
	public function list_available_widgets()
	{
		// Get a list of all widgets
		$uninstalled_widgets = $this->list_uninstalled_widgets();

		// Secondly, get a list of installed widgets
		$installed_widgets = $this->widget_m->order_by('slug')->get_all();

		foreach ($uninstalled_widgets as $widget)
		{
			$found = false;
			//check if it exist.
			foreach($installed_widgets as $key=>$ww):
				if($ww->slug == $widget->slug):
					$found =true;
				endif;
			endforeach;

			if($found==false):
				$this->add_widget((array) $widget);
			endif;

		}

		$avaliable = [];

		foreach ($installed_widgets as $widget)
		{
			if ( ! isset($this->_widget_locations[$widget->slug]))
			{
				$this->delete_widget($widget->slug);

				continue;
			}

			// Finally, check if is need and update the widget info
			$widget_file = FCPATH . $this->_widget_locations[$widget->slug] . $widget->slug . '.php';

			if (file_exists($widget_file) &&
				filemtime($widget_file) > $widget->updated_on)
			{

				$this->reload_widget($widget->slug);

				log_message('debug', sprintf('The information of the widget "%s" has been updated', $widget->slug));
			}

			$avaliable[] = $widget;
		}

		return $avaliable;
	}

	/**
	 * Get widgets that have not been added to system
	 */
	public function list_uninstalled_widgets()
	{
		$available = $this->widget_m->order_by('slug')->get_all();
		$available_slugs = [];

		foreach ($available as $widget)
		{
			$available_slugs[] = $widget->slug;
		}
		unset($widget);

		$uninstalled = [];
		foreach ($this->_widget_locations as $widget_path)
		{
			$slug = basename($widget_path);

			if ( ! in_array($slug, $available_slugs) and $widget = $this->read_widget($slug))
			{
				$uninstalled[] = $widget;
			}
		}

		return $uninstalled;
	}

	/**
	 * Get a specific instance by ID
	 */
	public function get_instance($instance_id)
	{
		$widget = $this->widget_m->get_instance($instance_id);

		if ($widget)
		{
			$widget->options = $this->_unserialize_options($widget->options);

			return $widget;
		}

		return false;
	}

	public function get_instance_by_name($name)
	{
		$widget = $this->widget_m->get_instance_by_name($name);

		if ($widget)
		{
			$widget->options = $this->_unserialize_options($widget->options);

			return $widget;
		}

		return false;
	}

	public function get_widget($id)
	{
		return is_numeric($id) ? $this->widget_m->get_widget_by('id', $id) : $this->widget_m->get_widget_by('slug', $id);
	}

	public function get_by_area($area_id)
	{
		return $this->widget_m->get_by_area($area_id);
	}

	public function read_widget($slug)
	{
		$this->_spawn_widget($slug);

		if ($this->_widget === false or ! is_subclass_of($this->_widget, 'Widgets'))
		{
			return false;
		}

		$widget = (object) get_object_vars($this->_widget);
		$widget->slug = $slug;
		//$widget->module = strpos($this->_widget->path, 'modules/') ? basename(dirname($this->_widget->path)) : null;
		//$widget->is_addon = strpos($this->_widget->path, 'addons/') !== false;
		$widget->module =  null;
		$widget->is_addon = false;
		return $widget;
	}

	/**
	 * render a widget
	 */
	public function render($name, $options = [])
	{
		$this->_spawn_widget($name);

		$data = method_exists($this->_widget, 'run') ? call_user_func(array($this->_widget, 'run'), $options) : [];

		// Don't run this widget
		if ($data === false)
		{
			return false;
		}

		// If we have true, just make an empty array
		$data !== true or $data = [];

		// convert to array
		is_array($data) or $data = (array) $data;

		$data['options'] = $options;

		// Is there an overload view in the theme?
		//$overload = file_exists($this->template->get_views_path().'widgets/'.$name.'/display'.'.php') ? $name : false;
		$overload = false; //its already there

		return $this->load_view('display', $data, $overload);
	}

	/**
	 * $slug - The slug to create an instance of
	 */
	public function render_backend( $slug, $saved_data = [] )
	{

		$this->_spawn_widget($slug);


		// No fields, no backend, no rendering
		if (empty($this->_widget->fields))
		{
			return '';
		}

		$options = [];
		$_arrays = [];

		foreach ($this->_widget->fields as $field)
		{
			$field_name = &$field['field'];
			if (($pos = strpos($field_name, '[')) !== false)
			{
				$key = substr($field_name, 0, $pos);

				if ( ! in_array($key, $_arrays))
				{
					$options[$key] = $this->input->post($key);
					$_arrays[] = $key;
				}
			}
			$options[$field_name] = set_value($field_name, isset($saved_data[$field_name]) ? $saved_data[$field_name] : '');
			unset($saved_data[$field_name]);
		}

		// Any extra data? Merge it in, but options wins!
		if ( ! empty($saved_data))
		{
			$options = array_merge($saved_data, $options);
		}

		// Check for default data if there is any
		$data = method_exists($this->_widget, 'form') ? call_user_func(array(&$this->_widget, 'form'), $options) : [];

		// Options we'rent changed, lets use the defaults
		isset($data['options']) or $data['options'] = $options;

		return $this->load_view('form', $data);
	}

	public function render_area($area)
	{
		//save the widget path
		$save_path = $this->load->get_view_paths();



		//already done! well pass it back.
		if (isset($this->_rendered_areas[$area]))
		{
			return $this->_rendered_areas[$area];
		}

		// Get all the widgets (instances) by area
		//$widgets = $this->widget_m->get_by_area($area);
		$widgets = $this->widget_m->get_by_area_slug($area);






		// wrap all widgets in 
		// this html - for areas only
		$view = 'widget_area';
		
		//build the widgets html
		$output = '';
		foreach ($widgets as $widget)
		{
			$widget->options = array_merge(array("instance_title" => $widget->instance_title), $this->_unserialize_options($widget->options));
			$output .= $this->render($widget->slug, $widget->options);
		}

		
		//$path = $this->template->get_views_path() . 'modules/widgets/';
		$path = 'system/cms/modules/widgets/views/';

		//set the view path to modules widgets for the wrapper
		$this->load->set_view_path($path);

		//echo $path;die;

		//load the wrapper, and wrap the widgets
		$output = $this->load->_ci_load(array('_ci_view' => $view, '_ci_vars' => array('body' => $output,'area' => $area), '_ci_return' => true)) . "\n";

		//return the view path
		$this->load->set_view_path($save_path);


		$this->_rendered_areas[$area] = $output;

		return $output;
	}

	/**
	 * Call events on all existing widgets
	 */
	public function call_widget_events()
	{
		$instances = $this->get_all_instances();
		$widgets=[];

		foreach($instances as $widget)
		{
			$widgets[$widget->widget_id] = '';
		}

		foreach($widgets as $widget_id=>$v)
		{
			if($widget = $this->widgets->get_widget($widget_id))
			{
				$this->widgets->call_widget_event($widget->slug);
			}
		}	
		
	}

	/**
	 * call the event on a single widget
	 */
	private function call_widget_event($slug)
	{
		//if not already
		$this->_spawn_widget($slug);

		//call the event if exist, otherwise move on.
		method_exists($this->_widget, 'event') AND call_user_func(array($this->_widget, 'event')) ;
	}

	public function reload_widget($slug)
	{
		if (is_array($slug))
		{
			foreach ($slug as $_slug)
			{
				if ( ! $this->reload_widget($_slug))
				{
					return false;
				}
			}
			return true;
		}

		$widget = $this->read_widget($slug);

		return $this->edit_widget(array(
			'title' 		=> $widget->title,
			'slug' 			=> $widget->slug,
			'description' 	=> $widget->description,
			'author' 		=> $widget->author,
			'website' 		=> $widget->website,
			'version' 		=> $widget->version
		));
	}

	public function add_widget($input)
	{
		return $this->widget_m->insert_widget($input);
	}

	public function edit_widget($input)
	{
		return $this->widget_m->update_widget($input);
	}

	public function update_widget_order($id, $position)
	{
		return $this->widget_m->update_widget_order($id, $position);
	}

	public function delete_widget($slug)
	{
		return $this->widget_m->delete_widget($slug);
	}



	/**
	 * $info['name']
	 * $info['title']
	 * $info['area']
	 * $info['widget_id']
	 */
	public function add_instance($info, $options = [], $data = [])
	{
		$slug = $this->get_widget($info['widget_id'])->slug;

		if ($error = $this->validation_errors($slug, $data))
		{
			return array('status' => 'error', 'error' => $error);
		}

		// The widget has to do some stuff before it saves
		$options = $this->widgets->prepare_options($slug, $options);

		$this->widget_m->insert_instance(
			[
				'title' => $info['title'],
				'name' => $info['name'],
				'area_id' => $info['area_id'],
				'widget_id' => $info['widget_id'],
				'options' => $this->_serialize_options($options),
				'data' => $data
			]
		);

		return array('status' => 'success');
	}

	/**
	 * $info['name'] 		= $input['name'];
	 * $info['title'] 		= $input['title'];
	 * $info['area'] 		= $input['area'];
	 * $info['widget_id'] 	= $input['widget_id'];
	 * $info['instance_id'] = $input['widget_instance_id'];
	 */
	public function edit_instance($info, $options = [], $data = [])
	{
		$slug = $this->widget_m->get_instance($info['instance_id'])->slug;

		if ($error = $this->validation_errors($slug, $options))
		{
			return ['status' => 'error', 'error' => $error];
		}

		// The widget has to do some stuff before it saves
		$options = $this->widgets->prepare_options($slug, $options);

		$this->widget_m->update_instance($info['instance_id'], 
			[
				'title' => $info['title'],
				'name' => $info['name'],
				'area_id' => $info['area_id'],
				'options' => $this->_serialize_options($options),
				'data' => $data
			]
		);

		return array('status' => 'success');
	}

	public function update_instance_order($id, $position)
	{
		return $this->widget_m->update_instance_order($id, $position);
	}

	public function delete_instance($id)
	{
		return $this->widget_m->delete_instance($id);
	}

	public function validation_errors($name, $options)
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', lang('global:title'), 'trim|required|max_length[100]');

		$this->_widget or $this->_spawn_widget($name);

		if (property_exists($this->_widget, 'fields'))
		{
			$this->form_validation->set_rules($this->_widget->fields);
		}

		if ( ! $this->form_validation->run('', false))
		{
			return validation_errors();
		}
	}

	public function prepare_options($name, $options = array())
	{
		$this->_widget or $this->_spawn_widget($name);

		if (method_exists($this->_widget, 'save'))
		{
			return (array) call_user_func(array(&$this->_widget, 'save'), $options);
		}

		return $options;
	}

	private function _spawn_widget($name)
	{
		$widget_path = $this->_widget_locations[$name];
		$widget_file = FCPATH . $widget_path . $name . '.php';

		if (file_exists($widget_file))
		{
			require_once $widget_file;
			$class_name = 'Widget_' . ucfirst($name);

			$this->_widget = new $class_name;
			$this->_widget->path = $widget_path;

			return;
		}

		$this->_widget = null;
	}

	public function __get($var)
	{
		if (isset(get_instance()->$var))
		{
			return get_instance()->$var;
		}
	}

	protected function load_view($view, $data = [], $overload = false)
	{
		if ($overload !== false)
		{
			return $this->parser->parse_string($this->load->_ci_load(array(
					'_ci_path' => $this->template->get_views_path().'widgets/' . $overload . '/display.php',
					'_ci_vars' => $data,
					'_ci_return' => true
				)), array(), true);
		}

		$path = isset($this->_widget->path) ? $this->_widget->path : $this->path;

		return $view == 'display'

			? $this->parser->parse_string($this->load->_ci_load(array(
				'_ci_path'		=> $path . 'views/' . $view . '.php',
				'_ci_vars'		=> $data,
				'_ci_return'	=> true
			)), array(), true)

			: $this->load->_ci_load(
				[
					'_ci_path'		=> $path . 'views/' . $view . '.php',
					'_ci_vars'		=> $data,
					'_ci_return'	=> true
				]
			);
	}

	private function _serialize_options($options)
	{
		return serialize((array) $options);
	}

	private function _unserialize_options($options)
	{

		$options = (array) unserialize($options);

		isset($options['show_title']) or $options['show_title'] = false;

		return $options;
	}
}