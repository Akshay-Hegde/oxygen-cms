<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * @author		 Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Users\Controllers
 */
class Auth extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();


	}

	/**
	 * wip
	 * hand Auth callback handling here
	 */
	public function index()
	{
		echo 'You dont have access to this function.';
		redirect('users');
	}


}