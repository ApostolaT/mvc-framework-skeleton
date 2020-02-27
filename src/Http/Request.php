<?php

namespace Framework\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message implements RequestInterface
{
    private $cookie = null;
    private $requestTarget = null;
    private $method = null;
    private $uri = null;

    public function __construct(
        string $protocolVersion,
        array $headers,
        string $requestTarget,
        string $method,
        Stream $body,
        URI $uri,
        array $cookie)
    {
        $this->requestTarget = $requestTarget;
        $this->method = $method;

        $this->uri = $uri;
        $this->cookie = $cookie;

        parent::__construct($protocolVersion, $headers, $body);

    }

    public static function createFromGlobals(): self
    {
        $protocolVersion = explode("/", $_SERVER["SERVER_PROTOCOL"])[1];
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (explode("_", $key)[0] === "HTTP"){
                $headers[$key] = $value;
            }
        }
        $requestTarget = $_SERVER["HTTP_HOST"];
        $method = $_SERVER["REQUEST_METHOD"];

        $streamID = fopen("php://input", "r+");
        $stream = new Stream($streamID, fseek($streamID, 0, SEEK_END));

        $uri = URI::createFromGlobals();

        $cookie = $_COOKIE;

        return new self($protocolVersion, $headers, $requestTarget, $method, $stream, $uri, $cookie);
    }


    public function getParameter(string $name)
    {
        if (!isset($_GET)) {
            return "";
        }

        if (!array_key_exists($name, $_GET)) {
            return "";
        }

        return $_GET[$name];
    }

    public function getCookie(string $name)
    {
        if (!isset($_COOKIE)) {
            return "";
        }

        if (!array_key_exists($name, $_COOKIE)) {
            return "";
        }

        return $_COOKIE[$name];
    }

    //skip
    public function moveUploadedFile(string $path)
    {
        //TODO moveUploadedFile
    }

    public function getRequestTarget()
    {
        return $this->requestTarget;
    }

    /**
     * @inheritDoc
     */
    public function withRequestTarget($requestTarget)
    {
        $method = clone $this;
        $method->requestTarget = $requestTarget;

        return $method;
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @inheritDoc
     */
    public function withMethod($method)
    {
        $method = clone $this;
        $method->method = $method;

        return $method;
    }

    /**
     * @inheritDoc
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @inheritDoc
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $request = clone $this;
        $request->uri = $uri;

        return $request;
    }
}
