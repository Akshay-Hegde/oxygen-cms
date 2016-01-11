<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Soundcloud Field Type
 *
 * @package		PyroStreams
 * @author		Jose Luis Fonseca
 * @team                WeDreamPro
 * @copyright           Copyright (c) 2014, WeDreamPro
 */
class Field_soundcloud {

    public $field_type_slug = 'soundcloud';
    public $db_col_type = 'text';
    public $version = '1.0.0';
    public $author = array('name' => 'Jose Fonseca', 'url' => 'http://josefonseca.me');

    // --------------------------------------------------------------------------

    /**
     * Output form input
     *
     * @access	public
     * @param   $params	array
     * @return	string
     */
    public function form_output($params) {
        $soundcloud_info = !empty($params['value']) ? json_decode($params['value']) : null;

        $input_options = array(
            'name' => $params['form_slug'] . '_url',
            'type' => 'text',
            'id' => $params['form_slug'],
            'data-fieldtype' => 'soundcloud',
            'value' => !empty($soundcloud_info->url) ? $soundcloud_info->url : null,
            'placeholder' => lang('streams:soundcloud.input_placeholder')
        );

        $input_hidden_options = array(
            $params['form_slug'] => $params['value']
        );


        return $this->CI->type->load_view('soundcloud', 'input', array(
                    'input_options' => $input_options,
                    'input_hidden_options' => $input_hidden_options
                ));
          
    }

    // --------------------------------------------------------------------------

    /**
     * Tag output variables
     *
     *
     * @access 	public
     * @param	string
     * @param	array
     * @return	array
     */
    public function pre_output($input, $params) {
        if (!$input)
            return null;
        $data = json_decode($input);
        return html_entity_decode($data->html);
    }
    
    /**
     * $input = Information from database 
     * $params = Stream info
     *
     *   {{ slug:title }}
     *   {{ slug:description }}
     *   {{ slug:thumbnail_url }}
     *   {{ slug:html }}
     *   {{ slug:author_name }}
     *   {{ slug:author_url }}
     *   {{ slug:url }}
     *
     */
    public function pre_output_plugin($input, $params, $slug='', $y='') {

        //$acceptable = ['title', 'description', 'thumbnail_url', 'html', 'author_name', 'author_url', 'url']
        //var_dump($y);die;

        if (!$input)
            return null;

        $data = json_decode($input);

        $data->html = html_entity_decode($data->html);

        $data = (array) $data;

        $data['thumbnail'] = $data['thumbnail_url'];

        return $data;
    }






    // ----------------------------------------------------------------------

    /**
     * Event
     *
     * Load assets
     *
     * @access public
     * @param $field object
     * @return void
     */
    public function event() {
        if($this->CI->uri->segment(1) == 'admin') $this->CI->type->add_js('soundcloud', 'soundcloud.js');
    }

}
