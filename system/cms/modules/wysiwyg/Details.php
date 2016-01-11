<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\
 */
class Module_Wysiwyg extends Module
{

    public $version = '1.0.0';

    public function info()
    {
        return 
        [
            'name' => 
            [
                'en' => 'WYSIWYG',
            ],
            'description' => 
            [
                'en' => 'Provides the WYSIWYG editor for OxygenCMS powered by CKEditor.',
            ],
            'frontend' => false,
            'backend' => false,
            'menu'=>false,
        ];
    }

    public function install()
    {

        $this->db->insert_batch('settings',
                [
                    [
                        'slug' => 'ckeditor_behaviour',
                        'title' => 'SHIFT+ENTER Mode behaviour.',
                        'description' => 'Select the behaviour for the result of pressing SHIFT+ENTER.',
                        'type' => 'select',
                        'default' => 'ENTER_BR',
                        'value' => "ENTER_BR",
                        'options' => 'ENTER_BR=ENTER_BR|ENTER_P=ENTER_P',
                        'is_required' => 1,
                        'is_gui' => 1,
                        'module' => 'wysiwyg',
                        'order' => 100,
                    ],
                    [ 
                        'slug' => 'ckeditor_theme',
                        'title' => 'Select the theme of CKeditor',
                        'description' => 'You can choose a theme for CKeditor',
                        'type' => 'select',
                        'default' => 'office2013',
                        'value' => 'office2013',
                        'options' => 'office2013=Modern|moono=Light|moono-dark=Dark|minimalist=Minimalist|bootstrapck=Bootstrap Style',
                        'is_required' => 1,
                        'is_gui' => 1,
                        'module' => 'wysiwyg',
                        'order' => 110,
                    ],
                    [ 
                        'slug' => 'ckeditor_adv_extrafeatures',
                        'title' => 'Display All tools  (Advanced Editor)',
                        'description' => 'Display all available tools for CKEditor',
                        'type' => 'select',
                        'default' => '1',
                        'value' => "1",
                        'options' => '0=No|1=Yes (Show)',
                        'is_required' => 1,
                        'is_gui' => 1,
                        'module' => 'wysiwyg',
                        'order' => 160,
                    ],
                ]
            );

            return true;
    }

    public function uninstall()
    {
        // This is a core module, lets keep it around.
        return false;
    }


    public function upgrade($old_version)
    {
        return true;                      
    }


    public function disable() 
    {
        return true;
    }
    
    public function enable() 
    { 
        return true;
    }

}
