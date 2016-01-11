<?php defined('BASEPATH') or exit('No direct script access allowed');

class Events_Forms {
    
    protected $CI;
    
    public function __construct()
    {
        $this->CI =& get_instance();
        Events::register('forms_postback', [$this, 'forms_postback'] );

        Events::trigger('forms_postback');
    }

    public function forms_postback()
    {
    	$this->refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    	$this->namespace = 'forms';

    	if($stream_slug = $this->CI->input->post('forms_0xyg3n'))
    	{
    		// Load streams
    		$this->CI->load->driver('Streams');
            $this->CI->load->library('streams/Fields');

    		$input = $this->CI->input->post();

			$extra = 
			[
				'return' 			=> $this->refer,
			    'cancel_url'		=> $this->refer,
				'success_message' 	=> $this->CI->lang->line('streams:new_entry_success'),
				'failure_message'	=> $this->CI->lang->line('streams:new_entry_error')
			];

            if($fields = $this->CI->fields->entry_request($stream_slug, $this->namespace, false, [], $extra ))
            {
                // Send email if they want it send
                if(isset($input['forms_send_email']) AND $input['forms_send_email'] == 'true')
                {

                    if($stream_row = $this->CI->db->where('stream_slug',$stream_slug)->get('data_streams')->row())
                    {
                        $this->CI->load->model('forms/metadata_m');
                        $metarow = $this->CI->metadata_m->get_by_stream($stream_row->id);

                        //double check if the email should be sent
                        if($metarow->notify_email==1)
                        {
                            $input['to'] =  $metarow->email; //Settings::get('contact_email');
                            $input['slug'] = 'contact'; //$metarow->email_template

                            //check if there is a email field
                            /*
                             if(isset($input['email'])) {
                                $input['reply-to'] = $input['email'];
                             }
                             */


                            Events::trigger('email', (array) $input);
                        }


                    }

                }

                $this->CI->session->set_flashdata('success', 'Success');   

                $redir_to = $this->CI->input->post('redirect_success');          
            }
            else
            {
                $this->CI->session->set_flashdata('error', 'Error' ); 
                $redir_to = $this->CI->input->post('redirect_error'); 
            }

            redirect($redir_to);


    	}
    }
 
}