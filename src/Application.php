<?php

namespace Framework;

use Exception;
use Framework\Contracts\DispatcherInterface;
use Framework\Contracts\RouterInterface;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Routing\RouteMatch;

class Application
{
    public function __construct(Framework\Contracts\ContainerInterface $container)
    {
        // TODO
    }

    public static function create(Framework\Contracts\ContainerInterface $container): self
    {
        // TODO:
        // implement the constructor and make sure that the statically created app is also added to the container
        // for later usage
        return new self($container);
    }

    public function handle(Request $request): Response
    {
        $routeMatch = $this->getRouter()->route($request);

        $response = $this->getDispatcher()->dispatch($routeMatch, $request);

        return $response;
    }

    private function getRouter(): RouterInterface
    {
        //TODO: obtain router from DI container and return

        // code below is just a placeholder
        return new class implements RouterInterface
        {
            public function route(Request $request): RouteMatch
            {
                throw new Exception('You need to provide a RouterInterface implementation');
            }

        };
    }

    private function getDispatcher(): DispatcherInterface
    {
        //TODO: obtain dispatcher from DI container and return

        // code below is just a placeholder
        return new class implements DispatcherInterface
        {
            public function dispatch(RouteMatch $routeMatch, Request $request): Response
            {
                throw new Exception('You need to provide a DispatcherInterface implementation');
            }
        };
    }
}
