<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Events_Email {
    
    protected $ci;
    
    public function __construct()
    {
        $this->ci =& get_instance();

        //what is this for ?
        $this->fallbacks = 
        [
            'comments'  => ['comments'  => 'email/comment'],
            'contact'   => ['contact'   => 'email/contact'],
        ];

        //register the email event
        Events::register('email', array($this, 'send_email'));   
        Events::register('admin_controller', [$this, 'dashboard'] );     
    }

    public function dashboard()
    {
        $mail_notifications = [];
        $recent_emails = $this->ci->db->limit(8)->order_by('uid','desc')->get('email_headers')->result();
        $this->ci->template->set('mail_notifications',$mail_notifications);
        $this->ci->template->set('recent_emails',$recent_emails);

    }    

    /**
     * -Defaults-
     *
     * $data['lang'] = settings::site_lang or -en-
     * $data['from'] = settings::server_email
     * $data['name'] = null
     * $data['reply-to'] = $data['from']
     * $data['to'] = settings::contact_email]
     * $data['attach'] = []
     */
    public function send_email($data = [])
    {
        $this->ci =& get_instance();

        $slug = $data['slug'];
        unset($data['slug']);

        $this->ci->load->model('email/email_templates_m');

        //get email template required
        $templates = $this->ci->email_templates_m->get_templates($slug);


        //make sure we have something to work with
        if ( ! empty($templates))
        {
            $lang      = isset($data['lang']) ? $data['lang'] : Settings::get('site_lang');
            $from      = isset($data['from']) ? $data['from'] : Settings::get('server_email');
            $from_name = isset($data['name']) ? $data['name'] : null;
            $reply_to  = isset($data['reply-to']) ? $data['reply-to'] : $from;
            $to        = isset($data['to']) ? $data['to'] : Settings::get('contact_email');

            $master = array_key_exists($lang, $templates) ? $templates[$lang]->master_template : $templates['en']->master_template ;

            $template_email_master = $this->get_template_master($master);

            //only for string, not arrays
            if ( ! is_array($to)) 
            {
                // perhaps they've passed a pipe separated string, let's switch it to commas for CodeIgniter
                $to = str_replace('|', ',', $to);

                // perhaps they've used semi-col
                $to = str_replace(';', ',', $to);
            }

            $subject = array_key_exists($lang, $templates) ? $templates[$lang]->subject : $templates['en']->subject ;
            $subject = $this->ci->parser->parse_string($subject, $data, true);

            $body = array_key_exists($lang, $templates) ? $templates[$lang]->body : $templates['en']->body ;
            $body = $this->ci->parser->parse_string($body, $data, true);

            //encase in master template
            //do unsubscribe link too, however on multiple emails this may not work in templating.
            //there is no loop for the email to be sent with
            $unsub = '<a href="'.site_url('subscriptions').'">Unsubscribe</a>';
            $body = $this->ci->parser->parse_string($template_email_master, ['body'=>$body, 'unsubscribe'=>$unsub], true);


            $this->ci->email->from($from, $from_name);
            $this->ci->email->reply_to($reply_to);
            $this->ci->email->to($to);
            $this->ci->email->subject($subject);
            $this->ci->email->message($body);
            
            // To send attachments simply pass an array of file paths in Events::trigger('email')
            // $data['attach'][] = /path/to/file.jpg
            // $data['attach'][] = /path/to/file.zip
            if (isset($data['attach']))
            {
                foreach ($data['attach'] AS $attachment)
                {
                    $this->ci->email->attach($attachment);
                }
            }

            return (bool) $this->ci->email->send();
        }

        //return false if we can't find the necessary templates
        return false;
    }  

    private function getDefaultThemePath() {
        $public_theme = $this->ci->theme_m->get();
        return $public_theme->path.'/';
    } 

    private function get_template_master($master='default') {

        $template_email_master = '{{body}}';

        //read file from template in public theme
        $public_theme =  Settings::get('public_theme');
        $filename = $this->getDefaultThemePath().'templates/email/master/'.$master.'.html';
        $this->ci->load->helper('file');
        if( file_exists($filename) ) {
            $template_email_master = htmlspecialchars_decode(file_get_contents($filename)); 
        }

        return $template_email_master;  
    } 
}
/* End of file Events.php */