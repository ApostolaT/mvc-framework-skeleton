<?php

$baseDir = dirname(__DIR__);
require $baseDir.'/vendor/autoload.php';

use Framework\Application;
use Framework\Http\Request;
use Framework\Router\Router;

// obtain the base directory for the web application a.k.a. document root


// setup auto-loading


// obtain the DI container
//$container = require $baseDir.'/config/services.php';


$routes = require $baseDir.'/config/routes.php';

$router = new Router($routes);
$request = new Request();
$match = $router->route($request);

echo $match->getMethod()."<br>";
echo $match->getActionName()."<br>";
echo $match->getControllerName()."<br>";
print_r($match->getRequestAttributes());




// create the application and handle the request

//$application = Application::create($container);
//$request = Request::createFromGlobals();
//$response = $application->handle($request);
//$response->send();
