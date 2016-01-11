<?php namespace Oxygen\Exceptions;

use Oxygen\Interfaces\IException;

/**
 * @author Sal McDonald
 */
class FlowFetchException extends \Oxygen\Exceptions\OxygenException
{

    public function __construct($message = null, $code = 0, $payload=null, Exception $previous = null) 
    {

        parent::__construct($message, $code, $previous);
    }
   
    //public function __toString()
 
}