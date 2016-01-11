<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Modules model
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Modules\Models
 */
class Module_m extends MY_Model
{
	protected $_table = 'modules';

	/**
	 * Caches modules that exist
	 */
	private $_module_exists = [];
	
	/**
	 * Caches modules that are enabled
	 */
	private $_module_enabled = [];
	
	/**
	 * Caches modules that are installed
	 */
	private $_module_installed = [];

	/**
	 * Get
	 *
	 * Return an array containing module data
	 *
	 * @param	string	$slug		The name of the module to load
	 * @return	array
	 */
	public function get($slug = '')
	{
		// Have to return an associative array of null values for backwards compatibility.
		$null_array = 
		[
			'name' => null,
			'slug' => null,
			'requires_module' => null,
			'version' => null,
			'description' => null,
			'clean_xss' => null,
			'is_frontend' => null,
			'is_backend' => null,
			'menu' => false,
			'icon' => 'fa fa-edit',
			'enabled' => 1,
			'sections' => [],
			'shortcuts' => [],
			'is_core' => null,
			'is_current' => null,
			'current_version' => null,
			'updated_on' => null
		];

		if (is_array($slug) || empty($slug))
		{
			return $null_array;
		}

		$row = $this->db
			->where('slug', $slug)
			->get($this->_table)
			->row();
		
		if ($row)
		{

            // store these
            $this->_module_exists[$slug] = count($row) > 0;
            $this->_module_enabled[$slug] = $row->enabled;
            $this->_module_installed[$slug] = $row->installed;

			// Let's get REAL
			if ( ! $module = $this->_spawn_class($slug, $row->is_core))
			{
				return false;
			}

			list($class, $location) = $module;
			$info = $class->info();

			// Return false if the module is disabled
			if ($row->enabled == 0)
			{
				return false;
			}

			$name = ! isset($info['name'][CURRENT_LANGUAGE]) ? $info['name']['en'] : $info['name'][CURRENT_LANGUAGE];
			$description = ! isset($info['description'][CURRENT_LANGUAGE]) ? $info['description']['en'] : $info['description'][CURRENT_LANGUAGE];

			return 
			[
				'name' => $name,
				'slug' => $row->slug,
				'requires_module' =>  $row->requires_module,
				'version' => $row->version,
				'description' => $description,
				'clean_xss' => $row->clean_xss,
				'is_frontend' => $row->is_frontend,
				'is_backend' => $row->is_backend,
				'menu' => $row->menu,
				'icon' => ! empty($info['icon']) ? $info['icon'] : 'fa fa-edit',
				'enabled' => $row->enabled,
				'sections' => ! empty($info['sections']) ? $info['sections'] : [] ,
				'shortcuts' => ! empty($info['shortcuts']) ? $info['shortcuts'] : [] ,
				'is_core' => $row->is_core,
				'is_current' => version_compare($row->version, $this->version($row->slug),  '>='),
				'current_version' => $this->version($row->slug),
				'path' => $location,
				'updated_on' => $row->updated_on
			];
		} 
		else 
		{
            // store these, all are false, since we couldn't find a module entry
            $this->_module_exists[$slug] = false;
            $this->_module_enabled[$slug] = false;
            $this->_module_installed[$slug] = false;
        }
		return $null_array;
	}

	/**
	 * Get Modules
	 *
	 * Return an array of objects containing module related data
	 *
	 * @param   array   $params             The array containing the modules to load
	 * @param   bool    $return_disabled    Whether to return disabled modules
	 * @return  array
	 */
	public function get_all($params = [], $return_disabled = false)
	{
		$modules = [];

		// We have some parameters for the list of modules we want
		if ($params)
		{
			foreach ($params as $field => $value)
			{
				if (in_array($field, array('is_frontend', 'is_backend', 'menu', 'is_core')))
				{
					$this->db->where($field, $value);
				}
			}
		}

		// Skip the disabled modules
		if ($return_disabled === false)
		{
			$this->db->where('enabled', 1);
		}

		$result = $this->db->get($this->_table)->result();

		foreach ($result as $row)
		{
			// Let's get REAL
			if ( ! $module = $this->_spawn_class($row->slug, $row->is_core))
			{
				// If module is not able to spawn a class,
				// just forget about it and move on, man.
				continue;
			}

			list($class, $location) = $module;
			$info = $class->info();

			$name = ! isset($info['name'][CURRENT_LANGUAGE]) ? $info['name']['en'] : $info['name'][CURRENT_LANGUAGE];
			$description = ! isset($info['description'][CURRENT_LANGUAGE]) ? $info['description']['en'] : $info['description'][CURRENT_LANGUAGE];

			$module = 
			[
				'name'            => $name,
				'module'          => $class,
				'slug'            => $row->slug,
				'requires_module'  => $row->requires_module,
				'version'         => $row->version,
				'description'     => $description,
				'clean_xss'        => $row->clean_xss,
				'is_frontend'     => $row->is_frontend,
				'is_backend'      => $row->is_backend,
				'menu'            => $row->menu,
				'icon'        	  => ! empty($info['icon']) ? $info['icon'] : 'fa fa-edit',
				'enabled'         => $row->enabled,
				'sections'        => ! empty($info['sections']) ? $info['sections'] : [],
				'shortcuts'       => ! empty($info['shortcuts']) ? $info['shortcuts'] : [],
				'installed'       => $row->installed,
				'is_core'         => $row->is_core,
				'is_current'      => version_compare($row->version, $this->version($row->slug),  '>='),
				'current_version' => $this->version($row->slug),
				'path'            => $location,
				'updated_on'      => $row->updated_on
			];
			
			// store these
			$this->_module_exists[$row->slug] = true;
			$this->_module_enabled[$row->slug] = $row->enabled;
			$this->_module_installed[$row->slug] = $row->installed;
			
			if ( ! empty($params['is_backend']))
			{	
				if ( $this->current_user->group !== 'admin' and empty($this->permissions[$row->slug]) )
				{
					continue;
				}
			}

			//all good skipper
			$modules[$module['name']] = $module;
		}
		ksort($modules);
		return array_values($modules);
	}

	/**
	 * Add
	 *
	 * Adds a module to the database
	 *
	 * @access	public
	 * @param	array	$module		Information about the module
	 * @return	object
	 */
	public function add($module)
	{
		return $this->db->replace($this->_table, 
			[
				'name'        		=> serialize($module['name']),
				'slug'        		=> $module['slug'],
				'requires_module'   =>  ! empty($module['requires_module']) ? $module['requires_module'] : false,
				'version'     		=> $module['version'],
				'description' 		=> serialize($module['description']),
				'clean_xss'    		=> ! empty($module['clean_xss']),
				'is_frontend' 		=> ! empty($module['frontend']),
				'is_backend'  		=> ! empty($module['backend']),
				'menu'        		=> ! empty($module['menu']) ? $module['menu'] : false,
				'icon'        		=> ! empty($module['icon']) ? $module['icon'] : 'fa fa-edit',
				'enabled'    		=> ! empty($module['enabled']),
				'installed'   		=> ! empty($module['installed']),
				'is_core'     		=> ! empty($module['is_core']),
				'updated_on'  		=> now()
			]
		);
	}

	/**
	 * Update
	 *
	 * Updates a module in the database
	 *
	 * @access  public
	 * @param   array   $slug   Module slug to update
	 * @param   array   $module Information about the module
	 * @return  object
	 */
	public function update($slug, $module, $skip_validation = false)
	{
		$module['updated_on'] = time();

		return $this->db->where('slug', $slug)->update($this->_table, $module);
	}

	/**
	 * Delete
	 *
	 * Delete a module from the database
	 *
	 * @param	array	$slug	The module slug
	 * @access	public
	 * @return	object
	 */
	public function delete($slug)
	{
		return $this->db->delete($this->_table, array('slug' => $slug));
	}

	/**
	 * Exists
	 *
	 * Checks if a module exists
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function exists($slug)
	{
		if ( ! $slug)
		{
			return false;
		}

		// We already know about this module
		if (isset($this->_module_exists[$slug]))
		{
			return $this->_module_exists[$slug];
		}

		return $this->_module_exists[$slug] = $this->db
			->where('slug', $slug)
			->count_all_results($this->_table) > 0;
	}
	
	/**
	 * Enabled
	 *
	 * Checks if a module is enabled
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function enabled($slug)
	{
		if ( ! $slug)
		{
			return false;
		}

		// We already know about this module
		if (isset($this->_module_enabled[$slug]))
		{
			return $this->_module_enabled[$slug];
		}

		return $this->_module_enabled[$slug] = $this->db
			->where('slug', $slug)
			->where('enabled', 1)
			->count_all_results($this->_table) > 0;
	}
	
	
	/**
	 * Installed
	 *
	 * Checks if a module is installed
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function installed($slug)
	{
		if ( ! $slug)
		{
			return false;
		}

		// We already know about this module
		if (isset($this->_module_installed[$slug]))
		{
			return $this->_module_installed[$slug];
		}

		return $this->_module_installed[$slug] = $this->db
			->where('slug', $slug)
			->where('installed', 1)
			->count_all_results($this->_table) > 0;
	}

	/**
	 * Enable
	 *
	 * Enables a module
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function enable($slug)
	{
		$en_status = false;

		if ($this->exists($slug))
		{
			// cant enable a module that doesnt exist
			if ( ! ($module = $this->_spawn_class($slug, true,true) or $module = $this->_spawn_class($slug, false,true)))
			{
				return false;
			}

			list($module) = $module;
			
			//smoke and mirrors
			if (isset($module->installer))
			{
				//call enable on installer			
				$en_status = $module->installer->enable();
			}
			else
			{
				//call enable on installer			
				$en_status = $module->enable();
			}

			if($en_status)
			{
				$this->db->where('slug', $slug)->update($this->_table, array('enabled' => 1));
				$this->_module_enabled[$slug] = true;
				//$this->module_widget_task($slug, 'enable');
			}
		}

		return $en_status;
	}
	
	
	/**
	 * Disable
	 *
	 * Disables a module
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function disable($slug)
	{
		if ($this->exists($slug))
		{
			// cant disable a module that doesnt exist
			if ( ! ($module = $this->_spawn_class($slug, true,true) or $module = $this->_spawn_class($slug, false,true)))
			{
				return false;
			}
			list($module) = $module;
			//smoke and mirrors
			if (isset($module->installer))
			{
				//call disable on installer			
				$dis_status = $module->installer->disable();
			}
			else
			{
				//call disable on installer			
				$dis_status = $module->disable();
			}

			if($dis_status)
			{
				$this->db->where('slug', $slug)->update($this->_table, array('enabled' => 0));
				$this->_module_enabled[$slug] = false;
			}		
				
			return $dis_status;
		}
		return false;
	}
	

	/**
	 * Install
	 *
	 * Installs a module
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function install($slug, $is_core = false, $insert = false)
	{
	
		//the third param if set to true, checks for installer files as well
		if ( ! $module = $this->_spawn_class($slug, $is_core,true))
		{
			return false;
		}

		list($class) = $module;

		// They've just finished uploading it so we need to make a record
		if ($insert)
		{
			// Get some info for the db
			$input = $class->info();

			// Now lets set some details ourselves
			$input['slug']			= $slug;
			$input['version']		= $class->version;
			$input['enabled']		= $is_core; // enable if core
			$input['installed']		= $is_core; // install if core
			$input['is_core']		= $is_core; // is core if core

			// It's a valid module let's make a record of it
			$this->add($input);
		}
		
		// set the site_ref and upload_path for third-party devs
		$class->site_ref 	= SITE_REF;
		$class->upload_path	= SITE_STORAGE_PATH.SITE_REF.'/';


		// Run the install method to get it into the database
		// smoke and mirrors
		if (!(isset($class->installer)) )
		{
			$class->installer = $class;
		}

		//
		// Now check if we need a required module installed first!
		//
		$d = $this->db->where('slug',$slug)->get('modules')->row();
		if($d->requires_module) {
			if(trim($d->requires_module) != '') {
				//now lets see if we have that module installed
				$required_mod = $this->db->where('slug',$d->requires_module)->get('modules')->row();
				if(!$required_mod->installed) {
					return false;
				} 
			}
		}
		//
		// end-
		//

		//smoke and mirrors
		if ($class->installer->install())
		{
			// TURN ME ON BABY!
			$this->db->where('slug', $slug)->update($this->_table, array('enabled' => 1, 'installed' => 1));
			
			// enable it
			$this->_module_exists[$slug] = true;
			$this->_module_enabled[$slug] = true;
			$this->_module_installed[$slug] = true;

			return true;
		}

		return false;
	}

	/**
	 * Uninstall
	 *
	 * Unnstalls a module
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function uninstall($slug, $is_core = false)
	{
		if ( ! $module = $this->_spawn_class($slug, $is_core,true))
		{		
			// the files are missing so let's clean the "modules" table
			return $this->delete($slug);
		}

		list($class) = $module;

		// set the site_ref and upload_path for third-party devs
		$class->site_ref 	= SITE_REF;
		$class->upload_path	= SITE_STORAGE_PATH.SITE_REF.'/';

		//smoke and mirrors
		if (!(isset($class->installer)) )
		{
			$class->installer = $class;
		}

		// Run the uninstall method to drop the module's tables
		if ( $class->installer->uninstall() == false)
		{
			return false;
		}

		if ($this->delete($slug))
		{
			// Get some info for the db
			$input = $class->info();

			// Now lets set some details ourselves
			$input['slug']      = $slug;
			$input['version']   = $class->version;
			$input['enabled']   = $is_core; // enable if core
			$input['installed'] = 0; //$is_core; // install if core
			$input['is_core']   = $is_core; // is core if core

			// We record it again here. If they really want to get rid of it they'll use Delete
			return $this->add($input);
		}
		return false;
	}

	/**
	 * Upgrade
	 *
	 * Upgrade a module
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function upgrade($slug)
	{
		// Get info on the new module
		if ( ! ($module = $this->_spawn_class($slug, true,true) or $module = $this->_spawn_class($slug, false,true)))
		{
			return false;
		}

		// Get info on the old module
		if ( ! $old_module = $this->get($slug))
		{
			return false;
		}

		list($class) = $module;

		// Get the old module version number
		$old_version = $old_module['version'];

		// set the site_ref and upload_path for third-party devs
		$class->site_ref 	= SITE_REF;
		$class->upload_path	= SITE_STORAGE_PATH.SITE_REF.'/';


		// Run the install method to get it into the database
		// smoke and mirrors
		if (!(isset($class->installer)) )
		{
			$class->installer = $class;
		}


		// Run the update method to get it into the database
		if ($class->installer->upgrade($old_version))
		{
			// Update version number
			$this->db->where('slug', $slug)->update($this->_table, array('version' => $class->version));
			
			return true;
		}

		// The upgrade failed
		return false;
	}

	public function import_unknown()
    {
    	$modules = [];

		$is_core = true;

		$known = $this->get_all(array(), true);
		$known_array = [];
		$known_mtime = [];

		// Loop through the known array and assign it to a single dimension because
		// in_array can not search a multi array.
		if (is_array($known) && count($known) > 0)
		{
			foreach ($known as $item)
			{
				array_unshift($known_array, $item['slug']);
				$known_mtime[$item['slug']] = $item;
			}
		}

		foreach (array(APPPATH, ADDONPATH, SHARED_ADDONPATH) as $directory)
    	{
			// some servers return false instead of an empty array
			if ( ! $directory or ! ($temp_modules = glob($directory.'modules/*', GLOB_ONLYDIR)))
			{
				continue;
			}

			foreach ($temp_modules as $path)
			{
				$slug = basename($path);

				// Yeah yeah we know
				if (in_array($slug, $known_array))
				{
					$details_file = $directory.'modules/'.$slug.'/Details.php';

					if (file_exists($details_file) &&
						filemtime($details_file) > $known_mtime[$slug]['updated_on'] &&
						$module = $this->_spawn_class($slug, $is_core))
					{
						list($class) = $module;

						// Get some basic info
						$input = $class->info();

						$this->update($slug, array(
							'name'        => serialize($input['name']),
							'description' => serialize($input['description']),
							'is_frontend' => ! empty($input['frontend']),
							'is_backend'  => ! empty($input['backend']),
							'clean_xss'    => ! empty($input['clean_xss']),
							'menu'        => ! empty($input['menu']) ? $input['menu'] : false,
							'icon'        => ! empty($input['icon']) ? $input['icon'] : 'fa fa-edit',
							'updated_on'  => now()
						));

						log_message('debug', sprintf('The information of the module "%s" has been updated', $slug));
					}

					continue;
				}

				// This doesn't have a valid Details.php file! :o
				if ( ! $module = $this->_spawn_class($slug, $is_core))
				{
					continue;
				}

				list ($class) = $module;

				// Get some basic info
				$input = $class->info();

				// Now lets set some details ourselves
				$input['slug']      = $slug;
				$input['version']   = $class->version;
				$input['enabled']   = $is_core; // enable if core
				$input['installed'] = 0; //$is_core; // install if core, do not auto register to install, it never installed anyway just referenced as installed
				$input['is_core']   = $is_core; // is core if core

				// Looks like it installed ok, add a record
				$this->add($input);
			}
			unset($temp_modules);

			// Going back around, 2nd time is addons
			$is_core = false;
		}

		return true;
	}


	/**
	 * Spawn Class
	 *
	 * Checks to see if a Details.php exists and returns a class
	 *
	 * @param	string	$slug	The folder name of the module
	 * @return	array
	 */
	private function _spawn_class( $slug, $is_core = false, $check_installer=false )
	{

		$path = $is_core ? APPPATH : ADDONPATH;

		// Before we can install anything we need to know some details about the module
		$details_file = $path.'modules/'.$slug.'/Details.php';
		

		// If it didn't exist as a core module or an addon then check addons_shared
		if ( ! is_file($details_file))
		{
			$details_file = SHARED_ADDONPATH.'modules/'.$slug.'/Details.php';
			$path = SHARED_ADDONPATH;

			//we have no known details file, no point looking for an installer
			if ( ! is_file($details_file))
			{
				return false;
			}
		}

		// now we know we have a details, which is required, 
		// but what about the optional installer?
		$installer_file = $path.'modules/'.$slug.'/Installer.php';

		//only do this if we need
		if ( is_file($installer_file) && $check_installer)
		{
			// Now we need to talk to it
			$details_class = $this->getClassObjectFromFile($details_file,'Module_',$slug);
			$installer_class = $this->getClassObjectFromFile($installer_file,'Installer_',$slug);
			$details_class->installer = $installer_class;
			$details_class->installer->set_info($details_class->info());

			return array($details_class, dirname($details_file));

		}		

		//if there is no installer.php file, we expect the details to have all the info and definitions for us
		$details_class = $this->getClassObjectFromFile($details_file,'Module_',$slug);


		//name of expected class
		$class = 'Module_'.ucfirst(strtolower($slug));

		// Now we need to talk to it
		if ( ! class_exists($class))
		{
			throw new Exception("Module $slug has an incorrect Details.php class. It should be called '$class'.");
		}

		return array($details_class, dirname($details_file));

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

	/**
	 * Help
	 *
	 * Retrieves help string from Details.php
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function help($slug)
	{
		foreach (array(0, 1) as $is_core)
    	{
			$languages = $this->config->item('supported_languages');
			$default = $languages[$this->config->item('default_language')]['folder'];

			//first try it as a core module
			if ($module = $this->_spawn_class($slug, $is_core))
			{
				list ($class, $location) = $module;

				// Check for a hep language file, if not show the default help text from the Details.php file
				if (file_exists($location.'/language/'.$default.'/help_lang.php'))
				{
					$this->lang->load($slug.'/help');

					if (lang('help_body'))
					{
						return lang('help_body');
					}
				}
				else
				{
					return $class->help();
				}
			}
		}

		return false;
	}

	/**
	 * Roles
	 *
	 * Retrieves roles for a specific module
	 *
	 * @param	string	$slug	The module slug
	 * @return	bool
	 */
	public function roles($slug)
	{
		foreach (array(0, 1) as $is_core)
    	{
			//first try it as a core module
			if ($module = $this->_spawn_class($slug, $is_core))
			{
				list($class) = $module;
				$info = $class->info();

				if ( ! empty($info['roles']))
				{
					$this->lang->load($slug.'/permission');
					return $info['roles'];
				}
			}
		}

		return [];
	}

	/**
	 * Help
	 *
	 * Retrieves version number from Details.php
	 *
	 * @param   string  $slug   The module slug
	 * @return  bool
	 */
	public function version($slug)
	{
		if ($module = $this->_spawn_class($slug, true) or $module = $this->_spawn_class($slug))
		{
			list($class) = $module;
			return $class->version;
		}

		return false;
	}
}