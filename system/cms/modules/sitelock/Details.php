<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Module_Sitelock
 */
class Module_Sitelock extends Module
{

    /**
     * @var string
     */
    public $version = '1.0.0';

    /**
     * @return array
     */
    public function info()
    {
        return [
            'name' => [
                'en' => 'Site lock'
            ],
            'description' => [
                'en' => 'Password protect your web front-end'
            ],
            'frontend' => true,
            'backend' => false,
        ];
    }

    /**
     * Install settings
     * @return bool
     */
    public function install()
    {

        $settings = 
        [
            [
                'slug' => 'sitelock_password_protect',
                'title' => 'Lock site with Password',
                'description' => '',
                'type' => 'select',
                'default' => '0',
                'value' => '0',
                'options' => '1=Locked|0=Open (Unlocked)',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'security',
                'order' => 899,
            ],
            [
                'slug' => 'sitelock_password',
                'title' => 'Password',
                'description' => 'Enter the password to lock your site',
                'type' => 'text',
                'default' => 'hidden',
                'value' => 'hidden',
                'options' => '',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'security',
                'order' => 890,
            ],

        ];
        foreach ($settings as $setting) {
            if (!$this->db->insert('settings', $setting)) {
                return false;
            }
        }
        return true;
    }


    /**
     * Remove settings
     * @return bool
     */
    public function uninstall()
    {
        $this->db->where('module', 'sitelock');

        if ($this->db->delete('settings')) {
            return true;
        }
        return false;

    }


    /**
     * @param string $old_version
     * @return bool
     */
    public function upgrade($old_version)
    {
        return true;
    }


    /**
     * @return string
     */
    public function help()
    {
        return '<p></p>';

    }
}

/* End of file Details.php */
