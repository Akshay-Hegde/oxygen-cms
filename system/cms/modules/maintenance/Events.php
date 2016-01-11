<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Maintenance Events Class
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Maintenance
 */
class Events_Maintenance {

    public function __construct()
    {
        // this is triggered on every front-end page load and run_system_cron() checks
        // to see if this is a bot. If it's a bot we don't care if they get a slightly slower page load
        Events::register('public_controller', array($this, 'run_system_cron'));


        // this is a just a regular task that we use to maintain the session table.
        // Other modules can implement a cron task in a similar manner
        Events::register('system_cron', array($this, 'clean_sessions'));

        // Clear menu cache
        Events::register('module_disabled',[$this,'clear_menu_cache']);
        Events::register('module_upgraded',[$this,'clear_menu_cache']);
        Events::register('module_enabled',[$this,'clear_menu_cache']);

        Events::register('user_created',[$this,'clear_menu_cache']);
        Events::register('user_deleted',[$this,'clear_menu_cache']);
        Events::register('user_updated',[$this,'clear_menu_cache']);        
        
        Events::register('permissions_saved',[$this,'clear_menu_cache']);
        Events::register('permissions_users_saved',[$this,'clear_menu_cache']);
        Events::register('group_created',[$this,'clear_menu_cache']);       
        
    }

    /**
     * Keep track of cron times and trigger the event
     *
     * This is kept basic for 2.1. In a major version we'll add scheduling and a 
     * public controller that can be cURL'd with a standard server cron job
     * 
     * @return void
     */
    public function run_system_cron()
    {
        if (get_instance()->agent->is_robot())
        {
            Events::trigger('system_cron');
        }
    }

    /**
     * Clean stale sessions from the database
     * 
     * @return void
     */
    public function clean_sessions()
    {
        $session_table = SITE_REF.'_'.str_replace('default_', '', config_item('sess_table_name'));

        // delete all session records older than 1 week. 
        // In a major versioin we'll add Settings for this
        if (get_instance()->db->table_exists($session_table))
        {
            get_instance()->db->where('last_activity <', (now() - 604800))
                ->delete($session_table);
        }
    }


    public function clear_menu_cache()
    {

        $apath = $this->_refind_apath('menu');

        if ( ! empty($apath))
        {
            $item_count = count(glob($apath.'/*'));
            $this->delete_files($apath, 1);
        }
    
    }    

    private function _refind_apath($name)
    {

        $this->cache_path = SITE_DIR.'cache/';        

        $folders = glob($this->cache_path.'*', GLOB_ONLYDIR);

        foreach ($folders as $folder)
        {
            if (basename($folder) === $name)
            {
                return $folder;
            }
        }
    }

    private function delete_files($apath, $andfolder = false)
    {
        get_instance()->load->helper('file');

        if ( ! delete_files($apath, true))
        {
            return false;
        }

        if ($andfolder)
        {
            if ( ! rmdir($apath))
            {
                return false;
            }
        }

        return true;
    }

}