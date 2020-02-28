<?php

$baseDir = dirname(__DIR__);
require $baseDir.'/vendor/autoload.php';

use Framework\Application;
use Framework\Http\Request;

ini_set("display_errors", 1);

$container = require $baseDir.'/config/services.php';

$application = new Application($container);
$request = Request::createFromGlobals();
$response = $application->handle($request);
$response->send();