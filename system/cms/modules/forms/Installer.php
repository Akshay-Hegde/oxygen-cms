<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Installer_Forms extends Component
{
	public $info;

	public function __construct()
	{
		$this->ci = get_instance();
		$this->load->driver('Streams');
		$this->namespace = 'forms';
	}

	public function info()
	{
		return $this->info;
	}

	public function set_info($info)
	{
		$this->info = $info;
	}

	public function install()
	{
		// We need a meta data table so that we can have extra info like "do we send an email on success post ?"
		$tables = 
		[
			'forms' => 
			[
				'id' 				=> 	['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,],
				'form_stream_id'	=> 	['type' => 'INT', 'constraint' => 11, 'default' => 0],
				'store_db' 			=> 	['type' => 'INT', 'constraint' => 1, 'default' => 1],
				'notify_email' 		=> 	['type' => 'INT', 'constraint' => 1, 'default' => 0],
				'email' 			=> 	['type' => 'VARCHAR', 'constraint' => 255,],
				'msg_success'		=> 	['type' => 'VARCHAR', 'constraint' => 1024, 'null' => true, 'default'=>'Thank you for filling out the form'],
				'msg_error'			=> 	['type' => 'VARCHAR', 'constraint' => 1024, 'null' => true, 'default'=>'Oops, something went wrong..'],
				'redir_success'		=> 	['type' => 'VARCHAR', 'constraint' => 1024, 'null' => true, 'default'=>'{{url:site}}'],
				'redir_error'		=> 	['type' => 'VARCHAR', 'constraint' => 1024, 'null' => true, 'default'=>'{{url:current}}'],
				'replyto_field'		=> 	['type' => 'VARCHAR', 'constraint' => 80, 'null' => true, 'default'=>'email'],
			],
		];

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		//fields to add to system
        $fields = 
        [
		    [
		        'name'          => 'Website',
		        'slug'          => 'website',
		        'namespace'     => $this->namespace,
		        'type'          => 'url',
		        'required'      => false,
		        'title_column'  => false,
		    ],
		    [
		        'name'          => 'Email',
		        'slug'          => 'email',
		        'namespace'     => $this->namespace,
		        'type'          => 'email',
		        'required'      => false,
		        'title_column'  => false,
		    ],		    
		    [
		        'name'          => 'Name',
		        'slug'          => 'name',
		        'namespace'     => $this->namespace,
		        'type'          => 'text',
		        'required'      => false,
		        'title_column'  => true,
		        'locked'		=> false,
		    ],	    	    
		    [
		        'name'          => 'Message',
		        'slug'          => 'message',
		        'namespace'     => $this->namespace,
		        'type'          => 'textarea',
		        'required'      => false,
		        'title_column'  => false,
		    ],			    	    			    			      
       		[
		        'name'          => 'Captch',
		        'slug'          => 'captcha',
		        'namespace'     => $this->namespace,
		        'type'          => 'captcha',
		        'required'      => true,
		        'title_column'  => false,
		    ],	           
                                                                          
        ];

        $this->streams->fields->add_fields($fields);

		return true;
	}

	public function uninstall()
	{
		$this->streams->utilities->remove_namespace($this->namespace);
		return TRUE;
	}

	public function upgrade($old_version)
	{
		return TRUE;
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
/* End of file Details.php */