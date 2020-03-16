<?php

namespace Framework;

use Framework\Contracts\ContainerInterface;
use Framework\Contracts\DispatcherInterface;
use Framework\Contracts\RouterInterface;
use Framework\Exceptions\RouteNotFoundException;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\Stream;
use Framework\Routing\RouteMatch;

class Application
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $container->set(self::class, $this);
    }

    public function handle(Request $request): Response
    {
        try {
            $routeMatch = $this->getRouter()->route($request);
        } catch (RouteNotFoundException $e) {
            $response = new Response(Stream::createFromString(' '), []);
            $response = $response->withStatus(301);
            $response = $response->withHeader('Location', $this->container['domain'].'/error/404');

            return $response;
        }

        return $this->getDispatcher()->dispatch($routeMatch, $request);
    }

    private function getRouter(): RouterInterface
    {
        return $this->container->get(RouterInterface::class);
    }

    private function getDispatcher(): DispatcherInterface
    {
        return $this->container->get(DispatcherInterface::class);
    }
}
