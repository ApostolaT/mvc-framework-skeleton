<?php

namespace Framework\Dispatcher;

use Framework\Contracts\DispatcherInterface;
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
        $FQCN = $this->controllerName."\\".$routeMatch->getControllerName().$this->suffix;

        return $this->createResponse($FQCN, $routeMatch, $request);
    }

    public function addController(AbstractController $controller) {
        $this->controllers[get_class($controller)] = $controller;
    }

    private function createResponse(
        string $FQCN,
        RouteMatch $routeMatch,
        Request $request
    ): Response
    {
        if (key_exists($FQCN, $this->controllers)) {
            $action = $routeMatch->getActionName();
            $values = $routeMatch->getRequestAttributes();


            return $this->controllers[$FQCN]->$action($request, $values);
        }

        return null;
    }
}