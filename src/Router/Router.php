<?php

namespace Framework\Router;

use Framework\Contracts\RouterInterface;
use Framework\Exceptions\RouteNotFoundException;
use Framework\Http\Request;
use Framework\Regex\RegexConstructor;
use Framework\Routing\RouteMatch;

class Router implements RouterInterface
{
    const CONFIG_KEY_PATH = "path";
    private $routes = null;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function route(Request $request): RouteMatch
    {
        $uri = $request->getPath();
        $method = $request->getMethod();
        $regexConstructor = new RegexConstructor();
        $routes = $this->routes["routing"]["routes"];

        foreach ($routes as $configPaths) {
            if ($method !== $configPaths['method']) continue;

            $pattern = $regexConstructor->createRegex($configPaths);
            if (preg_match($pattern, $uri, $matches))
            {
                $filter = function($var) {return !is_numeric($var);};
                $matches = array_filter($matches, $filter, ARRAY_FILTER_USE_KEY);

                // TODO make controller's first letter Uppercase
                return new RouteMatch(
                    $request->getMethod(),
                    $this->routes["dispatcher"]["controller_namespace"]."\\"
                    .$configPaths["controller"]
                    .$this->routes["dispatcher"]["controller_suffix"],
                    $configPaths["action"],
                    $matches
                );
            }
        }

        // TODO make exceptions like Dan said, with custom in config 404 page with DI
        throw new RouteNotFoundException();
    }
}