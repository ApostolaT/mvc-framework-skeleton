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

    private $session;

    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    // TODO: inject other services: session handling, mail sending, etc. into the actual controllers where needed
}
