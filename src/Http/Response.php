<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response extends Message implements ResponseInterface
{
    private $reasonPhrase = "";
    private $status = 404;
    private $header = [];

    public function __construct(
        Stream $body,
        array $headers = ["key"=>"value"],
        string $protocolVersion = "1.1",
        string $status = "200"
    )
    {
        parent::__construct($protocolVersion, $headers, $body);
    }

    public function send(): void
    {
        $this->sendHeaders();
        echo $this->getBody();
    }

    /**
     * @inheritDoc
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $response = clone $this;
        $response->status = $code;
        $response->reasonPhrase = $reasonPhrase;
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return $this->status;
    }

    private function sendHeaders()
    {
        foreach ($this->header as $key => $value) {
            header("$key: ".$value);
        }
    }
}
