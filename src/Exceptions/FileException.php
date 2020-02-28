<?php


namespace Framework\Exceptions;


use Exception;
use Throwable;

class FileException extends Exception
{
    private $name = "";

    public function __construct($message = "",  $name = "",  $code = 0, Throwable $previous = null)
    {
        $this->name = $name;
        parent::__construct($message, $code, $previous);
    }

    public function messageLog() {
        return sprintf($this->getMessage(), $this->name);
    }
}