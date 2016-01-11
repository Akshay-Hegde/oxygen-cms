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
class ViewObject
{
    public function __construct() 
    { 
    }  
    
	public function __get($var)
	{
		if (isset(get_instance()->$var))
		{
			return get_instance()->$var;
		}
	}  

    public function as_array()
    {
        return (array) $this;
    }
}