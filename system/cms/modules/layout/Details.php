<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Layout extends Module
{
    public $version = '1.0.0';

    private $module_name;

    public function __construct()
    {
        parent::__construct();
        $this->module_name = strtolower(str_replace('Module_', '', get_class()));
    }

    public function info()
    {
		$info = 
        [
            'name' => 
            [
                'en' => 'Layout'
            ],
            'description' => 
            [
                'en' => 'Home of the layout plugin'
            ],
            'backend' => false,
            'frontend' => false,
            'menu'  => false,
        ];

        return $info;
    }

    public function install()
    {
        return true;
    }

    public function upgrade($old_version)
    {
        return true;
    }

    public function uninstall()
    {
        return true;
    }
}
