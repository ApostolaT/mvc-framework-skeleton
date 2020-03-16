<?php
declare(strict_types=1);

namespace Framework\Controller;

use Framework\Contracts\RendererInterface;
use Framework\Session\Session;

/**
 * Base abstract class for application controllers.
 * All application controllers must extend this class.
 */
abstract class AbstractController
{
    /**
     * @var RendererInterface
     */
    protected $renderer;


    protected $session;

    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    private function getRedirectPage(string $path): Response
    {
        $response = new Response(Stream::createFromString(' '), []);
        $response = $response->withStatus(301);
        $response = $response->withHeader('Location', $path);

        return $response;
    }
}
