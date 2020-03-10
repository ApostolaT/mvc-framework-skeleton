<?php

namespace Framework\Http;


class Response extends Message
{
    private $status = 200;

    public function __construct(
        Stream $body,
        array $headers,
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
    public function withStatus($code)
    {
        $response = clone $this;
        $response->status = $code;

        return $response;
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
        $this->header = $this->getHeaders();

        foreach ($this->header as $key => $value) {
            header("$key: ".$value);
        }
    }
}
