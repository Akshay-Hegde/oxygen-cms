<?php defined('BASEPATH') OR exit('No direct script access allowed');

define('OXYPATH', dirname(FCPATH).'/system/cms/');
define('ADDONPATH', dirname(FCPATH).'/sites/default/addons/');
define('SHARED_ADDONPATH', dirname(FCPATH).'/shared/');


// Include some constants that modules may be looking for
define('SITE_REF', 'default');

// All modules talk to the Module class, best get that!
include OXYPATH.'libraries/Module.php';

class Module_import
{

	private $ci;

	public function __construct()
	{
		$this->ci =& get_instance();

		// Getting our model and MY_Model class set up
		class_exists('CI_Model', false) OR load_class('Model', 'core');
		include(OXYPATH.'/core/MY_Model.php');

		//define site_ref

		// Now we can use stuff from our system/cms directory, hooray!
		// Any dupes are generic so we shouldn't run into any 
		// meaningful conflicts.
		$this->ci->load->add_package_path(OXYPATH);
		$this->ci->load->add_package_path(SHARED_ADDONPATH);

		$db['hostname'] = $this->ci->session->userdata('hostname');
		$db['username'] = $this->ci->session->userdata('username');
		$db['password'] = $this->ci->session->userdata('password');
		$db['database'] = $this->ci->session->userdata('database');
		$db['port'] 	= $this->ci->session->userdata('port');
		$db['dbdriver'] = "mysql";
		$db['dbprefix'] = 'default_';
		$db['pconnect'] = false;
		$db['db_debug'] = true;
		$db['cache_on'] = false;
		$db['cachedir'] = "";
		$db['char_set'] = "utf8";
		$db['dbcollat'] = "utf8_unicode_ci";

		$this->ci->load->database($db);
		$this->ci->load->helper('file');

		// create the site specific upload folder
		is_dir(dirname(FCPATH).'/sites/default') OR mkdir(dirname(FCPATH).'/sites/default', DIR_WRITE_MODE, true);

		// create folders
		$this->mkdirtool(ADDONPATH);
		$this->mkdirtool(SHARED_ADDONPATH);
		
	}

	private function mkdirtool($path)
	{
		// create the site specific addon folder
		is_dir($path.'modules') OR mkdir($path.'modules', DIR_READ_MODE, true);
		is_dir($path.'themes') OR mkdir($path.'themes', DIR_READ_MODE, true);
		is_dir($path.'widgets') OR mkdir($path.'widgets', DIR_READ_MODE, true);
		is_dir($path.'field_types') OR mkdir($path.'field_types', DIR_READ_MODE, true);
		is_dir($path.'plugins') OR mkdir($path.'plugins', DIR_READ_MODE, true);
		is_dir($path.'helpers') OR mkdir($path.'helpers', DIR_READ_MODE, true);

		write_file($path.'modules/index.html', '');
		write_file($path.'themes/index.html', '');
		write_file($path.'widgets/index.html', '');
		write_file($path.'field_types/index.html', '');
		write_file($path.'plugins/index.html', '');	
		write_file($path.'helpers/index.html', '');	
		write_file($path.'sites/default/index.html', '');
	}


	/**
	 * Installs a module
	 *
	 * @param string $slug The module slug
	 * @param bool   $is_core
	 *
	 * @return bool
	 */
	public function install($slug, $is_core = false)
	{
		$details_class = $this->_spawn_class($slug, $is_core);

		// Get some basic info
		$module = $details_class->info();

		// Now lets set some details ourselves
		$module['version'] = $details_class->version;
		$module['is_core'] = $is_core;
		$module['enabled'] = true;
		$module['installed'] = true;
		$module['slug'] = $slug;

		// set the site_ref and upload_path for third-party devs
		$details_class->site_ref = 'default';
		$details_class->upload_path = 'sites/default/';

		// Run the install method to get it into the database
		if (!$details_class->install())
		{
			return false;
		}

		// Looks like it installed ok, add a record
		return $this->add($module);
	}

	public function add($module)
	{
		return $this->ci->db->insert('modules', [
			'name' => serialize($module['name']),
			'slug' => $module['slug'],
			'requires_module' => ( ! empty($module['requires_module'])) ? $module['requires_module'] : false,
			'version' => $module['version'],
			'description' => serialize($module['description']),
			'clean_xss' => ! empty($module['clean_xss']),
			'is_frontend' => ! empty($module['frontend']),
			'is_backend' => ! empty($module['backend']),
			'menu' => ( ! empty($module['menu'])) ? $module['menu'] : false,
			'icon' => ( ! empty($module['icon'])) ? $module['icon'] : 'fa fa-edit',
			'enabled' => $module['enabled'],
			'installed' => $module['installed'],
			'is_core' => $module['is_core']
		]);
	}


	public function import_all()
	{
		//drop the old modules table
		$this->ci->load->dbforge();
		$this->ci->dbforge->drop_table('modules');

		$modules = "
			CREATE TABLE IF NOT EXISTS ".$this->ci->db->dbprefix('modules')." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` TEXT NOT NULL,
			  `slug` varchar(50) NOT NULL,
			  `requires_module` varchar(50) NULL,
			  `version` varchar(20) NOT NULL,
			  `type` varchar(20) DEFAULT NULL,
			  `description` TEXT DEFAULT NULL,
			  `clean_xss` tinyint(1) NOT NULL,
			  `is_frontend` tinyint(1) NOT NULL,
			  `is_backend` tinyint(1) NOT NULL,
			  `menu` varchar(20) NOT NULL,
			  `icon` varchar(20) DEFAULT 'fa fa-edit',
			  `enabled` tinyint(1) NOT NULL,
			  `installed` tinyint(1) NOT NULL,
			  `is_core` tinyint(1) NOT NULL,
			  `updated_on` int(11) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `slug` (`slug`),
			  INDEX `enabled` (`enabled`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

		//create the modules table so that we can import all modules including the modules module
		$this->ci->db->query($modules);

		$session = "
			CREATE TABLE IF NOT EXISTS ".$this->ci->db->dbprefix(str_replace('default_', '', config_item('sess_table_name')))." (
			 `session_id` varchar(40) DEFAULT '0' NOT NULL,
			 `ip_address` varchar(45) DEFAULT '0' NOT NULL,
			 `user_agent` varchar(120) NOT NULL,
			 `last_activity` int(10) unsigned DEFAULT 0 NOT NULL,
			 `user_data` text NULL,
			PRIMARY KEY (`session_id`),
			KEY `last_activity_idx` (`last_activity`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		";

		// create a session table so they can use it if they want
		$this->ci->db->query($session);

		// In case we are re-installing with existing data,
		// we'll need to make sure that these tables aren't here.
		$this->ci->dbforge->drop_table('data_streams');
		$this->ci->dbforge->drop_table('data_fields');
		$this->ci->dbforge->drop_table('data_field_assignments');

		// Install settings, streams core and email 
		// first. Other modules may need them.
		$this->install('settings', true);
		$this->ci->load->library('settings/settings');
		$this->install('streams', true);
		$this->install('maintenance', true);
		$this->install('email', true);


		// Are there any modules to install on this path?
		if ($modules = glob(OXYPATH.'modules/*', GLOB_ONLYDIR))
		{
			// Loop through modules
			foreach ($modules as $module_name)
			{
				$slug = basename($module_name);

				//skip the modules we installed earlier
				if ($slug == 'streams' or $slug == 'settings' or $slug == 'email' or $slug == 'maintenance')
				{
					continue;
				}

				// invalid details class?
				if ( ! $details_class = $this->_spawn_class($slug, true))
				{
					continue;
				}

				// 
				// skip modules that dont want 
				// to be installed from the get go
				//
				if(isset($details_class->auto_install)) {
					if($details_class->auto_install==false) {
						continue;
					}
				}

				$this->install($slug, true);
			}
		}

		// After modules are imported we need to modify the settings table
		// This allows regular admins to upload addons on the first install but not on multi
		$this->ci->db
			->where('slug', 'addons_upload')
			->update('settings', array('value' => '1'));

		return true;
	}

	/**
	 * Spawn Class
	 *
	 * Checks to see if a Details.php exists and returns a class
	 * It returns either Details.php or installer.php if it exist.
	 *
	 * @author Sal McDonald - Added goodness with installer.php check
	 * @param string $slug    The folder name of the module
	 * @param bool   $is_core
	 *
	 * @return    array
	 */
	private function _spawn_class($slug, $is_core = false)
	{
		$path = $is_core ? OXYPATH : ADDONPATH;

		// Before we can install anything we need to know some details about the module
		$details_file = $path.'modules/'.$slug.'/Details.php';
		

		// If it didn't exist as a core module or an addon then check addons_shared
		if ( ! is_file($details_file))
		{
			$details_file = SHARED_ADDONPATH.'modules/'.$slug.'/Details.php';
			$path = SHARED_ADDONPATH;

			// We dont have any Details.php file 
			// at all, this isnt a valid module
			if ( ! is_file($details_file))
			{
				return false;
			}
		}

		// now we know we have a details, which is required, 
		// but what about the optional installer?
		$installer_file = $path.'modules/'.$slug.'/Installer.php';


		//if there is no installer.php file, we expect the details to have all the info and definitions for us
		$details_class = $this->getClassObjectFromFile($details_file,'Module_',$slug);

		if (is_file($installer_file))
		{
			// Now we need to talk to it
			$details_class = $this->getClassObjectFromFile($details_file,'Module_',$slug);
			$installer_class = $this->getClassObjectFromFile($installer_file,'Installer_',$slug);

			//merge the installer with the details
			$installer_class->info = $details_class->info();
			$installer_class->version = $details_class->version;

			$installer_class->set_info($details_class->info());

			return $installer_class;
		}		

		return $details_class;

	}


	private function getClassObjectFromFile($filename,$prefix,$slug)
	{
		// Sweet, include the file
		include_once $filename;

		// Now call the details class
		$class = $prefix.ucfirst(strtolower($slug));

		// Now we need to talk to it
		return class_exists($class) ? new $class : false;
	}
}