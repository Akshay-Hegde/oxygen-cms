<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events_Tasks {
    
    protected $ci;
    
    public function __construct()
    {
        $this->ci =& get_instance();
        
        Events::register('admin_display_dashboard', [$this, 'dashboard'] );
        Events::register('admin_controller', [$this, 'dashboard'] );
		
        //request a list of tasks to display in maintenance module
        Events::register('maintenance_request', [$this, 'maintenance_request']);
    }
    
    public function dashboard()
    {
        $this->ci->load->model('tasks/tasks_m');

        $todo_tasks = $this->ci->tasks_m->where('complete',null)->order_by('pcent','desc')->get_all();


        //temp add
        Asset::add_path('tasks', APPPATH.'modules/tasks/' );

        $this->ci->template->append_js('tasks::dashboard_widget.js');

        $this->ci->template->set('todo_tasks',$todo_tasks);
        
    }

    public function maintenance_request($object_list_array)
    {
       $object_list_array->items[] = ['module'=>'tasks','name'=>'Clear All Todos','action'=>'admin/tasks/maintenance_delete_all', 'button_text'=>'Clear all','description'=>'A description'];
    } 
}
/* End of file Events.php */