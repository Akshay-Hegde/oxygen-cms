<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Oxygen extends Theme
{
    public $name			= 'Oxygen';
    public $author			= 'Oxygen-CMS Dev Team';
    public $author_website	= 'http://oxygen-cms.com/';
    public $website			= 'http://oxygen-cms.com/';
    public $description		= '';
    public $version			= '1.0.0';


    /**
     * This function is fired ONLY when the 
     * theme is set by the admin themes module
     *
     */
    public function initialize()
    {
        $theme = [];
    
        $theme['streams'] = 
        [
            [
                'name'          => 'Cars',
                'slug'          => 'strm_cars',
                //'namespace'   => 'lists', //lists is default
                'fields'        => [],
            ],
            [
                'name'          => 'Boats',
                'slug'          => 'strm_boats',
                'namespace'     => 'lists', //lists is default
            ]           
        ];
        $theme['widget-areas']      = 'Side bar,Header bar';            
        $theme['navigation-groups'] = 'Header,Side bar,Footer';
        $theme['user-groups']       = 'Customer,Merchant User';     
        return $theme;
    }

	/**
	 * This function is fired when the page is loaded
	 */
	public function run() {

	}

}
/* End of file Theme.php */