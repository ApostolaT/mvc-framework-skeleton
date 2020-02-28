<?php

namespace Framework\Exceptions\Dispatcher;

use Exception;

class ControllerNotFoundException extends Exception
{

    public static function forControllerNotFound(string $controllerClassName)
    {
        return new self(sprintf("Controller %s not found in Dispatcher", $controllerClassName));
    }
}