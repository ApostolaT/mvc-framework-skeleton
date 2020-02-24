<?php

namespace Framework\Routing;

class RouteMatch
{
    public function getMethod(): string
    {
        //TODO: return GET, POST, PUT, DELETE ...
    }

    public function getControllerName(): string
    {
        //TODO: return the controller name
    }


    public function getActionName(): string
    {
        //TODO: return the controller action
    }


    public function getRequestAttributes(): array
    {
        //TODO: return attributes extracted from PATH_INFO
    }
}
