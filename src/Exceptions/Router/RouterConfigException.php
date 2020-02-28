<?php

namespace Framework\Exceptions\Router;

use Framework\Exceptions\RouterException;

class RouterConfigException extends RouterException
{
    public static function forRoutesConfigMissing(): self
    {
        return new self('Configuration for router is missing mandatory keys');
    }
}
