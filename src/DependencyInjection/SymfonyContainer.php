<?php
declare(strict_types=1);

namespace Framework\DependencyInjection;

use Exception;
use Framework\Contracts\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as SContainerinterface;


//S for Symphony
class SymfonyContainer implements ContainerInterface
{
    /**
     * @var SContainerInterface
     */
    private $container;

    /**
     * @param SContainerInterface $container
     */
    public function __construct(SContainerinterface $container)
    {
        $this->container = $container;
    }

    public function set(string $id, ?object $service)
    {
        $this->container->set($id, $service);
    }

    public function get($id)
    {
        return $this->container->get($id);
    }

    public function has($id)
    {
        return $this->container->has($id);
    }
}
