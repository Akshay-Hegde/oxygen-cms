<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 */
/**
 * An error function that will display the error page wih more information based on the environment you are running.
 * Staging and production show the least amount of errors, it will write a log file and display 404. Dev will output the error and extra info on screen
 */
function common_show_error($output,$title='An Error Occured')
{
	switch(ENVIRONMENT)
	{
		case OXYGEN_PRODUCTION:
		case OXYGEN_STAGING:
			break;				
		case OXYGEN_DEVELOPMENT:
			ob_start();
			var_dump($output);
			$n_output = ob_get_clean();
			show_error($title.$n_output);  
			break;
	}
}