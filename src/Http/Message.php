<?php


namespace Framework\Http;


use http\Exception\InvalidArgumentException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

abstract class Message implements MessageInterface
{
    private $protocolVersion = null;
    private $headers = null;
    private $body = null;

    public function __construct(string $protocolVersion, array $headers, StreamInterface $stream)
    {
        $this->protocolVersion = $protocolVersion;
        $this->headers = $headers;
        $this->body = $stream;
    }

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        $message = clone $this;
        $message->protocolVersion = $version;

        return $version;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        foreach ($this->headers as $key => $value) {
            if ($name === $key) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        if ($this->hasHeader($name)) {
            return $this->headers[$name];
        }

        return [];
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        if (!$this->hasHeader($name)) {
            return "";
        }

        $header = $this->getHeader($name);

        $string = "";
        foreach ($header as $values) {
            $string .= $values.",";
        }

        return substr($string, 0, strlen($string) -1 );
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        if (!$this->hasHeader($name)) {
            throw new InvalidArgumentException($name);
        }

        $message = clone $this;
        $message->headers = $this->getHeaders();
        $message->headers[$name] = $value;

        return $message;
    }

    /**
     * @inheritDoc
     */
    //TODO fix the problem
    public function withAddedHeader($name, $value)
    {
        $message = clone $this;
        $message->headers = $this->getHeaders();

        $message->headers = array_merge($message->getHeader($name), $value);

        return $message;
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        $message = clone $this;
        unset($message->headers[$name]);

        return $message;
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        $message = clone $this;
        $message->body = $body;

        return $message;
    }
}