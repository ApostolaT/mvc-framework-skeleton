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
        $uri = $request->getUri()->getPath();
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

                return $this->createRouteMatch(
                    $request->getMethod(),
                    ucwords($configPaths["controller"]),
                    $configPaths["action"],
                    $matches
                );
            }
        }

        // TODO make exceptions like Dan said, with custom in config 404 page with DI
        throw new RouteNotFoundException();
    }

    private function createRouteMatch(
        string $method,
        string $controller,
        string $action,
        array $reqArray
    )
    {
        return new RouteMatch(
            $method,
            $controller,
            $action,
            $reqArray
        );
    }
}

