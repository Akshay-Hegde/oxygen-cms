<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events_Blog {
    
    protected $ci;
    
    public function __construct()
    {
        $this->ci =& get_instance();

        Events::register('public_controller', [$this, 'public_controller'] );     
    }

    public function public_controller()
    {
        // Provide an event to other module to link data here
        // If there is a blog module, link to its RSS feed in the head
        /*
        if (module_enabled('blog'))
        {
            
        }
        */
        $this->ci->template->append_metadata('<link rel="alternate" type="application/rss+xml" title="'.Settings::get('site_name').'" href="'.site_url('blog/rss/all.rss').'" />');
    }    
}
/* End of file Events.php */