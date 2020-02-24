<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;

$container = new ContainerBuilder();
$container->register('Framework\Contracts\RouterInterface', 'Framework\Routing\Router');


// .........


return new \Framework\DependencyInjection\SymfonyContainer($container);