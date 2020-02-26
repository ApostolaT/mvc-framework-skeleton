<?php

$baseDir = dirname(__DIR__);
require $baseDir.'/vendor/autoload.php';

use Framework\Application;
use Framework\Http\Request;
use Framework\Router\Router;
use Framework\Exceptions\RouteNotFoundException;

ini_set("display_errors", 1);

// setup auto-loading


// obtain the DI container
//$container = require $baseDir.'/config/services.php';

/// Router config
//        $routes = require $baseDir.'/config/routes.php';
//
//        $router = new Router($routes);
//        $request = new Request();
//        try {
//            $match = $router->route($request);
//            echo $match->getMethod()."<br>";
//            echo $match->getActionName()."<br>";
//            echo $match->getControllerName()."<br>";
//            print_r($match->getRequestAttributes());
//        } catch (RouteNotFoundException $e) {
//            echo "404 Route not found";
//        }

$request = new Request();

echo $request->getHeaders();


// create the application and handle the request

//$application = Application::create($container);
//$request = Request::createFromGlobals();
//$response = $application->handle($request);
//$response->send();
