<?php

namespace Framework\Contracts;

use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Routing\RouteMatch;

interface DispatcherInterface
{
    /**
     * Obtains controller based on the RouteMatch and executes its logic/method passing the request.
     *
     * @param RouteMatch $routeMatch
     * @param Request    $request
     *
     * @return Response
     */
    public function dispatch(RouteMatch $routeMatch, Request $request): Response;
    /*
     * The dispatch method will obtain the controller and then call the action method on it passing the Request as param
     * and obtaining the Response as return
     *
     * Ex:
     * $response = $controllerObject->actionName($request);
     */


    // TODO: Hint: register controller as services in the DI and inject them in the dispatcher during DI config
}
