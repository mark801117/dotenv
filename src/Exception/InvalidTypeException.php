<?php
namespace Cloud\Dotenv\Exception;
use Exception;
/**
 * Description of InvalidTypeException
 *
 * @author Cloud
 */
class InvalidTypeException extends Exception
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }
}
