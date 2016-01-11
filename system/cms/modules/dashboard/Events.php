<?php defined('BASEPATH') or exit('No direct script access allowed');

class Events_Dashboard {
    
    protected $CI;
    
    public function __construct()
    {
        $this->CI =& get_instance();
        
        //When the flows module handles the data we want to clear the cache
        Events::register('install_dashboard_widget', array($this, 'install_dashboard_widget'));

    }
 
    public function install_dashboard_widget($object_data)
    {
        //req fields
        $fields = ['section','name','partial','order','is_visible','module'];

        //check we have all the data
        foreach($object_data as $key=>$value)
        {
            if(in_array($key,$fields)) {

            } else {
                unset($object_data[$key]);
            }
        }

        foreach($fields as $key)
        {
            if(!isset($object_data[$key])) {
                //we cant install this widget
                return;
            }
        }   

        $this->CI->db->insert('widgets_admin',$object_data);
    }

}