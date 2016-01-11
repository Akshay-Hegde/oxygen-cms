<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Email extends Module {

    public $version = '1.0.0';

	public $installable_tables = 
	[
        'email_folders' 	 => 
        [
        	'id'             => ['type' => 'INT', 'constraint' => '11', 'unsigned' => true, 'auto_increment' => true, 'primary' => true],
            'name'       	 => ['type' => 'VARCHAR', 'constraint' => '255', 'null'=>true,'default'=>''],
            'type'  		 => ['type' => 'VARCHAR', 'constraint' => '10', 'default'=>''],        
        ], 	
        'email_headers' 	 => 
        [
        	'id'             => ['type' => 'INT', 'constraint' => '11', 'unsigned' => true, 'auto_increment' => true, 'primary' => true],
        	'uid'          	 => ['type' => 'INT', 'constraint' => '11', 'unsigned' => true,],
            'to'       	 	 => ['type' => 'VARCHAR', 'constraint' => '512', 'null'=>true,'default'=>''],
            'from'       	 => ['type' => 'VARCHAR', 'constraint' => '512', 'null'=>true,'default'=>''],  
            'date'  		 => ['type' => 'VARCHAR', 'constraint' => '255', 'default'=>''], 
            'udate'  		 => ['type' => 'INT', 'constraint' => '20', 'default'=>0], 
            'subject'     	 => ['type' => 'VARCHAR', 'constraint' => '255', 'null'=>true, 'default'=>''],  
            'seen'         	 => ['type' => 'INT', 'constraint' => '1', 'default'=>0],
            'answered'       => ['type' => 'INT', 'constraint' => '1', 'default'=>0],
            'fl_starred'   	 => ['type' => 'INT', 'constraint' => '1', 'default'=>0],
            'fl_important'   => ['type' => 'INT', 'constraint' => '1', 'default'=>0],
            'filename'     	 => ['type' => 'VARCHAR', 'constraint' => '512', 'default'=>''],
        	'folder_id'      => ['type' => 'INT', 'constraint' => '11', 'unsigned' => true, 'null'=>true, 'default'=>null], 
        	'category_id'    => ['type' => 'INT', 'constraint' => '11', 'unsigned' => true, 'null'=>true, 'default'=>null],                          
        ], 
        'email_sent_headers' => 
        [
        	'id'             => ['type' => 'INT', 'constraint' => '11', 'unsigned' => true, 'auto_increment' => true, 'primary' => true],
            'to'       	 	 => ['type' => 'VARCHAR', 'constraint' => '360', 'null'=>true,'default'=>''],
            'date'  		 => ['type' => 'VARCHAR', 'constraint' => '255', 'default'=>''], 
            'udate'  		 => ['type' => 'INT', 'constraint' => '20', 'default'=>0], 
            'subject'     	 => ['type' => 'VARCHAR', 'constraint' => '255', 'null'=>true, 'default'=>''],  
            'filename'     	 => ['type' => 'VARCHAR', 'constraint' => '512', 'default'=>''],
            'cust_id'        => ['type' => 'INT', 'constraint' => '11', 'unsigned' => true,],   //crm feature cust/user_id    
        	'folder_id'      => ['type' => 'INT', 'constraint' => '11', 'unsigned' => true, 'null'=>true, 'default'=>null], 
        	'category_id'    => ['type' => 'INT', 'constraint' => '11', 'unsigned' => true, 'null'=>true, 'default'=>null], 
            'fl_starred'   	 => ['type' => 'INT', 'constraint' => '1', 'default'=>0],
            'fl_important'   => ['type' => 'INT', 'constraint' => '1', 'default'=>0],        	                        
        ], 
        // blacklist table is used only for auto-send emails. Not manual sent eamils. 
        // It checks wheather the user wants to be blacklisted or admin has blacklisted email address
    	'email_blacklist'	 =>
		[ 
 			'id'    		 	=> [ 'type' 	=> 'INT', 'constraint' 		=> '11', 'unsigned' => TRUE, 'auto_increment' => TRUE, 'primary' => TRUE],
 			'email'  		 	=> [ 'type' 	=> 'VARCHAR', 'constraint' 	=> '512', 'null' => TRUE, 'default' => '' ],
 			'message'  		 	=> [ 'type' 	=> 'VARCHAR', 'constraint' 	=> '512', 'null' => TRUE, 'default' => '' ],
 			'created'  		 	=> [ 'type' 	=> 'DATETIME', 'null' 		=> true, 'default' => NULL],
		],
		'email_templates' 	=> 
		[
			'id' 				=> ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,],
			'slug' 				=> ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => 'slug_lang',],
			'master_template' 	=> ['type' => 'VARCHAR', 'constraint' => 155, 'default' => '',],
			'name' 				=> ['type' => 'VARCHAR', 'constraint' => 100,], // @todo rename this to 'title' to keep coherency with the rest of the module
			'description' 		=> ['type' => 'VARCHAR', 'constraint' => 255,], // @todo change this to TEXT to be coherent with the rest of the module,
			'subject' 			=> ['type' => 'VARCHAR', 'constraint' => 255,],
			'body' 				=> ['type' => 'TEXT'],
			'lang' 				=> ['type' => 'VARCHAR', 'constraint' => 2, 'null' => true, 'unique' => 'slug_lang',],
			'is_default' 		=> ['type' => 'INT', 'constraint' => 1, 'default' => 0,],
			'module' 			=> ['type' => 'VARCHAR', 'constraint' => 50, 'default' => '',],
		],

	];	


	public function info()
	{
		return 
		[
			'name' 		=> 
			[
				'en' 	=> 'Email'
			],
			'description' => 
			[
				'en' 	=> 'Email module (Basic). Allows sending of emails to users.'
			],
			'requires_module' => false,
			'frontend' 	=> false,
			'backend' 	=> true,
			'clean_xss' => true,			
			'menu' 		=> false, 
			'icon' 		=> 'fa fa-envelope-o',			
			'sections' 	=> 
			[
				'templates' =>
				[
					'name' => 'email:templates',
					'uri' => 'admin/email/templates/',				
					'shortcuts' => 
					[
						[
							'name' => 'email:create_template',
							'uri' => 'admin/email/templates/create',
						]
					],
			
				],
				'compose' =>
				[
					'name' => 'email:compose',
					'uri' => 'admin/email/compose/',				
					'shortcuts' => 
					[
						[
							'name' => 'email:compose',
							'uri' => 'admin/email/compose',
						]
					],
				],				
			],	
			'roles'		=>
			[
				'admin_send_receive','admin_templates'
			],
		];
	
	}

	public function admin_menu(&$menu)
	{

		$menu['lang:cp:nav_email']['icon'] = 'fa fa-envelope-o';

		if(group_has_role('email','admin_send_receive'))
		{	
			$menu['lang:cp:nav_email']['menu_items'][] =
			[
				'name' 			=> 'Compose',
				'uri' 			=> 'admin/email/compose',
				'icon' 			=> 'fa fa-envelope-o',
			];			
		}

		if(group_has_role('email','admin_templates'))
		{	
			$menu['lang:cp:nav_email']['menu_items'][] =
			[
				'name' 			=> 'Templates',
				'uri' 			=> 'admin/email/templates',
				'icon' 			=> 'fa fa-code',
			];	
		}

		add_admin_menu_place('lang:cp:nav_email', 5);
	
	}

	public function install()
	{
		//whats the site ref ?
		$curr_site_slug = defined(SITE_REF)?SITE_REF:'default';

		if($this->install_tables($this->installable_tables))
		{
			//need to create a download directory for mail
			//used to dump all mail for future caching, not db io.
			is_dir(SITE_STORAGE_PATH.$curr_site_slug.'/email') OR @mkdir(SITE_STORAGE_PATH.$curr_site_slug.'/email',0777,TRUE);

	        $settings = 
	        [
	            [
	                'slug' => 'mail_imap_recent_uid',
	                'title' => 'Most recent UID index for inbox',
	                'description' => 'The most recent uid index for mailbox inbox, used by email program to track current download status.',
	                'type' => 'text',
	                'default' => '0',
	                'value' => '0',
	                'options' => '',
	                'is_required' => 0,
	                'is_gui' => false,
	                'module' => 'imap',
	                'order' => 599,
	            ],
	            [
					'slug' => 'mail_imap_email',
					'title' => 'IMAP Email User ID',
					'description' => 'Generally this will be the email address for your imap account.',
					'type' => 'text',
					'default' => DEFAULT_EMAIL,
					'value' => '',
					'options' => '',
					'is_required' => 1,
					'is_gui' => 1,
					'module' => 'imap',
					'order' => 590,
				],
	            [
					'slug' => 'mail_imap_host',
					'title' => 'IMAP Host Name',
					'description' => 'The host name of your imap server. For Gmail it is <code>imap.gmail.com</code>',
					'type' => 'text',
					'default' => 'imap.yourdomain.com',
					'value' => 'imap.yourdomain.com',
					'options' => '',
					'is_required' => 0,
					'is_gui' => 1,
					'module' => 'imap',
					'order' => 580,
				],
	            [
					'slug' => 'mail_imap_port',	
					'title' => 'IMAP Port',
					'description' => 'IMAP port number. For Gmail it is generally <code>993</code>',
					'type' => 'text',
					'default' => '993',
					'value' => '',
					'options' => '',
					'is_required' => 0,
					'is_gui' => 1,
					'module' => 'imap',
					'order' => 570,
				],
	            [
					'slug' => 'mail_imap_flags',					
					'title' => 'IMAP Flags',
					'description' => 'IMAP flags. To recieve emails you may need to select the flag for your domain.',
					'type' => 'select',
					'default' => '/ssl/imap',
					'value' => '/ssl/imap',
					'options' => '/ssl=SSL|/ssl/imap=IMAP-SSL|/pop=POP3',
					'is_required' => 0,
					'is_gui' => 1,
					'module' => 'imap',
					'order' => 560,
				],		
				[
					'slug' => 'mail_imap_pass',					
					'title' => 'IMAP password',
					'description' => 'IMAP password.',
					'type' => 'password',
					'default' => '',
					'value' => '',
					'options' => '',
					'is_required' => 0,
					'is_gui' => 1,
					'module' => 'imap',
					'order' => 550,
				],	
	            [
					'slug' => 'mail_interval_minutes',					
					'title' => 'Server Interval Time',
					'description' => 'How often should we check for new mail ? (in minutes)',
					'type' => 'select',
					'default' => '30',
					'value' => '30',
					'options' => '5=5 minutes|15=15|30=30|45=45|60=1 Hour|120=2 Hours',
					'is_required' => 1,
					'is_gui' => 1,
					'module' => 'imap',
					'order' => 540,
				],					
	        ];
	        foreach ($settings as $setting) {
	            if (!$this->db->insert('settings', $setting)) {
	                return false;
	            }
	        }

	 		$data = 
	 		[
	 			'section'=>'row3',
	 			'name'=>'Recent Emails Dashboard Widget',
	 			'partial'=>'email/admin/dashboard/widget',
	 			'order'=> 1, 
	 			'is_visible'=> 1,
	 			'module'=>'email'
	 		];
	 		$this->db->insert('widgets_admin',$data);

	 		//Inbox folder
	 		$data = 
	 		[
	 			'name'=>'Inbox',
	 			'type'=>'core'
	 		];	 		
	 		$this->db->insert('email_folders',$data);

	 		return $this->install_templates();

		}

		return false;
	}

	public function install_templates()
	{

		// Insert the default email templates
		$this->db->insert('email_templates',
			[
				'slug' 				=> 'email_compose',
				'master_template' 	=> 'compose',
				'name' 				=> 'Compose Email',
				'description' 		=> 'A generic email template for sending emails via the Email module',
				'subject' 			=> '{{ subject }}',
				'body' 				=> "{{ body }}",
				'lang' 				=> 'en',
				'is_default' 		=> 1,
				'module' 			=> 'email'
			]
		);

		// @todo move this to the comments module
		$this->db->insert('email_templates',
			[
				'slug' 				=> 'comments',
				'master_template' 	=> 'default',				
				'name' 				=> 'Comment Notification',
				'description' 		=> 'Email that is sent to admin when someone creates a comment',
				'subject' 			=> 'You have just received a comment from {{ name }}',
				'body' 				=> "<h3>You have received a comment from {{ name }}</h3>
					<p>
					<strong>IP Address: {{ sender_ip }}</strong><br>
					<strong>Operating System: {{ sender_os }}<br>
					<strong>User Agent: {{ sender_agent }}</strong>
					</p>
					<p>{{ comment }}</p>
					<p>View Comment: {{ redirect_url }}</p>",
				'lang' 				=> 'en',
				'is_default' 		=> 1,
				'module' 			=> 'comments'
			]
		);

		// @todo move this to the contact module
		$this->db->insert('email_templates',array(
				'slug' 				=> 'contact',
				'master_template' 	=> 'default',				
				'name' 				=> 'Contact Notification',
				'description' 		=> 'Template for the contact form',
				'subject' 			=> '{{ settings:site_name }} :: {{ subject }}',
				'body' 				=> 'This message was sent via the contact form on with the following details:
				<hr>
				IP Address: {{ sender_ip }}
				OS {{ sender_os }}
				Agent {{ sender_agent }}
				<hr>
				{{ message }}

				{{ name }},
				
				{{ email }}',
				'lang' 				=> 'en',
				'is_default' 		=> 1,
				'module' 			=> 'pages'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
			'slug' => 'registered',
				'master_template' 	=> 'default',				
			'name' => 'New User Registered',
			'description' => 'Email sent to the site contact e-mail when a new user registers',
			'subject' => '{{ settings:site_name }} :: You have just received a registration from {{ name }}',
			'body' => '<h3>You have received a registration from {{ name }}</h3>
				<p><strong>IP Address: {{ sender_ip }}</strong><br>
				<strong>Operating System: {{ sender_os }}</strong><br>
				<strong>User Agent: {{ sender_agent }}</strong>
				</p>',
			'lang' => 'en',
			'is_default' => 1,
			'module' => 'users'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
			'slug' => 'activation',
				'master_template' 	=> 'default',				
			'name' => 'Activation Email',
			'description' => 'The email which contains the activation code that is sent to a new user',
			'subject' => '{{ settings:site_name }} - Account Activation',
			'body' => '<p>Hello {{ user:first_name }},</p>
				<p>Thank you for registering at {{ settings:site_name }}. Before we can activate your account, please complete the registration process by clicking on the following link:</p>
				<p><a href="{{ url:site }}users/activate/{{ user:id }}/{{ activation_code }}">{{ url:site }}users/activate/{{ user:id }}/{{ activation_code }}</a></p>
				<p>&nbsp;</p>
				<p>In case your email program does not recognize the above link as, please direct your browser to the following URL and enter the activation code:</p>
				<p><a href="{{ url:site }}users/activate">{{ url:site }}users/activate</a></p>
				<p><strong>Activation Code:</strong> {{ activation_code }}</p>',
			'lang' => 'en',
			'is_default' => 1,
			'module' => 'users'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
				'slug' 				=> 'forgotten_password',
				'master_template' 	=> 'default',				
				'name' 				=> 'Forgotten Password Email',
				'description' 		=> 'The email that is sent containing a password reset code',
				'subject' 			=> '{{ settings:site_name }} - Forgotten Password',
				'body' 				=> '<p>Hello {{ user:first_name }},</p>
					<p>It seems you have requested a password reset. Please click this link to complete the reset: <a href="{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}">{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}</a></p>
					<p>If you did not request a password reset please disregard this message. No further action is necessary.</p>',
				'lang' 				=> 'en',
				'is_default' 		=> 1,
				'module' 			=> 'users'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
				'slug' 				=> 'new_password',
				'master_template' 	=> 'default',				
				'name' 				=> 'New Password Email',
				'description' 		=> 'After a password is reset this email is sent containing the new password',
				'subject' 			=> '{{ settings:site_name }} - New Password',
				'body' 				=> '<p>Hello {{ user:first_name }},</p>
					<p>Your new password is: {{ new_password }}</p>
					<p>After logging in you may change your password by visiting <a href="{{ url:site }}edit-profile">{{ url:site }}edit-profile</a></p>',
				'lang' 				=> 'en',
				'is_default' 		=> 1,
				'module' 			=> 'users'
		));

		$tem_body = "<html><head></head><style></style><body>{{body}}</body></html>";

		return true;
	}
	
	public function uninstall()
	{
		foreach($this->installable_tables as $table_name=>$table) {
			$this->dbforge->drop_table($table_name);
		}		
		return true;
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
	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br>Contact the module developer for assistance.";
	}
}
/* End of file Details.php */
