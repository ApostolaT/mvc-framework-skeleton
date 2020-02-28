<?php

namespace Framework\Http;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message implements RequestInterface
{
    private $cookie;
    private $requestTarget;
    private $method;
    private $uri;
    private $get;
    private $post;

    /**
     * @var array
     */
    private $routeParameters;

    public function __construct(
        string $protocolVersion,
        array $headers,
        string $requestTarget,
        string $method,
        Stream $body,
        URI $uri,
        array $post = [],
        array $get = [],
        array $cookie = []
    )
    {
        $this->requestTarget = $requestTarget;
        $this->method = $method;
        $this->routeParameters = [];
        $this->uri = $uri;
        $this->cookie = $cookie;
        $this->get = $get;
        $this->post = $post;

        parent::__construct($protocolVersion, $headers, $body);

    }

    public static function createFromGlobals(): self
    {
        $protocolVersion = explode("/", $_SERVER["SERVER_PROTOCOL"])[1];
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (explode("_", $key)[0] === "HTTP") {
                $headers[$key] = $value;
            }
        }
        $requestTarget = $_SERVER["HTTP_HOST"];
        $method = $_SERVER["REQUEST_METHOD"];

        $bodyHandler = fopen("php://input", "r");
        $stream = new Stream($bodyHandler, (array_key_exists('HTTP_CONTENT_LENGTH', $_SERVER)) ? $_SERVER['HTTP_CONTENT_LENGTH'] : 0);

        $uri = URI::createFromGlobals();

        return new self($protocolVersion, $headers, $requestTarget, $method, $stream, $uri, $_GET, $_POST, $_COOKIE);
    }

    public function getParameter(string $name)
    {
        if (!isset($this->get[$name]) && !isset($this->post[$name])) {
            return null;
        }

        return (isset($this->get[$name])) ? $this->get[$name] : $this->post[$name];
    }

    public function getCookie(string $name)
    {
        if (!isset($this->cookie)) {
            return "";
        }

        if (!array_key_exists($name, $this->cookie)) {
            return "";
        }

        return $this->cookie[$name];
    }

    public function moveUploadedFile(string $name, string $path)
    {
        if (!isset($_FILES[$name])) {
            throw new FileException("File %s does not exist", $name);
        }
        if ($_FILES[$name]["error"] == UPLOAD_ERR_OK) {
            throw new FileException("Error while uploading %s", $name);
        }

        move_uploaded_file($_FILES[$name]["tmp_name"], $path);
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

    public function setRouteParameters(array $routeParams): void
    {
        $this->routeParameters = $routeParams;
    }

    public function hasRouteParameter(string $name): bool
    {
        return array_key_exists($name, $this->routeParameters);
    }

    /**
     * @return mixed
     */
    public function getRouteParameter(string $name)
    {
        if (!$this->hasRouteParameter($name)) {
            throw new \InvalidArgumentException(sprintf("Route parametre with name %s not found"), $name);
        }

        return $this->routeParameters[$name];
    }

    public function getRequestParameters()
    {
        return $this->routeParameters;
    }
}
