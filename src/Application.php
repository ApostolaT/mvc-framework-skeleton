<?php

namespace Framework;

use Framework\Contracts\ContainerInterface;
use Framework\Contracts\DispatcherInterface;
use Framework\Contracts\RouterInterface;
use Framework\Http\Request;
use Framework\Http\Response;

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
        $routeMatch = $this->getRouter()->route($request);

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
