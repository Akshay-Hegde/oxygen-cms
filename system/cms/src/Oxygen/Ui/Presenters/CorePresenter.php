<?php namespace Oxygen\Ui\Presenters;


/**
 * @author Sal McDonald
 */
abstract class CorePresenter {

	/**
	 * Ref to ci->template
	 */
	protected $template;

	/**
	 * HMVC module id
	 */
	protected $module_details;

	/**
	 * View ref
	 */
	protected $default_view;


	/**
	 * Latyout to use
	 */
	protected $default_layout;


	/**
	 * Assigned values
	 */
	private $_values = [];



	/**
	 * @constructor
	 */
	public function __construct() {
		// Get the ci->template instance
		$this->template = get_instance()->template;
		$this->module_details = get_instance()->module_details;
		$this->default_view = 'view';
	}

	/**
	 * Present the item
	 */
	public function present($object=null) {
		//Set all the variables
		$this->_set_all();

		//show the template
		$this->template->build($this->default_view,$object);
	}

	/**
	 * Assign values/key pairs
	 */
	public function assign($name,$value) {
		$this->_values[$name] = $value;
	}


	public function set_view($view_name) {
		$this->default_view = $view_name;
	}

	/**
	 * Get a value by name
	 */
	public function get($name) {
		return $this->_values[$name];
	}

	/**
	 * Set all values to template
	 */
	private function _set_all() {
		foreach($this->_values as $name =>$value) {
			$this->template->set($name,$value);
		}	
	}	
}