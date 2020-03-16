<?php

namespace Framework\Router;

use Framework\Contracts\RouterInterface;
use Framework\Exceptions\RouteNotFoundException;
use Framework\Exceptions\Router\RouterConfigException;
use Framework\Http\Request;
use Framework\Regex\RegexBuilder;
use Framework\Routing\RouteMatch;

class Router implements RouterInterface
{
    public const CONFIG_KEY_PATH = "path";
    public const CONFIG_KEY_CONTROLLER = "controller";
    public const CONFIG_KEY_ACTION = "action";
    public const CONFIG_KEY_METHOD = "method";
    public const CONFIG_KEY_ATTRIBUTES = "attributes";

    /**
     * @var array
     */
    private $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @throws RouteNotFoundException
     * @throws RouterConfigException
     */
    public function route(Request $request): RouteMatch
    {
        $uri = $request->getUri()->getPath();
        $method = $request->getMethod();
        $regexBuilder = new RegexBuilder();
        $routes = $this->getRoutes();

        foreach ($routes as $configPaths) {
            if ($method !== $configPaths['method']) continue;

            $pattern = $regexBuilder->createRegex($configPaths);
            if (preg_match($pattern, $uri, $routeParams)) {
                $filter = function ($var) {
                    return !is_numeric($var);
                };
                $routeParams = array_filter($routeParams, $filter, ARRAY_FILTER_USE_KEY);
                $request->setRouteParameters($routeParams);

                return $this->createRouteMatch($request, $configPaths, $routeParams);
            }
        }

        // TODO make exceptions like Dan said, with custom in config 404 page with DI
        throw new RouteNotFoundException();
    }

    private function createRouteMatch(Request $request, array $configPaths, array $matches): RouteMatch
    {
        return new RouteMatch(
            $request->getMethod(),
            ucfirst($configPaths["controller"]),
            $configPaths["action"],
            $matches
        );
    }

    /**
     * @throws RouterConfigException
     */
    public function getRoutes(): array
    {
        if (!isset($this->routes["routing"]["routes"])) {
            throw RouterConfigException::forRoutesConfigMissing();
        }
        return $this->routes["routing"]["routes"];
    }
}

