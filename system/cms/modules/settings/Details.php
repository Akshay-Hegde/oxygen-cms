<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Settings module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Settings
 */
class Module_Settings extends Module
{

	public $version = '1.0.7';

	public function info()
	{
		return 
		[
			'name' => 
			[
				'en' => 'Settings',
			],
			'description' => 
			[
				'en' => 'Allows administrators to update settings like Site Name, messages and email address, etc.',
			],
			'frontend' => false,
			'backend' => true,
			'menu' => false,
			'icon' =>'fa fa-gears',
			'clean_xss' => true,
			'menu' => false, 
			'roles'	=> 
			[
				'access_settings',
			],
		];
	}

	public function admin_menu(&$menu)
	{
		if(group_has_role('settings','access_settings'))
		{
			$menu['lang:cp:nav_system']['menu_items'][] = 
				[
					'name' 			=> 'lang:cp:nav_settings',
					'uri' 			=> 'admin/settings',
					'icon' 			=> 'fa fa-gears',
					'permission' 	=> '',
					'menu_items'	=> [],
				];
		}
	}

	public function install()
	{
		$this->dbforge->drop_table('settings');

		log_message('debug', '-- Settings: Installing tables.');
		$tables_to_install = 
		[
			'settings' 			=> 
			[
				'slug' 			=> array('type' => 'VARCHAR', 'constraint' => 50, 'primary' => true, 'unique' => true, 'key' => 'index_slug'),
				'title' 		=> array('type' => 'VARCHAR', 'constraint' => 100,),
				'description' 	=> array('type' => 'TEXT',),
				'type' 			=> array('type' => 'set', 'constraint' => array('text', 'textarea', 'password', 'select', 'select-multiple', 'radio', 'checkbox'),),
				'default' 		=> array('type' => 'TEXT',),
				'value' 		=> array('type' => 'TEXT',),
				'options' 		=> array('type' => 'TEXT'),
				'is_required' 	=> array('type' => 'INT', 'constraint' => 1,),
				'is_gui' 		=> array('type' => 'INT', 'constraint' => 1,),
				'module' 		=> array('type' => 'VARCHAR', 'constraint' => 50,),
				'order' 		=> array('type' => 'INT', 'constraint' => 10, 'default' => 0,),
			],
            'widgets_admin' 	 => 
            [
                'id'             => ['type' => 'INT', 'constraint' => '11', 'unsigned' => true, 'auto_increment' => true, 'primary' => true],
                'name'       	 => ['type' => 'VARCHAR', 'constraint' => '255', 'default'=>''],  
                'section'        => ['type' => 'VARCHAR', 'constraint' => '100', 'default'=>'row1'], /* row1,row2,row3 */
                'partial'        => ['type' => 'VARCHAR', 'constraint' => '255', 'default'=>'partials/widgets/graph1'], /* Path to the partial*/
                'order'          => ['type' => 'INT', 'constraint' => '5', 'default'=>0],
                'is_visible'     => ['type' => 'INT', 'constraint' => '4', 'default'=>1], //order
                'module'         => ['type' => 'VARCHAR', 'constraint' => '100', 'default'=>'row1'], /* store, core, users ect */
            ],  
 			'timeline' 			 =>  
			[ 
				'id' 			 => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,],
				'name' 			 => ['type' => 'varchar', 'constraint' => 250, 'default'=>'Event'],
				'user_id' 		 => ['type' => 'int', 'constraint' => 11, 'null' => true, 'default'=>0],
				'color' 		 => ['type' => 'varchar', 'constraint' => 20, 'default'=>'blue'],
				'icon' 			 => ['type' => 'varchar', 'constraint' => 250, 'default'=>'fa fa-plus',],
				'module' 		 => ['type' => 'varchar', 'constraint' => 250, 'default'=>'timeline',],
				'tl_timestamp' 	 => ['type' => 'int','constraint' => 11,'default' => 0],
				'tl_datetime'	 => ['type' => 'DATETIME', 'null' => true, 'default' => NULL],
				'tl_day' 		 => ['type' => 'varchar', 'constraint' => 20, 'default'=>'',],
				'tl_date' 		 => ['type' => 'varchar', 'constraint' => 20, 'default'=>'',],
				'tl_time' 		 => ['type' => 'varchar', 'constraint' => 20, 'default'=>'',],
				'description' 	 => ['type' => 'TEXT', 'null' => true],			
				'actions' 		 => ['type' => 'TEXT', 'null' => true],
				'admin_access'	 => ['type' => 'int','constraint' => 1, 'default' => 1],
				'front_access'	 => ['type' => 'int','constraint' => 1, 'default' => 0],
				'deleted'		 => ['type' => 'DATETIME', 'null' => true, 'default' => NULL],
			],
            'routes'         	 => 
            [
                'id'             => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,],
                'name'           => ['type' => 'varchar', 'constraint' => 250, 'null'=>'true', 'default'=>''],
                'module'         => ['type' => 'varchar', 'constraint' => 250, 'null'=>'true', 'default'=>''],
                'uri'            => ['type' => 'varchar', 'constraint' => 250, 'null'=>'true', 'default'=>''],
                'default_uri'    => ['type' => 'varchar', 'constraint' => 512, 'null'=>'true', 'default'=>''],
                'dest'           => ['type' => 'varchar', 'constraint' => 512, 'null'=>'true', 'default'=>''],
                'is_core'        => ['type' => 'int','constraint' => 1,'default' => 0],
                'can_change'     => ['type' => 'int','constraint' => 1,'default' => 0],
                'ordering_count' => ['type' => 'int','constraint' => 5, 'null'=>'true', 'default'=>0],
                'created'        => ['type' => 'DATETIME', 'null' => true, 'default' => NULL],
                'updated'        => ['type' => 'DATETIME', 'null' => true, 'default' => NULL], 
                'active'     	 => ['type' => 'varchar', 'constraint' =>20, 'null'=>'true', 'default'=>'active'],      
            ],
        ];


        $tables_installed = $this->install_tables( $tables_to_install );

        if( ! $tables_installed  )
        {
        	return false;
        }

		// Regarding ordering: any additions to this table can have an order 
		// value the same as a sibling in the same section. For example if you 
		// add to the Email tab give it a value in the range of 983 to 975.
		// Third-party modules should use lower numbers or 0.
		$settings = 
		[
			'site_name' => 
			[
				'title' => 'Site Name',
				'description' => 'The name of the website for page titles and for use around the site.',
				'type' => 'text',
				'default' => 'Un-named Website',
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 999,
			],
			'site_slogan' => 
			[
				'title' => 'Site Slogan',
				'description' => 'The slogan of the website for page titles and for use around the site',
				'type' => 'text',
				'default' => '',
				'value' => 'Add your slogan here',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => '',
				'order' => 995,
			],
			'meta_topic' => array(
				'title' => 'Meta Topic',
				'description' => 'Two or three words describing this type of company/website.',
				'type' => 'text',
				'default' => 'Content Management',
				'value' => 'Add your slogan here',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => '',
				'order' => 990,
			),
			'site_lang' => array(
				'title' => 'Site Language',
				'description' => 'The native language of the website, used to choose templates of e-mail notifications, contact form, and other features that should not depend on the language of a user.',
				'type' => 'select',
				'default' => DEFAULT_LANG,
				'value' => DEFAULT_LANG,
				'options' => 'func:get_supported_lang',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 985,
			),
			'site_public_lang' => array(
				'title' => 'Public Languages',
				'description' => 'Which are the languages really supported and offered on the front-end of your website?',
				'type' => 'checkbox',
				'default' => DEFAULT_LANG,
				'value' => DEFAULT_LANG,
				'options' => 'func:get_supported_lang',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 980,
			),
			'date_format' => array(
				'title' => 'Date Format',
				'description' => 'How should dates be displayed across the website and control panel? Using the <a target="_blank" href="http://php.net/manual/en/function.date.php">date format</a> from PHP - OR - Using the format of <a target="_blank" href="http://php.net/manual/en/function.strftime.php">strings formatted as date</a> from PHP.',
				'type' => 'select',
				'default' => 'F j, Y',
				'value' => 'F j, Y',
				'options' => 'F j, Y=March 10, 2001|m.d.y=03.10.01|Ymd=20010310|j, n, Y=10, 3, 2001|D M j G:i:s T Y=Sat Mar 10 17:16:18 MST 2001',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '', 
				'order' => 975,
			),
			'currency' => 
			[
				'title' => 'Currency',
				'description' => 'The currency symbol for use on products, services, etc.',
				'type' => 'text',
				'default' => '$',
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 970,
			],
			'records_per_page' => 
			[
				'title' => 'Records Per Page',
				'description' => 'How many records should we show per page in the admin section?',
				'type' => 'select',
				'default' => '25',
				'value' => '',
				'options' => '10=10|25=25|50=50|100=100',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 965,
			],
			'rss_feed_items' => array(
				'title' => 'Feed item count',
				'description' => 'How many items should we show in RSS/blog feeds?',
				'type' => 'select',
				'default' => '25',
				'value' => '',
				'options' => '10=10|25=25|50=50|100=100',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 960,
			),
			'dashboard_rss' => array(
				'title' => 'Dashboard RSS Feed',
				'description' => 'Link to an RSS feed that will be displayed on the dashboard.',
				'type' => 'text',
				'default' => 'http://oxygen-cms.com/blog/rss/all.rss',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => '',
				'order' => 955,
			),
			'dashboard_rss_count' => array(
				'title' => 'Dashboard RSS Items',
				'description' => 'How many RSS items would you like to display on the dashboard?',
				'type' => 'text',
				'default' => '5',
				'value' => '5',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 950,
			),
			'frontend_enabled' => array(
				'title' => 'Site Status',
				'description' => 'Use this option to the user-facing part of the site on or off. Useful when you want to take the site down for maintenance.',
				'type' => 'radio',
				'default' => true,
				'value' => '',
				'options' => '1=Open|0=Closed',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'security',
				'order' => 850,
			),
			'unavailable_message' => array(
				'title' => 'Unavailable Message',
				'description' => 'When the site is turned off or there is a major problem, this message will show to users.',
				'type' => 'textarea',
				'default' => 'Sorry, this website is currently unavailable.',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'security',
				'order' => 840,
			),
			'admin_force_https' => array(
				'title' => 'Force HTTPS for Control Panel?',
				'description' => 'Allow only the HTTPS protocol when using the Control Panel?',
				'type' => 'radio',
				'default' => false,
				'value' => '',
				'options' => '1=Yes|0=No',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'security',
				'order' => 830,
			),	
			'ga_email' => 
			[
				'title' => 'Google Analytics User E-mail',
				'description' => 'The email address with valid access to Google Service API\'s. This may not be the default email you use to sign into GA. Check your <a target="blank" href="https://console.developers.google.com">Google Developer console</a> for Authentication settings',
				'type' => 'text',
				'default' => DEFAULT_EMAIL,
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 799,
			],			
			'ga_tracking_id' => 
			[
				'title' => 'Google Tracking ID',
				'description' => 'Enter your Google Analytic Tracking ID to activate Google Analytics view data capturing. E.g: UA-19483569-6',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 799,
			],

			//ga_profile
			'ga_view_id' => 
			[
				'title' => 'Google Analytic View-ID',
				'description' => 'The View-ID for Google Analytics property, previously named Profile-ID',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 785,
			],									

			'ga_p12_key' => 
			[
				'title' => 'Google P12 Key file',
				'description' => 'The name of the ***.p12 key file of the GA `Service account` used for Google Analytics. This file must be stored in the &lt;code&gt;sites/&lt;site-ref&gt;/keys/&lt;/code&gt; folder.',
				'type' => 'text',
				'default' => 'mysecret.p12',
				'value' => 'mysecret.p12',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 799,
			],
			'ga_json_key' => 
			[
				'title' => 'Google JSON Key file',
				'description' => 'The name of the ***.json key file of the service account used for Google Analytics.',
				'type' => 'text',
				'default' => 'mysecret.json',
				'value' => 'mysecret.json',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 799,
			],			
			'cdn_domain' => array(
				'title' => 'CDN Domain',
				'description' => 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => false,
				'is_gui' => true,
				'module' => 'integration',
				'order' => 760,
			),			
			'contact_email' => array(
				'title' => 'Contact E-mail',
				'description' => 'All e-mails from users, guests and the site will go to this e-mail address.',
				'type' => 'text',
				'default' => DEFAULT_EMAIL,
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 699,
			),
			'server_email' => array(
				'title' => 'Server E-mail',
				'description' => 'All e-mails to users will come from this e-mail address.',
				'type' => 'text',
				'default' => DEFAULT_EMAIL,
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 690,
			),
			'mail_protocol' => array(
				'title' => 'Mail Protocol',
				'description' => 'Select desired email protocol.',
				'type' => 'select',
				'default' => 'smtp',
				'value' => 'smtp',
				'options' => 'mail=Mail|sendmail=Sendmail|smtp=SMTP',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 680,
			),
			'mail_smtp_host' => array(
				'title' => 'SMTP Host Name', 
				'description' => 'The host name of your smtp server. For Gmail try <code>ssl://smtp.gmail.com</code>',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 670,
			),
			'mail_smtp_pass' => array(
				'title' => 'SMTP password',
				'description' => 'SMTP password.',
				'type' => 'password',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 660,
			),
			'mail_smtp_port' => array(
				'title' => 'SMTP Port',
				'description' => 'SMTP port number. Leave blank for Google SMTP option (i.e for Gmail SSL try 465).',
				'type' => 'text',
				'default' => '',
				'value' => '465',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 650,
			),			
			'mail_smtp_user' => array(
				'title' => 'SMTP User Name',
				'description' => 'SMTP user name.',
				'type' => 'text',
				'default' => DEFAULT_EMAIL,
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 640,
			),
			'mail_sendmail_path' => array(
				'title' => 'Sendmail Path',
				'description' => 'Path to server sendmail binary.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 630,
			),
			'mail_line_endings' => array(
				'title' => 'Email Line Endings',
				'description' => 'Change from the standard <code>\r\n</code> line ending to <code>PHP_EOL</code> for some email servers.',
				'type' => 'select',
				'`default`' => 1,
				'value' => '1',
				'`options`' => '0=PHP_EOL|1=\r\n',
				'is_required' => false,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 620,
			),
			'search_enabled' => 
			[
				'title' 		=> 'Enable Search subsystem',
				'description' 	=> 'Enable search for both public and admin access',
				'type' 			=> 'select',
				'`default`' 	=> '1',
				'value' 		=> '1',
				'`options`' 	=> '0=Disabled|1=Enabled',
				'is_required' 	=> false,
				'is_gui' 		=> true,
				'module' 		=> 'api',
				'order' 		=> 0,
			],			
			// @todo It should be possibile to move this into the users module. (but would it make sense?)
			'api_enabled' => array(
				'title' => 'API Enabled',
				'description' => 'Allow API access to all modules which have an API controller.',
				'type' => 'select',
				'`default`' => false,
				'value' => '0',
				'`options`' => '0=Disabled|1=Enabled',
				'is_required' => false,
				'is_gui' => false,
				'module' => 'api',
				'order' => 0,
			),
			// @todo It should be possibile to move this into the users module. (but would it make sense?)
			'api_user_keys' => array(
				'title' => 'API User Keys',
				'description' => 'Allow users to sign up for API keys (if the API is Enabled).',
				'type' => 'select',
				'`default`' => false,
				'value' => '0',
				'`options`' => '0=Disabled|1=Enabled',
				'is_required' => false,
				'is_gui' => false,
				'module' => 'api',
				'order' => 0,
			),
		];

		// Lets add the settings for this module.
		foreach ($settings as $slug => $setting_info)
		{
			log_message('debug', '-- Settings: installing '.$slug);
			$setting_info['slug'] = $slug;
			if ( ! $this->db->insert('settings', $setting_info))
			{
				log_message('debug', '-- -- could not install '.$slug);

				return false;
			}
		}


 		$data = 
 		[
 			'section'=>'row2',
 			'name'=>'Google Analytics',
 			'partial'=>'settings/admin/dashboard/google_analytics',
 			'order'=> 1, 
 			'is_visible'=> 1,
 			'module'=>'settings'
 		];
 		$this->db->insert('widgets_admin',$data);	

 		$data = 
 		[
 			'section'=>'row2',
 			'name'=>'Google Analytics JS',
 			'partial'=>'settings/admin/dashboard/google_analytics_js',
 			'order'=> 1, 
 			'is_visible'=> 1,
 			'module'=>'settings'
 		];
 		$this->db->insert('widgets_admin',$data);	

		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;	
	}

	public function upgrade($old_version)
	{

 		$data = 
 		[
 			'section'=>'row2',
 			'name'=>'Google Analytics',
 			'partial'=>'settings/admin/dashboard/google_analytics',
 			'order'=> 1, 
 			'is_visible'=> 1,
 			'module'=>'settings'
 		];
 		$this->db->insert('widgets_admin',$data);	

 		$data = 
 		[
 			'section'=>'row2',
 			'name'=>'Google Analytics JS',
 			'partial'=>'settings/admin/dashboard/google_analytics_js',
 			'order'=> 1, 
 			'is_visible'=> 1,
 			'module'=>'settings'
 		];
 		$this->db->insert('widgets_admin',$data);	
	
		$settings = 
		[				

			//ga_profile
			'ga_view_id' => 
			[
				'title' => 'Google Analytic View-ID',
				'description' => 'The View-ID for Google Analytics property, previously named Profile-ID',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 785,
			],									

			'ga_p12_key' => 
			[
				'title' => 'Google P12 Key file',
				'description' => 'The name of the ***.p12 key file of the GA `Service account` used for Google Analytics. This file must be stored in the <code>uploads/<site-ref>/keys/</code> folder.',
				'type' => 'text',
				'default' => 'mysecret.p12',
				'value' => 'mysecret.p12',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 799,
			],
			'ga_json_key' => 
			[
				'title' => 'Google JSON Key file',
				'description' => 'The name of the ***.json key file of the service account used for Google Analytics.',
				'type' => 'text',
				'default' => 'mysecret.json',
				'value' => 'mysecret.json',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 799,
			],	
		];

		// Lets add the settings for this module.
		foreach ($settings as $slug => $setting_info)
		{
			log_message('debug', '-- Settings: installing '.$slug);
			$setting_info['slug'] = $slug;
			if ( ! $this->db->insert('settings', $setting_info))
			{
				log_message('debug', '-- -- could not install '.$slug);

				return false;
			}
		}

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
