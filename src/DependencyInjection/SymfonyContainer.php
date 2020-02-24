<?php
declare(strict_types=1);

namespace Framework\DependencyInjection;

use Framework\Contracts\ContainerInterface;

class SymfonyContainer implements ContainerInterface
{
    /**
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(\Symfony\Component\DependencyInjection\ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function set(string $id, ?object $service)
    {
        // TODO: call wrapped container
    }

    public function get($id)
    {
        // TODO: call wrapped container
    }

    public function has($id)
    {
        // TODO: call wrapped container
    }
}
