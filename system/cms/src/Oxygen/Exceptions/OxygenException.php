<?php namespace Oxygen\Exceptions;

use Oxygen\Interfaces\IException;

/**
 * @author Sal McDonald
 */
abstract class OxygenException extends \Exception implements \Oxygen\Interfaces\IException
{
    protected $message = 'Unknown exception';     // Exception message
    private   $string;                            // Unknown
    protected $code    = 0;                       // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private   $trace;                             // Unknown
    private   $_payload;                          // Has the payload object being attatched

    public function __construct($message = null, $code = 0, $payload=null, Exception $previous = null) 
    {
        /*
        if (!$message) {
            throw new $this('Unknown '. get_class($this));
        }*/
        $this->message = ($message!=null) ? $message : $this->message . ' [Exception Class:' . get_class($this) . ' ]' ;

        $this->_payload = $payload;

        parent::__construct($message, $code, $previous);
    }
   
    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }


    /**
     * has the payload object being attached ?
     */
    public function hasPayload()
    {
        return ($this->_payload)?true:false;
    }  

    /**
     * return the payload
     */
    public function getPayload()
    {
        return $this->_payload;
    }  
}