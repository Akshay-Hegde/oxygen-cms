<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events_Notifications {
    
    protected $ci;
    
    public function __construct()
    {
        $this->ci =& get_instance();

        Events::register('admin_display_dashboard', [$this, 'dashboard'] );
        Events::register('admin_controller', [$this, 'evt_admin_controller'] );
    }
    
    public function dashboard()
    {
        $this->ci->load->model('notifications/notifications_m');

        $global_notifications = $this->ci->notifications_m->get_all();

        $this->ci->template->set('global_notifications',$global_notifications);

    }
    
    public function evt_admin_controller()
    {
        $this->dashboard();
    }    
}
/* End of file Events.php */