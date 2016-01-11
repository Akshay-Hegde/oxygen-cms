<?php namespace Oxygen\Converters;

/**
 * @author Sal McDonald
 */
class StringConverter 
{

	private $_string;

    public function __construct($string = null) 
    {
		$this->_string = $string;
    }

    public function USUTF8Compatible()
    {
    	return $this->_string;
    }
    
}