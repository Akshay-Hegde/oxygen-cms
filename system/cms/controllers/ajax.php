<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * The basic Ajax controller class.
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 * @package     PyroCMS\Core\Controllers
 *
 */
class Ajax extends MY_Controller
{
	/**
	 * Used in a javascript callback url.
	 * 
	 * Basically this is just an interface to url_title() defined 
	 * in /system/cms/helpers/MY_url_helper.php.
	 * 
	 * @see /system/cms/modules/files/js/functions.js, url_title()
	 */
    public function url_title()
    {
        $this->load->helper('text');

        $slug = trim(url_title($this->input->post('title'), 'dash', true), '-');

        $this->output->set_output($slug);
    }
}