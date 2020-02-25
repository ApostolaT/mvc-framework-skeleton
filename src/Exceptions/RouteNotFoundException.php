<?php


namespace Framework\Exceptions;


use Exception;
use Throwable;

class RouteNotFoundException extends Exception
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}