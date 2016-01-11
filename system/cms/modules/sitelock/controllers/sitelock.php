<?php defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Class Sitelock
 */
class Sitelock extends Public_Controller
{
    /**
     * Don't show the form if logged in
     */
    function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->template->set_layout(false);
    }

    /**
     * Show login page
     */
    public function index()
    {
        $this->authCheck();
        $this->template->build('login');
    }

    /**
     * Validate input
     */
    public function login()
    {
        $this->authCheck();
        $this->form_validation->set_rules('sitelock_password', 'Password', 'trim|required');

        if ($this->form_validation->run() AND $this->input->post('sitelock_password') === trim(Settings::get('sitelock_password'))) {

            $this->session->set_userdata('sitelock_login', true);

            redirect('');
        }

        $this->template->build('login', ['message' => lang('sitelock:wrong_pass')]);
    }

    /**
     * Destroy session if you need for some reason
     */
    public function destroy()
    {
        $this->session->sess_destroy();
        redirect('');
    }

    private function authCheck()
    {
        if (is_logged_in() OR !Settings::get('sitelock_password_protect') OR $this->session->userdata('sitelock_login')) {
            redirect('');
        };
    }


}
