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
            // if !method continue
            $pattern = $regexConstructor->createRegex($configPaths);

            if (
                preg_match($pattern, $uri, $matches)
                && $method === $configPaths['method'])
            {
                $filter = function($var) {return !is_numeric($var);};
                $matches = array_filter($matches, $filter, ARRAY_FILTER_USE_KEY);

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

        throw new RouteNotFoundException();
    }
}