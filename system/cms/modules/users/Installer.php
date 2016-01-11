<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Users Module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Users
 */
class Installer_Users extends Component {

	public $info;
	
	public function __construct()
	{
		$this->ci = get_instance();
	}

	public function info()
	{
		return $this->info;
	}

	public function set_info($info)
	{
		$this->info = $info;
	}

	/**
	 * Installation logic
	 *
	 * This is handled by the installer only so that a default user can be created.
	 *
	 * @return boolean
	 */
	public function install()
	{
		//insrtall ua table
		$this->install_ua_table();

		// Load up the streams driver and convert the profiles table
		// into a stream.
		$this->load->driver('Streams');

		if ( ! $this->streams->utilities->convert_table_to_stream('users_profiles', 'users', null, 'lang:user_profile_fields_label', 'Profiles for users module', 'display_name', array('display_name')))
		{
			return false;
		}

		// Go ahead and convert our standard user fields:
		$columns = 
		[
			'first_name' => 
			[
				'field_name' => 'lang:user:first_name_label',
				'field_type' => 'text',
				'extra'		 => array('max_length' => 50),
				'assign'	 => array('required' => true),
				'locked'	 => true
			],
			'last_name' => 
			[
				'field_name' => 'lang:user:last_name_label',
				'field_type' => 'text',
				'extra'		 => array('max_length' => 50),
				'assign'	 => array('required' => true),
				'locked'	 => true
			],
			'bio' => 
			[
				'field_name' => 'lang:profile_bio',
				'field_type' => 'textarea'
			],
			'lang' => array(
				'field_name' => 'lang:user:lang',
				'field_type' => 'oxy_lang',
				'extra' => array('filter_theme' => 'yes')
			),
			'dob' => 
			[
				'field_name' => 'lang:profile_dob',
				'field_type' => 'datetime',
				'extra'		 => 
				[
					'use_time' 		=> 'no',
					'storage' 		=> 'unix',
					'input_type'	=> 'dropdown',
					'start_date'	=> '-100Y'
				]
			],
			'gender' => 
			[
				'field_name' => 'lang:profile_gender',
				'field_type' => 'choice',
				'extra'		 => 
				[
					'choice_type' => 'dropdown',
					'choice_data' => " : Not Telling\nm : Male\nf : Female"
				]
			],
			'phone' => 
			[
				'field_name' => 'lang:profile_phone',
				'field_type' => 'text',
				'extra'		 => array('max_length' => 20)
			],
			'address_line1' => 
			[
				'field_name' => 'lang:profile_address_line1',
				'field_type' => 'text'
			],
			'address_line2' => 
			[
				'field_name' => 'lang:profile_address_line2',
				'field_type' => 'text'
			],
			'website' => 
			[
				'field_name' => 'lang:profile_website',
				'field_type' => 'url'
			],
		];

		// Run through each column and add the field
		// metadata to it.
		foreach ($columns as $field_slug => $column)
		{
			// We only want fields that actually exist in the
			// DB. The user could have deleted some of them.
			if ($this->db->field_exists($field_slug, 'users_profiles'))
			{
				$extra = array();
				$assign = array();

				if (isset($column['extra']))
				{
					$extra = $column['extra'];
				}

				if (isset($column['assign']))
				{
					$assign = $column['assign'];
				}

				if (isset($column['locked']))
				{
					$extra = $column['locked'];
				}
				
				$this->streams->utilities->convert_column_to_field('users_profiles', 'users', $column['field_name'], $field_slug, $column['field_type'], $extra, $assign);

				unset($extra);
				unset($assign);
			}
		}

		//new users_admin_profiles table
		//no ui for this, each program can implement its own ui
		if(!$this->install_streams())
		{
			//ooops, something went wrong
			return false;
		}		

		// Install the settings
		$settings = 
		[
			[
				'slug' => 'auto_username',
				'title' => 'Auto Username',
				'description' => 'Create the username automatically, meaning users can skip making one on registration.',
				'type' => 'radio',
				'default' => true,
				'value' => '',
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'users',
				'order' => 964,
			],
			[
				'slug' => 'enable_profiles',
				'title' => 'Enable profiles',
				'description' => 'Allow users to add and edit profiles.',
				'type' => 'radio',
				'default' => true,
				'value' => '',
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'users',
				'order' => 963,
			],
			[
				'slug' => 'activation_email',
				'title' => 'Activation Email',
				'description' => 'Send out an e-mail with an activation link when a user signs up. Disable this so that admins must manually activate each account.',
				'type' => 'select',
				'default' => true,
				'value' => '',
				'options' => '0=activate_by_admin|1=activate_by_email|2=no_activation',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'users',
				'order' => 961,
			],
			[
				'slug' => 'registered_email',
				'title' => 'User Registered Email',
				'description' => 'Send a notification email to the contact e-mail when someone registers.',
				'type' => 'radio',
				'default' => true,
				'value' => '',
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'users',
				'order' => 962,
			],
			[
				'slug' => 'enable_registration',
				'title' => 'Enable user registration',
				'description' => 'Allow users to register in your site.',
				'type' => 'radio',
				'default' => true,
				'value' => '',
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'users',
				'order' => 961,
			],
			[
            	'slug' => 'profile_visibility',
                'title' => 'Profile Visibility',
                'description' => 'Specify who can view user profiles on the public site',
                'type' => 'select',
                'default' => 'public',
                'value' => '',
                'options' => 'public=profile_public|owner=profile_owner|hidden=profile_hidden|member=profile_member',
                'is_required' => 0,
                'is_gui' => 1,
                'module' => 'users',
                'order' => 960,
            ],
		];

		foreach ($settings as $setting)
		{
			if ( ! $this->db->insert('settings', $setting))
			{
				return false;
			}
		}

		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		//$this->streams->utilities->remove_namespace($this->namespace);
		return false;
	}

	private function install_ua_table()
	{
		//add the trigger table ref	
		$module_tables = 
		[
			'users_access_keys' => 
			[
				'id' 				=> ['type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE],
				'user_id' 			=> ['type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null'=>true,'default'=> null],
				'ref_id' 			=> ['type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null'=>true,'default'=> null],
	            'module' 			=> ['type' => 'VARCHAR', 'constraint' => '255'], 
			],	
		];		

		$tables_installed = $this->install_tables( $module_tables );


		// if the tables installed, now time to register this sub-module with
		if( $tables_installed  )
		{
			return true;			
		}

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

	private function install_streams()
	{
		$this->load->driver('Streams');
		$this->namespace = 'users';

        if( $stream_id  = $this->streams->streams->add_stream( 'User Admin Profiles',  'users_admin_profiles' , $this->namespace , '' ))
        {
			//install streams fields to user
			$fields = 
	        [
			    [
			        'name'          => 'User ID',
			        'slug'          => 'user_id',
			        'namespace'     => $this->namespace,
			        'type'          => 'integer',
			        'required'      => false,
			        'unique'        => true,			        
			        'title_column'  => false,
			        'assign'		=> 'users_admin_profiles',
			        'extra'         => ['default_value'=>1,'readonly'=>true],
			    ],	   			    
			];  

			$this->streams->fields->add_fields($fields);

			return true;
        }

        return false;      
	}
}