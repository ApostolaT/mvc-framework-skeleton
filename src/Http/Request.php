<?php

namespace Framework\Http;

class Request implements Psr\Http\Message\RequestInterface
{
    public static function createFromGlobals(): self
    {
        // TODO:
        // look in $_GET, $_POST, $_SERVER, $_FILES, $_COOKIES and extract data into this objects properties for
        // easy access
        return new self();
    }

    public function getParameter(string $name)
    {
        //TODO
    }

    public function getCookie(string $name)
    {
        //TODO
    }

    public function moveUploadedFile(string $path)
    {
        //TODO
    }

    // TODO: implement methods declared by RequestInterface
}
