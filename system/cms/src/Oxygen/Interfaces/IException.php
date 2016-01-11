<?php namespace Oxygen\Interfaces;

/**
 * http://php.net/manual/en/language.exceptions.php
 */
interface IException
{
    /* Protected methods inherited from Exception class */
    public function getMessage();                 // Exception message
    public function getCode();                    // User-defined Exception code
    public function getFile();                    // Source filename
    public function getLine();                    // Source line
    public function getTrace();                   // An array of the backtrace()
    public function getTraceAsString();           // Formated string of trace

    public function hasPayload();                 // Get if the payload exist
    public function getPayload();                 // Get the payload object


   
    /* Overrideable methods inherited from Exception class */
    public function __toString();                 // formated string for display


    public function __construct($message = null, $code = 0, $payload=null, \Exception $previous = null);
}