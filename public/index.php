<?php

$baseDir = dirname(__DIR__);
require $baseDir.'/vendor/autoload.php';

use Framework\Application;
use Framework\Dispatcher\Dispatcher;
use Framework\Http\Request;
use Framework\Http\Stream;
use Framework\Render\Renderer;
use Framework\Router\Router;
use Framework\Exceptions\RouteNotFoundException;
use Framework\Http\Message;

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

// create the application and handle the request

//$application = Application::create($container);
//$request = Request::createFromGlobals();
//$response = $application->handle($request);
//$response->send();

$request = Request::createFromGlobals();
$dispatcher = new Dispatcher("Framework\Controller", "Controller");
$renderer = new Renderer("");
$routeMatch =  new \Framework\Routing\RouteMatch(
    "GET",
    "",
    "getUser",
    ["id"=>"4"]
);

$controller = new Framework\Controller\Controller($renderer);
$dispatcher->addController($controller);
$response = $dispatcher->dispatch($routeMatch, $request);
$response->send();


//$request = new Request($_SERVER["SERVER_PROTOCOL"], ["header1", "header2"], "salutsalut");
//$request = Request::createFromGlobals();
//var_dump($request);


