<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * OxygenCMS
 *
 * CodeIgniter Debug Helpers | Debug Helper
 * Outputs the given variable with formatting and location
 *
 * @author      OxygenCMS Dev Team 2015
 * @author      PyroCMS Dev Team 2008-2014
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @copyright   Copyright (c) 2016, OxygenCMS 
 *
 */
function dump()
{
	list($callee) = debug_backtrace();
	$arguments = $callee['args'];
	$total_arguments = count($arguments);

	echo '<fieldset style="background: #fefefe !important; border:2px red solid; padding:5px">';
	echo '<legend style="background:lightgrey; padding:5px;">'.$callee['file'].' @ line: '.$callee['line'].'</legend><pre>';

	$i = 0;
	foreach ($arguments as $argument)
	{
		echo '<br><strong>Debug #'.(++$i).' of '.$total_arguments.'</strong>: ';
		var_dump($argument);
	}

	echo '</pre>';
	echo '</fieldset>';
}