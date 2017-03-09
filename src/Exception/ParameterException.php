<?php

namespace Sway\Component\Parameter\Exception;

class ParameterException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }
    
    public static function parameterNotFoundException(string $parameterName) : ParameterException
    {
        $parameterException = new ParameterException (
                sprintf("Parameter '%s' not exists", $parameterName)
        );
        return $parameterException;
    }
    
    public static function contextArrayException(string $contextName) : ParameterException
    {
        $parameterException = new ParameterException (
                sprintf("Current context '%s' is not array", $contextName)
        );
        return $parameterException;
    }
    
    
}


?>
