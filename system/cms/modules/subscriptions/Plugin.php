<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Widgets Plugin
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Widgets\Plugins
 */
class Plugin_Subscriptions extends Plugin
{

	public $version = '1.0.0';
	public $name = 
	[
		'en' => 'Subscriptions',
	];
	public $description = 
	[
		'en' => 'Display Subscriptions',
	];


	/**
	 * {{ subscriptions:subscribe list='events' email='' data-1='' auto-user='true' }}
	 */
	public function subscribe()
	{
		$auto_user     = $this->attribute('auto-user','false');		
		
		//do we have a user logged in ?
		if($auto_user AND $this->current_user) {

			$usr_email = $this->current_user->email;
				
		}

		//$module     = $this->attribute('module','page');
		//$link_text     = $this->attribute('link_text','Subscribe to this page');
		//return '<a href="{{url:site}}subscriptions/subscribe/module/'.$module.'">'.$link_text.'</a>';
	}



}

/* End of file Plugin.php */