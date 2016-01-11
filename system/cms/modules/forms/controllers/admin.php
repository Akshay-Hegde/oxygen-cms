<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
/**
 * @author Oxygen-CMS Dev Team
 */
class Admin extends Admin_Controller
{
	public function __construct() {
		parent::__construct();
		redirect('admin/forms/forms');
	}
}