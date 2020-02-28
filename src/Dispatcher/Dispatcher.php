<?php

namespace Framework\Dispatcher;

use Framework\Contracts\DispatcherInterface;
use Framework\Exceptions\Dispatcher\ControllerNotFoundException;
use Framework\Routing\RouteMatch;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Controller\AbstractController;

class Dispatcher implements DispatcherInterface
{
    private $controllerName = "";
    private $suffix = "";
    private $controllers = [];

    public function __construct(string $controllerName, string $suffix)
    {
        $this->controllerName = $controllerName;
        $this->suffix = $suffix;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(RouteMatch $routeMatch, Request $request): Response
    {
        $controllerClassName = $this->controllerName."\\".$routeMatch->getControllerName().$this->suffix;

        return $this->createResponse($controllerClassName, $routeMatch, $request);
    }

    /**
     * This gets used from DI configuration
     * @param AbstractController $controller
     */
    public function addController(AbstractController $controller) {
        $this->controllers[get_class($controller)] = $controller;
    }

    /**
     * @throws ControllerNotFoundException
     */
    private function createResponse(
        string $controllerClassName,
        RouteMatch $routeMatch,
        Request $request
    ): Response
    {
        if (key_exists($controllerClassName, $this->controllers)) {
            $action = $routeMatch->getActionName();

            return $this->controllers[$controllerClassName]->$action($request);
        }

        throw ControllerNotFoundException::forControllerNotFound($controllerClassName);
    }
}