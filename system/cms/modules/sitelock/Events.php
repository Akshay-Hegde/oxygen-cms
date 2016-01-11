<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Class Events_Sitelock
 */
class Events_Sitelock
{
    /**
     * @var object
     */
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->library('session');
        $this->ci->lang->load('sitelock/sitelock');
        //Don't register event if logged in or the module is disabled
        if (is_logged_in() OR !Settings::get('sitelock_password_protect') OR $this->ci->session->userdata('sitelock_login')) {
            return false;
        };
        //Register redirect event
        if (!in_array($this->ci->uri->segment(1), ['sitelock', 'admin'])) {
            Events::register('public_controller', array($this, 'check'));
        }
    }

    /**
     *  Redirect if not authenticated
     */
    public function check()
    {
        redirect('sitelock');
    }
}
/* End of file Events.php */
