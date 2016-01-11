<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/**
 * OxygenCMS
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 */
/**
 * MY_Email
 * Allows for email config settings to be stored in the db.
 *
 * @package 	PyroCMS\Core\Libraries
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */
class MY_Email extends CI_Email {

    /**
     * Constructor method
     * 
     * @return void
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        //set mail protocol
        $config['protocol'] = Settings::get('mail_protocol');

        //set a few config items (duh)
        $config['mailtype']	= "html";
        $config['charset']	= "utf-8";
        $config['crlf']		= Settings::get('mail_line_endings') ? "\r\n" : PHP_EOL;
        $config['newline']	= Settings::get('mail_line_endings') ? "\r\n" : PHP_EOL;

        //options 
        switch($config['protocol'])
        {
            case'sendmail':
                $config = $this->initSendmail($config);
                break;
            case'smtp':
                $config = $this->initSMTP($config);
                break;                                  
        }

        $this->initialize($config);
    }


    private function initSMTP($config)
    {
        $config['smtp_host'] = Settings::get('mail_smtp_host');
        $config['smtp_user'] = Settings::get('mail_smtp_user');
        $config['smtp_pass'] = Settings::get('mail_smtp_pass');
        $config['smtp_port'] = Settings::get('mail_smtp_port');

        return $config; 
    }   

    private function initSendmail($config)
    {
        if(Settings::get('mail_sendmail_path') == '')
        {
            //set a default
            $config['mailpath'] = '/usr/sbin/sendmail';
        }
        else
        {
            $config['mailpath'] = Settings::get('mail_sendmail_path');
        }

        return $config;
    }
}
/* End of file MY_Email.php */