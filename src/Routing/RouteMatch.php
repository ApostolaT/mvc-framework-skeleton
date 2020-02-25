<?php

namespace Framework\Routing;

class RouteMatch
{
    private $method = null;
    private $controller = null;
    private $action = null;
    private $reqAttributes = null;

    public function __construct(
        $method,
        $controller,
        $action,
        $reqAttributes)
    {
        $this->method = $method;
        $this->controller = $controller;
        $this->action = $action;
        $this->reqAttributes = $reqAttributes;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getControllerName(): string
    {
        return $this->controller;
    }


    public function getActionName(): string
    {
        return $this->action;
    }


    public function getRequestAttributes(): array
    {
        return $this->reqAttributes;
    }
}
