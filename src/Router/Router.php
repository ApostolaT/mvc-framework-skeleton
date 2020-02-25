<?php

namespace Framework\Router;

use Framework\Contracts\RouterInterface;
use Framework\Exceptions\BadRequestException;
use Framework\Http\Request;
use Framework\Routing\RouteMatch;

class Router implements RouterInterface
{
    private $routes = null;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function route(Request $request): RouteMatch
    {
        //if ( $request->getMethod() ) throw new BadRequestException();
        $uri = $request->getPath();

        foreach ($this->routes as $operation) {
            $pattern =
                "/".
                preg_replace(
                    "/\//",
                    "\/",
                    $operation["uri"])
                ."/";

            if (preg_match($pattern, $uri) && $request->getMethod() === $operation['method']) {

                $matches = null;
                preg_match($pattern, $uri, $matches);

                $reqAttributes = array();
                foreach ($matches as $key => $value) {
                    if (!is_numeric($key)) {//         sau o functie array_filter
                        $reqAttributes[$key] = $value;
                    }
                }

                return new RouteMatch(
                    $request->getMethod(),
                    $operation["controller"],
                    $operation["action"],
                    $reqAttributes
                );
            }
        }

        return null;
    }
}