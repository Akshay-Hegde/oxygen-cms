<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Installer_Lists extends Component
{

	public $info;

	public function __construct()
	{
		$this->ci = get_instance();
		$this->load->driver('Streams');
		$this->namespace = 'lists';
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
		//fields to add to system
        $fields = 
        [
		    [
		        'name'          => 'Active Status',
		        'slug'          => 'onoff_status',
		        'namespace'     => $this->namespace,
		        'type'          => 'onoff_status',
		        'extra'         => ['default_value'=>1],
		        'title_column'  => false,
		        'required'      => true,
		        'unique'        => false,
		        'locked'		=> true,
		    ],        
		    [
		        'name'          => 'Image',
		        'slug'          => 'image',
		        'namespace'     => $this->namespace,
		        'type'          => 'image',
		        'extra'         => ['folder'=>1, 'allowed_types'=>'jpg|jpeg|png'],/*'resize_height'=>400*/
		        'title_column'  => false,
		        'required'      => true,
		        'unique'        => false,
		        'locked'		=> false,
		    ],
		    [
		        'name'          => 'Link',
		        'slug'          => 'link',
		        'namespace'     => $this->namespace,
		        'type'          => 'url',
		        'required'      => false,
		        'title_column'  => false,
		    ],
		    [
		        'name'          => 'Title',
		        'slug'          => 'title',
		        'namespace'     => $this->namespace,
		        'type'          => 'text',
		        'required'      => false,
		        'title_column'  => true,
		        'locked'		=> false,
		    ],
		    [
		        'name'          => 'Slug',
		        'slug'          => 'slug',
		        'namespace'     => $this->namespace,
		        'type'          => 'slug',
		        'required'      => true,
		        'title_column'  => false,
		        'locked'		=> false,
		        'extra'			=>['slug_field'=>'title'],
		    ],		    
		    [
		        'name'          => 'SubTitle',
		        'slug'          => 'subtitle',
		        'namespace'     => $this->namespace,
		        'type'          => 'text',
		        'required'      => false,
		        'title_column'  => false,
		    ],		    
		    [
		        'name'          => 'Description',
		        'slug'          => 'description',
		        'namespace'     => $this->namespace,
		        'type'          => 'textarea',
		        'required'      => false,
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