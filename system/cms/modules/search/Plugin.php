<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Search Plugin
 *
 * Use the search plugin to display search forms and content
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Search\Plugins
 */
class Plugin_Search extends Plugin
{
	public $version = '1.0.0';

	public $name = 
	[
		'en' => 'Search',
	];

	public $description = 
	[
		'en' => 'Create a search form and display search results.',
	];

	/**
	 * {{search:form class=''}}
	 */
	public function form() {

		//$class = $this->attribute('class','');

		return form_open(site_url('search/public')).PHP_EOL
			 . $this->content().PHP_EOL
			 . form_close();

	}

}